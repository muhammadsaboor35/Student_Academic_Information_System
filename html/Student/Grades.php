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
    
    $sql = "SELECT course_ID FROM Student_Sections 
            WHERE student_ID = $id and semester = '$curr_semester' and year = $curr_year;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $courses = $statement->fetchAll();
    
    $sql = "SELECT score, total_score, start_date, course_ID 
            FROM Task natural join Attendance natural join grades_submission natural join Student_Sections 
            WHERE student_ID = $id and semester = '$curr_semester' and year = $curr_year;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $attendances = $statement->fetchAll();

    $sql = "SELECT course_ID, score, total_score, task_name 
            FROM Task  natural join grades_submission natural join Student_Sections
            WHERE student_ID = $id and semester = '$curr_semester' and year = $curr_year and
            (task_ID, course_ID) not in (select task_ID, course_ID from Attendance);";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $tasks = $statement->fetchAll();
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
    <title>Grades | Student</title>
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
          <a class="nav-link active" href="Grades.php">Grades</a>
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
          <a class="nav-link" href="Seminars.php">Seminars</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>
      </ul>
    </nav>

    <?php  foreach($courses as $course){ ?>
      <div class="dropdown-divider pt-4"></div>
      <div class="container">
        <div class="jumbotron">
          <h3><?php echo $course['course_ID']; ?></h3>
          <div class="dropdown-divider pt-3"></div>
            <table class="table table-hover ">
              <thead>
                <tr class="table-secondary">
                  <th scope="col">Dated</th>
                  <th scope="col">Attendance</th>
                </tr>
              </thead>
              <?php foreach($attendances as $attendance){ ?>
                <tbody>
                    <tr >
                      <?php if ($attendance['course_ID'] == $course['course_ID']){ ?>
                        <td><?php echo $attendance['start_date']; ?></td>
                        <td><?php $a = $attendance['score']; $b = $attendance['total_score']; echo "$a / $b"; ?></td>
                      <?php } ?>
                    </tr>
                </tbody>
              <?php }?>
            </table>
          <div class="dropdown-divider pt-5"></div>
          <table class="table table-hover ">
            <thead>
              <tr class="table-secondary">
                <th scope="col">Task</th>
                <th scope="col">Score</th>
              </tr>
            </thead>
            <?php foreach($tasks as $task){ ?>
              <tbody>
                  <tr >
                    <?php if ($task['course_ID'] == $course['course_ID']){ ?>
                      <td><?php echo $task['task_name']; ?></td>
                      <td><?php $a = $task['score']; $b = $task['total_score']; echo "$a / $b"; ?></td>
                    <?php } ?>
                  </tr>
              </tbody>
            <?php }?>
          </table>
        </div>
      </div>
    <?php }?>
  </body>
</html>