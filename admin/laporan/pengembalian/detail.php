<?php 

require '../../layouts/header.php'; 

$id           = $_GET['id'];
$paid         = 0;
$pengembalian = mysqli_fetch_assoc(mysqli_query($conn, "SELECT peminjaman.*, user.nama FROM peminjaman JOIN user ON user.id = peminjaman.user_id WHERE peminjaman.status IN ('ditolak', 'selesai') AND peminjaman.id = '$id'"));

$pengembalian_detail = mysqli_query($conn, "SELECT peminjaman_detail.id, peminjaman_detail.denda_terlambat, peminjaman_detail.denda_lainnya, peminjaman_detail.status, koleksi.judul FROM peminjaman_detail JOIN koleksi_stok ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode JOIN koleksi ON koleksi.id = koleksi_stok.koleksi_id JOIN penerbit ON penerbit.id = koleksi.penerbit_id WHERE peminjaman_detail.peminjaman_id = '$id' GROUP BY peminjaman_detail.id");

if(!isset($id) || !$pengembalian) {
   echo '<script>alert("Data tidak ditemukan!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/laporan/pengembalian"</script>';
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Detail Pengembalian</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Detail
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/laporan/pengembalian'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
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
                           <td>: <?= $pengembalian['kode']; ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">User</td>
                           <td>: <?= $pengembalian['nama']; ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Tanggal Pinjam</td>
                           <td>: <?= date('d M Y', strtotime($pengembalian['tanggal_pinjam'])); ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Tanggal Kembali</td>
                           <td>: 
                              <?= $pengembalian['tanggal_kembali'] ? date('d M Y', strtotime($pengembalian['tanggal_kembali'])) : '-'; ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Jatuh Tempo</td>
                           <td>: 
                              <?= $pengembalian['jatuh_tempo'] ? date('d M Y', strtotime($pengembalian['jatuh_tempo'])) : '-'; ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Perpanjangan</td>
                           <td>: 
                              <?= $pengembalian['perpanjangan'] ? $pengembalian['perpanjangan'] . ' Hari' : 'Tidak'; ?>
                           </td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Status</td>
                           <td>: <?= ucwords($pengembalian['status']); ?></td>
                        </tr>
                        <tr>
                           <td class="align-middle" width="15%">Pengembalian</td>
                           <td>: 
                              <?php 
                                 if($pengembalian['tanggal_kembali'] && $pengembalian['jatuh_tempo']) {
                                    if($pengembalian['perpanjangan'] > 0) {
                                       $perpanjangan        = '+' . $pengembalian['perpanjangan'] . ' days';
                                       $tanggal_jatuh_tempo = date('Y-m-d', strtotime($perpanjangan, strtotime($pengembalian['jatuh_tempo'])));
                                    } else {
                                       $tanggal_jatuh_tempo = $pengembalian['jatuh_tempo'];
                                    }

                                    $back_date = strtotime($pengembalian['tanggal_kembali']);
                                    $deadline  = strtotime($tanggal_jatuh_tempo);

                                    if($back_date == $deadline) {
                                       echo '<small class="text-primary font-italic font-weight-bold">Tepat waktu</small>';
                                    } else if($back_date < $deadline) {
                                       echo '<small class="text-success font-italic font-weight-bold">Sebelum jatuh tempo</small>';
                                    } else {
                                       $tanggal_kembali = date_create($pengembalian['tanggal_kembali']);
                                       $jatuh_tempo     = date_create($tanggal_jatuh_tempo);
                                       $selisih         = date_diff($jatuh_tempo, $tanggal_kembali);
                                       
                                       echo '<small class="text-danger font-italic font-weight-bold">Terlambat ' . $selisih->days . ' hari</small>'; 
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
                        <?php while($row = mysqli_fetch_assoc($pengembalian_detail)) { ?>
                           <?php $paid += $row['denda_terlambat'] + $row['denda_lainnya']; ?>
                           <tr class="text-center">
                              <td class="align-middle">
                                 <?= $row['judul']; ?>
                              </td>
                              <td class="align-middle">
                                 Rp <?= number_format($row['denda_terlambat']); ?>
                              </td>
                              <td class="align-middle">
                                 Rp <?= number_format($row['denda_lainnya']); ?>
                              </td>
                              <td class="align-middle">
                                 <?= ucwords($row['status']); ?>
                              </td>
                           </tr>
                        <?php } ?>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th class="text-right align-middle text-uppercase" colspan="2" style="font-size:13px;">
                              Denda yang harus dibayar
                           </th>
                           <th class="align-middle font-weight-bold text-danger" colspan="2" style="font-size:25px;">
                              Rp <?= number_format($paid); ?>
                           </th>
                        </tr>
                     </tfoot>
                  </table>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php require '../../layouts/footer.php'; ?>