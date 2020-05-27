<!-- php scripts -->
<?php
session_start();


if (isset($_SESSION['person_ID'])){
  require "../../php/config.php";
  //populate the page from DB
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_SESSION['person_ID'];
    $curr_semester = $_SESSION['curr_semester'];
    $curr_year = $_SESSION['curr_year'];

    $sql = "SELECT Pe.first_name, Pe.last_name, Pe.email, Pe.gender, Pe.phone, st.degree, Pe.address, Pe.hash_password,
                   st.current_semester, st.cgpa, P.first_name as advisor_name, P.last_name as advisor_l_name, 
                   P.email as advisor_email, EC.first_name as ec_name, EC.last_name as ec_l_name, 
                   EC.email as ec_email, EC.phone as ec_contact, EC.relation as ec_relation, DP.name as department
            FROM ((Person as Pe inner join Student as st on Pe.person_ID = st.student_ID)), 
                  ((Person as P inner join Instructor as ins on P.person_ID = ins.instructor_ID)),
                  ((Person as PP inner join Emergency_Contact as EC on PP.person_ID = EC.person_ID)),
                  ((Person as Pr inner join Dept_Person as DP on Pr.person_ID = DP.person_ID))
            WHERE 
                  st.student_ID = $id and 
                  st.advisor_ID = ins.instructor_ID and
                  EC.person_ID = $id and
                  DP.person_ID = $id;";
    $statement1 = $connection->prepare($sql);
    $statement1->execute();
    $sql1 = "SELECT ta_ID FROM Teaching_Assistant where ta_ID = $id;";
    $statement2 = $connection->prepare($sql1);
    $statement2->execute();
    //all variables
    $result = $statement1->fetchAll()[0];
    $first_name = $result['first_name'];
    $last_name = $result['last_name'];
    $email = $result['email'];
    $phone = $result['phone'];
    $address = $result['address'];
    $gender = $result['gender'];
    $department = $result['department'];
    $degree = $result['degree'];
    $c_semester = $result['current_semester'];
    $advisor_name = $result['advisor_name'];
    $advisor_l_name = $result['advisor_l_name'];
    $advisor_email = $result['advisor_email'];
    $ec_name = $result['ec_name'];
    $ec_l_name = $result['ec_l_name'];
    $ec_contact = $result['ec_contact'];
    $ec_email = $result['ec_email'];
    $ec_relation = $result['ec_relation'];
    $cgpa = $result['cgpa'];
    $t_a = "NO";
    $password = $result['hash_password'];
    if (!empty($statement2->fetchAll()))
      $t_a = "YES";
    

    if (isset($_POST['save'])){
      if(strlen($_POST['first_name']) > 0){
        $first_name = $_POST['first_name'];
      }
      if(strlen($_POST['last_name']) > 0){
        $last_name = $_POST['last_name'];
      }
      if(strlen($_POST['email']) > 0){
        $email = $_POST['email'];
      }
      if(strlen($_POST['phone']) > 0){
        $phone = $_POST['phone'];
      }
      if(strlen($_POST['password']) > 0){
        $password = hash('md5',$_POST['password']);
      }
      if(strlen($_POST['address']) > 0){
        $address = $_POST['address'];
      }
      if(strlen($_POST['gender']) > 0){
        $gender = $_POST['gender'];
      }
  
      if(strlen($_POST['ec_name']) > 0){
        $ec_name = $_POST['ec_name'];
      }
      if(strlen($_POST['ec_l_name']) > 0){
        $ec_l_name = $_POST['ec_l_name'];
      }
      if(strlen($_POST['ec_email']) > 0){
        $ec_email = $_POST['ec_email'];
      }
      if(strlen($_POST['ec_contact']) > 0){
        $ec_contact = $_POST['ec_contact'];
      }
      if(strlen($_POST['ec_relation']) > 0){
        $ec_relation = $_POST['ec_relation'];
      }
      $sql = "UPDATE Person
            SET first_name = '$first_name', last_name = '$last_name', hash_password = '$password',
                email = '$email', phone = '$phone', address = '$address', gender = '$gender'
            WHERE person_ID = $id;";
      $statement1 = $connection->prepare($sql);
      $statement1->execute();
    }
    
  }catch(PDOException $error) {
    echo $sql . "<br>" . $error->getMessage();
  }
}else{
  header("Location: http://localhost/html/Login/Login_as_Student.php");
    exit();
}


?>


<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Details | Student</title>
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
          <a class="nav-link" href="Home.php">Home</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link active" href="Details.php">Details</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Grades.php">Grades</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Transcript.php">Transcript</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Registration.php">Registration</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Clubs.php">Clubs</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Seminars.php">Seminars</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
        </li>
      </ul>
    </nav>
    <div class="dropdown-divider pt-4"></div>
    <div class="container">
      <div class="jumbotron">
      <form method="post" action="">
          <table class="table table-hovertext-center">
            <tbody>
              <tr class="table-active">
                <th>Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $first_name; ?>" name="first_name"></th>
              </tr>
              <tr class="table-active">
                <th>Last Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $last_name; ?>" name="last_name"></th>
              </tr>
              <tr class="table-active">
                <th>Email:</th>
                <th><input type="email" class="form-control form-control-lg" placeholder="<?php echo $email; ?>" name="email"></th>
              </tr>
              <tr class="table-active">
                <th>Password:</th>
                <th><input type="password" class="form-control form-control-lg" placeholder="**********" name="password"></th>
              </tr>
              <tr class="table-active">
                <th>Contact No:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $phone; ?>" name="phone"></th>
              </tr>
              <tr class="table-active">
                <th>Address:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $address; ?>" name="address"></th>
              </tr>
              <tr class="table-active">
                <th>Gender:</th>
                <th><select class="form-control-lg" name="gender">
                  <option selected=""><?php echo $gender; ?></option>
                  <?php $genders = array();
                        if ($gender != "Male")
                          array_push($genders, "Male");
                        if ($gender != "Female")
                          array_push($genders, "Female");
                        if ($gender != "Others")
                          array_push($genders, "Others");
                        foreach($genders as $item) {?>
                          <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php } ?>?>
                </select></th>
              </tr>
              <tr class="table-active">
                <th>Department:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $department; ?>" name="department" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Degree:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $degree; ?>" name="degree" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Current Semester:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $c_semester; ?>" name="c_semester" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Advisor Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $advisor_name; ?>" name="advisor_name" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Advisor Last Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $advisor_l_name; ?>" name="advisor_l_name" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Advisor Email:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $advisor_email; ?>" name="advisor_email" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Emergency Contact Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $ec_name; ?>" name="ec_name"></th>
              </tr>
              <tr class="table-active">
                <th>Emergency Contact Last Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $ec_l_name; ?>" name="ec_l_name"></th>
              </tr>
              <tr class="table-active">
                <th>Emergency Contact No:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $ec_contact; ?>" name="ec_contact"></th>
              </tr>
              <tr class="table-active">
                <th>Emergency Contact Email:</th>
                <th><input type="email" class="form-control form-control-lg" placeholder="<?php echo $ec_email; ?>" name="ec_email"></th>
              </tr>
              <tr class="table-active">
                <th>Emergency Contact Relation:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $ec_relation; ?>" name="ec_relation"></th>
              </tr>
              <tr class="table-active">
                <th>CGPA:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $cgpa; ?>" name="cgpa" readonly=""></th>
              </tr>
              <tr class="table-active">
                <th>Teaching Assistant:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $t_a; ?>" name="t_a" readonly=""></th>
              </tr>
            </tbody>
          </table>
          <div class="dropdown-divider pt-3"></div>
          <div class="container text-center">
            <input type="submit" class="btn btn-primary" name="save" role="button" value="Save">
          </div>
        </form>                  
      </div>
    </div>
  </body>
</html>