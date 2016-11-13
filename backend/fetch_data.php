<?php
/*
* Copyright 2016 Skovdev. All rights reserved.
*/

include_once("config/mysql_conn.php");
if ((isset($_POST['rowid']) && !empty($_POST['rowid'])) && (isset($_POST['purpose']) && !empty($_POST['purpose']))) {
  $id = $_POST['rowid'];
  $purpose = $_POST['purpose'];
}

// get phonebook info
if ($purpose == "contact") {
  $conn = connectDB();
  $stmt = $conn->prepare("SELECT * FROM phonebook WHERE id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $conn->close();
  $stmt->close();
  ?>
  <form name="editcontact" action="../backend/Actions.php" method="POST">
    <div class="form-group">
      <label for="firstname">Firstname</label>
      <input type="text" class="form-control" id="InputFirstName" name="InputFirstName" placeholder="Jane" value="<?php echo $result['firstname']; ?>" required>
    </div>
    <div class="form-group">
      <label for="lastname">Lastname</label>
      <input type="text" class="form-control" id="InputLastName" name="InputLastName" placeholder="Doe" value="<?php echo $result['lastname']; ?>" required>
    </div>
    <div class="form-group">
      <label for="number">Phone Number</label>
      <input type="text" class="form-control" id="InputNumber" name="InputNumber" placeholder="+4522994488" value="<?php echo $result['phone_number']; ?>" required>
    </div>
    <div class="form-group">
      <label for="number">Email address</label>
      <input type="email" class="form-control" id="InputEmail" name="InputEmail" placeholder="jane@doe.com" value="<?php echo $result['email']; ?>">
    </div>
    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
    <p>Please note: All fields must be filed out!</p>
  </div>
  <div class="modal-footer">
  <button type="button" class="btn btn-defualt" data-dismiss="modal">Close</button>
  <button type="button commit" class="btn btn-primary">Save contact</button>
  </div>
  </form>
<?php } elseif ($purpose == "user") {
  $conn = connectDB();
  $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
  $stmt->bind_param('s', $id);
  $stmt->execute();
  $result = $stmt->get_result()->fetch_assoc();
  $conn->close();
  $stmt->close();
?>

<form name="edituser" action="../backend/Actions.php" method="POST">
  <div class="form-group">
    <label for="username">Username</label>
    <input type="username" class="form-control" id="InputUsername" name="InputUsername" placeholder="Admin" value="<?php echo $result['username']; ?>" required>
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input type="password" class="form-control" id="InputPassword" name="InputPassword" placeholder="********" value="<?php echo $result['hash']; ?>" required>
  </div>
  <div class="form-group">
    <label for="access">Access</label>
    <input type="text" class="form-control" id="InputAccess" name="InputAccess" placeholder="5" value="<?php echo $result['access']; ?>" required>
  </div>
  <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
  <p>Please note: All fields must be filed out!</p>
</div>
<div class="modal-footer">
<button type="button" class="btn btn-defualt" data-dismiss="modal">Close</button>
<button type="button commit" class="btn btn-primary">Save user</button>
</div>
</form>

<?php } else { } ?>
