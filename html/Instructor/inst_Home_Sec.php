
<?php
session_start();
require "../../php/config.php";

if (isset($_SESSION['person_ID'])){
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $id = $_SESSION['person_ID'];
        $curr_semester = $_SESSION['curr_semester'];
        $curr_year = $_SESSION['curr_year'];
        $c_ID = $_GET['cID'];
        $s_ID = $_GET['sID'];
        $sql = "SELECT DISTINCT SS.student_ID, P.first_name, P.last_name, SS.grade
                FROM Student_Sections as SS, Person as P, Instructor as I
                WHERE SS.course_ID= :c_ID and SS.sec_ID= :s_ID and P.person_ID = SS.student_ID and 
                SS.semester = :curr_semester and SS.year = :curr_year;";

        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
        $statement1->bindParam(':s_ID', $s_ID, PDO::PARAM_STR);
        $statement1->bindParam(':curr_semester', $curr_semester, PDO::PARAM_STR);
        $statement1->bindParam(':curr_year', $curr_year, PDO::PARAM_STR);
        $statement1->execute();
        $studinfo = $statement1->fetchAll();

        $grade = array();
        $currentStanding = array();
        foreach($studinfo as $tmp) {
            $key = $tmp['student_ID'];
            $entry = $tmp['grade'];
            $grade += [$key => $entry];

            $sql = "SELECT SUM(score*weight) as SUMT
                    FROM grades_submission INNER JOIN Task ON grades_submission.task_ID=Task.task_ID
                    WHERE student_ID =$key and Task.course_ID = :c_ID;";

            $statement1 = $connection->prepare($sql);
            $statement1->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
            $statement1->execute();
            $suminfo =(float)$statement1->fetchAll()[0]['SUMT'];

            $sql = "SELECT SUM(total_score*weight) as Total
                    FROM grades_submission INNER JOIN Task ON grades_submission.task_ID=Task.task_ID
                    WHERE student_ID = $key and Task.course_ID = :c_ID;";

            $statement1 = $connection->prepare($sql);
            $statement1->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
            $statement1->execute();
            $totalinfo = (float)$statement1->fetchAll()[0]['Total'];
            
            $currentStanding += [$key => $suminfo*100.0/$totalinfo];

            
        }

        if (isset($_POST['save'])) {
            
            foreach($studinfo as $stud) {
               
                $tmp = $grade[$stud['student_ID']];
                $studid = $stud['student_ID'];
                if (strlen($_POST[$studid])>0) {
                    echo 'here';
                    $tmp = $_POST[$studid];
                    $grade[$studid] = $_POST[$studid];
                }

                $sql = "UPDATE Student_Sections
                SET grade = :tmp
                WHERE student_ID = $studid AND course_ID = :c_ID AND semester = :curr_semester and year = :curr_year;";
                $statement1 = $connection->prepare($sql);
                $statement1->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
                $statement1->bindParam(':tmp', $tmp, PDO::PARAM_STR);
                $statement1->bindParam(':curr_semester', $curr_semester, PDO::PARAM_STR);
                $statement1->bindParam(':curr_year', $curr_year, PDO::PARAM_STR);
                $statement1->execute();
            }

            
        }
        

    }
    catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
    }
}else{
    header("Location: http://localhost/html/Login/Login_as_Student.php");
      exit();
  }




// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 




?>


<!DOCTYPE html>
<html>
    <head>
        <title class="align-self-center"> SAIRS | Instructor </title>
        <link rel = "stylesheet" type="text/css" href="../../css/bootstrap.css">
    </head>
    <h1>SAIRS Instructor</h1>
    <body>
        <div>
        <ul class="nav nav-tabs sticky-top nav-justified">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="inst_Home.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="inst_Stud.php">Students</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="inst_Details.php">Instructor</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="inst_TA.php">Teaching Assistants</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link active" data-toggle="tab" href="inst_Course.php">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="Instructor_Clubs.php">Clubs</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="Instructor_Seminar.php">Seminars</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
              </li>
              </ul>
              <div id="myTabContent" class="tab-content">
            <form method="post" action="">
          <table class="table table-hovertext-center">
          <thead>
            <tr class = "table-active ">
                <th scope="col">ID</th>
                <th scope="col">Name</th>
                <th scope="col">Grade</th>
                <th scope="col">Current Standing</th>
            </tr>
            </thead>
            <tbody>
                <?php
                foreach($studinfo as $stud) { ?>
                    <tr class="table-active">
                        <th><?php echo $stud['student_ID'] ?></th>
                        <th> <?php echo $stud['first_name'], " ", $stud['last_name']; ?></th>
                        <th><input type="text" class="form-control form-control lg" placeholder="<?php echo $grade[$stud['student_ID']]; ?>" name="<?php echo $stud['student_ID'] ?>"></th>
                        <th><?php echo number_format($currentStanding[$stud['student_ID']], 2, '.', ''), "%";  ?></th>
                    </tr>
                <?php } ?>
            </tbody>
          </table>
          <div class="dropdown-divider pt-3"></div>
          <div class="container text-center">
            <input type="submit" class="btn btn-primary" name="save" role="button" value="Save">
          </div>
        </form>     

    </body>
</html>
