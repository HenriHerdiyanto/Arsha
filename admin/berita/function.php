<?php

function query($query)
{
    global $koneksi;
    $result = mysqli_query($koneksi, $query);
    $rows = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}
function cari($keyword)
{
    $query = "SELECT * FROM berita WHERE judul = '$keyword'";
    return query($query);
}
