<?php 

require 'layouts/header.php'; 

$id   = $_SESSION['bo_id'];
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'"));

if(isset($_POST['submit'])) {
   $nama    = $_POST['nama'];
   $email   = $_POST['email'];
   $telepon = $_POST['telepon'];
   $alamat  = $_POST['alamat'];

   $query = mysqli_query($conn, "UPDATE user SET nama = '$nama', email = '$email', telepon = '$telepon', alamat = '$alamat' WHERE id = '$id'");

   if($query) {
      echo '<script>alert("Data berhasil diubah!")</script>';
      echo '<script>document.location.href="profil.php"</script>';
   } else {
      echo '<script>alert("Data gagal diubah!")</script>';
      echo '<script>document.location.href="profil.php"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Profil</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="row">
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Nama :</label>
                        <input type="text" name="nama" id="nama" class="form-control" value="<?= $_SESSION['bo_nama']; ?>" placeholder="Masukan nama" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Email :</label>
                        <input type="email" name="email" id="email" class="form-control" value="<?= $_SESSION['bo_email']; ?>" placeholder="Masukan email" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Telepon :</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" value="<?= $_SESSION['bo_telepon']; ?>" placeholder="Masukan telepon">
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Alamat :</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat" style="resize:none;"><?= $_SESSION['bo_alamat']; ?></textarea>
               </div>
               <div class="form-group"><hr></div>
               <div class="text-right">
                  <div class="form-group">
                     <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Update Profil</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<?php require 'layouts/footer.php'; ?>