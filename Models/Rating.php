<?php

/*Created By Rahul Malik*/

require_once 'Database.php';

class Rating
{
    private $Connection;
	
    function __construct() {		
		$db = new Database();
        $this->Connection = $db->getDbFromAWS();		
	}	
    public function AddRating($UserID,$RatingNum,$ModuleID,$Desc)
	{

        // Insert New record into db
        $insert = "insert into RATINGS(user_id, rating_num,module_id,description) values (:UserID,:RatingNum,:ModuleID,:Desc)";
        //prepare query
        $RatingRow = $this->Connection->prepare($insert);
        //bind values
        $RatingRow->bindValue(":UserID", $UserID);
        $RatingRow->bindValue(":RatingNum",$RatingNum);
        $RatingRow->bindValue(":ModuleID",$ModuleID);
        $RatingRow->bindValue(":Desc",$Desc);
		//$RatingRow=
        return $RatingRow->execute();
    }


    public function GetAvgRating($ModuleID)
	{
		
        $select = "select avg(rating_num) as avg_num from RATINGS where module_id = :ModuleID";
        //prepare query
        $AvgRating = $this->Connection->prepare($select);
        //bind values
        $AvgRating->bindValue(":ModuleID", $ModuleID);	
     
        $AvgRating->execute();
		
        $Result = $AvgRating->fetch();
		
        return round($Result['avg_num']);
    }
	public function GetTopRating($ModuleID)
	{
		$avgRat=0;
        $select = "select * from RATINGS where module_id = :ModuleID order by rating_num desc limit 5";
        //prepare query
        $AvgRating = $this->Connection->prepare($select);
        //bind values
        $AvgRating->bindValue(":ModuleID", $ModuleID);	
     
        $AvgRating->execute();
		
        $Result = $AvgRating->fetchAll();

		
        return $Result;
    }
}