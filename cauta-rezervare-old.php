<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");
include("setari/search.class.php");
include("setari_traduceri.php");
$nelosearch = new neloSearch();
$neloCore->clearExpiredBookings();
$pos2 = strpos($_SERVER['HTTP_REFERER'],$_SERVER['SERVER_NAME']);
if($nelosearch->numarNopti==0 and !$pos2){
	header('Location: rezervare-esuata.php?error_code=9');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>
<?=$neloCore->config['conf_hotel_name']?>
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen" />
<script type="text/javascript" src="js/jquery-1.2.6.min.js"></script>
<script type="text/javascript" src="js/validari-rezervari.js"></script>
<script type="text/javascript" src="js/jquery.lightbox-0.5.min.js"></script>
</head>
<body>
<center>
 <div id="content">
  <h1>
   <?=$neloCore->config['conf_hotel_name']?>
  </h1>
  <div id="wrapper" style="width:700px !important;">
   <h2 align="left"  style="padding-left:5px;"><?=TEXT_CAUTARE_INTRARI?></h2>
   <hr color="#e1dada"  style="margin-top:3px;"/>
   <table cellpadding="0"  cellspacing="7" border="0" align="left" style="text-align:left;">
    <tr>
     <td><strong><?=TEXT_CHECKIN_D?>:</strong></td>
     <td><?=$nelosearch->checkInDate?></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_CHECKOUT_D?>:</strong></td>
     <td><?=$nelosearch->checkOutDate?></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_TOTAL_NOPTI?>:</strong></td>
     <td><?=$nelosearch->numarNopti?></td>
    </tr>
    <tr>
     <td><strong><?=TEXT_ADULTI_CAMERA_D?>:</strong></td>
     <td><?=$nelosearch->oaspetiPerCamera?></td>
    </tr>
   </table>
  </div>
  <br />
  <br />
  <div id="wrapper" style="width:700px !important;">
   <h2 align="left"  style="padding-left:5px;"><?=TEXT_REZULTAT_CAUTARE?></h2>
   <hr color="#e1dada" style="margin-top:3px;"/>
   <form name="searchresult" id="searchresult" method="post" action="detaliile_rezervarii.php" onsubmit="return validateSearchResultForm('<?=TEXT_ALERTA_SELECTARE_CAMERA?>');">
    <?php
		$gotSearchResult = false;
		$idgenrator = 0;
		$ik=1;
		foreach($nelosearch->roomType as $room_type){
			foreach($nelosearch->multiCapacity as $capid => $capvalues){
				$room_result = $nelosearch->getAvailableRooms($room_type['rtid'], $room_type['rtname'], $capid);
				if(intval($room_result['roomcnt']) > 0){
					$gotSearchResult = true;
					echo '<script> $(document).ready(function() { ';
					echo '$("#'.str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid).$ik.'").click(function () {
						  $("#'.str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid).'").slideToggle("slow");
						  if($("a#'.str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid).$ik.'").html()=="<b>'.TEXT_VIZUALIZARE_OFERTE.'</b>"){
								$("a#'.str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid).$ik.'").html("<b>'.TEXT_ASCUNDE_VIZUALIZARE_OFERTE.'</b>")
						  }else{
								$("a#'.str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid).$ik.'").html("<b>'.TEXT_VIZUALIZARE_OFERTE.'</b>")
						  }
						});
							';
					echo '}); </script>';
					echo '<script type="text/javascript">
							$(document).ready(function() {
								$("#mySlides_'.$capid.'_'.$room_type['rtid'].' a").lightBox();
							});
					  </script>';	
	?>
    <br />
    <table cellpadding="1" cellspacing="0" border="0" width="100%" height="100%" bgcolor="#f2f2f2" style="text-align:left;">
     <tr>
      <td width="95px" rowspan="3" id="mySlides_<?php echo $capid."_".$room_type['rtid']; ?>"><a href="<?php echo ($room_type['rtimg']=="")? 'imagini/no_photo.jpg':'galerie/'.$room_type['rtimg']; ?>"><img src="<?php echo ($room_type['rtimg']=="")? 'imagini/no_photo.jpg':'galerie/thumb_'.$room_type['rtimg']; ?>" width="146px" height="116px" style="border:2px #6CF solid" /></a></td>
     </tr>
     <tr>
      <td width="100%" style="font-size:18px;"><b>&nbsp;
       <?=$room_type['rtname']?>
       </b> (
       <?=$capvalues['captitle']?>
       )</td>
     </tr>
     <tr>
      <td width="100%" valign="top" style="font-size:13px"><table cellpadding="3" cellspacing="2" border="0" width="100%" bgcolor="#FFFFFF">
        <tr>
         <td bgcolor="#f5f9f9"  style="height:45px;"><strong><?=TEXT_MAX_OCUPARE?></strong></td>
         <td bgcolor="#f5f9f9"><?=$capvalues['capval']?>
          <?=TEXT_ADULTI?></td>
         <td bgcolor="#f5f9f9" style=" width:150px;" nowrap="nowrap"><strong><?=SELECT_NUMBER_OF_ROOM_TEXT?></strong></td>
         <td bgcolor="#f5f9f9"><select name="svars_selectedrooms[]" style="width:70px;">
           <?=$room_result['roomdropdown']?>
          </select></td>
        </tr>
        <tr>
         <td bgcolor="#f5f9f9"  style="height:44px;"><strong><?=TEXT_PRET_TOTAL_CAMERA?></strong></td>
         <td bgcolor="#f5f9f9"><?=$neloCore->config['conf_currency_symbol'].$room_result['totalprice']?></td>
         <td bgcolor="#f5f9f9" colspan="2" align="left"><a href="javascript:;" id="<?=str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid).$ik?>"><b><?=TEXT_VIZUALIZARE_OFERTE?></b></a></td>
        </tr>
        
       </table></td>
     </tr>
    <tr>
         <td colspan="2" ><span id="<?=str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid)?>" id="<?=str_replace(" ","",$room_type['rtid']).'_'.str_replace(" ","",$capid)?>" style="display:none;">
          <table width="100%">
           <?=$room_result['pricedetails']?>
          </table>
          </span></td>
        </tr>
    </table>
   
    <?php
				}
			}
		}
		
		if($gotSearchResult){
			echo '<div id="" style="width:600px !important;"><table cellpadding="5" cellspacing="0" border="0" width="100%" >';
			echo '<tr><td align="right" style="padding-right:30px;"><button id="registerButton" type="submit" style="float:right;">'.TEXT_CONTINUARE.'...</button></td></tr>';
			echo '</table></div>';	
		}else{
			echo '<table cellpadding="4" cellspacing="0" width="100%"><tbody><tr><td style="font-size:13px; color:#F00;" align="center"><br /><br />';
			if($nelosearch->searchCode == "SEARCH_ENGINE_TURN_OFF"){
				echo 'Sorry online booking currently not available. Please try later.';				
			}else if($nelosearch->searchCode == "OUT_BEFORE_IN"){
				echo 'Sorry you have entered a invalid searching criteria. Please try with invalid searching criteria.';				
			}else if($nelosearch->searchCode == "NOT_MINNIMUM_NIGHT"){
				echo 'Numarul minim de nopti nu trebuie sa fie mai mic de'.' '.$neloCore->config['conf_min_night_booking'].' '. 'Va rugam modificati criteriul de cautare.';
			}else if($nelosearch->searchCode == "TIME_ZONE_MISMATCH"){
				$tempdate = date("l F j, Y G:i:s T");
				echo 'Booking not possible for check in date: '.$nelosearch->checkInDate.'. '.'Please modify your search  criteria according to hotels date time. <br> Hotels Current Date Time:'.' '.$tempdate; 
			}else{
				echo 'Sorry no room available as your searching criteria. Please try with different date slot.';
			}
			echo '<br /><br /><br /></td></tr></tbody></table>';
		}
	?>
   </form>
   <br  />
  </div>
 </div>
</center>
</body>
</html>