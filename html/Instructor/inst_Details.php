<!-- php scripts -->
<?php
session_start();
require "../../php/config.php";

if (isset($_SESSION['person_ID'])){
  //populate the page from DB
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_SESSION['person_ID'];
    $curr_semester = $_SESSION['curr_semester'];
    $curr_year = $_SESSION['curr_year'];

    $sql = "SELECT P.first_name, P.last_name, P.gender, P.email, P.phone, P.address, P.hash_password, D.name as department, I.rank,
            EC.first_name as ec_name, EC.last_name as ec_l_name, EC.phone as ec_contact, EC.relation as ec_relation,
            EC.email as ec_email
            FROM Person as P, Dept_Person as D, Instructor as I, Emergency_Contact as EC
            WHERE P.person_ID = :id and D.person_ID = :id and EC.person_ID = :id;";

    $statement1 = $connection->prepare($sql);
    $statement1->bindParam(':id', $id, PDO::PARAM_STR);
    $statement1->execute();
    //all variables
    $result = $statement1->fetchAll()[0];


    $first_name = $result['first_name'];
    $last_name = $result['last_name'];
    $email = $result['email'];
    $phone = $result['phone'];
    $address = $result['address'];
    $gender = $result['gender'];
    $department = $result['department'];
    $rank = $result['rank'];
    $ec_name = $result['ec_name'];
    $ec_l_name = $result['ec_l_name'];
    $ec_contact = $result['ec_contact'];
    $ec_email = $result['ec_email'];
    $ec_relation = $result['ec_relation'];
    $password = $result['hash_password'];
    

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
  <h1>SAIRS Instructor</h1>
    <body>
        <div>
        <ul class="nav nav-tabs sticky-top nav-justified">
                <li class="nav-item ">
                    <a class="nav-link " data-toggle="tab" href="inst_Home.php">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="inst_Stud.php">Students</a>
                </li>
                <li class="nav-item active">
                  <a class="nav-link active" data-toggle="tab" href="inst_Details.php">Instructor</a>
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
                <li class="nav-item">
                  <a class="nav-link" data-toggle="tab" href="Instructor_Seminar.php">Seminars</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="../../php/logout.inc.php">Logout</a>
              </li>
              </ul>
            <div id="myTabContent" class="tab-content">
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
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php echo $rank; ?>" name="rank" readonly=""></th>
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
            </tbody>
          </table>
          <div class="dropdown-divider pt-3"></div>
          <div class="container text-center">
            <input type="submit" class="btn btn-primary" name="save" role="button" value="Save">
          </div>
        </form>     
    