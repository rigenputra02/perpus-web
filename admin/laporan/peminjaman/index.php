<?php 

require '../../layouts/header.php'; 

$nomor                = 1;
$filter_user_id       = null;
$filter_borrow_start  = null;
$filter_borrow_finish = null;
$filter_status        = null;
$filter_perpanjangan  = null;
$user                 = mysqli_query($conn, "SELECT * FROM user WHERE role != 'admin'");
$sql_clause           = '';

if(isset($_GET['filter'])) {
   $filter_user_id       = $_GET['filter_user_id'];
   $filter_borrow_start  = $_GET['filter_borrow_start'];
   $filter_borrow_finish = $_GET['filter_borrow_finish'];
   $filter_status        = $_GET['filter_status'];
   $filter_perpanjangan  = isset($_GET['filter_perpanjangan']) ? $_GET['filter_perpanjangan'] : null;

   if($filter_user_id) {
      $sql_clause .= "AND peminjaman.user_id = '$filter_user_id'";
   }

   if($filter_borrow_start && $filter_borrow_finish) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= "$space(peminjaman.tanggal_pinjam >= '$filter_borrow_start' AND peminjaman.tanggal_pinjam <= '$filter_borrow_finish')";
   } else if($filter_borrow_start) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= "$space(peminjaman.tanggal_pinjam = '$filter_borrow_start')";
   } else if($filter_borrow_finish) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= "$space(peminjaman.tanggal_pinjam = '$filter_borrow_finish')";
   }

   if($filter_status) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= $space . "peminjaman.status = '$filter_status'";
   }

   if($filter_perpanjangan) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= $space . "peminjaman.perpanjangan IS NOT NULL";
   }
}

$peminjaman = mysqli_query($conn, "SELECT peminjaman.id, peminjaman.kode, peminjaman.jatuh_tempo, peminjaman.status, peminjaman.tanggal_pinjam, peminjaman.perpanjangan, user.nama FROM peminjaman JOIN user ON user.id = peminjaman.user_id WHERE peminjaman.status IN ('pengajuan', 'dipinjam') AND user.role != 'admin' $sql_clause GROUP BY peminjaman.id ORDER BY peminjaman.tanggal_pinjam ASC");

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Laporan Peminjaman</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Filter
            </div>
         </div>
         <div class="card-body">
            <form action="" method="GET">
               <div class="form-group">
                  <label>User :</label>
                  <select name="filter_user_id" id="filter_user_id" class="custom-select">
                     <option value="">-- Pilih --</option>
                     <?php while($row = mysqli_fetch_assoc($user)) { ?>
                        <option value="<?= $row['id']; ?>" <?= $filter_user_id == $row['id'] ? 'selected' : '' ?>><?= $row['nama']; ?></option>
                     <?php } ?>
                  </select>
               </div>
               <div class="row">
                  <div class="col-md-8">
                     <div class="form-group">
                        <label>Tanggal :</label>
                        <div class="input-group">
                           <input type="date" name="filter_borrow_start" id="filter_borrow_start" class="form-control" max="<?= date('Y-m-d'); ?>" value="<?= $filter_borrow_start ? $filter_borrow_start : null ?>">
                           <div class="input-group-prepend">
                              <span class="input-group-text">s/d</span>
                           </div>
                           <input type="date" name="filter_borrow_finish" id="filter_borrow_finish" class="form-control" max="<?= date('Y-m-d'); ?>" value="<?= $filter_borrow_finish ? $filter_borrow_finish : null ?>">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group">
                        <label>Status :</label>
                        <select name="filter_status" id="filter_status" class="custom-select">
                           <option value="">-- Pilih --</option>
                           <option value="pengajuan" <?= $filter_status == 'pengajuan' ? 'selected' : null ?>>Pengajuan</option>
                           <option value="dipinjam" <?= $filter_status == 'dipinjam' ? 'selected' : null ?>>Dipinjam</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-12 text-right">
                     <div class="form-check">
                        <input type="checkbox" class="form-check-input" name="filter_perpanjangan" id="filter_perpanjangan" value="1" <?= $filter_perpanjangan ? 'checked' : '' ?>>
                        <label class="form-check-label" for="filter_perpanjangan">Perpanjangan</label>
                     </div>
                  </div>
               </div>
               <div class="form-group"><hr></div>
               <div class="form-group">
                  <div class="text-right">
                     <a href="<?= $base_url . '/admin/laporan/peminjaman'; ?>" class="btn btn-danger btn-sm"><i class="fas fa-sync"></i> Reset</a>
                     <button type="submit" name="filter" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Cari</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Data Peminjaman
               <span class="float-right">
                  <a href="<?= $base_url . '/admin/laporan/peminjaman/tambah.php'; ?>" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah</a>
               </span>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="datatable" class="table table-bordered table-hover table-striped" width="100%">
                  <thead>
                     <tr class="text-center">
                        <th>No</th>
                        <th>Kode</th>
                        <th>User</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while($row = mysqli_fetch_assoc($peminjaman)) { ?>
                        <tr class="text-center">
                           <td class="align-middle"><?= $nomor; ?></td>
                           <td class="align-middle"><?= $row['kode']; ?></td>
                           <td class="align-middle"><?= $row['nama']; ?></td>
                           <td class="align-middle"><?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?></td>
                           <td class="align-middle">
                              <?php if($row['jatuh_tempo']) { ?>
                                 <?php 
                                    if($row['perpanjangan'] > 0) {
                                       $perpanjangan        = '+' . $row['perpanjangan'] . ' days';
                                       $tanggal_jatuh_tempo = date('d F Y', strtotime($perpanjangan, strtotime($row['jatuh_tempo'])));
                                    } else {
                                       $tanggal_jatuh_tempo = date('d F Y', strtotime($row['jatuh_tempo']));
                                    }   

                                    echo $tanggal_jatuh_tempo;
                                 ?>
                              <?php } else { ?>
                                 Belum ditentukan
                              <?php } ?>
                           </td>
                           <td class="align-middle"><?= ucwords($row['status']); ?></td>
                           <td class="align-middle">
                              <a href="<?= $base_url . '/admin/laporan/peminjaman/detail.php?id=' . $row['id']; ?>" title="Detail" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i></a>
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
<?php require '../../layouts/footer.php'; ?>