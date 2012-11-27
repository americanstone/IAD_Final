<?php
/*
 * Author:Guojun Zhang
 * Filename: getProfessor.php
 * Purpose: server side php
 *          base on client request 
 *          response professors informtion 
 *          client list request response a xml including all professors
 *          client verify request response "true" is it is professor
 */
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
	}else if($action=='verify'){
            $email = $_SESSION['email'];
            $query = 'SELECT count(*) count FROM users WHERE email="'.$email.'" '.'and role="professor"';
            $dbc->execute_query($query);
            $result = $dbc->fetch_array();
            if($result[0]['count'] == 1){
                print "true";
            }else{
                print "false";
            }
        }
?>