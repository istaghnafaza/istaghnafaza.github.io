<?php
    require 'function.php';

    if (isset($_POST["register"])) {
        
        if (register($_POST) > 0) {
            echo "<script> alert('user baru berhasil di tambahkan'); </script>";

        } else{
            echo mysqli_error($conn);
        }

    }
?>


<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Form Registrasi</title>
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
             <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
        </li>
        <li>
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" id="exampleInputPassword1" name="password">
        </li>
        <li>
            <label for="exampleInputPassword2" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="exampleInputPassword2" name="password2">
        </li>
        <li>
            <button class="btn btn-success" type="submit" name="register">Register</button>
        </li>
    </ul>
</form>



<?php include 'kodejs.php'; ?>
      </body>
</html>