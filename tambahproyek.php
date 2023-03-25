<?php 
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require "function.php";
// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {
        // cek keberhasilan input data
        /* function tambahdata dengan parameter semua data di element form 
        di ambil dan di masukkan ke fungsi tambah data yang akan di tangkap
        oleh $data */

        if(tambahdataProyek($_POST) > 0){
            echo "
                <script>
                alert('Data berhasil di tambahkan');
                document.location.href = 'indexlp.php';
                </script>
            ";
        } else {
            echo "<script>
                alert('Data GAGAL di tambahkan');
                document.location.href = 'indexlp.php';
                </script>
                ";
        }
    } 
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include 'kodelink.php'; ?>
    <title>Tambah Proyek</title>
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
          </ul>
        </div>
      </div>
    </nav>

    <section class="py-5">
      <div class="container">
        <h2 class="text-center mb-5" >Create Project</h2>
        <div class="row"> 
    <!-- //enctype untuk jalur gambar, method post untuk jalur text -->
            <form action="" method="post" enctype="multipart/form-data" >
            <table>
            <tr>
                        <td><strong><label for="">Nama Client</label></strong></td>
                        <td><input type="text" name="nama_client"></td>
                    </tr>
                    <tr>
                        <td><strong><label for="">Nama Proyek</label></strong></td>
                        <td><input type="text" name="nama_proyek"></td>
                    </tr>
                    <tr>
                        <td><strong><label for="lokasi">Lokasi Proyek</label></strong></td>
                    <td><input type="text" name="lokasi" id="lokasi"></td> </tr>
                    <tr>
                        <td><strong><label for="tgl">Tanggal Mulai</label></strong></td>
                        <td><input type="date" name="tgl_mulai"></td>
                    </tr>
                    <tr>
                        <td><strong><label for="tgl">Tanggal Selesai</label></strong></td>
                        <td><input type="date" name="tgl_selesai"></td>
                    </tr>
                    <tr>
                        <td><strong><label for="tgl">Status</label></strong></td>
                        <td>
                        <select name="status" id="status">
                             <option value="Scheduling">Scheduling</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Completed">Completed</option>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td><strong><label for="formFile" class="form-label">Gambar</label></strong></td>
                        <td><input class="form-control " type="file" name="file" id="formFile"></td>
                    </tr>
                           
           </table>        
           <button type="submit" name="submit" class="btn btn-primary">Tambah Data</button>
                    </form>
                    <?php include 'kodejs.php'; ?>
</body>
</html>