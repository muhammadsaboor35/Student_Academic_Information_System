<?php
session_start();

if (isset($_SESSION['person_ID'])){
$_SESSION['curr_semester'] = "Spring";
$_SESSION['curr_year'] = date("Y");
$p_ID = $_SESSION['person_ID'];

try {
  
  require "../../php/config.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT first_name, last_name, email, gender, phone FROM Person WHERE person_ID = :p_ID";
  $statement = $connection->prepare($sql);
  $statement->bindParam(':p_ID', $p_ID, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetchAll();

  if(isset($result[0])) {
    $firstN = $result[0][0];
    $secondN = $result[0][1];
    $emailT = $result[0][2];
    $genderT = $result[0][3];
    $phoneT = $result[0][4];
  }

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}

try {
  $sql = "SELECT name FROM Dept_Person WHERE person_ID = :p_ID";
  $statement = $connection->prepare($sql);
  $statement->bindParam(':p_ID', $p_ID, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetchAll();

if(isset($result[0])) {
  $deptN = $result[0][0];
}

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
    <title>Home | Teaching Assistant</title>
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
          <a class="nav-link active" href="Home.php">Home</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Courses.php">Courses</a>
        </li>

        <li class="nav-item pr-3">
          <a class="nav-link" href="Email.php">Email</a>
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
        <thead>
          <tr class="table-secondary">
            <th scope="col">Type</th>
            <th scope="col">Information</th>
          </tr>
        </thead>
          <!--[if lt IE 9]>
            Tables here - rows
          <![endif]-->
        <tbody>
          <tr >
            <th scope="row">Name</th>
            <td><?php  echo $firstN ?></td>
          </tr>

          <tr>
            <th scope="row">Last Name</th>
            <td><?php  echo $secondN ?></td>
          </tr>

          <tr>
            <th scope="row">Gender</th>
            <td><?php  echo $genderT ?></td>
          </tr>

          <tr>
            <th scope="row">Department</th>
            <td><?php  echo $deptN ?></td>
          </tr>

          <tr>
            <th scope="row">Email</th>
            <td><?php  echo $emailT ?></td>
          </tr>

          <tr>
            <th scope="row">Contact Number</th>
            <td><?php  echo $phoneT ?></td>
          </tr>

        </tbody>
      </table>
    </div>

  </body>
</html>
