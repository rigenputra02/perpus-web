<?php 

require 'header.php'; 

if(!isset($_SESSION['fo_id'])) {
  echo '<script>document.location.href="' . $base_url . '"</script>';
}

$id = $_SESSION['fo_id'];
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
<div class="container">
  <div class="mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Ganti Password</h5>
            <form action="" class="row" method="POST">
              <div class="col-12">
                <label>Password Lama :</label>
                <input type="password" name="password_lama" id="password_lama" class="form-control" placeholder="Masukan password lama" required>
              </div>
              <div class="col-12 mt-3">
                <label>Password Baru :</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password baru" required>
              </div>
              <div class="col-12 mt-3">
                <label>Konfirmasi Password :</label>
                <input type="password" name="konfirmasi_password" id="konfirmasi_password" class="form-control" placeholder="Masukan konfirmasi password" required>
              </div>
              <div class="col-12 mt-3">
                <div class="text-end">
                  <button type="submit" class="btn btn-warning text-white" name="submit">Ganti Password</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>