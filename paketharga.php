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
    
    
    
    <!-- Services section -->
    <section class="py-5" id="paketharga">
      <div class="container">
        <div class="row">
            <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Paket Bronze</h5>
                <h6 class="card-subtitle mb-2 text-muted">Rp50.000/m2</h6>
                <p class="card-text">Paket ini mencakup design rumah dengan gaya minimalis sederhana, termasuk 3D rendering dan gambar kerja.</p>
                <a href="#" class="btn btn-primary">Pilih Paket</a>
                </div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Paket Silver</h5>
                <h6 class="card-subtitle mb-2 text-muted">Rp75.000/m2</h6>
                <p class="card-text">Paket ini mencakup design rumah dengan gaya modern, termasuk 3D rendering, gambar kerja, dan desain interior.</p>
                <a href="#" class="btn btn-primary">Pilih Paket</a>
                </div>
            </div>
            </div>
            <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                <h5 class="card-title">Paket Gold</h5>
                <h6 class="card-subtitle mb-2 text-muted">Rp100.000/m2</h6>
                <p class="card-text">Paket ini mencakup design rumah dengan gaya eksklusif, termasuk 3D rendering, gambar kerja, desain interior, dan konsep landscape.</p>
                <a href="#" class="btn btn-primary">Pilih Paket</a>
                </div>
            </div>
            </div>
        </div>
        </div>

    </section>
    


<?php include 'kodejs.php'; ?>
</body>
</html>
