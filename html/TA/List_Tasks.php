<?php
session_start();
if (isset($_SESSION['person_ID'])){
$p_ID = $_SESSION['person_ID'];
$c_ID = $_SESSION['ListTask_Button'];
unset($_SESSION['taskID']);
unset($_SESSION['grade_ID']);

if(isset($_GET['Attendance_Button'])) {
    header("Location: Attendance_List.php" );
}

if(isset($_GET['Grade_Button'])) {
    header("Location: Grades_List.php" );
}

try {
  
  require "../../php/config.php";
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT task_name, C.task_ID FROM (Task C, Task_Assign T) WHERE C.course_ID = :c_ID AND T.ta_ID = :p_ID AND C.course_ID = T.course_ID AND C.task_ID = T.task_ID";
    //names for assigned task, Attendance or Grade

  $statement = $connection->prepare($sql);
  $statement->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
  $statement->bindParam(':p_ID', $p_ID, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetchAll();
  
  $myArr = array();
  $myID = array();
  //echo '<pre>'; print_r($result); echo '</pre>';

  foreach($result as $temp) {
    array_push($myArr, $temp[0]);   //ID;
    array_push($myID, $temp[1]);    //Name
  }//copying dynamic number of elements

} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
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
    <title>List | Tasks</title>
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
          <a class="nav-link" href="Courses.php">Back</a>
        </li>

      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
    <p> Available Tasks: </p>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
          </tr>
        </thead>
        <tbody>
            <tr>


            <?php                
                $temp1 = array();
                $temp2 = array();
                $count1 = 0;
                $count2 = 0;

                //print_r($myArr);

                for($i = 0; $i < count($myArr); $i++){
                  if($myArr[$i] == "Attendance"){
                    $temp1[$count1] = $myID[$i];     
                    $count1 = $count1 + 1;
                  }
                  if($myArr[$i] != "Attendance"){
                    $temp2[$count2] = $myID[$i];  
                    $count2 = $count2 + 1;
                  }
                } //made list

                $_SESSION['Attendance_ID'] = $temp1;
                $_SESSION['Grade_ID'] = $temp2;

                if(count($temp1) > 0){
                  //echo "Its an Attendance button";
                  echo '
                  <form>
                  <td><button type="submit" value="';
                  //echo $myID;
                  //echo $myArr;  //echoing the arr and ids of those task
                  echo'"   name= "Attendance_Button" class="btn btn-primary btn-sm">Attendance</button></td>
                  </form>';
                } else{
                  echo "No attendance tasks assigned";
                  echo "<br>";
                }

                if(count($temp2) > 0){
                  echo '
                  <form>
                  <td><button type="submit" value="';
                  //echo $myID;
                  //echo $myArr;  //echoing the arr and ids of those task
                  echo'"  name= "Grade_Button" class="btn btn-primary btn-sm">Grades</button></td>
                  </form>';
                } else{
                  echo "<br>";
                  echo "No grading tasks assigned ";
                }
            ?>
          </tr>
        </tbody>
      </table>
    </div>

  </body>
</html>
