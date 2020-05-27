<?php
session_start();
if (isset($_SESSION['person_ID'])){
  $p_ID = $_SESSION['person_ID'];
  require "../../php/config.php";

  if(isset($_GET['edit'])) {
    $name_var = $_GET['name_var'];
    header("Location: http://localhost/html/Admin/Edit_Club_Details.php?name=".$name_var);
    exit();
  }

  if(isset($_GET['add'])) {
    header("Location: http://localhost/html/Admin/Add_Club.php");
    exit();
  }

  if(isset($_GET['delete'])) {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "DELETE FROM Participates WHERE name = :name_var;";
    $name_var = $_GET['name_var'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name_var', $name_var, PDO::PARAM_STR);
    $statement->execute();
    $sql = "DELETE FROM Club WHERE name = :name_var;";
    $name_var = $_GET['name_var'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':name_var', $name_var, PDO::PARAM_STR);
    $statement->execute();
  }

  if(isset($_GET['details'])) {
    $name_var = $_GET['name_var'];
    header("Location: http://localhost/html/Admin/Details_Club.php?name=".$name_var);
    exit();
  }

  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT name, website FROM Club;";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $names = array();
    $websites = array();
    foreach($result as $item) {
      array_push($names, $item[0]);
      array_push($websites, $item[1]);
    }

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
}else{
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
    <title>Clubs | Admin</title>
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
          <a class="nav-link" href="Home.php">Home</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Students.php">Courses</a>
        </li>

        <li class="nav-item pr-3">
          <a class="nav-link" href="Instructors.php">Instructors</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Departments.php">Departments</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Courses.php">Courses</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link active" href="Clubs.php">Clubs</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Seminars.php">Seminars</a>
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
	<button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?add=true" class="nav-link">Add Club</a></button>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Name</th>
            <th scope="col">Website</th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
          </tr>
        </thead>
          <!--[if lt IE 9]>
            Tables here - rows
          <![endif]-->
        <tbody>
	   <?php for($i = 0; $i < count($names); $i++) { ?>
		<tr>
		<td>
			<?php echo $names[$i] ?>
		</td>
		<td>
			<?php echo $websites[$i] ?>
		</td>
		<td><button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?edit=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Edit</a></button></td>
		<td><button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?delete=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Remove</a></button></td>
		<td><button type="button" class="btn btn-primary btn-sm"><a href="Clubs.php?details=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Details</a></button></td>
		</tr>
	   <?php } ?>
        </tbody>
      </table>
    </div>

  </body>
</html>
