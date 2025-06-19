<?php 

require '../layouts/header.php'; 

$nomor = 1;
$jenis = mysqli_query($conn, "SELECT * FROM jenis");

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Jenis</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Daftar Jenis
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/jenis/tambah.php'; ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="datatable" class="table table-bordered table-hover table-striped" width="100%">
                  <thead>
                     <tr class="text-center">
                        <th>No</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while($row = mysqli_fetch_assoc($jenis)) { ?>
                        <tr class="text-center">
                           <td class="align-middle"><?= $nomor; ?></td>
                           <td class="align-middle"><?= $row['nama']; ?></td>
                           <td class="align-middle">
                              <a href="<?= $base_url . '/admin/jenis/edit.php?id=' . $row['id']; ?>" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                              <a href="<?= $base_url . '/admin/jenis/hapus.php?id=' . $row['id']; ?>" title="Hapus" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
                           </td>
                        </tr>
                     <?php $nomor++; } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
<?php require '../layouts/footer.php'; ?>