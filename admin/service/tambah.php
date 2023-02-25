<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include "../../koneksi.php";

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
if (isset($_POST['Submit'])) {
    $kode = $_POST['kode'];
    $keterangan = $_POST['keterangan'];
    $jasa = $_POST['jasa'];
    $produk = $_POST['produk'];
    $harga = $_POST['harga'];
    $filename = $_FILES['gambar']['name'];

    // CEK DATA TIDAK BOLEH KOSONG
    if (empty($kode) || empty($keterangan) || empty($jasa) || empty($produk) || empty($harga) || empty($filename)) {

        if (empty($kode)) {
            echo "<font color='red'>Kolom kode tidak boleh kosong.</font><br/>";
        }

        if (empty($keterangan)) {
            echo "<font color='red'>Kolom keterangan tidak boleh kosong.</font><br/>";
        }

        if (empty($jasa)) {
            echo "<font color='red'>Kolom jasa tidak boleh kosong.</font><br/>";
        }

        if (empty($produk)) {
            echo "<font color='red'>Kolom produk tidak boleh kosong.</font><br/>";
        }

        if (empty($harga)) {
            echo "<font color='red'>Kolom harga tidak boleh kosong.</font><br/>";
        }

        if (empty($filename)) {
            echo "<font color='red'>Kolom Gambar tidak boleh kosong.</font><br/>";
        }
    } else {
        // JIKA SEMUANYA TIDAK KOSONG
        $filetmpname = $_FILES['gambar']['tmp_name'];

        // FOLDER DIMANA GAMBAR AKAN DI SIMPAN
        $folder = 'image/';
        // GAMBAR DI SIMPAN KE DALAM FOLDER
        move_uploaded_file($filetmpname, $folder . $filename);

        // MEMASUKAN DATA DATA + kode GAMBAR KE DALAM DATABASE
        $result = mysqli_query($koneksi, "INSERT INTO layanan(kode,keterangan,jasa,produk,harga,gambar) VALUES('$kode', '$keterangan', '$jasa','$produk','$harga', '$filename')");

        // MENAMPILKAN PESAN BERHASIL
        echo "<script>alert('Data berhasil disimpan.');window.location='sevice.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | mytax</title>
    <link href="../../assets/img/logo png.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/sidebar.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/dataTables.bootstrap4.min.css">
</head>

<body>
    <aside class="sidebar">
        <nav>
            <ul class="sidebar__nav">
                <li>
                    <a href="../index.php" class="sidebar__nav__link">
                        <i class="fa-solid fa-user"></i>
                        <span class="sidebar__nav__text">User</span>
                    </a>
                </li>
                <li>
                    <a href="../berita/berita.php" class="sidebar__nav__link">
                        <i class="fa-sharp fa-solid fa-newspaper"></i>
                        <span class="sidebar__nav__text">Tambah Berita</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar__nav__link">
                        <i class="fa-solid fa-file"></i>
                        <span class="sidebar__nav__text">Tambah Tax Service</span>
                    </a>
                </li>
                <li>
                    <a href="../legal/index.php" class="sidebar__nav__link">
                        <i class="fa-solid fa-file"></i>
                        <span class="sidebar__nav__text">Tambah Legal Service</span>
                    </a>
                </li>
                <li>
                    <a href="../logout.php" class="sidebar__nav__link">
                        <i class="mdi mdi-logout"></i>
                        <span class="sidebar__nav__text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <div style="padding-left: 5%;" class="container">
        <?php echo "<h1 class='pt-5'>Selamat Datang, " . $_SESSION['username'] . "!" . "</h1>"; ?>
        <form action="" method="post" name="form1" enctype="multipart/form-data">
            <table class="table table-bordered table-hover" width="25%" border="0">
                <tr>
                    <td>kode</td>
                    <td><input class="form-control" type="text" name="kode" /></td>
                </tr>
                <tr>
                    <td>keterangan</td>
                    <td><input class="form-control" type="text" name="keterangan" /></td>
                </tr>
                <tr>
                    <td>Jasa Terdiri Dari</td>
                    <td><textarea name="jasa" id="jasa"></textarea></td>
                </tr>
                <tr>
                    <td>produk</td>
                    <td><input class="form-control" type="text" name="produk" /></td>
                </tr>
                <tr>
                    <td>harga</td>
                    <td><input class="form-control" type="text" name="harga" /></td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><input type="file" name="gambar" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="btn btn-success" type="submit" name="Submit" value="Tambah" /></td>
                </tr>
            </table>
        </form>
    </div>
    <!-- script ck editor -->
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('jasa');
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>

</html>