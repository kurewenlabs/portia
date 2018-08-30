<?php
session_start();

// 0.- Redcibir identificador
$id = (isset($_POST['identificador'])?$_POST['identificador']:$_GET['identificador']);
$postula = (isset($_POST['postulacion'])?$_POST['postulacion']:$_GET['postulacion']);

// 1.- Conectarse a base de datos
require_once 'db.php';
global $conn;

function save_data_in_DB(){

    global $conn;

    if (isset($_SESSION["mode"])) 
    {
        error_log('save_data_in_DB en progreso');
    }

    $data = $_POST;            
    $sql = '';
    
    // Identificador de postulacion
    $idPost=$_POST['identificador'];

    // Llenamos los valores
    $valores = array();
    foreach($_POST AS $name => $value)
    {
        $valores[$name] = $value;
        $$name = $value;
    }
    $tipo_documento = (isset($pasaporte) && $pasaporte != ''?'pasaporte':'rut');

    //insert tabla tbl_postulante
    $sql =  "REPLACE INTO tbl_postulante (
                        id_post, 
                        tipo_documento,
                        rut, 
                        nombres, 
                        apellidop, 
                        apellidom, 
                        fecha_nacimiento, 
                        sexo, 
                        estado_civil, 
                        nacionalidad, 
                        telefono, 
                        telefono_recado, 
                        email, 
                        provincia, 
                        comuna, 
                        domicilio ) 
                VALUES (
                        '$idPost',
                        '$tipo_documento',
                        '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                        '$primerNombre',
                        '$primerApellido',
                        '$segundoApellido',
                        '$fechaNacimiento',
                        '$sexo',
                        '$estado_civil',
                        '$nacionalidad',
                        '$telefono',
                        '$telefonoRecado',
                        '$email',
                        '$region',
                        '$comuna',
                        '$domicilio'
                        );";
        
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante ' . mysqli_error($conn));
        return false;
    }

    //tabla tbl_estudio
    $sql = "DELETE FROM tbl_estudio WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }
    
    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_estudio ' . mysqli_error($conn));
        return false;
    }

    // Insertar o actualizar tbl_estudio 
    $sql =  "REPLACE INTO tbl_estudio (
                            id, 
                            id_post, 
                            rut, 
                            tipo_estudio, 
                            titulo, 
                            estado, 
                            fecha_titulacion,
                            semestres ) 
                    VALUES (
                            NULL,
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$estudio',
                            '$titulo',
                            '$estado_estudio',
                            '$fecha_estudio',
                            $semestres
                            );";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_estudio ' . mysqli_error($conn));
        return false;
    }

    // Insertar o actualizar tbl_estudio 
    $sql =  "UPDATE tbl_postulante SET tlicenciaconducir = '$licencia' WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_estudio ' . mysqli_error($conn));
        return false;
    }

    // Eliminamos los cursos anteriores
    $sql = "DELETE FROM tbl_curso WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_curso ' . mysqli_error($conn));
        return false;
    }

    // Insertamos los cursos   
    if ($curso1 != '') {
        $sql = "REPLACE INTO tbl_curso (
                                id, 
                                id_post,
                                rut,
                                curso,
                                fecha)
                        VALUES (
                                NULL,
                                '$idPost',
                                '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                                '$curso1',    
                                '$fecha_curso1')";

        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }
            
        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_curso ' . mysqli_error($conn));
            return false;
        }
    }
    if ($curso2 != '') {
        $sql = "REPLACE INTO tbl_curso (
                            id, 
                            id_post,
                            rut,
                            curso,
                            fecha)
                    VALUES (
                            NULL,
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$curso2',    
                            '$fecha_curso2')";

        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_curso ' . mysqli_error($conn));
            return false;
        }
    }
    if ($curso3 != '') {
        $sql = "REPLACE INTO tbl_curso (
                            id, 
                            id_post,
                            rut,
                            curso,
                            fecha)
                    VALUES (
                            NULL,
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$curso3',    
                            '$fecha_curso3')";

        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_curso ' . mysqli_error($conn));
            return false;
        }
    }

    // Eliminamos la experiencia anterior
    $sql = "DELETE FROM tbl_experiencia_laboral WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn));
        return false;
    }

    // Insertamos la experiencia laboral
    $sql = "UPDATE tbl_postulante 
               SET experiencialaboral = '$experiencia'  
             WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante' . mysqli_error($conn));
        return false;
    }
            
    if($experiencia == 'Si')
    {        
        if ($empresa1 != '') {
            $sql = "REPLACE INTO tbl_experiencia_laboral (
                                id, 
                                id_post,
                                rut,
                                empresa,
                                cargo,
                                fecha_desde,
                                fecha_hasta )
                            VALUES (
                                NULL, 
                                '$idPost',
                                '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                                '$empresa1',
                                '$cargo1',
                                '$fechaini_cargo1',
                                '$fechafin_cargo1'
                                )";
                    
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn));
                return false;
            }
        }
        if ($empresa2 != '') {
            $sql = "REPLACE INTO tbl_experiencia_laboral (
                            id, 
                            id_post,
                            rut,
                            empresa,
                            cargo,
                            fecha_desde,
                            fecha_hasta )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$empresa2',
                            '$cargo2',
                            '$fechaini_cargo2',
                            '$fechafin_cargo2'
                            )";
                
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn));
                return false;
            }
        }
        if ($empresa3 != '') {
            $sql = "REPLACE INTO tbl_experiencia_laboral (
                            id, 
                            id_post,
                            rut,
                            empresa,
                            cargo,
                            fecha_desde,
                            fecha_hasta )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$empresa3',
                            '$cargo3',
                            '$fechaini_cargo3',
                            '$fechafin_cargo3'
                            )";
                
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn));
                return false;
            }
        }
    }

    // Eliminamos la referencia anterior
    $sql = "DELETE FROM tbl_referencia_laboral WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn));
        return false;
    }

    // Insertamos la referencia laboral
    $sql = "UPDATE tbl_postulante 
               SET referencialaboral = '$referencia'  
             WHERE id_post = '$idPost'";
    
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante ' . mysqli_error($conn));
        return false;
    }

    if ($empresaref1 != '') {
        $sql = "REPLACE INTO tbl_referencia_laboral (
                            id, 
                            id_post,
                            rut,
                            empresa,
                            nombre_contacto,
                            cargo,
                            telefono,
                            email)
                        VALUES (
                            NULL,
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$empresaref1',
                            '$contactoref1',
                            '$cargoref1',
                            '$telefonoref1',
                            '$emailref1')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn));
            return false;
        }
    }
    if ($empresaref1 != '') {
        $sql = "REPLACE INTO tbl_referencia_laboral (
                            id, 
                            id_post,
                            rut,
                            empresa,
                            nombre_contacto,
                            cargo,
                            telefono,
                            email)
                        VALUES (
                            NULL,
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$empresaref2',
                            '$contactoref2',
                            '$cargoref2',
                            '$telefonoref2',
                            '$emailref2')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn));
            return false;
        }
    }
    if ($empresaref1 != '') {
        $sql = "REPLACE INTO tbl_referencia_laboral (
                            id, 
                            id_post,
                            rut,
                            empresa,
                            nombre_contacto,
                            cargo,
                            telefono,
                            email)
                        VALUES (
                            NULL,
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$empresaref3',
                            '$contactoref3',
                            '$cargoref3',
                            '$telefonoref3',
                            '$emailref3')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn));
            return false;
        }
    }

    // Eliminamos horarios anteriores
    $sql = "DELETE FROM tbl_horario_trabajo WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
        return false;
    }

    // Insertamos los horarios        
    if ($dias_work1 != null) {
        $sql = "REPLACE INTO tbl_horario_trabajo (
                            id, 
                            id_post,
                            rut,
                            dias,
                            horarios )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$dias_work1',
                            '$horaini_work1 a $horafin_work1')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
            return false;
        }
    }        
    if ($dias_work2 != null) {
        $sql = "REPLACE INTO tbl_horario_trabajo (
                            id, 
                            id_post,
                            rut,
                            dias,
                            horarios )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$dias_work2',
                            '$horaini_work2 a $horafin_work2')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
            return false;
        }
    }        
    if ($dias_work3 != null) {
        $sql = "REPLACE INTO tbl_horario_trabajo (
                            id, 
                            id_post,
                            rut,
                            dias,
                            horarios )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$dias_work3',
                            '$horaini_work3 a $horafin_work3')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
            return false;
        }
    }        
    if ($dias_work4 != null) {
        $sql = "REPLACE INTO tbl_horario_trabajo (
                            id, 
                            id_post,
                            rut,
                            dias,
                            horarios )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$dias_work4',
                            '$horaini_work4 a $horafin_work4')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
            return false;
        }
    }        
    if ($dias_work5 != null) {
        $sql = "REPLACE INTO tbl_horario_trabajo (
                            id, 
                            id_post,
                            rut,
                            dias,
                            horarios )
                        VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$dias_work5',
                            '$horaini_work5 a $horafin_work5')";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
            return false;
        }
    }        

    // Eliminamos comunas anteriores
    $sql = "DELETE FROM tbl_comuna WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_comuna ' . mysqli_error($conn));
        return false;
    }

    // Insertamos la comuna
    $sql = "REPLACE INTO tbl_comuna(
                id, 
                id_post,
                region,
                comuna)
            VALUES (
                NULL,
                '$idPost',
                '$region_work',
                '$comuna_work')";
    
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }
        
    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_comuna ' . mysqli_error($conn));
        return false;
    }

    $sql = "UPDATE tbl_postulante 
               SET afp = '$afp', 
                   prestadorsalud = '$isapre'  
             WHERE id_post = '$idPost'";
    
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante ' . mysqli_error($conn));
        return false;
    }

    $sql = "UPDATE tbl_postulante 
               SET tpolera = '$uniforme', 
                   tpoleron = '$uniforme2', 
                   tpantalon = '$talla_pantalon', 
                   tzapatos = '$talla_zapato', 
                   renta = '$renta' 
             WHERE id_post = '$idPost'";
    
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante ' . mysqli_error($conn));
        return false;
    }
    
    // Vemos los archivos cargados
    $cv = '';
    $cerAntecedentes = '';
    $carnet = '';
    $fotografia = '';

    $sql = "SELECT tipo_archivo, id 
              FROM tbl_archivo 
             WHERE id_post = '$idPost' 
               AND estado = 1";
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }
    $result = $conn->query($sql);
    if ($result->num_rows > 0) 
    {
        // output data of each row
        while($row = $result->fetch_assoc()) 
        {
            if($row['tipo_archivo']=='cv')
            {
                $cv = $row['id'];
            }
            if($row['tipo_archivo']=='cerAntecedentes')
            {
                $cerAntecedentes = $row['id'];
            }
            if($row['tipo_archivo']=='carnet')
            {
                $carnet = $row['id'];
            }
            if($row['tipo_archivo']=='fotografia')
            {
                $fotografia = $row['id'];
            }
        }
    }

    // Eliminamos documentos anteriores
    $sql = "DELETE FROM tbl_documento WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_documento ' . mysqli_error($conn));
        return false;
    }

    // Insertamos los documentos
    $sql =  "REPLACE INTO tbl_documento(
                         id, 
                         id_post, 
                         rut, 
                         cv, 
                         antecedentes,
                         carnet,
                         fotografia) 
                  VALUES (
                         NULL, 
                         '$idPost',
                         '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                         " . (isset($cv) && $cv!=''?$cv:'null') . ",
                         " . (isset($cerAntecedentes) && $cerAntecedentes!=''?$cerAntecedentes:'null') . ",
                         " . (isset($carnet) && $carnet!=''?$carnet:'null') . ",
                         " . (isset($fotografia) && $fotografia!=''?$fotografia:'null') . ");";
    
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_documento ' . mysqli_error($conn));
        return false;
    }

    if (isset($_SESSION["mode"])) 
    {
        error_log("Postulación " . $idPost . " almacenada en DB!");
    }
}

$pagina = (isset($_POST['pagina'])?$_POST['pagina']:$_GET['pagina']);
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
            $error = save_data_in_DB();
            if($error === TRUE) {
                //echo 'Estado actualizado de forma exitosa';
                header('Location: ' . $_SERVER["HTTP_REFERER"] .'&actualizado=ok1');
            }
            else {
                header('Location: ' . $_SERVER["HTTP_REFERER"] .'&actualizado=error1');
            }
        }
        break;
    case 'actualizar_estado':
        $estado = (isset($_POST['group1'])?$_POST['group1']:$_GET['group1']);
        $observacion = (isset($_POST['observacion'])?$_POST['observacion']:"");
        $sql = "UPDATE tbl_datos_postulacion_abierta "
            . " SET estado = '". $estado ."', "
            . " observacion = '" . $observacion . "' "
            . " WHERE id_post = '". $id ."'" 
            . " AND nombre = '". $postula ."'";

        if($conn->query($sql) === TRUE) {
            //echo 'Estado actualizado de forma exitosa';
            header('Location: ' . $_SERVER["HTTP_REFERER"] . (isset($_POST["pagina"])?"&":"?") . 'actualizado=ok1');
        }
        else {
            header('Location: ' . $_SERVER["HTTP_REFERER"] . (isset($_POST["pagina"])?"&":"?") . 'actualizado=error1');
        }
        break;
    default:

}



