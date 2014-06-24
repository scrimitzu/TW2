<?php
if(!$_POST) exit;

$to = 'gabriel.jicman@gmail.com';
$subject = 'Contactare';

/**************************************************/
$headers = 'From: '.$_POST['contact_email'];
$date = date ("l, F jS, Y"); 
$time = date ("h:i A"); 
$msg = '';

switch($_POST['form_type'])
{
    case 'construction':
        $msg .= "A user would like to keep updated\n";
        $msg .= 'Their email address is: '.$_POST['contact_email']."\n\n";
        $msg .= "Submitted $date at $time.\n\n";
        
    break; // end of 'construction'

    default:
        $msg .= $_POST['contact_message']."\n\n";
        $msg .= 'Submitted by '.$_POST['contact_name']." $date at $time.\n\n";
        
        $return = "";
        
        if (empty($_POST['contact_name']))
        {
            $return .= '"invalid_name":1,';
        }
        if (empty($_POST['contact_message']))
        {
            $return .= '"invalid_message":1,';
        }
        
    break; // end of default

} // end switch
if (empty($_POST['contact_email']) || !validEmail($_POST['contact_email']))
{
    $return .= '"invalid_email":1,';
}

// if no previous errors have been set
if (empty($return))
{
    if (mail($to, $subject, $msg, $headers))
    {
        $return .= '"success":1';
    }
    else
    {
        $return .= '"success":0';
    }
}

echo '{'.$return.'}';


function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
      }
      else if(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
         }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
      }
   }
   return $isValid;
}
