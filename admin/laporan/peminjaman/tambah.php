<?php

    require '../../layouts/header.php';

    $user    = mysqli_query($conn, "SELECT * FROM user WHERE role != 'admin'");
    $koleksi = mysqli_query($conn, "SELECT koleksi.id, koleksi.judul, penerbit.nama FROM koleksi JOIN penerbit ON penerbit.id = koleksi.penerbit_id GROUP BY koleksi.id ORDER BY koleksi.tanggal_entri ASC");

    if (isset($_POST['submit'])) {
        $id             = uuid();
        $user_id        = $_POST['user_id'];
        $kode           = generateCode();
        $jatuh_tempo    = $_POST['jatuh_tempo'];
        $tanggal_pinjam = date('Y-m-d');
        $koleksi        = $_POST['koleksi'];

        $query = mysqli_query($conn, "INSERT INTO peminjaman VALUES ('$id', '$user_id', '$kode', '$jatuh_tempo', '$tanggal_pinjam', null, null, 'dipinjam')");

        if ($query) {
            if (isset($koleksi)) {
                foreach ($koleksi as $k) {
                    $peminjaman_detail_id = uuid();
                    mysqli_query($conn, "INSERT INTO peminjaman_detail VALUES ('$peminjaman_detail_id', '$id', '$k', 0, 0, 'pinjam')");
                }
            }

            echo '<script>alert("Data berhasil ditambahkan!")</script>';
            echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
        } else {
            echo '<script>alert("Data gagal ditambahkan!")</script>';
            echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
        }
    }

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Tambah Peminjaman</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Form
               <span class="float-right">
                  <a href="<?php echo $base_url . '/admin/laporan/peminjaman';?>" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <form action="" method="POST">
               <div class="form-group">
                  <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Data</h5>
               </div>
               <div class="form-group">
                  <label>User :</label>
                  <select name="user_id" id="user_id" class="custom-select" required>
                     <option value="">-- Pilih --</option>
                     <?php while ($row = mysqli_fetch_assoc($user)) {?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['nama'];?></option>
                     <?php }?>
                  </select>
               </div>
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Tanggal Pinjam :</label>
                        <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" disabled>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Jatuh Tempo :</label>
                        <input type="date" name="jatuh_tempo" id="jatuh_tempo" class="form-control" min="<?php echo date('Y-m-d');?>" required>
                     </div>
                  </div>
               </div>
               <div class="form-group"><hr></div>
               <div class="form-group">
                  <h5 class="font-weight-bold text-uppercase mb-4 mt-4 text-primary">Koleksi</h5>
               </div>
               <div class="form-group">
                  <table id="datatable" class="table table-bordered table-striped">
                     <thead class="table-primary">
                        <tr class="text-center">
                           <th>#</th>
                           <th>Judul</th>
                           <th>Penerbit</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php while ($row = mysqli_fetch_assoc($koleksi)) {?>
<?php
    $koleksi_id   = $row['id'];
        $koleksi_stok = mysqli_query($conn, "
SELECT koleksi_stok.kode, COUNT(peminjaman_detail.id) AS sa
FROM koleksi_stok
LEFT JOIN peminjaman_detail ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode
WHERE (koleksi_stok.koleksi_id = '$koleksi_id' OR peminjaman_detail.status IN ('tolak', 'lengkap'))
AND ((SELECT COUNT(*) FROM peminjaman_detail q WHERE q.koleksi_stok_kode = koleksi_stok.kode) < 1)
GROUP BY koleksi_stok.kode
LIMIT 1
");

    ?>
<?php if (mysqli_num_rows($koleksi_stok) > 0) {?>
<?php $data_stok = mysqli_fetch_assoc($koleksi_stok); ?>
<?php if ($data_stok['kode']) {?>
                                 <tr class="text-center">
                                    <td class="align-middle">
                                       <input type="checkbox" name="koleksi[]" value="<?php echo $data_stok['kode'];?>">
                                    </td>
                                    <td class="align-middle"><?php echo $row['judul'];?></td>
                                    <td class="align-middle"><?php echo $row['nama'];?></td>
                                 </tr>
                              <?php }?>
<?php }?>
<?php }?>
                     </tbody>
                  </table>
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

<?php require '../../layouts/footer.php'; ?>