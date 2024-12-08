<?php
try {
    $db = new PDO("mysql:host=127.0.0.1;dbname=todolist",'root','');
}catch(PDOException $e){
    echo "Database gagal dihubungkan";
}

?>