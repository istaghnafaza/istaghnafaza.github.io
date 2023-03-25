<?php
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require 'function.php';

$id = $_GET["id"];
if(hapusProyek($id) > 0){
            echo "
                <script>
                alert('Data berhasil di HAPUS');
                document.location.href = 'indexlp.php';
                </script>
            ";
}else {
            echo "<script>
                alert('Data GAGAL di Hapus');
                document.location.href = 'indexlp.php';
                </script>
                ";
        }
?>