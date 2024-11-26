<?php
    include "includes/db.php";
    session_start();
    $message = "";
    if (isset($_POST['buat'])) {
        $user_nis = $_POST['user_nis'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        try{
            $sql = "INSERT INTO akun_users (user_nis,username,password) VALUES('$user_nis','$username', '$password')";
            if ($db->query($sql)) {
                $message = "Akun berhasil didaftarkan";
            } else{
                $message = "Akun gagal didaftarkan";
            }
        } catch (mysqli_sql_exception) {
            $message = "Username sudah digunakan";
        }
        $db->close();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Tambah Data Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
    <div class="container mt-5 bg-secondary-subtle">
        <div class="row ">
            <div class="col-3"></div>
            <div class="col-6 index-card d-flex flex-column align-items-center justify-content-center p-3">
                <img src="assets/image/img-icon.png" alt="" class="img-fluid rounded-circle mb-3 d-flex justify-content-center align-items-center" style="width: 200px;">
                <form action="add_users.php" method="POST" class="w-100">
                    <h2 class="text-center">Buat Akun</h2>
                    <div>
                        <p>User NIS</p>
                        <input type="text" name="user_nis" placeholder="User NIS" required class="w-100">
                    </div>
                    <div>
                        <p>Username</p>
                        <input type="text" name="username" placeholder="Username" required class="w-100">
                    </div>
                    <div>
                        <p>Password</p>
                        <input type="password" name="password" placeholder="Password" required class="w-100">
                    </div>
                    <p><?php 
                        if (isset($message)) {
                            echo $message; 
                        }?>
                    </p>
                    <button type="submit" name="buat" class="bg-danger text-white px-3 py-2 rounded text-decoration-none w-100">Buat</button>
                </form>
                <a href="admin_dashboard.php" class="bg-danger text-white px-3 py-2 rounded text-decoration-none mt-3 w-75 text-center">Kembali</a>
            </div>
            <div class="col-3"></div>
        </div>    
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
</body>
</html>