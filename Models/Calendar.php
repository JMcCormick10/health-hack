<?php
class Calendar {
    public $month;
    public $year;
    public $day;
    private $headings = array('Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday');
    private $headingsm = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    private $db;
    private $user;

    public function setDb($db) {
        $this->db = $db;
    }

    function __construct($month, $year, $userId) {
        $this->month = $month;
        $this->year = $year;
        $this->day = date("d");
        $this->user = $userId;
    }

    public function getDefaultGym()
    {
        $query = "select marker_id, address from GYMS where defaultGym = 1 and user_id = :userID";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userID', $_SESSION['user']);
        $statement->execute();
        $arr = $statement->fetch();

        return isset($arr['marker_id']) ? $arr['marker_id'] : false;
    }

    public function getDefaultGymTime()
    {
        $place_id = $this->getDefaultGym();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/place/details/json?placeid=".$place_id."&key=AIzaSyB-eAHJBHdVL8yYg7eeHsY5rg8f1Q1qZ4Q");
        $result = json_decode(curl_exec($ch), true);

        return $result;
    }

    public function getRoutinesByDay($day) {
        $workouts = array($day."_strength", $day."_cardio");
        $query = "select routine_id, name, $workouts[0], $workouts[1] from ROUTINES
                  where ($workouts[0] IS NOT NULL OR $workouts[1] IS NOT NULL)
                        AND user_id = :userID AND active = 'Yes'";
        $statement = $this->db->prepare($query);
        $statement->bindValue(':userID', $this->user);
        $statement->execute();
        $routines = $statement->fetchAll();
        return $routines;
    }

    public function getWorkoutById($type, $id)
    {
        $workout_name = "";
        if ($type == "cardio") {
            $query = "select name from CARDIO_WORKOUTS where cardio_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();
            $workout = $statement->fetch();
            $workout_name = $workout['name'];
        } else {
            $query = "select strength_workout_name from STRENGTH_WORKOUTS where strength_id = :id";
            $statement = $this->db->prepare($query);
            $statement->bindValue(":id", $id);
            $statement->execute();
            $workout = $statement->fetch();
            $workout_name = $workout['strength_workout_name'];
        }
        return $workout_name;
    }

    public function createCalendarEvent($day) {
        $output = "";
        $type = "";
        $workouts = array($day."_strength", $day."_cardio");

        $routines = $this->getRoutinesByDay($day);
        foreach($routines as $routine)
        {
            $output .= "<div class='routine'><div><strong>Routine: ".$routine['name']."</strong></div>";
            for ($i = 0; $i < count($workouts); ++$i)
            {
                $type = ($i == 0) ? "strength" : "cardio";
                if (isset($routine[$workouts[$i]])) 
                {
                    if ($type === "strength")
                        $output .= "<div><span><a href='/health-hack/Strength/log-strength.php'>".$this->getWorkoutById($type, $routine[$workouts[$i]])."</a></span></div>";
                    else
                        $output .= "<div><span><a href='/health-hack/CardioFeature/log-cardio.php'>".$this->getWorkoutById($type, $routine[$workouts[$i]])."</a></span></div>";
                }
            }
            $output .= "</div>";
        }
        return $output;
    }

    public function drawMobile()
    {
        $curDay = date('d', strtotime($this->year.'-'.$this->month.'-'.$this->day));
        $curMonday = date('d', strtotime('Monday this week', strtotime($this->year.'-'.$this->month.'-'.$this->day)));
        $dayCounter = $curMonday;
        
        $calendar = "<div class='calendar'>";

        foreach($this->headingsm as $heading) :
            if ($dayCounter == $curDay) {
                $calendar .= "<div class='day-of-week current-day'>";
            } else {
                $calendar .= "<div class='day-of-week'>";
            }
            $calendar .= "<div><span>".$dayCounter."</span></div>";
            $calendar .= "<div><strong>".$heading."</strong></div>";

            $calendar .= '<div class="routines">';
            switch (date('w', mktime(0, 0, 0, $this->month, $dayCounter, $this->year))) 
            {
                case 0 :
                    $calendar .= $this->createCalendarEvent('sunday');
                    break;
                case 1:
                    $calendar .= $this->createCalendarEvent('monday');
                    break;
                case 2:
                    $calendar .= $this->createCalendarEvent('tuesday');
                    break;
                case 3:
                    $calendar .= $this->createCalendarEvent('wednesday');
                    break;
                case 4:
                    $calendar .= $this->createCalendarEvent('thursday');
                    break;
                case 5:
                    $calendar .= $this->createCalendarEvent('friday');
                    break;
                case 6:
                    $calendar .= $this->createCalendarEvent('saturday');
                    break;
                default :
                    break;
            }
            $calendar .= '</div>';

            $calendar .= "</div>";
            ++$dayCounter;
        endforeach;

        $dayCounter = $curMonday;

        $calendar .= "</div>";

        return $calendar;
    }
}
?>