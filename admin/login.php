<?php 

require '../connection.php'; 

if(isset($_SESSION['bo_id'])) {
    echo '<script>document.location.href="dashboard.php"</script>';
}

if(isset($_POST['login'])) {
    $email    = $_POST['email'];
    $password = $_POST['password'];
    $user     = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM user WHERE email = '$email' AND role = 'admin'"));

    if($user) {
        if(password_verify($password, $user['password'])) {
            $_SESSION['bo_id']      = $user['id'];
            $_SESSION['bo_nama']    = $user['nama'];
            $_SESSION['bo_role']    = $user['role'];
            $_SESSION['bo_email']   = $user['email'];
            $_SESSION['bo_telepon'] = $user['telepon'];
            $_SESSION['bo_alamat']  = $user['alamat'];

            echo '<script>document.location.href="dashboard.php"</script>';
        }
    } 

    echo '<script>alert("Akun tidak ditemukan!")</script>';
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Perpustakaan Ikado - Admin Login</title>
    <link href="<?= $base_url; ?>/archive/icon.ico" rel="shortcut icon">
    <link href="<?= $base_url; ?>/assets/template/back_office/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="<?= $base_url; ?>/assets/template/back_office/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-5 col-md-5 mt-5">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="p-5">
                            <div class="text-center">
                                <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                            </div>
                            <form method="POST" class="user">
                                <div class="form-group">
                                    <input type="email" name="email" id="email" class="form-control form-control-user" placeholder="Masukan email">
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" id="password" class="form-control form-control-user" placeholder="Masukan password">
                                </div>
                                <button type="submit" name="login" class="btn btn-primary btn-user btn-block">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= $base_url; ?>/assets/template/back_office/vendor/jquery/jquery.min.js"></script>
    <script src="<?= $base_url; ?>/assets/template/back_office/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= $base_url; ?>/assets/template/back_office/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="<?= $base_url; ?>/assets/template/back_office/js/sb-admin-2.min.js"></script>
</body>
</html>