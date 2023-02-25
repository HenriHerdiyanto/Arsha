<?php
include "../koneksi.php";


session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$result = mysqli_query($koneksi, "SELECT * FROM users ");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin | mytax</title>
    <link href="../assets/img/logo png.png" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/4.9.95/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto&display=swap" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/sidebar.css" />
</head>

<body>
    <!-- <div class="container-logout">
        <form action="" method="POST" class="login-email">

            <?php echo "<h1>Selamat Datang, " . $_SESSION['username'] . "!" . "</h1>"; ?>

            <div class="input-group">
                <a href="../logout.php" class="btn">Logout</a>
            </div>
        </form>
    </div> -->
    <aside class="sidebar">
        <nav>
            <ul class="sidebar__nav">
                <li>
                    <a href="index.php" class="sidebar__nav__link">
                        <i class="fa-solid fa-user"></i>
                        <span class="sidebar__nav__text">User</span>
                    </a>
                </li>
                <li>
                    <a href="berita/berita.php" class="sidebar__nav__link">
                        <i class="fa-sharp fa-solid fa-newspaper"></i>
                        <span class="sidebar__nav__text">Tambah Berita</span>
                    </a>
                </li>
                <li>
                    <a href="service/sevice.php" class="sidebar__nav__link">
                        <i class="fa-solid fa-file"></i>
                        <span class="sidebar__nav__text">Tambah Tax Service</span>
                    </a>
                </li>
                <li>
                    <a href="legal/index.php" class="sidebar__nav__link">
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
    <div style="padding-left: 5%;" class="container" style="z-index: 1;">
        <?php echo "<h4 class='pt-5'>Selamat Datang, " . $_SESSION['username'] . "!" . "</h4>"; ?>
        <a class="btn btn-success" href="../register.php">Tambah User Baru</a><br /><br />
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-striped table-hover ">

                        <tr bgcolor='#CCCCCC'>
                            <td>Nama User</td>
                            <td>Email</td>
                            <td>Password</td>
                            <td>Aktion</td>
                        </tr>
                        <?php

                        while ($res = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td >" . $res['username'] . "</td>";
                            echo "<td>" . $res['email'] . "</td>";
                            echo "<td>" . $res['password'] . "</td>";
                            echo "<td><a style='width: 72px;' class='btn btn-warning' href=\"edit.php?id=$res[id]\">Edit</a>  <a class='btn btn-danger' href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Kamu yakin untuk delete ini?')\">Delete</a></td>";
                        }
                        ?>
                    </table>

                </div>
            </div>
        </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>

</body>