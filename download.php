<?php
    session_start();

    $id = $_GET['identificador'];
    $file_type = $_GET['tipo'];
    require_once 'db.php';

    $sql = "SELECT nombre, tipo, contenido, OCTET_LENGTH(contenido) as tamano FROM tbl_archivo WHERE id = " . $id . ";";
    echo $sql;
    $result = $conn->query($sql);
    $rows = $result->fetch_assoc();

    function var_error_log( $object = null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

    if (isset($_SESSION["mode"])) {
        var_error_log($rows);
    }

    header("Content-Type: " . $rows['tipo']);    
    header("Content-Length: " . $rows['tamano']);
    header("Content-Disposition: inline; filename=" . $rows['nombre']);  
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
    ob_clean();
    flush();
    print $rows['contenido'];
    exit;
?>