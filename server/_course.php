<?php
	session_start();
	include("DBconnect.php");
	$action = $_REQUEST['action'];
	
	// create an DB connection
	$dbc = new DBconnect();
	$dbc->connect();
	
	//handle the request of listing all courses
	if($action == "list") {
		$query = "SELECT C.course_id, C.title, C.course_img, U.name instructor, C.department, C.semester FROM course C, users U WHERE C.instructor = U.email order by C.department";
		$dbc->execute_query($query);
		
		$result = $dbc->fetch_array();
		
		if ($result) {
			// create a new XML document
			$doc = new DomDocument('1.0');
		
			// create root node
			$root = $doc->createElement('courses');
			$root = $doc->appendChild($root);
			
			$rows = sizeof($result);
			$fieldname = array_keys($result[0]);
			$columns = sizeof($fieldname);
			
			for($i = 0; $i < $rows; $i++) {
				// add node for each row
				$occ = $doc->createElement('course');
				$occ = $root->appendChild($occ);
				for($j = 0; $j < $columns; $j++) {
					// add node for each field
					$child = $doc->createElement($fieldname[$j]);
					$child = $occ->appendChild($child);
				
					// add value for each field
					$value = $doc->createTextNode($result[$i][$fieldname[$j]]);
					$value = $child->appendChild($value);
				}
			}
			$xml_string = $doc->saveXML();
			print $xml_string;
			
			$dbc->disconnect();
		}
	} 
	
	// handle the request of listing my courses
	else if($action == "mycourses") {
		$user_id = $_SESSION['email'];
		$query = "SELECT COURSE_ID, ROLE, GROUP_NAME FROM USERCOURSES WHERE USER_ID = '$user_id'";
		$dbc->execute_query($query);
		
		$course_list = $dbc->fetch_array();
		if ($course_list) {
			// create a new XML document
			$doc = new DomDocument('1.0');
		
			// create root node
			$root = $doc->createElement('mycourses');
			$root = $doc->appendChild($root);
			
			$rows = sizeof($course_list);
			for($i = 0; $i < $rows; $i++){
				// add node for each row
				$occ = $doc->createElement('mycourse');
				$occ = $root->appendChild($occ);
				
				$course_id = $course_list[$i]['COURSE_ID'];
				$role = $course_list[$i]['ROLE'];
				$group_name = $course_list[$i]['GROUP_NAME'];
				
				// fetch course's details
				$query = "SELECT COURSE_ID, COURSE_IMG, TITLE, INSTRUCTOR, DEPARTMENT, SEMESTER FROM COURSE WHERE COURSE_ID = '$course_id'";
				$dbc->execute_query($query);
				$detail = $dbc->fetch_array();
				
				if($detail) {
                                        $course_id = $detail[0]['COURSE_ID'];
					$course_img = $detail[0]['COURSE_IMG'];
					$title = $detail[0]['TITLE'];
					$instructor = $detail[0]['INSTRUCTOR'];
					$department = $detail[0]['DEPARTMENT'];
					$semester = $detail[0]['SEMESTER'];
					
					// fetch instructor name of the specified course
					$query = "SELECT NAME FROM USERS WHERE EMAIL = '$instructor'";
					$dbc->execute_query($query);
					$result = $dbc->fetch_array();
					
					if($result) {
						$instructor = $result[0]['NAME'];
					}
				}
				
				// fill data into XML
                                $child = $doc->createElement("course_id");
                                $child = $occ->appendChild($child);
                                $value = $doc->createTextNode($course_id);
                                $value = $child->appendChild($value);
                                
				$child = $doc->createElement("title");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($title);
				$value = $child->appendChild($value);
				
				$child = $doc->createElement("course_img");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($course_img);
				$value = $child->appendChild($value);
				
				$child = $doc->createElement("instructor");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($instructor);
				$value = $child->appendChild($value);
				
				$child = $doc->createElement("department");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($department);
				$value = $child->appendChild($value);
				
				$child = $doc->createElement("semester");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($semester);
				$value = $child->appendChild($value);
				
				$child = $doc->createElement("role");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($role);
				$value = $child->appendChild($value);
				
				$child = $doc->createElement("group_name");
				$child = $occ->appendChild($child);				
				$value = $doc->createTextNode($group_name);
				$value = $child->appendChild($value);
			}
		$xml_string = $doc->saveXML();
		print $xml_string;	
			
		}
		
		
			
		$dbc->disconnect();
	}
	
	// handle the request of enrolling a course
	else if ($action == "enroll") {
            $course_id = $_REQUEST['course'];
            $query = "INSERT INTO usercourses VALUES('".$_SESSION['email']."', ".$course_id.", '".$_SESSION['role']."', NULL)";
            $dbc->execute_query($query);
            header("Location: ../course.php?course=".$course_id);
	}
	
	// handle the request of unenrolling a course 
	else if ($action == "unenroll") {
            $course_id = $_REQUEST['course'];
            $query = "DELETE FROM usercourses WHERE user_id='".$_SESSION['email']."' AND course_id=".$course_id;
            $dbc->execute_query($query);
            header("Location: ../myCourse.php");
	}
	
	// handle the request of adding course
	else if($action == "add") {
		$title = $_REQUEST['title'];
		$description = $_REQUEST['description'];
		$department = $_REQUEST['department'];
		$semester = $_REQUEST['semester'];
		$fileName = $_FILES['upload_file']['name'];
		
		//save the uploaded file content
		$fileContent = file_get_contents($_FILES['upload_file']['tmp_name']);
		//$dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);
		$filePath = "../image/courses/".$title;
		mkdir($filePath);
		
		$file = $filePath."/".$fileName;
		file_put_contents($file, $fileContent);
		
		// insert the new course into table 'course'
		$dbFilePath = "image/courses/".$title."/".$fileName;
		$instructor = $_SESSION['email'];
		$query = "INSERT INTO COURSE VALUES (NULL, '$dbFilePath', '$title', '$description', '$instructor', '$department', '$semester')";
		$dbc->execute_query($query);
		
		// insert the new course into table 'usercourses' as my instructed course
		$query = "SELECT COURSE_ID FROM COURSE WHERE TITLE = '$title'";
		$dbc->execute_query($query);
		$result = $dbc->fetch_array();
		$course_id = $result[0]['COURSE_ID'];
		$user_id = $_SESSION['email'];
		
		$query = "INSERT INTO USERCOURSES VALUES ('$user_id', '$course_id', 'Instructor', NULL)";
		$dbc->execute_query($query);
		print "true";

	}
        
        //add new course content
        else if($action == "addcontent"){
            $topic = $_REQUEST['topic'];
            $description = $_REQUEST['description'];
            $course_id = $_REQUEST['courseid'];
            $fileName = $_FILES['upload_file']['name'];
            // fetch course's details
            $query = "SELECT title FROM COURSE WHERE COURSE_ID = '$course_id'";
            $dbc->execute_query($query);
            $result = $dbc->fetch_array();
            if($result){
                $title = $result[0]['title'];
            
                //save the uploaded file content
                $fileContent = file_get_contents($_FILES['upload_file']['tmp_name']);
                //$dataUrl = 'data:' . $fileType . ';base64,' . base64_encode($fileContent);
                $filePath = "../image/courses/".$title;
                if(!file_exists($filePath)){
                    mkdir($filePath);
                }
                $file = $filePath."/".$fileName;
                file_put_contents($file, $fileContent);

                // insert the new content into table 'coursecontent'
                $dbFilePath = "image/courses/".$title."/".$fileName;

                $query = "INSERT INTO coursecontent VALUES ('$topic', '$description', '$dbFilePath','$course_id')";
                $dbc->execute_query($query);
                print "true";
            }else{
                print "false";
            }
            
        }
?>