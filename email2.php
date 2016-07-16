<?php
include ('email.php');
require_once('recaptchalib.php');
$privatekey = "6LfiPPgSAAAAAAUvXBKuwI8SRQrioZ-yjdfqUe89";
if (isset($_POST['formsubmitted'])) {
    $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

  if (!$resp->is_valid) {
    // What happens when the CAPTCHA was entered incorrectly
    die ("The reCAPTCHA wasn't entered correctly. Go back and try it again." .
         "(reCAPTCHA said: " . $resp->error . ")");
  } else {
    // Your code here to handle a successful verification
    $error = array(); //Declare An Array to store any error message
    if (empty($_POST['inputUsername'])) { //if no name has been supplied
        $error[] = 'Please Enter a name '; //add to array "error"
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
            echo ' Database Error Occured ';
        }

        if (mysqli_num_rows($result_verify_email) == 0) { // IF no previous user is using this email .

            // Create a unique  activation code:
            $activation = md5(uniqid(rand(), true));
            $timerightnow = time();
            $query_insert_user =
                "INSERT INTO `users` ( `username`, `email`, `password`, `activation`, `lasttime`) VALUES ( '$name', '$Email', '$Password', '$activation', '$timerightnow')";

            $result_insert_user = mysqli_query($dbc, $query_insert_user);
            if (!$result_insert_user) {
                echo 'Query Failed ';
            }

            if (mysqli_affected_rows($dbc) == 1) { //If the Insert Query was successfull.

                // Send the email:
                $message = " Hi, there. Thanks for registering at Chakravyuha. To activate your account, please visit the link:\n\n";
                $message .= WEBSITE_URL . 'activation.php?email=' . urlencode($Email) . "&key=$activation";
                $message .= "\n\nUsername: " . $_POST['inputUsername'] . "\nPassword: " . $_POST['inputPassword'];
                mail($Email, 'Registration Confirmation', $message, 'From:'.EMAIL);

                // Flush the buffered output.

                // Finish the page:
                echo '<div class="bg-success">Thank you for registering! A confirmation email which includes your username and password has been sent to ' . $Email . '<br>Please click on the Activation Link to Activate your account. <a href="index.php">Click here</a> to go back to the main website. </div>';
            } else { // If it did not run OK.
                echo '<div class="errormsgbox">Well, that username exists already. Choose a way cooler one now!</div>';
            }

        } else { // The email address is not available.
            echo '<div class="errormsgbox" >That email
address has already been registered.
</div>';
        }

    } else { //If the "error" array contains error msg , display them

        echo '<div class="errormsgbox"> <ol>';
        foreach ($error as $key => $values) {

            echo '	<li>' . $values . '</li>';

        }
        echo '</ol></div>';

    }
}
    mysqli_close($dbc); //Close the DB Connection

} // End of the main Submit conditional.

?>