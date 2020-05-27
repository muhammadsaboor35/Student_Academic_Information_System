<?php
session_start();
if (isset($_SESSION['person_ID'])){
  $p_ID = $_SESSION['person_ID'];
  require "../../php/config.php";

  if(isset($_GET['name'])) {
    $name = $_GET['name'];
  }
  else if(isset($_POST['name'])) {
    $name = $_POST['name'];

  }
  if(isset($_GET['date'])) {
    $date = $_GET['date'];
  }
  else if(isset($_POST['date'])) {
    $date = $_POST['date'];

  }
  if(isset($_GET['host_ID'])) {
    $host_ID = $_GET['host_ID'];
  }
  else if(isset($_POST['host_ID'])) {
    $host_ID = $_POST['host_ID'];

  }
  if(isset($_GET['join'])) {
          $name = $_GET['name_var'];
          $date = $_GET['date'];
          $host_ID = $_GET['host_ID'];
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT person_ID FROM Attends WHERE name = :name_var AND seminar_date = :date AND host_ID = :host_ID;";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name_var', $name, PDO::PARAM_STR);
    $statement->bindParam(':date', $date, PDO::PARAM_STR);
    $statement->bindParam(':host_ID', $host_ID, PDO::PARAM_INT);
    $statement->execute();
    $result = $statement->fetchAll();
    $already_joined = false;
    foreach($result as $item) {
      if($item[0] == $_SESSION['person_ID']) {
          $already_joined = true;
      }
    }
    if($already_joined == true) {
      //show warning
      echo '<div class="alert alert-dismissible alert-danger">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Already attending!</strong> You are already attending this seminar.
  </div>';
  header( "refresh:5;url=http://localhost/html/Student/Seminars.php" );

    }
    else {
      //update
    $connection = new PDO($dsn, $username, $password, $options);

      $sql = "INSERT INTO Attends VALUES(:name_var, :seminar_date, :host_ID, :person_ID);";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name_var', $name, PDO::PARAM_STR);
    $statement->bindParam(':seminar_date', $date, PDO::PARAM_STR);
    $statement->bindParam(':host_ID', $host_ID, PDO::PARAM_INT);
    $statement->bindParam(':person_ID', $_SESSION['person_ID'], PDO::PARAM_INT);
    $statement->execute();
  echo '<div class="alert alert-dismissible alert-success">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong>Successfull!</strong> You are registered for the seminar.
  </div>';
  header( "refresh:5;url=http://localhost/html/Student/Seminars.php" );
    }
  }
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT seminar_time, room, duration, first_name, last_name FROM Seminar, Person WHERE name=:name AND seminar_date=:date AND host_ID=:host_ID AND host_ID = person_ID";
    $statement = $connection->prepare($sql);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->bindParam(":date", $date, PDO::PARAM_STR);
    $statement->bindParam(":host_ID", $host_ID, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    $time = $result[0][0];
    $room = $result[0][1];
    $duration = $result[0][2];
    $host_first_name = $result[0][3];
    $host_last_name = $result[0][4];
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
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
    <title>Seminar Details | Students</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
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
          <a class="nav-link" href="Clubs.php">Clubs</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link active" href="Seminars.php">Seminars</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>
      </ul>
    </nav>
    <!--[if lt IE 9]>
     Tables here - column
    <![endif]-->
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
          <!--[if lt IE 9]>
            Tables here - rows
          <![endif]-->
        <tbody>
		<tr> <td> Name </td> <td> <?php echo $name ?></td> </tr>
		<tr> <td> Date </td> <td> <?php echo $date ?> </td> </tr>
		<tr> <td> Time </td> <td> <?php echo $time ?></td> </tr>
		<tr> <td> Room </td> <td> <?php echo $room ?></td> </tr>
		<tr> <td> Duration </td> <td> <?php echo $duration ?></td> </tr>
		<tr> <td> Host </td> <td> <?php echo $host_first_name." ".$host_last_name ?></td> </tr>
        </tbody>
      </table>
   </div>
   <div class="row">
      <div class="col-sm-12">
         <div class="text-center">
               <td><button type="button" class="btn btn-primary btn-sm"><a href="Details_Seminar.php?join=true&name_var=<?php echo $_GET['name']; ?>&date=<?php echo $_GET['date']; ?>&host_ID=<?php echo $_GET['host_ID']; ?>" class="nav-link">Join Seminar</a></button></td>
         </div>
      </div>
   </div>
  </body>
</html>
