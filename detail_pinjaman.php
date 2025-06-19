<?php 

require 'header.php'; 

$id         = $_GET['id'];
$peminjaman = mysqli_fetch_assoc(mysqli_query($conn, "SELECT peminjaman.*, user.nama FROM peminjaman JOIN user ON user.id = peminjaman.user_id WHERE peminjaman.id = '$id'"));

$peminjaman_detail = mysqli_query($conn, "SELECT peminjaman_detail.id, peminjaman_detail.denda_terlambat, peminjaman_detail.denda_lainnya, koleksi.judul, koleksi_stok.kode
FROM peminjaman_detail
JOIN koleksi_stok ON koleksi_stok.kode = peminjaman_detail.koleksi_stok_kode
JOIN koleksi ON koleksi.id = koleksi_stok.koleksi_id
JOIN penerbit ON penerbit.id = koleksi.penerbit_id
WHERE peminjaman_detail.peminjaman_id = '$id'");


if(!isset($id) || !$peminjaman || !isset($_SESSION['fo_id'])) {
  echo '<script>alert("Data tidak ditemukan!")</script>';
  echo '<script>document.location.href="' . $base_url . '"</script>';
}

?>
<div class="container">
  <div class="mt-5 mb-5">
    <div class="card">
      <div class="card-body">
        <div class="card-title">
          <div class="mb-5">
            <span style="font-size:20px;">Detail Peminjaman</span>
            <span class="float-end">
              <a href="pinjaman.php" class="btn btn-secondary">Kembali</a>
            </span>
          </div>
        </div>
        <table cellspacing="0" cellpadding="10" width="100%">
          <tbody>
            <tr>
              <td class="align-middle" width="15%">Kode</td>
              <td>: <?= $peminjaman['kode']; ?></td>
            </tr>
            <tr>
              <td class="align-middle" width="15%">User</td>
              <td>: <?= $peminjaman['nama']; ?></td>
            </tr>
            <tr>
              <td class="align-middle" width="15%">Tanggal Pinjam</td>
              <td>: <?= date('d M Y', strtotime($peminjaman['tanggal_pinjam'])); ?></td>
            </tr>
            <tr>
              <td class="align-middle" width="15%">Jatuh Tempo</td>
              <td>: 
                <?= $peminjaman['jatuh_tempo'] ? date('d M Y', strtotime($peminjaman['jatuh_tempo'])) : '-'; ?>
              </td>
            </tr>
            <?php if($peminjaman['perpanjangan']) { ?>
              <tr>
                <td class="align-middle" width="15%">Perpanjangan</td>
                <td>: 
                  <?= $peminjaman['perpanjangan'] ? $peminjaman['perpanjangan'] . ' Hari' : 'Belum Perpanjangan'; ?>
                </td>
              </tr>
            <?php } ?>
            <tr>
              <td class="align-middle" width="15%">Status</td>
              <td>: <?= ucwords($peminjaman['status']); ?></td>
            </tr>
            <tr>
              <td class="align-middle" width="15%">Pengembalian</td>
              <td>: 
                <?php if($peminjaman['status'] == 'ditolak' || $peminjaman['status'] == 'pengajuan') { ?>
                  -
                <?php } else if($peminjaman['status'] == 'selesai') { ?>
                  Telah Dikembalikan
                <?php } else { ?>
                  Belum Dikembalikan
                <?php } ?>
              </td>
            </tr>
          </tbody>
        </table>
        <div class="clearfix"><hr></div>
        <table class="table table-bordered table-striped">
          <thead>
            <tr class="text-center">
              <th>Koleksi</th>
              <th>Kode</th>
              <th>Denda Keterlambatan</th>
              <th>Denda Lainnya</th>
            </tr>
          </thead>
          <tbody>
            <?php while($row = mysqli_fetch_assoc($peminjaman_detail)) { ?>
              <tr class="text-center">
                <td class="align-middle">
                  <?= $row['judul']; ?>
                </td>
                <td class="align-middle">
                  <?= $row['kode']; ?>
                </td>
                <td class="align-middle">
                  Rp <?= number_format($row['denda_terlambat'], 0, ',', '.'); ?>
                </td>
                <td class="align-middle">
                  Rp <?= number_format($row['denda_lainnya'], 0, ',', '.'); ?>
                </td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
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