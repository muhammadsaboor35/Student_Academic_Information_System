
<?php
session_start();
require "../../php/config.php";

if (isset($_SESSION['person_ID'])){
    try {
        $connection = new PDO($dsn, $username, $password, $options);
        $servername = "localhost";
        $username = "root";
        $password = "";
        $_SESSION['curr_semester'] = "Spring";
        $_SESSION['curr_year'] = date("Y");
        $curr_semester = $_SESSION['curr_semester'];
        $curr_year = $_SESSION['curr_year'];
        $id = $_SESSION['person_ID'];

        $sql = "SELECT S.course_ID, S.sec_ID, C.name
                FROM Sections as S, Course as C
                WHERE S.instructor_ID = :id AND C.course_ID = S.course_ID AND S.semester = :curr_semester AND S.year = :curr_year;";

        $statement1 = $connection->prepare($sql);
        $statement1->bindParam(':id', $id, PDO::PARAM_STR);
        $statement1->bindParam(':curr_semester', $curr_semester, PDO::PARAM_STR);
        $statement1->bindParam(':curr_year', $curr_year, PDO::PARAM_STR);
        $statement1->execute();
        $courses = $statement1->fetchAll();

        $sql = "SELECT HS.course_ID, TS.day, TS.time, S.room_ID
            FROM Has_Schedule as HS, Time_Slot as TS, Sections as S
            WHERE HS.instructor_ID = $id and HS.semester = '$curr_semester' and HS.year = $curr_year and HS.time_slot_ID = TS.time_slot_ID and S.course_ID = HS.course_ID ;";

        $statement1 = $connection->prepare($sql);
        $statement1->execute();
        $schedule = $statement1->fetchAll();

        $sched = array();
        foreach($schedule as $sc){
            $key = sprintf("%s_%s", $sc['day'], $sc['time']);
            $entry = sprintf("%s %s", $sc['room_ID'], $sc['course_ID']);
            $sched += [$key=> $entry];
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
                <li class="nav-item active">
                    <a class="nav-link active" data-toggle="tab" href="inst_Home.php">Home</a>
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
                <div class="tab-pane fade active show" id="home">
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
                            <td><?php echo $course['course_ID']; ?></td>
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
                <h2>Schedule</h2>
                <table class="table table-hover">
                  <thead>
                    <tr class = "table-active">
                      <th scope="col"></th>
                      <th scope="col">Monday</th>
                      <th scope="col">Tuesday</th>
                      <th scope="col">Wednesday</th>
                      <th scope="col">Thursday</th>
                      <th scope="col">Friday</th>
                  </thead>
                  <tbody>
                    <tr class="table-active">
                      <th scope="row">8 40 - 9 30</th>
                        <td><?php if (isset($sched['Mon_8-10'])){echo $sched['Mon_8-10'];}?></td>
                        <td><?php if (isset($sched['Tue_8-10'])){echo $sched['Tue_8-10'];}?></td>
                        <td><?php if (isset($sched['Wed_8-10'])){echo $sched['Wed_8-10'];}?></td>
                        <td><?php if (isset($sched['Thu_8-10'])){echo $sched['Thu_8-10'];}?></td>
                        <td><?php if (isset($sched['Fri_8-10'])){echo $sched['Fri_8-10'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">9 40 - 10 30</th>
                        <td><?php if (isset($sched['Mon_8-10'])){echo $sched['Mon_8-10'];}?></td>
                        <td><?php if (isset($sched['Tue_8-10'])){echo $sched['Tue_8-10'];}?></td>
                        <td><?php if (isset($sched['Wed_8-10'])){echo $sched['Wed_8-10'];}?></td>
                        <td><?php if (isset($sched['Thu_8-10'])){echo $sched['Thu_8-10'];}?></td>
                        <td><?php if (isset($sched['Fri_8-10'])){echo $sched['Fri_8-10'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">10 40 - 11 30</th>
                        <td><?php if (isset($sched['Mon_10-12'])){echo $sched['Mon_10-12'];}?></td>
                        <td><?php if (isset($sched['Tue_10-12'])){echo $sched['Tue_10-12'];}?></td>
                        <td><?php if (isset($sched['Wed_10-12'])){echo $sched['Wed_10-12'];}?></td>
                        <td><?php if (isset($sched['Thu_10-12'])){echo $sched['Thu_10-12'];}?></td>
                        <td><?php if (isset($sched['Fri_10-12'])){echo $sched['Fri_10-12'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">11 40 - 12 30</th>
                        <td><?php if (isset($sched['Mon_10-12'])){echo $sched['Mon_10-12'];}?></td>
                        <td><?php if (isset($sched['Tue_10-12'])){echo $sched['Tue_10-12'];}?></td>
                        <td><?php if (isset($sched['Wed_10-12'])){echo $sched['Wed_10-12'];}?></td>
                        <td><?php if (isset($sched['Thu_10-12'])){echo $sched['Thu_10-12'];}?></td>
                        <td><?php if (isset($sched['Fri_10-12'])){echo $sched['Fri_10-12'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">12 30 - 13 40</th>
                      <td></td>
                      <td></td>
                      <td>Break</td>
                      <td></td>
                      <td></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">13 40 - 14 30</th>
                        <td><?php if (isset($sched['Mon_13-15'])){echo $sched['Mon_13-15'];}?></td>
                        <td><?php if (isset($sched['Tue_13-15'])){echo $sched['Tue_13-15'];}?></td>
                        <td><?php if (isset($sched['Wed_13-15'])){echo $sched['Wed_13-15'];}?></td>
                        <td><?php if (isset($sched['Thu_13-15'])){echo $sched['Thu_13-15'];}?></td>
                        <td><?php if (isset($sched['Fri_13-15'])){echo $sched['Fri_13-15'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">14 40 - 15 30</th>
                        <td><?php if (isset($sched['Mon_13-15'])){echo $sched['Mon_13-15'];}?></td>
                        <td><?php if (isset($sched['Tue_13-15'])){echo $sched['Tue_13-15'];}?></td>
                        <td><?php if (isset($sched['Wed_13-15'])){echo $sched['Wed_13-15'];}?></td>
                        <td><?php if (isset($sched['Thu_13-15'])){echo $sched['Thu_13-15'];}?></td>
                        <td><?php if (isset($sched['Fri_13-15'])){echo $sched['Fri_13-15'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">15 40 - 16 30</th>
                        <td><?php if (isset($sched['Mon_15-17'])){echo $sched['Mon_15-17'];}?></td>
                        <td><?php if (isset($sched['Tue_15-17'])){echo $sched['Tue_15-17'];}?></td>
                        <td><?php if (isset($sched['Wed_15-17'])){echo $sched['Wed_15-17'];}?></td>
                        <td><?php if (isset($sched['Thu_15-17'])){echo $sched['Thu_15-17'];}?></td>
                        <td><?php if (isset($sched['Fri_15-17'])){echo $sched['Fri_15-17'];}?></td>
                    </tr>
                    <tr class="table-active">
                      <th scope="row">16 40 - 17 30</th>
                        <td><?php if (isset($sched['Mon_15-17'])){echo $sched['Mon_15-17'];}?></td>
                        <td><?php if (isset($sched['Tue_15-17'])){echo $sched['Tue_15-17'];}?></td>
                        <td><?php if (isset($sched['Wed_15-17'])){echo $sched['Wed_15-17'];}?></td>
                        <td><?php if (isset($sched['Thu_15-17'])){echo $sched['Thu_15-17'];}?></td>
                        <td><?php if (isset($sched['Fri_15-17'])){echo $sched['Fri_15-17'];}?></td>
                    </tr>
                  </tbody>
                </table> 
                </div>
                <div class="tab-pane fade" id="students">
                  
                </div>
                <div class="tab-pane fade" id="instructor">
                  
                </div>
                <div class="tab-pane fade" id="department">
                  
                </div>
                <div class="tab-pane fade" id="courses">
                  
                </div>
                <div class="tab-pane fade" id="clubs">
                  
                </div>
                <div class="tab-pane fade" id="seminar">
                  
                </div>
              </div>
        </div>
    </body>
</html>
