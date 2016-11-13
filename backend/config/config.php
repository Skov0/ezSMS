<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

// Change this to your username and password
$config['username']         = "YOUR_USERNAME";
$config['password']         = "YOUR_PASSWORD";

// Change this to fit your SMS Gateways APi
$config['apiurl']          = "http://smsapi.dk/sms/v1/";

// Global application settings
$config['sendername']       = "EzSMS";  // name on sender
$config['defualtprefix']    = "+45";      // If no prefix is defined when sending sms
$config['showcontacts']     = true;       // Show contacts on Send SMS page
$config['adminint']         = 1;          // Defines admin privileges
$config['shownumber']       = 1;          // Show number behind name in contact
$config['timeformat']       = 2;          // 1 = 24-hour, 2 = 12-hour
//$config['langauge']         = "english";   // danish & english supported
///////////////////////////////////////////////////////////////////////////////////

class SMSGateway {
  // Change this function to fit your gateway
  public function SendSMS($number, $text) {
    // get config vars
    global $config;

    // format request
    $request = $config['apiurl'] . "?username=" . $config['username'] . "&password=" . $config['password'] . "&to=" . $number . "&from=" . $config['sendername'] . "&message=" . urlencode($text);

    // get and return status
    $status = simplexml_load_file($request);
    if (isset($status->succes)) {
      return true;
    } else {
      return false;
    }
  }
}
?>
