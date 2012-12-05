<?php
/*
 * Created on 2012-6-28
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

        session_start();
	include("server/DBconnect.php");
	// create an DB connection
	$dbc = new DBconnect();
	$dbc->connect();
        $query = "SELECT C.course_id,C.title,C.description,C.course_img, U.name instructor, C.department, C.semester FROM course C, users U WHERE C.instructor = U.email order by C.department";
        $dbc->execute_query($query);
        $result = $dbc->fetch_array();
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
	<title>Studio online LAB</title>
	
	
</head>
<body>
	<div>
		<?php include("header.php") ?>
		 <br></br>

		
	
   
    
    <div class = "content">
            <table cellspacing="100" cellpadding="10" align="center">
               
                <?php
                    $rows = sizeof($result);
                    $fieldname = array_keys($result[0]);
                    $columns = sizeof($fieldname);
                    $m = 0;
                    for($i = 0; $i < 2; $i++){
                        echo "<tr>";
                        for($j =0; $j< 4; $j++){
                            
                            echo "<td style='border: 1px solid #EFE6D7' valign=top width=100px height=100px>";
                          
                            echo '<img src="'.$result[$m]['course_img'].'" />';
                            echo "<div class='all-courses-text'><a href='course.php?course=".$result[$m]['course_id']."'><h3>".$result[$m]['title']."</h3></a><br/>";
                            //echo $result[$m]['description']."</br>";
                            echo $result[$m]['instructor']."</br>";
                            //echo $result[$m]['department']."</br>";
                            echo $result[$m]['semester']."</div>";
                           

                            $m++;
                          
                            echo "</td>"; 
                        }
                       echo "</tr>";
                    }
                ?>
            </table>
            
        </div>
</div>
	
</body>

</html>
