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

    //    $sql = "CREATE VIEW instCourses AS SELECT HS.course_ID FROM Has_Schedule as HS 
    //                                         Where HS.instructor_ID = :id;";
    //     $statement1 = $connection->prepare($sql);
    //     $statement1->bindParam(':id', $id, PDO::PARAM_STR);
    //     $statement1->execute();


        $sql = "SELECT P.person_ID, P.first_name, P.last_name, A.course_ID
                FROM Assists as A, Person as P
                WHERE A.course_ID IN (SELECT course_ID FROM instCourses)
                        AND A.ta_ID = P.person_ID;";

        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(':id', $id, PDO::PARAM_STR);
        $statement1->execute();
        $teeAA = $statement1->fetchAll();

        $sql = "SELECT Task.course_ID, Task_Assign.ta_ID, Task.task_ID, Task.task_name
                FROM Task_Assign INNER JOIN Task ON Task_Assign.task_ID = Task.task_ID
                    AND Task_Assign.course_ID = Task.course_ID
                    WHERE Task_Assign.course_ID IN (SELECT course_ID FROM instCourses);";
        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(':id', $id, PDO::PARAM_STR);
        $statement1->execute();
        $tasks = $statement1->fetchAll();



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
                <h2>Teaching Assistants</h2>
            </div>
            <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Course ID</th>
                    </tr>
                  </thead>
                    <?php 
                    foreach($teeAA as $course){?>
                        <tbody>
                        <tr >
                            <td><?php echo $course['person_ID']; ?></td>
                            <td>
                            <?php 
                            echo $course['first_name'], " ", $course['last_name']; 
                            ?>
                            </a>
                            </td>
                            <td><?php echo $course['course_ID']; ?></td>
                        </tr>
                        </tbody>
                    <?php } ?>
                </table>
                
                <div class = "container text-center">
                    <h2></h2>
                    <h2> </h2>
                    <h2>Assigned Tasks</h2>
                </div>
                    <table class = "table table-hover">
                        <thead>
                            <tr>
                                <th scope = "col">Course ID</th>
                                <th scope = "col">Teaching Assistant ID</th>
                                <th scope = "col">Task ID</th>
                                <th scope = "col">Task name</th>
                            </tr>
                        </thead>
                        <?php 
                        foreach($tasks as $course) { ?>
                            <tbody>
                            <tr >
                                <td><?php echo $course['course_ID']; ?></td>
                                <td>
                                <?php 
                                echo $course['ta_ID']; 
                                ?>
                                
                                </td>
                                <td><?php echo $course['task_ID']; ?></td>
                                <td><?php echo $course['task_name']; ?></td>
                            </tr>
                            </tbody>
                        <?php } ?>

                    </table>
                <div>
                <form method="post" action="inst_Assign.php">
                <div class="container text-center">
                    <input type="submit" class="btn btn-primary" name="Assign" role="button" value="Assign Task">
                 </div>
                 </form>
                </div>
                
            </div>
            
        </div>
    </body>
</html>