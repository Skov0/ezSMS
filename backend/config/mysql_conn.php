<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

function connectDB() {
// prase connection info from ini
$config = parse_ini_file('database.ini');

$conn = new mysqli($config['server'], $config['username'], $config['password'], $config['database']);

  if ($conn->connect_error) {
    trigger_error('Database connection failed: ' . $conn->connect_error . E_USER_ERROR);
    exit;
  }
  return $conn;
}

function db_query($query) {
$conn = connectDB();

if (!$result = $conn->query($query)) {
    echo "The database query has failed with error: " . $conn->connect_error, E_USER_ERROR;
    exit;
}

if ($result->num_rows === 0) {

  }
  $conn->close();
  return $result;
}
?>
