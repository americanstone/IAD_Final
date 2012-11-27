<?php
/* Author:Guojun Zhang
 * Filename:mycourse.php
 * Purpose: script/course.js fetch all course information from db and 
 *          display it in certen area.
 *          css hiden create course page when click the create course button
 *          bring it in screen.
 * Call: by topmenue.php
 *       header.php
 *       createCourse.php
 * Created on 2012-6-28
 *
 */
 session_start();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en_US" xml:lang="en_US">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="Content-Language" content="en" />
	<meta name="GENERATOR" content="PHPEclipse 1.2.0" />
	<link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" />
	<link rel = "stylesheet" href = "css/course.css" type = "text/css" media = "screen" />
	<link rel = "stylesheet" href = "css/assignment.css" type = "text/css" media = "screen" />
	<link rel = "stylesheet" href = "css/popup.css" type = "text/css" media = "screen" />
	<title>My courses</title>
	<script type="text/javascript" src="script/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="script/myCourse.js"></script>
	
</head>
<body>
	<div class = "display-region">
		<?php include("header.php") ?>
		<div class = "content">
		<!---Will be generated automatically by myCourse.js  -->	
                
		</div>
                    <?php include("createCourse.php") ?>
		
	</div>
	<div class = "footer"> 
                      
                </div>
</body>

</html>