<!-- php scripts -->
<?php
session_start();
require "../../php/config.php";

if (isset($_SESSION['person_ID'])){
  try {
    $connection = new PDO($dsn, $username, $password, $options);
    $id = $_SESSION['person_ID'];
    $curr_semester = $_SESSION['curr_semester'];
    $curr_year = $_SESSION['curr_year'];
    $urgent = false;
    
    if (isset($_POST['order'])){
      if (strlen($_POST['address'])>0 && strlen($_POST['country'])>0 && strlen($_POST['name'])>0 && strlen($_POST['cvc'])>0 && strlen($_POST['date'])>0 && strlen($_POST['card'])>0){
        $date = date("d/m/Y");
        $method = $_POST['method'];
        $add = $_POST['address'];
        $country = $_POST['country'];
        $sql = "INSERT INTO Document
    		      values(NULL, 'Transcript', $date, $id, 50, '$method', '$add', '$country');";
        $statement = $connection->prepare($sql);
        $statement->execute();
        ?>
          <div class="alert alert-dismissible alert-success">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Successfull!</strong> You successfully ordered the transcript.
          </div>
        <?php
        // header("Refresh:0");
      }
      else{ ?>
        <div class="alert alert-dismissible alert-danger">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Error!</strong> <a href="#" class="alert-link">Fill all entries</a> and try submitting again.
        </div>
<?php }
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
    <title>Transcript | Student</title>
    <link href="../../css/bootstrap.css" rel="stylesheet" />
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
          <a class="nav-link" href="Details.php">Details</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link" href="Grades.php">Grades</a>
        </li>
        <li class="nav-item pr-3">
          <a class="nav-link active" href="Transcript.php">Transcript</a>
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
          <h3>Order Date: <?php echo date("Y/m/d"); ?></h3>
          <h3>Order Type: Transcript</h3>
          <div class="dropdown-divider pt-1"></div>
          <table class="table table-hovertext-center">
            <tbody>
              <tr class="table-active">
                <th>Delivery Method:</th>
                  <th><select class="form-control-lg" name="method">
                      <option selected="">Standard</option>
                      <option>Urgent</option>
                    </select></th>
              </tr>
              <tr class="table-active">
                <th>Domestic Address:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="Address" name="address"></th>
              </tr>
              <tr class="table-active">
                <th>Country:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="Country" name="country"></th>
              </tr>
              <tr class="table-active">
                <th>Cost:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="<?php if ($urgent){echo "100 TRY";} else {echo "50 TRY";} ?>" readonly=""></th>
              </tr>
            </tbody>
          </table>
          <h3>Payment Details</h3>
          <div class="dropdown-divider pt-1"></div>
          <table class="table table-hovertext-center">
            <tbody>
              <tr class="table-active">
                <th>Name:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="Name" name="name"></th>
              </tr>
              <tr class="table-active">
                <th>CVC:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="CVC" name="cvc"></th>
              </tr>
              <tr class="table-active">
                <th>Expiry Date:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="Date" name="date"></th>
              </tr>
              <tr class="table-active">
                <th>Card Number:</th>
                <th><input type="text" class="form-control form-control-lg" placeholder="Card Number" name="card"></th>
              </tr>
            </tbody>
          </table>
          <div class="dropdown-divider pt-3"></div>
          <div class="container text-center">
            <input type="submit" class="btn btn-primary" name="order" role="button" value="Order">
          </div>
        </form>
      </div>
    </div>   

  </body>
</html>