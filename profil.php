<?php 

require 'header.php'; 

$jurusan = mysqli_query($conn, "SELECT * FROM jurusan");
$id      = $_SESSION['fo_id'];
$user    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id = '$id'"));

if(!isset($_SESSION['fo_id'])) {
  echo '<script>document.location.href="' . $base_url . '"</script>';
}

if(isset($_POST['submit'])) {
  $role       = $_SESSION['fo_role'];
  $jurusan_id = $role == 'mahasiswa' ? $_POST['jurusan_id'] : null;
  $nama       = $_POST['nama'];
  $email      = $_POST['email'];
  $telepon    = $_POST['telepon'];
  $alamat     = $_POST['alamat'];
  $updateable = $_SESSION['fo_role'] == 'mahasiswa' ? "jurusan_id = '$jurusan_id'," : null;

  $query = mysqli_query($conn, "UPDATE user SET $updateable nama = '$nama', email = '$email', telepon = '$telepon', alamat = '$alamat' WHERE id = '$id'");

  if($query) {
    $_SESSION['fo_nama']    = $nama;
    $_SESSION['fo_email']   = $email;
    $_SESSION['fo_telepon'] = $telepon;
    $_SESSION['fo_alamat']  = $alamat;

    echo '<script>document.location.href="profil.php"</script>';
  } 
}

?>
<div class="container">
  <div class="mt-5 mb-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title mb-4"></h5>
            <form action="" class="row" method="POST">
              <div class="col-6 mt-3">
                <label>Nama :</label>
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" value="<?= $user['nama']; ?>" required>
              </div>
              <div class="col-6 mt-3">
                <label>Email :</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" value="<?= $user['email']; ?>" required>
              </div>
              <div class="col-12 mt-3">
                <label>Telepon :</label>
                <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Masukan telepon" value="<?= $user['telepon']; ?>" required>
              </div>
              <?php if($_SESSION['fo_role'] == 'mahasiswa') { ?>
                <div class="col-12 mt-3 select-jurusan_id">
                  <label>Jurusan :</label>
                  <select name="jurusan_id" id="jurusan_id" class="form-control">
                    <option value="">-- Pilih --</option>
                    <?php while($row = mysqli_fetch_assoc($jurusan)) { ?> 
                      <option value="<?= $row['id']; ?>"  <?= $user['jurusan_id'] == $row['id'] ? 'selected' : '' ?>><?= $row['nama']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              <?php } ?>
              <div class="col-12 mt-3">
                <label>Alamat :</label>
                <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat lengkap" required><?= $user['alamat']; ?></textarea>
              </div>
              <div class="col-12 mt-3">
                <div class="text-end">
                  <button type="submit" class="btn btn-info text-white" name="submit">Simpan</button>
                </div>
              </div>
            </form>
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