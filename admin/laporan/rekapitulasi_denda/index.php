<?php 

require '../../layouts/header.php'; 

$nomor        = 1;
$filter_month = date('Y-m');
$sql_clause   = '';

if(isset($_GET['filter_month'])) {
   $filter_month = $_GET['filter_month'];
   $month        = date('m', strtotime($filter_month));
   $year         = date('Y', strtotime($filter_month));

   if($filter_month) {
      $sql_clause .= "AND (MONTH(peminjaman.tanggal_pinjam) = '$month' AND YEAR(peminjaman.tanggal_pinjam) = '$year')";
   }
}

$peminjaman = mysqli_query($conn, "
SELECT
  koleksi.judul,
  jenis.nama,
  MIN(peminjaman.tanggal_pinjam) AS tanggal_pinjam,
  SUM(peminjaman_detail.denda_terlambat + peminjaman_detail.denda_lainnya) AS total_denda
FROM peminjaman_detail
LEFT JOIN peminjaman ON peminjaman.id = peminjaman_detail.peminjaman_id
LEFT JOIN koleksi_stok ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode
LEFT JOIN koleksi ON koleksi.id = koleksi_stok.koleksi_id
LEFT JOIN jenis ON jenis.id = koleksi.jenis_id
WHERE koleksi.judul IS NOT NULL $sql_clause
GROUP BY koleksi.id
ORDER BY tanggal_pinjam ASC
");


?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Laporan Rekapitulasi Denda</h1>
      <div class="card shadow mb-4 mt-4">
         <div class="card-header">
            <div class="mt-4 font-weight-bold text-primary">
               Data Rekapitulasi Denda
               <span class="float-right">
                  <form action="" id="form_filter">
                     <div class="form-group">
                        <input type="month" name="filter_month" class="form-control form-control-sm" onchange="$('#form_filter').submit();" value="<?= $filter_month; ?>">
                     </div>
                  </form>
               </span>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table id="datatable_html5" class="table table-bordered table-hover table-striped" width="100%">
                  <thead>
                     <tr class="text-center">
                        <th>No</th>
                        <th>Koleksi</th>
                        <th>Jenis</th>
                        <th>Nominal Denda</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php while($row = mysqli_fetch_assoc($peminjaman)) { ?>
                        <tr class="text-center">
                           <td class="align-middle"><?= $nomor; ?></td>
                           <td class="align-middle"><?= $row['judul']; ?></td>
                           <td class="align-middle"><?= $row['nama']; ?></td>
                           <td class="align-middle"><?= number_format($row['total_denda'], 0, ',', '.'); ?></td>
                        </tr>
                     <?php $nomor++; } ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $(function() {
      $('#datatable_html5').DataTable( {
         dom: 'Bfrtip',
         buttons: [
            'pdfHtml5'
         ],
         language: {
            emptyTable: 'Data tidak ada',
            info: 'Menampilkan _START_ sampai _END_ dari _TOTAL_ data',
            infoEmpty: 'Data kosong',
            infoFiltered: '(ditemukan _MAX_ total data)',
            lengthMenu: 'Menampilkan _MENU_ data',
            loadingRecords: 'Loading ...',
            search: 'Pencarian :',
            zeroRecords: 'Data tidak ditemukan',
            paginate: {
               first: '<',
               last: '>',
               next: 'Selanjutnya',
               previous: 'Sebelumnya'
            }
         }
      });
   });
</script>

<?php require '../../layouts/footer.php'; ?>