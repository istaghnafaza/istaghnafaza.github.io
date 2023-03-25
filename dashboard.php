<?php 
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require "function.php";

//ambil data dari url
$id = $_GET["id"];

//query data proyek berdasarkan id
$proyek = query("SELECT * FROM tb_proyek WHERE id_proyek = $id")[0];
$pekerja = query("SELECT p.nama_pekerja AS 'Nama Pekerja', k.nama_kategori AS 'Kategori Pekerja'
                FROM tbl_pivot_pekerjaproyek u 
                JOIN tb_pekerja p ON u.id_pekerja = p.id_pekerja 
                JOIN kategori_pekerja k ON p.id_kategoripekerja = k.id 
                WHERE id_proyek = $id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <?php include 'kodelink.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>

<section class="py-5" id="project-detail">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h2>Proyek <?= $proyek["nama_proyek"]?></h2>
        <p><strong>Nama Klien:</strong> <?= $proyek["nama_client"]?></p>
        <p><strong>Lokasi:</strong> <?= $proyek["lokasi"]?></p>
        <p><strong>Tanggal Mulai:</strong> <?= $proyek["tgl_mulai"]?></p>
        <p><strong>Tanggal Selesai:</strong> <?= $proyek["tgl_selesai"]?></p>
        <p><strong>Deskripsi:</strong> Proyek pembangunan gedung perkantoran 5 lantai dengan luas bangunan 2000 m²</p>
        <p><strong>Status:</strong> <?= $proyek["status"]?></p>
        <a type="button" class="btn btn-warning" href="ubahproyek.php?id=<?= $proyek["id_proyek"]?>">
            <i class="bi bi-pencil"></i> Edit Data
        </a>
        <a type="button" class="btn btn-danger"  href="hapusproyek.php?id=<?= $proyek["id_proyek"]?>" onclick="return confirm('Yakin?');">
            <i class="bi bi-trash"></i> Hapus Data
        </a>
      </div>
      <div class="col-md-6">
        <img src="img/<?= $proyek["gambar"]?>" class="img-fluid rounded" alt="Proyek A">
      </div>
    </div>
  </div>
</section>

<section class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <h3 class="text-center">Team Project</h3>
        <div class="table-responsive mx-auto my-3">
          <a href="tambahpekerja.php?id=<?= $proyek["id_proyek"]?>" class="btn btn-success btn-sm">
          <i class="bi bi-plus-square"></i> Add / Create Team
          </a>
          <table class="table table-striped table-hover" >
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Pekerja</th>
                <th>Kategori Pekerja</th>
              </tr>
              </thead>
              <tbody>
               <?php $i = 1 ?>
              <?php foreach ($pekerja as $baris) {?>
                <tr>
                <td><?= $i ?></td>
                <td><?= $baris["Nama Pekerja"]?></td>
                <td><?= $baris["Kategori Pekerja"]?></td>
                </tr>
              <?php $i++; }?>
              
              </tbody>
            </table>
        </div>
      </div>
      <div class="col-md-6">
            
      </div>
    </div>
  </div>
</section>
<?php include 'kodejs.php'; ?>

</body>
</html>