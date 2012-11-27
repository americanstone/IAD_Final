<?php
	session_start();
	include("DBconnect.php");
	$action = $_REQUEST['action'];
	
	//create an DB connection
	$dbc = new DBconnect();
	$dbc->connect();
	
	//handle the request of listing all professors
	if($action == "list"){
		$query = "SELECT name from USERS WHERE role='professor'";
		$dbc->execute_query($query);
		$result = $dbc->fetch_array();
		
		if($result){
			//create a new XML document 
			$doc = new DomDocument('1.0');
			//create root node 
			$root = $doc->createElement('professor');
			$root = $doc->appendChild($root);
			$rows = sizeof($result);
			for($i = 0; $i <$rows; $i++){
				//add node for each row
				$occ = $doc->createElement('name');
				$occ = $root->appendChild($occ);
				
				$value = $doc->createTextNode($result[$i]['name']);
				$value = $occ->appendChild($value);
			}
			$xml_string = $doc->saveXML();
			print $xml_string;
			$dbc->disconnect();
		}
	}
?>