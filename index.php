<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

session_start();
// check if user is logged in
if(isset($_SESSION["user"]) && !empty($_SESSION['user'])) {
  $id = $_SESSION['user'];
  header("Location: dashboard/index.php");
} else {
  // no session, no good
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>EzSMS - Login</title>

    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/override.css" rel="stylesheet">
  </head>
  <body>
    <div class="container">
      <div class="login-alerts">
      <?php if (isset($_SESSION['login']) && $_SESSION['login'] === "missingInput") { unset($_SESSION['login']); ?>
      <div class="alert alert-warning alerts" role="alert"><b>You must fill out both the username and password field!</b></div>
      <?php } elseif (isset($_SESSION['login']) && $_SESSION['login'] === "wrongInput") { unset($_SESSION['login']); ?>
      <div class="alert alert-danger alerts" role="alert">Ooops! <b>Wrong</b> username or password! Please try again.</div>
      <?php } elseif (isset($_SESSION['login']) && $_SESSION['login'] === "noLogin") { unset($_SESSION['login']); ?>
      <div class="alert alert-danger alerts" role="alert">You are not logged in. Please login to continue...</div>
      <?php } elseif (isset($_SESSION['install'])) { ?>
      <div class="alert alert-success alerts" role="alert"><?php echo $_SESSION['login']; ?></div>
      <?php } unset($_SESSION['install']); ?>
      </div>
      <div class="col-md-5 col-centered">
        <div class="ezSMSLogin">
          <div class="row">
            <div class="page-header">
              <h1 class="text-center">EzSMS Login</h1>
            </div>
          </div>
        <div class="row">
          <form action="backend/handleLogin.php" method="POST">
            <div class="form-group">
              <label for="InputUser">Username</label>
              <input type="username" class="form-control" id="InputUser" name="InputUser" placeholder="Admin">
            </div>
            <div class="form-group">
              <label for="InputPass">Password</label>
              <input type="password" class="form-control" id="InputPass" name="InputPass" placeholder="********">
            </div>
        </div>
        <div class="row">
          <button type="button submit" class="btn btn-primary">Login</button>
        </div>
          <!--<p class="pull-right build-version">build. 001 (5/11/16)</p>-->
        </form>
      </div>
    </div>
  </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/alertHandler.js"></script>
  </body>
</html>
