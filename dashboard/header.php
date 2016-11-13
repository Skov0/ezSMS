<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once("../backend/config/config.php");
// check access level
$conn = connectDB();
$stmt = $conn->prepare("SELECT access FROM users WHERE id= ?");
$stmt->bind_param('s', $id);
$stmt->execute();
$access = $stmt->get_result()->fetch_assoc()['access'];
$conn->close();
$stmt->close();

// get request url
$url = $_SERVER['REQUEST_URI'];
?>

<nav class="navbar navbar-inverse navbar-fixed-top">
<div class="container">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="#"><b>EzSMS</b></a>
  </div>

  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav">
      <?php if (strpos($url, "index.php")) { ?>
      <li class="active"><a href="index.php">Send SMS <span class="sr-only">(current)</span></a></li>
      <?php } else { ?>
      <li><a href="index.php">Send SMS</a></li>
      <?php } if (strpos($url, "history.php")) { ?>
      <li class="active"><a href="history.php">History <span class="sr-only">(current)</span></a></li>
      <?php } else { ?>
      <li><a href="history.php">History</a></li>
      <?php } if (strpos($url, "contacts.php")) { ?>
      <li class="active"><a href="contacts.php">Manage contacts <span class="sr-only">(current)</span></a></li>
      <?php } else { ?>
      <li><a href="contacts.php">Manage contacts</a></li>
      <?php } if (strpos($url, "index.php") == false && (strpos($url, "history.php") == false && (strpos($url, "contacts.php") == false))) { ?>
      <?php if($access == $config['adminint']) { ?>
      <li class="dropdown active">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li class="disabled"><a href="#">Edit APi</a></li>
          <li class="disabled"><a href="#">Edit config</a></li>
          <li role="separator" class="divider"></li>
          <li><a href="manageusers.php">Manage users</a></li>
        </ul>
      </li>
      <?php } ?>
      <?php } else { ?>
      <?php if($access == $config['adminint']) { ?>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Settings <span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li class="disabled"><a href="#">Edit APi</a></li>
            <li class="disabled"><a href="#">Edit config</a></li>
            <li role="separator" class="divider"></li>
            <li><a href="manageusers.php">Manage users</a></li>
          </ul>
        </li>
      <?php } ?>
      <?php } ?>
    </ul>
    <a class="navbar-text pull-right" href="logout.php">Logout</a>
    <p class="navbar-text pull-right">Logged in as <?php echo $username;?></p>
  </div>
</div>
</nav>
