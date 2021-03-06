<?php
	session_start();
	include("DBconnect.php");
	$action = $_REQUEST['action'];
	
	// create an DB connection
	$dbc = new DBconnect();
	$dbc->connect();
	
	//
	if($action == 'ls'){
		
		$course_id = $_REQUEST['course_id'];
		$assign_id = $_REQUEST['assign_id'];
                $submit_type = $_REQUEST['submit_type'];
               
                if(empty($_REQUEST['submit_by'])){
                    $submit_by = fetchSubmissionPath($course_id, $submit_type);
                   
                }else {
                    $submit_by = $_REQUEST['submit_by']; 
                }
                
		$root_dir = "../image/submissions/".$course_id."/".$assign_id."/".$submit_by."/";
		createDir($root_dir);
		
		
	}
	elseif ($action == 'submit'){
            if(isset($_FILES['attachment'])){
		$course_id = $_REQUEST['course_id'];
                $assignment_id = $_REQUEST['assignment_id'];
		$submit_type = $_REQUEST['submittype'];  
                $submition_path = fetchSubmissionPath($course_id,$submit_type);
                $submition_id = fetchSubmissionID($course_id, $assignment_id, $submit_type);
                $user = $_SESSION['email'];
                $target_path = "../image/submissions/".$course_id."/".$assignment_id."/".$submition_path."/";
                /*remove files first */
                rrmdir($target_path);
                mkdir($target_path);
                $fileName = $_FILES['attachment']['name'];
                $fileContent = file_get_contents($_FILES['attachment']['tmp_name']);
                $targetFile = $target_path.$fileName;
                file_put_contents($targetFile, $fileContent);

                $zip = new ZipArchive;
                
                $res = $zip->open($targetFile);
                              
                if($res === TRUE) {
                    
                    
                    $zip->extractTo($target_path); 
                    $zip->close();
                    unlink($targetFile);
                    
                    echo 'true';
                }else {
                    echo 'failed';
                }
             
                
            }
	}
	else if ($action == 'file') {
		$file_path = $_REQUEST['path'];
		//echo file_get_contents($file_path);
		$filearray = file($file_path);
		$response = "";
		for($i = 0 ; $i < sizeof($filearray); $i++){
			$response = $response.$filearray[$i];
			$response = $response."\n\r";
		}
		echo $response;
	}else if($action == 'getGrade'){
         /*get grade from database */
            $submitBy = $_REQUEST['submitername'];
            $assign_id = $_REQUEST['assignid'];
            $query = "SELECT score FROM submission WHERE submitted_by='$submitBy' and assign_id='$assign_id'";
            //print $query;
            $dbc->execute_query($query);
            $result = $dbc->fetch_array();
            if($result){
                    echo $result[0]['score'];
                }
        
        }else if($action == 'submitGrade'){
            /*update database grade */
           if(isset($_REQUEST['gradeValue']) && isset($_REQUEST['assignid']) && isset($_REQUEST['submitby'])){
               $grade = $_REQUEST['gradeValue'];
               $assign_id = $_REQUEST['assignid'];
               $submitBy = $_REQUEST['submitby'];
                   
                   $updatedata = "UPDATE submission SET score='$grade' WHERE assign_id='$assign_id' and submitted_by='$submitBy'";
                   $dbc->execute_query($updatedata);
                  
 //              }
               echo "true";
          }
          
        }
	 function rrmdir($dir) { 
            if (is_dir($dir)) { 
                $objects = scandir($dir); 
                foreach ($objects as $object) { 
                    if ($object != "." && $object != "..") { 
                        if (filetype($dir."/".$object) == "dir"){
                             rrmdir($dir."/".$object);  
                        }else{
                            //unset($dir."/".$object);
                            unlink($dir."/".$object);
                        }

                    } 
                } 
                reset($objects); 
                rmdir($dir); 
            } 
        } 
	
	function createDir($path){
		if($handle = opendir($path)){
			echo "<ul>";
			$queue = array();
			while(($file = readdir($handle)) !== false){
				if(is_dir($path.$file) && $file != '.' && $file != '..')
					printSubDir($file, $path);
				else if($file != '.' && $file != '..')
					$queue[] = $file;
			}
			printQueue($queue, $path);
			echo "</ul>";
		}
	}
	
	function printQueue($queue, $path){
		foreach ($queue as $file)
			printFile($file, $path);
	}
	
	function printFile ($file, $path){
		echo "<li><a class = 'file' path = \"".$path.$file."\">$file</a></li>";
	}
	
	function printSubDir($dir, $path){
		echo "<li><span class = \"toggle\">$dir</span>";
		createDir($path.$dir."/");
		echo "</li>";
	}
        
        function fetchSubmissionPath($course_id, $submit_type){
            global $dbc;
            if($submit_type == 'Individual'){
                return $_SESSION['email'];
            } elseif($submit_type == 'Group'){
                $query = "SELECT group_name FROM usercourses WHERE course_id ='$course_id' and user_id='".$_SESSION['email']."'";
                $dbc->execute_query($query);
                $result = $dbc->fetch_array();
                if($result){
                    return $result[0]['group_name'];
                }
            }
        }
        
        function fetchSubmissionID($course_id, $assign_id, $submit_type){
        global $dbc;
        if($submit_type == 'Individual'){
            
            $query = "SELECT submission_id FROM submission WHERE submitted_by='".$_SESSION['email']."' and assign_id=".$assign_id;           
            $dbc->execute_query($query);
            $result = $dbc->fetch_array();
            if($result){
                return $result[0]['submission_id'];
            }
        }elseif($submit_type == 'Group'){
            $query = "SELECT group_name FROM usercourses WHERE course_id ='$course_id' and user_id='".$_SESSION['email']."'";
            $dbc->execute_query($query);
            $result = $dbc->fetch_array();
            if($result){
                $group = $result[0]['group_name'];
                $query = "SELECT submission_id FROM submission WHERE submitted_by='".$group."' and assign_id=".$assign_id;           
                $dbc->execute_query($query);
                $result = $dbc->fetch_array();
                if($result){
                    return $result[0]['submission_id'];
                }
            }
        }
        
    }
        
      
	
?>