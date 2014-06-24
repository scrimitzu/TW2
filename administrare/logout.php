<?php 
session_start();
if(true === session_unregister('cppassnelo')) :
   session_destroy();
   sleep(3);
   header('Location: index.php');
else :
   unset($_SESSION['cppassnelo']);
   session_destroy();
   sleep(3);
   header('Location: index.php');
endif;
?> 