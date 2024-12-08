<?php
    include "../config/db.php";

    $title = $_POST['title'];
    $description = $_POST['description'];
    $category_id = $_POST['category_id'];
    $id_dari_form = $_POST['id'];

    $id = explode("|",base64_decode($id_dari_form));

	$upd = $db->prepare("UPDATE tasks SET title=?,description=?,category_id=? WHERE id=?");
	$upd->execute([$title,$description, $category_id, $id[1]]);
    header("Location: ../index.php");  	
    

?>