<?php
session_start();
if (isset($_SESSION['person_ID'])){
$p_ID = $_SESSION['person_ID'];

require "../../php/config.php";


if(isset($_GET['search'])) {

  $searchVar = $_GET['searchVar'];
  $criteria = $_GET['criteria'];
  $connection = new PDO($dsn, $username, $password, $options);
  $names = array();
  $dates = array();
  $times = array();
  $hosts = array();
  $host_IDs = array();

  if($criteria == '0') {
  $sql = "SELECT name, seminar_date, seminar_time, host_ID, first_name, last_name FROM (Seminar, Person) WHERE host_ID = person_ID AND name LIKE CONCAT('%', :searchVar, '%');";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
  foreach($result as $item) {
    array_push($names, $item[0]);
    array_push($dates, $item[1]);
    array_push($times, $item[2]);
    array_push($host_IDs, $item[3]);
    array_push($hosts, $item[4].' '.$item[5]);
  }
  }
  else if($criteria == '1') {
  $sql = "SELECT name, seminar_date, seminar_time, host_ID, first_name, last_name FROM (Seminar, Person) WHERE host_ID = person_ID AND first_name LIKE CONCAT('%', :searchVar, '%')";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
  foreach($result as $item) {
    array_push($names, $item[0]);
    array_push($dates, $item[1]);
    array_push($times, $item[2]);
    array_push($host_IDs, $item[3]);
    array_push($hosts, $item[4].' '.$item[5]);
  }
  }
  else if($criteria == '2') {
  $sql = "SELECT name, seminar_date, seminar_time, host_ID, first_name, last_name FROM (Seminar, Person) WHERE host_ID = person_ID AND last_name LIKE CONCAT('%', :searchVar, '%')";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':searchVar', $searchVar, PDO::PARAM_STR);
    $statement->execute();
    $result = $statement->fetchAll();
  foreach($result as $item) {
    array_push($names, $item[0]);
    array_push($dates, $item[1]);
    array_push($times, $item[2]);
    array_push($host_IDs, $item[3]);
    array_push($hosts, $item[4].' '.$item[5]);
  }
  }
  $names_Value = base64_encode(serialize($names));
  $dates_Value = base64_encode(serialize($dates));
  $times_Value = base64_encode(serialize($times));
  $hosts_Value = base64_encode(serialize($hosts));
  $host_IDs_Value = base64_encode(serialize($host_IDs));
  $data = array('names' => $names_Value,'dates' => $dates_Value,'times' => $times_Value,'hosts' => $hosts_Value,'host_IDs' => $host_IDs_Value);
  $options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
  );
  $context  = stream_context_create($options);
  $result = file_get_contents("Instructor_Seminars.php", false, $context);
}
else {
if(isset($_GET['create'])) {
	header("Location: http://localhost/html/Instructor/Create_Seminar.php");
	exit();
}

if(isset($_GET['join'])) {
	$name = $_GET['name_var'];
	$date = $_GET['date'];
	$host_ID = $_GET['host_ID'];
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT person_ID FROM Attends WHERE name = :name_var AND seminar_date = :date AND host_ID = :host_ID;";
  $statement = $connection->prepare($sql);
  $statement->bindParam(':name_var', $name, PDO::PARAM_STR);
  $statement->bindParam(':date', $date, PDO::PARAM_STR);
  $statement->bindParam(':host_ID', $host_ID, PDO::PARAM_INT);
  $statement->execute();
  $result = $statement->fetchAll();
  $already_joined = false;
  foreach($result as $item) {
    if($item[0] == $_SESSION['person_ID']) {
        $already_joined = true;
    }
  }
  if($already_joined == true) {
     //show warning
     echo '<div class="alert alert-dismissible alert-danger">
  <button type="button" class="close" data-dismiss="alert">&times;</button>
  <strong>Already attending!</strong> You are already attending this seminar.
</div>';
  }
  else {
     //update
  $connection = new PDO($dsn, $username, $password, $options);

     $sql = "INSERT INTO Attends VALUES(:name_var, :seminar_date, :host_ID, :person_ID);";
  $statement = $connection->prepare($sql);
  $statement->bindParam(':name_var', $name, PDO::PARAM_STR);
  $statement->bindParam(':seminar_date', $date, PDO::PARAM_STR);
  $statement->bindParam(':host_ID', $host_ID, PDO::PARAM_INT);
  $statement->bindParam(':person_ID', $_SESSION['person_ID'], PDO::PARAM_INT);
  $statement->execute();
  ?>
    <div class="alert alert-dismissible alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Successfull!</strong> You successfully registered to the Seminar.
    </div>
  <?php
  }
}

if(isset($_GET['delete'])) {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "DELETE FROM Club WHERE name = :name_var;";
  $name_var = $_GET['name_var'];
  $statement = $connection->prepare($sql);
  $statement->bindParam(':name_var', $name_var, PDO::PARAM_STR);
  $statement->execute();
  ?>
    <div class="alert alert-dismissible alert-success">
      <button type="button" class="close" data-dismiss="alert">&times;</button>
      <strong>Successfull!</strong> You successfully unregistered from the Seminar.
    </div>
  <?php
}

if(isset($_GET['details'])) {
	$name_var = $_GET['name_var'];
	$date = $_GET['date'];
	$host_ID = $_GET['host_ID'];
	header("Location: http://localhost/html/Instructor/Details_Seminar.php?name=".$name_var."&date=".$date."&host_ID=".$host_ID);
	exit();
}

try {
  $connection = new PDO($dsn, $username, $password, $options);

  $sql = "SELECT name, seminar_date, seminar_time, host_ID, first_name, last_name FROM Seminar, Person WHERE host_ID = person_ID;";
  $statement = $connection->prepare($sql);
  $statement->execute();
  $result = $statement->fetchAll();
  $names = array();
  $dates = array();
  $times = array();
  $host_IDs = array();
  $hosts = array();
  foreach($result as $item) {
    array_push($names, $item[0]);
    array_push($dates, $item[1]);
    array_push($times, $item[2]);
    array_push($host_IDs, $item[3]);
    array_push($hosts, $item[4].' '.$item[5]);
  }
} catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
}
if(isset($_POST['names'])) {
  $names = unserialize(base64_decode($_POST['names']));
}
if(isset($_POST['dates'])) {
  $dates = unserialize(base64_decode($_POST['dates']));
}
if(isset($_POST['times'])) {
  $times = unserialize(base64_decode($_POST['times']));
}
if(isset($_POST['hosts'])) {
  $hosts = unserialize(base64_decode($_POST['hosts']));
}
if(isset($_POST['host_IDs'])) {
  $host_IDs = unserialize(base64_decode($_POST['host_IDs']));
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
    <title>Seminars | Instructors</title>
    <link href="../../css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/style.css" />
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4/jquery.min.js" type="text/javascript"></script>
  </head>

  <body>
    <h1 class='text-center pb-4 pt-3'>Student Academic Information & Registration System</h1>
    <nav class="navbar sticky-top justify-content-center navbar-expand-lg navbar-dark bg-primary pt-2 pb-2 mx-auto" style="width: 50%;">
    <ul class="nav nav-tabs sticky-top nav-justified">
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="inst_Home.php">Home</a>
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
	<button type="button" class="btn btn-primary btn-sm"><a href="Create_Seminar.php" class="nav-link">Create Seminar</a></button>
    </div>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
       <div class="col-md-8">
            <form class="form-inline">
                Search<input type="text" name="searchVar" class="input-small" placeholder="Search...">
                <input type="hidden" name="name" value="<?php echo $_GET['name']; ?>">
                <select id="criteria" name="criteria">
                    <option value="0">Name</option>
                    <option value="1">Host First Name</option>
                    <option value="2">Host Last Name</option>
                </select>
                <button type="submit" name="search" class="btn">Search</button>
            </form>
        </div>
    </div>
    <div class="container">
      <table class="table table-hover justify-content-center text-center">
        <thead>
          <tr class="table-secondary">
            <th scope="col">Name</th>
            <th scope="col">Date</th>
            <th scope="col">Time</th>
            <th scope="col">Host</th>
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
			<?php echo $dates[$i] ?>
		</td>
		<td>
			<?php echo $times[$i] ?>
		</td>
		<td>
			<?php echo $hosts[$i] ?>
		</td>
		<td><button type="button" class="btn btn-primary btn-sm"><a href="Instructor_Seminar.php?details=true&name_var=<?php echo $names[$i] ?>&date=<?php echo $dates[$i] ?>&host_ID=<?php echo $host_IDs[$i] ?>" class="nav-link">Details</a></button></td>

		<?php if($host_IDs[$i] == $_SESSION['person_ID']) { ?>
		<td><button disabled="" type="button" class="btn btn-primary btn-sm"><a class="nav-link">Join</a></button></td>
		<?php } else { ?>
		<td><button type="button" class="btn btn-primary btn-sm"><a href="Instructor_Seminar.php?join=true&name_var=<?php echo $names[$i] ?>&date=<?php echo $dates[$i] ?>&host_ID=<?php echo $host_IDs[$i] ?>" class="nav-link">Join</a></button></td>
		<?php } ?>
		<?php if($host_IDs[$i] == $_SESSION['person_ID']) { ?>
		<td><button type="button" class="btn btn-primary btn-sm"><a href="Instructor_Seminar.php?delete=true&name_var=<?php echo $names[$i] ?>" class="nav-link">Remove</a></button></td>
		<?php } else { ?>
		<td><button disabled="" type="button" class="btn btn-primary btn-sm"><a class="nav-link">Remove</a></button></td>
		<?php } ?>
		</tr>
	   <?php } ?>
        </tbody>
      </table>
    </div>

  </body>
</html>
