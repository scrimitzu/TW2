<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");
include("setari_traduceri.php");
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if(!$pos2){
	header('Location: rezervare-esuata.php?error_code=9');
}
include("setari/details.class.php");
$nelobooking = new neloDetaliiRezervari();
$neloCore->clearExpiredBookings();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name='keywords' content='neLo, online lodging, proiect tw, anul 2, info iasi, informatica iasi, proiect informatica, iasi, rezervari hotel, sistem de rezervari hotel'>
<meta name='description' content='Aplicatie al carei scop rezervarilor unei locatii de cazare (hotel, pensiune, cripta) intr-o anumita localitate. Utilizatorului i se va oferi posibilitatea selectarii perioadei, tipului de camera (single, double, triple) si a altor optiuni oferite: aer conditionat, balcon cu vedere la stana, masaj electric, facilitati pentru vampiri etc. Pe baza unei modalitati de afisare cat mai atractive, utilizatorii vor putea consulta starea curenta a ocuparii locatiei pe o perioada de timp aleasa. Se vor oferi si mijloace de administrare a informatiilor de cazare, inclusiv rezolvarea problemelor de tip overbooking.'>
<meta name='subject' content='Proiect Tehnologii Web'>
<meta name='language' content='RO'>
<meta name='owner' content='Facultatea de Informatica din Iasi'>
<meta name='copyright' content='Facultatea de Informatica din Iasi'>
<title>
Detaliile Rezervarii | neLo - Online Lodging
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<link href="css/continut.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.validate.js"></script>
<!--<script id="demo" type="text/javascript">
$(document).ready(function() {
	$("#form1").validate();		
});
</script>-->
<script type="text/javascript">
	$().ready(function() {
		$("#form1").validate();
    });        
</script>

</head>
<body>
<div id="wrapper_principal"><!-- Inceput Wrapper Principal -->

	<div id="logo_sus"><!-- Inceput Logo Sus -->
  		<a href="http://localhost/altceva"><img src="imagini/logo_sus.png" alt="neLo - Online Lodging" /></a>
  	</div><!-- Sfarist Logo Sus -->
    
    
    <div id="telefon_dr"><!-- Start of telefon_dr -->
    Informatii si rezervari: +40 748 952 120 <br /> rezervari (at) neLo.info.uaic.ro
    </div><!-- End of telefon_dr -->
    
    
    
    <div class="full_width"><!-- Start of full_width -->
    
   
    
    <div id="content">
  
  <div id="content" align="center">
 <h1>
  
 </h1>
 <?php $bookingDetails = $nelobooking->generateBookingDetails(); ?>
 <div id="wrapper" style="width:600px !important;">
  <h2 align="left" style="padding-left:5px;"><?=TEXT_REZERVARI_DETALII?></h2>
  <hr color="#e1dada"  style="margin-top:3px;"/>
  <br />
  <table cellpadding="4" cellspacing="1" border="0" width="100%" bgcolor="#FFFFFF" style="font-size:13px;">
   <tr>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TEXT_DATA_CHECK_IN?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TEXT_DATA_CHECK_OUT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TEXT_NUMAR_NOPTI?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TEXT_NUMAR_CAMERE?></strong></td>
   </tr>
   <tr>
    <td align="center" bgcolor="#f5f9f9"><?=$nelobooking->checkInDate?></td>
    <td align="center" bgcolor="#f5f9f9"><?=$nelobooking->checkOutDate?></td>
    <td align="center" bgcolor="#f5f9f9"><?=$nelobooking->numarNopti?></td>
    <td align="center" bgcolor="#f5f9f9"><?=$nelobooking->totalRoomCount?></td>
   </tr>
   <tr>
    <td bgcolor="#f2f2f2" align="center"><strong><?=NUMBER_OF_ROOM_TEXT?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TEXT_TIPUL_CAMEREI?></strong></td>
    <td bgcolor="#f2f2f2" align="center"><strong><?=TEXT_NUMAR_MAXIM_OCUPANTI?></strong></td>
    <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong><?=TEXT_TOTAL_BRUT?></strong></td>
   </tr>
   <?php		
		foreach($bookingDetails as $bookings){		
			echo '<tr>';
			echo '<td align="center" bgcolor="#f5f9f9">'.$bookings['roomno'].'</td>';
			echo '<td align="center" bgcolor="#f5f9f9">'.$bookings['roomtype'].' ('.$bookings['capacitytitle'].')</td>';				
			echo '<td align="center" bgcolor="#f5f9f9">'.$bookings['capacity'].' Adult</td>';
				
			echo '<td align="right" bgcolor="#f5f9f9" style="padding-right:5px;">'.$neloCore->config['conf_currency_symbol'].number_format($bookings['grosstotal'], 2 , '.', ',').'</td>';
			echo '</tr>';		
		}
	 ?>
   <tr>
    <td colspan="3" align="right" bgcolor="#f2f2f2"><strong><?=TEXT_SUBTOTAL?></strong></td>
    <td bgcolor="#f2f2f2" align="right" style="padding-right:5px;"><strong>
     <?=$neloCore->config['conf_currency_symbol']?><?=number_format($nelobooking->roomPrices['subtotal'], 2 , '.', ',')?>
     </strong></td>
   </tr>
   <?php
		if($neloCore->config['conf_tax_amount'] > 0 &&  $neloCore->config['conf_price_with_tax']==0){
			$taxtext=""; 
		?>
   <tr>
    <td colspan="3" align="right" bgcolor="#f5f9f9"><?=TEXT_TAXE?>
     
     (
     <?=$neloCore->config['conf_tax_amount']?>
     %)</td>
    <td align="right" bgcolor="#f5f9f9" style="padding-right:5px;"><span id="taxamountdisplay">
     <?=$neloCore->config['conf_currency_symbol']?><?=number_format($nelobooking->roomPrices['totaltax'], 2 , '.', ',')?>
     </span></td>
   </tr>
   <?php }else{
			$taxtext="(".TEXT_TAXE_FISCALE_INCLUSE.")";
		}
		?>
   <tr>
    <td colspan="3" align="right" bgcolor="#f2f2f2"><strong><?=TEXT_TOTAL_GENERAL?></strong>
     <?=$taxtext?></td>
    <td align="right" bgcolor="#f2f2f2" style="padding-right:5px;"><strong> <span id="grandtotaldisplay">
     <?=$neloCore->config['conf_currency_symbol']?><?=number_format($nelobooking->roomPrices['grandtotal'], 2 , '.', ',')?>
     </span></strong></td>
   </tr>
   <?php 
		if($neloCore->config['conf_enabled_deposit'] && ($nelobooking->depositPlans['deposit_percent'] > 0 && $nelobooking->depositPlans['deposit_percent'] < 100)){
		?>
   <tr id="advancepaymentdisplay">
    <td colspan="3" align="right" bgcolor="#f2f2f2"><strong></strong> <?=TEXT_PLATI_AVANSATE?>(<span style="font-size:11px;">
     <?=$nelobooking->depositPlans['deposit_percent']?>
     %<?=TEXT_DIN_TOTAL_PLATA?></span>)</td>
    <td align="right" bgcolor="#f2f2f2" style="padding-right:5px;"><span id="advancepaymentamount">
     <?=$neloCore->config['conf_currency_symbol']?><?=number_format($nelobooking->roomPrices['advanceamount'], 2 , '.', ',')?>
     </span></td>
   </tr>
   <?php
        }?>
  </table>
 </div>
 <br />
 <br />
 <div id="wrapper" style="width:600px !important;">
  <h2 align="left" style="padding-left:5px;"><?=TEXT_DETALII_CLIENT_I?></h2>
  <hr color="#e1dada"  style="margin-top:3px;"/>
  <br />
<!-- TABEL CU INFORMATII --> 
  <table cellpadding="6" cellspacing="6" align="left" style="text-align:left;" width="100%">

   <tr>
    <td id="exist_wait" ></td>
   </tr>
  </table>

  <h1 align="center" >DETALII</h1>
  
  <h3 align="left" style="padding-left:5px; color:#999;"><?=TEXT_CLIENT_NOU?>?</h3>
  <form method="post" action="rezervare-procesare.php" id="form1" class="signupform">
   <input type="hidden" name="allowlang" id="allowlang" value="no" />
   <table cellpadding="6" cellspacing="6" width="100%" border="0" style="text-align:left;">
    <tr>
     <td width="120px"><strong><?=TITLU_TEXT?>:</strong></td>
     <td id="title"><select name="title" class="textbox3" style="width:60px;">
       <option value="Dl."><?=TEXT_DOMNUL?>.</option>
        <option value="D-ra."><?=TEXT_DOAMNA?>.</option>
       <option value="D-na."><?=TEXT_DOMNISOARA?>.</option>

      </select></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_NUME_FAMILIE?>:</strong></td>
     <td><input type="text" name="fname" id="fname"  class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_PRENUME?>:</strong></td>
     <td><input type="text" name="lname" id="lname"  class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_ADRESA?>:</strong></td>
     <td><input type="text" name="str_addr" id="str_addr"  class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_ORAS?>:</strong></td>
     <td><input type="text" name="city"  id="city" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_JUDET?>:</strong></td>
     <td><input type="text" name="state"  id="state" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_COD_POSTAL?>:</strong></td>
     <td><input type="text" name="zipcode"  id="zipcode" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_TARA?>:</strong></td>
     <td><input type="text" name="country"  id="country" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_TELEFON?>:</strong></td>
     <td><input type="text" name="phone"  id="phone" class="required" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_FAX?>:</strong></td>
     <td><input type="text" name="fax"  id="fax" /></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_EMAIL?>:</strong></td>
     <td><input type="text" name="email"  id="email" class="required email" /></td>
    </tr>
    <tr>
     <td valign="top"><strong><?=TEXT_PLATA_PRIN?>:</strong></td>
     <td><?php
				$paymentGatewayDetails = $neloCore->loadPaymentGateways();				
				foreach($paymentGatewayDetails as $key => $value){ 	
					echo '<input type="radio" name="payment_type" id="payment_type_'.$key.'" value="'.$key.'" class="required" />'.$value['name'].'<br />';
				}
				?>
      <label class="error" generated="true" for="payment_type" style="display:none;"><?=TEXT_ALERTA_CAMP_REQ?>.</label></td>
    </tr>
    <tr>
     <td valign="top" nowrap="nowrap"><strong><?=TEXT_ALTE_CERINTE?> :</strong></td>
     <td ><textarea name="message" style="width:300px; height:70px;" ></textarea></td>
    </tr>
    <tr>
     <td>&nbsp;</td>
     <td><input type="checkbox" name="tos" id="tos" value="" style="width:15px !important"  class="required"/>
      &nbsp;
      
     <?=TEXT_SUNT_DE_ACORD?> <a href="javascript: ;" onclick="javascript:myPopup2();"> <?=TEXT_TERMENI_SI_CONDITII?>.</a></td>
    </tr>
    <tr>
     <td height="50"></td>
     <td><button id="registerButton" type="submit" style="float:left;"><?=TEXT_CONFIRMARE?> &amp; <?=TEXT_VERIFICA_COS_PRODUSE?></button></td>
    </tr>
   </table>
  </form>
 </div>
</div>
    
    
    
    </div>
    

</div>

<!-- FOOTER -->



<div id="footer_continut">


<div id="footer_container">

<img src="imagini/bottom_logo.png" style="margin:0px auto; margin-left: 396px;" alt="logo" />
   <p style="text-align:center; color: #dedede; font-family: Century Gothic, sans-serif; !important; font-size: 13px !important;">
    &copy; Copyright 2014 Facultatea de Informatica Iasi.<br />Proiect realizat pentru disciplina TW 
	<br />
	Jicman Gabriel, Tudor Stefan, Razvan Lozneanu
	</p>


</div>

</div><!-- SFARSIT FOOTER -->





</body>
</html>