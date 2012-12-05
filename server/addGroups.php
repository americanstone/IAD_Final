<?php
include("DBconnect.php");
$course = $_REQUEST['course'];
$groups = json_decode($_REQUEST['groups'],true);


$dbc = new DBconnect();
$dbc->connect();

//delete group information from table usercourses
$cleanQuery = "update usercourses set group_name = null where course_id ='$course' ";
$dbc->execute_query($cleanQuery);

//delete group from table groups
$cleanQuery = "delete from groups where course_id ='$course'";
$dbc->execute_query($cleanQuery);


for($i=0; $i<sizeof($groups);$i++){
    //insert into table groups
    $groupName = $groups[$i]['id'];
    $query = "insert into groups(name, course_id) values('$groupName', '$course')";
    $dbc->execute_query($query);
    
    //update table usercourses
    for($j=0; $j < sizeof($groups[$i]['member']);$j++){
        $member = $groups[$i]['member'][$j]['email'];
        $query = "update usercourses set group_name = '$groupName' where course_id = '$course' and user_id='$member'";
       // print($query);
        $dbc->execute_query($query);
    }
}

?>