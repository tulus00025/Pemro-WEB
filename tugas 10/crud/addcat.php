<?php
include "../config/db.php";
$name = $_POST['name'];
try {
    $ins = $db->prepare("INSERT INTO categories (name) VALUES (?)");
    $ins->execute([$name]);
    header("Location: ../index.php");
} catch (Exception $e) {

    header("Location:../index.php");
}

?>