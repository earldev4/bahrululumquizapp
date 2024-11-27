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


if(isset($_POST['subject_name'])){
    
    $subject_id = isset($_POST['subject_id']) ? strip_tags($_POST['subject_id']) : '';
    $subject_name = isset($_POST['subject_name']) ? strip_tags($_POST['subject_name']) : '';
    $subject_desc = isset($_POST['subject_desc']) ? strip_tags($_POST['subject_desc']) : '';
    $thumbnail = $_FILES['thumbnail']['name'] != '' ? $_FILES['thumbnail']['name'] : '';
    $tmp_name = isset($_FILES['thumbnail']['tmp_name']) ? $_FILES['thumbnail']['tmp_name'] : '';
    $music = $_FILES['music']['name'] != '' ? $_FILES['music']['name'] : '';
    $tmp_name_music = isset($_FILES['music']['tmp_name']) ? $_FILES['music']['tmp_name'] : '';

    
    $updated_subject = update_subject($subject_id, $subject_name, $subject_desc,$tmp_name, $thumbnail, $tmp_name_music, $music);
    echo json_encode($updated_subject);
    exit();
}


$id_subject = isset($_GET['id_subject']) ? $_GET['id_subject'] : '';

$subject = get_single_subject($id_subject);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Edit Data Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/user_style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-3">Edit Subject</h1>
        <div class="shadow p-4 rounded mb-4">
            <form action="edit_subject.php" method="POST" id="form_edit_subject">
                <div class="row">
                    <div class="col-md-8">
                        <input type="hidden" name="subject_id" value="<?= $subject['subject_id'] ?>">
                        <div class="mb-3">
                            <label for="subject_name" class="form-label">Subject</label>
                            <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Masukkan nama subject" value="<?= htmlspecialchars($subject['subject_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="subject_desc" class="w-100 form-control" id="deskripsi" placeholder="Masukkan deskripsi subject" style="min-height: 200px;"><?= $subject['subject_desc'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="image" class="form-label">Music</label>
                            <input type="file" class="form-control music_soal mb-3" name="music" id="music">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="image" class="form-label">Image</label>
                            <input type="file" class="form-control file_thumbnail mb-3" name="thumbnail" id="image">
                            <img src="assets/image/<?= $subject['thumbnail']?>" alt="" class="img-fluid w-100 rounded">
                        </div>
                        <div class="mb-3">
                            <audio controls loop style="width: 100%; transform: scale(0.9);" class="show_audio">
                                <source src="assets/music/<?= $subject['music'] ?>">
                            </audio>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="data_subjects.php" class="btn btn-secondary">Kembali</a>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function(){
            $(".file_thumbnail").change(function() {
                let thumb = $(this).siblings('img');
                let reader = new FileReader();
                
                reader.onload = function(e) {
                    thumb.attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $(".music_soal").change(function() {
                let audio = $('.show_audio');
                let reader = new FileReader();
                
                reader.onload = function(e) {
                    audio.attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            $('#form_edit_subject').submit(function(e){
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
                            }, 1500);
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
