<?php 

require $_SERVER['DOCUMENT_ROOT'] . '/perpustakaan-main/connection.php'; 

$bo_id   = isset($_SESSION['bo_id']) ? $_SESSION['bo_id'] : null;
$bo_role = isset($_SESSION['bo_role']) ? $_SESSION['bo_role'] : null;
$user    = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE id = '$bo_id'"));

if(!$bo_id) {
    session_destroy();
    echo '<script>document.location.href="' . $base_url . '/admin/login.php"</script>';
} else if($bo_role != 'admin') {
    session_destroy();
    echo '<script>document.location.href="' . $base_url . '"</script>';
}

$_SESSION['bo_id']      = $user['id'];
$_SESSION['bo_nama']    = $user['nama'];
$_SESSION['bo_role']    = $user['role'];
$_SESSION['bo_email']   = $user['email'];
$_SESSION['bo_telepon'] = $user['telepon'];
$_SESSION['bo_alamat']  = $user['alamat'];

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perpustakaan Ikado</title>
    <link href="<?= $base_url; ?>/archive/icon.ico" rel="shortcut icon">
    <link href="<?= $base_url; ?>/assets/template/back_office/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= $base_url; ?>/assets/template/back_office/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="<?= $base_url; ?>/assets/plugins/datatable_b4/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="<?= $base_url; ?>/assets/plugins/datatable_b4/buttons.dataTables.min.css" rel="stylesheet">
    <link href="<?= $base_url; ?>/assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet">
    <script src="<?= $base_url; ?>/assets/template/back_office/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $base_url; ?>/assets/template/back_office/vendor/chart.js/Chart.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/select2/dist/js/select2.full.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/jquery.dataTables.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/dataTables.bootstrap4.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/dataTables.buttons.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/jszip.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/pdfmake.min.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/vfs_fonts.js"></script>
    <script src="<?= $base_url; ?>/assets/plugins/datatable_b4/buttons.html5.min.js"></script>

    <script>
        $(function() {
            $('.select2').select2();

            $('#datatable').DataTable({
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

        function previewImage(event, selector) {
            if(event.files && event.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $(selector).attr('src', e.target.result);
                }
                
                reader.readAsDataURL(event.files[0]);
            }
        }
    </script>
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $base_url; ?>admin/dashboard.php">
                <div class="sidebar-brand-icon rotate-n-15">P</div>
                <div class="sidebar-brand-text mx-3">Perpustakaan</div>
            </a>
            <hr class="sidebar-divider my-0">
            <li class="nav-item <?= $uri_segment[3] == 'dashboard.php' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/dashboard.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'jenis' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/jenis">
                    <i class="fas fa-fw fa-tag"></i>
                    <span>Jenis</span>
                </a>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'jurusan' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/jurusan">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Jurusan</span>
                </a>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'penerbit' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/penerbit">
                    <i class="fas fa-fw fa-user-tie"></i>
                    <span>Penerbit</span>
                </a>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'koleksi' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/koleksi">
                    <i class="fas fa-fw fa-archive"></i>
                    <span>Koleksi</span>
                </a>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'laporan' ? 'active' : '' ?>">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-file"></i>
                    <span>Laporan</span>
                </a>
                <div id="collapsePages" class="collapse <?= $uri_segment[3] == 'laporan' ? 'show' : '' ?>" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item <?= $uri_segment[4] == 'peminjaman' ? 'active' : '' ?>" href="<?= $base_url; ?>/admin/laporan/peminjaman">Peminjaman</a>
                        <a class="collapse-item <?= $uri_segment[4] == 'pengembalian' ? 'active' : '' ?>" href="<?= $base_url; ?>/admin/laporan/pengembalian">Pengembalian</a>
                        <a class="collapse-item <?= $uri_segment[4] == 'rekapitulasi_denda' ? 'active' : '' ?>" href="<?= $base_url; ?>/admin/laporan/rekapitulasi_denda">Rekapitulasi Denda</a>
                        <a class="collapse-item <?= $uri_segment[4] == 'rekapitulasi_koleksi' ? 'active' : '' ?>" href="<?= $base_url; ?>/admin/laporan/rekapitulasi_koleksi">Rekapitulasi Koleksi</a>
                    </div>
                </div>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'kritik_saran.php' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/kritik_saran.php">
                    <i class="fas fa-fw fa-envelope"></i>
                    <span>Kritik & Saran</span>
                </a>
            </li>
            <li class="nav-item <?= $uri_segment[3] == 'user' ? 'active' : '' ?>">
                <a class="nav-link" href="<?= $base_url; ?>/admin/user">
                    <i class="fas fa-fw fa-users"></i>
                    <span>User</span>
                </a>
            </li>
        </ul>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <form class="form-inline">
                        <button type="button" id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $_SESSION['bo_nama']; ?></span>
                                <img class="img-profile rounded-circle" src="<?= $base_url; ?>/assets/template/back_office/img/undraw_profile.svg">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?= $base_url; ?>/admin/profil.php">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profil
                                </a>
                                <a class="dropdown-item" href="<?= $base_url; ?>/admin/ganti_password.php">
                                    <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Ganti Password
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= $base_url; ?>/admin/logout.php">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>