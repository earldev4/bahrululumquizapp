<?php
session_start();

if (isset($_SESSION["is_login"]) == false) {
    header("location: login.php");
    exit();
}
include 'includes/db.php'; // Pastikan path ke file db.php benar
include 'includes/functions.php';

$profile = profile_user($_SESSION["user_nis"]);
if ($profile["role"] != "admin") {
    header("location: dashboard.php");
    exit();
}


if(isset($_POST['title'])){
    $subject_id = isset($_POST['subject_id']) ? strip_tags($_POST['subject_id']) : '';
    $judul_quiz = isset($_POST['title']) ? strip_tags($_POST['title']) : '';
    $hour = isset($_POST['hour']) ? strip_tags($_POST['hour']) : '';
    $min = isset($_POST['min']) ? strip_tags($_POST['min']) : '';
    $sec = isset($_POST['sec']) ? strip_tags($_POST['sec']) : '';

    $insert_quiz = insert_quiz($subject_id, $judul_quiz, $hour, $min, $sec);
    echo json_encode($insert_quiz);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Tambah Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-3">Tambah Quiz</h1>
        <div class="shadow p-4 rounded mb-4">
            <form action="add_quiz.php" method="POST" id="form_tambah_quiz">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" value="<?= $_GET['id_subject'] ?>" name="subject_id">
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul Quiz</label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Masukkan judul quiz" required>
                        </div>
                        <div class="mb-3">
                        <label for="title" class="form-label">Waktu Quiz ( Contoh : 01:30:00 )</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="title" name="hour" placeholder="Jam">
                                <input type="number" class="form-control" id="title" name="min" placeholder="Menit">
                                <input type="number" class="form-control" id="title" name="sec" placeholder="Detik">
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Tambah</button>
                <a href="data_quiz.php?id_subject=<?= $_GET['id_subject'] ?>" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#form_tambah_quiz').submit(function(e){
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
