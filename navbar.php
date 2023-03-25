<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
        <img src="SIMETRI.png" class="logo d-inline-block align-top" alt="SIMETRI STUDIO">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <div class="collapse navbar-collapse" id="navbarNav">
      
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="dashboard.php?id=<?= $id?>">Beranda</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tambahorder.php?id=<?= $id?>">Order Material</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tampilabsen.php?id=<?= $id?>">Absensi</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="report.php?id=<?= $id?>">Report Cash Flow </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="indexlp.php">Kembali</a>
        </li>
      </ul>
      
    </div>
    
  </div>
</nav>