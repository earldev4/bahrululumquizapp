<?php
include "includes/db.php";
session_start();

if (isset($_SESSION["is_login"])) {
    header("location: dashboard.php");
    exit();
}

if (isset($_POST['username'])) {
    $username = isset($_POST['username']) ? strip_tags($_POST['username']) : '';
    $password = isset($_POST['password']) ? strip_tags($_POST['password']) : '';

    if($username && $password != ''){
        $sqlUser = $db->prepare("SELECT user_nis,username,password FROM akun_users WHERE username=? AND password=?");
        $sqlUser->bind_param("ss", $username, $password);
        $sqlUser->execute();
        $resultUser = $sqlUser->get_result();

        if ($resultUser->num_rows > 0) {
            $dataUser = $resultUser->fetch_assoc();
            $_SESSION["user_nis"] = $dataUser['user_nis'];
            $_SESSION["is_login"] = true;
            
            $response = [
                'status' => 'success',
                'message' => 'Username dan password sesuai',
                'redirect' => 'dashboard.php'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Username dan password tidak sesuai',
                'redirect' => ''
            ];
        }
    }else{
        $response = [
            'status' => 'error',
            'message' => 'Username dan password wajib diisi',
            'redirect' => ''
        ];
    }
        
    $db->close();
    echo json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="px-3">
    <main>
        <div class="container mt-5">
            <div class="row d-flex justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4 shadow-lg rounded d-flex flex-column align-items-center justify-content-center p-4">
                    <img src="assets/image/img-icon.png" alt="" class="img-fluid rounded-circle mb-3 d-flex justify-content-center align-items-center" style="width: 200px;">
                    <form action="login.php" method="POST" class="w-100" id="form_login">
                        <h2 class="text-center">Login</h2>
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" placeholder="Username" required class="w-100 form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" placeholder="Password" required class="w-100 form-control">
                        </div>
                        <button type="submit" class="btn btn-danger w-100 py-3 mt-3">Login</button>
                    </form>
                </div>
            </div>    
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#form_login').submit(function(e){
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method');
                let data = new FormData(form[0]);

                $.ajax({
                    url: url,
                    type: method,
                    processData: false,
                    contentType: false,
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
<html>
