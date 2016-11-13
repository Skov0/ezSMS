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

    <title>EzSMS - Contacts</title>

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
          <h1>Manage contacts <small>Add, remove & edit contacts.</small>
          <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".addcontact-modal-lg">Add contact</button>
        </div>
      </div>
    </div>
  </div>
  <?php
  $function = "contacts";
  include_once("../backend/genPageInation.php");
  ?>
</div>

  <div class="modal fade addcontact-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addContactModal">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="addcontact-modal-lg">Create a new contact</h4>
      </div>
      <div class="modal-body">
        <form name="addcontact" action="../backend/Actions.php" method="POST">
          <div class="form-group">
            <label for="firstname">Firstname</label>
            <input type="text" class="form-control" id="InputFirstName" name="InputFirstName" placeholder="Jane" required>
          </div>
          <div class="form-group">
            <label for="lastname">Lastname</label>
            <input type="text" class="form-control" id="InputLastName" name="InputLastName" placeholder="Doe" required>
          </div>
          <div class="form-group">
            <label for="number">Phone Number</label>
            <input type="text" class="form-control" id="InputNumber" name="InputNumber" placeholder="+4522994488" required>
          </div>
          <div class="form-group">
            <label for="number">Email address</label>
            <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="jane@doe.com">
          </div>
          <p>Please note: All fields must be filed out!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-defualt" data-dismiss="modal">Close</button>
        <button type="button commit" class="btn btn-primary">Create contact</button>
      </div>
      </form>
    </div>
  </div>
  </div>

  <div class="modal fade editcontact-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editContact" id="editcontact">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="addcontact-modal-lg">Edit contact</h4>
      </div>
      <div class="modal-body">
        <div class="fetched-data"></div>
    </div>
  </div>
  </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="../js/bootstrap.min.js"></script>
    <script src="../js/Actions.js"></script>
  </body>
</html>
