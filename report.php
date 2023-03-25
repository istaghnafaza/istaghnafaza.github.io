<?php
require 'function.php';

$id = $_GET["id"];

$proyek = query("SELECT u.nama_proyek FROM tb_proyek u WHERE u.id_proyek = $id")[0];
$report = query("SELECT * FROM tb_ordermaterial o 
                JOIN toko t ON o.id_toko = t.id_toko
                where id_proyek = $id");

if (isset($_POST['filter'])){
    $tgl_start = $_POST['tgl_start'];
    $tgl_end= $_POST['tgl_end'];
    $ordermaterial = query("SELECT * FROM tb_ordermaterial o 
                JOIN toko t ON o.id_toko = t.id_toko
                where id_proyek = $id AND o.tanggal_pemesan BETWEEN '$tgl_start' AND '$tgl_end' ");
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Order</title>
    <!-- Bootstrap 5 CSS -->
    <?php include 'kodelink.php'; ?>
</head>
<body>
    <?php include 'navbar.php'; ?>
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
                <?php foreach($ordermaterial as $row): ?>
                <tr>                    
                    <td><?php echo $row['nama_tb']; ?></td>
                    <td><?php echo $row['material']; ?></td>
                    <td><?php echo $row['total_harga']; ?></td>
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

    <?php include 'kodejs.php'; ?>  
    <script>
          $(document).ready(function() { 
          
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
            } );
            
    </script>
</body>
</html>
