<?php
session_start(); 
    //session ketika user sudah login
    if (isset($_SESSION["login"])) {
        header("Location: indexlp.php");
        exit;
    }

    require 'function.php';

    if (isset($_POST["login"])) {
        
        $username = $_POST["username"];
        $password = $_POST["password"];

        $result = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
        
        //cek username
        // logic if artinya untuk ngitung ada berapa baris y di kembalikan dari fungsi select, kalau ketemu nilainya 1
        if (mysqli_num_rows($result) === 1) {
            // cek paswordnya
            $row = mysqli_fetch_assoc($result);
           if  (password_verify($password, $row["password"]) ){
                $_SESSION["login"] = true; // set session untuk masuk halaman index
                header('Location: indexlp.php');
                exit;
            } else {
                echo "<script> alert('Password / Username Salah'); </script>";
            }
        }

    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <?php include 'kodelink.php'; ?>
  </head>
  <body>
    <form action="" method="post">
    <ul>
        <li>
             <label for="exampleInputEmail1" class="form-label">Username</label>
            <input type="text" name="username" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </li>
        <li>
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </li>
        <li>
            <button class="btn btn-success" type="submit" name="login">Login</button>
        </li>
    </ul>
</form>



<?php include 'kodejs.php'; ?>
      </body>
</html>