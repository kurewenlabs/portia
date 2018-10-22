<?php
    session_start();
    require_once 'db.php';

    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }    

    function save_data_in_DB(){

        global $conn;
    
        if (isset($_SESSION["mode"])) 
        {
            error_log('save_data_in_DB en progreso');
        }

        $data = $_SESSION["postdata"];            
        $sql = '';
        
        // Identificador de postulacion
        $idPost=$data['pos']['id'];

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
        foreach($data['pos']['datos'] AS $registro_i)
        {
            foreach($registro_i AS $id => $value)
            {
                $valores_enviados[$id] = $value;
                $$id = $value;
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
            error_log('Error : tbl_postulante ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_estudio ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
            die();
        }

        error_log($semestres);

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
                                " . (isset($semestres)?$semestres:'0') . "
                                );";

        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_estudio ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_estudio ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_curso ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                error_log('Error : tbl_curso ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_postulante' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_postulante ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_comuna ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                    error_log('Error : tbl_comuna ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_postulante ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_postulante ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_documento ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_documento ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
            error_log('Error : tbl_datos_postulacion_abierta ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
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
                error_log('Error : tbl_datos_postulacion_abierta ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
                die();
            }
        }
    
        if (isset($_SESSION["mode"])) 
        {
            error_log("Postulación " . $idPost . " almacenada en DB!");
        }
    }

    // Captura de los datos por cada uno de los pasos de la postulación
    if(!isset($_SESSION["postdata"]))
    {
        $_SESSION["postdata"]=array("post"=>array());
        $_SESSION["postdata"]["pos"]["id"]=$_POST['pid'];
    }
    if(isset($_POST['action']) && $_POST['action'] == 'firstpagedata')
    {
        $_SESSION["postdata"]["pos"]["pa"] = $_POST['data'];
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'secondpagedata')
    {
        $_SESSION["postdata"]["pos"]["datos"] = $_POST['data'];
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'thirdpagedata')
    {
        $_SESSION["postdata"]["pos"]["estudios"] = $_POST['data'];
        $_SESSION["postdata"]["pos"]["cursos"] = $_POST['data2'];
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'fourthpagedata')
    {
        $_SESSION["postdata"]["pos"]["experiencia"] = $_POST['data'];
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'fifthpagedata')
    {
        $_SESSION["postdata"]["pos"]["referencia"] = $_POST['data'];
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'sixthpagedata')
    {
        $_SESSION["postdata"]["pos"]["horarioT"] = $_POST['data'];
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'seventhpagedata')
    {
        $_SESSION["postdata"]["pos"]["documentos"] = $_POST['data'];

        // Pre-guardado para asegurar que los datos estén a salvo antes de enviar
        // save_data_in_DB();
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'lastpagedata')
    {
        $session_back = $_SESSION["postdata"]["pos"];
        $_SESSION["postdata"]["pos"]["datos"] = $_POST["dataDatos"];
        $_SESSION["postdata"]["pos"]["estudios"] = $_POST["dataEstudios"];
        $_SESSION["postdata"]["pos"]["cursos"] = $_POST["dataCursos"];
        $_SESSION["postdata"]["pos"]["experiencia"] = $_POST["dataExperiencia"];
        $_SESSION["postdata"]["pos"]["referencia"] = $_POST["dataReferencia"];
        $_SESSION["postdata"]["pos"]["horarioT"] = $_POST["dataHorarios"];
        $_SESSION["postdata"]["pos"]["documentos"] = $_POST["dataDocumentos"];

        // Guardado definitivo que actualiza cualquier cambio en los datos del postulante
        save_data_in_DB();

        require_once('src/mailer/PHPMailerAutoload.php');
        $datos = $_SESSION["postdata"]["pos"];
        $email = '';
        $nombre = '';
        $postulaciones = '';
        $data_array = $datos["pa"];
        foreach($data_array as $field) 
        {
            $postulaciones .= $field["nom"] . ', ';
        }
        $postulaciones = substr($postulaciones, 0, strlen($postulaciones)-2);
        $data_array = $datos["datos"];
        foreach($data_array as $field) 
        {
            if (array_key_exists('noms', $field)) 
            {
                $nombre = $field["noms"];
            }
            if (array_key_exists('apeP', $field)) 
            {
                $nombre .= ' ' . $field["apeP"];
            }
            if (array_key_exists('apeM', $field)) 
            {
                $nombre .= ' ' . $field["apeM"];
            }
            if (array_key_exists('email', $field)) 
            {
                $email = $field["email"];
            }
        }

        if (isset($_SESSION["mode"])) 
        {
            error_log('To: ' . $nombre . ' <' . $email . '>');
            error_log('Jobs: ' . $postulaciones);
            error_log((extension_loaded('openssl')?'SSL loaded':'SSL not loaded'));
            error_log('Sending mail...');
        }

        $mail = new PHPMailer(true);

        try {
            $mail->addAddress($email, $nombre);
            $mail->Subject = 'Postulación Recibida';
            $mail->Body = '<html>
<body>
<table width="400" border="0">
<tbody>
<tr>
<th align="left">Estimado ' . $nombre . '</th>
</tr>
<tr>
<th>
<table width="400" border="0">
<tbody>
<tr>
<th align="left"><p>Hemos recibido su postulaci&oacuten para los cargos de: <p></th>
</tr>
<tr>
<th align="left">' . $postulaciones . '</th>
</tr>
<tr>
<th align="left"><p>Por favor, espere que revisemos su solicitud y le informemos del estado del proceso de selecci&oacuten. Saludos cordiales</th>
</tr>
</tbody>
</table>
</th>
</tr>
<tr>
<th align="left">Equipo de Selecci&oacuten de Personal Portia.</th>
</tr>
</tbody>
</table>
</body>
</html>'; 
            $mail->isHTML(true);
            $mail->FromName = "Postulaciones Portia";
            
            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            if (isset($_SESSION["mode"])) {
                // Solo en ambiente de desarrollo
                $mail->setFrom("postulacion@portia.cl", "Postulaciones Portia");
                $mail->addBCC('contacto@kurewen.cl', 'Contacto');
                $mail->Host = 'mail.kurewen.cl';
                $mail->SMTPAuth = true;
                $mail->Username = 'contacto@kurewen.cl';
                $mail->Password = 'malf0805';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
            }
            else {
                // Ambiente de producción
                $mail->setFrom("postulacion@portia.cl", "Postulaciones Portia");
                $mail->addBCC('contacto@kurewen.cl', 'Contacto');
                $mail->Host = 'correo.portia.cl';
                $mail->SMTPAuth = true;
                $mail->Username = 'postulacion@portia.cl';
                $mail->Password = 'PP.2018!!';
                $mail->SMTPSecure = 'ssl';
                $mail->Port = 465;
            }

            $mail->send();
            if (isset($_SESSION["mode"])) 
            {
                error_log('DONE!');
            }
        } catch (Exception $e) {
            error_log('ERROR! ' . $mail->ErrorInfo);
        }
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'graciaspage')
    {
        $idPost = $_SESSION["postdata"]["pos"]["id"];
        $medio  = $_POST['data'][0]['medio'];

        $sql = "UPDATE tbl_postulante 
                   SET medio = '$medio' 
                 WHERE id_post = '$idPost'";
        
        if (isset($_SESSION["mode"])) 
        {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_postulante ' . mysqli_error($conn) . ' (Query : ' . $sql . ')');
            die();
        }
    }
?>
