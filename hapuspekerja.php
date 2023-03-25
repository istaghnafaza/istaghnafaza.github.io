<?php
session_start();

    if (!isset($_SESSION["login"])) {
        header("Location: login.php");
        exit;
    }
require 'function.php';
$id = $_GET["id"];

if(hapusPekerja($id) > 0){
            echo "
                <script>
                alert('Data berhasil di HAPUS');
                document.location.href = 'pekerjabaru.php';
                </script>
            ";
}else {
            echo "<script>
                alert('Data GAGAL di Hapus');
                document.location.href = 'pekerjabaru.php';
                </script>
                ";
        }


?>