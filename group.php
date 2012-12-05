<?php

 session_start();
 include("server/DBconnect.php");
 $course_id = $_REQUEST['course'];
 

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<link rel = "stylesheet" href = "css/dnd.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/course.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/popup.css" type = "text/css" media = "screen" />
        <link rel = "stylesheet" href = "css/assignment.css" type = "text/css" media = "screen" />
        <script type="text/javascript" src="script/jquery-1.7.2.min.js"></script>
        <script type="text/javascript" src="script/course.js"></script>
        <script type="text/javascript" src="script/assignment.js"></script>
		<script type="text/javascript" src="script/DnD.js"></script>
        <title></title>
    </head>
    <body>
        <?php include 'header.php' ?>

        <div id="content" class="content" course-id="<?php echo $course_id?>" >

			<table id="cards-table">
		  
			</table>

			<div id='generator' class="addbutton"><header><a href="#"><img class="addimg" src="image/add.png"/></a>Click to add groups</header></div>
			<div class="submit">
			<table>
				<tr>
					<td><input id="submitButton" type="submit" value="submit"/></td>

					<td><input id="disbandButton" type="submit" value="disband all groups"/></td>
					
					<td><input id="refresh" type="submit" value="refresh"/></td>
				</tr>
			</table>
			</div>
			<br>
			<div id="columns" class="group">
			
			</div>

		</div>		
    </body>
</html>
