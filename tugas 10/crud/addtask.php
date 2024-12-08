<?php
include "../config/db.php";

$title = $_POST['title'];
$description = $_POST['description'];
$category_id = $_POST['category_id'];

try {
    // Persiapan query untuk memasukkan data baru ke dalam tabel tasks
    $ins = $db->prepare("INSERT INTO tasks (title, description, category_id) VALUES (?, ?, ?)");
    
    // Menjalankan query dengan data dari form
    $ins->execute([$title, $description, $category_id]);
    
    // Redirect ke halaman utama 
    header("Location: ../index.php");
} catch (Exception $e) {
    // Redirect ke halaman utama dengan pesan error jika ada kesalahan
    header("Location:../index.php");
}
?>
