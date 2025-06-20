<?php 

require 'header.php';

if(isset($_POST['submit'])) {
  if(!isset($_SESSION['fo_id'])) {
    echo '<script>alert("Mohon login terlebih dahulu")</script>';
    echo '<script>document.location.href="masuk.php"</script>';
    die;
  }

  $nama  = $_POST['nama'];
  $email = $_POST['email'];
  $pesan = $_POST['pesan'];
  $uuid  = uuid();

  mysqli_query($conn, "INSERT INTO kritik_saran VALUES ('$uuid', '$nama', '$email', '$pesan')");
  echo '<script>alert("Pesan telah terkirim!")</script>';
  echo '<script>document.location.href="' . $base_url . '"</script>';
}

?>
<div class="container">
  <div class="row mt-4">
    <div class="col-md-12">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
          <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img src="archive/banner-1.jpg" class="d-block w-100" style="max-height:600px;">
          </div>
          <div class="carousel-item">
            <img src="archive/banner-2.jpg" class="d-block w-100" style="max-height:600px;">
          </div>
          <div class="carousel-item">
            <img src="archive/banner-3.jpg" class="d-block w-100" style="max-height:600px;">
          </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="visually-hidden">Next</span>
        </button>
      </div>
    </div>
  </div>
  <div class="row mt-5 mb-5">
    <div class="col-md-5">
      <h4 class="mb-3">Kritik & Saran</h4>
      <div class="card">
        <div class="card-body">
          <form action="" class="row g-3" method="POST">
            <div class="col-12">
              <label>Nama :</label>
              <input type="text" name="nama" id="nama" class="form-control" placeholder="Masukan nama" required>
            </div>
            <div class="col-12">
              <label>Email :</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="Masukan email" required>
            </div>
            <div class="col-12">
              <label>Pesan :</label>
              <textarea name="pesan" id="pesan" class="form-control" placeholder="Masukan pesan" required></textarea>
            </div>
            <div class="col-12">
              <div class="text-end">
                <button type="submit" name="submit" value="submit" class="btn btn-success">Kirim</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-7">
      <h4 class="mb-3">Lokasi</h4>
      <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d246.88967936773102!2d111.9219761!3d-8.0775119!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e78e30ea6877ccd%3A0x450dff8d9025c326!2sUniversitas%20Bhinneka%20PGRI%20Tulungagung!5e0!3m2!1sid!2sid!4v1750351075206!5m2!1sid!2sid" width="100%" height="325" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
    </div>
  </div>
</div>
<div class="card bg-primary" style="border-radius:0;">
  <div class="card-body">
    <div class="row">
      <div class="col-md-6">
        <div class="text-center">
          <h5 class="text-white">Kontak</h5>
          <p class="text-white">
          Universitas Bhinneka PGRI Tulungagung.<br> Alamat lokasi: Jl. Mayor Sujadi No.7<br>
          Tulungagung, Kode Pos 66229.<br>
            Email : info@ubhi.ac.id
          </p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="text-center">
          <h5 class="text-white">Jam Operasional</h5>
          <p class="text-white">
            Senin - Jum'at (08.00 - 17.00)<br>
            Sabtu - Minggu (Libur)
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php require 'footer.php'; ?>