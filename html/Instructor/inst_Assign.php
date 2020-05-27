<?php

session_start();
require "../../php/config.php";


if (isset($_SESSION['person_ID'])){
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $curr_semester = "Spring";
        $curr_year = 2020;
        $id = $_SESSION['person_ID'];

        if (isset($_POST['AssignT'])) {
            
            if (strlen($_POST['ta_ID']) > 0) {
                if (strlen($_POST['course_ID']) > 0) {
                    if (strlen($_POST['task_ID']) > 0) {
                        if (strlen($_POST['task_name']) > 0) {
                            if (strlen($_POST['weight'])> 0){
                                if (strlen($_POST['start_date'])> 0) {
                                    if (strlen($_POST['end_date']) >0) {
                                        if (strlen($_POST['total_score'])>0) {
                                            $taID = $_POST['ta_ID'];
                                            $courseID = $_POST['course_ID'];
                                            $taskID = $_POST['task_ID'];
                                            $weight = $_POST['weight'];
                                            $taskName = $_POST['task_name'];
                                            $startDate = $_POST['start_date'];;
                                            $endDate = $_POST['end_date'];;
                                            $totalScore = $_POST['total_score'];

                                            $sql = "INSERT INTO Task
                                                    VALUES ('$courseID', $taskID, $startDate, $endDate, '$taskName', $totalScore, $weight);";
                                            $statement1 = $connection->prepare($sql);
                                            $statement1->execute();

                                            $sql = "INSERT INTO Task_Assign
                                                    VALUES ('$courseID', $taskID, $taID);";
                                            $statement1 = $connection->prepare($sql);
                                            $statement1->execute();


                                        }
                                    }
                                }
                            }
                        }
                    }
                }
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

$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
} 


?>


<!DOCTYPE html>
<html>
    <head>
        <title> SAIRS | Instructor </title>
        <link rel = "stylesheet" type="text/css" href="../../css/bootstrap.css">
    </head>
    <div class = "container text-center">
                <h2></h2>
                <h2> </h2>
                <h1>SAIRS Instructor</h1>
            </div>
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
                <li class="nav-item active">
                    <a class="nav-link active" data-toggle="tab" href="inst_TA.php">Teaching Assistants</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="inst_Course.php">Courses</a>
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
            <div class = "container text-center">
                <h2></h2>
                <h2> </h2>
                <h2>Assign Task</h2>
            </div>
            <form method="post" action="">
            <table class="table table-hover">
                        <tbody>
                        <tr >
                            <th>Teaching Assistant ID: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='TA ID' name='ta_ID'></th>
                        </tr>
                        <tr >
                            <th>Task ID: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='Task ID' name='task_ID'></th>
                        </tr>
                        <tr >
                            <th>Course ID: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='Course ID' name='course_ID'></th>
                        </tr>
                        
                        <tr>
                            <th>Task: </th>
                            <th><select class="form-control-lg" name="task_name">
                            <option selected=""></option>
                            <?php $genders = array();
                                    if ($gender != "Attendance")
                                    array_push($genders, "Attendance");
                                    if ($gender != "Exam")
                                    array_push($genders, "Exam");
                                    if ($gender != "Homework")
                                    array_push($genders, "Homework");
                                    foreach($genders as $item) {?>
                                    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                                    <?php } ?>?>
                            </select></th>
                        </tr>

                        <tr >
                            <th>Total Score: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='Course ID' name='total_score'></th>
                        </tr>

                        <tr >
                            <th>Weight: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='Weight' name='weight'></th>
                        </tr>

                        <tr >
                            <th>Start Date: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='YYYY-MM-DD' name='start_date'></th>
                        </tr>

                        <tr >
                            <th>End Date: </th>
                            <th><input type="text" class="form-control form-control lg" placeholder='YYYY-MM-DD' name='end_date'></th>
                        </tr>

                        </tbody>
                   
                </table>
                <div>
                
                <div class="container text-center">
                    <input type="submit" class="btn btn-primary" name="AssignT" role="button" value="Assign Task">
                 </div>
                 </form>
                </div>
                
            </div>
            
        </div>
    </body>
</html>