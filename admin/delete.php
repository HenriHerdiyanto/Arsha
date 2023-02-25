<?php
// INCLUDE KONEKSI KE DATABASE
include("../koneksi.php");

// AMBIL DATA ID DI URL
$id = $_GET['id'];


// DELETE DATA DARI TABLE
$result = mysqli_query($koneksi, "DELETE FROM users WHERE id=$id");

// REDIRECT KE index.php
header("Location:index.php");
