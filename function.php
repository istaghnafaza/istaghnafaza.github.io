   <?php
   $conn = mysqli_connect("localhost", "root", "", "db_proyek"); 
   if (!$conn) {
   die("Koneksi gagal: " . mysqli_connect_error());
}

   // Function untuk Read Database
   function query($query)
   {
      global $conn;
   //    analogi ambil baju di lemari
   // $read = lemari
   // $bariss = kerdus
   // $baris = baju
      $read = mysqli_query($conn,$query);
      $bariss = [];
   //    mengambil semua baju di lemari 
      while ($row = mysqli_fetch_assoc($read)) {
      // Kerdus di isi baju yang di dapatkan dari lemari
      $bariss[] = $row;
      }
      return $bariss;
   }

   function tambahdataAbsensi($data) {
      global $conn;

      // Memproses data yang di-submit dari form
      $tanggal_absensi = $data['tanggal'];
      $keterangan = $data['absensi'];
      $lembur = $data['lembur'];
      $proyek = $data['proyek'];;

      // Menyiapkan query untuk memasukkan data ke dalam tabel
      $query = "INSERT INTO tb_absen (id_proyek, id_pekerja, tanggal, keterangan, lembur) VALUES (?,?,?,?,?)";

      // Menjalankan query menggunakan prepared statement
      $stmt = $conn->prepare($query);
      $stmt->bind_param("iisss", $proyek_id, $id_pekerja, $tanggal_absensi, $keterangan_absensi, $lembur_absensi);

      foreach ($keterangan as $id_pekerja => $keterangan_absensi) {
         $lembur_absensi = $lembur[$id_pekerja];
         $proyek_id = $proyek[$id_pekerja];
         $stmt->bind_param("iisss",  $proyek_id, $id_pekerja, $tanggal_absensi, $keterangan_absensi, $lembur_absensi);
         $stmt->execute();
      }
      // Menutup prepared statement dan koneksi ke database
      $stmt->close();
      return mysqli_affected_rows($conn);
}



   function tambahdataPekerja($data){
    global $conn;
    /* ambil data dari tiap elemen di dalam form 
        (atribut name pada form harus sama dengan nama table di database)
        & di masukkan ke variable agar query tidak panjang*/
    // htmlspecialchars untuk pengaman dari hacker yg ingin masukkan script di form
     // set nilai parameter
      $id_proyek = $data["id_proyek"];
      $id_pekerja = $data["id_pekerja"];
      $upah = htmlspecialchars($data["upah"]);
      $tgl_mulai = htmlspecialchars($data["tgl_mulai"]);
      $tgl_selesai = htmlspecialchars($data["tgl_selesai"]);
   
      // Fungsi untuk mengecek apakah data sudah ada atau belum
      function cekData($conn, $id_proyek, $id_pekerja) {
      $query = "SELECT COUNT(*) as jumlah FROM tbl_pivot_pekerjaproyek WHERE id_proyek = '$id_proyek' AND id_pekerja = '$id_pekerja'";
      $result = mysqli_query($conn, $query);
      $row = mysqli_fetch_assoc($result);
      return $row['jumlah'];
      }

      // Cek apakah data sudah ada atau belum
      if(cekData($conn, $id_proyek, $id_pekerja) > 0) {
         echo "<script>alert('Data Pekerja sudah ada');</script>";
      } else {
         // Jika data belum ada, maka insert data ke dalam tabel pivot
         // siapkan query
         $query = "INSERT INTO tbl_pivot_pekerjaproyek (id_proyek, id_pekerja, upah, tgl_mulai, tgl_selesai) VALUES (?, ?, ?, ?, ?)";

         // siapkan statement
         $stmt = mysqli_prepare($conn, $query);

         // bind parameter ke statement
         mysqli_stmt_bind_param($stmt, "iiiss", $id_proyek, $id_pekerja, $upah, $tgl_mulai, $tgl_selesai);

         // eksekusi statement
         mysqli_stmt_execute($stmt);
         // tutup statement dan koneksi
         mysqli_stmt_close($stmt);

         return mysqli_affected_rows($conn);
      }        
}
   function tambahPekerjaBaru($data){
    global $conn;
    /* ambil data dari tiap elemen di dalam form 
        (atribut name pada form harus sama dengan nama table di database)
        & di masukkan ke variable agar query tidak panjang*/
    // htmlspecialchars untuk pengaman dari hacker yg ingin masukkan script di form
     // set nilai parameter
   
      $nama_pekerja = htmlspecialchars($data["nama_pekerja"]);
      $id_kategoripekerja = htmlspecialchars($data["id_kategoripekerja"]);
      $notelp = htmlspecialchars($data["notelp"]);
      $keterangan = htmlspecialchars($data["keterangan"]);
   
         // Jika data belum ada, maka insert data ke dalam tabel pivot
         // siapkan query
         $query = "INSERT INTO tb_pekerja (keterangan, nama_pekerja, id_kategoripekerja, notelp) VALUES (?, ?, ?, ?)";

         // siapkan statement
         $stmt = mysqli_prepare($conn, $query);

         // bind parameter ke statement
         mysqli_stmt_bind_param($stmt, "ssii", $keterangan, $nama_pekerja, $id_kategoripekerja, $notelp);

         // eksekusi statement
         mysqli_stmt_execute($stmt);
         // tutup statement dan koneksi
         mysqli_stmt_close($stmt);

         return mysqli_affected_rows($conn);
      }        



   function tambahdataProyek($data){
    global $conn;
    /* ambil data dari tiap elemen di dalam form 
        (atribut name pada form harus sama dengan nama table di database)
        & di masukkan ke variable agar query tidak panjang*/
    // htmlspecialchars untuk pengaman dari hacker yg ingin masukkan script di form
    $namaproyek = htmlspecialchars($data["nama_proyek"]);
    $namaclient = htmlspecialchars($data["nama_client"]);
    $lokasi = htmlspecialchars($data["lokasi"]);
    $tglmulai = htmlspecialchars($data["tgl_mulai"]);
    $tglselesai = htmlspecialchars($data["tgl_selesai"]);
    $status= htmlspecialchars($data["status"]);

    $gambar = upload();
    if(!$gambar){
      return false;
    }

    //query insert data
    // note : data yang di tambahkan harus sama jumlahnya dengan kolom di DB, sekalipun kosong
    $queryinsert = "INSERT INTO tb_proyek
                    VALUES
                      ('','$namaclient','$namaproyek','$lokasi','$tglmulai','$tglselesai','$gambar','$status')
                      ";
     /* parameter ke 1 untuk koneksi ke DB, parameter ke2 untuk query 
        (dimasukkan variable agar tidak terlalu panjang dan membingungkan)*/
        mysqli_query($conn, $queryinsert);

        return mysqli_affected_rows($conn);
}
   function tambahOrder($data){
    global $conn;
    /* ambil data dari tiap elemen di dalam form 
        (atribut name pada form harus sama dengan nama table di database)
        & di masukkan ke variable agar query tidak panjang*/
    
// Validasi data input dan escape karakter khusus
$id_proyek = mysqli_real_escape_string($conn, htmlspecialchars($data['id_proyek']));
$id_toko = mysqli_real_escape_string($conn, htmlspecialchars($data['id_toko']));
$material = mysqli_real_escape_string($conn, htmlspecialchars($data['material']));
$total_harga = mysqli_real_escape_string($conn, htmlspecialchars($data['total_harga']));
$tanggal_pemesanan = mysqli_real_escape_string($conn, htmlspecialchars($data['tanggal_pemesanan']));
$tanggal_nota = mysqli_real_escape_string($conn, htmlspecialchars($data['tanggal_nota']));
$status_nota = mysqli_real_escape_string($conn, htmlspecialchars($data['status_nota']));
$status_order = mysqli_real_escape_string($conn, htmlspecialchars($data['status_order']));

    $fotonota = upload();

    //query insert data
    // note : data yang di tambahkan harus sama jumlahnya dengan kolom di DB, sekalipun kosong
    // Prepare statement
      $stmt = mysqli_prepare($conn, "INSERT INTO tb_ordermaterial (id_proyek, id_toko, material, total_harga, tanggal_pemesanan, tanggal_nota, status_nota, foto_nota, status_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      mysqli_stmt_bind_param($stmt, "iisisssss", $id_proyek, $id_toko, $material, $total_harga, $tanggal_pemesanan, $tanggal_nota, $status_nota, $fotonota, $status_order);
     // eksekusi statement
         mysqli_stmt_execute($stmt);
         // tutup statement dan koneksi
         mysqli_stmt_close($stmt);

         return mysqli_affected_rows($conn);
}

function upload(){
      global $conn;  
      // Cek apakah ada file yang diunggah
   $nama_file = $_FILES["file"]["name"];
   $nama_temp = $_FILES["file"]["tmp_name"];
   $ukuran_file = $_FILES["file"]["size"];
   $error = $_FILES["file"]["error"];

   // Jika tidak ada file yang diunggah, set nilai $nama_baru menjadi null
   if ($error === 4) {
      $nama_baru = null;
   } else {
      // Periksa apakah file yang diunggah adalah gambar
      $ekstensi_valid = array("jpg", "jpeg", "png", "gif");
      $ekstensi_file = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));
      if(!in_array($ekstensi_file, $ekstensi_valid)) {
         die("File yang diunggah bukan gambar.");
      }

      // Periksa apakah ukuran file tidak terlalu besar
      $ukuran_valid = 10000000; // 10 MB
      if($ukuran_file > $ukuran_valid) {
         die("Ukuran file terlalu besar.");
      }

      // Generate nama file baru agar tidak ada file dengan nama yang sama
      $nama_baru = uniqid() . '.' . $ekstensi_file;

      // Simpan file di folder uploads
      $lokasi = "img/" . $nama_baru;
      if(move_uploaded_file($nama_temp, $lokasi)) {
            echo "File berhasil diunggah dan data nama gambar berhasil ditambahkan ke database.";
         } 
         else {
         echo "Terjadi kesalahan saat mengunggah file.";
      }
   }
   return $nama_baru;
   }


   function hapusProyek($id){
      global $conn;
      mysqli_query($conn,"DELETE FROM tb_proyek WHERE id_proyek = $id");
      return mysqli_affected_rows($conn);
   }
   function hapusPekerjaproyek($id){
      global $conn;
      mysqli_query($conn,"DELETE FROM tbl_pivot_pekerjaproyek WHERE id = $id");

      return mysqli_affected_rows($conn);
   }
   function hapusPekerja($id){
      global $conn;
      mysqli_query($conn,"DELETE FROM tb_pekerja WHERE id_pekerja = $id");

      return mysqli_affected_rows($conn);
   }

   function   ubahdataProyek($data){
      global $conn;
      /* ambil data dari tiap elemen di dalam form 
         (atribut name pada form harus sama dengan nama table di database)
         & di masukkan ke variable agar query tidak panjang*/
      // htmlspecialchars untuk pengaman dari hacker yg ingin masukkan script di form
      $id = $data["id_proyek"];
      $namaproyek = htmlspecialchars($data["nama_proyek"]);
      $namaclient = htmlspecialchars($data["nama_client"]);
      $lokasi = htmlspecialchars($data["lokasi"]);
      $tglmulai = htmlspecialchars($data["tgl_mulai"]);
      $tglselesai = htmlspecialchars($data["tgl_selesai"]);
      $status= htmlspecialchars($data["status"]);
      $gambarLama = htmlspecialchars($data["gambarLama"]);

      //cek apakah user pilih gambar baru atau lama
      if($_FILES['file']['error'] === 4){
         $gambar = $gambarLama;
      } else {
         $gambar = upload();
      }
      //query insert data
      // note : data yang di tambahkan harus sama jumlahnya dengan kolom di DB, sekalipun kosong
      $queryupdate = "UPDATE tb_proyek SET
                        nama_proyek = '$namaproyek', 
                        nama_client = '$namaclient', 
                        lokasi = '$lokasi', 
                        tgl_mulai = '$tglmulai',
                        tgl_selesai = '$tglselesai',
                        status = '$status',
                        gambar = '$gambar'
                        WHERE id_proyek = $id";
      /* parameter ke 1 untuk koneksi ke DB, parameter ke2 untuk query 
         (dimasukkan variable agar tidak terlalu panjang dan membingungkan)*/
         mysqli_query($conn, $queryupdate);

         return mysqli_affected_rows($conn);
   }

   function   ubahdataPekerja($data){
      global $conn;
      /* ambil data dari tiap elemen di dalam form 
         (atribut name pada form harus sama dengan nama table di database)
         & di masukkan ke variable agar query tidak panjang*/
      // htmlspecialchars untuk pengaman dari hacker yg ingin masukkan script di form
      $upah = htmlspecialchars($data["upah"]);
      $tgl_mulai = htmlspecialchars($data["tgl_mulai"]);
      $tgl_selesai = htmlspecialchars($data["tgl_selesai"]);

    //query insert data
    // note : data yang di tambahkan harus sama jumlahnya dengan kolom di DB, sekalipun kosong
    $queryupdate = "UPDATE tbl_pivot_pekerjaproyek SET 
                     upah = '$upah', 
                     tgl_mulai = '$tgl_mulai', 
                     tgl_selesai = '$tgl_selesai'
                     WHERE id ";
     /* parameter ke 1 untuk koneksi ke DB, parameter ke2 untuk query 
        (dimasukkan variable agar tidak terlalu panjang dan membingungkan)*/
        mysqli_query($conn, $queryupdate);

         return mysqli_affected_rows($conn);
   }

   ?>