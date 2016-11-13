<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once("Actions.php");
include_once("checkSession.php");

// define usage
if (isset($function) && !empty($function)) {
  if ($function == "history") {
    $query1 = "SELECT * FROM sms_sent WHERE owner = ?";
    $query2 = "SELECT * FROM sms_sent WHERE owner = ? ORDER BY id DESC LIMIT ? OFFSET ?";
  } elseif ($function == "users") {
    $query1 = "SELECT * FROM users";
    $query2 = "SELECT * FROM users ORDER BY id DESC LIMIT ? OFFSET ?";
  } elseif ($function == "contacts") {
    $query1 = "SELECT * FROM phonebook WHERE owner = ?";
    $query2 = "SELECT * FROM phonebook WHERE owner = ? ORDER BY id DESC LIMIT ? OFFSET ?";
  } else { }
}

try {
  // Find out how many items are in the table
  $conn = connectDB();

  $stmt = $conn->prepare($query1);
  if ($function == "history" || $function == "contacts") {
    $stmt->bind_param('s', $id);
  }
  $stmt->execute();
  $total = $stmt->get_result()->num_rows;

  // define state
  $state = "page";

  // How many items to list per page
  $limit = 15;

  // How many pages will there be
  $pages = ceil($total / $limit);

  // What page are we currently on?
  $page = min($pages, filter_input(INPUT_GET, $state, FILTER_VALIDATE_INT, array('options' => array('default' => 1, 'min_range' => 1,),)));

  // Calculate the offset for the query
  $offset = ($page - 1)  * $limit;

  // Some information to display to the user
  $start = $offset + 1;
  $end = min(($offset + $limit), $total);

  // Prepare the paged query
  $limit =  (int)$limit;
  $offset = (int)$offset;

  $stmt = $conn->prepare($query2);
  if ($function == "history" || $function == "contacts") {
    $stmt->bind_param('sss', $id, $limit, $offset);
  } elseif ($function == "users") {
    $stmt->bind_param('ss', $limit, $offset);
  }
  $stmt->execute();

  $stmtResult = $stmt->get_result();

  // close the mysql connection
  $stmt->close();
  $conn->close();

// Do we have any results?
if ($stmtResult->num_rows > 0) {
  // Define how we want to fetch the results
  $stmtResult->fetch_assoc();
  $iterator = new IteratorIterator($stmtResult);
?>
<div class="col-md-12">
  <?php if ($function == "history") { ?>
  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Send to</th>
        <th>Message</th>
        <th>Date</th>
        <th>Action</th>
        <th>View</th>
      </tr>
    </thead>
    <tbody>
      <?php
      // Display the results
      $runCount = 0;
      foreach ($iterator as $row) {
      $runCount++; ?>
      <tr>
          <td><?php echo $row['id']; ?></td>
          <td><?php echo $row['sms_to']; ?></td>
          <td><?php echo $row['sms_text']; ?></td>
          <td><?php echo $row['sms_date']; ?></td>
          <td><span onclick="DeleteSMS(<?php echo $row['id'];?>);" class="label label-danger">DELETE SMS</span></td>
          <td><span onclick="ViewSMS(<?php echo $row['id'];?>);" class="label label-primary">VIEW SMS</span></td>
      </tr>
      <?php } ?>
    </tbody>
  </table>
  <?php } elseif ($function == "users") { ?>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Password</th>
          <th>Access</th>
          <th>Edit</th>
          <th>Delete</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Display the results
        $runCount = 0;
        foreach ($iterator as $row) {
        $runCount++; ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo str_repeat('*', strlen($row['hash']));?></td>
            <td><?php echo $row['access']; ?></td>
            <td><span class="label label-info" data-toggle="modal" data-target=".edituser-modal-lg" data-id="<?php echo $row['id']; ?>">EDIT USERS</span></td>
            <td><span onclick="DeleteUser(<?php echo $row['id'];?>);" class="label label-danger">DELETE USER</span></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
    <?php } elseif ($function == "contacts") { ?>
      <table class="table table-bordered">
        <thead>
          <tr>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Number</th>
            <th>Email</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Display the results
          $runCount = 0;
          foreach ($iterator as $row) {
          $runCount++; ?>
          <tr>
              <td><?php echo $row['firstname']; ?></td>
              <td><?php echo $row['lastname']; ?></td>
              <td><?php echo $row['phone_number']; ?></td>
              <td><?php echo $row['email']; ?></td>
              <td><span class="label label-info" data-toggle="modal" data-target=".editcontact-modal-lg" data-id="<?php echo $row['id']; ?>">EDIT CONTACT</span></td>
              <td><span onclick="DeleteContact(<?php echo $row['id'];?>);" class="label label-danger">DELETE CONTACT</span></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    <?php } else { } ?>
  <nav>
  <ul class="pagination pull-right">
  <?php

  if ($page == 1) {
    echo '<li class="disabled"><a href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
  } else {
    echo '<li><a href="?'. $state .'=' . ($page - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
  }

  $i = 0;
  $currentPage = $page;
  while ($i < $pages) {
    $i++;
    // $currentPage is converted to float for some reason?
    if ((int)$currentPage == $i) {
      echo '<li class="active"><a href="?'. $state .'=' . $i .'">'. $i .' <span class="sr-only">(current)</span></a></li>';
    } else {
      echo '<li><a href="?'. $state .'='. $i .'">'. $i .' <span class="sr-only">(current)</span></a></li>';
    }
  }

  if ($page === $pages) {
    echo '<li class="disabled"><a href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
  } else {
    echo '<li><a href="?'. $state .'=' . ($page + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
  }
  ?>
  </ul>
  </nav>
  <div class="totalRcords pull-left">
    <?php echo '<h5>Showing ' . $runCount . ' out of ' . $total .' entries in total. </h5>'; ?>
  </div>
  </div>
  <?php
  } else {
    echo '<p>No results could be displayed.</p>';
  }
  } catch (Exception $e) {
    echo '<p>', $e->getMessage(), '</p>';
  }
?>
