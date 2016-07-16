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
          <a class="navbar-brand" href="play"><img src="img/thecircle.png"></a>
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li><a href="play.php">PLAY</a></li>
            <li class="active"><a href="leaderboard.php">LEADERBOARD</a></li>
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
    <h1><a href="results.html">FINAL RESULTS</a></h1>
    <div class="headingc"><h1 class="text-info">LEADERBOARD</h1></div>
    <div class="container">
    <table class="table table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Username</th>
          <th>Level</th>
        </tr>
      </thead>
      <tbody>
        <?php
          include('email.php');
          $leaderboardresult = mysqli_query($dbc, "SELECT username, level FROM users ORDER BY level DESC, lasttime ASC");
          $i = 1;
          while($row = mysqli_fetch_array($leaderboardresult)) {
            echo '<tr><td>' . $i . '</td><td>' . $row['username'] . '</td><td>' . $row['level'] . '</td></tr>';
            //echo $row['username'] . " " . $row['level'];
            $i = $i + 1;
          }
        ?>
        <!--<tr>
          <td>1</td>
          <td>Mark</td>
          <td>1</td>
        </tr>
        <tr>
          <td>2</td>
          <td>Jacob</td>
          <td>1</td>
        </tr>
        <tr>
          <td>3</td>
          <td>Larry</td>
          <td>1</td>
        </tr>-->
      </tbody>
    </table>
    </div>
    <?php
      include('footer.php');
      ?>


<script src="js/jquery-2.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/wordgen.js"></script>
    <script src="js/wordgenuse.js"></script>
  </body>
 </html>