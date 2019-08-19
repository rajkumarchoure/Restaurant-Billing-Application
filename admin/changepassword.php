<?php include("../adminsession.php");
$crit=" where loginid='$loginid' and type='$type'";
$pagename = "changepassword.php";
$module = "Change Password";
$submodule = "Change Password";

if(isset($_GET['action']))
$action = addslashes(trim($_GET['action']));
else
$action = "";
if(isset($_POST['sub']))
{
	$oldpass=$_POST['oldpass'];
	$newpass=$_POST['newpass'];
	$confirmpass=$_POST['confirmpass'];
	$loginid=$_SESSION['userid'];
	
	$sqlforcheck = "select * from user where password = '$oldpass' and userid ='$loginid'";
	$resforcheck = mysql_query($sqlforcheck);
	$cnt_check = mysql_num_rows($resforcheck);
	if($cnt_check != 0)
	{
		if($newpass == $confirmpass)
		{
			$sql="update user set password = '$newpass' where userid= '$loginid'";
			mysql_query($sql);
			$action=2;
			$cmn->InsertLog($pagename, "Profile Setting", "Change Password", "m_users", "userid", $loginid, "Changed Password");
			echo "<script>location='$pagename?action=$action'</script>";
		}
		else
		echo "Password Not Matched";
	}
	else
	echo "<script>alert('Wrong Password')</script>";
	
echo "<script>
closeframe();
function closeframe()
{
parent.location='changepassword.php';
parent.jQuery.fancybox.close()
}
</script>";
}
?>
<!DOCTYPE html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php include("inc/top_files.php"); ?>

<style type="text/css">
.fancybox-custom .fancybox-skin {
box-shadow: 0 0 50px #222;
}
</style>
<!--- fancy box code end here -->
<style>
.CSSTableGenerator {
	margin:0px;padding:0px;
	width:100%;
	box-shadow: 0px 0px 0px #888888;
	border:1px solid #000000;
	
	-moz-border-radius-bottomleft:13px;
	-webkit-border-bottom-left-radius:13px;
	border-bottom-left-radius:13px;
	
	-moz-border-radius-bottomright:13px;
	-webkit-border-bottom-right-radius:13px;
	border-bottom-right-radius:13px;
	
	-moz-border-radius-topright:13px;
	-webkit-border-top-right-radius:13px;
	border-top-right-radius:13px;
	
	-moz-border-radius-topleft:13px;
	-webkit-border-top-left-radius:13px;
	border-top-left-radius:13px;
}.CSSTableGenerator table{
	width:100%;
	height:100%;
	margin:0px;padding:0px;
}.CSSTableGenerator tr:last-child td:last-child {
	-moz-border-radius-bottomright:13px;
	-webkit-border-bottom-right-radius:13px;
	border-bottom-right-radius:13px;
}
.CSSTableGenerator table tr:first-child td:first-child {
	-moz-border-radius-topleft:13px;
	-webkit-border-top-left-radius:13px;
	border-top-left-radius:13px;
}
.CSSTableGenerator table tr:first-child td:last-child {
	-moz-border-radius-topright:13px;
	-webkit-border-top-right-radius:13px;
	border-top-right-radius:13px;
}.CSSTableGenerator tr:last-child td:first-child{
	-moz-border-radius-bottomleft:13px;
	-webkit-border-bottom-left-radius:13px;
	border-bottom-left-radius:13px;
}.CSSTableGenerator tr:hover td{
	
}
.CSSTableGenerator tr:nth-child(odd){ background-color:#e5e5e5; }
.CSSTableGenerator tr:nth-child(even)    { background-color:#ffffff; }.CSSTableGenerator td{
	vertical-align:middle;
	
	
	border:1px solid #000000;
	border-width:0px 1px 1px 0px;
	text-align:left;
	padding:7px;
	font-size:13px;
	font-family:Arial;
	font-weight:normal;
	color:#000000;
}.CSSTableGenerator tr:last-child td{
	border-width:0px 1px 0px 0px;
}.CSSTableGenerator tr td:last-child{
	border-width:0px 0px 1px 0px;
}.CSSTableGenerator tr:last-child td:last-child{
	border-width:0px 0px 0px 0px;
}
.CSSTableGenerator tr:first-child td{
		background:-o-linear-gradient(bottom, #cccccc 5%, #b2b2b2 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cccccc), color-stop(1, #b2b2b2) );
	background:-moz-linear-gradient( center top, #cccccc 5%, #b2b2b2 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#cccccc", endColorstr="#b2b2b2");	background: -o-linear-gradient(top,#cccccc,b2b2b2);

	background-color:#cccccc;
	border:0px solid #000000;
	text-align:center;
	border-width:0px 0px 1px 1px;
	font-size:14px;
	font-family:Arial;
	font-weight:bold;
	color:#000000;
}
.CSSTableGenerator tr:first-child:hover td{
	background:-o-linear-gradient(bottom, #cccccc 5%, #b2b2b2 100%);	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #cccccc), color-stop(1, #b2b2b2) );
	background:-moz-linear-gradient( center top, #cccccc 5%, #b2b2b2 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr="#cccccc", endColorstr="#b2b2b2");	background: -o-linear-gradient(top,#cccccc,b2b2b2);

	background-color:#cccccc;
}
.CSSTableGenerator tr:first-child td:first-child{
	border-width:0px 0px 1px 0px;
}
.CSSTableGenerator tr:first-child td:last-child{
	border-width:0px 0px 1px 1px;
}
</style>
<style type="text/css">
.styled-button-8 {
	background:#25A6E1;
	background:-moz-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:-webkit-gradient(linear,left top,left bottom,color-stop(0%,#25A6E1),color-stop(100%,#188BC0));
	background:-webkit-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:-o-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:-ms-linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	background:linear-gradient(top,#25A6E1 0%,#188BC0 100%);
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#25A6E1',endColorstr='#188BC0',GradientType=0);
	padding:8px 13px;
	color:#fff;
	font-family:'Helvetica Neue',sans-serif;
	font-size:17px;
	border-radius:4px;
	-moz-border-radius:4px;
	-webkit-border-radius:4px;
	border:1px solid #1A87B9
}
</style>
<script>
function checkOldPass()
{
	var oldpass=document.getElementById("oldpass").value;
	if(navigator.appName=="Microsoft Internet Explorer")
	obj3=new ActiveXObject("Msxml2.XMLHTTP");
	else
	obj3=new XMLHttpRequest()
	obj3.open("post","check_old_pass.php?" + oldpass,true);
	obj3.send(null)
	obj3.onreadystatechange=function()
	{
		if(obj3.readyState==4)
		{
			var idname = obj3.responseText;
			//alert(idname);
			//document.getElementById('msg').value = idname;
			document.getElementById('msg1').innerHTML = idname;
		}
	}
	
}

function checkPassEqual()
{
	var newpass=document.getElementById("newpass").value;
	var confirmpass=document.getElementById("confirmpass").value;
	//alert(newpass);
	//alert(confirmpass);
	if(newpass != "" && confirmpass !="")
	{
		if(newpass == confirmpass)
		document.getElementById('msg2').innerHTML = "Password matched";
		else
		document.getElementById('msg2').innerHTML = "Password not matched";
	}
}
</script>
<!-- YKB Validation js file inclusion at belowe file name is --->
    <script src="../lib/commonfun.js" type="text/javascript"></script>
<!-- YKB Validation js file inclusion --->


</head>

<body>
<div class="mainwrapper">
	
    <!-- START OF LEFT PANEL -->
    <?php include("inc/left_menu.php"); ?>
    
    <!--mainleft-->
    <!-- END OF LEFT PANEL -->
    
    <!-- START OF RIGHT PANEL -->
    
   <div class="rightpanel">
    	<?php include("inc/header.php"); ?>
        
        <div class="maincontent">
        	<div class="contentinner">
             <?php include("../include/alerts.php"); ?>
            	<!--widgetcontent-->        
                <div class="widgetcontent  shadowed nopadding">
                    <form action="" method="post">
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="CSSTableGenerator">
  <tr>
    <td height="51" colspan="3" align="center"><h3>Change Admin Password&nbsp;&nbsp;&nbsp;<span style="font-size:10px;color:#C00;">(Mandatory fields are marked with red astrick)</span></h3></td>
  </tr>
  <tr>
    <td width="33%" height="56" align="center">Old Password<span style="color:#C03;font-size:20px">*</span></td>
    <td width="18%" align="center"><input type="text" name="oldpass" id="oldpass" autocomplete="off" onChange="checkOldPass()"/></td> 
    <td width="49%" id="msg1" align="center"></td>
  </tr>
  <tr>
    <td height="54" align="center">New Password<span style="color:#C03;font-size:20px">*</span></td>
    <td align="center"><input type="password" name="newpass" id="newpass" autocomplete="off" onKeyUp="checkPassEqual()"/></td>
    <td align="center">&nbsp;</td>
  </tr>
  <tr>
    <td height="40" align="center">Confirm Password<span style="color:#C03;font-size:20px">*</span></td>
    <td align="center"><input type="password" name="confirmpass" id="confirmpass" autocomplete="off" onKeyUp="checkPassEqual()" /></td>
    <td id="msg2" align="center"></td>
 </tr>
   <tr>
    <td height="44" align="center">&nbsp;</td>
    <td align="center"><input type="submit" value="Change" name="sub" class="styled-button-8" onClick="return checkinputmaster('oldpass,newpass,confirmpass')"></td>
    <td align="center">&nbsp;</td>
  </tr>
</table>
</form>
                    </div>
                   
            </div><!--contentinner-->
        </div><!--maincontent-->
        
   
        
    </div>
    <!--mainright-->
    <!-- END OF RIGHT PANEL -->
    
    <div class="clearfix"></div>
     <?php include("inc/footer.php"); ?>
    <!--footer-->  
</div>
</body>
</html>