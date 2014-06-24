<?php 
include("access.php");
if(isset($_REQUEST['delete'])){
	include("../setari/db.conn.php");
	include("../setari/conf.class.php");
	include("../setari/admin.class.php");	
	$neloAdminMain->booking_cencel_delete(2);
	header("location:istoric_arhive_rezervari.php?book_type=".$_GET['book_type']);
	exit;
}
if(isset($_REQUEST['cancel'])){
	include("../setari/db.conn.php");
	include("../setari/conf.class.php");	
	include("../setari/admin.class.php");
	include("../setari/mail.class.php");	
	$neloAdminMain->booking_cencel_delete(1); 
	header("location:istoric_arhive_rezervari.php?book_type=".$_GET['book_type']);
	exit;
}
include("header.php"); 
include("../setari/conf.class.php");	
include("../setari/admin.class.php");
if(isset($_GET['book_type'])){
	$book_type = $neloCore->ClearInput($_GET['book_type']);
	
}else{
	$book_type = $neloCore->ClearInput($_POST['book_type']);
	$_SESSION['book_type'] = $book_type;
	$_SESSION['fromDate']=$neloCore->ClearInput($_POST['fromDate']);
	$_SESSION['toDate']=$neloCore->ClearInput($_POST['toDate']);
	$_SESSION['shortby']=$neloCore->ClearInput($_POST['shortby']);
}
if($_SESSION['fromDate'] !="" and $_SESSION['toDate'] != ""){
$condition=" and (DATE_FORMAT(".$_SESSION['shortby'].", '%Y-%m-%d') between '".$neloCore->getMySqlDate($_SESSION['fromDate'])."' and '".$neloCore->getMySqlDate($_SESSION['toDate'])."')";
$shortbyarr=array("booking_time"=>VIEW_ACTIVE_BOOKING_DATE, "start_date"=>CUSTOMER_BOOKING_CHECK_IN_DATE, "end_date"=>CUSTOMER_BOOKING_CHECK_OUT_DATE);
$text_cond="( ".$_SESSION['fromDate']."  ".VB_TO." ".$_SESSION['toDate']."  ".VB_BY." ".$shortbyarr[$_SESSION['shortby']]." )";
}else{
$condition="";
$text_cond="";
}

$query = $neloAdminMain->getBookingInfo($book_type, $clientid=0, $condition);

$html  = $neloAdminMain->getHtml($book_type, $query);
$title_hr = array(1=>VB_ACTIVE, 2=>VB_HISTORY);
?>   
<script type="text/javascript">
	function cancel(bid){
		var answer = confirm ("Esti sigur ca vrei sa anulezi rezervarea?");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?cancel="+bid+"&book_type="+<?=$book_type?>;
	}
	
	function deleteBooking(bid){
		var answer = confirm ("Are you sure want to delete Booking?");
		if (answer)
			window.location="<?=$_SERVER['PHP_SELF']?>?delete="+bid+"&book_type="+<?=$book_type?>;
	}
		
	function myPopup2(booking_id){
		var width = 730;
		var height = 650;
		var left = (screen.width - width)/2;
		var top = (screen.height - height)/2;
		var url='print_invoice.php?bid='+booking_id;
		var params = 'width='+width+', height='+height;
		params += ', top='+top+', left='+left;
		params += ', directories=no';
		params += ', location=no';
		params += ', menubar=no';
		params += ', resizable=no';
		params += ', scrollbars=yes';
		params += ', status=no';
		params += ', toolbar=no';
		newwin=window.open(url,'Chat', params);
		if (window.focus) {newwin.focus()}
		return false;
   }
</script> 
      <div id="container-inside">
      <span style="font-size:16px; font-weight:bold"><?=$title_hr[$book_type]?>  <?=$text_cond?></span>
      <input type="submit" value="Back" style="background:#e5f9bb; cursor:pointer; cursor:hand; float:right" onClick="javascript:window.location.href='lista_rezervarilor.php'"/>
      <hr />
        <table class="display datatable" border="0">
         <?=$html?>
        </table>
      </div>
 <script type="text/javascript" src="js/DataTables/jquery.dataTables.js"></script>
 <script>
 $(document).ready(function() {
	 	var oTable = $('.datatable').dataTable( {
				"bJQueryUI": true,
				"sScrollX": "",
				"bSortClasses": false,
				"aaSorting": [[0,'desc']],
				"bAutoWidth": true,
				"bInfo": true,
				"sScrollY": "100%",	
				"sScrollX": "100%",
				"bScrollCollapse": true,
				"sPaginationType": "full_numbers",
				"bRetrieve": true,
				"oLanguage": {
								"sSearch": "<?=DT_SEARCH?>:",
								"sInfo": "<?=DT_SINFO1?> _START_ <?=DT_SINFO2?> _END_ <?=DT_SINFO3?> _TOTAL_ <?=DT_SINFO4?>",
								"sInfoEmpty": "<?=DT_INFOEMPTY?>",
								"sZeroRecords": "<?=DT_ZERORECORD?>",
								"sInfoFiltered": "(<?=DT_FILTER1?> _MAX_ <?=DT_FILTER2?>)",
								"sEmptyTable": "<?=DT_EMPTYTABLE?>",
								"sLengthMenu": "<?=DT_LMENU?> _MENU_ <?=DT_SINFO4?>",
								"oPaginate": {
												"sFirst":    "<?=DT_FIRST?>",
												"sPrevious": "<?=DT_PREV?>",
												"sNext":     "<?=DT_NEXT?>",
												"sLast":     "<?=DT_LAST?>"
											  }
							 }
	} );
} );
</script> 
<script type="text/javascript" src="js/nelo_datatables.js"></script>
<link href="css/data.table.css" rel="stylesheet" type="text/css" />
<link href="css/jqueryui.css" rel="stylesheet" type="text/css" />
<?php include("footer.php"); ?> 