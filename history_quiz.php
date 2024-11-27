<?php
session_start();

if (isset($_SESSION["is_login"]) == false) {
    header("location: login.php");
    exit();
}

include 'includes/db.php';
include 'includes/functions.php';

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pondok Bahrul Ulum Quiz App - Lihat Data Ranking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/2.1.8/css/dataTables.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <div class="container mt-5">
        <!-- Tabel Data quiz -->
        <div class="card mt-3 shadow-lg rounded mb-4">
            <h5 class="card-header p-3">
                <div class="d-flex justify-content-between align-items-center">
                <span>Riwayat Pengerjaan</span>
                    <a href="dashboard.php" class="btn btn-danger">Kembali</a>
                </div>
            </h5>
            <div class="card-body">
                <table class="table table-bordered table-striped mt-4" class="display" id="table">
                    <thead class="table-secondary">
                        <tr>
                            <th>No</th>
                            <th>Nama Quiz</th>
                            <th>Score</th>
                            <th>Pengerjaan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $db->prepare("SELECT * FROM quiz_score LEFT JOIN quiz ON quiz_score.id_quiz = quiz.id_quiz WHERE user_nis=?");
                        $stmt->bind_param("s", $_SESSION['user_nis']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        $no = 0;
                        while ($row = $result->fetch_assoc()) {
                            $no++;
                            $date_create = date_create($row['completed_at']);
                            $date_format = date_format($date_create, "d F Y, H:i");
                        ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $row['title'] ?></td>
                                <td><?= $row['score'] ?></td>
                                <td><?= $date_format ?></td>
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus Quiz</h1>
                        <button type="button" class="btn_close_delete btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah anda yakin ingin menghapus quiz?
                    </div>
                    <div class="modal-footer">
                        <form action="data_quiz.php" id="ajax-delete">
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
        });
    </script>
</body>

</html>