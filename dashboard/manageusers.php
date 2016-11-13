<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once ("../backend/config/mysql_conn.php");
include_once("../backend/config/config.php");

// check if user is logged in
include ("../backend/checkSession.php");

// check access level
$conn = connectDB();
$stmt = $conn->prepare("SELECT access FROM users WHERE id= ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$access = $stmt->get_result()->fetch_assoc()['access'];
$conn->close();
$stmt->close();

if ($access != $config['adminint']) {
  header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EzSMS - Manage Users</title>

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
          <h1>Manage users <small>Add or remove users.</small>
          <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target=".adduser-modal-lg">Add user</button>
        </div>
      </div>
    </div>
  </div>
  <?php
  $function = "users";
  include_once("../backend/genPageInation.php");
  ?>
</div>

<div class="modal fade adduser-modal-lg" tabindex="-1" role="dialog" aria-labelledby="addUserModal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addcontact-modal-lg">Create a new user</h4>
    </div>
    <div class="modal-body">
      <form name="adduser" action="../backend/Actions.php" method="POST">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="username" class="form-control" id="InputUsername" name="InputUsername" placeholder="Admin" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="********" required>
        </div>
        <div class="form-group">
          <label for="access">Access</label>
          <input type="text" class="form-control" id="InputAccess" name="InputAccess" placeholder="5" required>
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

<div class="modal fade edituser-modal-lg" tabindex="-1" role="dialog" aria-labelledby="editUserModal" id="edituser">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="addcontact-modal-lg">Edit user</h4>
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
