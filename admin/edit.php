<?php
// INCLUDE KONEKSI KE DATABASE
include_once("../koneksi.php");
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

if (isset($_POST['update'])) {

    // AMBIL ID DATA
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);

    // AMBIL DATA DATA DIDALAM INPUT
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // CEK DATA TIDAK BOLEH KOSONG
    if (empty($username) || empty($email) || empty($password)) {

        if (empty($username)) {
            echo "<font color='red'>Kolom username tidak boleh kosong.</font><br/>";
        }
        if (empty($email)) {
            echo "<font color='red'>Kolom Email tidak boleh kosong.</font><br/>";
        }

        if (empty($password)) {
            echo "<font color='red'>Kolom password tidak boleh kosong.</font><br/>";
        }
    } else {

        // MEMASUKAN DATA YANG DI UPDATE KECUALI GAMBAR
        $result = mysqli_query($koneksi, "UPDATE users SET username='$username',email='$email',password='$password' WHERE id=$id");

        // REDIRECT KE HALAMAN INDEX.PHP
        header("Location: index.php");
    }
}
?>
<?php
// AMBIL ID DARI URL
$id = $_GET['id'];

// AMBIL DATA BERDASARKAN ID
$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
    $username = $res['username'];
    $email = $res['email'];
    $password = $res['password'];
}
?>
<?php
// AMBIL ID DARI URL
$id = $_GET['id'];

// AMBIL DATA BERDASARKAN ID
$result = mysqli_query($koneksi, "SELECT * FROM users WHERE id=$id");

while ($res = mysqli_fetch_array($result)) {
    $username = $res['username'];
    $email = $res['email'];
    $password = $res['password'];
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
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/sidebar.css" />
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
                    <a href="berita.php" class="sidebar__nav__link">
                        <i class="fa-sharp fa-solid fa-newspaper"></i>
                        <span class="sidebar__nav__text">Tambah Berita</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar__nav__link">
                        <i class="mdi mdi-cart"></i>
                        <span class="sidebar__nav__text">Shopping cart</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar__nav__link">
                        <i class="mdi mdi-account-circle"></i>
                        <span class="sidebar__nav__text">Account circle</span>
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
    <br /><br />
    <div class="container">
        <div class="row d-flex justify-content-center">

            <div class="col-lg-8">
                <?php echo "<h4 class='pt-5'>Selamat Datang, " . $_SESSION['username'] . "!" . "</h4>"; ?>
                <div class="card mt-4">
                    <div class="card-header">
                        <h3 class="text-center">Halaman Edit User</h3>
                    </div>
                    <div class="card-body">
                        <form name="form1" method="post" action="edit.php" enctype="multipart/form-data">
                            <center>
                                <table border="0">
                                    <tr>
                                        <td style="padding-right: 30px;"><label>Nama User</label></td>
                                        <td><input class="form-control" type="text" name="username" value="<?php echo $username; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Deskripsi</td>
                                        <td><input style="width:max-content;" class="form-control" type="text" name="email" value="<?php echo $email; ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>password</td>
                                        <td><input class="form-control" type="text" name="password" value="<?php echo $password; ?>"></td>
                                    </tr>
                                    <tr class="mt-4">
                                        <td><input type="hidden" name="id" value=<?php echo $_GET['id']; ?>></td>
                                        <td><input class="btn btn-success" type="submit" name="update" value="Update"></td>
                                    </tr>
                                </table>
                            </center>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>