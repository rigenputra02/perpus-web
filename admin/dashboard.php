<?php 

require 'layouts/header.php'; 

$total_koleksi        = mysqli_query($conn, "SELECT * FROM koleksi");
$total_user           = mysqli_query($conn, "SELECT * FROM user");
$total_koleksi_hilang = mysqli_query($conn, "SELECT * FROM peminjaman_detail WHERE status = 'hilang'");
$total_peminjaman     = mysqli_query($conn, "SELECT * FROM peminjaman WHERE status IN ('dipinjam', 'pengajuan')");
$statistik            = [];

for($i = 01; $i <= 12; $i++) {
   $year = date('Y');
   $data = mysqli_query($conn, "SELECT * FROM peminjaman WHERE (MONTH(tanggal_pinjam) = '$i' AND YEAR(tanggal_pinjam) = '$year') OR (MONTH(tanggal_kembali) = '$i' AND YEAR(tanggal_kembali) = '$year') GROUP BY id");

   $statistik[] = mysqli_num_rows($data);
}

?>
   <div class="container-fluid">
      <div class="d-sm-flex align-items-center justify-content-between mb-4">
         <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      </div>
      <div class="row">
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                           Total Koleksi
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($total_koleksi); ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-archive fa-2x text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                           Total User
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($total_user); ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                           Total Koleksi Hilang
                        </div>
                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= mysqli_num_rows($total_koleksi_hilang); ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-times fa-2x text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
               <div class="card-body">
                  <div class="row no-gutters align-items-center">
                     <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                           Total Peminjaman
                        </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?= mysqli_num_rows($total_peminjaman); ?></div>
                     </div>
                     <div class="col-auto">
                        <i class="fas fa-file fa-2x text-gray-300"></i>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="card shadow mb-4">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Statistik Peminjaman & Pengembalian</h6>
         </div>
         <div class="card-body">
            <div class="chart-area">
               <canvas id="chart_area"></canvas>
            </div>
         </div>
      </div>
   </div>
</div>

<script>
   $(function() {
      var ctx = document.getElementById('chart_area');
      var myLineChart = new Chart(ctx, {
         type: 'line',
         data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [
               {
                  backgroundColor: 'rgba(78, 115, 223, 0.05)',
                  borderColor: 'rgba(78, 115, 223, 1)',
                  pointBackgroundColor: 'rgba(78, 115, 223, 1)',
                  pointBorderColor: 'rgba(78, 115, 223, 1)',
                  pointHoverBackgroundColor: 'rgba(78, 115, 223, 1)',
                  pointHoverBorderColor: 'rgba(78, 115, 223, 1)',
                  data: [
                     '<?= $statistik[0]; ?>',
                     '<?= $statistik[1]; ?>',
                     '<?= $statistik[2]; ?>',
                     '<?= $statistik[3]; ?>',
                     '<?= $statistik[4]; ?>',
                     '<?= $statistik[5]; ?>',
                     '<?= $statistik[6]; ?>',
                     '<?= $statistik[7]; ?>',
                     '<?= $statistik[8]; ?>',
                     '<?= $statistik[9]; ?>',
                     '<?= $statistik[10]; ?>',
                     '<?= $statistik[11]; ?>'
                  ]
               }
            ],
         },
         options: {
            maintainAspectRatio: false,
            layout: {
               padding: {
                  left: 10,
                  right: 25,
                  top: 25,
                  bottom: 0
               }
            },
            scales: {
               xAxes: [
                  {
                     gridLines: {
                        display: true,
                        drawBorder: true
                     }
                  }
               ],
               yAxes: [
                  {
                     ticks: {
                        padding: 10
                     },
                     gridLines: {
                        color: 'rgb(234, 236, 244)',
                        zeroLineColor: 'rgb(234, 236, 244)',
                        drawBorder: false
                     }
                  }
               ],
            },
            legend: {
               display: false
            },
            tooltips: {
               backgroundColor: 'rgb(255,255,255)',
               bodyFontColor: '#858796',
               titleMarginBottom: 10,
               titleFontColor: '#6e707e',
               titleFontSize: 14,
               borderColor: '#dddfeb',
               borderWidth: 5,
               xPadding: 15,
               yPadding: 15,
               displayColors: true,
               intersect: false,
               mode: 'index',
               caretPadding: 10
            }
         }
      });
   });
</script>

<?php require 'layouts/footer.php'; ?>