
<!-- php scripts -->
<?php
session_start();
require "../../php/config.php";
// will be removed after testing

if (isset($_SESSION['person_ID'])){
  $_SESSION['curr_semester'] = "Spring";
  $_SESSION['curr_year'] = date("Y");
  //populate the page from DB
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_SESSION['person_ID'];
    $curr_semester = $_SESSION['curr_semester'];
    $curr_year = $_SESSION['curr_year'];

    $sql = "SELECT C.course_ID, S.sec_ID, S.room_ID, C.name, P.first_name, P.last_name, dept
            FROM Student_Sections as SS, Sections as S, Course as C, Person as P
            WHERE SS.course_ID = S.course_ID and SS.sec_ID = S.sec_ID and SS.semester = S.semester and
                  SS.year = S.year and S.course_ID = C.course_ID and S.instructor_ID = P.person_ID and
                  SS.student_ID = $id and SS.semester = '$curr_semester' and SS.year = $curr_year;";
    
    $statement1 = $connection->prepare($sql);
    $statement1->execute();
    $courses = $statement1->fetchAll();
    //schedule
    $sql = "SELECT course_ID, day, time, dept
            FROM Student_Sections natural join Has_Schedule natural join Time_Slot natural join Course
            WHERE student_ID = $id and semester = '$curr_semester' and year = $curr_year;";
    
    $statement1 = $connection->prepare($sql);
    $statement1->execute();
    $schedule = $statement1->fetchAll();
    $sched = array();
    foreach($schedule as $sc){
      $key = sprintf("%s_%s", $sc['day'], $sc['time']);
      $entry = sprintf("%s", $sc['course_ID']);
      $sched += [$key => $entry];
    }

    if (isset($_SESSION['dropped']) ){
      if ($_SESSION['dropped'] == true){
        $_SESSION['dropped'] = false;
        ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Successfull!</strong> You successfully dropped the course.
          </div>
        <?php
        
      }
      
    }
    
    //drop courses
    foreach ($courses as $course){
      $name = sprintf("%s", $course['course_ID']);
      if (isset($_POST[$name])){
        $sql = "DELETE FROM grades_submission 
                WHERE course_ID = '$name' and student_ID = $id;";
        $statement1 = $connection->prepare($sql);
        $statement1->execute();

        $sql = "DELETE FROM Student_Sections 
                WHERE course_ID = '$name' and student_ID = $id and semester = '$curr_semester' and year = $curr_year;";
        $statement1 = $connection->prepare($sql);
        $statement1->execute();
        $_SESSION['dropped'] = true;
        header("Refresh:0");
        
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
    <title>Home | Student</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
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
          <a class="nav-link active" href="Home.php">Home</a>
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
          <a class="nav-link" href="Seminars.php">Seminars</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>
      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <div class="jumbotron">
        <table class="table table-hover justify-content-center text-center">
          <thead>
            <tr class="table-secondary">
              <th scope="col">Course ID</th>
              <th scope="col">Course Name</th>
              <th scope="col">Section</th>
              <th scope="col">Room</th>
              <th scope="col">Instructor</th>
              <th scope="col">Drop</th>
            </tr>
          </thead>
          <?php 
            foreach($courses as $course){?>
              <tbody>
                <tr >
                  <td><?php echo $course['course_ID']; ?></td>
                  <td><?php echo $course['name']; ?></td>
                  <td><?php echo $course['sec_ID']; ?></td>
                  <td><?php echo $course['room_ID']; ?></td>
                  <td><?php echo $course['first_name']; $l_n = $course['last_name']; echo " $l_n";?></td>
                  <td>
                    <form method="post" action="">
                      <?php 
                        $name = $course['course_ID'];
                      ?>
                      <input type="submit" class="btn btn-primary" name="<?php echo $name; ?>" role="button" value="D">
                    </form>
                  </td>
                </tr>
              </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
    <div class="dropdown-divider pb-2"></div>
    <h2 class='text-center'>Schedule</h2>
    <div class="dropdown-divider pt-5"></div>
    <div class="container">
      <div class="jumbotron">
        <table class="table table-hover justify-content-center text-center">
          <thead>
            <tr class="table-secondary">
              <th scope="col">Hours</th>
              <th scope="col">Mon</th>
              <th scope="col">Tue</th>
              <th scope="col">Wed</th>
              <th scope="col">Thu</th>
              <th scope="col">Fri</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th class="table-secondary" scope="row">8:40 - 10:30</th>
              <td><?php if (isset($sched['Mon_8-10'])){echo $sched['Mon_8-10'];}?></td>
              <td><?php if (isset($sched['Tue_8-10'])){echo $sched['Tue_8-10'];}?></td>
              <td><?php if (isset($sched['Wed_8-10'])){echo $sched['Wed_8-10'];}?></td>
              <td><?php if (isset($sched['Thu_8-10'])){echo $sched['Thu_8-10'];}?></td>
              <td><?php if (isset($sched['Fri_8-10'])){echo $sched['Fri_8-10'];}?></td>
            </tr>
            <tr>
              <th class="table-secondary" scope="row">10:30 - 12:30</th>
              <td><?php if (isset($sched['Mon_10-12'])){echo $sched['Mon_10-12'];}?></td>
              <td><?php if (isset($sched['Tue_10-12'])){echo $sched['Tue_10-12'];}?></td>
              <td><?php if (isset($sched['Wed_10-12'])){echo $sched['Wed_10-12'];}?></td>
              <td><?php if (isset($sched['Thu_10-12'])){echo $sched['Thu_10-12'];}?></td>
              <td><?php if (isset($sched['Fri_10-12'])){echo $sched['Fri_10-12'];}?></td>
            </tr>
            <tr>
              <th class="table-secondary" scope="row">13:40 - 15:30</th>
              <td><?php if (isset($sched['Mon_13-15'])){echo $sched['Mon_13-15'];}?></td>
              <td><?php if (isset($sched['Tue_13-15'])){echo $sched['Tue_13-15'];}?></td>
              <td><?php if (isset($sched['Wed_13-15'])){echo $sched['Wed_13-15'];}?></td>
              <td><?php if (isset($sched['Thu_13-15'])){echo $sched['Thu_13-15'];}?></td>
              <td><?php if (isset($sched['Fri_13-15'])){echo $sched['Fri_13-15'];}?></td>
            </tr>
            <tr>
              <th class="table-secondary" scope="row">15:40 - 17:30</th>
              <td><?php if (isset($sched['Mon_15-17'])){echo $sched['Mon_15-17'];}?></td>
              <td><?php if (isset($sched['Tue_15-17'])){echo $sched['Tue_15-17'];}?></td>
              <td><?php if (isset($sched['Wed_15-17'])){echo $sched['Wed_15-17'];}?></td>
              <td><?php if (isset($sched['Thu_15-17'])){echo $sched['Thu_15-17'];}?></td>
              <td><?php if (isset($sched['Fri_15-17'])){echo $sched['Fri_15-17'];}?></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </body>
</html>