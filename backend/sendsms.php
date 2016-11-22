<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once('config/mysql_conn.php');
include_once ('config/config.php');
include_once('checkSession.php');

if (isset($_POST['InputNumber'])) {
  $number = $_POST['InputNumber'];
}
if (isset($_POST['InputText'])) {
  $text = $_POST['InputText'];
}

if (!empty($number)) {
  if (strpos($number, '+') === false) {
  // insert defualt prefix
  $prefix = $config['defualtprefix'];
  $number = $prefix . $number;
  }
}

if (isset($_POST['frecp']) && !empty($_POST['frecp'])) {
  $numbers = array();
  $numbers = json_decode($_POST['frecp']);
  $tempArray = array();
  foreach ($numbers as &$contact) {
    $contact = explode(": ", $contact)[1];
    array_push($tempArray, $contact);
  }
  if (isset($number) && !empty($number)) {
    array_push($tempArray, $number);
  }
} else {
  $tempArray = array($number);
}

$finalNumbers = array();
foreach ($tempArray as &$number) {
  array_push($finalNumbers, explode('+', $number)[1]);
}

$smsGW = new SMSGateway;
$errors = 0;
foreach ($finalNumbers as &$to) {
  if($smsGW->SendSMS($to, $text)) {
    // log it
    LogSMS($to, $text, $config['timeformat']);
  } else {
    $errors++;
  }
}

if ($errors === 0) {
  $_SESSION['smsstatus'] = "smsSent";
  header("Location: ../dashboard/index.php");
  exit;
} else {
  $_SESSION['smsstatus'] = "smsFailed";
  header("Location: ../dashboard/index.php");
  exit;
}

function LogSMS ($number, $text, $timeFormat) {
// get current max id
$conn = connectDB();
$stmt = $conn->prepare("SELECT id FROM sms_sent ORDER BY id DESC LIMIT 1");
$stmt->execute();
$currentID = $stmt->get_result()->fetch_assoc()['id'];
$stmt->close();
$newID = $currentID + 1;

// get datetime
if ($timeFormat == 1) {
  $now = date("G:i, j F Y");
} else {
  $now = date("F j Y, g:i a");
}

// set owner
$id = $GLOBALS["id"];

// check if number exists in contacts
$stmt = $conn->prepare("SELECT phone_number, firstname, lastname FROM phonebook WHERE phone_number = ? ORDER BY id LIMIT 1");
$checkNumber = "+" . $number;
$stmt->bind_param('s', $checkNumber);
$stmt->execute();
$checkResult = $stmt->get_result()->fetch_assoc();
if ($checkResult != NULL) {
  $number = $checkResult['firstname'] . " " . $checkResult['lastname'];
} else {
  $number = "+" . $number;
}
$stmt->close();
  
// format text
$text = nl2br($text);

// insert data
$stmt = $conn->prepare("INSERT INTO sms_sent (id, sms_to, sms_text, sms_date, owner) VALUES (?,?,?,?,?)");
$stmt->bind_param('sssss', $newID, $number, $text, $now, $id);
$stmt->execute();
$stmt->close();
$conn->close();
}
?>
