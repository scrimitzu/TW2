<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");
$row_default_lang=mysql_fetch_assoc(mysql_query("select * from nelo_language where `lang_default`=true"));
include("global/".$row_default_lang['lang_file']);

$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: rezervare-esuata.php?error_code=9');
}
include("setari/mail.class.php");
include("setari/process.class.php");
$bookprs = new BookingProcess();
switch($bookprs->paymentGatewayCode){	
	case "poa":
		processPayOnArrival();
		break;
		
	case "pp": 		
		processPayPal();
		break;	
					
	case "cc":
		processCreditCard();
		break;			
		
	default:
		processOther();
}
/* PAY ON ARIVAL: MANUAL PAYMENT */	
function processPayOnArrival(){	
	global $bookprs;
	global $neloCore;
	$neloMail = new neloMail();
	$emailContent=$neloMail->loadEmailContent();
	$subject    = $emailContent['subject'];
	
	mysql_query("UPDATE nelo_rezervari SET payment_success=true WHERE booking_id = ".$bookprs->bookingId);
	mysql_query("UPDATE nelo_clienti SET existing_client = 1 WHERE email = '".$bookprs->clientEmail."'");		
			
	$emailBody  = "Dear ".$bookprs->clientName.",<br><br>";
	$emailBody .= $emailContent['body']."<br><br>";
	$emailBody .= $bookprs->invoiceHtml;
	$emailBody .= '<br><br>'.mysql_real_escape_string(A_STIMA).',<br>'.$neloCore->config['conf_hotel_name'].'<br>'.$neloCore->config['conf_hotel_phone'];
	$emailBody .= '<br><br><font style=\"color:#F00; font-size:10px;\">[ '.mysql_real_escape_string(A_CAR).' ]</font>';	
				
	$returnMsg = $neloMail->sendEMail($bookprs->clientEmail, $subject, $emailBody);
	
	if ($returnMsg == true) {		
		
		$notifyEmailSubject = "Booking no.".$bookprs->bookingId." - Notification of Room Booking by ".$bookprs->clientName;				
		$notifynMsg = $neloMail->sendEMail($neloCore->config['conf_hotel_email'], $notifyEmailSubject, $bookprs->invoiceHtml);
		
		header('Location: rezervare-succes.php?success_code=1');
		die;
	}else {
		header('Location: rezervare-esuata.php?error_code=25');
		die;
	}	
	//header('Location: rezervare-succes.php?success_code=1');
}
/* PAYPAL PAYMENT */ 
function processPayPal(){
	global $bookprs;
	
	echo "<script language=\"JavaScript\">";
	echo "document.write('<form action=\"paypal.php\" method=\"post\" name=\"formpaypal\">');";
	echo "document.write('<input type=\"hidden\" name=\"amount\"  value=\"".number_format($bookprs->totalPaymentAmount, 2, '.', '')."\">');";
	echo "document.write('<input type=\"hidden\" name=\"invoice\"  value=\"".$bookprs->bookingId."\">');";
	echo "document.write('</form>');";
	echo "setTimeout(\"document.formpaypal.submit()\",500);";
	echo "</script>";	
}
/* CREDIT CARD PAYMENT */
function processCreditCard(){
	global $bookprs;
	global $neloCore;	
	$paymentAmount = number_format($bookprs->totalPaymentAmount, 2, '.', '');
	
	echo "<script language=\"javascript\">";
	echo "document.write('<form action=\"offlinecc-payment.php\" method=\"post\" name=\"form2checkout\">');";
	echo "document.write('<input type=\"hidden\" name=\"x_invoice_num\" value=\"".$bookprs->bookingId."\"/>');";
	echo "document.write('<input type=\"hidden\" name=\"total\" value=\"".$paymentAmount."\">');"; 
	echo "document.write('</form>');";
	echo "setTimeout(\"document.form2checkout.submit()\",500);";
	echo "</script>";
}
/* OTHER PAYMENT */
function processOther(){
	/* not implemented yet */
	header('Location: rezervare-esuata.php?error_code=22');
	die;
}
?>