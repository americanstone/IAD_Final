<?php

	session_start();
	include_once("DBConnect.php");
	
	$action = $_REQUEST['action'];
	
	//create an DB connection
	$dbc = new DBConnect();
	$dbc->connect();
	
	//fetch the assignments of my enrolled courses
	if($action == "myassignment"){
		
		//get my enrolled courses first
		$user_id = $_SESSION['email'];
		$query = "SELECT COURSE_ID, ROLE FROM USERCOURSES WHERE USER_ID = '$user_id'";
		
		$dbc->execute_query($query);
		$mycourses = $dbc->fetch_array();
		
		if($mycourses){
		
			//create a new XML document
			$doc = new DomDocument('1.0');
			
			//create root node
			$root = $doc->createElement('myassignments');
			$root = $doc->appendChild($root);
			
			$rows = sizeof($mycourses);
			for($i = 0; $i < $rows; $i++){
				
				// create node for every enrolled course
				$cnode = $doc->createElement('course');
				$cnode = $root->appendChild($cnode);
				
				// get course title by id
				$course_id = $mycourses[$i]['COURSE_ID'];
				$query = "SELECT TITLE FROM COURSE WHERE COURSE_ID = '$course_id'";
				
				$dbc->execute_query($query);
				$result = $dbc->fetch_array();
				$course_title = $result[0]['TITLE'];
				
				// append 'title' as the attribute of the element 'course'
				$attr = $doc->createAttribute('title');
				$attr->value = $course_title;
				$attr = $cnode->appendChild($attr);
				
				// append 'id' as the attribute of the element 'course'
				$attr = $doc->createAttribute('id');
				$attr->value = $course_id;
				$attr = $cnode->appendChild($attr);
				
				// append 'myrole' as the attribute of the element 'course'
				$attr = $doc->createAttribute('myrole');
				$attr->value = $mycourses[$i]['ROLE'];
				$attr = $cnode->appendChild($attr);
				
				// fetch assignment for the specified course
				$query = "SELECT ASSIGN_ID, NAME, ASSIGN_DATE, DUE_DATE, SUBMIT_TYPE FROM ASSIGNMENT WHERE COURSE_ID = '$course_id'";
				$dbc->execute_query($query);
				$assignments = $dbc->fetch_array();
				
				if($assignments){
				
					$assign_num = sizeof($assignments);
					for($j = 0; $j < $assign_num; $j++){
						
						// add node for every assignment
						$anode = $doc->createElement('assignment');
						$anode = $cnode->appendChild($anode);
						
						$assign_id = $assignments[$j]['ASSIGN_ID'];
						$assign_name = $assignments[$j]['NAME'];
						$assign_date = $assignments[$j]['ASSIGN_DATE'];
						$due_date = $assignments[$j]['DUE_DATE'];
						$submit_type = $assignments[$j]['SUBMIT_TYPE'];

						// fetch submission information related to the assignment
						if($submit_type == "Group"){
							// only one submission is allowed for a group if the submit_type of the assignment is group
							// get group name to which the user belongs
							$query = "SELECT GROUP_NAME FROM USERCOURSES WHERE USER_ID = '$user_id' AND COURSE_ID = '$course_id'";
							$dbc->execute_query($query);
							$group = $dbc->fetch_array();
							
							$submitted_by = $group[0]['GROUP_NAME'];
							
							
						} else if ($submit_type == "Individual"){
							$submitted_by = $_SESSION['email'];
						}
						
						
						$query = "SELECT SUBMISSION_ID, SCORE FROM SUBMISSION WHERE COURSE_ID = '$course_id' AND ASSIGN_ID = '$assign_id' and SUBMITTED_BY = '$submitted_by'";
						$dbc->execute_query($query);
						$submission = $dbc->fetch_array();
						
						if($submission){
							$submission_id = $submission[0]['SUBMISSION_ID'];
							$score = $submission[0]['SCORE'];
						}
			
						// fill data into XML
						$child = $doc->createElement("assign_id");
						$child = $anode->appendChild($child);				
						$value = $doc->createTextNode($assign_id);
						$value = $child->appendChild($value);
						
						$child = $doc->createElement("assign_name");
						$child = $anode->appendChild($child);				
						$value = $doc->createTextNode($assign_name);
						$value = $child->appendChild($value);
						
						$child = $doc->createElement("assign_date");
						$child = $anode->appendChild($child);				
						$value = $doc->createTextNode($assign_date);
						$value = $child->appendChild($value);
						
						$child = $doc->createElement("due_date");
						$child = $anode->appendChild($child);				
						$value = $doc->createTextNode($due_date);
						$value = $child->appendChild($value);
						
						$child = $doc->createElement("submission_id");
						$child = $anode->appendChild($child);				
						$value = $doc->createTextNode($submission_id);
						$value = $child->appendChild($value);
						
						$child = $doc->createElement("score");
						$child = $anode->appendChild($child);				
						$value = $doc->createTextNode($score);
						$value = $child->appendChild($value);
						
					}
					
				}
				
				
			}
		}
		$xml_string = $doc->saveXML();
		print $xml_string;
			
		$dbc->disconnect();
	}
	
	// fetch the detailed information about the specific assignment
	else if($action == "list") {
	
		$assign_id = $_REQUEST['assign_id'];
		$course_id = $_REQUEST['course_id'];
		$query = "SELECT NAME, INSTRUCTION, ATTACHMENT, ASSIGN_DATE, DUE_DATE, SUBMIT_TYPE FROM ASSIGNMENT WHERE ASSIGN_ID = '$assign_id' AND COURSE_ID = '$course_id'";
		
		$dbc->execute_query($query);
		$instruction = $dbc->fetch_array();
		
		if($instruction){
		
			// create a new XML document
			$doc = new DomDocument('1.0');
			
			// create root node
			$root = $doc->createElement('assignment');
			$root = $doc->appendChild($root);
			
			// fill data into XML
			$child = $doc->createElement('name');
			$child = $root->appendChild($child);
			$value = $doc->createTextNode($instruction[0]['NAME']);
			$value = $child->appendChild($value);
			
			$child = $doc->createElement('instruction');
			$child = $root->appendChild($child);
			$value = $doc->createTextNode($instruction[0]['INSTRUCTION']);
			$value = $child->appendChild($value);
			
			$child = $doc->createElement('attachment');
			$child = $root->appendChild($child);
			$value = $doc->createTextNode($instruction[0]['ATTACHMENT']);
			$value = $child->appendChild($value);
			
			$child = $doc->createElement('assign_date');
			$child = $root->appendChild($child);
			$value = $doc->createTextNode($instruction[0]['ASSIGN_DATE']);
			$value = $child->appendChild($value);
			
			$child = $doc->createElement('due_date');
			$child = $root->appendChild($child);
			$value = $doc->createTextNode($instruction[0]['DUE_DATE']);
			$value = $child->appendChild($value);
			
			$child = $doc->createElement('submit_type');
			$child = $root->appendChild($child);
			$value = $doc->createTextNode($instruction[0]['SUBMIT_TYPE']);
			$value = $child->appendChild($value);
			
		}
		$xml_string = $doc->saveXML();
		print $xml_string;
		
		$dbc->disconnect();
		
	}
	
	//create a new assignment
	else if($action == "add") {
               
		$assignment_name = $_REQUEST['assignment_name'];
		$course_id = $_REQUEST['course_id'];
		$submit_type = $_REQUEST['submit_type'];
		$instruction = $_REQUEST['instruction'];
		$due_date = $_REQUEST['due_date'];
		
		if(isset($_FILES['attachment'])){
                    $fileName = $_FILES['attachment']['name'];
                    // save the uploaded file content
                    $fileContent = file_get_contents($_FILES['attachment']['tmp_name']);
                    $filePath = "../image/assignments/".$course_id;
                    // create directory if it does not exist
                    if(!is_dir($filePath)) {
                            mkdir($filePath);
                    }
                    $file = $filePath."/".$fileName;
                    file_put_contents($file, $fileContent);
                    $dbFilePath = "../image/assignments/".$course_id."/".$fileName;
                    //insert the new added assignment into table 'assignment'
                    $query = "INSERT INTO ASSIGNMENT VALUES(NULL, '$course_id', '$assignment_name', '$instruction', '$dbFilePath', NOW(), STR_TO_DATE('$due_date', '%Y-%m-%d'), '$submit_type')";
                    //print $query;
                }else{
                    $query = 'INSERT INTO ASSIGNMENT VALUES(NULL, "$course_id", "$assignment_name", "$instruction", NULL, NOW(), STR_TO_DATE($due_date, "%Y-%m-%d"), "$submit_type")';
                }
		/*
		if($fileName) {
			$fileContent = file_get_contents($_FILES['attachment']['tmp_name']);
			$filePath = "../image/assignments/".$course_id;
			// create directory if it does not exist
			if(!is_dir($filePath)) {
				mkdir($filePath);
			}
			$file = $filePath."/".$fileName;
			file_put_contents($file, $fileContent);
			$dbFilePath = "../image/assignments/".$course_id."/".$fileName;
		}*/
		
		// get the current assign id 
		/*$query = "SELECT MAX(ASSIGN_ID) ID FROM ASSIGNMENT WHERE COURSE_ID = '$course_id'";
		$dbc->execute_query($query);
		$result = $dbc->fetch_array();
		if($result[0]['ID']) {
			$assign_id = $result[0]['ID'] + 1;
		} else {
			$assign_id = 1;
		}*/
		
		
		$dbc->execute_query($query);
		
		//create submissions in table 'submission' according to submit type 
                $query = "SELECT MAX(ASSIGN_ID) ID FROM ASSIGNMENT";
                $dbc->execute_query($query);
		$result = $dbc->fetch_array();
                $assign_id = $result[0]['ID'];
		if($submit_type == 'Group') {
			//insert submission for each group
			$query = "SELECT NAME FROM GROUPS WHERE COURSE_ID = '$course_id'";
			$dbc->execute_query($query);
			$result = $dbc->fetch_array();
			if($result){
				$number = sizeof($result);
				for($i = 0; $i < $number; $i++){
					$group_name = $result[$i]['NAME'];
					//submission id consists of $course_id, $assign_id and $group_name
					//$submission_id = $course_id."_".$assign_id."_".$group_name;
					$query = "INSERT INTO SUBMISSION VALUES (NULL, '$assign_id', '$group_name', NULL, NULL)";
					$dbc->execute_query($query);
					
					//make a directory for each submission
					$dir = "../image/submissions/".$course_id."/".$assign_id."/".$group_name;
					mkdir($dir, 0700, true);
				}
			}
		} elseif ($submit_type = "Individual") {
			//insert submission for each student who enrolls the course
			$query = "SELECT USER_ID FROM USERCOURSES WHERE COURSE_ID = '$course_id' AND ROLE = 'STUDENT'";
			$dbc->execute_query($query);
			$result = $dbc->fetch_array();
			if($result){
				$number = sizeof($result);
				for($i = 0; $i < $number; $i++){
					$user_id = $result[$i]['USER_ID'];
					//submission id consists of $course_id, $assign_id and $user_id
					//$submission_id = $course_id."_".$assign_id."_".$user_id;
					$query = "INSERT INTO SUBMISSION VALUES (NULL, '$assign_id', '$user_id', NULL, NULL)";
					$dbc->execute_query($query);
					
					//make a directory for each submission
					$dir = "../image/submissions/".$course_id."/".$assign_id."/".$user_id;
					mkdir($dir, 0700, true);
				}
			}
		}
		print "true";
		
	}
?>