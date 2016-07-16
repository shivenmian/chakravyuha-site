<?php
ob_start();
session_start();
if(!isset($_SESSION['username'])){
header("Location: login.php");
}
?>
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
          <a class="navbar-brand" href="#"><img src="img/thecircle.png"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li class="active"><a href="play.php">PLAY</a></li>
            <li><a href="leaderboard.php">LEADERBOARD</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="text-success"> <?php echo $_SESSION['username']?> </span><span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <div class="headingc"><h1 class="text-info">PLAY</h1></div>
    <div class="jumbotron container level">
    <!-- Anything relevant begins here -->
    <?php
      $load_file = 'levelyoloswag' . $_SESSION['level'] . '.php';
      include ($load_file);
    ?>

    <!-- Anything relevant ends here -->
    	<form method="post" style="text-align:center;margin-top:20px;">
    		<div class="form-group answerform">
    			<center><input type="text" id="answer" name="answer" class="form-control" placeholder=""></center><br>
    			<input type="hidden" name="answersubmitted" value="TRUE" />
        		<input type="submit" class="btn btn-primary" value="SUBMIT" />
        	</div>
    		</form>
    <?php
    	include('email.php');
      $personanswer = md5($_SESSION['username']);
    	$answers = array(
    		0 => "leonardodicaprio",
    		1 => "abrahamlincolnvampirehunter",
        2 => "natesilver",
        3 => "padmavyuha",
        4 => "isaacnewton",
        5 => "jeffreydahmer",
        6 => "abudhabi",
        7 => "malta",
        8 => "dido",
        9 => "hanniballecter",
        10 => "marionjones",
        11 => "lunduniversity",
        12 => "thabombeki",
        13 => "vincenzonatali",
        14 => "ninetails",
        15 => "jeanpierrejeunet",
        16 => "hieronymusbosch",
        17 => "xiaomi",
        18 => "cortana",
        19 => "acquiredimmunodeficiencysyndrome",
        20 => "noorinayatkhan",
        21 => "dQw4w9WgXcQ",
        22 => $personanswer
		);
		if (isset($_POST['answersubmitted'])) {
			if (empty($_POST['answer'])) {//if the email supplied is empty
 			echo '<div class="container alert alert-danger">No answer was given. Try harder.</div>';
 			} else {
 				$levelno = $_SESSION['level'];
 				if (preg_match("/^[a-zA-Z0-9]*$/", $_POST['answer']) && $_POST['answer'] == $answers[$levelno]) {
 					$levelnew = $_SESSION['level'] + 1;
 					$curruser = $_SESSION['username'];
          $timeright = $_SERVER['REQUEST_TIME'];
 					$updating1 = "UPDATE users SET level='$levelnew' WHERE username='$curruser'";
 					mysqli_query($dbc, $updating1);
          $updating2 = "UPDATE users SET lasttime='$timeright' WHERE username='$curruser'";
          mysqli_query($dbc, $updating2);
 					$refresh_session_variables = mysqli_query($dbc, "SELECT * FROM users WHERE username='$curruser'");
 					$_SESSION = mysqli_fetch_array($refresh_session_variables, MYSQLI_ASSOC);
 					header("Location: play.php");
 				} else {
 					echo '<div class="container alert alert-warning">Incorrect answer. Think again.</div>';
          $src = rand(1, 6);
          echo '<video width="640" height="480" controls><source src="img/no/no' . $src . '.mp4" type="video/mp4">Your browser does not support our sad video.</video>';
 				}
 			}
 		}
	?>
    </div>
    <?php
      include('footer.php');
    ?>

    <!-- MY JAVASCRIPT, BITCH -->
    <!-- ==================== -->
    <script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wordgen.js"></script>
    <script src="js/wordgenuse.js"></script>
  </body>
 </html>