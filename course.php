<?php
    session_start();
    $course_id = $_REQUEST['course'];
    
    include("server/DBconnect.php");
    // create an DB connection
    $dbc = new DBconnect();
    $dbc->connect();
    
    //check if the user is the instructor of this course or not
    if(isset($_SESSION['email'])){
        $email = $_SESSION['email'];

        $query = "SELECT user_id FROM usercourses WHERE role= 'Instructor' and course_id=".$course_id;
        $dbc->execute_query($query);
        $result = $dbc->fetch_array();

        $isInstructor = ($result[0]['user_id'] == $email);
        
        //check if the user enrolled the course or not
        $query = "SELECT COUNT(*) COUNT FROM usercourses WHERE user_id ='".$_SESSION['email']."' AND course_id=".$course_id;
        $dbc->execute_query($query);
        $result = $dbc->fetch_array();
        $enrolled  = ($result[0]['COUNT'] == 0);
    }else {
        $enrolled = false;
    }
    
    
    
    
    function courseDesc(){
        global $course_id, $dbc;
         if($course_id){                
            $query = 'SELECT C.course_id,C.title,C.description,C.course_img,U.email,
                U.name instructor, C.department, C.semester FROM course C, 
                users U WHERE C.instructor = U.email and course_id="'.$course_id.'"';
            $dbc->execute_query($query);
            $result = $dbc->fetch_array(); 
            if($result){

                $fieldname = array_keys($result[0]);
                  echo "<tr>";
                  echo "<td width=55%>";
                  echo "<p><h2>".$result[0]['title']."</h2></p>";
                  echo "<p><h3><a href='userProfile.php?user=".$result[0]['email']."'>".$result[0]['instructor']."</a></h3></p>";
                  echo "<p>".$result[0]['department']."</p>";
                  echo "<p>".$result[0]['semester']."</p>";
                  echo "</td>";
                  echo '<td width= 30% align=right><img class="course_big_img" src="'.$result[0]['course_img'].'"/></td>';
                  echo "</tr>";
                  echo "<tr><td><p>".$result[0]['description']."</p></td>";
                  echo "</tr>";
            }
        }
    }
    
    function enrollCourse(){
        global $course_id;
        echo "<form action='server/_course.php?action=enroll&course=".$course_id."' method='POST'>";
        echo "<input type='submit' class = 'normal-size-button' name='enroll-course' value='Enroll'/>";
        echo "</form>";                     
    }


    
    function courseContent(){
        global $dbc, $course_id;
        if($course_id){

            $query ='SELECT topic,description, attachment 
                FROM coursecontent Where course_id="'.$course_id.'"'."order by topic";
            $dbc->execute_query($query);
            $result = $dbc->fetch_array(); 
            $rows = sizeof($result);


            echo "<ul>";
            $curTopic='';
            $i=0;
            while($i <$rows){
                if($curTopic != $result[$i]['topic']){
                    if($curTopic != ''){
                        echo "</ul>";
                        echo "</li>";
                    }
                    echo "<li>".$result[$i]['topic'];
                    echo "<ul>";
                    $curTopic = $result[$i]['topic'];
                }
                $attachmentFile = explode(".",$result[$i]['attachment']);
                if($attachmentFile[1] == "mp4" ||$attachmentFile[1] == "webm"){
                    
                    echo '<li><a class="video" href="'.$result[$i]['attachment'].'">'.$result[$i]['description'].'</a></li>';
                }else{
                    echo '<li><a href="'.$result[$i]['attachment'].'">'.$result[$i]['description'].'</a></li>';
                }
                

                $i++;
            }
            echo "</ul>";
        }          
    }

	function courseGroups(){
	global $dbc, $course_id;
	if($course_id){
		$groupQuery="select name from groups where course_id =".$course_id;
		//echo $groupQuery;
		$dbc->execute_query($groupQuery);
		$groupResult = $dbc->fetch_array($groupQuery);
		if($groupResult){ 
                    echo "<ul>";
                    for($i=0; $i<sizeof($groupResult); $i++){
                        
                        echo "<li>".$groupResult[$i]['name'];
                        $studentMemberQuery = "select name, email from usercourses join users on user_id = users.email where group_name = '".$groupResult[$i]['name']."' and course_id=".$course_id;
                        $dbc->execute_query($studentMemberQuery);
                        $membersResult = $dbc->fetch_array($studentMemberQuery);
                        if($membersResult){
                            echo "<ul>";
                            for($k=0; $k<sizeof($membersResult); $k++){
                                echo "<li><a href='userProfile.php?user=".$membersResult[$k]['email']."'>".$membersResult[$k]['name']."</a></li>";
                            }
                            echo "</ul>";
                        }        
			echo"</li><br/>";
                    }
                    echo "</ul>";
		}else{
		  echo "No groups created yet.";
		}
		}
	
	}
    
    function courseAssignment(){
        global $dbc, $course_id, $isInstructor;
        if($course_id){
            $query = "SELECT assign_id, name, assign_date, due_date, submit_type
                FROM assignment WHERE course_id = '$course_id' ORDER BY assign_date";
            $dbc->execute_query($query);
            $result = $dbc->fetch_array(); 
            $rows = sizeof($result);
            echo "<table class='assignment-table'>";
            echo "<tr>";
            echo "<th>Assignment ID</th>";
            echo "<th>Assignment name</th>";
            echo "<th>Assign date</th>";
            echo "<th>Due date</th>";
            echo "<th>Submission type</th>";
            if(!$isInstructor){
                echo "<th>Score</th>";
            }
            echo "<th>Submission</th>";
            echo "</tr>";
            $background = true;
            for($i = 0; $i < $rows; $i++){
                if($background){
                    echo "<tr style='background-color: #F5F5F5'>";
                }else {
                    echo "<tr >";
                }
                $background = !$background;
                $assign_id = $result[$i]['assign_id'];
                $submit_type = $result[$i]['submit_type'];
                echo "<td>Assignment ".($i+1)."</td>";
                echo "<td><a class = 'assignment-instruction-window' href='#assignment-instruction' assign_id='".$result[$i]['assign_id']."'>".$result[$i]['name']."</a></td>";
                echo "<td>".$result[$i]['assign_date']."</td>";
                echo "<td>".$result[$i]['due_date']."</td>";
                echo "<td>".$result[$i]['submit_type']."</td>";
                if(!$isInstructor){
                    if($submit_type == "Group"){
                        $query="SELECT SCORE FROM SUBMISSION JOIN USERCOURSES ON SUBMITTED_BY = GROUP_NAME WHERE USER_ID='".$_SESSION['email']."' AND COURSE_ID = $course_id AND ASSIGN_ID = $assign_id";
                        $dbc->execute_query($query);
                        $queryResult = $dbc->fetch_array();
                        $score = $queryResult[0]['SCORE'];
                    } else {
                        $query="SELECT SCORE FROM SUBMISSION WHERE SUBMITTED_BY ='".$_SESSION['email']."' AND ASSIGN_ID = $assign_id";
                        $dbc->execute_query($query);
                        $queryResult = $dbc->fetch_array();
                        $score = $queryResult[0]['SCORE'];
                        
                    }
                    if($score != -1){
                        echo "<td>".$score."</td>";
                    } else {
                        echo "<td> - </td>";
                    }
                }
                echo "<td><a id = 'submission-id' href = 'submission.php?course=".$course_id."&assignment=".$assign_id."&submittype=".$submit_type."'>submission</a></td>";

                echo "</tr>";
            }
            echo "</table>";

        }
    }
	
	
    
    function displayContents(){
        global $isInstructor, $course_id;
        //course content
        echo "<p style='margin-top: 30px'><h3>Content</h3></p>";
        if($isInstructor){
            echo '<a href="#create-course-box" class="create-content-window">Add content</a>';
        }
        echo "<div class='course-content'>";
        courseContent();
        echo "</div>";
        
        //course assignment
        echo "<p style='margin-top: 30px'><h3>Assignment</h3></p>";
        if($isInstructor){
             echo '<a href="#create-assignment-box" class="create-assignment-window">Add assignment</a>';  
        }
        echo " <div class ='course-assignment'>" ;
        courseAssignment();
        echo "</div>";
		
		echo "<p style='margin-top: 30px'><h3>Groups</h3></p>";
		if($isInstructor){
			echo '<a href="group.php?course='.$course_id.'">Edit group</a>';
		}
		
		echo "<div class='course-assignment'>";
		courseGroups();
		echo"</div>";
		
        
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/course.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/popup.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/assignment.css" type = "text/css" media = "screen" />
        <script type="text/javascript" src="script/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="script/course.js"></script>
        <script type="text/javascript" src="script/assignment.js"></script>
        <title></title>
    </head>
    <body>
        <?php include 'header.php' ?>
        <div class="content" course-id="<?php echo $course_id?>">
            <!-- course description -->
            <table cellpadding="10px">
                <?php courseDesc(); ?>	
            </table>
            
            <!-- enroll course button -->
            <?php if($enrolled){
                enrollCourse();
            }else {
                displayContents();
            }?>
                     
            <?php include('createCourseContent.php') ?>
            <?php include('assignmentInstruction.php') ?>
            <?php include('createAssignment.php')?>
        </div>
    </body>
</html>
