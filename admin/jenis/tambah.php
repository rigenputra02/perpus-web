<?php 

require '../layouts/header.php'; 

if(isset($_POST['submit'])) {
   $id    = uuid();
   $nama  = $_POST['nama'];
   $query = mysqli_query($conn, "INSERT INTO jenis VALUES ('$id', '$nama')");

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
      <h1 class="h3 mb-2 text-gray-800">Tambah Jenis</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/jenis'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="form-group">
                  <label>Nama :</label>
                  <textarea name="nama" id="nama" class="form-control" placeholder="Masukan nama" style="resize:none;" required></textarea>
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