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
    $instructors = array();
    if($criteria == 'First Name') {
      $sql = "SELECT I.instructor_ID, P.first_name, P.last_name FROM Instructor I, Person P WHERE I.instructor_ID = P.person_ID AND P.first_name LIKE CONCAT('%', :searchVar, '%')";
      $statement = $connection->prepare($sql);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $item) {
        array_push($instructors, $item[0]." - ".$item[1]." ".$item[2]);
      }
    }
    else if($criteria == 'lastName') {
      $sql = "SELECT I.instructor_ID, P.first_name, P.last_name FROM Instructor I, Person P WHERE I.instructor_ID = P.person_ID AND P.last_name LIKE CONCAT('%', :searchVar, '%')";
      $statement = $connection->prepare($sql);
      $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
      $statement->execute();
      $result = $statement->fetchAll();
      foreach($result as $item) {
        array_push($instructors, $item[0]." - ".$item[1]." ".$item[2]);
      }
    }
    else if($criteria == 'id') {
      $sql = "SELECT I.instructor_ID, P.first_name, P.last_name FROM Instructor I, Person P WHERE I.instructor_ID = P.person_ID AND P.person_ID = :searchVar";
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
    $result = file_get_contents("Edit_Club_Details.php", false, $context);
  }
  else{
  try {
    $connection = new PDO($dsn, $username, $password, $options);

    $sql = "SELECT I.instructor_ID, P.first_name, P.last_name FROM Instructor I,  Person P WHERE I.instructor_ID = P.person_ID";
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

  if(isset($_GET['save'])) {
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT name, phone, website, budget, head_ID FROM Club  WHERE name = :name;";
    $name = $_GET['name'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
    $phone = $result[0][1];
    $website = $result[0][2];
    $budget = $result[0][3];
    $instructor_ID = $result[0][4];

    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "UPDATE Club
      set phone = :phone,
      website = :website,
      budget = :budget,
      head_ID = :head_ID
      WHERE name = :name;";
    if($_GET['phone'] != "") { $phone = $_GET['phone']; }
    if($_GET['website'] != "") { $website = $_GET['website']; }
    if($_GET['budget'] != "") { $budget = $_GET['budget']; }
    if($_GET['instructor'] != "") { $head_ID = substr($_GET['instructor'], 0, strpos($_GET['instructor'], ' ')); }
    $statement = $connection->prepare($sql);
    $statement->bindParam(":phone", $phone, PDO::PARAM_STR);
    $statement->bindParam(":website", $website, PDO::PARAM_STR);
    $statement->bindParam(":budget", $budget, PDO::PARAM_STR);
    $statement->bindParam(":head_ID", $head_ID, PDO::PARAM_INT);
    $statement->bindParam(":name", $name, PDO::PARAM_STR);
    $statement->execute();
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
    $instructor = $instructor_ID." - ".$instructor_first_name." ".$instructor_last_name;

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
      <div class="jumbotron">
      <form method="GET">
          <table class="table table-hovertext-center">
            <tbody>
              <tr class="table-active">
                <th>Name:</th>
                <th><input type="text" class="form-control form-control-lg" value="<?php echo $name; ?>" name="name" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Phone:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $phone; ?>" name="phone"></th>
              </tr>
              <tr class="table-active">
                <th>Website:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $website; ?>" name="website"></th>
              </tr>
              <tr class="table-active">
                <th>Budget:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $budget; ?>" name="budget"></th>
              </tr>
	    <tr class="table-active">
                <th>Head:</th>
                <th><select name="criteria" class="custom-select">
                <option selected="firstName">First Name</option>
                <option value="lastName">Last Name</option>
                <option value="id">Instructor ID</option>
                </select></th></tr>
                <tr><th></th><th><form method="GET" class="form-inline my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="text" name="searchVar" placeholder="Search">
			<!-- <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>"> -->
                        <button class="btn btn-secondary my-2 my-sm-0" name="search" type="submit">Search</button>
                   </form> </th> </tr>
                <tr><th></th><th><select id="instdrop" name="instructor" class="custom-select">
                   <option selected="<?php echo $instructor ?>"><?php echo $instructor ?></option>
                   <?php
                        foreach($instructors as $item) {?>
                            <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php } ?>
                </select> </th>
	   </tr>
	   </tbody>
	   <tr> <th></th><th>
			<!-- <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>"> -->
                        <button class="btn btn-secondary my-2 my-sm-0" name="save" type="submit">Save</button>
	</th></tr>
	</table>
      </form>
     </div>
    </div>
  </body>
</html>
