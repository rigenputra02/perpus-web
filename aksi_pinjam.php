<?php 

require 'connection.php';

if(!isset($_SESSION['fo_id'])) {
   header('Location:masuk.php');
}

$koleksi_id   = $_GET['id'];
$user_id      = $_SESSION['fo_id'];
$cek_pinjaman = mysqli_query($conn, "SELECT * FROM koleksi_stok LEFT JOIN peminjaman_detail ON peminjaman_detail.koleksi_stok_kode = koleksi_stok.kode LEFT JOIN peminjaman ON peminjaman.id = peminjaman_detail.peminjaman_id WHERE koleksi_stok.koleksi_id != '$koleksi_id' AND peminjaman.status != 'selesai' AND peminjaman.user_id = '$user_id'");

if(mysqli_num_rows($cek_pinjaman) > 0) {
   echo '<script>alert("Mohon maaf anda telah meminjam buku ini")</script>';
   echo '<script>window.location="koleksi.php"</script>';
} else {
   $_SESSION['koleksi_id'][] = $koleksi_id;
   echo '<script>alert("Koleksi berhasil disimpan didalam sesi peminjaman")</script>';
   echo '<script>window.location="koleksi.php"</script>';
}