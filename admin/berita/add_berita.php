<?php

include "../../koneksi.php";

if (isset($_POST['Submit'])) {
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $filename = $_FILES['gambar']['name'];

    // CEK DATA TIDAK BOLEH KOSONG
    if (empty($judul) || empty($deskripsi) || empty($kategori) || empty($filename)) {

        if (empty($judul)) {
            echo "<font color='red'>Kolom judul tidak boleh kosong.</font><br/>";
        }

        if (empty($deskripsi)) {
            echo "<font color='red'>Kolom deskripsi tidak boleh kosong.</font><br/>";
        }

        if (empty($kategori)) {
            echo "<font color='red'>Kolom kategori tidak boleh kosong.</font><br/>";
        }

        if (empty($filename)) {
            echo "<font color='red'>Kolom Gambar tidak boleh kosong.</font><br/>";
        }

        // KEMBALI KE HALAMAN SEBELUMNYA
        echo "<br/><a href='javascript:self.history.back();'>Kembali</a>";
    } else {
        // JIKA SEMUANYA TIDAK KOSONG
        $filetmpname = $_FILES['gambar']['tmp_name'];

        // FOLDER DIMANA GAMBAR AKAN DI SIMPAN
        $folder = 'image/';
        // GAMBAR DI SIMPAN KE DALAM FOLDER
        move_uploaded_file($filetmpname, $folder . $filename);

        // MEMASUKAN DATA DATA + nama GAMBAR KE DALAM DATABASE
        $result = mysqli_query($koneksi, "INSERT INTO berita(judul,deskripsi,kategori,gambar) VALUES('$judul', '$deskripsi', '$kategori', '$filename')");
        echo "<script>window.alert('Data Berhasil Ditambahkan'); window.location.href='berita.php'</script>";
    }
}
