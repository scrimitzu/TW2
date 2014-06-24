<?php
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: rezervare-esuata.php?error_code=9');
}
	session_start();
	include("setari/db.conn.php");
	include("setari/conf.class.php");
	$row_default_lang=mysql_fetch_assoc(mysql_query("select * from nelo_language where `lang_default`=true"));
	include("global/".$row_default_lang['lang_file']);
	include("setari/mail.class.php");
   
    $booking_id = mysql_real_escape_string($_POST['bookingid']);
	$emailBody  = '';
	
    $invoiceROWS= mysql_fetch_assoc(mysql_query("SELECT client_name, client_email, invoice FROM nelo_facturare WHERE booking_id='".$booking_id."'"));
	$ccArray    = array();
	$neloMail    = new neloMail();	
	$emailContent=$neloMail->loadEmailContent();
	$subject    = $emailContent['subject'];
	$emailBody .= "Dear ".$invoiceROWS['client_name'].",<br><br>";
	$emailBody .= $emailContent['body'];
	$emailBody .= $invoiceROWS['invoice'];
				
	$cardnum        = $_POST['CardNumber'];
	$DETINATOR_CARD_name = $_POST['DETINATOR_CARD_name'];
	$CardType       = $_POST['CardType'];
	$cc_exp_dt      = $_POST['cc_exp_dt'];
	$cc_ccv         = $_POST['cc_ccv'];
	$cardnum_enc    = $neloCore->encryptCard(mysql_real_escape_string($_POST['CardNumber']));
	$cardno_len=strlen($cardnum)-4;
	$creditcard_no=substr($cardnum,$cardno_len);
	$star='';
	for($i=0;$i<$cardno_len;$i++){ $star.='#';}
	$show_cardno=$star.$creditcard_no;
	
	$payoptions = "Credit Card";
	$table      = '<br /><table  style="font-family:Verdana, Geneva, sans-serif; font-size: 12px; background:#999999; width:700px; border:none;" cellpadding="4" cellspacing="1"><tr><td align="left" colspan="2" style="font-weight:bold; font-variant:small-caps; background:#eeeeee;">'.mysql_real_escape_string(TEXT_DETALII_PLATA_A).'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps;background:#ffffff;">'.mysql_real_escape_string(TEXT_OPTIUNI_PLATA_A).'</td><td align="left" style="background:#ffffff;">'.$payoptions.'</td></tr><tr><td align="left" width="30%" style="font-weight:bold; font-variant:small-caps;background:#ffffff;">'.mysql_real_escape_string(CC_NUMBER).'</td><td align="left" style="background:#ffffff;">'.$show_cardno.'</td></tr></table>';
	$updatedInvoice=$invoiceROWS['invoice'].$table;
	mysql_query("Update nelo_facturare SET invoice='$updatedInvoice' WHERE booking_id='".$booking_id."'");				
	mysql_query("insert into nelo_informatii_cc(booking_id, cardholder_name, card_type, card_number, expiry_date, ccv2_no) values('".mysql_real_escape_string($_POST['bookingid'])."', '".mysql_real_escape_string($_POST['DETINATOR_CARD_name'])."', '".mysql_real_escape_string($_POST['CardType'])."', '".$cardnum_enc."', '".mysql_real_escape_string($_POST['cc_exp_dt'])."', '".mysql_real_escape_string($_POST['cc_ccv'])."')");
	
	$emailBody .= $table;
	
	
	$emailBody .= '<br><br>'.mysql_real_escape_string(A_STIMA).',<br>'.$neloCore->config['conf_hotel_name'].'<br>'.$neloCore->config['conf_hotel_phone'];
	$emailBody .= '<br><br><font style=\"color:#F00; font-size:10px;\">[ '.mysql_real_escape_string(A_CAR).' ]</font>';		
		
	$returnMsg = $neloMail->sendEMail($invoiceROWS['client_email'],$subject, $emailBody);
	if ($returnMsg == true) {
	    mysql_query("update nelo_rezervari set payment_success=true where booking_id=".$booking_id);
			
		$notifyEmailSubject = "Booking no.".$_POST['bookingid']." - Notification of Room Booking by ".$invoiceROWS['client_name'];				
		$notifynMsg = $neloMail->sendEMail($neloCore->config['conf_notification_email'], $notifyEmailSubject, $invoiceROWS['invoice']);
		header('Location: rezervare-succes.php?success_code=1');
		die; 
	}else {
		header('Location: rezervare-esuata.php?error_code=25');
		die;
	}		
?>