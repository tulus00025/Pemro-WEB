<?php
    include "../config/db.php";

    $is_completed = $_POST['is_completed'];
    $id_dari_form = $_POST['id'];

    $id = explode("|",base64_decode($id_dari_form));

	$upd = $db->prepare("UPDATE tasks SET is_completed=? WHERE id=?");
	$upd->execute([$is_completed, $id[1]]);
    header("Location: ../index.php");  	
    

?>