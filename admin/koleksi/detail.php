<?php 

require '../layouts/header.php'; 

$id             = $_GET['id'];
$daftar_pustaka = mysqli_query($conn, "SELECT * FROM koleksi_pustaka WHERE koleksi_id = '$id' ORDER BY konten ASC");
$koleksi        = mysqli_fetch_assoc(mysqli_query($conn, "SELECT koleksi.*, jenis.nama as nama_jenis, penerbit.nama FROM koleksi LEFT JOIN jenis ON jenis.id = koleksi.jenis_id JOIN penerbit ON penerbit.id = koleksi.penerbit_id WHERE koleksi.id = '$id'"));


if(!isset($id) || !$koleksi) {
   echo '<script>alert("Data tidak ditemukan!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/koleksi"</script>';
}

$stock = mysqli_query($conn, "SELECT koleksi_stok.kode, peminjaman_detail.status, user.nama FROM koleksi_stok LEFT JOIN peminjaman_detail ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode LEFT JOIN peminjaman ON peminjaman_detail.peminjaman_id = peminjaman.id LEFT JOIN user ON peminjaman.user_id = user.id WHERE koleksi_stok.koleksi_id = '$id' ORDER BY koleksi_stok.kode ASC");

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Detail Koleksi</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Detail
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/koleksi'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <div class="form-group">
               <div class="form-group">
                  <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Meta Data</h5>
               </div>
               <table cellspacing="0" cellpadding="10" width="100%">
                  <tbody>
                     <tr>
                        <td class="align-middle" width="15%">Judul</td>
                        <td>: <?= $koleksi['judul']; ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Penerbit</td>
                        <td>: <?= $koleksi['nama']; ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">ISBN</td>
                        <td>: <?= $koleksi['isbn']; ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Jenis</td>
                        <td>: <?= ucwords($koleksi['nama_jenis']); ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Nomor Rak</td>
                        <td>: <?= ucwords($koleksi['nomor_rak']); ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Tahun Terbit</td>
                        <td>: <?= $koleksi['tahun_terbit']; ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Total Halaman</td>
                        <td>: <?= ucwords($koleksi['total_halaman']); ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Pengarang</td>
                        <td>: <?= ucwords($koleksi['pengarang']); ?></td>
                     </tr>
                     <tr>
                        <td class="align-middle" width="15%">Dibuat</td>
                        <td>: <?= date('d M Y', strtotime($koleksi['tanggal_entri'])); ?></td>
                     </tr>
                  </tbody>
               </table>
            </div>
            <div class="form-group"><hr></div>
            <div class="form-group">
               <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Sinopsis</h5>
            </div>
            <div class="form-group">
               <p><?= $koleksi['keterangan']; ?></p>
            </div>
            <div class="form-group"><hr></div>
            <div class="form-group">
               <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Stok</h5>
            </div>
            <div class="form-group">
               <?php if(mysqli_num_rows($stock) > 0) { ?>
                  <table id="datatable" class="table table-bordered table-hover">
                     <thead>
                        <tr class="text-center">
                           <th>No</th>
                           <th>Kode</th>
                           <th>Status</th>
                           <th>Nama Peminjam</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php $no = 1; while($row = mysqli_fetch_assoc($stock)) { ?>
                           <tr class="text-center">
                              <td class="align-middle"><?= $no; ?></td>
                              <td class="align-middle"><?= $row['kode']; ?></td>
                              <td class="align-middle"><?= isset($row['status']) ? ucwords($row['status']) : 'Available'; ?></td>
                              <td class="align-middle"><?= isset($row['nama']) ? $row['nama'] : 'Tidak Ada'; ?></td>
                           </tr>
                        <?php $no++; } ?>
                     </tbody>
                  </table>
               <?php } else { ?>
                  <p class="font-italic">Tidak ada stok</p>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
</div>
<?php require '../layouts/footer.php'; ?>