<?php 

require '../layouts/header.php'; 

$jenis              = mysqli_query($conn, "SELECT * FROM jenis");
$nomor              = 1;
$filter_search      = null;
$filter_date_start  = null;
$filter_date_finish = null;
$filter_type        = null;
$sql_clause         = '';

if(isset($_GET['filter'])) {
   $filter_search = $_GET['filter_cari'];
   $filter_type   = $_GET['filter_jenis'];

   if($filter_search) {
      $sql_clause .= "AND (koleksi.judul LIKE '%$filter_search%' OR koleksi_pustaka.konten LIKE '%$filter_search%')";
   }

   if($filter_type) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= $space . "jenis.id = '$filter_type'";
   }
}

$koleksi = mysqli_query($conn, "SELECT koleksi.id, koleksi.cover, koleksi.judul, jenis.nama as nama_jenis, koleksi.tanggal_entri, penerbit.nama FROM koleksi JOIN penerbit ON penerbit.id = koleksi.penerbit_id LEFT JOIN koleksi_pustaka ON koleksi_pustaka.koleksi_id = koleksi.id LEFT JOIN jenis ON jenis.id = koleksi.jenis_id WHERE koleksi.id IS NOT NULL $sql_clause GROUP BY koleksi.id ORDER BY koleksi.tanggal_entri ASC");

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Koleksi</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Filter
            </div>
         </div>
         <div class="card-body">
            <form action="" method="GET">
               <div class="row">
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Pencarian :</label>
                        <input type="text" name="filter_cari" id="filter_cari" class="form-control" value="<?= $filter_search ? $filter_search : null ?>" placeholder="Masukan kata kunci (nama koleksi / daftar pustaka)">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Jenis :</label>
                        <select name="filter_jenis" id="filter_jenis" class="custom-select">
                           <option value="">-- Pilih --</option>
                           <?php while($row = mysqli_fetch_assoc($jenis)) { ?>
                              <option value="<?= $row['id'] ?>"><?= $row['nama'] ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="form-group"><hr></div>
               <div class="form-group">
                  <div class="text-right">
                     <a href="<?= $base_url . '/admin/koleksi'; ?>" class="btn btn-danger btn-sm"><i class="fas fa-sync"></i> Reset</a>
                     <button type="submit" name="filter" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Cari</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Daftar Koleksi
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/koleksi/tambah.php'; ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="datatable" class="table table-bordered table-hover table-striped" width="100%">
                  <thead>
                     <tr class="text-center">
                        <th>No</th>
                        <th>Cover</th>
                        <th>Judul</th>
                        <th>Penerbit</th>
                        <th>Jenis</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while($row = mysqli_fetch_assoc($koleksi)) { ?>
                        <tr class="text-center">
                           <td class="align-middle"><?= $nomor; ?></td>
                           <td class="align-middle">
                              <?php 
                                 if($row['cover']) {
                                    $cover = $base_url . '/archive/' . $row['cover'];
                                 } else {
                                    $cover = $base_url . '/archive/empty.jpg';
                                 }
                              ?>
                              <img src="<?= $cover; ?>" width="80" class="img-thumbnail img-fluid" alt="">
                           </td>
                           <td class="align-middle"><?= $row['judul']; ?></td>
                           <td class="align-middle"><?= $row['nama']; ?></td>
                           <td class="align-middle"><?= $row['nama_jenis']; ?></td>
                           <td class="align-middle"><?= date('d M Y', strtotime($row['tanggal_entri'])); ?></td>
                           <td class="align-middle" nowrap>
                              <a href="<?= $base_url . '/admin/koleksi/detail.php?id=' . $row['id']; ?>" title="Detail" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i></a>
                              <a href="<?= $base_url . '/admin/koleksi/edit.php?id=' . $row['id']; ?>" title="Edit" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></a>
                              <a href="<?= $base_url . '/admin/koleksi/hapus.php?id=' . $row['id']; ?>" title="Hapus" class="btn btn-danger btn-sm" onclick="return confirm('Anda yakin ingin menghapus data ini?');"><i class="fas fa-trash"></i></a>
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