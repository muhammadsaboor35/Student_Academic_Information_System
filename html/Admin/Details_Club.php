<?php
session_start();
if (isset($_SESSION['person_ID'])){
  $p_ID = $_SESSION['person_ID'];

  require "../../php/config.php";

  if(isset($_GET['name'])) {
    $name = $_GET['name'];
  }
  else if(isset($_POST['name'])) {
    $name = $_POST['name'];

  }

  if(isset($_GET['search'])) {

    $searchVar = $_GET['searchVar'];
    $criteria = $_GET['criteria'];
    $connection = new PDO($dsn, $username, $password, $options);
    $student_IDs = array();
    $first_names = array();
    $last_names = array();

    if($criteria == '0') {
    $sql = "select P.student_ID, Q.first_name, Q.last_name from Participates as P, Person as Q where P.student_ID = Q.person_ID
      AND P.name = :name AND Q.first_name LIKE CONCAT('%', :searchVar, '%')";
      $statement = $connection->prepare($sql);
      $statement->bindParam(":name", $name, PDO::PARAM_STR);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll();
    foreach($result as $item) {
      array_push($student_IDs, $item[0]);
      array_push($first_names, $item[1]);
      array_push($last_names, $item[2]);
    }
    }
    else if($criteria == '1') {
    $sql = "select P.student_ID, Q.first_name, Q.last_name from Participates as P, Person as Q where P.student_ID = Q.person_ID
      AND P.name = :name AND Q.last_name LIKE CONCAT('%', :searchVar, '%')";
      $statement = $connection->prepare($sql);
      $statement->bindParam(":name", $name, PDO::PARAM_STR);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll();
    foreach($result as $item) {
      array_push($student_IDs, $item[0]);
      array_push($first_names, $item[1]);
      array_push($last_names, $item[2]);
    }
    }
    else if($criteria == '2') {
    $sql = "select P.student_ID, Q.first_name, Q.last_name from Participates as P, Person as Q where P.student_ID = Q.person_ID
      AND P.name = :name AND P.student_ID = :searchVar";
      $statement = $connection->prepare($sql);
      $statement->bindParam(":name", $name, PDO::PARAM_STR);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_INT);
      $statement->execute();
      $result = $statement->fetchAll();
    foreach($result as $item) {
      array_push($student_IDs, $item[0]);
      array_push($first_names, $item[1]);
      array_push($last_names, $item[2]);
    }
    }
    $student_IDs_Value = base64_encode(serialize($student_IDs));
    $first_names_Value = base64_encode(serialize($first_names));
    $last_names_Value = base64_encode(serialize($last_names));
    $data = array('student_IDs' => $student_IDs_Value, 'first_names' => $first_names_Value, 'last_names'=> $last_names_Value, 'name' => $name);
    $options = array(
      'http' => array(
          'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
          'method'  => 'POST',
          'content' => http_build_query($data)
      )
    );
    $context  = stream_context_create($options);
    $result = file_get_contents("Details_Club.php", false, $context);
  }
  else{
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "select P.student_ID, Q.first_name, Q.last_name from Participates as P, Person as Q where P.student_ID = Q.person_ID
      AND P.name = :name";
    $name = $_GET['name'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    $student_IDs = array();
    $first_names = array();
    $last_names = array();
    foreach($result as $item) {
      array_push($student_IDs, $item[0]);
      array_push($first_names, $item[1]);
      array_push($last_names, $item[2]);
    }

  } catch(PDOException $error) {
      echo $sql . "<br>" . $error->getMessage();

  }
  if(isset($_POST['first_names'])) {
    $first_names = unserialize(base64_decode($_POST['first_names']));
  }
  if(isset($_POST['last_names'])) {
    $last_names = unserialize(base64_decode($_POST['last_names']));
  }
  if(isset($_POST['student_IDs'])) {
    $student_IDs = unserialize(base64_decode($_POST['student_IDs']));
  }

  }


  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT C.name, C.phone, C.website, C.budget, C.head_ID, P.first_name, P.last_name FROM Club C, Person P WHERE C.name = :name AND C.head_ID = P.person_ID;";
    $statement = $connection->prepare($sql);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    $phone = $result[0][1];
    $website = $result[0][2];
    $budget = $result[0][3];
    $instructor_ID = $result[0][4];
    $instructor_first_name = $result[0][5];
    $instructor_last_name = $result[0][6];
    $instructor = $instructor_first_name.' '.$instructor_last_name.' ('.$instructor_ID.')';

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
    <title>Club Details | Admin</title>
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
      <table class="table table-hover justify-content-center text-center">
          <!--[if lt IE 9]>
            Tables here - rows
          <![endif]-->
        <tbody>
		<tr> <td> Name </td> <td> <?php echo $name ?></td> </tr>
		<tr> <td> Phone </td> <td> <?php echo $phone ?> </td> </tr>
		<tr> <td> Website </td> <td> <?php echo $website ?></td> </tr>
		<tr> <td> Budget </td> <td> <?php echo $budget ?></td> </tr>
		<tr> <td> Head </td> <td> <?php echo $instructor ?></td> </tr>
        </tbody>
      </table>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <h4>Members: </h4>
      <table class="table table-hover justify-content-center text-center">
          <!--[if lt IE 9]>
            Tables here - rows
          <![endif]-->
	<div class="container">
	    <div class="row">
        	  <div class="col-md-8">
                	<form class="form-inline">
                	    Search<input type="text" name="searchVar" class="input-small" placeholder="Search...">
			    <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
                	    <select id="criteria" name="criteria">
                	        <option value="0">First Name</option>
                	        <option value="1">Last Name</option>
                	        <option value="2">ID</option>
                	    </select>
                	    <button type="submit" name="search" class="btn">Search</button>
                	</form>
          	</div>
    	    </div>
	</div>
	<thead>
          <tr class="table-secondary">
            <th scope="col">Student ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
          </tr>
	</thead>
        <tbody>
           <?php for($i = 0; $i < count($first_names); $i++) { ?>
                <tr>
                <td>
                        <?php echo $student_IDs[$i] ?>
                </td>
                <td>
                        <?php echo $first_names[$i] ?>
                </td>
                <td>
                        <?php echo $last_names[$i] ?>
                </td>
                </tr>
           <?php } ?>

        </tbody>
      </table>
    </div>
  </body>
</html>
