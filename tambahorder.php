<?php 
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require "function.php";
$id = $_GET["id"];

$proyek = query("SELECT * FROM tb_proyek WHERE id_proyek = $id")[0];
$toko = query("SELECT * FROM toko");
$material = query("SELECT * FROM bahan_material");
$ordermaterial = query("SELECT *, t.nama_tb AS 'Nama Toko', o.material, FORMAT(o.total_harga, '#,##0;') AS 'Total Harga', o.status_nota 
                        FROM tb_ordermaterial o JOIN toko t ON o.id_toko = t.id_toko 
                        where id_proyek = $id AND DAYOFWEEK(tanggal_nota) BETWEEN 2 AND 7 
                        AND tanggal_nota BETWEEN DATE_SUB(CURDATE(), INTERVAL DAYOFWEEK(CURDATE())-2 DAY) AND DATE_ADD(CURDATE(), INTERVAL 7-DAYOFWEEK(CURDATE()) DAY);");
if (isset($_POST['filter'])){
    $tgl_start = $_POST['tgl_start'];
    $tgl_end= $_POST['tgl_end'];
    $filterorder = query("SELECT *, t.nama_tb AS 'Nama Toko', o.material, FORMAT(o.total_harga, '#,##0;') AS 'Total Harga', o.status_nota FROM tb_ordermaterial o 
                JOIN toko t ON o.id_toko = t.id_toko
                where id_proyek = $id AND o.tanggal_nota BETWEEN '$tgl_start' AND '$tgl_end' ");
}else{
  $filterorder = query("SELECT *, t.nama_tb AS 'Nama Toko', o.material, FORMAT(o.total_harga, '#,##0;') AS 'Total Harga', o.status_nota FROM tb_ordermaterial o 
                JOIN toko t ON o.id_toko = t.id_toko
                where id_proyek = $id");
}
// cek apakah tombol submit sudah ditekan atau belum
    if ( isset($_POST["submit"]) ) {
        // cek keberhasilan input data
        /* function tambahdata dengan parameter semua data di element form 
        di ambil dan di masukkan ke fungsi tambah data yang akan di tangkap
        oleh $data */
        if(tambahOrder($_POST) != 0){
            echo "
                <script>
                alert('Data berhasil di tambahkan');
                </script>
            ";
            header('Location: tambahorder.php?id=' . urlencode($id));
            
        } else {
            echo "<script>
                alert('Data GAGAL di tambahkan');
                document.location.href = 'dashboard.php';
                </script>
                ";
                header('Location: dashboard.php?id=' . urlencode($id));
           
        }
    } 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Input Order Material</title>
    <?php include 'kodelink.php'; ?>
    <style>
      @media print {
        .print-only {
        display: none;
        page-break-before: always;
        }
        
        
      }
    </style>
  </head>
  <body>
    <?php include 'navbar.php'; ?>
    
    <div class="row print-only">
      <div class="col-md-4">
    <div class="container mt-3">
      <h1 class="text-center">Input Order Material</h1>
      <form method="POST" action="" enctype="multipart/form-data">
        <div class="form-group">
         <input type="hidden" class="form-control" id="id_proyek" name="id_proyek" value="<?= $proyek["id_proyek"]?>">
         <input type="hidden" class="form-control" id="lokasi" name="lokasi" value="<?= $proyek["lokasi"]?>">
        </div>
        <div class="form-group">
          <label for="id_toko">Toko Material</label>
            <select class="selectpicker form-control" data-live-search="true" name="id_toko" required>
                    <option value="">Pilih Toko</option>
                    <?php foreach ($toko as $baris) {?>
                    <option value="<?= $baris["id_toko"]?>" data-telp="<?= $baris["telp"]?>"> <?= $baris["nama_tb"]?></option>
                    <?php }?>
            </select>          
        </div>
        <div class="form-group">
          <label for="telp">No Whatsapp</label>
          <input class="form-control" id="telp" name="telp" value="<?= $baris["telp"]?>" disabled></input>
        </div>
        <div class="form-group">
          <label for="id_material">Material</label>
          <textarea class="form-control" id="material" name="material" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label for="total_harga">Total Harga</label>
          <input type="number" class="form-control" id="total_harga" name="total_harga" >
        </div>
        <div class="form-group">
          <label for="tanggal_pemesan">Tanggal Pemesanan</label>
          <input type="date" class="form-control" id="tanggal_pemesan" name="tanggal_pemesan" >
        </div>
        <div class="form-group">
          <label for="tanggal_nota">Tanggal Nota</label>
          <input type="date" class="form-control" id="tanggal_nota" name="tanggal_nota" >
        </div>
        <div class="form-group">
          <strong><label for="formFile" class="form-label">Upload Nota</label></strong>
          <input class="form-control " type="file" name="file" id="formFile">          
        </div>
        <div class="form-group">
          <label for="status">Status Nota Asli</label>
          <select class="form-control" id="status" name="status_nota" >
            <option value="ditoko">Di Toko</option>
            <option value="diproyek">Di Proyek</option>
            <option value="dibawa">Di bawa</option>
          </select>
        </div>
        <div class="form-group">
          <label for="status">Order Melalui</label>
        </div>
        <div class="form-group">
        <div class="form-check-inline">
          <input class="form-check-input" type="radio" name="status_order" value="whatsapp" id="wa">
          <label class="form-check-label" for="check-diproses">
            Via WhatsApp
          </label>
        </div>
        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status_order" value="langsung" id="check-dikirim">
          <label class="form-check-label" for="check-dikirim">
            Langusng di toko
          </label>
        </div>

        <div class="form-check form-check-inline">
          <input class="form-check-input" type="radio" name="status_order" value="marketplace" id="check-selesai">
          <label class="form-check-label" for="check-selesai">
            Online Web/MarketPlace
          </label>
        </div>
        <div class="form-group">
        <button type="submit" name="submit" class="btn btn-primary">Rekap Order</button>
        <a id="sendMessageLink" class="btn btn-success" href="#">
        <i class="bi bi-whatsapp"></i>
        Order Via WhatsApp
        </a>
        </div>
        </div>
        
      </form>
      </div>
    </div>
    <div class="col-md-8">
      <div class="container mt-3">
      <h1 class="text-center">Order Material Pekan ini</h1>
      <table id="absenTable" class="table table-striped table-hover" responsive>
            <thead>
                <tr>                    
                    <th>Nama Toko</th>
                    <th>Material</th>       
                    <th>Total Harga</th>             
                    <th>Status Nota</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($ordermaterial as $row): ?>
                <tr>                    
                    <td><?php echo $row['Nama Toko']; ?></td>
                    <td><?php echo $row['material']; ?></td>
                    <td><?php echo $row['Total Harga']; ?></td> 
                    <td><?php echo $row['status_nota']; ?></td> 
                                                          
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
              <tr>
                <th colspan="2" style="text-align:right">Jumlah Total:</th>
                <th></th>
              </tr>
            </tfoot>
        </table>    
      </div>
    </div>
    </div>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <h1>Daftar Order Material Proyek</h1>
                <h2><?= $proyek['nama_proyek'] ?></h2>
            </div>
            <div class="col-md-6">
                <form class="" action="" method="post">
                <label for="tgl_start">Dari Tanggal</label>
                <input type="date" name="tgl_start">
                <label for="tgl_end">Sampai Tanggal</label>
                <input type="date" name="tgl_end">
                <button class="btn btn-danger" name="filter">Filter</button>
                </form>
            </div>
        </div>
        
        <table id="orderTable" class="table table-striped table-hover" responsive>
            <thead>
                <tr>                    
                    <th>Nama Toko</th>
                    <th>Material</th>
                    <th>Total Harga</th>
                    <th>Tanggal Pemesanan</th>
                    <th>Tanggal Nota</th>
                    <th>Status Nota</th>
                    <th>Foto Nota</th>
                    <th>Status Order</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($filterorder as $row): ?>
                <tr>                    
                    <td><?php echo $row['Nama Toko']; ?></td>
                    <td><?php echo $row['material']; ?></td>
                    <td><?php echo $row['Total Harga']; ?></td>
                    <td><?php echo $row['tanggal_pemesanan']; ?></td>
                    <td><?php echo $row['tanggal_nota']; ?></td>
                    <td><?php echo $row['status_nota']; ?></td>
                    <td>
                        <?php if($row['foto_nota']): ?>
                        <img src="img/<?php echo $row['foto_nota']; ?>" alt="<?php echo $row['foto_nota']; ?>" width="100">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $row['status_order']; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- elemen tautan -->
    

    <!-- script JavaScript -->
    

    <?php include 'kodejs.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>
    
        <script>
            var selectElem = document.querySelector('select[name="id_toko"]');
            selectElem.addEventListener('change', function() {
              var selectedOption = selectElem.options[selectElem.selectedIndex];
              var namaToko = selectedOption.text;
              var telp = selectedOption.getAttribute('data-telp');

              var sendMessageLink = document.getElementById("sendMessageLink");
              sendMessageLink.addEventListener("click", function(event) {
                event.preventDefault();
                var materialElem = document.getElementById("material");
                var materialValue = materialElem.value;
                var lokasi = document.getElementById("lokasi");
                var lokasiValue = lokasi.value;
                var message = encodeURIComponent(`*ORDER*\n\nKpd. *${namaToko}*\n*TOLONG CEPAT DI KIRIM*\n\n${materialValue}\nAlamat Kirim\n*${lokasiValue}*\n\nTerimakasih`);
                var url = "https://wa.me/62" + telp + "?text=" + message;
                window.open(url);
              });
            });
        </script>
    <script>
        $(document).ready(function() {
            // Ketika nilai dropdown berubah
            $('.selectpicker').on('changed.bs.select', function(e, clickedIndex, isSelected, previousValue) {
            // Ambil nilai kategori dari opsi yang dipilih
            var telp = $('option:selected', this).attr('data-telp');
            // Set nilai input telp dengan nilai telp yang diperoleh
            $('#telp').val(telp);
            });  
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
              var total = api.column(2).data().reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b.replace(/,/g, ''));
              }, 0);
              var formattedTotal = 'Rp ' + total.toLocaleString('id-ID');
              $(api.column(2).footer()).html(formattedTotal);
              $(api.column(1).footer()).html('Jumlah Total');
              }
            } );
 
            table.buttons().container()
                .appendTo( '#absenTable_wrapper .col-md-6:eq(0)' );
                var table = $('#orderTable').DataTable( {
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
                .appendTo( '#orderTable_wrapper .col-md-6:eq(0)' );
                
        });
    </script>
  </body>
</html>
