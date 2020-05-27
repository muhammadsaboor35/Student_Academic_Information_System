<?php
session_start();
if (isset($_SESSION['person_ID'])){
$p_ID = $_SESSION['person_ID'];

require "../../php/config.php";


if(isset($_POST['create'])){
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "INSERT INTO Seminar values ( :name, :date, :time, :room, :duration, :host_ID);";
    $statement = $connection->prepare($sql);
    $name = $_POST['name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $room = $_POST['room'];
    $duration = $_POST['duration'];
    $statement->bindParam(':name', $name, PDO::PARAM_STR);
    $statement->bindParam(':date', $date, PDO::PARAM_STR);
    $statement->bindParam(':time', $time, PDO::PARAM_STR);
    $statement->bindParam(':room', $room, PDO::PARAM_STR);
    $statement->bindParam(':duration', $duration, PDO::PARAM_STR);
    $statement->bindParam(':host_ID', $_SESSION['person_ID'], PDO::PARAM_INT);
    $statement->execute();
  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}
}
else{
  header("Location: http://localhost/html/Login/Login_as_Admin.php");
    exit();
}

?>


<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Create Seminar | Instructors</title>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Club Details | Admin</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+o$
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" />

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.6/moment.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
  </head>

  <body>
    <h1 class='text-center pb-4 pt-3'>Student Academic Information & Registration System</h1>
    <nav class="navbar sticky-top justify-content-center navbar-expand-lg navbar-dark bg-primary pt-2 pb-2 mx-auto" style="width: 50%;">
    <ul class="nav nav-tabs sticky-top nav-justified">
                <li class="nav-item ">
                    <a class="nav-link " data-toggle="tab" href="inst_Home.php">Home</a>
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
                <li class="nav-item active">
                  <a class="nav-link active" data-toggle="tab" href="Instructor_Seminar.php">Seminars</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
              </li>
              </ul>

    </nav>

    <!--[if lt IE 9]>
     Tables here - column
    <![endif]-->
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <div class="jumbotron custom-container container">
        <form method="post" action="">
          <fieldset>
            <div class="form-group custom-container2 container">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Name">
            </div>
            <div class="form-group custom-container2 container">
              <label for="date">Date</label>
              <input type="text" id="date" class="form-control" name="date" placeholder="Enter Date">
            </div>
            <div class="form-group custom-container2 container">
              <label for="time">Time</label>
              <input type="text" id="time" class="form-control" name="time" placeholder="Enter TIme">
            </div>
            <div class="form-group custom-container2 container">
              <label for="room">Room</label>
              <input type="text" class="form-control" name="room" placeholder="Enter Room">
            </div>
            <div class="form-group custom-container2 container">
              <label for="duration">Duration</label>
              <input type="text" class="form-control" name="duration" placeholder="Enter Duration">
            </div>
            <div>
              <input type="submit" class="btn btn-primary" name="create" role="button" value="Create">
            </div>
          </fieldset>
        </form>
      </div>

    </div>
  </body>
<script>
$(document).ready(function() {
  $(function() {
    $('#date').datetimepicker({format: 'YYYY-MM-DD'});
    $('#time').datetimepicker({format: 'hh:mm:ss'});
  });
});
</script>

</html>

