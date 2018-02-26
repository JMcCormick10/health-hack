<?php

/*Created By Rahul Malik*/

require_once 'Database.php';

class Tracking
{
    private $Connection;
	
    function __construct() {		
		$db = new Database();
        $this->Connection = $db->getDbFromAWS();		
	}	
    public function AddTracking($UserID,$StartPoint,$EndPoint,$StartTime,$EndTime)
	{
			
	
        // Insert New record into db
        $insert = "insert into TRACK_DISTANCE(user_id,start_point,end_point,start_time,end_time) values (:UserID,GeomFromText(:StartPoint),GeomFromText(:EndPoint),:StartTime,:EndTime)";
 		//prepare query
        $RatingRow = $this->Connection->prepare($insert);
        //bind values
        $RatingRow->bindValue(":UserID", $UserID);
        $RatingRow->bindValue(":StartPoint",($StartPoint));
        $RatingRow->bindValue(":EndPoint",($EndPoint));
        $RatingRow->bindValue(":StartTime",$StartTime);
		$RatingRow->bindValue(":EndTime",$EndTime);
		//$RatingRow=
        return $RatingRow->execute();
    }


  	public function GetTracks($UserID)
	{
		$avgRat=0;
        $select = "select * from TRACK_DISTANCE where user_id = :UserID limit 5";
        //prepare query
        $AvgRating = $this->Connection->prepare($select);
        //bind values
        $AvgRating->bindValue(":UserID", $UserID);	
     
        $AvgRating->execute();
		
        $Result = $AvgRating->fetchAll();

		
        return $Result;
    }
}