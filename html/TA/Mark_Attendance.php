<?php
session_start();
if (isset($_SESSION['person_ID'])){
$c_ID = $_SESSION['ListTask_Button'];   //need this
$p_ID = $_SESSION['person_ID']; //need this as its TA

$temp_tID = $_GET['id'];
$temp_Date = $_GET['date'];
$temp_Time = $_GET['hours'];


require "../../php/config.php";

$stud_ID = array();
$f_Name = array();
$l_Name = array();

try {
    $sql = "SELECT student_ID, First_Name, Last_Name FROM (Student_Sections S, Person P) 
            Where S.student_ID = P.person_ID
            AND S.course_ID = :c_ID";   //Students that attend this course

        $connection = new PDO($dsn, $username, $password, $options);      
        $statement = $connection->prepare($sql);
        $statement->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
        $statement->execute();
        $result = $statement->fetchAll();
        //echo '<pre>'; print_r($result); echo '</pre>';
        
        foreach($result as $myTemp) {
            array_push($stud_ID, $myTemp[0]);
            array_push($f_Name, $myTemp[1]);
            array_push($l_Name, $myTemp[2]);
        }
    //got stuff
    //echo '<pre>'; print_r($stud_ID); echo '</pre>';
    //echo '<pre>'; print_r($f_Name); echo '</pre>';
    //echo '<pre>'; print_r($l_Name); echo '</pre>';

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}  

if (isset($_GET['submit'])) {
    //GOING INTO THIS
    try {
        for($i = 0; $i < count($stud_ID); $i++){
            $Marks = $_GET['Attendance_'.$i]; ///////////////
            $s_ID = $stud_ID[$i];
        
            //print_r($Marks);

            $sql = "INSERT INTO grades_submission
            VALUES (:s_ID, :c_ID, :temp_tID, :p_ID, :Marks)";
    
            $connection = new PDO($dsn, $username, $password, $options);
            $statement = $connection->prepare($sql);
            $statement->bindParam(':p_ID', $p_ID, PDO::PARAM_INT);
            $statement->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
            $statement->bindParam(':temp_tID', $temp_tID, PDO::PARAM_INT);
            $statement->bindParam(':s_ID', $s_ID, PDO::PARAM_INT);
            $statement->bindParam(':Marks', $Marks, PDO::PARAM_INT);
    
            $statement->execute();
            } 
        }catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
}   
}else{
  header("Location: http://localhost/html/Login/Login_as_Student.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Marking Attendance</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
  </head>

  <body>
    <h1 class='text-center pb-4 pt-3'>Student Academic Information & Registration System</h1>
    <nav class="navbar sticky-top justify-content-center navbar-expand-lg navbar-dark bg-primary pt-2 pb-2 mx-auto" style="width: 50%;">
      <ul class="nav justify-content-center nav-pills ">

        <li class="nav-item pr-3">
          <a class="nav-link" href="Attendance_List.php">Back</a>
        </li>

      </ul>
    </nav>

    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <p> Task ID: <?php echo $temp_tID ?></p><!-----These temps have been updated----->
    <p> Date: <?php echo $temp_Date ?></p>
    <p> Total Hours: <?php echo $temp_Time ?></p>
    </div>

    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <form>
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Student ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Hours Attended</th>
          </tr>
        </thead>
        <tbody>

           <?php for($i = 0; $i < count($stud_ID); $i++) { ?>
            <tr>
            <td><?php  echo $stud_ID[$i]; ?></td>
            <td><?php  echo $f_Name[$i]; ?></td>
            <td><?php  echo $l_Name[$i]; ?></td>
            <td><input type="text" name="Attendance_<?php echo $i; ?>" placeholder="Enter Attendance"></td>

            <!---HOW DO I GET MULTIPLE VALUES HERE^^^-->

            </tr>
           <?php } ?>
        </tbody>
      </table>
        
        <div>
            <input type="hidden" name="id" value="<?php echo $temp_tID; ?>">
            <input type="hidden" name="date" value="<?php echo $temp_Date; ?>">
            <input type="hidden" name="hours" value="<?php echo $temp_Time; ?>">
            <input type="submit" class="btn btn-primary" name="submit" role="button" value="submit">
        </div>
        </form>
    </div>

  </body>
</html>