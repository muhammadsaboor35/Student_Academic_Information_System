
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

        $sql = "SELECT P.person_ID, P.first_name, P.last_name, D.name, S.cgpa
                FROM Person as P, Dept_Person as D, Student as S
                WHERE S.advisor_ID = $id and P.person_ID = S.student_ID and D.person_ID = S.student_ID and S.cgpa >= coalesce(3.00, S.cgpa);";

        $statement1 = $connection->prepare($sql);
        $statement1->execute();
        $honor = $statement1->fetchAll();

        $sql = "SELECT P.person_ID, P.first_name, P.last_name, D.name, S.cgpa
        FROM Person as P, Dept_Person as D, Student as S
        WHERE S.advisor_ID = $id and P.person_ID = S.student_ID and D.person_ID = S.student_ID and S.cgpa < coalesce(3.00, S.cgpa);";

        $statement1 = $connection->prepare($sql);
        $statement1->execute();
        $satis = $statement1->fetchAll();


    }
    catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
    }
}else{
  header("Location: http://localhost/html/Login/Login_as_Student.php");
    exit();
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
                <div class="container text-center">
                    <h2>Honor Students</h2>
                </div>
                <table class="table">
                  <thead>
                    <tr class = "table-active ">
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Department</th>
                      <th scope="col">CGPA</th>
                  </thead>
                  <tbody>
                  <?php foreach($honor as $adv) {?>
                    <tr>
                            <td><?php echo $adv['person_ID']; ?></td>
                            <td><a href="inst_Stud_Info.php?studentID=<?php echo $adv['person_ID'];?>"><?php echo $adv['first_name'];echo " " ;echo $adv['last_name'];?></a></td>
                            <td><?php echo $adv['name']; ?></td>
                            <td><?php echo $adv['cgpa']; ?></td>
                            
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <div class="container text-center">
                <h2>Satisfactory Students</h2>
                </div>
                <table class="table">
                  <thead>
                    <tr class = "table-active ">
                      <th scope="col">ID</th>
                      <th scope="col">Name</th>
                      <th scope="col">Department</th>
                      <th scope="col">CGPA</th>
                  </thead>
                  <tbody>
                  <?php foreach($satis as $adv) {?>
                    <tr>
                            <td><?php echo $adv['person_ID']; ?></td>
                            <td><a href="inst_Stud_Info.php?studentID=<?php echo $adv['person_ID'];?>"><?php echo $adv['first_name'];echo " " ;echo $adv['last_name'];?></a></td>
                            <td><?php echo $adv['name']; ?></td>
                            <td><?php echo $adv['cgpa']; ?></td>
                            
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
                </div>
                <div class="tab-pane fade" id="instructor">l
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