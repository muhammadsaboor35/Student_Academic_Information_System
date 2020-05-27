<?php
  $id = 0;
  try {
    require "../../php/config.php";
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "SELECT max(person_ID) FROM Person";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    if(isset($result[0][0])) {
	$id = $result[0][0];
    }
    $id = $id + 1;

    $sql = "SELECT name FROM Department";
    $statement = $connection->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll();
    $departments = array();
    foreach($result as $dept) {
      array_push($departments, $dept[0]);
    }

  } catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }

if (isset($_POST['signup'])) {
  try {
    require "../../php/config.php";
    $connection = new PDO($dsn, $username, $password, $options);
    $sql = "insert into Person
	values ( :id, :first_name, :last_name, :hash_password, :login_status, :phone, :email, :gender, :address)";
    $password = hash('md5',$_POST['password']);
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $login_status = 'Off';
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $dept = $_POST['dept'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':phone', $phone, PDO::PARAM_STR);
    $statement->bindParam(':login_status', $login_status, PDO::PARAM_STR);
    $statement->bindParam(':hash_password', $password, PDO::PARAM_STR);
    $statement->bindParam(':first_name', $first_name, PDO::PARAM_STR);
    $statement->bindParam(':last_name', $last_name, PDO::PARAM_STR);
    $statement->bindParam(':email', $email, PDO::PARAM_STR);
    $statement->bindParam(':gender', $gender, PDO::PARAM_STR);
    $statement->bindParam(':address', $address, PDO::PARAM_STR);
    $statement->execute();

    $sql = "insert into Emergency_Contact
	values (:id, :emergency_email, :emergency_first_name, :emergency_last_name, :emergency_relation, :emergency_phone)";
    $emergency_email = $_POST['emergency_email'];
    $emergency_phone = $_POST['emergency_phone'];
    $emergency_first_name = $_POST['emergency_name'];
    $emergency_last_name = $_POST['emergency_lname'];
    $emergency_relation = $_POST['emergency_relation'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':emergency_phone', $emergency_phone, PDO::PARAM_STR);
    $statement->bindParam(':emergency_email', $emergency_email, PDO::PARAM_STR);
    $statement->bindParam(':emergency_first_name', $emergency_first_name, PDO::PARAM_STR);
    $statement->bindParam(':emergency_last_name', $emergency_last_name, PDO::PARAM_STR);
    $statement->bindParam(':emergency_relation', $emergency_relation, PDO::PARAM_STR);
    $statement->execute();

    $sql = "INSERT INTO Instructor
	 	values (:id, :rank)";

    $rank = $_POST['rank'];

    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':rank', $rank, PDO::PARAM_STR);
    $statement->execute();

    $sql = "INSERT INTO Dept_Person
		values (:dept, :id)";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':dept', $dept, PDO::PARAM_STR);
    $statement->execute();

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
    <title>Signup | Instructor</title>
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
	  <div class="col-sm-12 my-auto">Signup As: </div>
	</li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Signup_as_Student.php">Student</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link active" href="Signup_as_Instructor.php">Instructor</a>
        </li>
	<li class="nav-item pr-3">
	  <a class="nav-link" href="Signup_as_Teaching_Assistant.php">Teaching Assistant</a>
	</li>
	<li class="nav-item pr-3">
	  <a class="nav-link" href="Signup_as_Admin.php">Admin</a>
</li>
      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
      <div class="jumbotron custom-container container">
        <form method="post" action="">
	  <fieldset>
	    <div class="form-group custom-container2 container">
      	      <label for="id">user ID</label>
      	      <input type="text" class="form-control" name="id" disabled="" value="<?php echo $id;?>">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="first_name">First Name</label>
      	      <input type="text" class="form-control" name="first_name" placeholder="Enter first name">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="last_name">Last Name</label>
      	      <input type="text" class="form-control" name="last_name" placeholder="Enter last name">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="email">Email</label>
      	      <input type="email" class="form-control" name="email" placeholder="Enter email">
            </div>
	    <div class="form-group custom-container2 container">
	      <label for="password">Password</label>
	      <input type="password" class="form-control" name="password" placeholder="Enter password">
	    </div>
	    <div class="form-group custom-container2 container">
		<label for="phone">Contact No.</label>
		<input type="text" class="form-control" name="phone" placeholder="Enter contact number">
	    </div>
      	    <label for="genderdropdown">Gender</label>
	    <div id="genderdropdown" class="form-group custom-container2 container">
	      <select name="gender" class="custom-select">
		<option selected=""></option>
		<option value="Male">Male</option>
		<option value="Female">Female</option>
		<option value="Other">Other</option>
	      </select>
	    </div>
      	    <label for="rankdropdown">Rank</label>
	    <div id="rankdropdown" class="form-group custom-container2 container">
	      <select name="rank" class="custom-select">
		<option selected=""></option>
		<option value="Associate">Associate</option>
		<option value="Assistant">Assistant</option>
		<option value="Professor">Professor</option>
		<option value="Coordinator">Coordinator</option>
		<option value="Head">Head</option>
		<option value="Dean">Dean</option>
	      </select>
            </div>
      	    <label for="deptdropdown">Department</label>
	    <div id="deptdropdown" class="form-group custom-container2 container">
		<select name="dept" class="custom-select">
	           <option selected=""></option>
		   <?php
			foreach($departments as $item) {?>
			    <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
			<?php } ?>
		</select>
	    </div>
	    <div class="form-group custom-container2 container">
      	      <label for="address">Address</label>
      	      <input type="text" class="form-control" name="address" placeholder="Enter address">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="emergency_name">Emergency Contact First Name</label>
      	      <input type="text" class="form-control" name="emergency_name" placeholder="Enter Emergency Contact first name">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="emergency_lname">Emergency Contact Last Name</label>
      	      <input type="text" class="form-control" name="emergency_lname" placeholder="Enter Emergency Contact last name">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="emergency_email">Emergency Contact Email</label>
      	      <input type="email" class="form-control" name="emergency_email" placeholder="Enter Emergency Contact email">
            </div>
	    <div class="form-group custom-container2 container">
      	      <label for="emergency_relation">Emergency Contact Relation</label>
      	      <input type="text" class="form-control" name="emergency_relation" placeholder="Enter Emergency Contact's relation with you">
            </div>
	    <div class="form-group custom-container2 container">
		<label for="emergency_phone">Emergency Contact No.</label>
		<input type="text" class="form-control" name="emergency phone" placeholder="Enter emergency contact number">
	    </div>
            <div>
              <input type="submit" class="btn btn-primary" name="signup" role="button" value="Signup">
              <a class="btn btn-link" href="Login_as_Instructor.php" role="button">Already registered? Login</a>
            </div>
	  </fieldset>
	</form>
      </div>

  </body>
</html>
