<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

session_start();
session_destroy();

header("Location: ../index.php");
?>
