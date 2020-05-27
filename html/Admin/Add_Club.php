<?php
session_start();

if (isset($_SESSION['person_ID'])){
  $p_ID = $_SESSION['person_ID'];

  require "../../php/config.php";
  if(isset($_POST['search'])) {

    $searchVar = $_POST['searchVar'];
    $criteria = $_POST['criteria'];
    $connection = new PDO($dsn, $username, $password, $options);
    $instructors = array();
    if($criteria == 'First Name') {
      $sql = "SELECT instructor_ID, first_name, last_name FROM Instructor NATURAL JOIN Person WHERE first_name LIKE CONCAT('%', :searchVar, '%') AND person_ID = instructor_ID";
      $statement = $connection->prepare($sql);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $item) {
        array_push($instructors, $item[0]." - ".$item[1]." ".$item[2]);
      }
    }
    else if($criteria == 'lastName') {
      $sql = "SELECT instructor_ID, first_name, last_name FROM Instructor NATURAL JOIN Person WHERE last_name LIKE CONCAT('%', :searchVar, '%') AND person_ID = instructor_ID";
      $statement = $connection->prepare($sql);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $item) {
        array_push($instructors, $item[0]." - ".$item[1]." ".$item[2]);
      }
    }
    else if($criteria == 'id') {
      $sql = "SELECT instructor_ID, first_name, last_name FROM Instructor NATURAL JOIN Person WHERE instructor_ID = :searchVar AND person_ID = instructor_ID";
      $statement = $connection->prepare($sql);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $item) {
        array_push($instructors, $item[0]." - ".$item[1]." ".$item[2]);
      }
    }
    $instructorsValue = base64_encode(serialize($instructors));
    $data = array('instructors' => $instructorsValue);
    $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
      )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents("Add_Club.php", false, $context);
  }
  else{
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT instructor_ID, first_name, last_name FROM Instructor, Person WHERE person_ID = instructor_ID";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $instructors = array();
    foreach($result as $item) {
      array_push($instructors, $item[0]." - ".$item[1]." ".$item[2]);
    }

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();
  }
  }
  if(isset($_POST['instructors'])) {
    $instructors = unserialize(base64_decode($_POST['instructors']));
  }

  if(isset($_POST['add'])){
    try {
      $connection = new PDO($dsn, $username, $password, $options);

      $sql = "INSERT INTO Club values ( :name, :phone, :website, :budget, :head_ID);";
      $statement = $connection->prepare($sql);
      $name = $_POST['name'];
      $phone = $_POST['phone'];
      $website = $_POST['website'];
      $budget = $_POST['budget'];
      $instructor = $_POST['instructor'];
      $head_ID = substr($instructor, 0, strpos($instructor, ' '));
      $statement->bindParam(':name', $name, PDO::PARAM_STR);
      $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
      $statement->bindParam(':website', $website, PDO::PARAM_STR);
      $statement->bindParam(':budget', $budget, PDO::PARAM_INT);
      $statement->bindParam(':head_ID', $head_ID, PDO::PARAM_STR);
      $statement->execute();
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
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
    <title>Add Club | Admin</title>
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
        <form method="post" action="">
          <fieldset>
            <div class="form-group custom-container2 container">
              <label for="name">Name</label>
              <input type="text" class="form-control" name="name" placeholder="Enter Name">
            </div>
            <div class="form-group custom-container2 container">
              <label for="phone">Phone</label>
              <input type="text" class="form-control" name="phone" placeholder="Enter Phone">
            </div>
            <div class="form-group custom-container2 container">
              <label for="website">Website</label>
              <input type="text" class="form-control" name="website" placeholder="Enter Website">
            </div>
            <div class="form-group custom-container2 container">
              <label for="budget">Budget</label>
              <input type="text" class="form-control" name="budget" placeholder="Enter Budget">
            </div>
            <div id="instdropdown" class="form-group custom-container2 container">
                <label for="instructor">Instructor</label>
		<select name="criteria" class="custom-select">
		<option selected="firstName">First Name</option>
		<option value="lastName">Last Name</option>
		<option value="id">Instructor ID</option>
		</select>
		<form class="form-inline my-2 my-lg-0">
			<input class="form-control mr-sm-2" type="text" name="searchVar" placeholder="Search">
			<button class="btn btn-secondary my-2 my-sm-0" name="search" type="submit">Search</button>
		   </form>
                <select id="instdrop" name="instructor" class="custom-select">
                   <option selected=""></option>
                   <?php
                        foreach($instructors as $item) {?>
                            <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php } ?>
                </select>
            </div>
	    <div class="dropdown-divider pt-2"></div>
            <div>
              <input type="submit" class="btn btn-primary" name="add" role="button" value="Add">
            </div>
          </fieldset>
        </form>
    </div>

  </body>
</html>
