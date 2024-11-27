<?php

$hostname = "localhost";
$username = "root";
$password = "devola3465";
$database = "db_bahrululum";

$db = mysqli_connect($hostname, $username, $password, $database);

if ($db->connect_error){
    echo "Koneksi database rusak";
    die("Error!");
}

date_default_timezone_set("Asia/Jakarta");
?>