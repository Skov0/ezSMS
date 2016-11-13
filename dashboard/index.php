<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once ("../backend/config/mysql_conn.php");
include_once ("../backend/config/config.php");
// check if user is logged in
include ("../backend/checkSession.php");

// get search
if (isset($_POST['search']) && !empty($_POST['search'])) {
  $input = $_POST['search'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>EzSMS - Dashboard</title>

  <link href="../css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/style.css" rel="stylesheet">
</head>

<body>
  <?php include_once ("header.php"); ?>

   <div class="container">
       <div class="sendsms">
         <div class="row">
           <div class="col-md-12">
           <div class="page-header">
             <h1>Send SMS <small>Select contact(s) and/or insert a number.</small>
           </div>
           <?php if (isset($_SESSION['smsstatus']) == "smsSent") { unset($_SESSION['smsstatus']); ?>
           <div class="alert alert-success alerts" role="alert"><b>Everything looks good!</b> Your Message(s) was sent successfully!</div>
           <?php } elseif (isset($_SESSION['smsstatus']) == "smsFailed") { unset($_SESSION['smsstatus']); ?>
            <div class="alert alert-danger alerts" role="alert"><b>Ooops! It looks like something went wrong.</b> One or more messages was not sent!</div>
           <?php } ?>
          </div>
        </div>
      </div>
    </div>

  <div class="well well-lg">
  <div class="container">
    <?php if ($config['showcontacts'] == true) { ?>
    <div class="col-md-6">
    <?php } else { ?>
    <div class="col-md-12">
    <?php } ?>
      <div class="row">
          <div class="sendsettings">
          <h4>Phone number</h4>
          <form id="main" name="main" action="../backend/sendsms.php" method="POST">
          <div class="input-group">
            <span class="input-group-addon" id="to">To nr:.</span>
            <input type="text" class="form-control" name="InputNumber" id="InputNumber" onkeyup="saveValue(this);" placeholder="+4522448732" aria-describedby="to">
          </div>
          <h4>SMS Message</h4>
          <textarea class="form-control" name="InputText" id="InputText" onkeyup="saveValue(this);" rows="8" placeholder="Hello there how are you today..."></textarea>
        </div>
        <input type="hidden" name="frecp" id="frecp" value="">
        <button type="submit" class="btn btn-success btn-send" onclick="submitMain();">Send SMS</button>
        </form>
      </div>
    </div>
    <?php if ($config['showcontacts'] == true) { ?>
    <div class="col-md-5 col-md-offset-1">
      <div class="row">
        <div class="contacts">
        <h4>Filter contacts</h4>
        <form action="index.php" method="POST">
        <div class="input-group">
          <input type="text" class="form-control" id="search" name="search" placeholder="Search for First and/or lastname (blank for all)">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="button commit">Search</button>
        </span>
        </div>
        </form>
        <h4>Contacts <small> (hold CTRL to select multiple recipients)</small></h4>
        <select multiple class="form-control" name="recp" id="recp"> <!-- NOTE: this solution does not support IE/Edge -->
          <?php
            $conn = connectDB();
            $stmt = $conn->prepare("SELECT firstname, lastname, phone_number FROM phonebook WHERE owner = ? ORDER BY id DESC");
            $stmt->bind_param('s', $id);
            $stmt->execute();
            $result = $stmt->get_result();

            while ($obj = $result->fetch_object()) {
              if (isset($input) && !empty($input)) {
                if (($obj->firstname == $input) || ($obj->lastname == $input) || ($obj->firstname . " " . $obj->lastname == $input)) {
                  echo "<option>" . $obj->firstname . " " . $obj->lastname . "  :  " . $obj->phone_number . "</option>";
                }
              } else {
                echo "<option>" . $obj->firstname . " " . $obj->lastname . "  :  " . $obj->phone_number . "</option>";
              }
            }
            // lose db connection
            $conn->close();
            $stmt->close();
          ?>
        </select>
      </div>
    </div>
    </div>
    <?php } ?>
  </div>
</div>

    <!-- javascripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/saveForms.js"></script>
    <script src="../js/alertHandler.js"></script>
    <script>
    // fix since IE & Edge does not support the HTML5 form attribute..
    function submitMain() {
      var numbers = $('#recp').val();
      document.getElementById('frecp').value = JSON.stringify(numbers);
    }
    </script>
  </body>
</html>
