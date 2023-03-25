<?php
session_start();
    //set session agar masuk halaman melalui login
    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

require "function.php";
$proyekaktif = query("SELECT  * FROM tb_proyek p WHERE p.status = 'in progress'");
$proyefinished = query("SELECT  * FROM tb_proyek p WHERE p.status = 'completed'");

if (isset($_POST["cari"])) {
    $proyek = cari($_POST["keyword"]);
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Jasa Arsitek - Landing Page</title>
    <?php include 'kodelink.php'; ?>
      
</head>
  <body>
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
      <div class="container">
        <a class="navbar-brand" href="#">
            <img src="SIMETRI.png" class="logo d-inline-block align-top" alt="SIMETRI STUDIO">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Tentang Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#proyekkami">Proyek Kami</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Kontak</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="paketharga.php">Pricing</a>
            </li>
            <li class="nav-item">
              <a href="logout.php" type="button" class="btn btn-danger btn-sm">Logout</a>              
            </li>
          </ul>
        </div>
      </div>
    </nav>
    
    <!-- Jumbotron -->
    <div class="jumbotron jumbotron-fluid ">
      <div class="container">
        <h1 class="display-4">Jasa Arsitek Profesional</h1>
        <p class="lead">Bergabunglah dengan kami untuk mendapatkan desain arsitektur terbaik untuk rumah Anda.</p>
        <a href="tambahproyek.php" class="btn btn-success btn-lg">
          <i class="bi bi-plus-square"></i> Create Project
        </a>
        <a href="pekerjabaru.php" class="btn btn-info btn-lg">
          <i class="bi bi-plus-square"></i> Create New Worker
        </a>
      </div>
    </div>
    
    <!-- Services section -->
    <section class="py-5" id="proyekkami">
      <div class="container">
        <h2 class="text-center mb-5" >Project In Progress</h2>
        <div class="row"> 
          <?php foreach ($proyekaktif as $baris) {?> 
            <div class="col-md-4 mb-4">
              <div class="card text-bg-light h-100">
                <div class="card-body">
                  <img src="img/<?= $baris["gambar"]?>"  class="card-img-top img-fluid" alt="Foto Projek">
                  <h5 class="card-title"><?= $baris["nama_proyek"]?></h5>
                  <h6 ><?= $baris["nama_client"]?></h6>
                  <p class="card-text"><?= $baris["lokasi"]?></p>
                  <a href="dashboard.php?id=<?= $baris["id_proyek"]?>" class="btn btn-primary">Dashboard</a>
                </div>
              </div>
            </div>
            <?php }?>
        </div>
        <h2 class="text-center mb-5" >Project Completed</h2>
        <div class="row"> 
          <?php foreach ($proyefinished as $baris) {?> 
            <div class="col-md-4 mb-4">
              <div class="card text-bg-secondary h-100">
                <div class="card-body">
                  <img src="img/<?= $baris["gambar"]?>"  class="card-img-top img-fluid" alt="Foto Projek">
                  <h5 class="card-title"><?= $baris["nama_proyek"]?></h5>
                  <h6 >Nama Client</h6>
                  <p class="card-text"><?= $baris["lokasi"]?></p>
                  <a href="dashboard.php?id=<?= $baris["id_proyek"]?>" class="btn btn-primary">Dashboard</a>
                </div>
              </div>
            </div>
            <?php }?>
        </div>
      </div>
    </section>
    <!-- Testimonials section -->
<section class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-5">Testimoni Pelanggan</h2>
    <div class="row">
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <p class="card-text">"Terima kasih Jasa Arsitek atas desain rumah yang indah dan fungsional. Kami sangat puas dengan hasilnya."</p>
            <h6 class="card-subtitle mb-2 text-muted">John Doe</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <p class="card-text">"Saya merekomendasikan Jasa Arsitek kepada siapa saja yang membutuhkan jasa desain arsitektur yang profesional dan terpercaya."</p>
            <h6 class="card-subtitle mb-2 text-muted">Jane Doe</h6>
          </div>
        </div>
      </div>
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <div class="card-body">
            <p class="card-text">"Proses kerja dengan Jasa Arsitek sangat mudah dan lancar. Hasilnya juga sesuai dengan ekspektasi kami."</p>
            <h6 class="card-subtitle mb-2 text-muted">David Smith</h6>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Contact section -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5">Hubungi Kami</h2>
    <div class="row">
      <div class="col-md-6 mx-auto">
        <form>
          <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" class="form-control" id="name">
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email">
          </div>
          <div class="mb-3">
            <label for="message" class="form-label">Pesan</label>
            <textarea class="form-control" id="message" rows="5"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Kirim</button>
        </form>
      </div>
    </div>
  </div>
</section>
<?php include 'kodejs.php'; ?>
</body>
</html>
