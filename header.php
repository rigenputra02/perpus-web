<?php require 'connection.php'; ?>
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="archive/icon.ico" rel="shortcut icon">
    <link href="assets/template/front_office/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/datatable_b5/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="assets/template/front_office/jquery.min.js"></script>
    <script src="assets/plugins/datatable_b5/jquery.dataTables.min.js"></script>
    <script src="assets/plugins/datatable_b5/dataTables.bootstrap5.min.js"></script>
    <title>Perpustakaan Pusat UBHI</title>
  </head>
  <body>
    <nav class="navbar navbar-light bg-light">
      <div class="container">
        <a class="navbar-brand" href="<?= $base_url; ?>">
          <img src="archive/faruq-image.jpg" alt="Logo">
        </a>
        <span class="mb-3 mt-3">
          <b>Universitas Bhinneka PGRI</b><br>
          Kantor Perpustakaan Pusat JL. Mayor Sujadi Timur No 7 <br>
          Tulungagung, Kode Pos 66221.
        </span>
      </div>
    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background:#DD4814;">
      <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link" href="<?= $base_url; ?>">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="koleksi.php">Koleksi</a>
            </li>
            <?php if(isset($_SESSION['fo_id'])) { ?>
              <li class="nav-item">
                <a class="nav-link" href="pinjaman.php">Pinjaman</a>
              </li>
            <?php } ?>
            <li class="nav-item">
              <a class="nav-link" href="tentang_kami.php">Tentang Kami</a>
            </li>
          </ul>
          <form class="d-flex">
            <?php if(isset($_SESSION['fo_id'])) { ?>
              <div class="dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?= $_SESSION['fo_nama']; ?></a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="profil.php">Profil</a></li>
                  <li><a class="dropdown-item" href="ganti_password.php">Ganti Password</a></li>
                  <li><a class="dropdown-item" href="logout.php">Keluar</a></li>
                </ul>
              </div>
            <?php } else { ?>
              <a href="masuk.php" class="text-white font-weight-bold" style="text-decoration:none;">Masuk / Daftar</a>
            <?php } ?>
          </form>
        </div>
      </div>
    </nav>