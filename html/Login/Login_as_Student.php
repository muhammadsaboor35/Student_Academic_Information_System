<?php
session_start();
if (isset($_POST['login'])) {
  try {
    require "../../php/config.php";
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT person_ID FROM Person NATURAL JOIN Student
	WHERE person_ID = :id
	AND hash_password = :password";
    $id = $_POST['id'];
    $password = hash('md5',$_POST['password']);
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':password', $password, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();

    if (count($result) > 0) {
	//login
	$sql = "update Person
		set login_status = 'On'
		where person_ID = :id";
	$statement = $connection->prepare($sql);
	$statement->bindParam(':id', $id, PDO::PARAM_STR);
	$statement->execute();

	$_SESSION['person_ID'] = $id;
	header("Location: http://localhost/html/Student/Home.php");
	exit();
    }
    else {
	//invalid id or password
	echo '<div class="alert alert-dismissible alert-danger">';
 	echo ' <!--<button type="button" class="close" data-dismiss="alert">&times;</button>-->';
   	echo 'Incorrect user ID or password. Please try again!.';
	echo '</div>';
    }

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login | Student</title>
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
          <div class="col-sm-12 my-auto">Login As: </div>
        </li>
              <li class="nav-item pr-3">
                <a class="nav-link active" href="Login_as_Student.php">Student</a>
              </li>
              <li class="nav-item pr-3">
                <a class="nav-link" href="Login_as_Instructor.php">Instructor</a>
              </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Login_as_Teaching_Assistant.php">Teaching Assistant</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Login_as_Admin.php">Admin</a>
        </li>
      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
      <div class="jumbotron custom-container container">
        <form method="post" action="">
	  <fieldset>
	    <div class="form-group custom-container2 container">
      	      <label for="id">user ID</label>
      	      <input type="text" class="form-control" name="id" placeholder="Enter ID">
            </div>
	    <div class="form-group custom-container2 container">
	      <label for="password">Password</label>
	      <input type="password" class="form-control" name="password" placeholder="Enter password">
	    </div>
            <div>
              <input type="submit" class="btn btn-primary" name="login" role="button" value="Login">
              <a class="btn btn-link" href="Signup_as_Student.php" role="button">New user? Signup First!</a>
            </div>
	  </fieldset>
	</form>
      </div>

  </body>
</html>
