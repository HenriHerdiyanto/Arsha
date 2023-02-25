<?php
// INCLUDE KONEKSI KE DATABASE
include_once("../../koneksi.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['update'])) {

    // AMBIL ID DATA
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);

    // AMBIL NAMA FILE FOTO SEBELUMNYA
    $data = mysqli_query($koneksi, "SELECT gambar FROM layanan WHERE id='$id'");
    $dataImage = mysqli_fetch_assoc($data);
    $oldImage = $dataImage['gambar'];

    // AMBIL DATA DATA DIDALAM INPUT
    $kode = mysqli_real_escape_string($koneksi, $_POST['kode']);
    $keterangan = mysqli_real_escape_string($koneksi, $_POST['keterangan']);
    $jasa = mysqli_real_escape_string($koneksi, $_POST['jasa']);
    $produk = mysqli_real_escape_string($koneksi, $_POST['produk']);
    $harga = mysqli_real_escape_string($koneksi, $_POST['harga']);
    $filename = $_FILES['newImage']['name'];

    // CEK DATA TIDAK BOLEH KOSONG
    if (
        empty($kode) || empty($keterangan) || empty($jasa) || empty($produk) || empty($harga) || empty($filename)
    ) {

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

        // JIKA FOTO DI GANTI
        if (!empty($filename)) {
            $filetmpname = $_FILES['newImage']['tmp_name'];
            $folder = "image/";

            // GAMBAR LAMA DI DELETE
            unlink($folder . $oldImage) or die("GAGAL");

            // GAMBAR BARU DI MASUKAN KE FOLDER
            move_uploaded_file($filetmpname, $folder . $filename);

            // NAMA FILE FOTO + DATA YANG DI GANTIBARU DIMASUKAN
            $result = mysqli_query($koneksi, "UPDATE layanan SET kode='$kode',keterangan='$keterangan',jasa='$jasa',produk='$produk',harga='$harga',gambar='$filename' WHERE id=$id");
        }

        // MEMASUKAN DATA YANG DI UPDATE KECUALI GAMBAR
        $result = mysqli_query($koneksi, "UPDATE layanan SET kode='$kode',keterangan='$keterangan',jasa='$jasa',produk='$produk',harga='$harga' WHERE id=$id");

        // REDIRECT KE HALAMAN INDEX.PHP
        echo "<script>alert('Data berhasil di update.');window.location='sevice.php';</script>";
    }
}
?>
<?php
// AMBIL ID DARI URL
$id = $_GET['id'];

// AMBIL DATA BERDASARKAN ID
$result = mysqli_query($koneksi, "SELECT * FROM layanan WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
    $kode = $res['kode'];
    $keterangan = $res['keterangan'];
    $jasa = $res['jasa'];
    $produk = $res['produk'];
    $harga = $res['harga'];
    $image = $res['gambar'];
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
    <div class="container">
        <?php echo "<h4 class='pt-5'>Selamat Datang, " . $_SESSION['username'] . "!" . "</h4>"; ?>
        <form name="form1" method="post" action="edit.php" enctype="multipart/form-data">
            <table class="table table-bordered table-hover" border="0">
                <tr>
                    <td>Kode</td>
                    <td><input class="form-control" type="text" name="kode" value="<?php echo $kode; ?>"></td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td><input class="form-control" type="text" name="keterangan" value="<?php echo $keterangan; ?>"></td>
                </tr>
                <tr>
                    <td>Jasa Terdiri Dari</td>
                    <td><textarea name="jasa" id="jasa"><?php echo $jasa; ?></textarea></td>
                </tr>
                <tr>
                    <td>Produk</td>
                    <td><input class="form-control" type="text" name="produk" value="<?php echo $produk; ?>"></td>
                </tr>
                <tr>
                    <td>Harga</td>
                    <td><input class="form-control" type="text" name="harga" value="<?php echo $harga; ?>"></td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><img width="100" src="image/<?php echo $image ?>"><br><br><input type="file" name="newImage"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value=<?php echo $_GET['id']; ?>></td>
                    <td><input class="btn btn-success" type="submit" name="update" value="Update"></td>
                </tr>
            </table>
        </form>
    </div>

    <!-- script ck editor -->
    <script src="https://cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('jasa');
    </script>
</body>

</html>