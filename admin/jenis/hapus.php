<?php 

require '../../connection.php';

$id    = $_GET['id'];
$query = mysqli_query($conn, "DELETE FROM jenis WHERE id = '$id'");

if($query) {
   echo '<script>alert("Data berhasil dihapus!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/jenis"</script>';
} else {
   echo '<script>alert("Data gagal dihapus!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/jenis"</script>';
}