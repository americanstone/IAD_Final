<?php
    session_start();
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel = "stylesheet" href = "css/main.css" type = "text/css" media = "screen" />
        <title></title>
    </head>
    <body>
  
        <div class="content">
        <table cellpadding="10px">
        <?php
           
            $action= $_REQUEST['action'];
          
            if($action=="list"){
                $course_id = $_REQUEST['course'];
                
                if($course_id){
                    include("server/DBconnect.php");
                    // create an DB connection
                    $dbc = new DBconnect();
                    $dbc->connect();
                    $query = 'SELECT C.course_id,C.title,C.description,C.course_img,
                        U.name instructor, C.department, C.semester FROM course C, 
                        users U WHERE C.instructor = U.email and course_id="'.$course_id.'"';
                    $dbc->execute_query($query);
                    $result = $dbc->fetch_array(); 
                    if($result){
                        
                        $fieldname = array_keys($result[0]);
                          echo "<tr>";
                          echo "<td width=55%>";
                          echo "<p><h2>".$result[0]['title']."</h2></p>";
                          echo "<p><h3>".$result[0]['instructor']."</h3></p>";
                          echo "<p>".$result[0]['department']."</p>";
                          echo "<p>".$result[0]['semester']."</p>";
                          echo "</td>";
                          echo '<td width= 30%><img class="course_big_img" src="'.$result[0]['course_img'].'"/></td>';
                          echo "</tr>";
                          echo "<td><p>".$result[0]['description']."</p></td>";
                          echo "</tr>";
                    }
                }
            }
        ?>	
	</table>
            <input type="button" name="enroll-course" value="Enroll"/>
        </div>
        <div class="course-content">
            <?php
            if($course_id){
                
                $query ='SELECT topic,description, attachment 
                    FROM coursecontent Where course_id="'.$course_id.'"'."order by topic";
                $dbc->execute_query($query);
                $result = $dbc->fetch_array(); 
                $rows = sizeof($result);
                
       
                echo "<ul>";
                
                $i=0;
                $curTopic='';
                /*
                while($i < $rows){
                    echo $result[$i]['attachment']."<br/>";
                    $i++;
                }*/
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
                    
                    echo '<li><a href="'.$result[$i]['attachment'].'">'.$result[$i]['description'].'</a></li>';
                   
                    $i++;
                }
                echo "</ul>";
            }              
            ?>
        </div>
        
        
    </body>
</html>
