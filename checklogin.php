<?php
session_start();
include("config.php");
$conn = new Connection();
include("lib/dboperation.php");
include_once("lib/getval.php");
$cmn = new Comman();
$ipaddress = $cmn->get_client_ip();

//echo $_POST['login'];die;
if(isset($_POST['login']))
{
	
	$admin_name = test_input($_POST['admin_name']);	
	$admin_pwd = test_input($_POST['admin_pwd']);
	$createdate = date('Y-m-d');
	//$admin_pwd =encrypt($admin_pwd,"trinitysolutions");
	if($admin_name != "" && $admin_pwd != "" )
	{
		//echo "hii" ;
		//echo "select * from m_user where username='$admin_name' and password='$admin_pwd'";die;
		$res = mysql_query("select * from user where username='$admin_name' and password='$admin_pwd'");
		$count = mysql_num_rows($res);
		
		if($count == 1)
		{
			$login_fetch = mysql_fetch_assoc($res);
			$_SESSION['userid'] = $login_fetch['userid'];
			$_SESSION['usertype'] = $login_fetch['usertype'];
			
			mysql_query("insert into loginlogoutreport set userid ='$_SESSION[userid]',usertype = '$_SESSION[usertype]', process = 'Login', loginlogouttime = now(), createdate = '$createdate', ipaddress = '$ipaddress'");
			echo "<script>location='admin/index.php' </script>" ;
		}
		else
		echo "<script>location='index.php?msg=error' </script>" ;
	}
	echo "<script>location='index.php?msg=blank' </script>" ;
}

?>