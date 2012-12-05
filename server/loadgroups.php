<?php
	include("DBconnect.php");
	header("Content-type: text/xml"); 
	$dbc = new DBconnect();
    $dbc->connect();
	$course = $_REQUEST['course'];
	$groupsFromClassQuery = "select name from groups where course_id =".$course;
	$dbc->execute_query($groupsFromClassQuery);
	$result = $dbc->fetch_array();
	//echo $result[00]['name'];
	if($result){
		$doc = new DomDocument('1.0');
		$root = $doc->createElement('groups');
		$root = $doc->appendChild($root);
		$rows = sizeof($result);
		
		
		for($i=0; $i<$rows;$i++){
			$groupElement = $doc->createElement('group');
			$groupAttribute = $doc->createAttribute('groupname');
			$groupAttributeValue = $doc->createTextNode($result[$i]['name']);
			$groupAttribute->appendChild($groupAttributeValue);
			$groupElement->appendChild($groupAttribute);
			$groupMembersQuery = "select email, name, photo from usercourses join users on user_id = users.email where group_name = '".$result[$i]['name']."' and course_id=".$course;
			$dbc->execute_query($groupMembersQuery);
			$groupMembers = $dbc->fetch_array();
			$grouprows = sizeof($groupMembers);
			
			for($k=0;$k<$grouprows;$k++){
				$memberElement = $doc->createElement('member');
				$memberEmail = $doc->createElement('email');
				$memberName = $doc->createElement('name');
				$imageElement = $doc->createElement('image');
				$imageElementValue = $doc->createTextNode($groupMembers[$k]['photo']);
				$memberEmailValue = $doc->createTextNode($groupMembers[$k]['email']);
				$memberNameValue = $doc->createTextNode($groupMembers[$k]['name']);
				$memberEmail->appendChild($memberEmailValue);
				$memberName->appendChild($memberNameValue);
				$imageElement->appendChild($imageElementValue);
				$memberElement->appendChild($memberEmail);
				$memberElement->appendChild($memberName);
				$memberElement->appendChild($imageElement);
				$groupElement->appendChild($memberElement);
			
			}
			$root->appendChild($groupElement);
			
			
			
			///$groupElement = $root->appendChild($groupElement);
		
		}
		
		$doc->save('groups.xml');
		print $doc->saveXML();
	}
?>