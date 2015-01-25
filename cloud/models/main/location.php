<?php

//print_r(getCityState());
// from lon lat determine city
//print_r(getLatLon("new york", "ny"));

function getCityState($lat, $lon){
	
	if(!isset($lon)){
		$lon= -73.9526528;
		$lat=40.7496964;
	}
	$theResponse = dbMassData("SELECT *, SQRT(POW(69.1 * (latitude - $lat ), 2) + POW(69.1 * ($lon- longitude) * COS(latitude / 57.3), 2)) AS distance FROM zip_codes HAVING distance < 20 ORDER BY distance LIMIT 3;");
	
	return(json_decode('{"city":"'.$theResponse[0]['city'].'","state":"'.$theResponse[0]['state'].'","zip":"'.$theResponse[0]['zip'].'"}', true));

}

// from lat lon, determine close lat, lon, or from citysatate or zip, get the lat and lon
function  getLatLon($city, $state, $zip, $lat, $lon){
	

	if(isset($lat) && isset($lon)){
		if(!is_float($lon)){
			$lon= -73.9526528;
			$lat=40.7496964;
		}
		return getPhantomLocs($lat, $lon, 1);
	}
	//print_r("near". $nearestPpl);
	//echo('{"lon":"'.$lon1.'", "lat": "'.$lat1.'"}');
	//echo("UPDATE zip_codes SET localSearched = 'true' WHERE (latitude = $lat1 AND longitude = $lon1)");
	//source1Cat2
		// query for city
	

	if(!isset($zip)){

		// query for city
		if(!isset($state)){
			$nearestPlaces  = dbMassData("SELECT * FROM zip_codes WHERE city LIKE '%$city%' ");
			return(json_decode('{"lat":'.$nearestPlaces[0]['latitude'].',"lon":'.$nearestPlaces[0]['longitude'].'}', true));
	
		}
		else{
			
			$nearestPlaces  = dbMassData("SELECT * FROM zip_codes WHERE city LIKE '%$city%' AND state LIKE '%$state%' ");
			return(json_decode('{"lat":'.$nearestPlaces[0]['latitude'].',"lon":'.$nearestPlaces[0]['longitude'].'}', true));
	
		
		}
		
	}

	else{
		$nearestPlaces  = dbMassData("SELECT * FROM zip_codes WHERE zip ='$zip'");
		
		// zip not found, use default lonlat and proceed
		if($nearestPlaces == null){

			$lon= -73.9526528;
			$lat=40.7496964;
		
		return getPhantomLocs($lat, $lon, 1);
		}
		else{

			return(json_decode('{"lat":'.$nearestPlaces[0]['latitude'].',"lon":'.$nearestPlaces[0]['longitude'].'}', true));
		
		}
		
	}


	

}


//for all, except vibation's weather
function findRecords($tableName, $matchingArr, $likeBool=false, $responseLimit,  $lonLatNamesArr, $withinDistanceMiles){

	//returns all records from DB matching the matchingArr key value pairs, and within the distance specified

	//just look up and return

	if(!isset($tableName)){
		return false;
	}
	if(!is_array($matchingArr)){
		$matchingArr=array("1"=>"1", "operator1"=>"=");
		$likeBool=false;
	}

	if(!is_bool($likeBool)){


		//user forgot to include likeBool... and put the 
		return false;
	}

	if(!isset($responseLimit)){
		$responseLimit= 30;
	}
	if(!isset($withinDistance)){
		$withinDistance=25;
	}


	$whereClause = "";
	$matchingReset==0;
	foreach($matchingArr as $k=>$v){

		//first record... dont include AND in claude
		if($matchingReset=0){
			$matchingReset=1;
			if($likeBool==false){
				if(isset($matchingArr['operator1'])){
					$whereClause .= $k." ".$matchingArr['operator1']." ".$v." ";
				}
				else{
					$matchingArr['operator1'] = "=";
					$whereClause .= $k." ".$matchingArr['operator1']." '".$v."' ";
				}
				
			}
			else{
				
				$whereClause .= $k." LIKE '%".$v."%' ";
			}
			
		}

		//not first record, include "AND "
		else{
			if($likeBool==false){
			
				$whereClause .= "AND " .$k." = '".$v."' ";
			}
			else{
				
				$whereClause .= "AND ". $k." LIKE '%".$v."%' ";
			}
		}
	}



	if(!isset($lonLatNamesArr) || !isset($withinDistance)){
		$response = dbMassData("SELECT * FROM $tableName WHERE $whereClause LIMIT $responseLimit ORDER BY DESC");
		//echo("SELECT * FROM $tableName WHERE $whereClause LIMIT $responseLimit");
		
		return $response;
	}
	else{

		$lat = $lonLatNamesArr['lat'];
		$lon = $lonLatNamesArr['lon'];

		$tableLat = $lonLatNamesArr['tableLat'];
		$tableLon = $lonLatNamesArr['tableLon'];
		$distance= $withinDistanceMiles;

		if(!isset($lon)){

			$lon= -73.9526528;
			$lat=40.7496964;
		}

		$theResponse = dbMassData("SELECT *, SQRT(POW(69.1 * ($tableLat - $lat ), 2) + POW(69.1 * ($lon- $tableLon) * COS($tableLat / 57.3), 2)) AS distance FROM $tableName HAVING distance < $distance ORDER BY distance LIMIT $responseLimit;");
		//echo("SELECT *, SQRT(POW(69.1 * ($tableLat - $lat ), 2) + POW(69.1 * ($lon- $tableLon) * COS($tableLat / 57.3), 2)) AS distance FROM $tableName HAVING distance < $distance ORDER BY distance LIMIT $responseLimit;");
		
		return $theResponse;
		//$response = dbMassData("SELECT * FROM $tableName WHERE $whereClause LIMIT $responseLimit");

	}

	}


	//for vibation weather


function findRecords1($tableName, $matchingArr, $likeBool=false, $responseLimit,  $lonLatNamesArr, $withinDistanceMiles){

	//returns all records from DB matching the matchingArr key value pairs, and within the distance specified

	//just look up and return

	if(!isset($tableName)){
		return false;
	}
	if(!is_array($matchingArr)){
		$matchingArr=array("1"=>"1", "operator1"=>"=");
		$likeBool=false;
	}

	if(!is_bool($likeBool)){


		//user forgot to include likeBool... and put the 
		return false;
	}

	if(!isset($responseLimit)){
		$responseLimit= 30;
	}
	if(!isset($withinDistance)){
		$withinDistance=25;
	}


	$whereClause = "";
	$matchingReset==0;
	foreach($matchingArr as $k=>$v){

		//first record... dont include AND in claude
		if($matchingReset=0){
			$matchingReset=1;
			if($likeBool==false){
				if(isset($matchingArr['operator1'])){
					$whereClause .= $k." ".$matchingArr['operator1']." ".$v." ";
				}
				else{
					$matchingArr['operator1'] = "=";
					$whereClause .= $k." ".$matchingArr['operator1']." '".$v."' ";
				}
				
			}
			else{
				
				$whereClause .= $k." LIKE '%".$v."%' ";
			}
			
		}

		//not first record, include "AND "
		else{
			if($likeBool==false){
			
				$whereClause .= "AND " .$k." = '".$v."' ";
			}
			else{
				
				$whereClause .= "AND ". $k." LIKE '%".$v."%' ";
			}
		}
	}



	if(!isset($lonLatNamesArr) || !isset($withinDistance)){
		$response = dbMassData("SELECT * FROM $tableName WHERE $whereClause LIMIT $responseLimit ORDER BY DESC");
		//echo("SELECT * FROM $tableName WHERE $whereClause LIMIT $responseLimit");
		
		return $response;
	}
	else{

		$lat = $lonLatNamesArr['lat'];
		$lon = $lonLatNamesArr['lon'];

		$tableLat = $lonLatNamesArr['tableLat'];
		$tableLon = $lonLatNamesArr['tableLon'];
		$distance= $withinDistanceMiles;

		if(!isset($lon)){

			$lon= -73.9526528;
			$lat=40.7496964;
		}

		$theResponse = dbMassData("SELECT *, SQRT(POW(69.1 * ($tableLat - $lat ), 2) + POW(69.1 * ($lon- $tableLon) * COS($tableLat / 57.3), 2)) AS distance FROM $tableName HAVING distance < $distance ORDER BY timestamp DESC LIMIT $responseLimit;");
		//echo("SELECT *, SQRT(POW(69.1 * ($tableLat - $lat ), 2) + POW(69.1 * ($lon- $tableLon) * COS($tableLat / 57.3), 2)) AS distance FROM $tableName HAVING distance < $distance ORDER BY distance LIMIT $responseLimit;");
		
		return $theResponse;
		//$response = dbMassData("SELECT * FROM $tableName WHERE $whereClause LIMIT $responseLimit");

	}

	}

function resolveLonLat($locArr){
	$lonLat = array();
	if(!isset($locArr['lon']) || !isset($locArr['lat'])){
			$locArr['lon']= -73.9526528;
			$locArr['lat']= 40.7496964;
	}
		$lonLat['lon']=$locArr['lon'];
		$lonLat['lat']=$locArr['lat'];
		if(isset($locArr['city']) || isset($locArr['zip'])){

			if(isset($locArr['state'])){
				$lonLat = getLatLon($locArr['city'], $locArr['state']);
			}
			else if(!isset($locArr['zip'])){
				$lonLat = getLatLon($locArr['city']);
			
			}
			else{
				$lonLat = getLatLon(null,null,$locArr['zip']);
			}
		}

		return($lonLat);
}



function getPhantomLocs($lon, $lat, $pNum){

	$theResponse = dbMassData("SELECT *, SQRT(POW(69.1 * (latitude - $lat ), 2) + POW(69.1 * ($lon- longitude) * COS(latitude / 57.3), 2)) AS distance FROM zip_codes HAVING distance < 3000 ORDER BY distance LIMIT $pNum, 12;");

	return(json_decode('{"lat":'.$theResponse[$ranRes]['latitude'].',"lon":'.$theResponse[$ranRes]['longitude'].'}', true));
	
						
}

?>