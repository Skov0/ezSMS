<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once ("../backend/config/mysql_conn.php");

// check if user is logged in
include ("../backend/checkSession.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EzSMS - History</title>

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
          <h1>Sent SMS <small>Listing all sent SMS</small>
        </div>
      </div>
    </div>
  </div>
</div>
  <div class="container">
    <?php
    $function = "history";
    include_once("../backend/genPageInation.php");
    ?>
  </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Actions.js"></script>
  </body>
</html>
