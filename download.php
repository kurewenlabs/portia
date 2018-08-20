<?php
    session_start();

    $id = $_GET['identificador'];
    $file_type = $_GET['tipo'];
    require_once 'db.php';

    $sql = "SELECT nombre, tipo, contenido FROM tbl_archivo WHERE id = " . $id . ";";
    echo $sql;
    $result = $conn->query($sql);
    $rows = $result->fetch_assoc();
    
    header("Content-Type: " . $rows['tipo']);    
    header("Content-Disposition: attachment; filename=" . $file_type . "." . $rows['tipo']);  
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    ob_clean();
    flush();
    echo $rows['contenido'];
    exit;
?>