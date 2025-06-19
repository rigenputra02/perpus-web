<?php 

require '../../connection.php';

$id       = $_GET['id'];
$password = password_hash('perpustakaan', PASSWORD_DEFAULT);
$query    = mysqli_query($conn, "UPDATE user SET password = '$password' WHERE id = '$id'");

if($query) {
   echo '<script>alert("Password telah direset!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/user"</script>';
} else {
   echo '<script>alert("Password gagal direset!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/user"</script>';
}