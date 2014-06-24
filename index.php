<?php
session_start();
include("setari/db.conn.php");
include("setari/conf.class.php");
include("setari_traduceri.php");
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
Prima Pagina | Online Lodging - neLo
</title>
<link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery-ui.min.js"></script>
<script type="text/javascript" src="js//dtpicker/jquery.ui.datepicker-<?=$langauge_selcted?>.js"></script>
<script type="text/javascript">
$(document).ready(function(){
 $.datepicker.setDefaults( $.datepicker.regional[ "<?=$langauge_selcted?>" ] );
 $.datepicker.setDefaults({ dateFormat: '<?=$neloCore->config['conf_dateformat']?>'});
    $("#txtFromDate").datepicker({
        minDate: 0,
        maxDate: "+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
    	var date = $(this).datepicker('getDate');
         if(date){
            date.setDate(date.getDate() + <?=$neloCore->config['conf_min_night_booking']?>);
          }
          $("#txtToDate").datepicker("option","minDate", date)
        }
    });
 
    $("#txtToDate").datepicker({ 
        minDate: 0,
        maxDate:"+365D",
        numberOfMonths: 2,
        onSelect: function(selected) {
           $("#txtFromDate").datepicker("option","maxDate", selected)
        }
    });  
 $("#datepickerImage").click(function() { 
    $("#txtFromDate").datepicker("show");
  });
 $("#datepickerImage1").click(function() { 
    $("#txtToDate").datepicker("show");
  });
  
  $('#btn_room_search').click(function() { 		
	  	if($('#txtFromDate').val()==""){
	  		alert('<?=mysql_real_escape_string(TEXT_ALERTA_DATA_CHECKIN)?>');
	  		return false;
	 	}else if($('#txtToDate').val()==""){
	  		alert('<?=mysql_real_escape_string(TEXT_ALERTA_DATA_CHECKOUT)?>');
	  		return false;
	  	} else {
	  		return true;
	 	}	  
	});	
});
</script>
</head>
<body>
<div id="wrapper_principal"><!-- Inceput Wrapper Principal -->

	<div id="logo_sus"><!-- Inceput Logo Sus -->
  		<a href="http://localhost/altceva"><img src="imagini/logo_sus.png" alt="neLo - Online Lodging" /></a>
  	</div><!-- Sfarist Logo Sus -->
    
    
    <div id="telefon_dr"><!-- Numar de telefon (Dreapta Sus) -->
    Informatii si rezervari: +40 748 952 120 <br /> rezervari (at) neLo.info.uaic.ro
    </div>
    
    
    
<div class="container_stg"><!-- Container Stanga -->
    	<h1>Hotelul neLo</h1>
        
  <div class="intro_text">
        Oferta hotelului conţine o listă de servicii directe şi complementare de ultimă oră în domeniul turismului: de la sala de conferinţe tehnologizată la opţiunile de petrecere a timpului liber în cadrul propriei baze sportive.
		<br />
		Vă oferim internet  de mare viteza,  Wi-FI GRATUIT în toate spaţiile hotelului (recepţie, bar, restaurant, camere, sala de conferinţă, business corner) precum şi internet prin cablu. 
        </div>
        
		<br />
		<br />
            <p><a href="#">Mai multe detalii..</a></p>

      
      <div class="beneficii">
      <br />
      	<span class="titlu_portocaliu">Facilitatile</span> <span class="titlu_gri">Hotelului</span>
        
        <div class="beneficii_prim"><!-- Beneficii -->
   	    	<img src="imagini/icon-restaurant.png" alt="Facilitati - Restaurant" />
        	<h3>Restaurant in cadrul hotelului</h3>
        	<p>Hotelul nostru dispune de cel mai generos spatiu, oferind clientilor nostri eleganta unui restaurant select, exuberanta unei terase racoroase.</p>
        </div>
        
        
        <div class="beneficii_secundare"><!-- Beneficii 2 -->
   	    	<img src="imagini/icon-rservice.png" alt="Facilitati - Room Service" />
        	<h3>Room Service</h3>
        	<p>Hotelul nostru va ofera Room-Service pana la ora 23.</p>
        </div>
        
        
        <div class="beneficii_secundare"><!-- Beneficii 3 -->
   	    	<img src="imagini/icon-animale.png" alt="Facilitati - Animale permise" />
        	<h3>Animale de companie</h3>
        	<p>animalele de companie sunt permise in cadrul hotelului, respectand termenii si conditiile aferente.</p>
        </div>
        
        
        <div class="beneficii_secundare"><!-- Beneficii 4 -->
    	  <img src="imagini/icon-internet.png" alt="Facilitati - Internet" />
        	<h3>Acces Wi-Fi Gratuit</h3>
        	<p>Hotelul nostru dispune de zona publica, camere si centru de conferinte: cu wireless/ cablu.</p>
        </div><!-- Sfaristul beneficiilor -->
        
       
        
      </div><!-- Sfarsit Wrapper Beneficii -->
        
    </div><!-- Sfarsit container stanga -->
    
    
    
  <div class="container_dreapta"><!-- Inceput Container Dreapta -->
    
    
    <div class="continut_dreapta"><!-- Inceput Continut Dreapta -->
   	  <span class="titlu_gri">Formular</span> <span class="titlu_portocaliu">Rezervari</span>
	  
    
    
    <div id="box-rezervari-dreapta" style="width:600px !important;" >
  
 
  <form id="formElem" name="formElem" action="cauta-rezervare.php" method="post">
   <table cellpadding="0"  cellspacing="7" border="0"  align="left" style="text-align:left;">
    <tr>
     <td><strong>Data sosirii:</strong></td>
     <td><input id="txtFromDate" name="check_in" style="width:277px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />
      <span style="padding-left:3px;"><a id="datepickerImage" href="javascript:;"><img src="imagini/calendar.png" height="28px" width="28px" style=" margin-bottom:-4px;" border="0" /></a></span></td>
    </tr>
    <tr>
     <td><strong>Data plecării:</strong></td>
     <td><input id="txtToDate" name="check_out" style="width:277px" type="text" readonly="readonly" AUTOCOMPLETE=OFF />
      <span style="padding-left:3px;"><a id="datepickerImage1" href="javascript:;"><img src="imagini/calendar.png" height="28px" width="28px" style=" margin-bottom:-4px;" border="0" /></a></span></td>
    </tr>
    <tr>
     <td><strong>Adulți/cameră:</strong></td>
     <td><?=$neloCore->capacitycombo();?></td>
    </tr>
    <tr>
     <td></td>
     <td><button class="rezervare" type="submit">Rezervă online</button></td>
    </tr>
   </table>
  </form>
 </div>
    
 	
        
        
    </div><!-- Sfarsit Continut Dreapta -->
    
    
    </div><!-- Sfarsit Container Dreapta -->
    
    <div class="continut_dreapta2"><!-- Inceput Testimoniale -->
    
    <h3>Testimoniale</h3>
    
    <blockquote>De mult nu am vãzut un loc atât de binecuvântat: oameni grozavi, naturã de vis şi un bun gust desãvarşit în toate! Sper sã revin curând.</blockquote>
    <pre>Jicman Gabriel</pre>
    
    <blockquote>Dragii mei, mă simt foarte bine la dumneavoastră. Asta înseamnă ca hotelul e primitor, începând cu întreg colectivul. Am să recomand şi prietenilor mei să poposească la această locație. Vă mulţumesc!</blockquote>
    <pre>Tudor, client</pre>
	
	<blockquote>Vă mulţumesc foarte mult pentru o după amiază fantastică şi pentru ospitalitate. O locaţie minunată</blockquote>
	<pre>Razvan, Client</pre>
        
    </div><!-- Sfarsit Testimoniale -->

	<div class="hr"></div>
    
    
    <div class="galerie_primapag"><!-- Galerie Imagini -->
    
    <span class="titlu_portocaliu">Camere</span> <span class="titlu_gri">Disponibile</span>
    
    <ul class="gallery">
			<li><a href="imagini/gallery_image_big.jpg" rel="prettyPhoto[gallery1]" title="Click to enlarge this image!" class="fade"><img src="imagini/gallery_image.jpg" width="300" height="141" alt="Some great title" /></a></li>
			<li><a href="imagini/gallery_image_big.jpg" rel="prettyPhoto[gallery1]" title="This can be any text you want!" class="fade"><img src="imagini/gallery_image.jpg" width="300" height="141" alt="Some great title" /></a></li>
            <li><a href="imagini/gallery_image_big.jpg" rel="prettyPhoto[gallery1]" title="Click to enlarge this image!" class="fade"><img src="imagini/gallery_image.jpg" width="300" height="141" alt="Some great title" /></a></li>
	</ul>
    
    </div>
    

</div><!-- Sfarsit Galerie Imagini -->


<!-- FOOTER -->



<div id="footer_continut">


<div id="footer_container">

<img src="imagini/bottom_logo.png" style="margin:0px auto; margin-left: 396px;" alt="logo" />
   <p style="text-align:center; color: #dedede; font-family: Century Gothic, sans-serif; !important; font-size: 13px !important;">
    &copy; Copyright 2014 Facultatea de Informatica Iasi.<br />Proiect realizat pentru disciplina TW 
	<br />
	Jicman Gabriel, Tudor Stefan Scriminti, Razvan Lozneanu
	</p>


</div>

</div><!-- SFARSIT FOOTER -->
<div id="bottomstuff"><img src="keep-calm-and-book-now-5.png" /></div>
</body>
</html>