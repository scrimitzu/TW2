<?php
/**
Fisier de configurare a mailurilor trimise
*/
class neloMail 
{
	private $isSMTP 		= false;
	private $emailFrom 		= '';
	private $emailReplyTo 	= '';
    private $smtpHost 		= NULL;	
	private $smtpPort 		= NULL;
	private $smtpUserName 	= NULL;			
	private $smtpPassword 	= NULL;
	private $emailTo 		= '';
	private $emailSubject 	= '';
	private $emailBody 		= '';	
	
	
	function neloMail() {
		/**
		 * Referinta la fisierul: conf.class.php
		 **/
		global $neloCore;		
					
		$this->isSMTP = false;	
			
		if($this->isSMTP == true){	
			require_once "Mail.php"; // PEAR Mail package
			require_once ('Mail/mime.php'); // PEAR Mail_Mime package		
			$this->emailFrom = $neloCore->config['conf_hotel_name']."<nelomarketingdept@gmail.com>";		
		}else{
			$this->emailFrom = $neloCore->config['conf_hotel_name']."<".$neloCore->config['conf_hotel_email'].">";
		}
		
		$this->emailReplyTo 	= $neloCore->config['conf_hotel_email'];
		$this->smtpHost 		= "ssl://smtp.gmail.com";
		$this->smtpPort 		= intval(465);
		$this->smtpUserName 	= "nelomarketingdept@gmail.com";
		$this->smtpPassword 	= "hhh";
		//$this->loadEmailContent();	
		if(!$this->smtpPort){
			$this->smtpPort = NULL;
		}			
	}
	
	public function sendEMail($emailTo, $emailSubject, $emailBody){
		$this->emailTo = $emailTo;
		$this->emailSubject = $emailSubject;
		$this->emailBody = $emailBody;
		return (($this->isSMTP == true)? $this->sendSMTPMail() : $this->sendPHPMail());		
	}
	
	// Trimiterea mailului utilizand parametrul PHP
	public function sendPHPMail(){
		// Setarea headerului obligatoriu
		$emailHeaders  = 'MIME-Version: 1.0' . "\r\n";
		$emailHeaders .= 'Content-type: text/html; charset=utf-8' . "\r\n";
				
		// Alte headere
		$emailHeaders .= 'reply-to: '.$this->emailReplyTo.'' . "\r\n";
		$emailHeaders .= 'From: '.$this->emailFrom.'' . "\r\n";	
		
		$retmsg = mail($this->emailTo, $this->emailSubject, $this->emailBody, $emailHeaders);		
		// Trimite mail
		if ($retmsg) {
			return true;
		}else {
			return "Failed to sent Message!";
		}
	}
			
	// Trimite mail utilizand SMTP
	public function sendSMTPMail(){
		$emailHeaders = array (
			'From' => $this->emailFrom, 
			'To' => $this->emailTo, 			
			'reply-to' => $this->emailReplyTo, 
			'Subject' => $this->emailSubject,
			'Mime-Version' => "1.0",
			'Content-Type' => "text/html",
			'charset' => "utf-8",
			'Content-Transfer-Encoding' => "7bit");
		$smtpAuthData = array (
			'host' => $this->smtpHost, 
			'port' => $this->smtpPort,
			'auth' => true, 
			'username' => $this->smtpUserName, 
			'password' => $this->smtpPassword);
			
		$smtpMail = Mail::factory('smtp', $smtpAuthData);			
		$smtpMsg = $smtpMail->send($this->emailTo, $emailHeaders, $this->emailBody);
		
		if (PEAR::isError($smtpMail)) {
			return $smtpMail->getMessage();
		}else {
			return true;
		}	
	} 
		
	public function loadEmailContent() {		
		$sql = mysql_query("SELECT * FROM nelo_continut_mailuri WHERE email_name = 'Confirmation Email'");
		$currentrow = mysql_fetch_assoc($sql);	
		$emailContent =  array('subject'=> $currentrow["email_subject"], 'body'=> $currentrow["TEXT_EMAIL"]);			
		return $emailContent; 		
	}
}
?>