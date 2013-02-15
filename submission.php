<?php
    
    session_start();
    
    $course_id = $_REQUEST['course'];
    $assign_id  = $_REQUEST['assignment'];
    $submit_type = $_REQUEST['submittype'];
    
    include("server/DBconnect.php");
    // create an DB connection
    $dbc = new DBconnect();
    $dbc->connect();
    
    //check if the user has the right to grade submissions
    if($_SESSION['email']){
        $email = $_SESSION['email'];

        $query = "SELECT user_id FROM usercourses WHERE role= 'Instructor' and course_id=".$course_id;
        $dbc->execute_query($query);
        $result = $dbc->fetch_array();

        $grader = ($result[0]['user_id'] == $email);
    }

    function displayAllSubmissions(){
        global $dbc, $assign_id;
        
        $query = "SELECT submission_id, submitted_by FROM submission WHERE assign_id=".$assign_id;
        $dbc->execute_query($query);
        $result = $dbc->fetch_array();
        $rows = sizeof($result);
        echo "<table width='70%' id='all-submissions'>";
         echo "<tr>";
        for($i = 0; $i < $rows; $i++){
            if(($i + 1) % 6 === 0){
                echo "<tr>";
            }else{
                echo "<td><a class='submission' href='#' submitid='".$result[$i]['submission_id']."' submitby='".$result[$i]['submitted_by']."'>".$result[$i]['submitted_by']."</a></td>";
                if(($i + 1) % 6 === 0){
                    echo "</tr>";
                }
            }
            
        }
        echo "</tr>";
        echo "</table>";
        
        
    }
    
    function uploadSubmission(){
        echo "<div id = 'submission-upload'>";
        echo '<form method="post">';
        echo '<lable class="attachment" >';
        echo '<h4>You are only allowed to upload .zip, .rar or .tar.gz</h4>';
        echo '<input type="file" id="attachment" name="attachment" required="required" accept="application/x-rar-compressed|application/zip"/>';
        echo '</lable><br/>';
        echo '<button id = "upload-submission" class="normal-size-button button" type="submit">Submit</button>';
        echo '</form>';
        echo '</div>';
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" />
	<link rel = "stylesheet" href = "css/popup.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/submission.css" type = "text/css" media = "screen" />
	<title>Studio online LAB</title>
	<script type="text/javascript" src="script/jquery-1.7.2.min.js"></script>
        <?php if($grader) { ?>
	<script type="text/javascript" src="script/submission.js"></script>
        <?php }else { ?>
        <script type="text/javascript" src="script/studentSubmission.js"></script>
        <?php } ?>
	
</head>
<body>
    <div class = "display-region">
        <?php include("header.php") ?>

        <div class = "content" course="<?php echo $course_id?>" 
             assignment="<?php echo $assign_id?>" submittype="<?php echo $submit_type ?>">

                <?php if($grader){
                    displayAllSubmissions();
                }else {
                    uploadSubmission();
                } ?>
             
                <!-- div for display submission directories and files -->
                <div id = "project-editor" class = "bordered-box">	
                        <div id = "editor-menus" submitby="">
                            <?php if(!$grader){ ?>
                            <button id = "refresh" type="submit">
                            <img src = "image/update.png" width = "28px" hight = "28px" alt="refresh" title="refresh"/></button>
                            <?php } ?>
                            <button id = "view-comment" type="submit" file = "dummy">
                            <img src = "image/comments.png" width = "28px" hight = "28px" alt="comments" title="comments"/></button>
                            <?php if($grader){ ?>
                            <button id = "grade" type="submit" file = "dummy">
                            <img src = "image/grade.png" width = "28px" hight = "28px" alt="grade" title="grade"/></button>
                            Current grade: <input id="slidbar" type="range" name="points" min="0" max="100" value="0">
                               <span id="range" style="color: red">0</span>
                               
                            <?php } ?>
                        </div>
                        <div id = "directory-data"></div>
                        <div id = "file-container">
                                <div id = "file-data"></div>
                                <!-- div for displaying comments for the mouse hovered line -->
                                <div>
                                        <table id = 'comment-details' class = 'comment'>

                                        </table>
                                </div>
                        </div>
                </div>

                <!-- div for adding a comment pop up box -->
                <div id="comment-box" class="popup-box">
                    <a href="#" class="close"><img src="image/close_pop.png" class="btn_close" title="Close Window" alt="Close" /></a>
                    <div class="data">
                        <form method="post" class="comment">
                            <fieldset class="textbox">

                                <!-- Course ID was hidden -->
                                <input id="file-path" value="" type="text" style = "display:none"/>

                                <!-- Issue -->
                                <label class="issue">
                                <span>Issue</span>
                                <textarea id="issue" cols="20" rows = "30"></textarea>
                                </label>

                                <!-- Suggested Solution -->
                                <label class="solution">
                                <span>Suggested Solution</span>	
                                <textarea id="solution" cols="20" rows = "30"></textarea>
                                </label>

                            </fieldset>

                            <fieldset class="textbox2">
                                    <!-- Severity -->
                                    <label class="severity">
                                    <span>Severity</span>
                                    <input id="severity" required="required" type= "text" list = "severity"/>
                                    <datalist id="browsers">
                                      <option value="1">
                                      <option value="2">
                                      <option value="3">
                                      <option value="4">
                                    </datalist>
                                    </label>

                                    <!-- category -->				
                                    <lable class="category" >
                                    <span>Category</span>
                                            <input type="text" id="category" />
                                    </lable>

                                    <!-- Line -->
                                    <lable class="in-line" >
                                    <span>Line</span>
                                            <input type="text" id="in-line" />
                                    </lable>

                                    <button id = "update" class="normal-size-button button" type="submit">Submit</button>
                                    <!-- hidden reset input -->
                                    <div class = "reset">
                                            <input id="reset" type = "reset"/>
                                    </div>
                            </fieldset>				
                        </form>
                    </div>
                </div>
        </div>
    </div>
	
</body>

</html>
