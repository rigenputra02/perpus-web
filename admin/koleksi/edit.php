<?php 

require '../layouts/header.php'; 

$id             = $_GET['id'];
$jenis          = mysqli_query($conn, "SELECT * FROM jenis");
$penerbit       = mysqli_query($conn, "SELECT * FROM penerbit");
$daftar_pustaka = mysqli_query($conn, "SELECT * FROM koleksi_pustaka WHERE koleksi_id = '$id' ORDER BY konten ASC");
$stok           = mysqli_query($conn, "SELECT * FROM koleksi_stok WHERE koleksi_id = '$id'");
$koleksi        = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM koleksi WHERE id = '$id'"));

if(!isset($id) || !$koleksi) {
   echo '<script>alert("Data tidak ditemukan!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/koleksi"</script>';
}

if(isset($_POST['submit'])) {
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

   if(isset($cover['name'])) {
      $cover_name = $cover['name'];
   } else {
      $cover_name = $koleksi['cover'];
   }

   $query = mysqli_query($conn, "UPDATE koleksi SET penerbit_id = '$penerbit_id', cover = '$cover_name', judul = '$judul', isbn = '$isbn', jenis_id = '$jenis_id', pengarang = '$pengarang', stok = $stok, nomor_rak = '$nomor_rak', total_halaman = $total_halaman, tahun_terbit = '$tahun_terbit', keterangan = '$keterangan' WHERE id = '$id'");

   if($query) {
      if(isset($cover['name'])) {
         move_uploaded_file($cover['tmp_name'], '../../archive/' . $cover_name);
      }

      mysqli_query($conn, "DELETE FROM koleksi_stok WHERE koleksi_id = '$id'");
      for($i = 1; $i <= $stok; $i++) {
         $koleksi_stok_id = uuid();
         $kode            = strtoupper(preg_replace('/[^a-zA-Z0-9]/', '', substr($judul, 0, 3))) . '-' . sprintf('%04s', $i);
         mysqli_query($conn, "INSERT INTO koleksi_stok VALUES ('$koleksi_stok_id', '$id', '$kode')");
      }

      echo '<script>alert("Data berhasil diubah!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/koleksi"</script>';
   } else {
      echo '<script>alert("Data gagal diubah!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Edit Koleksi</h1>
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
                  <center>
                     <?php 
                        if(isset($koleksi['cover'])) {
                           $cover = $base_url . '/archive/' . $koleksi['cover'];
                        } else {
                           $cover = $base_url . '/archive/empty.jpg';
                        }
                     ?>
                     <img src="<?= $cover; ?>" width="200" alt="">
                  </center>
               </div>
               <div class="form-group">
                  <label>Cover :</label>
                  <input type="file" name="cover" id="cover" class="form-control" accept="image/gif,image/jpeg,image/jpg,image/png" data-max-size="1000000">
               </div>
               <div class="form-group">
                  <label>Judul :</label>
                  <textarea name="judul" id="judul" class="form-control" placeholder="Masukan judul" style="resize:none;" minlength="10" required><?= $koleksi['judul']; ?></textarea>
               </div>
               <div class="form-group">
                  <label>Penerbit :</label>
                  <select name="penerbit_id" id="penerbit_id" class="custom-select" required>
                     <option value="">-- Pilih --</option>
                     <?php while($row = mysqli_fetch_assoc($penerbit)) { ?>
                        <option value="<?= $row['id']; ?>" <?= $koleksi['penerbit_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['nama']; ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>ISBN :</label>
                        <input type="text" name="isbn" id="isbn" class="form-control" value="<?= $koleksi['isbn']; ?>" placeholder="Masukan no ISBN">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Jenis :</label>
                        <select name="jenis_id" id="jenis_id" class="custom-select" required>
                           <option value="">-- Pilih --</option>
                           <?php while($row = mysqli_fetch_assoc($jenis)) { ?>
                              <option value="<?= $row['id'] ?>" <?= $koleksi['jenis_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['nama'] ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Stok :</label>
                        <input type="number" name="stok" id="stok" class="form-control" value="<?= $koleksi['stok']; ?>" placeholder="Masukan jumlah stok">
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Tahun Terbit :</label>
                        <input type="number" name="tahun_terbit" id="tahun_terbit" class="form-control" min="1990" max="<?= date('Y') ?>" placeholder="<?= date('Y') ?>" value="<?= $koleksi['tahun_terbit']; ?>" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Nomor Rak :</label>
                        <input type="text" name="nomor_rak" id="nomor_rak" class="form-control" placeholder="Masukan nomor rak" value="<?= $koleksi['nomor_rak']; ?>" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Total Halaman :</label>
                        <input type="number" name="total_halaman" id="total_halaman" class="form-control" placeholder="0" value="<?= $koleksi['total_halaman']; ?>" required>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Pengarang :</label>
                  <textarea name="pengarang" id="pengarang" class="form-control" placeholder="Masukan pengarang" style="resize:none;"><?= $koleksi['pengarang']; ?></textarea>
               </div>
               <div class="form-group">
                  <label>Keterangan :</label>
                  <textarea name="keterangan" id="keterangan" class="form-control" placeholder="Masukan keterangan" style="resize:none;"><?= $koleksi['keterangan']; ?></textarea>
               </div>
               <div class="form-group"><hr></div>
               <div class="text-right">
                  <div class="form-group">
                     <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Submit Data</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>

<?php require '../layouts/footer.php'; ?>