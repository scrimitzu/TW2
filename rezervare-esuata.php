<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");
include("setari_traduceri.php");
if(isset($_REQUEST["error_code"]))
$errorCode = $neloCore->ClearInput($_REQUEST["error_code"]);
else
$errorCode=9;
$erroMessage = array(); 
$erroMsg[9] = TEXT_EROARE_REZERVARE_1;
$erroMsg[13] = TEXT_EROARE_REZERVARE_2;
$erroMsg[22] = TEXT_EROARE_REZERVARE_3;
$erroMsg[25] = TEXT_EROARE_REZERVARE_4;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Rezervare Esuata</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
</head>
<body>
<div id="content" align="center">
  <h1><?=$neloCore->config['conf_hotel_name']?></h1>
   <div id="wrapper" style="width:400px !important; height:200px;">
   <h2 align="left" style="padding-left:5px;"><?=TEXT_REZERVARE_ESUATA?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/><br /><br />
    <span style="color: #D00;"><?=$erroMsg[$errorCode]?></span>
  </div>
</div>
</body>
</html>