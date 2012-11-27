<?php
	session_start();
	include("DBconnect.php");
	$action = $_REQUEST['action'];
	$file = $_REQUEST['file'];
	$line = $_REQUEST['line'];
	
	// create an DB connection
	$dbc = new DBconnect();
	$dbc->connect();
	
	if($action == 'add'){
		
		$issue = $_REQUEST['issue'];
		$solution = $_REQUEST['solution'];
		$severity = $_REQUEST['severity'];
		$category = $_REQUEST['category'];
		$raised_by = $_SESSION['email'];
		 
		$query = "INSERT INTO COMMENTS VALUES('$issue', '$solution', $severity, '$category', '$file', $line, '$raised_by')";
		$dbc->execute_query($query);
	} 
	else if ($action == 'list'){
		$query = "SELECT ISSUE, SOLUTION, SEVERITY, CATEGORY, RAISED_BY FROM COMMENTS WHERE FILENAME = '$file' AND LINE = $line";
		$dbc->execute_query($query);
		$result = $dbc->fetch_array();
		
		if($result){
			$comments = Array();
			for($i = 0; $i < sizeof($result); $i++){
				$comment = array('issue'=>$result[$i]['ISSUE'], 'solution'=>$result[$i]['SOLUTION'], 'severity'=>$result[$i]['SEVERITY'], 'category'=>$result[$i]['CATEGORY'], 'author'=>$result[$i]['RAISED_BY']);
				$comments[$i] = $comment;
			}
			echo json_encode($comments);
		}
		
	}
	else if ($action == 'lsall'){
		$query = "SELECT DISTINCT(LINE) LINE FROM COMMENTS WHERE FILENAME = '$file' ORDER BY LINE";
		$dbc->execute_query($query);
		$result = $dbc->fetch_array();
		$comments = Array();
		for($i = 0; $i < sizeof($result); $i++){
			$comments[$i] = $result[$i]['LINE'];
		}
		echo json_encode($comments);
	
		
	}
?>