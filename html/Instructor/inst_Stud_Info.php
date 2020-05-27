<?php

    session_start();
    require "../../php/config.php";
    $studentID = $_GET['studentID']; 
    

    if (isset($_SESSION['person_ID'])){
        try {
            $connection = new PDO($dsn, $username, $password, $options);
            $servername = "localhost";
            $username = "root";
            $password = "";
            $id = $_SESSION['person_ID'];
            $curr_semester = $_SESSION['curr_semester'];
            $curr_year = $_SESSION['curr_year'];
    
            $sql = "SELECT S.student_ID, S.current_semester, S.total_semesters, S.rank, S.cgpa, S.degree, P.first_name, P.last_name, P.email, P.gender
                    FROM Student as S, Person as P
                    WHERE S.student_ID = $studentID and P.person_ID = $studentID";
    
            $statement1 = $connection->prepare($sql);
            $statement1->execute();
            $details = $statement1->fetchAll();
        }
        catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
        }
    }else{
      header("Location: http://localhost/html/Login/Login_as_Student.php");
        exit();
    }


// will be removed after testing
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
                <li class="nav-item active">
                  <a class="nav-link active" data-toggle="tab" href="inst_Stud.php">Students</a>
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
                <div class="tab-pane fade" id="home">
                  <p>Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. Cosby sweater eu banh mi, qui irure terry richardson ex squid. Aliquip placeat salvia cillum iphone. Seitan aliquip quis cardigan american apparel, butcher voluptate nisi qui.</p>
                </div>
                <div class="tab-pane fade active show" id="students">
                <table class="table table-hover">
                    <thead>
                    </thead>
                  <tbody class= "table-active">
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'ID'; ?></td>
                            <td><?php echo $dets['student_ID'];?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Name'; ?></td>
                            <td><?php echo $dets['first_name'];echo " " ;echo $dets['last_name']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Email'; ?></td>
                            <td><?php echo $dets['email']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'CGPA'; ?></td>
                            <td><?php echo $dets['cgpa']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Current Semester'; ?></td>
                            <td><?php echo $dets['current_semester']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Total Semesters'; ?></td>
                            <td><?php echo $dets['total_semesters']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Gender'; ?></td>
                            <td><?php echo $dets['gender']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Degree'; ?></td>
                            <td><?php echo $dets['degree']?></td>
                    </tr>
                    <?php foreach($details as $dets) ?>
                    <tr>
                            <td><?php echo 'Rank'; ?></td>
                            <td><?php echo $dets['rank']?></td>
                    </tr>
                  </tbody>
                </table>
                </div>
                <div class="tab-pane fade" id="instructor">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                </div>
                <div class="tab-pane fade" id="department">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
                </div>
                <div class="tab-pane fade" id="courses">
                  <p>Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid. Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko farm-to-table craft beer twee. Qui photo booth letterpress, commodo enim craft beer mlkshk aliquip jean shorts ullamco ad vinyl cillum PBR. Homo nostrud organic, assumenda labore aesthetic magna delectus mollit.</p>
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