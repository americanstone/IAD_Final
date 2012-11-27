<?php

class DBconnect
{	
	private $dbhost = "localhost";
	private	$dbuser = "root";
	private	$dbpass = "zhu88jie";
	private	$dbname = "sbls";
	private $dbconnect;
	private $dbresult;
	
	// connect to Mysql and select a db
	public function connect() {
	
		if(!$this->dbconnect = mysql_connect($this->dbhost, $this->dbuser, $this->dbpass)) {
			echo "Connection failed to the host ".$this->dbhost;
			exit;
		}
		if (!mysql_select_db($this->dbname)) {
			echo "Cannot connect to database ".$this->dbname;
			exit;
		}
	}
	
	// execute a query
	public function execute_query($dbquery){
		
		if(!isset($this->dbconnect)) {
			connect();
		}
		if (!$this->dbresult = mysql_query($dbquery)) {
			echo "Failed to execute query ". $dbquery;
			exit;
		}
	}
	
	// fetch raw data
	public function fetch_array() {
            
                $query_result = null;
		if(isset($this->dbresult)) {
			$i = 0;
			while ($row = mysql_fetch_assoc($this->dbresult)) {
				if ($row) {
					foreach ($row as $fieldname => $fieldvalue)
						$query_result[$i][$fieldname] = $fieldvalue;
				}
				$i++;
			}
		}
		return $query_result;
	}
	
	// disconnect
	public function disconnect() {
		
		// free the resources associated with the $dbresult		
		if(isset($this->dbresult)) {
			mysql_free_result($this->dbresult);
		}
		// close the connection
		if(isset($this->dbconnect)) {
			mysql_close($this->dbconnect);
		}
	}
	
	
}


?>