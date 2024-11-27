<?php
include "includes/db.php";
include "includes/functions.php";
session_start();
if (isset($_SESSION["is_login"]) == false) {
    header("location: login.php");
    exit();
}
$profile = profile_user($_SESSION["user_nis"]);
if ($profile["role"] != "admin") {
    header("location: dashboard.php");
    exit();
}

if(isset($_POST['username'])){
    $user_nis = isset($_POST['user_nis']) ? strip_tags($_POST['user_nis']) : '';
    $user_name = isset($_POST['username']) ? strip_tags($_POST['username']) : '';
    $user_password = isset($_POST['password']) ? strip_tags($_POST['password']) : '';

    $insert_user = insert_user($user_nis, $user_name, $user_password);
    echo json_encode($insert_user);
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Tambah Data Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/user_style.css">
</head>

<body class="d-flex align-items-center p-3" style="min-height: 100vh; height: 100%;">
    <div class="container shadow-lg">
        <div class="row py-4 px-3">
            <div class="col-md-6 col-12 d-flex justify-content-center align-items-center">
                <img src="assets/image/img-icon.png" alt="" class="img-form-add-user img-fluid rounded-circle" style="width: 300px;">
            </div>
            <div class="col-md-6 col-12 index-card d-flex flex-column align-items-center justify-content-center p-3">
                <form action="add_users.php" method="POST" class="w-100" id="form_tambah_user">
                    <h2 class="text-center mb-3">Tambah User</h2>
                    <div class="mb-3">
                        <label class="form-label">User NIS</label>
                        <input type="text" name="user_nis" class="form-control w-100" placeholder="User NIS" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" name="username" class="form-control w-100" placeholder="Username" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control w-100" placeholder="Password" required>
                    </div>
                    <p><?php
                        if (isset($message)) {
                            echo $message;
                        } ?>
                    </p>
                    <button type="submit" name="buat" class="btn btn-danger w-100 py-2 mb-4">Tambah</button>
                </form>
                <a href="dashboard.php" class="btn btn-danger w-75 py-2">Kembali</a>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="app.js"></script>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    $(document).ready(function() {
        
        $('#form_tambah_user').submit(function(e) {
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

                success: function(response) {
                    if (response.status == 'success') {
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
                    } else {
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

</html>