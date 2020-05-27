<?php

$host       = "localhost";
$username   = "root";
$password   = "";
$dbname     = "sairsdb";
$dsn        = "mysql:host=$host;dbname=$dbname"; // will use later
$options    = array(
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
              );

