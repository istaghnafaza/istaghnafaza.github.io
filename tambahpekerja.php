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
$plotpekerja = query("SELECT p.id_pekerja, p.nama_pekerja, k.nama_kategori
FROM tb_pekerja p
JOIN kategori_pekerja k ON p.id_kategoripekerja = k.id 
");
$pekerja = query("SELECT u.id AS 'id pivot', p.nama_pekerja AS 'Nama Pekerja', b.nama_kategori AS 'Kategori Pekerja', u.upah AS 'Upah Harian'
                FROM tbl_pivot_pekerjaproyek u 
                JOIN tb_pekerja p ON u.id_pekerja = p.id_pekerja 
                JOIN kategori_pekerja b ON p.id_kategoripekerja = b.id
                WHERE id_proyek = $id");
// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {
        // cek keberhasilan input data
        /* function tambahdata dengan parameter semua data di element form 
        di ambil dan di masukkan ke fungsi tambah data yang akan di tangkap
        oleh $data */

        if(tambahdataPekerja($_POST) != 0){
            echo "
                <script>
                alert('Data berhasil di tambahkan');
                </script>
            ";
            header('Location: tambahpekerja.php?id=' . urlencode($id));
            exit();
        } else {
            echo "<script>
                alert('Data GAGAL di tambahkan');
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
    
    <title>Tambah Pekerja</title>
</head>
<body>
    <!-- Navigation bar -->
   <?php include 'navbar.php'; ?>

    <section class="py-5">
      <div class="container">
        <h2 class="text-center " >Tambahkan Team</h2>
        <h3 class="text-center mb-5" >Project <?= $proyek["nama_proyek"]?></h3>
        <div class="row"> 
    <!-- //enctype untuk jalur gambar, method post untuk jalur text -->
            <form method="post" action="">
                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <input type="hidden" class="form-control" id="id_proyek" name="id_proyek" value="<?= $proyek["id_proyek"]?>">
                        </div>
                        <div class="mb-3">
                            <label for="id_pekerja" class="form-label">Nama Pekerja</label>
                                <div class="form-group">
                                <select class="selectpicker form-control" data-live-search="true" name="id_pekerja" required>
                                    <option value="">Pilih Pekerja</option>
                                    <?php foreach ($plotpekerja as $baris) {?>
                                    <option value="<?= $baris["id_pekerja"]?>" data-kategori="<?= $baris["nama_kategori"]?>"> <?= $baris["nama_pekerja"]?></option>
                                    <?php }?>
                                </select>
                                </div>
                            </div>
                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori Pekerja</label>
                            <input type="text" class="form-control" id="kategori" name="kategori" value="<?= $baris["nama_kategori"]?>" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="upah" class="form-label">Upah</label>
                            <input type="text" class="form-control" id="upah" name="upah">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai">
                        </div>
                        <div class="mb-3">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai">
                        </div>
                            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    <div class="col-md-8">
                        <h3 class="text-center">Team Project</h3>
                        <div class="table-responsive mx-auto my-3">
                        <table  class="table table-striped table-hover" >
                            <thead>
                            <tr class="text-center">
                                <th>No</th>
                                <th>Nama Pekerja</th>
                                <th>Kategori Pekerja</th>
                                <th>Upah Harian</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $i = 1 ?>
                            <?php foreach ($pekerja as $baris) {?>
                                <tr>
                                <td class="text-center"><?= $i ?></td>
                                <td><?= $baris["Nama Pekerja"]?></td>
                                <td class="text-center"><?= $baris["Kategori Pekerja"]?></td>
                                <td class="text-center"><?= $baris["Upah Harian"]?></td>
                                <td class="text-center"><a type="button" class="btn btn-warning btn-sm" href="ubahpekerjaproyek.php?id=<?= $baris["id pivot"]?>&idproyek=<?= $proyek["id_proyek"]?>">
                                        <i class="bi bi-pencil"></i> Edit Data
                                    </a>
                                    <a type="button" class="btn btn-danger btn-sm"  href="hapuspekerjaproyek.php?idpivot=<?= $baris["id pivot"]?>&idproyek=<?= $proyek["id_proyek"]?>" onclick="return confirm('Yakin?');">
                                        <i class="bi bi-trash"></i> Hapus Data
                                    </a>
                                </td>
                                </tr>
                            <?php $i++; }?>
                            
                            </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            

            <?php include 'kodejs.php'; ?>
             <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
        <script>
            $(document).ready(function() {
                // Ketika nilai dropdown berubah
                $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
                // Ambil nilai kategori dari opsi yang dipilih
                var kategori = $('option:selected', this).attr('data-kategori');
                // Set nilai input kategori dengan nilai kategori yang diperoleh
                $('#kategori').val(kategori);
                });
                $('.autonumeric').autoNumeric('init', {
                aSep: '.',
                aDec: ',',
                mDec: 0
                });
            });
        </script>

</body>
</html>