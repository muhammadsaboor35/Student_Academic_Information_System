<?php
session_start();

if (isset($_SESSION['person_ID'])){
$c_ID = $_SESSION['ListTask_Button'];
$p_ID = $_SESSION['person_ID'];

require "../../php/config.php";

try {
    $date = array();
    $hours = array();
    $ids = array();
    foreach($_SESSION['Attendance_ID'] as $temp){
        $task_ID = $temp;
        //echo $task_ID;

        $sql = "SELECT start_date, total_score FROM Task WHERE task_ID = :task_ID";   //warks

        $connection = new PDO($dsn, $username, $password, $options);      
        $statement = $connection->prepare($sql);
        $statement->bindParam(':task_ID', $task_ID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
        //echo '<pre>'; print_r($result); echo '</pre>';
        
        foreach($result as $myTemp) {
            array_push($date, $myTemp[0]);
            array_push($hours, $myTemp[1]);
            array_push($ids, $task_ID);
        }
    }//got stuff

    //echo '<pre>'; print_r($date); echo '</pre>';
    //echo '<pre>'; print_r($hours); echo '</pre>';
    //echo '<pre>'; print_r($ids); echo '</pre>';

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
    <title>Listing Attendance</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
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
          <a class="nav-link" href="List_Tasks.php">Back</a>
        </li>

      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>

    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Task ID</th>
            <th scope="col">Date</th>
            <th scope="col">Hours</th>
          </tr>
        </thead>
        <tbody>

           <?php for($i = 0; $i < count($date); $i++) { ?>
            <tr>
            <td><?php  echo $ids[$i]; ?></td>
            <td><?php  echo $date[$i]; ?></td>
            <td><?php  echo $hours[$i]; ?></td>
            <td><button type="button" class="btn btn-primary btn-sm"><a class="nav-link" href="Mark_Attendance.php?id=<?php echo $ids[$i]; ?>&date=<?php echo $date[$i]; ?>&hours=<?php echo $hours[$i]; ?>">Mark Attendance</a></button></td>
          </tr>
           <?php } ?>
        </tbody>
      </table>
    </div>

  </body>
</html>