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

        $sql = "SELECT S.course_ID, S.sec_ID, C.name
                FROM Sections as S, Course as C
                WHERE S.instructor_ID = :id AND C.course_ID = S.course_ID AND S.semester = :curr_semester AND S.year = :curr_year;";

        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(':id', $id, PDO::PARAM_STR);
        $statement1->bindParam(':curr_semester', $curr_semester, PDO::PARAM_STR);
        $statement1->bindParam(':curr_year', $curr_year, PDO::PARAM_STR);
        $statement1->execute();
        $courses = $statement1->fetchAll();


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
                <div class="tab-pane fade" id="home">
                </div>
                <div class="tab-pane fade" id="students">
                </div>
                <div class="tab-pane fade" id="instructor">
                </div>
                <div class="tab-pane fade" id="department">
                </div>
                <div class="tab-pane fade active show" id="courses">
                <h2>Courses</h2>
                <table class="table table-hover">
                  <thead>
                    <tr>
                      <th scope="col">Course ID</th>
                      <th scope="col">Section</th>
                      <th scope="col">Course Name</th>
                    </tr>
                  </thead>
                    <?php 
                    foreach($courses as $course){?>
                        <tbody>
                        <tr >
                            <td> <?php echo $course['course_ID']; ?></td>
                            <td><a href="inst_Home_Sec.php<?php
                            echo "?sID=", $course['sec_ID'], "&cID=", $course['course_ID'];
                            ?>">
                            <?php 
                            echo $course['sec_ID']; 
                            ?>
                            </a>
                            </td>
                            <td><?php echo $course['name']; ?></td>
                        </tr>
                    </tbody>
                    <?php } ?>
                </table>
                </div>
                <div class="tab-pane fade" id="clubs">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                </div>
                <div class="tab-pane fade" id="seminar">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                </div>
            </div>
        </div>
    </body>
</html>