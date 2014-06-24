<?php
define("MYSQL_SERVER", "localhost");
define("MYSQL_USER", "root");
define("MYSQL_PASSWORD", "");
define("MYSQL_DATABASE", "altceva");

mysql_connect(MYSQL_SERVER,MYSQL_USER,MYSQL_PASSWORD) or die ('Nu pot sa ma connectez la baza de date 1: ' . mysql_error());
mysql_select_db(MYSQL_DATABASE) or die ('Nu pot sa ma conectez la baza de date 2: ' . mysql_error());
?>