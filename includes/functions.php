<?php
function count_quiz_subject($subject_id)
{
    include 'db.php';

    $stmt = $db->prepare("SELECT subject_id FROM quiz WHERE subject_id=?");
    $stmt->bind_param("i", $subject_id);
    $stmt->execute();

    // Jumlah quiz per subject
    $response = $stmt->get_result()->num_rows;

    return $response;
}

function profile_user($user_nis)
{
    include 'db.php';
    $stmt = $db->prepare("SELECT user_nis, username, role FROM akun_users WHERE user_nis=?");
    $stmt->bind_param("s", $user_nis);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    return $result;
}

function get_all_data_subject()
{
    include 'db.php';

    $stmt = $db->prepare("SELECT * FROM subject");
    $stmt->execute();

    $results = $stmt->get_result();

    if ($results->num_rows > 0) {
        while ($row = $results->fetch_assoc()) {
            $response[] = [
                'subject_id' => $row['subject_id'],
                'thumbnail' => $row['thumbnail'],
                'subject_name' => $row['subject_name'],
                'subject_desc' => $row['subject_desc']
            ];
        }
    } else {
        $response = [];
    }

    return $response;
}

function get_single_subject($subject_id){
    include 'includes/db.php';

    if (isset($subject_id)) {
        $stmt = $db->prepare("SELECT * FROM subject WHERE subject_id = ?");
        $stmt->bind_param("i", $subject_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        $subject = $result->fetch_assoc();
    
        if (!$subject) {
            echo "<script>alert('Subject tidak ditemukan!'); location.href='subject.php'</script>";
            exit();
        }
    } else {
        echo "id subject tidak disertakan!";
        exit();
    }

    return $subject;
}

function insert_subject($subject_name, $subject_desc, $tmp_name, $thumbnail, $tmp_name_music, $music)
{
    include 'includes/db.php';

    if ($subject_name && $subject_desc != '') {

        if ($thumbnail != '') {

            $rand_image = rand() . '-' . $thumbnail;
            $insert_dir = "assets/image/$rand_image";
            move_uploaded_file($tmp_name, $insert_dir);

            $set_thumbnail = $rand_image;
        } else {
            $set_thumbnail = 'default_thumbnail.png';
        }

        if ($music != '') {
            $rand_music = rand() . '-' . $music;
            $insert_dir_music = "assets/music/$rand_music";
            move_uploaded_file($tmp_name_music, $insert_dir_music);

            $set_music = $rand_music;
        } else {
            $set_music = null;
        }

        $stmt = $db->prepare("INSERT INTO subject (thumbnail, subject_name, subject_desc, music) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $set_thumbnail, $subject_name, $subject_desc, $set_music);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Subject berhasil ditambahkan',
            'redirect' => 'data_subjects.php'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Semua field wajib diisi',
        ];
    }

    return $response;
}

function update_subject($subject_id, $subject_name, $subject_desc, $tmp_name, $thumbnail, $tmp_name_music, $music)
{
    include 'includes/db.php';

    if ($subject_id && $subject_name && $subject_desc != '') {

        $subject = $db->prepare("SELECT thumbnail,music FROM subject WHERE subject_id=?");
        $subject->bind_param("i", $subject_id);
        $subject->execute();
        $result = $subject->get_result();
        $thumbnail_name_db = $result->fetch_assoc();

        if ($result->num_rows > 0) {

            if ($thumbnail != '') {
                $delete_dir = "assets/image/$thumbnail_name_db[thumbnail]";
                unlink($delete_dir);

                $rand_image = rand() . '-' . $thumbnail;
                $update_dir = "assets/image/$rand_image";
                move_uploaded_file($tmp_name, $update_dir);

                $set_thumbnail = $rand_image;
            } else {
                $set_thumbnail = $thumbnail_name_db['thumbnail'];
            }

            if ($music != '') {
                if($thumbnail_name_db['music'] != null){
                    $delete_dir_music = "assets/music/$thumbnail_name_db[music]";
                    unlink($delete_dir_music);
                }

                $rand_music = rand() . '-' . $music;
                $insert_dir_music = "assets/music/$rand_music";
                move_uploaded_file($tmp_name_music, $insert_dir_music);
    
                $set_music = $rand_music;
            } else {
                $set_music = $thumbnail_name_db['music'];
            }
    

            $stmt = $db->prepare("UPDATE subject SET thumbnail=?, subject_name=?, subject_desc=?, music=? WHERE subject_id=?");
            $stmt->bind_param("ssssi", $set_thumbnail, $subject_name, $subject_desc, $set_music, $subject_id);
            $stmt->execute();

            $response = [
                'status' => 'success',
                'message' => 'Subject berhasil diedit',
                'redirect' => 'data_subjects.php'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Subject tidak ditemukan'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Semua field wajib diisi',
        ];
    }

    return $response;
}

function delete_subject($id)
{
    include 'includes/db.php';

    if ($id != '') {
        $quiz = $db->prepare("SELECT subject_id FROM quiz WHERE subject_id=?");
        $quiz->bind_param("i", $id);
        $quiz->execute();
        $quiz_result = $quiz->get_result();

        if ($quiz_result->num_rows < 1) {
            $subject = $db->prepare("SELECT thumbnail, music FROM subject WHERE subject_id=?");
            $subject->bind_param("i", $id);
            $subject->execute();
            $result = $subject->get_result()->fetch_assoc();

            if ($result['thumbnail'] != 'default_thumbnail.png') {
                $delete_file = "assets/image/$result[thumbnail]";
                unlink($delete_file);
            }
            if ($result['music'] != '' || $result['music'] != null) {
                $delete_file = "assets/music/$result[music]";
                unlink($delete_file);
            }

            $stmt = $db->prepare("DELETE FROM subject WHERE subject_id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $response = [
                'status' => 'success',
                'message' => 'Subject berhasil dihapus'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Kosongkan quiz didalam subject terlebih dahulu'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Id subject tidak ditemukan'
        ];
    }

    return $response;
}

function get_data_quiz($id_quiz)
{
    include 'includes/db.php';

    if ($id_quiz != '') {

        $stmt = $db->prepare("SELECT id_quiz, subject_id, title, quiz_time, status FROM quiz WHERE id_quiz=?");
        $stmt->bind_param("i", $id_quiz);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();

        if (!$result) {
            echo "<script>alert('Quiz tidak ditemukan!'); location.href='data_quiz.php?id_subject=$result[subject_id]'</script>";
            exit();
        }
    } else {
        echo "<script>alert('Quiz tidak ditemukan!'); location.href='data_subjects.php'</script>";
        exit();
    }

    return $result;
}

function quiz_status($user_nis, $id_quiz)
{
    include "db.php";
    $stmt = $db->prepare("SELECT user_nis, id_quiz FROM quiz_score WHERE user_nis=? AND id_quiz=?");
    $stmt->bind_param("si", $user_nis, $id_quiz);
    $stmt->execute();
    // Jumlah user per quiz
    $response = $stmt->get_result()->num_rows;

    return $response;
}

function insert_quiz($subject_id, $judul_quiz, $hour, $min, $sec)
{
    include 'includes/db.php';

    $hours = isset($hour) ? intval($hour) : 0;
    $mins = isset($min) ? intval($min) : 0;
    $secs = isset($sec) ? intval($sec) : 0;

    $time = ($hours * 3600) + ($mins * 60) + $secs;

    if ($judul_quiz != '') {

        $created_at = date("Y-m-d H:i:s");

        $stmt = $db->prepare("INSERT INTO quiz (subject_id, title, quiz_time, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isis", $subject_id, $judul_quiz, $time, $created_at);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Quiz berhasil dibuat',
            'redirect' => 'data_quiz.php?id_subject=' . $subject_id . ''
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Judul quiz wajib diisi'
        ];
    }

    return $response;
}

function update_quiz($id_quiz, $subject_id, $judul_quiz, $hour, $min, $sec, $status)
{
    include 'includes/db.php';

    $hours = isset($hour) ? intval($hour) : 0;
    $mins = isset($min) ? intval($min) : 0;
    $secs = isset($sec) ? intval($sec) : 0;

    $time = ($hours * 3600) + ($mins * 60) + $secs;

    if ($judul_quiz != '') {
        $stmt = $db->prepare("UPDATE quiz SET subject_id=?, title=?, quiz_time=?, status=? WHERE id_quiz=?");
        $stmt->bind_param("isisi", $subject_id, $judul_quiz, $time, $status, $id_quiz);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Quiz berhasil diupdate',
            'redirect' => 'data_quiz.php?id_subject=' . $subject_id . ''
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Judul quiz wajib diisi'
        ];
    }

    return $response;
}

function delete_quiz($id)
{
    include 'includes/db.php';

    if ($id != '') {
        $question = $db->prepare("SELECT id_quiz FROM questions WHERE id_quiz=?");
        $question->bind_param("i", $id);
        $question->execute();
        $quest_result = $question->get_result();

        if ($quest_result->num_rows < 1) {
            $stmt = $db->prepare("DELETE FROM quiz WHERE id_quiz=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();

            $response = [
                'status' => 'success',
                'message' => 'Quiz berhasil dihapus'
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Kosongkan soal didalam quiz terlebih dahulu'
            ];
        }
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Id quiz tidak ditemukan'
        ];
    }

    return $response;
}

function insert_user($user_nis, $user_name, $user_password)
{
    include 'includes/db.php';

    $date = date("Y-m-d H:i:s");

    if ($user_nis && $user_password && $user_name != '') {
        $stmt = $db->prepare("INSERT INTO akun_users (user_nis, username, password, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $user_nis, $user_name, $user_password, $date);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'User berhasil Ditambah',
            'redirect' => 'view_account.php'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Semua field wajib diisi'
        ];
    }

    return $response;
}

function update_user($user_nis, $user_name, $user_password)
{
    include 'includes/db.php';

    if ($user_nis && $username != '') {
        $password = $db->prepare("SELECT password FROM akun_users WHERE user_nis=?");
        $password->bind_param("s", $user_nis);
        $password->execute();
        $result = $password->get_result()->fetch_assoc();

        if ($user_password != "") {
            $user_new_password = $user_password;
        } else {
            $user_new_password = $result["password"];
        }

        $stmt = $db->prepare("UPDATE akun_users SET username=? , password=? WHERE user_nis=?");
        $stmt->bind_param("sss", $user_name, $user_new_password, $user_nis);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'User berhasil diubah',
            'redirect' => 'view_account.php'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Semua field wajib diisi'
        ];
    }

    return $response;
}

function delete_user($user_nis)
{
    include 'includes/db.php';

    if ($user_nis != '') {
        $stmt = $db->prepare("DELETE FROM akun_users WHERE user_nis=?");
        $stmt->bind_param("i", $user_nis);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'User berhasil dihapus'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'NIS User tidak ditemukan'
        ];
    }

    return $response;
}

function count_question_quiz($id_quiz)
{
    include 'includes/db.php';

    $stmt = $db->prepare("SELECT id_quiz FROM questions WHERE id_quiz=?");
    $stmt->bind_param("i", $id_quiz);
    $stmt->execute();

    $result = $stmt->get_result()->num_rows;

    return $result;
}

function get_question_for_quiz($id_quiz)
{
    include 'includes/db.php';

    $stmt = $db->prepare("SELECT id_question, image_soal, question_text, options FROM questions WHERE id_quiz=?");
    $stmt->bind_param("i", $id_quiz);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $response[] = [
                'id_question' => $row['id_question'],
                'image_soal' => $row['image_soal'],
                'question_text' => $row['question_text'],
                'options' => json_decode($row['options'], true)
            ];
        }
    }

    return $response;
}

function insert_question($id_quiz, $image_soal, $tmp_name, $question_text, $option_a, $option_b, $option_c, $option_d, $answer)
{
    include 'includes/db.php';

    if ($question_text && $option_a && $option_b && $option_c && $option_d && $answer != '') {

        if ($image_soal != null) {
            $rand_image = rand() . '-' . $image_soal;
            $insert_dir = "assets/image_soal/$rand_image";
            move_uploaded_file($tmp_name, $insert_dir);
        } else {
            $rand_image = null;
        }

        $option = [
            "options" => [
                "a" => $option_a,
                "b" => $option_b,
                "c" => $option_c,
                "d" => $option_d,
            ],
            "answer" => $answer
        ];

        $options = json_encode($option, true);
        $created_at = date("Y-m-d H:i:s");
        
        $stmt = $db->prepare("INSERT INTO questions (id_quiz, image_soal, question_text, options, created_at) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $id_quiz, $rand_image, $question_text, $options, $created_at);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Berhasil menambah soal',
            'redirect' => 'data_question.php?id_quiz=' . $id_quiz . ''
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Semua field wajib diisi'
        ];
    }

    return $response;
}

function update_question($id_question, $id_quiz, $image_soal, $tmp_name, $question_text, $option_a, $option_b, $option_c, $option_d, $answer)
{
    include 'includes/db.php';

    if ($question_text && $option_a && $option_b && $option_c && $option_d && $answer != '') {

        $image = $db->prepare("SELECT image_soal FROM questions WHERE id_question=?");
        $image->bind_param("i", $id_question);
        $image->execute();
        $result = $image->get_result()->fetch_assoc();

        if ($image_soal != null) {
            if ($result['image_soal'] != null) {
                $delete_dir = "assets/image_soal/$result[image_soal]";
                unlink($delete_dir);
            }

            $rand_image = rand() . '-' . $image_soal;
            $update_dir = "assets/image_soal/$rand_image";
            move_uploaded_file($tmp_name, $update_dir);
        } else {
            $rand_image = $result['image_soal'];
        }

        $option = [
            "options" => [
                "a" => $option_a,
                "b" => $option_b,
                "c" => $option_c,
                "d" => $option_d,
            ],
            "answer" => $answer
        ];

        $options = json_encode($option, true);
        $stmt = $db->prepare("UPDATE questions SET id_quiz=?, image_soal=?, question_text=?, options=? WHERE id_question=? ");
        $stmt->bind_param("isssi", $id_quiz, $rand_image, $question_text, $options, $id_question);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Berhasil mengedit soal',
            'redirect' => 'data_question.php?id_quiz=' . $id_quiz . ''
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Semua field wajib diisi'
        ];
    }

    return $response;
}


function delete_question($id)
{
    include 'includes/db.php';

    if ($id != '') {
        $image = $db->prepare("SELECT image_soal FROM questions WHERE id_question=?");
        $image->bind_param("i", $id);
        $image->execute();
        $result = $image->get_result()->fetch_assoc();

        if ($result['image_soal'] != null) {
            $delete_dir = "assets/image_soal/$result[image_soal]";
            unlink($delete_dir);
        }

        $stmt = $db->prepare("DELETE FROM questions WHERE id_question=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $response = [
            'status' => 'success',
            'message' => 'Quiz berhasil dihapus'
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Id quiz tidak ditemukan'
        ];
    }

    return $response;
}
