<?php
require "function.php";
$id = $_GET["id"];

$proyek = query("SELECT u.nama_proyek FROM tb_proyek u WHERE u.id_proyek = $id")[0];
$pekerja = query("SELECT p.nama_pekerja AS 'Nama Pekerja' , s.id_pekerja , id_proyek
                  FROM tbl_pivot_pekerjaproyek s 
                  JOIN tb_pekerja p ON p.id_pekerja = s.id_pekerja  
                  WHERE id_proyek = $id");

// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {
        // cek keberhasilan input data
        /* function tambahdata dengan parameter semua data di element form 
        di ambil dan di masukkan ke fungsi tambah data yang akan di tangkap
        oleh $data */
        if(tambahdataAbsensi($_POST) != 0){
            echo "
                <script>
                alert('Data berhasil di tambahkan');
                </script>
            ";
            
        } else {
            echo "<script>
                alert('Data GAGAL di tambahkan');
                document.location.href = 'absensi.php';
                </script>
                ";
        }
    } 
if (!isset($_POST['filter'])){
  $filter ="Menampilkan Data Absen Keseluruhan";
  $keteranganmingguan = query("SELECT tb_pekerja.nama_pekerja AS 'Nama Pekerja',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 2 THEN a.keterangan ELSE NULL END) AS 'Senin',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 3 THEN a.keterangan ELSE NULL END) AS 'Selasa',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 4 THEN a.keterangan ELSE NULL END) AS 'Rabu',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 5 THEN a.keterangan ELSE NULL END) AS 'Kamis',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 6 THEN a.keterangan ELSE NULL END) AS 'Jumat',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 7 THEN a.keterangan ELSE NULL END) AS 'Sabtu'
FROM tb_absen a JOIN tb_pekerja ON tb_pekerja.id_pekerja = a.id_pekerja
WHERE id_proyek = $id AND DAYOFWEEK(tanggal) BETWEEN 2 AND 7
AND tanggal BETWEEN DATE_SUB(CURDATE(), INTERVAL DAYOFWEEK(CURDATE())-2 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY)
GROUP BY a.id_pekerja");
  $rekapabsenmingguan = query("SELECT 
  u.id_pekerja, 
  y.nama_proyek AS 'Nama Proyek',
  p.nama_pekerja AS 'Nama Pekerja', 
  SUM(
      CASE a.keterangan 
      WHEN 'Hadir' THEN 1
      WHEN 'Tidak Hadir' THEN 0
      WHEN '7' THEN 0.88
      WHEN '6' THEN 0.75
      WHEN '5' THEN 0.62
      WHEN '4' THEN 0.50
      WHEN '3' THEN 0.38
      WHEN '2' THEN 0.25
      WHEN '1' THEN 0.12
      END
      ) AS 'Jumlah Absen', 
  FORMAT(u.upah, '#,##0') AS 'Upah Harian', 
  k.nama_kategori AS 'Kategori Pekerja', 
  FORMAT(SUM(
      CASE a.keterangan 
      WHEN 'Hadir' THEN 1
      WHEN 'Tidak Hadir' THEN 0
      WHEN '7' THEN 0.88
      WHEN '6' THEN 0.75
      WHEN '5' THEN 0.62
      WHEN '4' THEN 0.50
      WHEN '3' THEN 0.38
      WHEN '2' THEN 0.25
      WHEN '1' THEN 0.12
      END
      ) * u.upah, '#,##0') AS 'Total Upah' 
FROM 
  tbl_pivot_pekerjaproyek u 
  JOIN tb_absen a ON u.id_proyek = a.id_proyek AND u.id_pekerja = a.id_pekerja 
  JOIN tb_pekerja p ON u.id_pekerja = p.id_pekerja 
  JOIN tb_proyek y ON u.id_proyek = y.id_proyek 
  JOIN kategori_pekerja k ON p.id_kategoripekerja = k.id 
WHERE 
  u.id_proyek = $id  
GROUP BY 
  u.id_pekerja;
");
} else{
  $tgl_start = $_POST['tgl_start'];
  $tgl_end= $_POST['tgl_end'];
  $hari = date('l', strtotime($tgl_start));
  $hari_indonesia = str_replace(
      ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'], 
      ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'], 
      $hari
  );
  // konversi ke format yang diinginkan
  $tanggal_mulai = date("d/m/Y", strtotime($tgl_start));
  $tanggal_selesai = date("d/m/Y", strtotime($tgl_end));

  $filter = "Dari $hari_indonesia tgl $tanggal_mulai  - $hari_indonesia tgl $tanggal_selesai";
  $keteranganmingguan = query("SELECT tb_pekerja.nama_pekerja AS 'Nama Pekerja',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 2 THEN a.keterangan ELSE NULL END) AS 'Senin',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 3 THEN a.keterangan ELSE NULL END) AS 'Selasa',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 4 THEN a.keterangan ELSE NULL END) AS 'Rabu',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 5 THEN a.keterangan ELSE NULL END) AS 'Kamis',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 6 THEN a.keterangan ELSE NULL END) AS 'Jumat',
       MAX(CASE WHEN DAYOFWEEK(tanggal) = 7 THEN a.keterangan ELSE NULL END) AS 'Sabtu'
FROM tb_absen a JOIN tb_pekerja ON tb_pekerja.id_pekerja = a.id_pekerja
WHERE id_proyek = $id AND DAYOFWEEK(tanggal) BETWEEN 2 AND 7
AND tanggal BETWEEN DATE_SUB(CURDATE(), INTERVAL DAYOFWEEK(CURDATE())-2 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY)
GROUP BY a.id_pekerja;
"); 
  $rekapabsenmingguan = query("SELECT 
  p.nama_pekerja AS 'Nama Pekerja', 
  SUM(
      CASE a.keterangan 
      WHEN 'Hadir' THEN 1
      WHEN 'Tidak Hadir' THEN 0
      WHEN '7' THEN 0.88
      WHEN '6' THEN 0.75
      WHEN '5' THEN 0.62
      WHEN '4' THEN 0.50
      WHEN '3' THEN 0.38
      WHEN '2' THEN 0.25
      WHEN '1' THEN 0.12
      END
      ) AS 'Jumlah Absen', 
  FORMAT(u.upah, '#,##0;') AS 'Upah Harian', 
  k.nama_kategori AS 'Kategori Pekerja', 
  FORMAT(SUM(
      CASE a.keterangan 
      WHEN 'Hadir' THEN 1
      WHEN 'Tidak Hadir' THEN 0
      WHEN '7' THEN 0.88
      WHEN '6' THEN 0.75
      WHEN '5' THEN 0.62
      WHEN '4' THEN 0.50
      WHEN '3' THEN 0.38
      WHEN '2' THEN 0.25
      WHEN '1' THEN 0.12
      END
      ) * u.upah, '#,##0;') AS 'Total Upah' 
FROM 
  tbl_pivot_pekerjaproyek u 
  JOIN tb_absen a ON u.id_proyek = a.id_proyek AND u.id_pekerja = a.id_pekerja 
  JOIN tb_pekerja p ON u.id_pekerja = p.id_pekerja 
  JOIN kategori_pekerja k ON p.id_kategoripekerja = k.id 
WHERE 
  u.id_proyek = $id AND
  a.tanggal BETWEEN '$tgl_start' AND '$tgl_end' 
GROUP BY 
  u.id_pekerja;
");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- datatables
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/css/bootstrap.min.css"> -->

    <title>Tampil Absensi</title>
    <?php include 'kodelink.php'; ?>
     <script>
    function aktifDropdown(id) {
      // Mengambil elemen radio button dan dropdown dengan id sesuai parameter
      var radioTelat = document.getElementById("radio-telat-" + id);
      var dropdownTelat = document.getElementById("dropdown-telat-" + id);

      // Menghapus nilai dropdown jika radio button yang lain dipilih
      if (!radioTelat.checked) {
        dropdownTelat.selectedIndex = 0;
        dropdownTelat.hidden = true;
      }

      // Mengaktifkan dropdown jika radio button dipilih
      if (radioTelat.checked) {
        dropdownTelat.disabled = false;
        dropdownTelat.hidden = false;
      }
      // Menonaktifkan dropdown jika radio button tidak dipilih
      else {
        dropdownTelat.disabled = true;
        dropdownTelat.hidden = true;
      }
    }
    function munculDropdown(id) {
      
      var radioLembur = document.getElementById("radio-lembur-" + id);
      var dropdownLembur = document.getElementById("dropdown-lembur-" + id);

      
      if (!radioLembur.checked) {
        dropdownLembur.hidden = true;
      }

      
      if (radioLembur.checked) {
        dropdownLembur.hidden = false;
      }
      
      else {
        dropdownLembur.hidden = true;
      }
    }
    </script>
  </head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="row">
      <h1 class="text-center mb-5" >Project <?= $proyek["nama_proyek"]?></h1>
       <div class="col-md-6">
      <div class="container">
        
          <div class="mb-3"> 
              <h3>Form Absensi Pekerja</h3>
              <form action="" method="post">
                <label for="tanggal">Tanggal Absensi:</label>
                <input type="date" name="tanggal" id="tanggal" required>
                <table class="table table-striped table-hover" responsive>
                    <thead>
                    <tr>
                      <th>Nama Pekerja</th>
                      <th>Absensi</th>
                    </tr>
                  </thead>
                  <tbody>
                        <!-- Loop untuk menampilkan data pekerja -->
                        <?php foreach ($pekerja as $row) { ?>
                          <tr>
                            <td><?=$row["Nama Pekerja"]?></td>
                            <td name="proyek" hidden><?=$row["id_proyek"]?></td>
                            <td>
                              <input type="hidden" name="proyek[<?=$row['id_pekerja']?>]" value="<?=$row['id_proyek']?>" hidden>
                              <input type="radio" id="radio-masuk-<?=$row['id_pekerja']?>" name="absensi[<?=$row['id_pekerja']?>]" value="Hadir" onchange="aktifDropdown(<?=$row['id_pekerja']?>)" required> Hadir
                              <input type="radio" id="radio-tidakmasuk-<?=$row['id_pekerja']?>" name="absensi[<?=$row['id_pekerja']?>]" value="Tidak Hadir" onchange="aktifDropdown(<?=$row['id_pekerja']?>)"> Tidak Hadir
                              <input type="radio" id="radio-telat-<?=$row['id_pekerja']?>" name="absensi[<?=$row['id_pekerja']?>]" onclick="aktifDropdown(<?=$row['id_pekerja']?>)" onchange="aktifDropdown(<?=$row['id_pekerja']?>)"> Sesuai Jam Kerja
                              <select id="dropdown-telat-<?=$row['id_pekerja']?>" name="absensi[<?=$row['id_pekerja']?>]" hidden disabled> 
                                <option value="7">7 jam</option>
                                <option value="6">6 jam</option>
                                <option value="5">5 jam</option>
                                <option value="4">4 jam</option>
                                <option value="3">3 jam</option>
                                <option value="2">2 jam</option>
                                <option value="1">1 jam</option>
                              </select>

                              <input type="radio" id="radio-lembur-<?=$row['id_pekerja']?>" name="lembur[<?=$row['id_pekerja']?>]" onclick="munculDropdown(<?=$row['id_pekerja']?>)" > Lembur
                              <select id="dropdown-lembur-<?=$row['id_pekerja']?>" name="lembur[<?=$row['id_pekerja']?>]" hidden>
                                <option value="">Jam Lembur</option>
                                <option value="1">1 jam</option>
                                <option value="2">2 jam</option>
                                <option value="3">3 jam</option>
                                <option value="4">4 jam</option>
                                <option value="5">5 jam</option>
                                <option value="6">6 jam</option>
                                <option value="7">7 jam</option>
                                <option value="8">8 jam</option>
                              </select>
                         </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
                <input type="submit" name="submit" value="Submit">
              </form>
          </div>
        </div>  
      </div>
      
      <div class="col-md-6">
        <div class="mb-3">
          <h3 class="pb-4">Absensi Minggu ini</h3>
        <table class="table table-striped table-hover" responsive>
                    <thead>
                    <tr>
                      <th>Nama Pekerja</th>                      
                      <th>Senin</th>
                      <th>Selasa</th>
                      <th>Rabu</th>
                      <th>Kamis</th>
                      <th>Jumat</th>
                      <th>Sabtu</th>
                    </tr>
                  </thead>
                  <tbody>
                        <!-- Loop untuk menampilkan data pekerja -->
                        
                          <?php foreach ($keteranganmingguan as $data) : ?>
                            <tr>
                              <td><?= $data['Nama Pekerja'] ?></td>
                              <td><?= $data['Senin'] ?></td>
                              <td><?= $data['Selasa'] ?></td>
                              <td><?= $data['Rabu'] ?></td>
                              <td><?= $data['Kamis'] ?></td>
                              <td><?= $data['Jumat'] ?></td>
                              <td><?= $data['Sabtu'] ?></td>
                            </tr>
                          <?php endforeach ?>
                        
                      </tbody>
                    </table>
        </div>
      </div>
      <div class="row">
        <div class="container">
        <div class="filtertgl text-center  ">
          <h1>LAPORAN MINGGUAN UPAH PEKERJA</h1>
          <h2><?= $proyek['nama_proyek'] ?> </h2>  
          <form class="" action="" method="post">
            <label for="tgl_start">Dari Tanggal</label>
            <input type="date" name="tgl_start">
            <label for="tgl_end">Sampai Tanggal</label>
            <input type="date" name="tgl_end">
            <button class="btn btn-danger" name="filter">Filter</button>
          </form>
          <strong><?= $filter;   ?></strong>
        </div>   
        <table id="absenTable" class="table table-striped table-hover" responsive>
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Pekerja</th>
                    <th>Jumlah Absen</th>
                    <th>Upah Harian</th>
                    <th>Kategori Pekerja</th>
                    <th>Total Upah</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1 ?>
                <?php foreach ($rekapabsenmingguan as $row) {?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?= $row["Nama Pekerja"]?></td>
                        <td><?= $row["Jumlah Absen"]?> Hari</td>
                        <td><?= $row["Upah Harian"]?></td>
                        <td><?= $row["Kategori Pekerja"]?></td>
                        <td><?= $row["Total Upah"]?></td>
                    </tr>
                    <?php $i++; ?>
                <?php } ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="5" style="text-align:right">Jumlah Total:</th>
                <th></th>
              </tr>
            </tfoot>
        </table>    
      </div>
   </div>
   </div>

         <?php include 'kodejs.php'; ?>   
              
         <!-- datatables
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
        <script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.bootstrap5.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.1/js/bootstrap.bundle.min.js"></script> -->
        <script>
          $(document).ready(function() { 
          var data = JSON.parse($("#data-container").attr("data"));
              var table = $('#absenTable').DataTable( {
                  lengthChange: false,
                  buttons: [
                      {
                          extend: 'pdf',
                          title: 'Laporan Mingguan Upah Pekerja Proyek $proyek',
                          split: [ 'csv', 'excel'],
                      },
                      'colvis'
                  ]
              } );
          
              table.buttons().container()
                  .appendTo( '#absenTable_wrapper .col-md-6:eq(0)' );
          } );
                
              table.buttons().container()
                  .appendTo( '#absenTable_wrapper .col-md-6:eq(0)' );
        </script> 
        <script>
          $(document).ready(function() { 
          
            var table = $('#absenTable').DataTable( {
            lengthChange: false,
            buttons: [
              {
                extend: 'pdf',
                title: 'Laporan Mingguan Upah Pekerja Proyek <?= $proyek["nama_proyek"] ?>',
                split: [ 'csv', 'excel'],
            },
            'colvis'
            ],
            footerCallback: function(row, data, start, end, display) {
              var api = this.api();
              var total = api.column(5).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b.replace(/,/g, ''));
              }, 0);
              var formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
              $(api.column(5).footer()).html(formattedTotal);
              $(api.column(4).footer()).html('Jumlah Total');
            }



            } );
 
            table.buttons().container()
                .appendTo( '#absenTable_wrapper .col-md-6:eq(0)' );
            } );
            
    </script>
</body>
</html>