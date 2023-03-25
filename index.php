<?php
session_start();
    //set session agar masuk halaman melalui login
    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }

require "function.php";
$proyek = query("SELECT  * FROM tb_proyek");

if (isset($_POST["cari"])) {
    $proyek = cari($_POST["keyword"]);
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coba Database</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>
<body>
    <a href="logout.php" type="button" class="btn btn-danger btn-lg">Logout</a>
    <?php foreach ($proyek as $baris) {?>
    <div class="card" style="width: 18rem; ">
    <img src="img/<?= $baris["gambar"]?>" class="card-img-top" alt="Foto Projek">
    <div class="card-body">
        <h4 class="card-title"><?= $baris["nama_proyek"]?></h4>
        <h6 >Nama Client</h6>
        <p class="card-text"><?= $baris["lokasi"]?></p>
        <a href="#" class="btn btn-primary">Dashboard</a>
  </div>
</div>
<?php }?>
        <a href="tambahproyek.php" type="button" class="btn btn-primary btn-lg">Tambah Proyek</a>
    <form action="" method="post">
        <input type="text" name="keyword" id="keyword" autofocus 
        placeholder="masukkan data yang ingin di cari" size="40" autocomplete="off">
        <button class="btn btn-success" type="submit" name="cari">Cari Data!</button>
    </form>
    <table class="table table-striped table-hover">
        <tr>
        <th>No.</th>
        <th>Gambar</th>
        <th>Nama Proyek</th>
        <th>Lokasi Proyek</th>
        <th>Tgl Mulai</th>
        <th>Aksi</th>
        </tr>
        <?php $i = 1 ?>
        <?php foreach ($proyek as $baris) {?>
        <tr>
        <td><?= $i ?></td>
        <td><?= $baris["gambar"]?></td>
        <td><?= $baris["nama_proyek"]?></td>
        <td><?= $baris["lokasi"]?></td>
        <td><?= date('d/m/Y', strtotime($baris["tgl_mulai"])) ?></td>
        
        <!-- hapus pakai GET dengan di sandarkan id dalam data base -->
        <!-- atribut onclik java script untuk konfirmasi  -->
        <td><a class="btn btn-warning" href="ubah.php?id=<?= $baris["id_proyek"]?>">ubah</a> <a class="btn btn-danger" href="hapus.php?id=<?= $baris["id_proyek"]?>" onclick="return confirm('Yakin?');">hapus</a></td>
        </tr>

        <?php $i++; }?>
    </table>
         
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>