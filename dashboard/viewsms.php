<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

// check that the logged in user is owner of sms id!
include_once ("../backend/config/mysql_conn.php");

// check if user is logged in
include ("../backend/checkSession.php");

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $smsid = $_GET['id'];
}
$userID = $id;

$conn = connectDB();
$stmt = $conn->prepare("SELECT id, sms_to, sms_text, sms_date, owner FROM sms_sent WHERE id = ?");
$stmt->bind_param('s', $smsid);
$stmt->execute();
$result = $stmt->get_result()->fetch_assoc();
$stmt->close();

if ($result['owner'] == $userID) {
  // continue...
} else {
  // not the owner of this sms.
  header("Location: index.php");
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EzSMS - View SMS</title>

    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>

  <?php include_once ("header.php"); ?>

  <div class="container">
    <div class="col-md-12">
    <div class="sendsms">
      <div class="row">
        <div class="page-header">
          <h1>SMS ID: <?php echo $result['id']; ?> <small> Send To: <?php echo $result['sms_to']; ?>. Date: <?php echo $result['sms_date']; ?></small>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="container">
    <br /><br />
    <textarea class="form-control" rows="25" readonly><?php $breaks = array("<br />","<br>","<br/>"); $text = str_ireplace($breaks, "\r\n", $result['sms_text']); echo $text;?></textarea>
    <button type="button" class="btn btn-primary goback" onclick="window.close();">Go back</button>
  </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>
