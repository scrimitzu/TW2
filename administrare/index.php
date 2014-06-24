<?php
session_start(); 
include("../setari/db.conn.php");
//******************************************
$sql_lang_select=mysql_query("select * from nelo_language order by lang_title");
$lang_dd='';
while($row_lang_select=mysql_fetch_assoc($sql_lang_select)){
	if($row_lang_select['lang_default']==true)
	$lang_dd.='<option value="'.$row_lang_select['lang_code'].'" selected="selected">'.$row_lang_select['lang_title'].'</option>';
	else
	$lang_dd.='<option value="'.$row_lang_select['lang_code'].'">'.$row_lang_select['lang_title'].'</option>';
}
//******************************************
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>neLo - Administrare</title>
<link rel="stylesheet" href="css/login.css" type="text/css" media="screen" />
<!--  jquery core -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript">
<!-- Custom jquery scripts -->
// 2 - START LOGIN PAGE SHOW HIDE BETWEEN LOGIN AND FORGOT PASSWORD BOXES--------------------------------------
$(document).ready(function () {
	$(".forgot-pwd").click(function () {
	$("#loginbox").hide();
	$("#forgotbox").show();
	return false;
	});
	<?php
	if(isset($_SESSION['msg']) && $_SESSION['msg'] == "RESET"){
		echo '$("#loginbox").hide();
		      $("#forgotbox").show();';
	    $div = '<div id="forgotbox-text">Parola a fost resetata. Verificati mailul pentru a schimba parola</div>';
	}else{
		$div = '<div id="forgotbox-text">Introduceti adresa de e-mail si veti primi parola prin mail.</div>';
	}
	?>
});
$(document).ready(function () {
	$(".back-login").click(function () {
	$("#loginbox").show();
	$("#forgotbox").hide();
	return false;
	});
});
// END ----------------------------- 2
</script>
</head>
<body id="login-bg">
<br />
<br />
<br />
<br />
<h2 align="center" style="font-family:Verdana, Geneva, sans-serif; font-size:28px; color:#FFF;">neLo - Administrare</h2>
<!-- Start: login-holder -->
<div id="login-holder">
<div class="clear"></div>
<!--  start loginbox ................................................................................. -->
<div id="loginbox"> 
 
 <!--  start login-inner -->
 
 <div id="login-inner">
  <form action="authenticate.php" method="post" id="formlogin">
   <table border="0" cellpadding="5" cellspacing="0">
    <?php
		if(isset($_SESSION['msglog']) && $_SESSION['msglog']){
			echo '<tr style="font-size:13px; color:#F00;"><th colspan="2" style="padding-left:40px;">'.$_SESSION['msglog'].'</th></tr>';
			unset($_SESSION['msglog']);
		}else{
			echo '<tr style="font-size:13px; color:#F00;"><th colspan="2" valign="top">&nbsp;</th></tr>';
		}
		?>
    <tr>
     <th>User</th>
     <td><input type="text" name="username" id="username" class="login-inp"  /></td>
    </tr>
    <tr>
     <th>Parola</th>
     <td><input type="password" name="password"  id="password"   class="login-inp" /></td>
    </tr>
    <tr>
     <th colspan="2">&nbsp;</th>
    </tr>
    <tr>
     <th><input type="hidden" name="loginform" value="1" /></th>
     <td><input type="submit" class="submit-login" id="submit-login" value="Login" /></td>
    </tr>
   </table>
  </form>
 </div>
 
 <!--  end login-inner -->
 
 <div class="clear"></div>
 <a href="" class="forgot-pwd">Ai uitat parola?</a> </div>
<!--  end loginbox --> 
<!--  start forgotbox ................................................................................... -->
<div id="forgotbox">
<?=$div?>
<!--start forgot-inner-->
<form id="formElem" name="formElem" action="authenticate.php" method="post">
<div id="forgot-inner">
 <table border="0" cellpadding="0" cellspacing="0">
  <tr>
   <th>Adresa de email:</th>
   <td><input type="text" value="" name="emailid" class="login-inp" /></td>
  </tr>
  <tr>
   <th><input type="hidden" name="loginform" value="2" /></th>
   <td><input type="submit" class="submit-login" id="submit-forgot"  /></td>
  </tr>
 </table>
</div>
<form>
<!--  end forgot-inner -->
<div class="clear"></div>
<a href="" class="back-login">Inapoi la login</a>
</div>
<!--  end forgotbox -->
</div>
<!-- End: login-holder --> 
<script type="text/javascript">
	$().ready(function() {
		 $('#submit-login').click(function() { 		
			if($('#username').val()==""){
				alert('Va rugam introduceti userul.');
				return false;
			}else if($('#password').val()==""){
				alert('Va rugam introduceti parola.');
				return false;
			} else {
				return true;
			}	  
		});	
	});      
</script>
</body>
</html>