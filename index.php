<?php
ob_start();
session_start();
if(!isset($_SESSION['username'])){
include("login.php");
} else {
	header("Location: play.php");
}
ob_flush();
?> <div class="container">
      <div class="jumbotron">
        <h1>Welcome to Chakravyuha!</h1>
        <p>Hey, you. Chakravyuha is an enticing online treasure hunt part of <a href="http://www.esya.iiitd.edu.in/">Esya '14</a>. Embark on a mind-bending task to find and solve clues which lead to a single answer.</p>
        <p>Don't forget to read the <a href="rules.html">rules</a>.</p>
        <p>You can quickly sign up below to participate and win prizes worth Rs. 9000!</p><br>
        <?php
require_once('recaptchalib.php');
$privatekey = "6LfiPPgSAAAAAAUvXBKuwI8SRQrioZ-yjdfqUe89";
if (isset($_POST['signupformsubmitted'])) {
    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    echo '<a href="index.php">Go back.</a>';
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
    // Your code here to handle a successful verification
    $error = array(); //Declare An Array to store any error message
    if (empty($_POST['inputUsername'])) { //if no name has been supplied
        $error[] = 'Please Enter a usernname '; //add to array "error"
    } else {
        $name = $_POST['inputUsername']; //else assign it a variable
    }

    if (empty($_POST['inputEmail'])) {
        $error[] = 'Please Enter your Email ';
    } else {

        if (preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $_POST['inputEmail']) && preg_match("/^[a-zA-Z]*$/", $_POST['inputUsername'])) {
            //regular expression for email validation
            $Email = $_POST['inputEmail'];
        } else {
            $error[] = 'Your EMail Address or Username is invalid  ';
        }

    }

    if (empty($_POST['inputPassword'])) {
        $error[] = 'Please Enter Your Password ';
    } else {
        $Password = $_POST['inputPassword'];
    }

    if (empty($error)) //send to Database if there's no error '

    { // If everything's OK...

        // Make sure the email address is available:
        $query_verify_email = "SELECT * FROM users WHERE email ='$Email'";
        $result_verify_email = mysqli_query($dbc, $query_verify_email);
        if (!$result_verify_email) { //if the Query Failed ,similar to if($result_verify_email==false)
            echo '<span class="container alert alert-danger"> Database Error Occured. Try again later.</span> ';
        }

        if (mysqli_num_rows($result_verify_email) == 0) { // IF no previous user is using this email .

            // Create a unique  activation code:
            $activation = md5(uniqid(rand(), true));
            $timerightnow = time();
            $query_insert_user =
                "INSERT INTO `users` ( `username`, `email`, `password`, `activation`, `lasttime`) VALUES ( '$name', '$Email', '$Password', '$activation', '$timerightnow')";

            $result_insert_user = mysqli_query($dbc, $query_insert_user);
            if (!$result_insert_user) {
                echo '<span class="container alert alert-danger">&nbsp;&nbsp:&nbsp;&nbsp:&nbsp:&nbsp:&nbsp:There were some issues.</span> ';
            }

            if (mysqli_affected_rows($dbc) == 1) { //If the Insert Query was successfull.

                // Send the email:
                $message = " Hi, there. Thanks for registering at Chakravyuha. To activate your account, please visit the link:\n\n";
                $message .= WEBSITE_URL . 'activation.php?email=' . urlencode($Email) . "&key=$activation";
                $message .= "\n\nUsername: " . $_POST['inputUsername'] . "\nPassword: " . $_POST['inputPassword'];
                mail($Email, 'Registration Confirmation', $message, 'From:'.EMAIL);

                // Flush the buffered output.

                // Finish the page:
                echo '<div class="container alert alert-success">&nbsp:&nbsp:&nbsp:Thank you for registering! A confirmation email which includes your username and password has been sent to ' . $Email . '<br>Please click on the Activation Link to Activate your account.</div>';
            } else { // If it did not run OK.
                echo '<span class="container alert alert-danger">&nbsp:&nbsp:&nbsp:&nbsp:&nbsp:Well, that username or email ID exists already. Choose a way cooler one now!</span>';
            }

        } else { // The email address is not available.
            echo '<span class="text-danger">That email
address has already been registered.
</span>';
        }

    } else { //If the "error" array contains error msg , display them

        echo '<div class="container alert alert-danger"> <ol>';
        foreach ($error as $key => $values) {

            echo '  <li>' . $values . '</li>';

        }
        echo '</ol></div>';

    }
}
    mysqli_close($dbc); //Close the DB Connection

} // End of the main Submit conditional.

?>
        <p>
          <form class="form-horizontal login registration_form" method="post">
            <fieldset>
              <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Username</label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Username">
                </div>
                <div class="col-lg-2">
                  <a class="btn btn-info" id="usernamebtn">Generate a <del>funny</del>  one.</a>
                </div>
              </div>
              <div class="form-group">
                <label for="inputPassword" class="col-lg-2 control-label">Password</label>
                <div class="col-lg-4">
                  <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Password">
                </div>
                <div class="col-lg-2">
                  <a class="btn btn-info" id="passwordbtn">Generate a strong one.</a>
                </div>
                <div class="col-lg-4 alert alert-warning" id="password-alert">
                  Heads up! Your generated password is "<b id="generated-pass"></b>", without the quotes. Save it somewhere safe.
                </div>
              </div>
              <div class="form-group">
                <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                <div class="col-lg-4">
                  <input type="text" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email">
                </div>
                <div class="col-lg-2">
                  <a class="btn btn-info btn-disabled" href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Don't click this.</a>
                </div>
              </div><br>
              <div class="row"><div class="col-md-2"></div><div class="col-md-10">
              <?php
                require_once('recaptchalib.php');
                $publickey = "6LfiPPgSAAAAAKk8BvQuMannjzwwZSoYtXOOJVp0"; // you got this from the signup page
                echo recaptcha_get_html($publickey);
              ?></div><div class="col-md-3"></div></div><br><br><div class="row"><div class="col-md-2"></div><div class="col-md-10">
              <div class="submit">
                <input type="hidden" name="signupformsubmitted" value="TRUE"></input>
                <input class="btn btn-lg btn-primary" type="submit" value="Enter the rabbit hole &raquo;"></input>
              </div></div></div>
            </fieldset>
          </form>
        </p>
      </div>
    </div>
    <?php include('footer.php'); ?>
    <!-- MY JAVASCRIPT, BITCH -->
    <!-- ==================== -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wordgen.js"></script>
    <script src="js/wordgenuse.js"></script>
  </body>
</html>