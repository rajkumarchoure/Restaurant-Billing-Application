<?php 
session_start();
if(isset($_SESSION['usertype']) && $_SESSION['usertype'] != "" && isset($_SESSION['userid']) && $_SESSION['userid'] != "")
	{
		include("config.php");
		$conn = new Connection();	
		include_once("lib/dboperation.php");
		include_once("lib/getval.php");
		$cmn = new Comman();
		$ipaddress = $cmn->get_client_ip();
		$loginid = $_SESSION['userid'];
		$createdby = $_SESSION['userid'];
		$usertype = $_SESSION['usertype'] ;
		$createdate = date('Y-m-d H:i:s');
		
	}
else
	echo "<script>location='../index.php?msg=invalid' </script>" ;

?>