<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once ("config/mysql_conn.php");
session_start();

if ((isset($_POST['InputUser']) && !empty($_POST['InputUser']))
  && (isset($_POST['InputPass']) && !empty($_POST['InputPass']))) {
    $username = $_POST['InputUser'];
    $password = $_POST['InputPass'];
} else {
    $_SESSION['login'] = "missingInput";
    header("Location: ../index.php");
    return;
}

// check hashed password
if(!function_exists('hash_equals')) {
  function hash_equals($str1, $str2) {
    if(strlen($str1) != strlen($str2)) {
      return false;
    } else {
      $res = $str1 ^ $str2;
      $ret = 0;
      for($i = strlen($res) - 1; $i >= 0; $i--) $ret |= ord($res[$i]);
      return !$ret;
    }
  }
}

$conn = connectDB();

$stmt = $conn->prepare("SELECT hash FROM users WHERE username = ?");
$stmt->bind_param('s', $username);
$stmt->execute();

$user = $stmt->get_result()->fetch_object();

if (hash_equals($user->hash, crypt($password, $user->hash))) {
  // user is ok
  $stmt->prepare("SELECT id FROM users WHERE username = ? LIMIT 1");
  $stmt->bind_param('s', $username);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc()['id'];
  $_SESSION['user'] = $result;
  header("Location: ../dashboard/index.php");
} else {
  // user not ok
  $_SESSION['login'] = "wrongInput";
  header("Location: ../index.php");
}

$stmt->close();
$conn->close();
?>
