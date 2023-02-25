<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// INCLUDE KONEKSI KE DATABASE
include_once("../../koneksi.php");

// AMBIL DATA ID DI URL
$id = $_GET['id'];


// DELETE DATA DARI TABLE
$result = mysqli_query($koneksi, "DELETE FROM legal WHERE id=$id");

// REDIRECT KE index.php
echo "<script>alert('Data berhasil dihapus!');window.location='index.php';</script>";
