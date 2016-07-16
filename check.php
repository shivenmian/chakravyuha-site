<?php
include ('email.php');
if (isset($_POST['formsubmitted'])) {
	if (empty($_POST['answer'])) {//if the email supplied is empty
 		echo "No answer was given. Try harder.";
 	} else {
 		$levelno = $_SESSION['level']
 		$answer_query = "SELECT lvlanswer FROM answersdb WHERE lvl=$levelno";
 		$result_check = mysqli_query($dbc, $answer_query);
 		echo $result_check;
 	}
 }
?>