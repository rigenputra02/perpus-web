<?php 

require '../../layouts/header.php'; 

$id         = $_GET['id'];
$peminjaman = mysqli_fetch_assoc(mysqli_query($conn, "SELECT peminjaman.*, user.nama FROM peminjaman JOIN user ON user.id = peminjaman.user_id WHERE peminjaman.status IN ('pengajuan', 'dipinjam') AND peminjaman.id = '$id'"));

$peminjaman_detail = mysqli_query($conn, "SELECT peminjaman_detail.id, peminjaman_detail.denda_terlambat, peminjaman_detail.denda_lainnya, peminjaman_detail.status, koleksi.judul
FROM peminjaman_detail
JOIN koleksi_stok ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode
JOIN koleksi ON koleksi.id = koleksi_stok.koleksi_id
JOIN penerbit ON penerbit.id = koleksi.penerbit_id
WHERE peminjaman_detail.peminjaman_id = '$id'");


if(!isset($id) || !$peminjaman) {
   echo '<script>alert("Data tidak ditemukan!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/laporan/peminjaman"</script>';
}

if(isset($_POST['submit'])) {
   $perpanjangan = isset($_POST['perpanjangan']) ? $_POST['perpanjangan'] : $peminjaman['perpanjangan'];
   $due_date     = isset($_POST['jatuh_tempo']) ? $_POST['jatuh_tempo'] : $peminjaman['jatuh_tempo'];
   $status       = $_POST['status'];

   if($status == 'selesai') {
      $back_date = date('Y-m-d');
      $query     = mysqli_query($conn, "UPDATE peminjaman SET jatuh_tempo = '$due_date', perpanjangan = $perpanjangan, tanggal_kembali = '$back_date', status = '$status' WHERE id = '$id'");
   } else {
      $query = mysqli_query($conn, "UPDATE peminjaman SET jatuh_tempo = '$due_date', perpanjangan = $perpanjangan, status = '$status' WHERE id = '$id'");
   }

   if($query) {
      if($status == 'dipinjam' OR $status == 'selesai') {
         foreach($_POST['detail_peminjaman_detail_id'] as $key => $dpdi) {
            $late_fine  = $_POST['detail_denda_terlambat'][$key];
            $other_fine = isset($_POST['detail_denda_lainnya'][$key]) ? $_POST['detail_denda_lainnya'][$key] : 0;
            $status     = $_POST['detail_status'][$key];

            if(!empty($status) && $status != 'tolak') {
               mysqli_query($conn, "UPDATE peminjaman_detail SET denda_terlambat = $late_fine, denda_lainnya = $other_fine, status = '$status' WHERE id = '$dpdi'");
            }
         }
      } else if($status == 'ditolak') {
         mysqli_query($conn, "UPDATE peminjaman_detail SET denda_terlambat = 0, denda_lainnya = 0, status = 'tolak' WHERE peminjaman_id = '$id'");
      }

      echo '<script>alert("Data berhasil diubah!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/laporan/peminjaman"</script>';
   } else {
      echo '<script>alert("Data gagal diubah!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Detail Peminjaman</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Detail
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/laporan/peminjaman'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="form-group">
                  <div class="form-group">
                     <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Data</h5>
                  </div>
                  <table cellspacing="0" cellpadding="10" width="100%">
                     <tbody>
                        <tr>
                           <td class="align-middle" width="15%">Kode</td>
                           <td>: <?= $peminjaman['kode']; ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">User</td>
                           <td>: <?= $peminjaman['nama']; ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Tanggal Pinjam</td>
                           <td>: <?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])); ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Jatuh Tempo</td>
                           <td>: 
                              <?php if($peminjaman['status'] == 'pengajuan') { ?>
                                 <input type="date" name="jatuh_tempo" id="jatuh_tempo" min="<?= date('Y-m-d', strtotime($peminjaman['tanggal_pinjam'])); ?>" value="<?= $peminjaman['jatuh_tempo']; ?>">
                              <?php } else { ?>
                                 <?= date('d F Y', strtotime($peminjaman['jatuh_tempo'])); ?>
                              <?php } ?>
                           </td>
                        </tr>
                         <tr>
                           <td class="align-middle" width="15%">Perpanjangan</td>
                           <td>: 
                              <?php if($peminjaman['perpanjangan']) { ?>
                                 <?= $peminjaman['perpanjangan']; ?> <small>Hari</small>
                              <?php } else { ?>
                                 <input type="number" name="perpanjangan" id="perpanjangan" value="<?= ($peminjaman['perpanjangan']) ? $peminjaman['perpanjangan'] : 0; ?>"> <small>Hari</small>
                              <?php } ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Status</td>
                           <td>: 
                              <select name="status" id="status">
                                 <option value="">-- Pilih --</option>
                                 <option value="pengajuan" <?= $peminjaman['status'] == 'pengajuan' ? 'selected' : '' ?>>Pengajuan</option>
                                 <option value="dipinjam" <?= $peminjaman['status'] == 'dipinjam' ? 'selected' : '' ?>>Dipinjam</option>
                                 <option value="ditolak" <?= $peminjaman['status'] == 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                 <option value="selesai" <?= $peminjaman['status'] == 'selesai' ? 'selected' : '' ?>>Selesai</option>
                              </select>
                           </td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Pengembalian</td>
                           <td>: 
                              <?php 
                                 if($peminjaman['status'] != 'ditolak' AND $peminjaman['status'] != 'pengajuan') {
                                    if($peminjaman['jatuh_tempo']) {
                                       if($peminjaman['perpanjangan'] > 0) {
                                          $perpanjangan        = '+' . $peminjaman['perpanjangan'] . ' days';
                                          $tanggal_jatuh_tempo = date('Y-m-d', strtotime($perpanjangan, strtotime($peminjaman['jatuh_tempo'])));
                                       } else {
                                          $tanggal_jatuh_tempo = $peminjaman['jatuh_tempo'];
                                       }

                                       $tanggal_sekarang = date('Y-m-d');
                                       $sekarang         = date_create($tanggal_sekarang);
                                       $jatuh_tempo      = date_create($tanggal_jatuh_tempo);
                                       $selisih          = date_diff($jatuh_tempo, $sekarang);
                                       
                                       if($tanggal_sekarang > $tanggal_jatuh_tempo) {
                                          echo 'Terlambat ' . $selisih->days . ' hari';
                                       } else if($tanggal_sekarang == $tanggal_jatuh_tempo) {
                                          echo 'Hari ini';
                                       } else {
                                          echo $selisih->days . ' hari lagi';
                                       }
                                    } else {
                                       echo 'Jatuh tempo belum ditentukan';
                                    }
                                 } else {
                                    echo '-';
                                 }
                              ?>
                           </td>
                        </tr>
                     </tbody>
                  </table>
               </div>
               <div class="form-group"><hr></div>
               <div class="form-group">
                  <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Koleksi Yang Dipinjam</h5>
               </div>
               <div class="form-group">
                  <table class="table table-bordered table-striped">
                     <thead>
                        <tr class="text-center">
                           <th>Koleksi</th>
                           <th>Denda Keterlambatan</th>
                           <th>Denda Lainnya</th>
                           <th>Status</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php while($row = mysqli_fetch_assoc($peminjaman_detail)) { ?>
                           <tr class="text-center">
                              <td class="align-middle">
                                 <input type="hidden" name="detail_peminjaman_detail_id[]" value="<?= $row['id']; ?>">
                                 <?= $row['judul']; ?>
                              </td>
                              <td class="align-middle">
                                 <?php 
                                    if($peminjaman['jatuh_tempo']) {
                                       if($peminjaman['perpanjangan'] > 0) {
                                          $perpanjangan        = '+' . $peminjaman['perpanjangan'] . ' days';
                                          $tanggal_jatuh_tempo = date('Y-m-d', strtotime($perpanjangan, strtotime($peminjaman['jatuh_tempo'])));
                                       } else {
                                          $tanggal_jatuh_tempo = $peminjaman['jatuh_tempo'];
                                       }

                                       $tanggal_sekarang = date('Y-m-d');
                                       $sekarang         = date_create($tanggal_sekarang);
                                       $jatuh_tempo      = date_create($tanggal_jatuh_tempo);
                                       $selisih          = date_diff($jatuh_tempo, $sekarang);
                                       
                                       if($tanggal_sekarang > $tanggal_jatuh_tempo) {
                                          $denda = 5000 * $selisih->days;
                                       } else if($tanggal_sekarang == $tanggal_jatuh_tempo) {
                                          $denda = 0;
                                       } else {
                                          $denda = 0;
                                       }
                                    } else {
                                       $denda = 0;
                                    }
                                 ?>
                                 <input type="hidden" name="detail_denda_terlambat[]" value="<?= $denda; ?>">
                                 Rp <?= number_format($denda); ?>
                              </td>
                              <td class="align-middle">
                                 <input type="number" name="detail_denda_lainnya[]" id="detail_denda_lainnya" class="form-control" placeholder="0" value="<?= $row['denda_lainnya']; ?>">
                              </td>
                              <td class="align-middle">
                                 <select name="detail_status[]" id="detail_status" class="custom-select">
                                    <option value="">-- Pilih --</option>
                                    <option value="tolak" <?= $row['status'] == 'tolak' ? 'selected' : '' ?>>Tolak</option>
                                    <option value="pinjam" <?= $row['status'] == 'pinjam' ? 'selected' : '' ?>>Pinjam</option>
                                    <option value="hilang" <?= $row['status'] == 'hilang' ? 'selected' : '' ?>>Hilang</option>
                                    <option value="rusak" <?= $row['status'] == 'rusak' ? 'selected' : '' ?>>Rusak</option>
                                    <option value="lengkap" <?= $row['status'] == 'lengkap' ? 'selected' : '' ?>>Lengkap</option>
                                 </select>
                              </td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
               <div class="form-group"><hr></div>
               <div class="form-group">
                  <div class="text-right">
                     <button type="submit" name="submit" class="btn btn-success">Submit Data</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php require '../../layouts/footer.php'; ?>