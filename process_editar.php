<?php
session_start();

// 0.- Redcibir identificador
$id = $_POST['identificador'];
$postula = $_POST['postulacion'];

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
    $idPost=['id'];

    // Inicializamos las variables
    $fecha_post = date('Y-m-d');
    $rut='';
    $pasaporte='';
    $noms='';
    $apeP='';
    $apeM='';
    $fNaci='';
    $sexo='';
    $eCivil='';
    $nacionalidad='';
    $telefono='';
    $telRec='';
    $email='';
    $provi='';
    $comuna='';
    $direccion='';
    $tPolera='';
    $tPantalon='';
    $tPoleron='';
    $tZapatos='';
    $renta='';
    $tlicencia='';
    $afp='';
    $salud='';
    $exLaboral='';
    $referencialaboral='';

    // Llenamos los valores
    $valores_enviados = array();
    foreach($data['datos'] AS $registro_i)
    {
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
            error_log($id . " = " . $value);
        }
    }
    $tipo_documento = (isset($pasaporte) && $pasaporte != ''?'pasaporte':'rut');

    //insert tabla tbl_postulante
    $sql =  "REPLACE INTO tbl_postulante (
                        id_post, 
                        fecha_post, 
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
                        domicilio, 
                        tpolera, 
                        tpantalon, 
                        tpoleron, 
                        tzapatos, 
                        renta, 
                        tlicenciaconducir, 
                        afp, 
                        prestadorsalud, 
                        experiencialaboral, 
                        referencialaboral ) 
                VALUES (
                        '$idPost',
                        '$fecha_post',
                        '$tipo_documento',
                        '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                        '$noms',
                        '$apeP',
                        '$apeM',
                        '$fNaci',
                        '$sexo',
                        '$eCivil',
                        '$nacionalidad',
                        '$telefono',
                        '$telRec',
                        '$email',
                        '$provi',
                        '$comuna',
                        '$direccion',
                        '$tPolera',
                        '$tPantalon',
                        '$tPoleron',
                        '$tZapatos',
                        '$renta',
                        '$tlicencia',
                        '$afp',
                        '$salud',
                        '$exLaboral ',
                        '$referencialaboral'
                        );";
        
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante ' . mysqli_error($conn));
        die();
    }

    //tabla tbl_estudio
    
    $tipoEstudio='';
    $titulo='';
    $estado_estudio='';
    $fechaEstudio='';
    $semestres='';
    
    $valores_enviados = array();
    foreach($data['pos']['estudios'] AS $registro_i)
    {
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
        }
    }

    // Eliminamos el estudio anterior
    $sql = "DELETE FROM tbl_estudio WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }
    
    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_estudio ' . mysqli_error($conn));
        die();
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
                            '$tipoEstudio',
                            '$titulo',
                            '$estado_estudio',
                            '$fechaEstudio',
                            $semestres
                            );";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_estudio ' . mysqli_error($conn));
        die();
    }

    // Insertar o actualizar tbl_estudio 
    $sql =  "UPDATE tbl_postulante SET tlicenciaconducir = '$licencia[0]' WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_estudio ' . mysqli_error($conn));
        die();
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
        die();
    }

    // Insertamos los cursos   
    $valores_enviados = array();
    foreach($data['pos']['cursos'] AS $registro_i)
    {
        $nombre='';
        $fecha='';
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
        }
        
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
                            '$nombre',    
                            '$fecha')";
                
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }
                        
        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_curso ' . mysqli_error($conn));
            die();
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
        die();
    }

    // Insertamos la experiencia laboral
    foreach($data['pos']['experiencia'] AS $registro_i)
    {   
        $empresa='';
        $cargo='';
        $fechaDesde='';
        $fechaHasta='';
        
        $valores_enviados = array();
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
        }

        if($experiencia != '')
        {
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
                die();
            }
            
        } else {
            
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
                                '$empresa',
                                '$cargo',
                                '$fechaDesde',
                                '$fechaHasta'
                                )";
                    
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }
    
            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn));
                die();
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
        die();
    }

    // Insertamos la referencia laboral
    $valores_enviados = array();
    foreach($data['pos']['referencia'] AS $registro_i)
    {    
        $empresa='';
        $nombreContacto='';
        $cargo='';
        $telefono='';
        $email='';
        $referencia_laboral ='';
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
        }
        
        if($referencia_laboral != '')
        {
            $sql = "UPDATE tbl_postulante 
                       SET referencialaboral = '$referencia_laboral'  
                     WHERE id_post = '$idPost'";
            
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_postulante ' . mysqli_error($conn));
                die();
            }
            
        } else {
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
                                '$empresa',
                                '$nombreContacto',
                                '$cargo',
                                '$telefono',
                                '$email')";
            
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn));
                die();    
            }
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
        die();
    }

    // Insertamos los horarios
    $comunas='';
    $afp='';
    $isapre='';
        
    $valores_enviados = array();
    foreach($data['pos']['horarioT'] AS $registro_i)
    {
        $dias='';
        $horarios='';
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
            if($id == 'dias')
            {
                $$id = '';
                foreach($value AS $dia_i)
                {
                    $$id .= $dia_i. ', ';
                }
            } else {
                $$id = $value;
            }
        }
        if($dias != '')
        {                
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
                                '$dias',
                                '$horarios')";
            
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
                die();
            }
        }
        if($comunas != '')
        {    
            // Eliminamos comunas anteriores
            $sql = "DELETE FROM tbl_comuna WHERE id_post = '$idPost'";

            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_comuna ' . mysqli_error($conn));
                die();
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
                        '$region',
                        '$comunas')";
            
            if (isset($_SESSION["mode"])) 
            {
                error_log('Query: '. $sql);
            }
                
            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_comuna ' . mysqli_error($conn));
                die();    
            }
        }
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
        die();
    }

    $uniforme='';
    $uniforme2='';
    $tallaPantalon='';
    $tallaZapato='';
    $renta='';
    
    foreach($data['pos']['documentos'] AS $registro_i)
    {
        foreach($registro_i AS $id => $value)
        {
            $$id = $value;
        }
    }

    $sql = "UPDATE tbl_postulante 
               SET tpolera = '$uniforme', 
                   tpoleron = '$uniforme2', 
                   tpantalon = '$tallaPantalon', 
                   tzapatos = '$tallaZapato', 
                   renta = '$renta' 
             WHERE id_post = '$idPost'";
    
    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_postulante ' . mysqli_error($conn));
        die();
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
        die();
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
        die();
    }

    // Eliminamos postulaciones anteriores
    $sql = "DELETE FROM tbl_datos_postulacion_abierta WHERE id_post = '$idPost'";

    if (isset($_SESSION["mode"])) 
    {
        error_log('Query: '. $sql);
    }

    if(!mysqli_query($conn,$sql))
    {
        error_log('Error : tbl_datos_postulacion_abierta ' . mysqli_error($conn));
        die();
    }

    // Insertamos las postulaciones
    $valores_enviados = array();
    foreach($data['pos']['pa'] AS $registro_i)
    {    
        $nun='';
        $nom='';
        $cat='';
        foreach($registro_i AS $id => $value)
        {
            $valores_enviados[$id] = $value;
            $$id = $value;
        }
        
        $sql = "REPLACE INTO tbl_datos_postulacion_abierta(
                            id, 
                            id_post,
                            rut,
                            num,
                            nombre,
                            categoria)
                     VALUES (
                            NULL, 
                            '$idPost',
                            '". ($tipo_documento=='pasaporte'?$pasaporte:$rut) . "',
                            '$nun',
                            '$nom',
                            '$cat')";
                
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_datos_postulacion_abierta ' . mysqli_error($conn));
            die();
        }
    }

    if (isset($_SESSION["mode"])) 
    {
        error_log("Postulación " . $idPost . " almacenada en DB!");
    }
}

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
            print_r($_POST);
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



