<!-- php scripts -->
<?php
session_start();
require "../../php/config.php";


if (isset($_SESSION['person_ID'])){
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_SESSION['person_ID'];
    $curr_semester = $_SESSION['curr_semester'];
    $curr_year = $_SESSION['curr_year'];
    $course_ID = $_SESSION['course_ID'];

    $sql = "SELECT can_register FROM Student WHERE student_ID = $id;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $allow = $statement->fetchAll()[0]['can_register'];
    
    $sql = "SELECT sec_ID, first_name, last_name, instructor_ID, quota, day, time 
            FROM Sections NATURAL JOIN Time_Slot NATURAL JOIN Has_Schedule 
                  NATURAL JOIN Instructor INNER JOIN Person ON (instructor_ID = person_ID) 
            WHERE course_ID = '$course_ID' and semester = '$curr_semester' and year = $curr_year;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $sections = $statement->fetchAll();
    
    $no_students = array();
    foreach ($sections as $section){
      $section_ID = $section['sec_ID'];
      $sql = "SELECT COUNT(student_ID) FROM Student_Sections 
              WHERE course_ID = '$course_ID' and sec_ID = $section_ID 
              and year = $curr_year and semester = '$curr_semester';";
      $statement = $connection->prepare($sql);
      $statement->execute();
      array_push($no_students, $statement->fetchAll()[0]['COUNT(student_ID)']);
    }
    foreach ($sections as $section){
      $section_ID = $section['sec_ID'];
      if (isset($_POST[$section_ID])){
        $sql = "SELECT course_ID, name FROM Student_Sections natural join Has_Schedule natural join
                                       Time_Slot natural join Course 
                WHERE student_ID = $id and semester = '$curr_semester' and year = $curr_year and 
                (day, time) in (SELECT day, time FROM Sections NATURAL JOIN Time_Slot 
                NATURAL JOIN Has_Schedule NATURAL JOIN Instructor INNER JOIN Person 
                ON (instructor_ID = person_ID) WHERE course_ID = '$course_ID' and sec_ID = $section_ID 
                and semester = '$curr_semester' and year = $curr_year);";
    
        $statement = $connection->prepare($sql);
        $statement->execute();
        $check = $statement->fetchAll();
        if (count($check) > 0){?>
          <div class="alert alert-dismissible alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error!</strong> <a href="#" class="alert-link">Clash with</a> <?php echo $check[0]['course_ID'] ?>
          </div>
        <?php break;}
        else{
          $sql = "SELECT current_semester FROM Student WHERE student_ID = $id;";
          $statement = $connection->prepare($sql);
          $statement->execute();
          $sem_no = $statement->fetchAll()[0]['current_semester'];
          $section_ID = $section['sec_ID'];
          $inst = $section['instructor_ID'];
          $_SESSION['registered'] = true;
          $sql = "INSERT INTO Student_Sections values($id, '$course_ID', $inst, $section_ID, '$curr_semester', $curr_year, NULL, $sem_no);";
    
          $statement = $connection->prepare($sql);
          $statement->execute();
          header("LOCATION: Registration.php");
        }
      }
    }
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
    <div class="dropdown-divider pt-4"></div>
    <h2 class='text-center'><?php echo $course_ID; echo " | "; echo  $_SESSION['name'];?></h2>
    <?php if ($allow == "Yes"){ ?>
      <div class="dropdown-divider pt-4"></div>
      <div class="container">
        <div class="jumbotron">
          <table class="table table-hover justify-content-center text-center">
            <thead>
              <tr class="table-secondary">
                <th scope="col">Section ID</th>
                <th scope="col">Instructor Name</th>
                <th scope="col">Quota</th>
                <th scope="col">Time Slot</th>
                <th scope="col">Register</th>
              </tr>
            </thead>
            <?php $x = 0;
            foreach($sections as $section){
              if ($section['sec_ID'] >= $x+1){?>
              <tbody>
                <tr >
                  <td><?php echo $section['sec_ID']; ?></td>
                  <td><?php echo $section['first_name']; echo " "; echo $section['last_name'];?></td>
                  <td><?php  
                        echo $no_students[$x]; echo " / ";
                        echo $section['quota'];?></td>
                  <td><?php 
                    for($y = $x; $y < count($sections); $y++){
                      if ($section['sec_ID'] == $sections[$y]['sec_ID']){
                        echo $sections[$y]['day']; echo ": "; echo $sections[$y]['time'];echo "<br>";
                      }
                    }
                  ?></td>
                  <td>
                    <form method="post" action="">
                      <?php 
                        $name = $section['sec_ID'];
                      ?>
                      <input type="submit" class="btn btn-primary" name="<?php echo $name; ?>" role="button" value="R">
                    </form>
                  </td>
                </tr>
              </tbody>
                  <?php }$x = $x + 1;} ?>
          </table>
        </div>
      </div>
    <?php } ?>

  </body>
</html>