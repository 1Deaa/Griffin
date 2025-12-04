<?php

$DB_HOST = getenv('DB_HOST');
$DB_USER = getenv('DB_USER');
$DB_PASS = getenv('DB_PASS');
$DB_NAME = getenv('DB_NAME');

// $DB_HOST = "griffin-database";
// $DB_USER = "griffinuser";
// $DB_PASS = "griffin123";
// $DB_NAME = "griffindb";

$mysqli = new mysqli($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME);

if ($mysqli->connect_errno)
{
    die("Database connection failed: " . $mysqli->connect_error);
}

?>