<?php
     include "../config/db.php";

     $id = explode("|", base64_decode($_GET['id']));

     $del = $db->prepare("DELETE FROM tasks WHERE id=?");
     $del->execute([$id[1]]);

     header("Location: ../index.php");
?>