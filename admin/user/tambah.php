<?php 

require '../layouts/header.php'; 

$jurusan = mysqli_query($conn, "SELECT * FROM jurusan");

if(isset($_POST['submit'])) {
   $id         = uuid();
   $role       = $_POST['role'];
   $jurusan_id = $role == 'mahasiswa' ? $_POST['jurusan_id'] : null;
   $nama       = $_POST['nama'];
   $email      = $_POST['email'];
   $telepon    = $_POST['telepon'];
   $password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
   $alamat     = $_POST['alamat'];

   $check_email = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'");
   if(mysqli_num_rows($check_email) > 0) {
      echo '<script>alert("Email telah digunakan!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
      die;
   }

   $query = mysqli_query($conn, "INSERT INTO user VALUES ('$id', '$jurusan_id', '$role', '$nama', '$email', '$telepon', '$password', '$alamat')");

   if($query) {
      echo '<script>alert("Data berhasil ditambahkan!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
   } else {
      echo '<script>alert("Data gagal ditambahkan!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Tambah User</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/user'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Nama :</label>
                        <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" required>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Email :</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" required>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Telepon :</label>
                        <input type="text" name="telepon" id="telepon" class="form-control" placeholder="Masukan telepon">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Role :</label>
                        <select name="role" id="role" class="custom-select" required>
                           <option value="">-- Pilih --</option>
                           <option value="admin">Admin</option>
                           <option value="dosen">Dosen</option>
                           <option value="mahasiswa">Mahasiswa</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Jurusan :</label>
                        <select name="jurusan_id" id="jurusan_id" class="custom-select">
                           <option value="">-- Pilih --</option>
                           <?php while($row = mysqli_fetch_assoc($jurusan)) { ?> 
                              <option value="<?= $row['id']; ?>"><?= $row['nama']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label>Password :</label>
                  <input type="text" name="password" id="password" class="form-control" placeholder="Masukan password" value="perpusikado" readonly required>
               </div>
               <div class="form-group">
                  <label>Alamat :</label>
                  <textarea name="alamat" id="alamat" class="form-control" placeholder="Masukan alamat" style="resize:none;"></textarea>
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