<?php 

require 'connection.php';

$data_peminjaman = mysqli_query($conn, "SELECT * FROM peminjaman WHERE status = 'pengajuan'");
while($row = mysqli_fetch_assoc($data_peminjaman)) {
   $tanggal_pinjam = strtotime($row['tanggal_pinjam']);
   $batas_tanggal  = strtotime(date('Y-m-d', strtotime('+1 day', strtotime($row['tanggal_pinjam']))));

   if($tanggal_pinjam > $batas_tanggal) {
      $id = $row['id'];
      mysqli_query($conn, "UPDATE peminjaman SET status = 'ditolak' WHERE id = '$id'");
   }
}

?>