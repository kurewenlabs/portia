<?php
/**
 * Created by PhpStorm.
 * User: web1
 * Date: 26/07/2018
 * Time: 8:31
 */

// 0.- Redcibir identificador
$id = $_POST['identificador'];
$postula = $_POST['postulacion'];

// 1.- Conectarse a base de datos
require_once 'db.php';
global $conn;

// 2.- Preguntar si existe registro
/*


    $sql = "UPDATE tbl_postulante "
        . " SET estado_post = '". $estado ."', "

        . " WHERE id_post = '". $id . "'";

    if($conn->query($sql) === TRUE) {
        //echo 'Estado actualizado de forma exitosa';
        header('Location: ' . $_SERVER["HTTP_REFERER"] .'&jajajajajaja');
    }
    else {
        echo 'Error al actualizar';
    }



    $conn->close();
}*/



$pagina = $_POST['pagina'];
switch ($pagina) {
    case 'datos_personales':
        $sql = "SELECT COUNT(*) AS cantidad FROM tbl_postulante where id_post='".$id."'";
        $cantidad = 1;
        $estado = $_POST["group1"];
        echo $estado;
        if($cantidad == 0) {
            // 3.1.- Insertar registro
            throw new Exception('Debe estar registrado el postulante');
        }
        else {
            $sql = "UPDATE tbl_datos_postulacion_abierta "
                . " SET estado = '". $estado . "', "
                . " WHERE id_post = '". $id ."'" 
                . " AND nombre = '". $postula ."'";

            if($conn->query($sql) === TRUE) {
                //echo 'Estado actualizado de forma exitosa';
                // header('Location: ' . $_SERVER["HTTP_REFERER"] .'&actualizado=ok2');
            }
            else {
                // header('Location: ' . $_SERVER["HTTP_REFERER"] .'&actualizado=error2');
            }
        }
        break;
    case 'actualizar_estado':
        $estado = $_POST['group1'];
        $observacion = $_POST['observacion'];
        $sql = "UPDATE tbl_datos_postulacion_abierta "
            . " SET estado = '". $estado ."', "
            . " observacion = '" . $observacion . "' "
            . " WHERE id_post = '". $id ."'" 
            . " AND nombre = '". $postula ."'";

        /*  return print_r(array(
            'estado' => $estado,
            'observacion' => $observacion,
            'post_id' => $id,
            'sql' => $sql
        ));*/

        if($conn->query($sql) === TRUE) {
            //echo 'Estado actualizado de forma exitosa';
            header('Location: ' . $_SERVER["HTTP_REFERER"] .'&actualizado=ok1');
        }
        else {
            header('Location: ' . $_SERVER["HTTP_REFERER"] .'&actualizado=error1');
        }
        break;
    default:

}



