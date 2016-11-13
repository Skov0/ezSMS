<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

session_start();
if(isset($_SESSION["user"]) && !empty($_SESSION['user'])) {
  $id = $_SESSION['user'];

  $conn = connectDB();
  $stmt = $conn->prepare("SELECT username FROM users WHERE id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $username = $stmt->get_result()->fetch_assoc()['username'];

  $conn->close();
  $stmt->close();
} else {
  // no session, no good.
  $_SESSION['login'] = "noLogin";
  header("Location: ../index.php");
  exit;
}
?>
