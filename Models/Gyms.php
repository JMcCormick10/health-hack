<?php
    class Gyms
    {
        private $db;

        public function setDb($db) 
        {
            $this->db = $db;
        }

        public function getGymsList()
        {
            $query = "select * from GYMS where user_id = :userID";
            $statement = $this->db->prepare($query);
            $statement->bindValue(':userID', $_SESSION['user']);
            $statement->execute();
            $gyms = $statement->fetchAll();
            $statement->closeCursor();
            return $gyms;
        }

        public function displayGymList()
        {
            $output = "<div class='row fav-gyms'>";
            $gyms = $this->getGymsList();
            $i = 0;

            foreach($gyms as $gym) 
            {
                $output .= "<div class='col-sm-12 gym-item'>";

                $output .= "<div class='row'>";

                if ($gym['defaultGym'] == 1) {
                    $output .= "<div class='col-sm-1'>
                                    <input type='radio' name='gymtodef' value='{$gym["marker_id"]}' checked>
                                </div>";
                } else {
                    $output .= "<div class='col-sm-1'>
                                    <input type='radio' name='gymtodef' value='{$gym["marker_id"]}'>
                                </div>";
                }

                $output .= "<div class='col-sm-2'>
                                <img src='../opt-imgs/login-photo.png' alt='gym logo' />
                            </div>";

                $output .= "<div class='col-sm-6'>";
                $output .= "<h2>".$gym['name']."</h2>";
                $output .= "<span><strong>Address:</strong> ".$gym['address']."</span>";
                $output .= "</div>";

                $output .= "<div class='col-sm-3'><form method='post'>
                                <input type='hidden' name='gym-num' value='{$gym["marker_id"]}'>
                                <input type='submit' class='btn btn-warning' name='deleteGym' value='Remove Gym'>
                            </form></div>";

                $output .= "</div>";

                $output .= "</div>";
                $i++;
            }
            if ($i != 0)
                $output .= "<div><input id='gymToChoose' type='button' class='btn btn-success' value='Make a Default'></div>";
            $output .= "</div>";
            return $output;
        }

        public function deleteGymFromList($gymId)
        {
            try {
                $query = "delete from GYMS where marker_id = :gymID";

                $statement = $this->db->prepare($query);
                $statement->bindValue(':gymID', $gymId);
                $statement->execute();
                $statement->closeCursor();
            } catch (Exception $e) {
                return $e->getMessage();
            }
            return true;
        }

        public function updateDefaultGym($gymId) 
        {
            try {
                $query = "update GYMS
                          SET defaultGym = 0
                          where user_id = :userID";
                $statement = $this->db->prepare($query);
                $statement->bindValue(':userID', $_SESSION['user']);
                $statement->execute();
                $statement->closeCursor();

                $query2 = "update GYMS
                        SET defaultGym = 1
                        WHERE marker_id = :gymID and user_id = :userID";
                $statement2 = $this->db->prepare($query2);
                $statement2->bindValue(':gymID', $gymId);
                $statement2->bindValue(':userID', $_SESSION['user']);
                $statement2->execute();
                $statement2->closeCursor();
            } catch (Exception $e) {
                return $e->getMessage();
            }
            return true;
        }

        public function addGymToFav($gymInfo)
        {
            try
            {
                $query = "insert into GYMS(marker_id, user_id, name, address, lat, lng) 
                        values(:markerID, :userID, :gymName, :gymAddress, :gymLat, :gymLng)";
                $statement = $this->db->prepare($query);
                $statement->bindValue(':markerID', $gymInfo->getGymId());
                $statement->bindValue(':userID', $_SESSION['user']);
                $statement->bindValue(':gymName', $gymInfo->getGymName());
                $statement->bindValue(':gymAddress', $gymInfo->getGymAddress());
                $statement->bindValue(':gymLat', $gymInfo->getGymLat());
                $statement->bindValue(':gymLng', $gymInfo->getGymLng());
                $statement->execute();
            } catch(Exception $e) {
                return $e->getMessage();
            }
            $statement->closeCursor();
            return true;
        }

        public function getGymCountPerUser($userId)
        {
            try {
                $query = "select count(*) as gymCount from GYMS where user_id = :userID";
                $statement = $this->db->prepare($query);
                $statement->bindValue(':userID', $_SESSION['user']);
                $statement->execute();
                $count = $statement->fetch();
            } catch(Exception $e) {
                return $e->getMessage();
            }
            $statement->closeCursor();
            return $count['gymCount'];
        }
    }
?>