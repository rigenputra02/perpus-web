<?php 

require 'header.php'; 

$jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
if(isset($_SESSION['fo_id'])) {
  echo '<script>document.location.href="' . $base_url . '"</script>';
}

if(isset($_POST['submit'])) {
  $id               = uuid();
  $role             = $_POST['role'];
  $jurusan_id       = $role == 'mahasiswa' ? $_POST['jurusan_id'] : null;
  $nama             = $_POST['nama'];
  $email            = $_POST['email'];
  $telepon          = $_POST['telepon'];
  $password         = $_POST['password'];
  $konfirm_password = $_POST['konfirm_password'];
  $alamat           = $_POST['alamat'];

  $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
  if(mysqli_num_rows($check_email) > 0) {
    echo '<script>alert("Email telah digunakan!")</script>';
    echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
    die;
  }

  if($password == $konfirm_password) {
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $query    = mysqli_query($conn, "INSERT INTO user VALUES ('$id', '$jurusan_id', '$role', '$nama', '$email', '$telepon', '$password', '$alamat')");

    if($query) {
      $_SESSION['fo_id']      = $id;
      $_SESSION['fo_nama']    = $nama;
      $_SESSION['fo_role']    = $role;
      $_SESSION['fo_email']   = $email;
      $_SESSION['fo_telepon'] = $telepon;
      $_SESSION['fo_alamat']  = $alamat;

      echo '<script>alert("Pendaftaran berhasil")</script>';
      echo '<script>document.location.href="' . $base_url . '"</script>';
    } 
  } else {
    echo '<script>alert("Password dan konfirmasi password tidak sama")</script>';
    echo '<script>document.location.href="daftar.php"</script>';
  }
}

?>
<div class="container">
  <div class="mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4">Daftar Akun</h5>
            <form action="" class="row" method="POST">
              <div class="col-6 mt-3">
                <label>Nama :</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" minlength="3" required>
              </div>
              <div class="col-6 mt-3">
                <label>Email :</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" required>
              </div>
              <div class="col-6 mt-3">
                <label>Daftar Sebagai :</label>
                <select name="role" id="role" class="form-control" required>
                  <option value="">-- Pilih --</option>
                  <option value="mahasiswa">Mahasiswa</option>
                  <option value="dosen">Dosen</option>
                </select>
              </div>
              <div class="col-6 mt-3">
                <label>Telepon :</label>
                <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Masukan telepon" minlength="10" maxlength="12" required>
              </div>
              <div class="col-12 mt-3 select-jurusan_id">
                <label>Jurusan :</label>
                <select name="jurusan_id" id="jurusan_id" class="form-control">
                  <option value="">-- Pilih --</option>
                  <?php while($row = mysqli_fetch_assoc($jurusan)) { ?> 
                    <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="col-12 mt-3">
                <label>Alamat :</label>
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat lengkap" minlength="10" required></textarea>
              </div>
              <div class="col-6 mt-3">
                <label>Password :</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukan password" required>
              </div>
              <div class="col-6 mt-3">
                <label>Konfirmasi Password :</label>
                <input type="password" name="konfirm_password" id="konfirm_password" class="form-control" placeholder="Masukan konfirmasi password" required>
              </div> 
              <div class="col-12 mt-3">
                <div class="text-end">
                  <button type="submit" class="btn btn-success" name="submit">Daftar</button>
                </div>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <a href="masuk.php" class="btn btn-primary btn-sm">Masuk disini.</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('#role').change(function() {
      if($('#role').val() == 'mahasiswa') {
        $('.select-jurusan_id').show();
        $('#jurusan_id').attr('required', true);
      } else if($('#role').val() == 'dosen') {
        $('#jurusan_id').val(null);
        $('#jurusan_id').removeAttr('required');
        $('.select-jurusan_id').hide();
      } else {
        $('.select-jurusan_id').show();
        $('#jurusan_id').removeAttr('required');
      }
    });
  });
</script>

<?php require 'footer.php'; ?>