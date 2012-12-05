 <?php
			include("DBconnect.php");
            $dbc = new DBconnect();
             $dbc->connect();

			$_SESSION['dbc'] = $dbc;

				$course = $_REQUEST['course'];

                $query = 'SELECT name,email,photo FROM users JOIN usercourses on user_id = users.email WHERE usercourses.role="Student" and course_id='.$course.' and usercourses.group_name is NULL';

                $dbc->execute_query($query);
                $result = $dbc->fetch_array();
                $rows = sizeof($result);
				if(isset($result)){
					$fieldname = array_keys($result[0]);
				}
				$cards = '';
                if($result){ 

                    for($i = 0; $i<$rows;$i++){                      
                        $cards= $cards.'<div class="card" draggable="true" id='.$result[$i][$fieldname[1]]
                                .'><div class="id-image"><img class="small-pic" src='.$result[$i][$fieldname[2]]
                                .'></div><a href=""><span class="id-infor">'.$result[$i][$fieldname[0]].'<br/>'.$result[$i][$fieldname[1]].'</span></a></div>';
                    }
					$dbc->disconnect();
						
					echo $cards;
                }else{
                    echo "No students to add.";
					$dbc->disconnect();
                }  
           // }
 ?>