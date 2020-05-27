<?php
session_start();
require "../../php/config.php";

if (isset($_SESSION['person_ID'])){
  try {
    if (isset($_SESSION['leftClub']) ){
      if ($_SESSION['leftClub'] == true){
        $_SESSION['leftClub'] = false;
        ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Successfull!</strong> You successfully left the club.
          </div>
        <?php
        
      }
      
    }
    if (isset($_SESSION['toClub']) ){
      if ($_SESSION['toClub'] == true){
        $_SESSION['toClub'] = false;
        ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Successfull!</strong> You successfully joined the club.
          </div>
        <?php
        
      }
      
    }
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT name, website FROM Club;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $names = array();
    $websites = array();
    foreach($result as $item) {
      array_push($names, $item[0]);
      array_push($websites, $item[1]);
    }
    $sql = "SELECT name FROM Participates WHERE student_ID = :student_ID;";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':student_ID', $_SESSION['person_ID'], PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll();
    $clubs = array();
    foreach($result as $item) {
      array_push($clubs, $item[0]);
    }
    $member = array();
    foreach($names as $item) {
	if(in_array($item, $clubs)) {
	    array_push($member, true);
	}
	else {
	    array_push($member, false);
	}
    }

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }

  if(isset($_GET['details'])) {
        $name_var = $_GET['name_var'];
        header("Location: http://localhost/html/Student/Details_Club.php?name=".$name_var);
        exit();
  }

  if(isset($_GET['join'])) {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "INSERT INTO Participates values(:student_ID ,:name);";
    $name_var = $_GET['name_var'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':student_ID', $_SESSION['person_ID'], PDO::PARAM_INT);
    $statement->bindParam(':name', $name_var, PDO::PARAM_STR);
    $statement->execute();
    $_SESSION['toClub'] = true;
    header("Location: http://localhost/html/Student/Clubs.php");
    exit();
  }

  if(isset($_GET['leave'])) {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "DELETE FROM Participates WHERE student_ID = :student_ID AND name = :name;";
    $name_var = $_GET['name_var'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':student_ID', $_SESSION['person_ID'], PDO::PARAM_INT);
    $statement->bindParam(':name', $name_var, PDO::PARAM_STR);
    $statement->execute();
    $_SESSION['leftClub'] = true;
    header("Location: http://localhost/html/Student/Clubs.php");
    exit();
  }
}else{
  header("Location: http://localhost/html/Login/Login_as_Student.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Clubs | Student</title>
    <link href="../../css/bootstrap.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <h1 class='text-center pb-4 pt-3'>Student Academic Information & Registration System</h1>
    <nav class="navbar sticky-top justify-content-center navbar-expand-lg navbar-dark bg-primary pt-2 pb-2 mx-auto" style="width: 50%;">
      <ul class="nav justify-content-center nav-pills ">
        <li class="nav-item pr-3">
          <a class="nav-link" href="Home.php">Home</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Details.php">Details</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Grades.php">Grades</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Transcript.php">Transcript</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Registration.php">Registration</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link active" href="Clubs.php">Clubs</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Seminars.php">Seminars</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>
      </ul>
    </nav>

    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Name</th>
            <th scope="col">Website</th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
          <!--[if lt IE 9]>
            Tables here - rows
          <![endif]-->
        <tbody>
           <?php for($i = 0; $i < count($names); $i++) { ?>
                <tr>
                <td>
                        <?php echo $names[$i]; ?>
                </td>
                <td>
                        <?php echo $websites[$i]; ?>
                </td>
                <td><button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?details=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Details</a></button></td>
		 <?php if($member[$i] == true) : ?>
                <td><button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?leave=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Leave</a></button></td>
		<?php else : ?>
                <td><button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?join=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Join</a></button></td>
                </tr>
		<?php endif; ?>
           <?php } ?>
        </tbody>
      </table>
    </div>


  </body>
</html>

