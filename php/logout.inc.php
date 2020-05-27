<?php

session_start();
require "config.php";
$person_ID = $_SESSION['person_ID'];
$connection = new PDO($dsn, $username, $password, $options);

$sql = "UPDATE Person SET login_status = 'Off' WHERE person_ID = $person_ID;";
$statement1 = $connection->prepare($sql);
$statement1->execute();
session_unset();

session_destroy();

session_start();
$connection = new PDO($dsn, $username, $password, $options);

$sql = "UPDATE Person SET login_status = 'Off' WHERE person_ID = $person_ID;";
$statement1 = $connection->prepare($sql);
$statement1->execute();
session_unset();

session_destroy();
$sql = "SELECT P.person_ID FROM Person P, Student S WHERE P.person_ID = $person_ID AND P.person_ID = S.student_ID;";
$statement1 = $connection->prepare($sql);
$statement1->execute();
$result = $statement1->fetchAll();
if (count($result) > 0) {
	header("Location: ../html/Login/Login_as_Student.php");
	exit();
}
else {
$sql = "SELECT P.person_ID FROM Person P, Instructor S WHERE P.person_ID = $person_ID AND P.person_ID = S.instructor_ID;";
$statement1 = $connection->prepare($sql);
$statement1->execute();
$result = $statement1->fetchAll();
if (count($result) > 0) {
	header("Location: ../html/Login/Login_as_Instructor.php");
	exit();
}
else {
$sql = "SELECT P.person_ID FROM Person P, Teaching_Assistant S WHERE P.person_ID = $person_ID AND P.person_ID = S.ta_ID;";
$statement1 = $connection->prepare($sql);
$statement1->execute();
$result = $statement1->fetchAll();
if (count($result) > 0) {
	header("Location: ../html/Login/Login_as_Teaching_Assitant.php");
	exit();
}
else {
$sql = "SELECT P.person_ID FROM Person P, Admin S WHERE P.person_ID = $person_ID AND P.person_ID = S.admin_ID;";
$statement1 = $connection->prepare($sql);
$statement1->execute();
$result = $statement1->fetchAll();
if (count($result) > 0) {
	header("Location: ../html/Login/Login_as_Admin.php");
	exit();
}
}
}
}



?>