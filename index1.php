<?php
        session_start();
	include("server/DBconnect.php");
	// create an DB connection
	$dbc = new DBconnect();
	$dbc->connect();
        $query = "SELECT C.title,C.description,C.course_img, U.name instructor, C.department, C.semester FROM course C, users U WHERE C.instructor = U.email order by C.department";
        $dbc->execute_query($query);
        $result = $dbc->fetch_array();
?>
<html>
    <head>
        
        <link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" /> 
    </head>
    <body>
        <div><a href="signIn.php">Login</a></div>
        <div>
            <table cellspacing="100" cellpadding="10" align="center">
               
                <?php
                    $rows = sizeof($result);
                    $fieldname = array_keys($result[0]);
                    $columns = sizeof($fieldname);
                    $m = 0;
                    for($i = 0; $i < 2; $i++){
                        echo "<tr>";
                        for($j =0; $j< 3; $j++){
                            
                            echo "<td valign=top width=100px height=100px>";
                          
                            echo '<img src="'.$result[$m]['course_img'].'" />';
                            echo "<p><span>".$result[$m]['title']."</span><br/>";
                            //echo $result[$m]['description']."</br>";
                            echo $result[$m]['instructor']."</br>";
                            //echo $result[$m]['department']."</br>";
                            echo $result[$m]['semester']."</p>";
                           

                            $m++;
                          
                            echo "</td>"; 
                        }
                       echo "</tr>";
                    }
                ?>
            </table>
            
        </div>
        <div>footer</div>
        
    </body>
</html>

<?php


?>