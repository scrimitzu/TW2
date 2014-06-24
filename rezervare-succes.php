<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");
include("setari_traduceri.php");
session_destroy();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?=$neloCore->config['conf_hotel_name']?></title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
</head>
<body>
<div id="content" align="center">
  <h1><?=$neloCore->config['conf_hotel_name']?></h1>
  <div id="wrapper" style="width:400px !important; height:200px;">
   <h2 align="left" style="padding-left:5px;"><?=TEXT_REZERVARE_FINALIZATA?></h2>
    <hr color="#e1dada"  style="margin-top:3px;"/><br /><br />
    <h4><?=TEXT_MULTUMESC?>!</h4><br /><?=TEXT_REZERVARE_EFECTUTA_SUCCESS?>. <?=TEXT_FACUTA_TRIMISA?>.
	&nbsp;
	<h4>Puteti sa va intoarceti <a href="http://localhost/altceva/index.php">pe prima pagina.</h4>
  </div>
</div>
</body>
</html>