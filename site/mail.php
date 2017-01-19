<?php

error_reporting(-1);
$from         = 'no-reply@rayplumbing.com';
$to           = 'info@rayplumbing';
$subject      = 'Porta pottie quote form entry submitted';

# The following is kind of ugly, but will work just fine:

$body         = "
The pottie rental quote form at your website has recieved a submission with the following details:\r\n";



if ($_POST['realname']) {
  $body .= "Name: ". $_POST['realname'] . "\r\n";
}
 

if ($_POST['address']) {
  $body .= "Address: ". $_POST['address'] . "\r\n";
}

if ($_POST['city']) {
  $body .= "Address: " . $_POST['city'] . "\r\n";
}

if ($_POST['state']) {
  $body .= "State: " . $_POST['state'] . "\r\n";
}

if ($_POST['zip']) {
  $body .= "Zip code: " . $_POST['zip'] . "\r\n";
}

if ($_POST['phone']) {
  $body .= "Phone #: " . $_POST['phone'] . "\r\n";
}

if ($_POST['phone']) {
  $body .= "Organization: " . $_POST['organization'] . "\r\n";
}

if ($_POST['delivery_address']) {
  $body .= "Delivery address: " . $_POST['delivery_address'] . "\r\n";
}

if ($_POST['delivery_city']) {
  $body .= "Delivery city: " . $_POST['delivery_city'] . "\r\n";
}

if ($_POST['fax']) {
  $body .= "Fax: " . $_POST['fax'] . "\r\n";
}

if ($_POST['email']) {
  $body .= "Email: " . $_POST['email'] . "\r\n";
}

if ($_POST['type_event']) {
  $body .= "Type of event: " . $_POST['type_event'] . "\r\n";
}

if ($_POST['delivery_month']) {
  $body .= "Delivery date - Month: " . $_POST['delivery_month'] . "\r\n";
}

if ($_POST['delivery_day']) {
  $body .= "Delivery date - Day: " . $_POST['delivery_day'] . "\r\n";
}

if ($_POST['delivery_year']) {
  $body .= "Delivery date - Year: " . $_POST['delivery_year'] . "\r\n";
}

if ($_POST['unit_style']) {
  $body .= "Unit style: " . $_POST['unit_style'] . "\r\n";
}

if ($_POST['pickup_month']) {
  $body .= "Pickup date - Month: " . $_POST['pickup_month'] . "\r\n";
}

if ($_POST['pickup_day']) {
  $body .= "Pickup date - Day: " . $_POST['pickup_day'] . "\r\n";
}

if ($_POST['pickup_year']) {
  $body .= "Pickup date - Year: " . $_POST['pickup_year'] . "\r\n";
}

if ($_POST['order_quantity']) {
  $body .= "Order quantity: " . $_POST['order_quantity'] . "\r\n";
}

if ($_POST['comments']) {
  $body .= "Comments: " . $_POST['comments'] . "\r\n";
}


/* the following two are for redirects: */
$return_page  = 'http://rayplumbing.com';
$form_page    = 'http://http://www.rayplumbing.com/porta-pottie-quote.htm';
$refresh_time = 3;

$captcha_private_key = ''; # leave blank for no captcha validation

$smtp_host    = 'localhost';
$smtp_user    = 'no-reply@rayplumbing.com';
$smtp_pass    = 'X#FHhTF=~]P?#Np.';
$smtp_port    = 25;

/* ------------ do not edit below this line! ------------ */

/* captcha stuff ... ew it's ugly, but blame the reCaptcha team! :D */

if ($captcha_private_key) {
  require_once('recaptchalib.php');
  $resp = recaptcha_check_answer ($captcha_private_key, $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
  
  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    header("Refresh: $refresh_time;url=$form_page");
    echo ("<h2 style='color: #DD0000;'>Validation Error</h2>The reCAPTCHA wasn't entered correctly. Please go back and correct this.");
    die;
  }
}

/* encryption stuff: */
/*
  $gpg = new gnupg();
  $gpg->addencryptkey ('');
  $gpg->adddecryptkey ('');
  $gpg->addsignkey    ('');

  # Encrypt and sign message:
  $body = $gpg->encryptsign($body);
*/

/* mailing stuff: */

require_once "Mail.php";
 
$headers = array ('From' => $from,
		  'To' => $to,
		  'Subject' => $subject);
$smtp = Mail::Factory('smtp',
		      array ('host' => $smtp_host,
			     'auth' => true,
			     'username' => $smtp_user,
			     'password' => $smtp_pass));

$mail = $smtp->send($to, $headers, $body);
 
if (PEAR::isError($mail)) {
  header("Refresh: $refresh_time;url=$return_page");
  echo("<h2 style='color: DD0000;'>Unexpected Error</h2>Please contact the system administrator.");
# echo("<p>" . $mail->getMessage() . "</p>"); # uncomment this to figure out what sort of errors are happening with the SMTP transfer
} else {
  header("Refresh: $refresh_time;url=$return_page");
  echo("<p>Message successfully sent, thank you for contacting us! You should be redirected to the home page in a few secconds.</p>");
}

?>
