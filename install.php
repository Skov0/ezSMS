<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

/// !!!!! DELETE THIS FILE AFTER INSTALLATION !!!!! ///
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>EzSMS - Installation</title>

  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">
</head>

<body>
   <div class="container">
     <?php if (isset($_SESSION['install'])) { ?>
       <div class="install-alert alert alert-danger alerts" role="alert"><?php echo $_SESSION['install']; ?></div>
     <?php } unset($_SESSION['install']); ?>
       <div class="sendsms">
         <div class="row">
           <div class="col-md-12">
           <h1 class="text-center">EzSMS Installation</h1>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-md-6 col-md-offset-3">
            <form action="backend/setup.php" method="POST">
            <h4>MySQL Configuration</h4>
            <div class="well well-lg">
              <div class="form-group">
                <label for="mysqlserver">Hostname or IP address</label>
                <input type="text" class="form-control" name="InputServer" id="InputServer" placeholder="127.0.0.1" required>
              </div>
              <div class="form-group">
                <label for="mysqluser">Username</label>
                <input type="text" class="form-control" name="InputMUsername" id="InputMUsername" placeholder="root" required>
              </div>
              <div class="form-group">
                <label for="mysqlpass">Password</label>
                <input type="password" class="form-control" name="InputMPassword" id="InputMPassword" placeholder="toor">
              </div>
              <div class="form-group">
                <label for="mysqldb">Database</label>
                <input type="text" class="form-control" name="InputDB" id="InputDB" placeholder="ezsms" required>
              </div>
            </div>
            <h4>User Creation</h4>
            <div class="well well-lg">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" name="InputUsername" id="InputUsername" placeholder="Admin" required>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="InputPassword" id="InputPassword" placeholder="********" required>
              </div>
            </div>
            <button type="button submit" class="install-btn btn btn-primary pull-right">Install EzSMS</button>
            </form>
          </div>
        </div>
      </div>

<!-- javascripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="js/alertHandler.js"></script>
  </body>
</html>
