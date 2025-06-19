<?php 

require 'header.php'; 

if(isset($_SESSION['fo_id'])) {
  echo '<script>document.location.href="' . $base_url . '"</script>';
}

if(isset($_POST['submit'])) {
  $email    = $_POST['email'];
  $password = $_POST['password'];
  $user     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' AND role != 'admin'"));

  if($user) {
    if(password_verify($password, $user['password'])) {
      $_SESSION['fo_id']      = $user['id'];
      $_SESSION['fo_nama']    = $user['nama'];
      $_SESSION['fo_role']    = $user['role'];
      $_SESSION['fo_email']   = $user['email'];
      $_SESSION['fo_telepon'] = $user['telepon'];
      $_SESSION['fo_alamat']  = $user['alamat'];

      echo '<script>document.location.href="' . $base_url . '"</script>';
    }
  } 

  echo '<script>alert("Akun tidak ditemukan!")</script>';
}

?>
<div class="container">
  <div class="mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-5">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Masuk Akun</h5>
            <form action="" class="row" method="POST">
              <div class="col-12">
                <label>Email :</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" required>
              </div>
              <div class="col-12 mt-3">
                <label>Password :</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password" required>
              </div>
              <div class="col-12 mt-3">
                <div class="text-end">
                  <button type="submit" class="btn btn-success" name="submit">Masuk</button>
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <a href="daftar.php" class="btn btn-primary btn-sm">Daftar disini.</a>
            <a href="admin/login.php" class="btn btn-info btn-sm text-white">Petugas.</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>