<?php 
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require "function.php";
//ambil data dari url

//query data proyek berdasarkan id
$kategori = query("SELECT * FROM kategori_pekerja");
$plotpekerja = query("SELECT p.id_pekerja AS 'id pekerja', p.nama_pekerja, k.nama_kategori
FROM tb_pekerja p
JOIN kategori_pekerja k ON p.id_kategoripekerja = k.id 
");
$pekerja = query("SELECT * FROM tb_pekerja")[0];
// var_dump($pekerja);die;
// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {
        // cek keberhasilan input data
        /* function tambahdata dengan parameter semua data di element form 
        di ambil dan di masukkan ke fungsi tambah data yang akan di tangkap
        oleh $data */

        if(tambahPekerjaBaru($_POST) != 0){
            echo "
                <script>
                alert('Data berhasil di tambahkan');
                </script>
            ";
            header('Location: pekerjabaru.php');
            exit();
        } else {
            echo "<script>
                alert('Data GAGAL di tambahkan');
                </script>
                ";
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    <script>
        function aktifDropdown() {
        // Mengambil elemen radio button dan dropdown dengan nama yang sama
        var radioKategoriBaru = document.getElementById("radio-kategoribaru");
        var radioKategori = document.getElementById("radio-existing");
        var dropdownKategori = document.getElementById("dropdown-kategori");
        var textKategori = document.getElementById("text-kategori");

        // Menghapus nilai dropdown jika radio button yang lain dipilih
        if (!radioKategori.checked) {
            dropdownKategori.selectedIndex = 0;
        }
        if (!radioKategoriBaru.checked) {
            textKategori.selectedIndex = 0;
        }

        // Mengaktifkan dropdown jika radio button dipilih
        if (radioKategori.checked) {
            dropdownKategori.disabled = false;
            textKategori.disabled = true;
        }
        // Menonaktifkan dropdown jika radio button tidak dipilih
        else {
            dropdownKategori.disabled = true;
            textKategori.disabled = false;
        }
        // Mengaktifkan dropdown jika radio button dipilih
        // if (radioKategoriBaru.checked) {
            
        // }
        // // Menonaktifkan dropdown jika radio button tidak dipilih
        // else {
            
        // }
        }
    </script>
    <title>Tambah Pekerja</title>
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
              <a class="nav-link active" aria-current="page" href="indexlp.php">Home</a>
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
        <h2 class="text-center " >Tambahkan Pekerja Baru</h2>
        <div class="row"> 
    <!-- //enctype untuk jalur gambar, method post untuk jalur text -->
            <form method="post" action="">
                <div class="row my-3">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="id_proyek" name="id_proyek" value="<?= $proyek["id_proyek"]?>">
                        </div>
                        <div class="mb-3">
                            <label for="id_pekerja" class="form-label">Nama Pekerja</label>
                            <input type="text" class="form-control" id="nama_pekerja" name="nama_pekerja">
                        </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Pekerja</label>
                            <br>
                            <input class="form-check-input" type="radio" name="kategori" id="radio-existing" value="existing" onclick="aktifDropdown()" onchange="aktifDropdown()"> Cari Kategori
                            <div class="form-group">
                            <select class="form-select" id="dropdown-kategori" name="id_kategoripekerja" disabled>
                                <option value="">Pilih Kategori Pekerja</option>
                                <?php foreach ($kategori as $baris) {?>
                                <option value="<?= $baris['id']?>">
                                    <?= $baris["nama_kategori"]?>
                                </option>
                                <?php }?>
                            </select>
                            </div>
                        </div>
                        <div class="mb-3">
                        <input class="form-check-input" type="radio" name="kategori" id="radio-kategoribaru" value="existing" onclick="aktifDropdown()" onchange="aktifDropdown()">Kategori Baru
                        <input type="text" class="form-control" id="text-kategori" name="id_kategoripekerja" disabled>
                        </div>
                        <div class="mb-3">
                            <div class="form-group">
                            <label for="notelp">Nomor Handphone</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">+62</span>
                                </div>
                                <input type="tel" class="form-control" id="notelp" name="notelp" placeholder="Contoh: 81234567890" aria-describedby="basic-addon1">
                            </div>
                            </div>

                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <input type="text" class="form-control" id="keterangan" name="keterangan">
                        </div>                        
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <div class="col-md-8">
                        <h3 class="text-center">Team Project</h3>
                       
                        <table  id="absenTable" class="table table-striped table-hover" responsive >
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Pekerja</th>
                                <th>Kategori Pekerja</th>                                
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1 ?>
                            <?php foreach ($plotpekerja as $baris) {?>
                                <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= $baris["nama_pekerja"]?></td>
                                <td class="text-center"><?= $baris["nama_kategori"]?></td>                                
                                <td class="text-center"><a type="button" class="btn btn-warning btn-sm" href="ubahpekerja.php?id=<?= $baris["id pekerja"]?>">
                                        <i class="bi bi-pencil"></i> Edit Data
                                    </a>
                                    <a type="button" class="btn btn-danger btn-sm"  href="hapuspekerja.php?id=<?= $baris["id pekerja"]?>" onclick="return confirm('Yakin?');">
                                        <i class="bi bi-trash"></i> Hapus Data
                                    </a>
                                </td>
                                </tr>
                            <?php $i++; }?>
                            
                            </tbody>
                            </table>
                        
                    </div>
                </div>
            

            <?php include 'kodejs.php'; ?>
        
        <script>
                $(document).ready(function() { 
                
                    var table = $('#absenTable').DataTable( {
                    lengthChange: false,
                    buttons: [
                    {
                        extend: 'pdf',
                        title: 'List Pekerja',
                        split: [ 'csv', 'excel'],
                    },
                    'colvis'
                    ]
                    } );
        
                    table.buttons().container()
                        .appendTo( '#absenTable_wrapper .col-md-6:eq(0)' );
                    } );
                    
            </script>
</body>
</html>