<?php
session_start();
require_once '../redirect.php';

$UserID = $_SESSION['user'];  //get it from session
class Track
{
	public function getAddress($latitude,$longitude)
	{
		if(!empty($latitude) && !empty($longitude)){
			//Send request and receive json data by address
			$geocodeFromLatLong = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?latlng='.trim($latitude).','.trim($longitude).'&sensor=false'); 
		   $output = json_decode($geocodeFromLatLong);
			$status = $output->status;
			//Get address from json data
			$address = ($status=="OK")?$output->results[1]->formatted_address:'';
			//Return address of the given latitude and longitude
			if(!empty($address)){
				return $address;
			}else{
				return false;
			}
		}else{
			return false;   
		}
	}
    public function getDistance($addressFrom, $addressTo, $unit)
	{
		//Change address format
		$formattedAddrFrom = str_replace(' ','+',$addressFrom);
		$formattedAddrTo = str_replace(' ','+',$addressTo);
		
		//Send request and receive json data
		$geocodeFrom = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrFrom.'&sensor=false');
		$outputFrom = json_decode($geocodeFrom);
		$geocodeTo = file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$formattedAddrTo.'&sensor=false');
		$outputTo = json_decode($geocodeTo);
		
		//Get latitude and longitude from geo data
		$latitudeFrom = $outputFrom->results[0]->geometry->location->lat;
		$longitudeFrom = $outputFrom->results[0]->geometry->location->lng;
		$latitudeTo = $outputTo->results[0]->geometry->location->lat;
		$longitudeTo = $outputTo->results[0]->geometry->location->lng;
		
		//Calculate distance from latitude and longitude
	   // $theta = $longitudeFrom - $longitudeTo;
	   // $dist = sin(deg2rad($latitudeFrom)) * sin(deg2rad($latitudeTo)) +  cos(deg2rad($latitudeFrom)) * cos(deg2rad($latitudeTo)) * cos(deg2rad($theta));
		$dist=2;
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		
		$unit = strtoupper($unit);
		if ($unit == "K") {
			return ($miles * 1.609344).' km';
		} else if ($unit == "N") {
			return ($miles * 0.8684).' nm';
		} else {
			return $miles.' mi';
		}
		echo($dist);
	}
	

}

$TrackObj = new Track();
$Mode=$_GET['Mode'];
$FromAddress=$TrackObj->getAddress($_GET['FromLatitude'],$_GET['FromLongitude']);
$ToAddress=$TrackObj->getAddress($_GET['ToLatitude'],$_GET['ToLongitude']);
$Distance=$TrackObj->getDistance($FromAddress,$ToAddress,'m');
if($Mode==1)
{
	
    echo($Distance);  
	exit;

}
else if($Mode==2)
{
	
	$StartTime=$_GET['StartTime'];
	$EndTime=$_GET['EndTime'];
	
	//save into database
	require_once '../Models/Tracking.php';
    $TrackingObj = new Tracking();
	$StartPoint = "POINT(".$_GET['FromLatitude']. " " . $_GET['FromLongitude'].")";
	$EndPoint = "POINT(".$_GET['ToLatitude']. " " . $_GET['ToLongitude'].")";

    $TrackingObj->AddTracking($UserID,$StartPoint,$EndPoint,$StartTime,$EndTime);
}
      
?>