<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id     = (int)$_GET['id'];
    $result = mysqli_query($conn, "SELECT filename FROM books WHERE id=$id");
    $row    = mysqli_fetch_assoc($result);
    if ($row) {
        @unlink("uploads/" . $row['filename']);
        mysqli_query($conn, "DELETE FROM books WHERE id=$id");
    }
}
header("Location: index.php");
exit;
?>
