<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

/// !!!!! DELETE THIS FILE AFTER INSTALLATION !!!!! ///
session_start();
error_reporting(E_ERROR);

// get post
if ((isset($_POST['InputServer']) && !empty($_POST['InputServer'])) &&
  (isset($_POST['InputMUsername']) && !empty($_POST['InputMUsername'])) &&
  (isset($_POST['InputMPassword'])) &&
  (isset($_POST['InputDB']) && !empty($_POST['InputDB'])) &&
  (isset($_POST['InputUsername']) && !empty($_POST['InputUsername'])) &&
  (isset($_POST['InputPassword']) && !empty($_POST['InputPassword']))) {
    $server = $_POST['InputServer'];
    $musername = $_POST['InputMUsername'];
    $mpassword = $_POST['InputMPassword'];
    $database = $_POST['InputDB'];
    $username = $_POST['InputUsername'];
    $password = $_POST['InputPassword'];
} else {
  //return;
}

// create database.ini
try {
  CreateIniFile($server, $musername, $mpassword, $database);
} catch (Execption $e) {
  $_SESSION['install'] = $e->getMessage();
  header("Location: ../install.php");
}

// create db and tables
try {
  CreateDB($server, $musername, $mpassword, $database);
} catch (ErrorException $e) {
  $_SESSION['install'] = $e->getMessage();
  header("Location: ../install.php");
}

// create admin user
try {
  CreateUser($username, $password);
} catch (Execption $e) {
  $_SESSION['install'] = $e->getMessage();
  header("Location: ../install.php");
}

// quick fix
DBFix();

// success!
$_SESSION['install'] = "EzSMS was installed successfully. <b>Please delete install.php</b>";
header("Location: ../index.php");

function CreateIniFile ($server, $musername, $mpassword, $database) {
  $iniFile = fopen("config/database.ini", "w");
  $content = "server = " . $server . "\n" . "username = " . $musername . "\n" . "password = " . $mpassword . "\n" . "database = " . $database;
  if (fwrite($iniFile, $content) === FALSE) {
    throw new Exception('An error occored while trying to write database.ini..');
  }
  fclose($iniFile);
}

function CreateDB ($server, $musername, $mpassword, $database) {
  $conn = new mysqli($server, $musername, $mpassword);
  if ($conn->connect_error) {
    throw new ErrorException("Unable to connect to your MySQL Server..");
    exit;
  }
  $request = "CREATE DATABASE IF NOT EXISTS " . $database;
  if ($conn->query($request) === TRUE) {
    // create tables
    $phonebook = "CREATE TABLE phonebook (
    id INT(225),
    firstname TEXT NOT NULL,
    lastname TEXT NOT NULL,
    phone_number TEXT NOT NULL,
    email TEXT NOT NULL,
    owner INT(255)
    )";

    $sms_sent = "CREATE TABLE sms_sent (
    id INT(255),
    sms_to TEXT NOT NULL,
    sms_text TEXT NOT NULL,
    sms_date TEXT NOT NULL,
    owner int(255)
    )";

    $users = "CREATE TABLE users (
    id INT(255),
    username TEXT NOT NULL,
    hash TEXT NOT NULL,
    access INT(255)
    )";

    $tables = array();
    array_push($tables, $phonebook, $sms_sent, $users);
    $errors = 0;
    $conn = new mysqli($server, $musername, $mpassword, $database);
    foreach ($tables as $table) {
      if($conn->query($table) === FALSE) {
        $errors++;
      }
    }
    if ($errors > 0) {
      throw new Exception("Something went wrong while trying to create the database tables..");
      return;
    }
  } else {
    // we should never get an error here.
  }
}

function CreateUser ($username, $password) {
  include_once("config/mysql_conn.php");
  include_once("config/config.php");
  $access = $config['adminint'];
  $id = "1";

  $conn = connectDB();
  $stmt = $conn->prepare("INSERT INTO users (id, username, hash, access) VALUES (?,?,?,?)");
  $stmt->bind_param('ssss', $id, $username, HashPassword($password), $access);
  if(!$stmt->execute()) {
    throw new Exception("Something went wrong while trying to create the admin user!");
    return;
  }
  $conn->close();
  $stmt->close();
}

function HashPassword ($password) {
  $cost = 10;
  $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
  $salt = sprintf("$2a$%02d$", $cost) . $salt;

  $hash = crypt($password, $salt);

  return $hash;
}

function DBFix () {
  include_once("config/mysql_conn.php");
  $id = "0";
  $conn = connectDB();
  $stmt = $conn->prepare("INSERT INTO phonebook (id) VALUES (?)");
  $stmt->bind_param('s', $id);
  $stmt->execute();

  $stmt = $conn->prepare("INSERT INTO sms_sent (id) VALUES (?)");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $stmt->close();
  $conn->close();
}
?>
