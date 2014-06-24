<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");	
include("setari/ajaxprocess.class.php");	
$ajaxProc = new ajaxProcessor();

switch($ajaxProc->actionCode){
	case "1": 
		$ajaxProc->getBookingStatus(); 
		break;
		
	case "2": 
		$ajaxProc->getCustomerDetails();
		break;
		
	case "3": 
		$ajaxProc->sendContactMessage();
		break;
		
	case "4":
		$ajaxProc->applyCouponDiscount();
		break;
		
	default:
		$ajaxProc->sendErrorMsg();
}
?>