<?php
    session_start();
    
    $id = $_GET['identificador'];
    $file = $_GET['documento'];
    require_once 'db.php';
    global $conn;

    $sql = "SELECT nombre, tipo, contenido FROM tbl_archivo WHERE id = " . $id . ";";
    $result = $conn->query($sql);
    $rows = $result->fetch_assoc();
    
    header("Content-Type: " . $rows['tipo']);    
    header("Content-Disposition: attachment; filename=" . $file . "." . $rows['tipo']);  
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    ob_clean();
    flush();
    echo $rows['contenido'];
    exit;
?>