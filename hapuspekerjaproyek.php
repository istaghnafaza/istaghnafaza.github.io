<?php
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require 'function.php';
$id = $_GET["idpivot"];
$idproyek = $_GET["idproyek"];
$proyek = query("SELECT * FROM tb_proyek WHERE id_proyek = $idproyek")[0];

if(hapusPekerjaproyek($id) > 0){
            echo "
                <script>
                alert('Data berhasil di HAPUS');
                
                </script>
            ";
            header('Location: tambahpekerja.php?id=' . urlencode($proyek['$idproyek']));
            exit();
}else {
            echo "<script>
                alert('Data GAGAL di Hapus');
                document.location.href = 'indexlp.php';
                </script>
                ";
        }

?>