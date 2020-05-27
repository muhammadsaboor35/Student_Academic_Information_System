<?php
session_start();
if (isset($_SESSION['person_ID'])){
$p_ID = $_SESSION['person_ID'];
$c_ID = $_SESSION['ListStudent_Button'];

try {
  
  require "../../php/config.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT person_ID, first_name, last_name FROM (Person P, Student_Sections S) WHERE S.course_ID = :c_ID AND S.student_ID = P.person_ID";

  $statement = $connection->prepare($sql);
  $statement->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
  $statement->execute();
  $result = $statement->fetchAll();
  
  $student_IDs = array();
  $nameF = array();
  $nameL = array();

  //echo '<pre>'; print_r($result); echo '</pre>';

  foreach($result as $temp) {
    array_push($student_IDs, $temp[0]);
    array_push($nameF, $temp[1]);
    array_push($nameL, $temp[2]);
  }//copying dynamic number of elements

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
    <title>List | Students</title>
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
          <a class="nav-link" href="Courses.php">Back</a>
        </li>

      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <p> List of Students: </p>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Student ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
          </tr>
        </thead>
        <tbody>

           <?php for($i = 0; $i < count($student_IDs); $i++) { ?>
            <tr>
            <td><?php  echo $student_IDs[$i] ?></td>
            <td><?php  echo $nameF[$i] ?></td>
            <td><?php  echo $nameL[$i] ?></td>
            <td><button type="button" class="btn btn-primary btn-sm"><a class="nav-link" href="Email_Special.php?id=<?php echo $student_IDs[$i]; ?>">Email</a></button></td>
          </tr>
           <?php } ?>
        </tbody>
      </table>
    </div>

  </body>
</html>