<?php
session_start();
if (isset($_SESSION['person_ID'])){
$c_ID = $_SESSION['ListTask_Button'];
$p_ID = $_SESSION['person_ID'];

//print_r($_SESSION);

require "../../php/config.php";
try {
    $names = array();
    foreach($_SESSION['Grade_ID'] as $temp){
        $task_ID = $temp;
        $sql = "SELECT task_name FROM Task WHERE task_ID = :task_ID";   //warks

        $connection = new PDO($dsn, $username, $password, $options);      
        $statement = $connection->prepare($sql);
        $statement->bindParam(':task_ID', $task_ID, PDO::PARAM_INT);
        $statement->execute();
        $result = $statement->fetchAll();
       // echo '<pre>'; print_r($result); echo '</pre>';
        foreach($result as $myTemp) {
            array_push($names, $myTemp[0]);
        }
        //echo '<pre>'; print_r($names); echo '</pre>';
       // print_r($names);
    }//got stuff for label down
    
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}


if (isset($_POST['submit'])) {
    try {

        $myAssign = $_POST['assign']; /////////////
        //echo '<pre>'; print_r($myAssign); echo '</pre>';

        $connection = new PDO($dsn, $username, $password, $options);   ///////  

        $sql2 = "SELECT task_ID FROM Task WHERE task_name = :myAssign";/////////

        $connection = new PDO($dsn, $username, $password, $options);      
        $statement = $connection->prepare($sql2);

        $statement->bindParam(':myAssign', $myAssign, PDO::PARAM_STR);

        $statement->execute();
        $result = $statement->fetchAll();
        $task_ID = $result[0][0];////

        $sql = "INSERT INTO grades_submission
        VALUES (:s_ID, :c_ID, :task_ID, :p_ID, :Marks)";

        $s_ID = $_POST['s_ID'];
        $Marks = $_POST['Marks'];

        $statement = $connection->prepare($sql);
        $statement->bindParam(':p_ID', $p_ID, PDO::PARAM_INT);
        $statement->bindParam(':c_ID', $c_ID, PDO::PARAM_STR);
        $statement->bindParam(':task_ID', $task_ID, PDO::PARAM_INT);
        $statement->bindParam(':s_ID', $s_ID, PDO::PARAM_INT);
        $statement->bindParam(':Marks', $Marks, PDO::PARAM_INT);

        $statement->execute();
        } catch(PDOException $error) {
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
    <title>Grading</title>
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
      <div class="jumbotron custom-container container">
        <form method="post" action="">
          <fieldset>

            <!-- experiment with assignment drop down -->
            <label for="assigndropdown">Select Assignment</label>
            <div id="assigndropdown" class="form-group custom-container2 container">
                <select name="assign" class="custom-select">
                    <option selected="selected"></option>
                    <?php
                        foreach($names as $item) {?>
                        <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group custom-container2 container">
              <label for="s_ID">Student ID</label>
              <input type="text" class="form-control" name="s_ID" placeholder="Enter student's ID">
            </div>
            <div class="form-group custom-container2 container">
              <label for="Marks">Marks</label>
              <input type="text" class="form-control" name="Marks" placeholder="Enter Marks">
            </div>
            <div>
              <input type="submit" class="btn btn-primary" name="submit" role="button" value="submit">
            </div>
          </fieldset>
        </form>
      </div>

  </body>
</html>