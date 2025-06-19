<?php 

require '../layouts/header.php'; 

$id      = $_GET['id'];
$jurusan = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM jurusan WHERE id = '$id'"));

if(!isset($id) || !$jurusan) {
   echo '<script>alert("Data tidak ditemukan!")</script>';
   echo '<script>document.location.href="' . $base_url . '/admin/koleksi"</script>';
}

if(isset($_POST['submit'])) {
   $nama  = $_POST['nama'];
   $query = mysqli_query($conn, "UPDATE jurusan SET nama = '$nama' WHERE id = '$id'");

   if($query) {
      echo '<script>alert("Data berhasil diubah!")</script>';
      echo '<script>document.location.href="' . $base_url . '/admin/jurusan"</script>';
   } else {
      echo '<script>alert("Data gagal diubah!")</script>';
      echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '?id=' . $id . '"</script>';
   }
}

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Edit Program Studi</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/jurusan'; ?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="form-group">
                  <label>Nama :</label>
                  <textarea name="nama" id="nama" class="form-control" placeholder="Masukan nama Program Studi" style="resize:none;" minlength="5" required><?= $jurusan['nama']; ?></textarea>
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