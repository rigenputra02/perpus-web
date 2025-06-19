<?php

    require 'header.php';

    if (! isset($_SESSION['fo_id'])) {
        echo '<script>document.location.href="masuk.php"</script>';
    }

    $session_id = isset($_SESSION['koleksi_id']) ? array_unique($_SESSION['koleksi_id']) : null;
    $koleksi    = mysqli_query($conn, "SELECT koleksi.id, koleksi.judul, penerbit.nama, (SELECT COUNT(*) FROM koleksi_stok WHERE koleksi_stok.koleksi_id = koleksi.id) as total_stok FROM koleksi JOIN penerbit ON penerbit.id = koleksi.penerbit_id GROUP BY koleksi.id ORDER BY koleksi.tanggal_entri ASC");

    if (isset($_POST['submit'])) {
        $user_id   = $_SESSION['fo_id'];
        $terpinjam = mysqli_query($conn, "SELECT * FROM peminjaman_detail LEFT JOIN peminjaman ON peminjaman.id = peminjaman_detail.peminjaman_id WHERE peminjaman.user_id = '$user_id' AND peminjaman_detail.status = 'pinjam'");

        $total_dipinjam = mysqli_num_rows($terpinjam) + count($_POST['koleksi_stok_kode']);
        if ($total_dipinjam > 3) {
            echo '<script>alert("Batas pinjam hanya 3 koleksi!")</script>';
            echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
        } else {
            $id             = uuid();
            $kode           = generateCode();
            $tanggal_pinjam = date('Y-m-d');
            $jatuh_tempo    = date('Y-m-d', strtotime('+3 day'));
            $koleksi_stok   = $_POST['koleksi_stok_kode'];

            $query = mysqli_query($conn, "INSERT INTO peminjaman VALUES ('$id', '$user_id', '$kode', '$jatuh_tempo', '$tanggal_pinjam', null, null, 'pengajuan')");

            if ($query) {
                if (isset($koleksi_stok)) {
                    foreach ($koleksi_stok as $ks) {
                        $peminjaman_detail_id = uuid();
                        mysqli_query($conn, "INSERT INTO peminjaman_detail VALUES ('$peminjaman_detail_id', '$id', '$ks', 0, 0, 'pinjam')");
                    }
                }

                unset($_SESSION['koleksi_id']);
                echo '<script>alert("Pinjaman telah diajukan!")</script>';
                echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
            } else {
                echo '<script>alert("Pinjaman gagal diajukan!")</script>';
                echo '<script>document.location.href="' . $_SERVER['PHP_SELF'] . '"</script>';
            }
        }
    }

?>
<div class="container">
  <div class="mt-5 mb-5">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <div class="mb-5">
            <span style="font-size:20px;">Tambah Pinjaman Saya</span>
            <span class="float-end">
              <a href="pinjaman.php" class="btn btn-secondary">Kembali</a>
            </span>
          </div>
        </div>
        <form action="" class="row" method="POST">
          <div class="col-6 mb-3">
            <label class="mb-2">User :</label>
            <input type="text" class="form-control" value="<?php echo $_SESSION['fo_nama'];?>" disabled>
          </div>
          <div class="col-6 mb-3">
            <label class="mb-2">Tanggal Pinjam :</label>
            <input type="date" class="form-control" value="<?php echo date('Y-m-d');?>" disabled>
          </div>
          <div class="col-12"><hr></div>
          <div class="col-12">
            <table id="datatable" class="table table-bordered table-striped">
              <thead class="table-primary">
                <tr class="text-center">
                  <th>#</th>
                  <th>Judul</th>
                  <th>Penerbit</th>
                  <th>Stok</th>
                </tr>
              </thead>
              <tbody>
                <?php while ($row = mysqli_fetch_assoc($koleksi)) {?>
<?php
    $koleksi_id   = $row['id'];
        $koleksi_stok = mysqli_query($conn, "SELECT koleksi_stok.kode, COUNT(peminjaman_detail.id) sa
FROM koleksi_stok
LEFT JOIN peminjaman_detail ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode
WHERE (koleksi_stok.koleksi_id = '$koleksi_id' OR peminjaman_detail.status IN ('tolak', 'lengkap'))
AND ((SELECT COUNT(*) FROM peminjaman_detail q WHERE q.koleksi_stok_kode = koleksi_stok.kode) < 1)
GROUP BY koleksi_stok.kode
LIMIT 1");

        if ($session_id) {
            if (in_array($row['id'], $session_id)) {
                $checked = 'checked';
            } else {
                $checked = '';
            }
        } else {
            $checked = '';
        }
    ?>
<?php if (mysqli_num_rows($koleksi_stok) > 0) {?>
<?php $data_stok = mysqli_fetch_assoc($koleksi_stok); ?>
                    <tr class="text-center">
                      <td class="align-middle">
                        <input type="checkbox" name="koleksi_stok_kode[]" value="<?php echo $data_stok['kode'];?>" <?php echo $checked;?>>
                      </td>
                      <td class="align-middle"><?php echo $row['judul'];?></td>
                      <td class="align-middle"><?php echo $row['nama'];?></td>
                      <td class="align-middle"><?php echo $row['total_stok'];?></td>
                    </tr>
                  <?php }?>
<?php }?>
              </tbody>
            </table>
          </div>
          <div class="col-12"><hr></div>
          <div class="col-12 text-end">
            <button type="submit" name="submit" class="btn btn-primary">Submit Data</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    $('.table').DataTable();
  });
</script>

<?php require 'footer.php'; ?>