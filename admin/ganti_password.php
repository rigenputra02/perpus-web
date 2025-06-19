<?php 

require 'layouts/header.php'; 

$id = $_SESSION['bo_id'];
if(isset($_POST['submit'])) {
   $password_lama       = $_POST['password_lama'];
   $password            = $_POST['password'];
   $konfirmasi_password = $_POST['konfirmasi_password'];
   $user                = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'"));

   if(password_verify($password_lama, $user['password'])) {
      if($password == $konfirmasi_password) {
         $password_hash = password_hash($password, PASSWORD_DEFAULT);
         $query         = mysqli_query($conn, "UPDATE user SET password = '$password_hash' WHERE id = '$id'");

         if($query) {
            echo '<script>alert("Password telah diganti!")</script>';
            echo '<script>document.location.href="logout.php"</script>';
         } else {
            echo '<script>alert("Password gagal diganti!")</script>';
            echo '<script>document.location.href="ganti_password.php"</script>';
         }
      } else {
         echo '<script>alert("Password dan konfirmasi password tidak sama!")</script>';
         echo '<script>document.location.href="ganti_password.php"</script>';
      }
   } else {
      echo '<script>alert("Password lama tidak benar!")</script>';
      echo '<script>document.location.href="ganti_password.php"</script>';
   }
}

?>
   <div class="container-fluid justify-content-center">
      <h1 class="h3 mb-2 text-gray-800">Ganti Password</h1>
      <div class="row justify-content-center">
         <div class="col-md-5">
            <div class="card shadow mb-4 mt-4">
               <div class="card-header">
                  <div class="mt-2 font-weight-bold text-primary">
                     Form
                  </div>
               </div>
               <div class="card-body">
                  <form action="" method="POST">
                     <div class="form-group">
                        <label>Password Lama :</label>
                        <input type="password" name="password_lama" id="password_lama" class="form-control" placeholder="Masukan password lama" required>
                     </div>
                     <div class="form-group">
                        <label>Password Baru :</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password baru" required>
                     </div>
                     <div class="form-group">
                        <label>Konfirmasi Password :</label>
                        <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" placeholder="Masukan konfirmasi password" required>
                     </div>
                     <div class="form-group"><hr></div>
                     <div class="text-right">
                        <div class="form-group">
                           <button type="submit" name="submit" class="btn btn-warning"><i class="fas fa-edit"></i> Ganti Password</button>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<?php require 'layouts/footer.php'; ?>