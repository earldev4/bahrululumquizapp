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


if(isset($_GET['delete_id'])){
    $delete_question = delete_question($_GET['delete_id']);
    echo json_encode($delete_question);
    exit();
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Lihat Data Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php
    $id_quiz = isset($_GET['id_quiz']) ? $_GET['id_quiz'] : '';
    $result = get_data_quiz($id_quiz);
    ?>
    <div class="container mt-5">
        <!-- Tabel Data quiz -->
        <div class="card mt-3 shadow-lg rounded mb-4">
            <h5 class="card-header p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span><?= $result['title'] ?></span>
                    <div class="d-flex">
                        <a href="add_question.php?id_quiz=<?= $id_quiz ?>" class="btn btn-primary me-2">Buat Soal</a>
                        <a href="data_quiz.php?id_subject=<?= $result['subject_id'] ?>"
                            class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </h5>
            <div class="card-body p-4">
                <?php 
                    $stmt = $db->query("SELECT * FROM questions WHERE id_quiz=$result[id_quiz]");
                    $no = 0;
                    $count_row = $stmt->num_rows;
                ?>
                <h3 class="mb-4 fs-3"><span id="jumlah_soal"><?= $count_row ?></span> Soal</h3>
                <div class="row">
                <?php
                    if($count_row > 0){
                        while ($row = $stmt->fetch_assoc()) {
                        $no++;
                        $date_create = date_create($row['created_at']);
                        $date_format = date_format($date_create, "d F Y, H:i");
                        $options = json_decode($row['options'], true);
                    ?>
                        <div class="col-md-6">
                            <div class="card shadow-sm border rounded mb-4">
                                <div class="card-header">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>Soal <?= $no ?></span>
                                        <div class="d-flex">
                                            <a href="edit_question.php?id_question=<?= $row['id_question'] ?>" class="btn btn-sm btn-outline-secondary me-1">Edit</a>
                                            <button type="button" class="btn_delete btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-question="<?= $row['id_question'] ?>" data-bs-target="#confirm_delete">
                                                Hapus
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body px-3">
                                    <?php if($row['image_soal'] != null){ ?>
                                        <img src="assets/image_soal/<?= $row['image_soal'] ?>" alt="img_soal" class="img-fluid w-50 rounded mb-2">
                                    <?php } ?>
                                    <div class="mb-2"><?= $row['question_text'] ?></div>
                                    <div class="row">
                                        <?php foreach($options['options'] as $key_opt => $text_opt){ ?>
                                            <div class="col-md-6 mb-2">
                                                <span><span class="<?= $key_opt == $options['answer'] ? 'fw-bold' : '' ?>"><?= ucfirst($key_opt) ?>. </span><?= ucfirst($text_opt) ?></span>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
    
                    <?php } 
                    }else{ ?>
                    <p class="text-center">Soal belum dibuat</p>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Soal</h1>
                        <button type="button" class="btn_close_delete btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus soal?
                    </div>
                    <div class="modal-footer">
                        <form action="data_quiz.php" id="ajax-delete">
                            <button type="button" class="btn_close_delete btn btn-secondary"
                                data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Ya, Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="//cdn.datatables.net/2.1.8/js/dataTables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function () {

            $('.btn_delete').click(function () {
                let question_id = $(this).data('question');
                let row = $(this).closest('.col-md-6');
                let form_delete = $('#ajax-delete');
                let jumlah_soal = $('#jumlah_soal').text();

                form_delete.attr('action', 'data_question.php?delete_id=' + question_id);
                form_delete.data('row', row);
                form_delete.data('jumlah_soal', jumlah_soal);
            });

            $('.btn_close_delete').click(function () {
                let form_delete = $('#ajax-delete');

                form_delete.attr('action', 'data_question.php');
            });

            $('#ajax-delete').submit(function (e) {
                e.preventDefault();

                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method');
                let row = form.data('row');
                let jumlah_soal = form.data('jumlah_soal') - 1;

                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'JSON',
                    beforeSend: function () {
                        $('#confirm_delete').modal('hide');
                    },
                    success: function (response) {
                        if (response.status == 'success') {
                            row.remove();
                            $('#jumlah_soal').text(jumlah_soal);

                            toastr.success(response.message, 'Success !', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500
                            });

                        } else {
                            toastr.error(response.message, 'Failed !', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 2500
                            });
                        }
                    },
                });

            });

        });
    </script>
    <script src="app.js"></script>
</body>

</html>