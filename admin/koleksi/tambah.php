<?php 

require '../layouts/header.php'; 

$jenis    = mysqli_query($conn, "SELECT * FROM jenis");
$penerbit = mysqli_query($conn, "SELECT * FROM penerbit");

if(isset($_POST['submit'])) {
   $id            = uuid();
   $penerbit_id   = $_POST['penerbit_id'];
   $judul         = $_POST['judul'];
   $isbn          = $_POST['isbn'];
   $jenis_id      = $_POST['jenis_id'];
   $pengarang     = $_POST['pengarang'];
   $stok          = $_POST['stok'];
   $nomor_rak     = $_POST['nomor_rak'];
   $total_halaman = $_POST['total_halaman'];
   $tahun_terbit  = $_POST['tahun_terbit'];
   $keterangan    = $_POST['keterangan'];
   $cover         = $_FILES['cover'];
   $cover_name    = $cover['name'];

   $query = mysqli_query($conn, "INSERT INTO koleksi VALUES ('$id', '$penerbit_id', '$cover_name', '$judul', '$isbn', '$jenis_id', '$pengarang', $stok, '$nomor_rak', $total_halaman, '$tahun_terbit', '$keterangan', CURRENT_TIMESTAMP)");

   if($query) {
      move_uploaded_file($cover['tmp_name'], '../../archive/' . $cover_name);
      for($i = 1; $i <= $stok; $i++) {
         $koleksi_stok_id = uuid();
         $kode            = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', substr($judul, 0, 3))) . '-' . sprintf('%04s', $i);
         mysqli_query($conn, "INSERT INTO koleksi_stok VALUES ('$koleksi_stok_id', '$id', '$kode')");
      }

      echo '<script>alert("Data berhasil ditambahkan!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
   } else {
      echo '<script>alert("Data gagal ditambahkan!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Tambah Koleksi</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/koleksi'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
               <div class="form-group">
                  <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Meta Data</h5>
               </div>
               <div class="form-group">
                  <label>Cover :</label>
                  <input type="file" name="cover" id="cover" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png" data-max-size="1000000" required>
               </div>
               <div class="form-group">
                  <label>Judul :</label>
                  <textarea name="judul" id="judul" class="form-control" placeholder="Masukan judul" style="resize:none;" minlength="10" required></textarea>
               </div>
               <div class="form-group">
                  <label>Penerbit :</label>
                  <select name="penerbit_id" id="penerbit_id" class="custom-select" required>
                     <option value="">-- Pilih --</option>
                     <?php while($row = mysqli_fetch_assoc($penerbit)) { ?>
                        <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>ISBN :</label>
                        <input type="text" name="isbn" id="isbn" class="form-control" placeholder="Masukan no ISBN">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Jenis :</label>
                        <select name="jenis_id" id="jenis_id" class="custom-select" required>
                           <option value="">-- Pilih --</option>
                           <?php while($row = mysqli_fetch_assoc($jenis)) { ?>
                              <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Stok :</label>
                        <input type="number" name="stok" id="stok" class="form-control" placeholder="Masukan jumlah stok">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Tahun Terbit :</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" min="1990" max="<?= date('Y') ?>" placeholder="<?= date('Y') ?>" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Nomor Rak :</label>
                        <input type="text" name="nomor_rak" id="nomor_rak" class="form-control" placeholder="Masukan nomor rak" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Total Halaman :</label>
                        <input type="number" name="total_halaman" id="total_halaman" class="form-control" placeholder="0" required>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Pengarang :</label>
                  <textarea name="pengarang" id="pengarang" class="form-control" placeholder="Masukan pengarang" style="resize:none;"></textarea>
               </div>
               <div class="form-group">
                  <label>Keterangan :</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukan keterangan" style="resize:none;"></textarea>
               </div>
               <div class="form-group"><hr></div>
               <div class="text-right">
                  <div class="form-group">
                     <button type="submit" name="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Submit Data</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php require '../layouts/footer.php'; ?>