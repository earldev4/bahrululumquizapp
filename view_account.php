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
    $delete_user = delete_user($_GET['delete_id']);
    echo json_encode($delete_user);
    exit();
}


?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum user App - Lihat Data Murid</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <!-- Tabel Data Murid -->
        <div class="card mt-3 overflow-auto shadow-lg rounded">
            <h5 class="card-header p-3">
                <div class="d-flex justify-content-between align-items-center">
                    <span>Data Murid</span>
                    <div class="d-flex">
                        <a href="dashboard.php" class="btn btn-danger">Kembali</a>
                    </div>

                </div>
            </h5>
            <div class="card-body">
                <table class="table table-bordered table-striped mt-4" class="display" id="table">
                    <thead class="table-secondary">
                        <tr>
                            <th>NIS</th>
                            <th>Username</th>
                            <th>Tanggal Pembuatan Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->query("SELECT user_nis, username, created_at FROM akun_users ORDER BY created_at DESC");
                        $no = 1;
                        while ($row = $stmt->fetch_assoc()) {
                            $no++;
                        ?>
                            <tr>
                                <td><?= $row['user_nis'] ?></td>
                                <td><?= $row['username'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                                <td>
                                    <a href='edit_account.php?user_nis=<?= $row['user_nis'] ?>' class='btn btn-warning btn-sm'>Edit</a>
                                    <button type="button" class="btn_delete btn btn-sm btn-danger" data-bs-toggle="modal" data-user="<?= $row['user_nis'] ?>" data-bs-target="#confirm_delete">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="confirm_delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus User</h1>
                        <button type="button" class="btn_close_delete btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus User?
                    </div>
                    <div class="modal-footer">
                        <form action="view_account.php" id="ajax-delete">
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
                let user_nis = $(this).data('user');
                let row = $(this).closest('tr');
                let form_delete = $('#ajax-delete');

                form_delete.attr('action','view_account.php?delete_id='+user_nis);
                form_delete.data('row',row);
            });

            $('.btn_close_delete').click(function(){
                let form_delete = $('#ajax-delete');

                form_delete.attr('action','view_account.php');
            });

            $('#ajax-delete').submit(function(e){
                e.preventDefault();
                let form = $(this);
                let url = form.attr('action');
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
                                timeOut: 1500
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