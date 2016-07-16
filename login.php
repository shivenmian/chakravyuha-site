<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="img/thecircle.png">

    <title>Chakravyuha</title>

    <!-- CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/chakravyuha.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="navbar navbar-default navbar-static-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="index.php"><img src="img/thecircle.png"></a>
        </div>
        <div class="navbar-collapse collapse">
          <form action="login.php" method="post" class="navbar-nav navbar-form navbar-right" role="search">
            <div class="form-group">
              <input type="text" id="username" name="username" class="form-control" placeholder="USERNAME">
              <input type="password" id="Password" name="Password" class="form-control" placeholder="PASSWORD">
            </div>
            <input type="hidden" name="formsubmitted" value="TRUE" />
            <input type="submit" class="btn btn-primary" value="LOGIN" />
          </form>
        </div><!--/.nav-collapse -->
      </div>
    </div>
<?php
include ('email.php');
if (isset($_POST['formsubmitted'])) {
 // Initialize a session:
session_start();
 $error = array();//this aaray will store all error messages

 if (empty($_POST['username'])) {//if the email supplied is empty
 $error[] = 'You forgot to enter  your Username ';
 } else {

 if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $_POST['username'])) {
 $Email = $_POST['username'];
 } else {
 $error[] = 'Your username is invalid  ';
 }
}

if (empty($_POST['Password'])) {
 $error[] = 'Please Enter Your Password ';
 } else {
 $Password = $_POST['Password'];
 }

 if (empty($error))//if the array is empty , it means no error found
 {
$query_check_credentials = "SELECT * FROM users WHERE (username='$Email' AND password='$Password') AND activation IS NULL";
 $result_check_credentials = mysqli_query($dbc, $query_check_credentials);
 if(!$result_check_credentials){//If the QUery Failed
 echo 'Query Failed ';
 }

 if (@mysqli_num_rows($result_check_credentials) == 1)//if Query is successfull
 { // A match was made.

 $_SESSION = mysqli_fetch_array($result_check_credentials, MYSQLI_ASSOC);

//Assign the result of this query to SESSION Global Variable

 header("Location: play.php");

 }else
 { $msg_error= 'Uh oh. There seems to be a problem. Your username/password combination is invalid. Or maybe you have made a super boo boo by not activating your account. Check your email, dawg.';
 }
}  else {
 echo '<div> <ol>';
 foreach ($error as $key => $values) {
 echo '    <li>'.$values.'</li>';
}
 echo '</ol></div>';
}
 if(isset($msg_error)){
 echo '<div class="container alert alert-danger">'.$msg_error.' </div>';
 }
 /// var_dump($error);
 mysqli_close($dbc);
} // End of the main Submit conditional.
?>

<script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wordgen.js"></script>
    <script src="js/wordgenuse.js"></script>
  </body>
 </html>