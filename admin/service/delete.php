<?php
include "../../koneksi.php";
session_start();

$id = $_GET['id'];

$result = mysqli_query($koneksi, "DELETE FROM layanan WHERE id=$id");
echo "<script>alert('Data berhasil di hapus');window.location='sevice.php'</script>";
