<?php
$localhost = "localhost";
$root = "root";
$password = "";
$database = "mytax";
$koneksi = mysqli_connect($localhost, $root, $password, $database);
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}
