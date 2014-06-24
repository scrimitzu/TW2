<?php
 
 /**
Fisier de configurare a classelor
 */
 
 
 
 class neloDetaliiRezervari
 
 {
 
	public $oaspetiPerCamera      = 0;			
 
	public $numarNopti         = 0;	
 
	public $checkInDate        = '';
 
	public $checkOutDate       = '';	
 
	public $totalRoomCount     = 0;	
 
	public $roomPrices         = array();
 
	public $depositPlans       = array();
 
	
 
	private $selectedRooms     = '';
 
	private $mysqlCheckInDate  = '';
 
	private $mysqlCheckOutDate = '';
 
	private $searchVars        = array();
 
	private $detailVars	       = array();
 
 
 
	function neloDetaliiRezervari() {	
 
		$this->setRequestParams();			
 
		$this->advancePayment();
 
	}		
 
	
 
	private function setRequestParams() {	
 
 
		global $neloCore;	
 
		
 
		$this->setMyParamValue($this->oaspetiPerCamera, 'SESSION', 'sv_guestperroom', NULL, true);		
 
		$this->setMyParamValue($this->checkInDate, 'SESSION', 'sv_checkindate', NULL, true);
 
		$this->setMyParamValue($this->mysqlCheckInDate, 'SESSION', 'sv_mcheckindate', NULL, true);
 
		$this->setMyParamValue($this->checkOutDate, 'SESSION', 'sv_checkoutdate', NULL, true);
 
		$this->setMyParamValue($this->mysqlCheckOutDate, 'SESSION', 'sv_mcheckoutdate', NULL, true);
 
		$this->setMyParamValue($this->numarNopti, 'SESSION', 'sv_numarNopti', NULL, true);		
 
		$this->setMyParamValue($this->searchVars, 'SESSION', 'svars_details', NULL, true);
 
		$this->setMyParamValue($this->selectedRooms, 'POST_SPECIAL', 'svars_selectedrooms', NULL, true);		
 
		$selected = 0;
 
		
 
		foreach($this->selectedRooms as &$val){		
 
			$val = $neloCore->ClearInput($val); if($val) $selected++;
 
		}			
 
		if($selected == 0) $this->invalidRequest(9);				
 
	}
 
	
 
	private function setMyParamValue(&$membervariable, $vartype, $param, $defaultvalue, $required = false){
 
		global $neloCore;
 
		switch($vartype){
 
			case "POST": 
 
				if($required){if(!isset($_POST[$param])){$this->invalidRequest(9);} 
 
					else{$membervariable = $neloCore->ClearInput($_POST[$param]);}}
 
				else{if(isset($_POST[$param])){$membervariable = $neloCore->ClearInput($_POST[$param]);} 
 
					else{$membervariable = $defaultvalue;}}				
 
				break;	
 
			case "POST_SPECIAL":
 
				if($required){if(!isset($_POST[$param])){$this->invalidRequest(9);}
 
					else{$membervariable = $_POST[$param];}}
 
				else{if(isset($_POST[$param])){$membervariable = $_POST[$param];}
 
					else{$membervariable = $defaultvalue;}}				
 
				break;	
 
			case "GET":
 
				if($required){if(!isset($_GET[$param])){$this->invalidRequest(9);} 
 
					else{$membervariable = $neloCore->ClearInput($_GET[$param]);}}
 
				else{if(isset($_GET[$param])){$membervariable = $neloCore->ClearInput($_GET[$param]);} 
 
					else{$membervariable = $defaultvalue;}}				
 
				break;	
 
			case "SESSION":
 
				if($required){if(!isset($_SESSION[$param])){$this->invalidRequest(9);} 
 
					else{$membervariable = $_SESSION[$param];}}
 
				else{if(isset($_SESSION[$param])){$membervariable = $_SESSION[$param];} 
 
					else{$membervariable = $defaultvalue;}}				
 
				break;	
 
			case "REQUEST":
 
				if($required){if(!isset($_REQUEST[$param])){$this->invalidRequest(9);}
 
					else{$membervariable = $neloCore->ClearInput($_REQUEST[$param]);}}
 
				else{if(isset($_REQUEST[$param])){$membervariable = $neloCore->ClearInput($_REQUEST[$param]);}
 
					else{$membervariable = $defaultvalue;}}				
 
				break;
 
			case "SERVER":
 
				if($required){if(!isset($_SERVER[$param])){$this->invalidRequest(9);}
 
					else{$membervariable = $_SERVER[$param];}}
 
				else{if(isset($_SERVER[$param])){$membervariable = $_SERVER[$param];}
 
					else{$membervariable = $defaultvalue;}}				
 
				break;	
 
					
 
		}		
 
	}	
 
	
 
	private function advancePayment(){
 
		$month  = intval(substr($this->mysqlCheckInDate, 5, 2)) ;
 
		$result = mysql_query("SELECT * FROM nelo_plati_avansate WHERE month_num = ".$month);
 
		$this->depositPlans = mysql_fetch_assoc($result);		
 
		mysql_free_result($result);	
 
	}
 
	
 
	private function invalidRequest($errocode = 9){		
 
		header('Location: rezervare-esuata.php?error_code='.$errocode.'');
 
		die;
 
	}	
 
	
 
	public function generateBookingDetails() {
 
		global $neloCore;
 
		$result = array();
 
		$_SESSION['dvars_details2'] = array();
 
		$dvroomidsonly = "";
 
		$selectedRoomsCount = count($this->selectedRooms);		
 
		$this->roomPrices['subtotal']   = 0.00;	
 
		$this->roomPrices['totaltax']   = 0.00;			
 
		$this->roomPrices['grandtotal'] = 0.00;	
 
		
 
		$dvarsCtr = 0;
 
		for($i = 0; $i < $selectedRoomsCount; $i++){
 
			if($this->selectedRooms[$i] > 0){		
 
				$this->detailVars[$dvarsCtr] = $this->searchVars[$i]; //selected only							
 
				$tmpTotalPrice = 0;
 
				$tmpTotalPrice2 = 0;
 
				$tmpTotalPrice = $this->detailVars[$dvarsCtr]['roomprice'];
 
				$this->detailVars[$dvarsCtr]['totalprice'] = $tmpTotalPrice;
 
				
 
				$tmpRoomCounter = 0;								
 
				foreach($this->detailVars[$dvarsCtr]['availablerooms'] as $availablerooms){	
 
					$this->roomPrices['subtotal'] = $this->roomPrices['subtotal'] + $tmpTotalPrice;	
 
					$dvroomidsonly.= $availablerooms['roomid'].",";													
 
					$tmpRoomCounter++;	
 
					if($tmpRoomCounter == $this->selectedRooms[$i]){
 
						$tmpAvRmSize = count($this->detailVars[$dvarsCtr]['availablerooms']);
 
						for($akey = $tmpRoomCounter; $akey < $tmpAvRmSize; $akey++){
 
							unset($this->detailVars[$dvarsCtr]['availablerooms'][$akey]);
 
						}
 
						break;		
 
					}			
 
				}
 
				array_push($result, array('roomno'=>$tmpRoomCounter, 'roomtype'=>$this->detailVars[$dvarsCtr]['roomtypename'], 'capacitytitle'=>$this->detailVars[$dvarsCtr]['capacitytitle'] ,'capacity'=>$this->detailVars[$dvarsCtr]['capacity'], 'details'=>$tmpRoomCounter."x".$tmpTotalPrice, 'grosstotal'=>$tmpRoomCounter*$tmpTotalPrice ));
 
				$dvarsCtr++;				
 
			}
 
		}
 
		
 
		
 
		if(isset($_SESSION['dvars_details']))unset($_SESSION['dvars_details']);
 
		$_SESSION['dvars_details'] = $this->detailVars;
 
		
 
		if(isset($_SESSION['dvars_details2']))unset($_SESSION['dvars_details2']);
 
		$_SESSION['dvars_details2'] = $result;
 
				
 
		if(isset($_SESSION['dv_roomidsonly']))unset($_SESSION['dv_roomidsonly']);
 
		$_SESSION['dv_roomidsonly'] = substr($dvroomidsonly, 0, -1);
 
			
 
		$this->totalRoomCount =  count(explode(",", $_SESSION['dv_roomidsonly']));
 
		
 
		
 
		/* -------------------------------- calculeaza pretul cazarii ------------------------------------ */	
 
											
 
		if($neloCore->config['conf_tax_amount'] > 0 &&  $neloCore->config['conf_price_with_tax']==0){ 
 
			$this->roomPrices['totaltax'] = ($this->roomPrices['subtotal'] * $neloCore->config['conf_tax_amount'])/100;
 
			$this->roomPrices['grandtotal'] = $this->roomPrices['subtotal'] + $this->roomPrices['totaltax'];	
 
		}else{
			$this->roomPrices['grandtotal'] = $this->roomPrices['subtotal'];
		}
 
		
 
		$this->roomPrices['advanceamount'] = $this->roomPrices['grandtotal'];
 
		if($neloCore->config['conf_enabled_deposit']){
 
			$this->roomPrices['advancepercentage'] = $this->depositPlans['deposit_percent'];			
 
			if($this->roomPrices['advancepercentage'] > 0 && $this->roomPrices['advancepercentage'] < 100){
 
				$this->roomPrices['advanceamount'] = ($this->roomPrices['grandtotal'] * $this->roomPrices['advancepercentage'])/100;
 
			}
 
		}
 
		
 
		//rotunjirea pretului la 2 decimale		
 
		$this->roomPrices['subtotal'] = number_format($this->roomPrices['subtotal'], 2 , '.', '');	
 
		$this->roomPrices['totaltax'] = number_format($this->roomPrices['totaltax'], 2 , '.', '');			
 
		$this->roomPrices['grandtotal'] = number_format($this->roomPrices['grandtotal'], 2 , '.', '');
 
		if($neloCore->config['conf_enabled_deposit']){	
 
		$this->roomPrices['advancepercentage'] = number_format($this->roomPrices['advancepercentage'], 2 , '.', '');
 
		$this->roomPrices['advanceamount'] = number_format($this->roomPrices['advanceamount'], 2 , '.', '');
 
		}
 
		if(isset($_SESSION['dvars_roomprices']))unset($_SESSION['dvars_roomprices']);
 
		$_SESSION['dvars_roomprices'] = $this->roomPrices;
 
		
 
		return $result;
 
	}	
 
	
 
	public function generateBlockingDetails() {
 
		global $neloCore;
 
		$result = array();
 
		$dvroomidsonly = "";
 
		$selectedRoomsCount = count($this->selectedRooms);	
 
		$dvarsCtr = 0;
 
		for($i = 0; $i < $selectedRoomsCount; $i++){
 
			if($this->selectedRooms[$i] > 0){		
 
				$this->detailVars[$dvarsCtr] = $this->searchVars[$i]; //selected only					
 
												
 
				$tmpRoomCounter = 0;								
 
				foreach($this->detailVars[$dvarsCtr]['availablerooms'] as $availablerooms){	
 
					
 
					$dvroomidsonly .= $availablerooms['roomid'].",";													
 
					$tmpRoomCounter++;
 
						
 
					if($tmpRoomCounter == $this->selectedRooms[$i]){
 
						$tmpAvRmSize = count($this->detailVars[$dvarsCtr]['availablerooms']);
 
						for($akey = $tmpRoomCounter; $akey < $tmpAvRmSize; $akey++){
 
							unset($this->detailVars[$dvarsCtr]['availablerooms'][$akey]);
 
						}
 
						break;		
 
					}			
 
				}
 
				array_push($result, array('roomno'=>$tmpRoomCounter, 'roomtype'=>$this->detailVars[$dvarsCtr]['roomtypename'], 'capacitytitle'=>$this->detailVars[$dvarsCtr]['capacitytitle'] ,'capacity'=>$this->oaspetiPerCamera));		
 
		
 
				$dvarsCtr++;				
 
			}
 
		}
 
				
 
		if(isset( $_SESSION['dvars_details']))unset($_SESSION['dvars_details']);
 
		$_SESSION['dvars_details'] = $this->detailVars;
 
				
 
		if(isset($_SESSION['dv_roomidsonly']))unset($_SESSION['dv_roomidsonly']);
 
		$_SESSION['dv_roomidsonly'] = substr($dvroomidsonly, 0, -1);	
 
		$this->totalRoomCount =  count(explode(",", $_SESSION['dv_roomidsonly']));
 
			
 
		return $result;
 
	}	
 
 
 
 }
 
 ?>