<?php
    session_start();

    if (isset($_SESSION["is_login"]) == false) {
        header("location: login.php");
        exit();
    }
    
    include 'includes/functions.php';
    include 'includes/db.php';
    
    $profile = profile_user($_SESSION["user_nis"]);
    if ($profile["role"] != "admin") {
        header("location: dashboard.php");
        exit();
    }

    if(isset($_GET['delete_id'])){
        $delete_subject = delete_subject($_GET['delete_id']);
        echo json_encode($delete_subject);
        exit();
    }

    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Data Subject</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="container mt-5">
        <!-- Tabel Data Murid -->
        <div class="card mt-3 shadow-lg rounded mb-4">
            <h5 class="card-header p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Data Subject</span>
                    <div class="d-flex">
                        <a href="add_subject.php" class="btn btn-primary me-2">Tambah</a>
                        <a href="dashboard.php" class="btn btn-danger">Kembali</a>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <table class="table table-bordered table-striped mt-4 overflow-auto" class="display" id="table">
                    <thead class="table-secondary">
                        <tr>
                            <th>Image</th>
                            <th>Subject</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data_subject = get_all_data_subject();
                        foreach ($data_subject as $row) { ?>
                            <tr>
                                <td><img src="assets/image/<?= $row['thumbnail']?>" alt="" class="img-fluid rounded"></td>
                                <td><?= $row['subject_name'] ?></td>
                                <td><?= $row['subject_desc'] ?></td>
                                <td>
                                    <div class="d-flex">
                                        <a href='data_quiz.php?id_subject=<?= $row['subject_id'] ?>' class='btn btn-secondary btn-sm me-1'><?= count_quiz_subject($row['subject_id']) ?><span class="ms-1">Quiz</span></a>
                                        <a href='edit_subject.php?id_subject=<?= $row['subject_id'] ?>' class='btn btn-warning btn-sm me-1'>Edit</a>
                                        <button type="button" class="btn_delete btn btn-sm btn-danger" data-bs-toggle="modal" data-subject="<?= $row['subject_id'] ?>" data-bs-target="#confirm_delete">
                                            Hapus
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Subject</h1>
                    <button type="button" class="btn_close_delete btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus subject?
                </div>
                <div class="modal-footer">
                    <form action="data_subjects.php" id="ajax-delete">
                        <button type="button" class="btn_close_delete btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
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
        $(document).ready(function(){
            $('#table').DataTable();

            $('.btn_delete').click(function(){
                let subject_id = $(this).data('subject');
                let row = $(this).closest('tr');
                let form_delete = $('#ajax-delete');

                form_delete.attr('action','data_subjects.php?delete_id='+subject_id);
                form_delete.data('row',row);
            });

            $('.btn_close_delete').click(function(){
                let form_delete = $('#ajax-delete');

                form_delete.attr('action','data_subject.php');
            });

            $('#ajax-delete').submit(function(e){
                e.preventDefault();

                let form = $(this);
                let url = form.attr('action');
                let method = form.attr('method');
                let row = form.data('row');
                
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'JSON',
                    beforeSend: function(){
                        $('#confirm_delete').modal('hide');
                    },
                    success: function(response){
                        if(response.status == 'success'){
                            row.remove();

                            toastr.success(response.message, 'Success !', {
                                closeButton: true,
                                progressBar: true,
                                timeOut: 1500
                            });

                        }else{
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