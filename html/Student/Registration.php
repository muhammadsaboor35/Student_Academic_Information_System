<!-- php scripts -->
<?php
session_start();
require "../../php/config.php";


if (isset($_SESSION['person_ID'])){
  try {
    if (isset($_SESSION['registered']) ){
      if ($_SESSION['registered'] == true){
        $_SESSION['registered'] = false;
        ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Successfull!</strong> You successfully registered for the course.
          </div>
        <?php
        
      }
      
    }
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_SESSION['person_ID'];
    $curr_semester = $_SESSION['curr_semester'];
    $curr_year = $_SESSION['curr_year'];
    
    $sql = "SELECT can_register FROM Student WHERE student_ID = $id;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $allow = $statement->fetchAll()[0]['can_register'];

    $sql = "SELECT DISTINCT course_ID, name, dept FROM Course natural join Has_Schedule 
              WHERE year = $curr_year and semester = '$curr_semester' and 
              course_ID not in (Select course_ID from Student_Sections where student_ID = $id);";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $courses = $statement->fetchAll();
    if ($allow == "Yes"){
      foreach ($courses as $course){
        $name = sprintf("%s", $course['course_ID']);
        if (isset($_POST[$name])){
          $sql = "SELECT pre_course_ID FROM Requires WHERE course_ID = '$name' and pre_course_ID not in
                  (SELECT course_ID FROM Student_Sections WHERE student_ID = $id);";
          $statement = $connection->prepare($sql);
          $statement->execute();
          $preReqs = $statement->fetchAll();
          if (count($preReqs)>0){?>
            <div class="alert alert-dismissible alert-danger">
              <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Error!</strong> <a href="#" class="alert-link">Pre-requisites not satisfied</a> to register.
            </div>
    <?php }
          else{
            $_SESSION['course_ID'] = $name;
            $_SESSION['name'] = $course['name'];
            header("LOCATION: RegistrationSections.php");
          }
        }
      }
    }
    else{ ?>
      <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Error!</strong> <a href="#" class="alert-link">Not allowed</a> to register.
        </div>
<?php }
  }catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}else{
  header("Location: http://localhost/html/Login/Login_as_Student.php");
    exit();
}

?>


<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Registration | Student</title>
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
          <a class="nav-link active" href="Registration.php">Registration</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Clubs.php">Clubs</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Seminars.php">Seminars</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>
      </ul>
    </nav>

    <?php if ($allow == "Yes"){ ?>
      <div class="dropdown-divider pt-4"></div>
      <div class="container">
        <div class="jumbotron">
          <table class="table table-hover justify-content-center text-center">
            <thead>
              <tr class="table-secondary">
                <th scope="col">Course ID</th>
                <th scope="col">Course Name</th>
                <th scope="col">Department</th>
                <th scope="col">Register</th>
              </tr>
            </thead>
            <?php 
            foreach($courses as $course){?>
              <tbody>
                <tr >
                  <td><?php echo $course['course_ID']; ?></td>
                  <td><?php echo $course['name']; ?></td>
                  <td><?php echo $course['dept']; ?></td>
                  <td>
                    <form method="post" action="">
                      <?php 
                        $name = $course['course_ID'];
                      ?>
                      <input type="submit" class="btn btn-primary" name="<?php echo $name; ?>" role="button" value="R">
                    </form>
                  </td>
                </tr>
              </tbody>
            <?php } ?>
          </table>
        </div>
      </div>
    <?php } ?>

  </body>
</html>