<?php 

require '../layouts/header.php'; 

if(isset($_POST['submit'])) {
   $id      = uuid();
   $nama    = $_POST['nama'];
   $telepon = $_POST['telepon'];
   $email   = $_POST['email'];
   $website = $_POST['website'];
   $alamat  = $_POST['alamat'];

   $query = mysqli_query($conn, "INSERT INTO penerbit VALUES ('$id', '$nama', '$telepon', '$email', '$alamat', '$website', CURRENT_TIMESTAMP)");

   if($query) {
      echo '<script>alert("Data berhasil ditambahkan!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/penerbit/tambah.php"</script>';
   } else {
      echo '<script>alert("Data gagal ditambahkan!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/penerbit/tambah.php"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Tambah Penerbit</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/penerbit'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="form-group">
                  <label>Nama :</label>
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" minlength="5" required>
               </div>
               <div class="form-group">
                  <label>Telepon :</label>
                  <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Masukan telepon" minlength="11" maxlength="12" required>
               </div>
               <div class="form-group">
                  <label>Email :</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" required>
               </div>
               <div class="form-group">
                  <label>Website :</label>
                  <input type="url" name="website" id="website" class="form-control" placeholder="Masukan url website">
               </div>
               <div class="form-group">
                  <label>Alamat :</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat lengkap" style="resize:none;" minlength="10"></textarea>
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