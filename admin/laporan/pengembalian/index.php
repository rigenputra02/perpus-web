<?php 

require '../../layouts/header.php'; 

$nomor                = 1;
$filter_user_id       = null;
$filter_borrow_start  = null;
$filter_borrow_finish = null;
$filter_back_start    = null;
$filter_back_finish   = null;
$filter_status        = null;
$user                 = mysqli_query($conn, "SELECT * FROM user WHERE role != 'admin'");
$sql_clause           = '';

if(isset($_GET['filter'])) {
   $filter_user_id       = $_GET['filter_user_id'];
   $filter_borrow_start  = $_GET['filter_borrow_start'];
   $filter_borrow_finish = $_GET['filter_borrow_finish'];
   $filter_back_start    = $_GET['filter_back_start'];
   $filter_back_finish   = $_GET['filter_back_finish'];
   $filter_status        = $_GET['filter_status'];

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

   if($filter_back_start && $filter_back_finish) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= "$space(peminjaman.tanggal_kembali >= '$filter_back_start' AND peminjaman.tanggal_kembali <= '$filter_back_finish')";
   } else if($filter_back_start) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= "$space(peminjaman.tanggal_kembali = '$filter_back_start')";
   } else if($filter_back_finish) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= "$space(peminjaman.tanggal_kembali = '$filter_back_finish')";
   }

   if($filter_status) {
      if($sql_clause) {
         $space = ' AND ';
      } else {
         $space = 'AND ';
      }

      $sql_clause .= $space . "peminjaman.status = '$filter_status'";
   }
}

$pengembalian = mysqli_query($conn, "SELECT peminjaman.id, peminjaman.kode, peminjaman.jatuh_tempo, peminjaman.status, peminjaman.tanggal_pinjam, peminjaman.tanggal_kembali, peminjaman.perpanjangan, user.nama FROM peminjaman JOIN user ON user.id = peminjaman.user_id WHERE peminjaman.status IN ('ditolak', 'selesai') AND user.role != 'admin' $sql_clause GROUP BY peminjaman.id ORDER BY peminjaman.tanggal_pinjam ASC");

?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Laporan Pengembalian</h1>
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
                        <label>User :</label>
                        <select name="filter_user_id" id="filter_user_id" class="custom-select">
                           <option value="">-- Pilih --</option>
                           <?php while($row = mysqli_fetch_assoc($user)) { ?>
                              <option value="<?= $row['id']; ?>" <?= $filter_user_id == $row['id'] ? 'selected' : '' ?>><?= $row['nama']; ?></option>
                           <?php } ?>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Status :</label>
                        <select name="filter_status" id="filter_status" class="custom-select">
                           <option value="">-- Pilih --</option>
                           <option value="ditolak" <?= $filter_status == 'ditolak' ? 'selected' : null ?>>Ditolak</option>
                           <option value="selesai" <?= $filter_status == 'selesai' ? 'selected' : null ?>>Selesai</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Tanggal Pinjam :</label>
                        <div class="input-group">
                           <input type="date" name="filter_borrow_start" id="filter_borrow_start" class="form-control" max="<?= date('Y-m-d'); ?>" value="<?= $filter_borrow_start ? $filter_borrow_start : null ?>">
                           <div class="input-group-prepend">
                              <span class="input-group-text">s/d</span>
                           </div>
                           <input type="date" name="filter_borrow_finish" id="filter_borrow_finish" class="form-control" max="<?= date('Y-m-d'); ?>" value="<?= $filter_borrow_finish ? $filter_borrow_finish : null ?>">
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="form-group">
                        <label>Tanggal Kembali :</label>
                        <div class="input-group">
                           <input type="date" name="filter_back_start" id="filter_back_start" class="form-control" max="<?= date('Y-m-d'); ?>" value="<?= $filter_back_start ? $filter_back_start : null ?>">
                           <div class="input-group-prepend">
                              <span class="input-group-text">s/d</span>
                           </div>
                           <input type="date" name="filter_back_finish" id="filter_back_finish" class="form-control" max="<?= date('Y-m-d'); ?>" value="<?= $filter_back_finish ? $filter_back_finish : null ?>">
                        </div>
                     </div>
                  </div>
               </div>
               <div class="form-group"><hr></div>
               <div class="form-group">
                  <div class="text-right">
                     <a href="<?= $base_url . '/admin/laporan/pengembalian'; ?>" class="btn btn-danger btn-sm"><i class="fas fa-sync"></i> Reset</a>
                     <button type="submit" name="filter" class="btn btn-success btn-sm"><i class="fas fa-search"></i> Cari</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-2 font-weight-bold text-primary">
               Data Pengembalian
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
                        <th>Tanggal Kembali</th>
                        <th>Pengembalian</th>
                        <th>Status</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while($row = mysqli_fetch_assoc($pengembalian)) { ?>
                        <tr class="text-center">
                           <td class="align-middle"><?= $nomor; ?></td>
                           <td class="align-middle"><?= $row['kode']; ?></td>
                           <td class="align-middle"><?= $row['nama']; ?></td>
                           <td class="align-middle"><?= date('d M Y', strtotime($row['tanggal_pinjam'])); ?></td>
                           <td class="align-middle">
                              <?php 
                                 if($row['status'] != 'ditolak') {
                                    echo date('d M Y', strtotime($row['tanggal_kembali']));
                                 } else {
                                    echo '<small class="text-danger font-italic font-weight-bold">Tidak ada</small>'; 
                                 }
                              ?>
                           </td>
                           <td class="align-middle">
                              <?php 
                                 if($row['status'] != 'ditolak') {
                                    if($row['perpanjangan'] > 0) {
                                       $perpanjangan        = '+' . $row['perpanjangan'] . ' days';
                                       $tanggal_jatuh_tempo = date('Y-m-d', strtotime($perpanjangan, strtotime($row['jatuh_tempo'])));
                                    } else {
                                       $tanggal_jatuh_tempo = $row['jatuh_tempo'];
                                    }

                                    $back_date = strtotime($row['tanggal_kembali']);
                                    $deadline  = strtotime($tanggal_jatuh_tempo);

                                    if($back_date == $deadline) {
                                       echo '<small class="text-primary font-italic font-weight-bold">Tepat waktu</small>';
                                    } else if($back_date < $deadline) {
                                       echo '<small class="text-success font-italic font-weight-bold">Sebelum jatuh tempo</small>';
                                    } else {
                                       $tanggal_kembali = date_create($row['tanggal_kembali']);
                                       $jatuh_tempo     = date_create($tanggal_jatuh_tempo);
                                       $selisih         = date_diff($jatuh_tempo, $tanggal_kembali);
                                       
                                       echo '<small class="text-danger font-italic font-weight-bold">Terlambat ' . $selisih->days . ' hari</small>'; 
                                    }
                                 } else {
                                    echo '<small class="text-danger font-italic font-weight-bold">Tidak ada</small>'; 
                                 }
                              ?>
                           </td>
                           <td class="align-middle"><?= ucwords($row['status']); ?></td>
                           <td class="align-middle">
                              <a href="<?= $base_url . '/admin/laporan/pengembalian/detail.php?id=' . $row['id']; ?>" title="Detail" class="btn btn-info btn-sm"><i class="fas fa-info-circle"></i></a>
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