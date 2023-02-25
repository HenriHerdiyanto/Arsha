<?php
include "../../koneksi.php";

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
$result = mysqli_query($koneksi, "SELECT * FROM legal");



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
                    <a href="../service/sevice.php" class="sidebar__nav__link">
                        <i class="fa-solid fa-file"></i>
                        <span class="sidebar__nav__text">Tambah Tax Service</span>
                    </a>
                </li>
                <li>
                    <a href="#" class="sidebar__nav__link">
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
        <?php echo "<h4 class='pt-5'>Selamat Datang, " . $_SESSION['username'] . "!" . "</h4>"; ?>
        <!-- <a class="btn btn-success" href="add_berita.php">Tambah Berita Baru</a><br /><br /> -->
        <!-- Button trigger modal -->


    </div>
    <div style="padding-left: 5%;" class="container">
        <div class="row" style="z-index: 0;">
            <div class="col-lg-6">
                <a class="btn btn-success" href="tambah.php">Tambah Berita Baru</a>
            </div>
            <div align="end" class="col-lg-6">
                <small class="text-muted">*Untuk menampilkan semua data biarkan kosong lalu Enter</small>
                <form action="" method="get">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Apa yang anda cari" name="cari" autofocus>
                        <button class="btn btn-outline-secondary" type="submit" id="button">Cari</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <tr>
                    <th>No</th>
                    <td>KODE</td>
                    <td>Nama</td>
                    <td>Keterangan</td>
                    <td>Jasa Terdiri Dari</td>
                    <td>Produk yang dihasilkan</td>
                    <td>Harga + Durasi</td>
                    <td>Gambar</td>
                    <td>Action</td>
                </tr>
                <!-- "SELECT * FROM berita WHERE judul LIKE '%$cari%' OR deskripsi LIKE '%$cari%' OR kategori LIKE '%$cari%'"; -->
                <?php
                if (isset($_GET['cari'])) {
                    $cari = $_GET['cari'];
                    $data = mysqli_query($koneksi, "SELECT * FROM legal WHERE kode LIKE '%$cari%' OR nama LIKE '%$cari%' OR keterangan LIKE '%$cari%' OR jasa LIKE '%$cari%' OR produk LIKE '%$cari%' OR harga LIKE '%$cari%'");
                } else {
                    $data = mysqli_query($koneksi, "select * from legal");
                }
                $no = 1;
                while ($d = mysqli_fetch_array($data)) {
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $d['kode']; ?></td>
                        <td><?php echo $d['nama']; ?></td>
                        <td align="justify"><?php echo $d['keterangan']; ?></td>
                        <td><?php echo $d['jasa']; ?></td>
                        <td><?php echo $d['produk']; ?></td>
                        <td><?php echo $d['harga']; ?></td>
                        <td><img src="image/<?php echo $d['gambar']; ?>" width="100px" height="100px"></td>
                        <?php echo "<td><a style='width: 72px;' class='btn btn-warning text-white' href=\"edit.php?id=$d[id]\">Edit</a>  
                    <a  class='btn btn-danger mt-2' href=\"delete.php?id=$d[id]\" onClick=\"return confirm('Kamu yakin untuk delete ini?')\">Delete</a></td>" ?>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>

    <!-- <table id="tabel" class="table table-striped table-hover" width='80%' border=0>

            <tr bgcolor='#CCCCCC'>
                <td>Judul Berita</td>
                <td>Deskripsi Berita</td>
                <td>Kategori Berita</td>
                <td>Gambar</td>
                <td>Action</td>
            </tr>
            <?php

            // while ($res = mysqli_fetch_assoc($result)) {
            //     echo "<tr>";
            //     echo "<td>" . $res['judul'] . "</td>";
            //     echo "<td>" . $res['deskripsi'] . "</td>";
            //     echo "<td>" . $res['kategori'] . "</td>";
            //     echo "<td><img width='100' src='image/" . $res['gambar'] . "'</td>";
            //     echo "<td><a style='width: 72px;' class='btn btn-warning text-white' href=\"edit.php?id=$res[id]\">Edit</a>  <a class='btn btn-danger' href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Kamu yakin untuk delete ini?')\">Delete</a></td>";
            // }
            // 
            ?>
        </table> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


    <!-- script ck editor -->
    <script src="https://cdn.ckeditor.com/4.20.1/basic/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('jasa');
    </script>

</body>