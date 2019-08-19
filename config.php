<?php
date_default_timezone_set('Asia/Kolkata');
class Connection {
	
	function __construct(){
		//database configuration
		if($_SERVER["SERVER_NAME"]=="localhost")
		{
			$host_name="localhost";
			$db_name="resto";
			$db_user="root";
			$db_pwd="";
		}
		else
		{
			$host_name="";
			$db_name="";
			$db_user="";
			$db_pwd="";
			
		}
		
		//connect databse
		$database_link_for_connection=mysql_connect("$host_name","$db_user","$db_pwd");
		
		if(!$database_link_for_connection){
			die("Failed to connect ");
		}else{
			mysql_select_db("$db_name",$database_link_for_connection);
			//echo "connected";
		}
	}
}
//$conn = new Connection();	
?>
