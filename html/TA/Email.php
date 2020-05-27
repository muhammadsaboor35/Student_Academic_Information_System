<?php
session_start();

if (isset($_SESSION['person_ID'])){
$p_ID = $_SESSION['person_ID'];

try {
  
  require "../../php/config.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT C.course_ID, C.name, C.dept FROM (Course C, Assists A) WHERE A.ta_ID = :p_ID AND C.course_ID = A.course_ID";

  $statement = $connection->prepare($sql);
  $statement->bindParam(':p_ID', $p_ID, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetchAll();
  
  $course_IDs = array();
  $names = array();
  $depts = array();

  //echo '<pre>'; print_r($result); echo '</pre>';

  foreach($result as $temp) {
    array_push($course_IDs, $temp[0]);
    array_push($names, $temp[1]);
    array_push($depts, $temp[2]);
  }//copying dynamic number of elements

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
} 

if(isset($_GET['Email_Button'])) {
    $_SESSION['Email_Button'] = $_GET['Email_Button'];
    header("Location: Email_Student.php" );
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
    <title>List | Courses | Email</title>
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
          <a class="nav-link" href="Courses.php">Courses</a>
        </li>

        <li class="nav-item pr-3">
          <a class="nav-link active" href="Email.php">Email</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>

      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <p> Can send email to following courses: </p>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Course ID</th>
            <th scope="col">Course Name</th>
            <th scope="col">Department</th>
          </tr>
        </thead>
        <tbody>

           <?php for($i = 0; $i < count($depts); $i++) { ?>
            <tr>
            <td><?php  echo $course_IDs[$i] ?></td>
            <td><?php  echo $names[$i] ?></td>
            <td><?php  echo $depts[$i] ?></td>

            <form>
            <td><button type="submit" value="<?php echo $course_IDs[$i]; ?>" name= "Email_Button" class="btn btn-primary btn-sm">Email Students</button></td>
            </form>

          </tr>
           <?php } ?>
        </tbody>
      </table>
    </div>

  </body>
</html>