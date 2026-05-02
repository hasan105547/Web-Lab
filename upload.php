<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title         = mysqli_real_escape_string($conn, trim($_POST['title']));
    $author        = mysqli_real_escape_string($conn, trim($_POST['author']));
    $subject       = mysqli_real_escape_string($conn, trim($_POST['subject']));
    $department_id = mysqli_real_escape_string($conn, trim($_POST['department_id']));
    $type          = mysqli_real_escape_string($conn, $_POST['type']);

    $file      = $_FILES['file'];
    $ext       = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $allowed   = ['pdf','doc','docx','ppt','pptx'];

    if (!in_array($ext, $allowed)) {
        header("Location: index.php?msg=error&reason=filetype");
        exit;
    }

    $filename  = time() . "_" . preg_replace('/[^a-zA-Z0-9._-]/', '_', basename($file['name']));
    $file_path = "uploads/" . $filename;

    if (!is_dir("uploads")) mkdir("uploads", 0755, true);

    if (move_uploaded_file($file['tmp_name'], $file_path)) {
        $sql = "INSERT INTO books (title, author, subject, department_id, type, file_type, file_path, filename)
                VALUES ('$title','$author','$subject','$department_id','$type','$ext','$file_path','$filename')";
        mysqli_query($conn, $sql);
        header("Location: index.php?msg=success");
    } else {
        header("Location: index.php?msg=error&reason=upload");
    }
    exit;
}
?>
