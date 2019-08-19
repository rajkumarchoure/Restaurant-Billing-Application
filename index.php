<?php
$message = "" ;
if(isset($_GET['msg']))
{
	$msg = $_GET['msg'];
	
	if($msg == 'error')
		$message = "<div class='alert alert-error'><button data-dismiss='alert' class='close' type='button'>×</button>Wrong User Id or Password</div>"  ;
	if($msg == 'blank')
		$message = "<div class='alert alert-info'><button data-dismiss='alert' class='close' type='button'>×</button>User Id & Password Should not blank</div>" ;
	if($msg == 'invalid')
		$message ="<div class='alert alert-error'><button data-dismiss='alert' class='close' type='button'>×</button>Invalid User login</div>" ;
		if($msg == 'logout')
		$message = "<div class='alert alert-success'><button data-dismiss='alert' class='close' type='button'>×</button>Successfully Logged Out !!</div>" ;
	
}

?>
<!DOCTYPE html>


<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>TriSol</title>
<link rel="stylesheet" href="css/style.default.css" type="text/css" />
<script type="text/javascript" src="js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="js/jquery-migrate-1.1.1.min.js"></script>
<script src="lib/commonfun.js"></script>
<script type="text/javascript" src="js/custom.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/jquery.cookie.js"></script>
<script type="text/javascript" src="js/modernizr.min.js"></script>
<script type="text/javascript" src="js/detectizr.min.js"></script>
</head>

<body class="loginbody">

<div class="loginwrapper">
	<div class="loginwrap zindex100 animate2 bounceInDown">
	<h1 class="logintitle"><span class="iconfa-lock"></span> Sign In <span class="subtitle">&nbsp;</span></h1>
        <div class="loginwrapperinner">
        <?php if($message != "")
		{echo $message;
		}?>
            <form id="loginform" action="checklogin.php" method="post">
                <p class="animate4 bounceIn"><input type="text" id="admin_name" name="admin_name"  placeholder="Username" autocomplete="off" autofocus /></p>
                <p class="animate5 bounceIn"><input type="password" id="admin_pwd" name="admin_pwd" placeholder="Password" autocomplete="off" /></p>
                <p class="animate6 bounceIn">
              
                <input type="submit" name="login" onClick="return checkinputmaster('admin_name,admin_pwd')" class="btn btn-default btn-block" value="Sign IN">
                </p>
               <!-- <p class="animate7 fadeIn"><a href="#"><span class="icon-question-sign icon-white"></span> Forgot Password?</a></p>-->
            </form>
        </div><!--loginwrapperinner-->
    </div>
    <div class="loginshadow animate3 fadeInUp"></div>
</div><!--loginwrapper-->

<script type="text/javascript">
jQuery.noConflict();

jQuery(document).ready(function(){
	
	var anievent = (jQuery.browser.webkit)? 'webkitAnimationEnd' : 'animationend';
	jQuery('.loginwrap').bind(anievent,function(){
		jQuery(this).removeClass('animate2 bounceInDown');
	});
	
	jQuery('#admin_name,#password').focus(function(){
		if(jQuery(this).hasClass('error')) jQuery(this).removeClass('error');
	});
	
	jQuery('#loginform button').click(function(){
		if(!jQuery.browser.msie) {
			if(jQuery('#admin_name').val() == '' || jQuery('#password').val() == '') {
				if(jQuery('#admin_name').val() == '') jQuery('#admin_name').addClass('error'); else jQuery('#admin_name').removeClass('error');
				if(jQuery('#password').val() == '') jQuery('#password').addClass('error'); else jQuery('#password').removeClass('error');
				jQuery('.loginwrap').addClass('animate0 wobble').bind(anievent,function(){
					jQuery(this).removeClass('animate0 wobble');
				});
			} else {
				jQuery('.loginwrapper').addClass('animate0 fadeOutUp').bind(anievent,function(){
					jQuery('#loginform').submit();
				});
			}
			return false;
		}
	});
});
</script>
</body>


</html>
