<?php 

require '../layouts/header.php'; 

$id       = $_GET['id'];
$penerbit = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM penerbit WHERE id = '$id'"));

if(!isset($id) || !$penerbit) {
   echo '<script>alert("Data tidak ditemukan!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/penerbit"</script>';
}

if(isset($_POST['submit'])) {
   $nama    = $_POST['nama'];
   $telepon = $_POST['telepon'];
   $email   = $_POST['email'];
   $website = $_POST['website'];
   $alamat  = $_POST['alamat'];

   $query = mysqli_query($conn, "UPDATE penerbit SET nama = '$nama', telepon = '$telepon', email = '$email', website = '$website', alamat = '$alamat' WHERE id = '$id'");

   if($query) {
      echo '<script>alert("Data berhasil diubah!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/penerbit"</script>';
   } else {
      echo '<script>alert("Data gagal diubah!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/penerbit/edit.php?id=' . $id . '"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Edit Penerbit</h1>
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
                  <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" value="<?= $penerbit['nama']; ?>" minlength="5" required>
               </div>
               <div class="form-group">
                  <label>Telepon :</label>
                  <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Masukan telepon" value="<?= $penerbit['telepon']; ?>" minlength="11" maxlength="12" required>
               </div>
               <div class="form-group">
                  <label>Email :</label>
                  <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" value="<?= $penerbit['email']; ?>" required>
               </div>
               <div class="form-group">
                  <label>Website :</label>
                  <input type="url" name="website" id="website" class="form-control" placeholder="Masukan url website" value="<?= $penerbit['website']; ?>">
               </div>
               <div class="form-group">
                  <label>Alamat :</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat lengkap" minlength="10" style="resize:none;"><?= $penerbit['alamat']; ?></textarea>
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