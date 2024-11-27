<?php
session_start();

if (isset($_SESSION["is_login"]) == false) {
    header("location: login.php");
    exit();
}

include 'includes/db.php';
include 'includes/functions.php';

    $profile = profile_user($_SESSION["user_nis"]);
    if ($profile["role"] != "admin") {
        header("location: dashboard.php");
        exit();
    }


// Update data user tanpa hashing password
if(isset($_POST['username'])){
    $user_nis = isset($_POST['user_nis']) ? strip_tags($_POST['user_nis']) : '';
    $user_name = isset($_POST['username']) ? strip_tags($_POST['username']) : '';
    $user_password = isset($_POST['password']) ? strip_tags($_POST['password']) : '';

    $update_user = update_user($user_nis, $user_name, $user_password);
    echo json_encode($update_user);
    exit();
}

// Ambil data user berdasarkan NIS
if (isset($_GET['user_nis'])) {
    $user_nis = $_GET['user_nis'];

    // Menggunakan MySQLi untuk query
    $stmt = $db->prepare("SELECT * FROM akun_users WHERE user_nis = ?");
    $stmt->bind_param("s", $user_nis);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('User tidak ditemukan!'); location.href='view_account.php'</script>";
        exit();
    }
} else {
    echo "NIS tidak disertakan!";
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Edit Data Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-3">Edit Murid</h1>
        <div class="shadow px-3 py-4 rounded">
            <form method="POST" action="edit_account.php" id="form_edit_user">
                <input type="hidden" name="user_nis" value="<?= $user['user_nis'] ?>" required>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" id="username" name="username" value="<?= $user['username'] ?>" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password (Biarkan kosong jika tidak ingin diubah)</label>
                    <input type="password" class="form-control" id="password" name="password">
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="view_account.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#form_edit_user').submit(function(e){
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method');
                let data = new FormData(form[0]);
                
                $.ajax({
                    url: url,
                    type: method,
                    contentType: false,
                    processData: false,
                    data: data,
                    dataType: 'JSON',

                    success: function(response){
                        if(response.status == 'success'){
                            toastr.success(response.message, 'Success !', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500
                            });
                            
                            setTimeout(function() {
                                if (response.redirect != "") {
                                    location.href = response.redirect;
                                } else {
                                    location.reload();
                                }
                            }, 1800);
                        }else{
                            toastr.error(response.message, 'Failed !', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500
                            });
                        }
                    },
                });

            });
        });
    </script>

</body>
</html>
