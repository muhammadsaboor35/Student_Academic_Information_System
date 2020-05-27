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
    
    //grade scheme
    $grade_scheme = array('A+'=>4, 'A'=>4, 'A-'=>3.7, 'B+'=>3.3, 'B'=>3, 'B-'=>2.7,
                          'C+'=>2.3, 'C'=>2, 'C-'=>1.7, 'D+'=>1.3, 'D'=>1, 'F'=>0, NULL=>0);
    
    $sql = "SELECT course_ID, semester, year, grade, name, credits, semester_no
            FROM Course natural join Student_Sections WHERE student_ID = $id and
            course_ID not in (SELECT course_ID FROM Course natural join Student_Sections 
                      WHERE semester = '$curr_semester' and year = $curr_year) order by semester_no;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $courses = $statement->fetchAll();
    
    //calculate cgpa
    $sumScore = 0; $sumCredits = 0;
    foreach($courses as $course){
      $sumScore = $sumScore + $grade_scheme[$course['grade']] * $course['credits']; 
      $sumCredits = $sumCredits + $course['credits'];
    }
    $cgpa = 0;
    if ($sumCredits != 0)
      $cgpa = number_format((float)($sumScore / $sumCredits), 2, '.', '');
    $sql = "UPDATE Student SET cgpa = $cgpa WHERE student_ID = $id;";
    $statement = $connection->prepare($sql);
    $statement->execute();

    $sql = "SELECT current_semester FROM Student WHERE student_ID = $id;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $no_semesters = ($statement->fetchAll()[0]['current_semester']) - 1;

    $sql = "SELECT first_name, last_name, name, person_ID, degree, current_semester, cgpa 
            FROM Person natural join Student natural join Dept_Person WHERE person_ID = $id;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $details = $statement->fetchAll()[0];

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
    <title>Transcript | Student</title>
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
          <a class="nav-link active" href="Transcript.php">Transcript</a>
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
              <th scope="col">Name</th>
              <th scope="col">ID</th>
              <th scope="col">Semester</th>
              <th scope="col">Department</th>
              <th scope="col">Degree</th>
              <th scope="col">CGPA</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>
            <tr >
              <td><?php echo $details['first_name']; echo " "; echo $details['last_name'];?></td>
              <td><?php echo $details['person_ID']; ?></td>
              <td><?php echo $details['current_semester']; ?></td>
              <td><?php echo $details['name']; ?></td>
              <td><?php echo $details['degree']; ?></td>
              <td><?php echo $details['cgpa']; ?></td>
              <td><?php echo date("Y/m/d"); ?></td>
            </tr>
          </tbody>
        </table>
        <div class="dropdown-divider pt-1"></div>
        <form method="post" action="" class="text-center">
          <a class="btn btn-primary" href="TranscriptOrder.php" role="button">Order Transcript</a>
        </form>
      </div>
    </div>

    <div class="dropdown-divider pt-4"></div>
    <?php  for($x = $no_semesters; $x > 0 ; $x--){ ?>
      <div class="dropdown-divider pt-4"></div>
      <div class="container">
        <div class="jumbotron">
          <h3><?php echo "Semester $x - "; 
            foreach($courses as $course){
              if ($course['semester_no'] == $x){
                echo $course['semester']; echo " "; echo $course['year']; break;
              }
            }?>
          </h3>
          <div class="dropdown-divider pt-3"></div>
          <table class="table table-hover ">
            <thead>
              <tr class="table-secondary">
                <th scope="col">Course ID</th>
                <th scope="col">Course Name</th>
                <th scope="col">Course Grade</th>
              </tr>
            </thead>
            <?php $sumScore = 0; $sumCredits = 0;
                  foreach($courses as $course){ ?>
              <tbody>
                  <tr >
                    <?php if ($course['semester_no'] == $x){ ?>
                      <td><?php echo $course['course_ID']; ?></td>
                      <td><?php echo $course['name']; ?></td>
                      <td><?php echo $course['grade']; ?></td>
                    <?php 
                        $sumScore = $sumScore + $grade_scheme[$course['grade']] * $course['credits']; 
                        $sumCredits = $sumCredits + $course['credits'];
                      }?>
                  </tr>
              </tbody>
            <?php } $gpa = number_format((float)($sumScore / $sumCredits), 2, '.', '');?>
          </table>
          <h5><?php echo "GPA: $gpa"; ?></h5>
        </div>
      </div>
    <?php }?>
  </body>
</html>