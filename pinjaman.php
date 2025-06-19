<?php 

require 'header.php'; 

if(!isset($_SESSION['fo_id'])) {
  echo '<script>document.location.href="masuk.php"</script>';
}

$user_id    = $_SESSION['fo_id'];
$peminjaman = mysqli_query($conn, "SELECT * FROM peminjaman WHERE user_id = '$user_id'");

?>
<div class="container">
  <div class="mt-5 mb-5">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <div class="mb-5">
            <span style="font-size:20px;">Pinjaman Saya</span>
            <span class="float-end">
              <a href="tambah_peminjaman.php" class="btn btn-primary">Tambah</a>
            </span>
          </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-striped table-hover">
            <thead>
              <tr class="text-center">
                <th>No</th>
                <th>Kode</th>
                <th>Tanggal Pinjam</th>
                <th>Pengembalian</th>
                <th>Status</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php $no = 1; ?>
              <?php while($row = mysqli_fetch_assoc($peminjaman)) { ?>
                <tr class="text-center">
                  <td class="align-middle"><?= $no; ?></td>
                  <td class="align-middle"><?= $row['kode']; ?></td>
                  <td class="align-middle"><?= date('d F Y', strtotime($row['tanggal_pinjam'])); ?></td>
                  <td class="align-middle">
                    <?php if($row['status'] == 'ditolak' || $row['status'] == 'pengajuan') { ?>
                      -
                    <?php } else if($row['status'] == 'selesai') { ?>
                      Telah Dikembalikan
                    <?php } else { ?>
                      Belum Dikembalikan
                    <?php } ?>
                  </td>
                  <td class="align-middle"><?= ucwords($row['status']); ?></td>
                  <td class="align-middle">
                    <a href="detail_pinjaman.php?id=<?= $row['id']; ?>" title="Detail" class="btn btn-info btn-sm">Detail</a>
                  </td>
                </tr>
              <?php $no++; } ?>
            </tbody>
          </table>
        </div>
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