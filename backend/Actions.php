<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

//TODO: make function for mysqli querys.
include_once("config/mysql_conn.php");
include_once("config/config.php");

// check for the id
if (isset($_POST['id']) && !empty($_POST['id'])) {
  $InputID = $_POST['id'];
}

// check for actions
if (isset($_POST['smsID']) && !empty($_POST['smsID'])) {
  DeleteSMS($_POST['smsID']);
} elseif (isset($_POST['userID']) && !empty($_POST['userID'])) {
  DeleteUser($_POST['userID']);
} elseif (isset($_POST['contactID']) && !empty($_POST['contactID'])) {
  DeleteContact($_POST['contactID']);
} else { }

// create or edit a contact
if ((isset($_POST['InputFirstName']) && !empty($_POST['InputFirstName'])) &&
  (isset($_POST['InputLastName']) && !empty($_POST['InputLastName'])) &&
  (isset($_POST['InputNumber']) && !empty($_POST['InputNumber'])) &&
  (isset($_POST['InputEmail']) && !empty($_POST['InputEmail']))) {
    AddEditContact($_POST['InputFirstName'], $_POST['InputLastName'], $_POST['InputNumber'], $_POST['InputEmail']);
}

// create or edit a user
if ((isset($_POST['InputUsername']) && !empty($_POST['InputUsername'])) &&
  (isset($_POST['InputPassword']) && !empty($_POST['InputPassword'])) &&
  (isset($_POST['InputAccess']) && !empty($_POST['InputAccess']))) {
    AddEditUser($_POST['InputUsername'], $_POST['InputPassword'], $_POST['InputAccess']);
}

function DeleteSMS ($id) {
  Execute("DELETE FROM sms_sent WHERE id = ?", $id);
}

function AddEditUser($username, $password, $access) {
  $conn = connectDB();

  // check if we need to insert or update
  $id = $GLOBALS['InputID'];
  echo $id;
  $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  if ($stmt->get_result()->num_rows == 1) {
    $stmt->close();
    // we need to update
    if (strpos($password, '$2a') == false) { $password = HashPassword($password); }
    $stmt = $conn->prepare("UPDATE users SET username = ?, hash = ?, access = ? WHERE id = ?");
    $stmt->bind_param('ssss', $username, $password, $access, $id);
    $stmt->execute();
    $stmt->close();
  } else {
    // we need to insert
    // get current higest id
    $stmt = $conn->prepare("SELECT id FROM users ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $currentID = $stmt->get_result()->fetch_assoc()['id'];
    $stmt->close();

    $newid = $currentID + 1;
    $stmt = $conn->prepare("INSERT INTO users (id, username, hash, access) VALUES (?,?,?,?)");
    $stmt->bind_param('ssss', $newid, $username, HashPassword($password), $access);
    $stmt->execute();

    $conn->close();
    $stmt->close();
  }
  header("Location: ../dashboard/manageusers.php");
}

function DeleteUser($id) {
  Execute("DELETE FROM users WHERE id = ?", $id);
}

function AddEditContact($firstname, $lastname, $number, $email) {
  session_start();
  $owner = $_SESSION['user'];
  $conn = connectDB();

  // insert defualt prefix
  if (strpos($number, '+') === false) {
  global $config;
  $prefix = $config['defualtprefix'];
  $number = $prefix . $number;
  }

  // check if we need to insert or update
  $id = $GLOBALS['InputID'];
  $stmt = $conn->prepare("SELECT * FROM phonebook WHERE id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  if ($stmt->get_result()->num_rows == 1) {
    $stmt->close();
    // we need to update
    $stmt = $conn->prepare("UPDATE phonebook SET firstname = ?, lastname = ?, phone_number = ?, email = ? WHERE id = ?");
    $stmt->bind_param('sssss', $firstname, $lastname, $number, $email, $id);
    $stmt->execute();
    $stmt->close();
  } else {
    // we need to insert
    // get current higest id
    $stmt = $conn->prepare("SELECT id FROM phonebook ORDER BY id DESC LIMIT 1");
    $stmt->execute();
    $currentID = $stmt->get_result()->fetch_assoc()['id'];
    $stmt->close();

    $newid = $currentID + 1;
    $stmt = $conn->prepare("INSERT INTO phonebook (id, firstname, lastname, phone_number, email, owner) VALUES (?,?,?,?,?,?)");
    $stmt->bind_param('ssssss', $newid, $firstname, $lastname, $number, $email, $owner);
    $stmt->execute();

    $conn->close();
    $stmt->close();
  }
  header("Location: ../dashboard/contacts.php");
}

function DeleteContact($id) {
  Execute("DELETE FROM phonebook WHERE id = ?", $id);
}

function Execute($query, $id) {
  $conn = connectDB();
  $stmt = $conn->prepare($query);
  $stmt->bind_param('s', $id);
  $stmt->execute();

  if ($stmt->get_result()) {
    return True;
  } else {
    return False;
  }
  $conn->close();
  $stmt->close();
}

function HashPassword($password) {
  $cost = 10;
  $salt = strtr(base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)), '+', '.');
  $salt = sprintf("$2a$%02d$", $cost) . $salt;

  $hash = crypt($password, $salt);

  return $hash;
}
?>
