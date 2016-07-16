<?php
include ('email.php');
if (isset($_GET['email']) && preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/',
 $_GET['email'])) {
 $email = $_GET['email'];
}
if (isset($_GET['key']) && (strlen($_GET['key']) == 32))
 //The Activation key will always be 32 since it is MD5 Hash
 {
 $key = $_GET['key'];
}

if (isset($email) && isset($key)) {

 // Update the database to set the "activation" field to null

 $query_activate_account = "UPDATE users SET activation=NULL WHERE(email ='$email' AND activation='$key')LIMIT 1";
 $result_activate_account = mysqli_query($dbc, $query_activate_account);

 // Print a customized message:
 if (mysqli_affected_rows($dbc) == 1) //if update query was successfull
 {
 echo '<div>Your account is now active. You may now <a href="index.php">Log in</a></div>';

 } else {
 echo '<div>Oops !Your account could not be activated. Please recheck the link or contact the system administrator.</div>';

 }

 mysqli_close($dbc);

} else {
 echo '<div>Error Occured .</div>';
}

?>