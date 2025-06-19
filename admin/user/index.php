<?php 

require '../layouts/header.php'; 

$nomor = 1;
$user  = mysqli_query($conn, "SELECT user.*, jurusan.nama as nama_jurusan FROM user LEFT JOIN jurusan ON user.jurusan_id = jurusan.id");

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">User</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Daftar User
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/user/tambah.php'; ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
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
                        <th>Jurusan</th>
                        <th>Role</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while($row = mysqli_fetch_assoc($user)) { ?>
                        <tr class="text-center">
                           <td class="align-middle"><?= $nomor; ?></td>
                           <td class="align-middle"><?= $row['nama']; ?></td>
                           <td class="align-middle"><?= $row['role'] == 'mahasiswa' ? $row['nama_jurusan'] : '-' ?></td>
                           <td class="align-middle"><?= ucwords($row['role']); ?></td>
                           <td class="align-middle"><?= $row['email']; ?></td>
                           <td class="align-middle"><?= $row['telepon']; ?></td>
                           <td class="align-middle"><?= $row['alamat']; ?></td>
                           <td class="align-middle">
                              <a href="<?= $base_url . '/admin/user/reset_password.php?id=' . $row['id']; ?>" title="Reset Password" class="btn btn-success btn-sm" onclick="return confirm('Password akan direset menjadi `perpustakaan`');"><i class="fas fa-key"></i></a>
                              <a href="<?= $base_url . '/admin/user/edit.php?id=' . $row['id']; ?>" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                              <a href="<?= $base_url . '/admin/user/hapus.php?id=' . $row['id']; ?>" title="Hapus" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
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