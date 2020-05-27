<?php
session_start();
  if (isset($_SESSION['person_ID'])){
  $s_ID = $_GET['id'];; //getting id of student to show
  $address= 'None Provided';
try {
  
  require "../../php/config.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT email FROM Person WHERE person_ID = :s_ID";

  $statement = $connection->prepare($sql);
  $statement->bindParam(':s_ID', $s_ID, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetchAll();
    $address = $result[0][0];
} catch(PDOException $error) {
    echo "error 35";
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
    <title>Student Email Address</title>
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
          <a class="nav-link" href="List_Student.php">Back</a>
        </li>

      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <p> Student id: <?php echo $s_ID; ?></p>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <p> The Email Address: <?php echo $address; ?></p>
    </div>

  </body>
</html>