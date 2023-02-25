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
    $data = mysqli_query($koneksi, "SELECT gambar FROM berita WHERE id='$id'");
    $dataImage = mysqli_fetch_assoc($data);
    $oldImage = $dataImage['gambar'];

    // AMBIL DATA DATA DIDALAM INPUT
    $judul = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $filename = $_FILES['newImage']['name'];

    // CEK DATA TIDAK BOLEH KOSONG
    if (empty($judul) || empty($deskripsi) || empty($kategori)) {

        if (empty($judul)) {
            echo "<font color='red'>Kolom judul tidak boleh kosong.</font><br/>";
        }

        if (empty($deskripsi)) {
            echo "<font color='red'>Kolom deskripsi tidak boleh kosong.</font><br/>";
        }

        if (empty($kategori)) {
            echo "<font color='red'>Kolom kategori tidak boleh kosong.</font><br/>";
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

            // judul FILE FOTO + DATA YANG DI GANTIBARU DIMASUKAN
            $result = mysqli_query($koneksi, "UPDATE berita SET judul='$judul',deskripsi='$deskripsi',kategori='$kategori',gambar='$filename' WHERE id=$id");
        }

        // MEMASUKAN DATA YANG DI UPDATE KECUALI GAMBAR
        $result = mysqli_query($koneksi, "UPDATE berita SET judul='$judul',deskripsi='$deskripsi',kategori='$kategori' WHERE id=$id");

        // REDIRECT KE HALAMAN INDEX.PHP
        header("Location: berita.php");
    }
}
?>
<?php
// AMBIL ID DARI URL
$id = $_GET['id'];

// AMBIL DATA BERDASARKAN ID
$result = mysqli_query($koneksi, "SELECT * FROM berita WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
    $judul = $res['judul'];
    $deskripsi = $res['deskripsi'];
    $kategori = $res['kategori'];
    $image = $res['gambar'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | mytax</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="stylesheet" href="../css/sidebar.css" />
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
                    <a href="#" class="sidebar__nav__link">
                        <i class="fa-sharp fa-solid fa-newspaper"></i>
                        <span class="sidebar__nav__text">Tambah Berita</span>
                    </a>
                </li>
                <li>
                    <a href="../service/sevice.php" class="sidebar__nav__link">
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
                    <a href="../../logout.php" class="sidebar__nav__link">
                        <i class="mdi mdi-logout"></i>
                        <span class="sidebar__nav__text">Logout</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>
    <div class="container">
        <?php echo "<h4 class='pt-5'>Selamat Datang, " . $_SESSION['username'] . "!" . "</h4>"; ?>
        <br /><br />
        <form name="form1" method="post" action="edit.php" enctype="multipart/form-data">
            <table border="0">
                <tr>
                    <td>Nama</td>
                    <td><input class="form-control" type="text" name="judul" value="<?php echo $judul; ?>"></td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <!-- <td><?php echo '<textarea' . $deskripsi . '</textarea>'; ?></td> -->
                    <td><textarea style="width: 1000px; height:500px;" input type="text" class="form-control" name="deskripsi" value="<?php echo $deskripsi ?>"></textarea></td>
                    <!-- <input style="width: 500px;" class="form-control" type="text" name="deskripsi" value="<?php echo $deskripsi; ?>"> -->
                </tr>
                <!-- <tr>
                    <td>Deskripsi</td>
                    <td><input class="form-control" type="text" name="kategori" value="<?php echo $deskripsi; ?>"></td>
                </tr> -->
                <tr>
                    <th>Kategori Berita</th>
                    <td>
                        <select class="form-control selectpicker" name="kategori">
                            <option value=""> <?php echo $kategori; ?></option>
                            <option value="pajak">Pajak</option>
                            <option value="keuangan">Keuangan</option>
                            <option value="umum">Umum</option>
                            <option value="legal">Legal</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Gambar</td>
                    <td><img width="210" src="image/<?php echo $image ?>"></td><br>
                    <td><input type="file" name="newImage"></td>
                </tr>
                <tr>
                    <td><input type="hidden" name="id" value=<?php echo $_GET['id']; ?>></td>
                    <td><input class="btn btn-success" type="submit" name="update" value="Update"></td>
                </tr>
            </table>
        </form>
    </div>

</body>

</html>