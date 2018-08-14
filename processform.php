<?php
   session_start();
   
    //$imprimir_json_y_sqls = 1;
    $imprimir_json_y_sqls = 0;

    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
      }    

   function save_data_in_DB(){

        require_once 'db.php';
        global $conn;
     
        //leemos el JSON
        $data = $_SESSION["postdata"];

        global $imprimir_json_y_sqls;
        //convertimos el JSON a arreglo
        //print_r($data);
            
        $sql = '';
        
        error_log("Comenzando el almacenado del postulante...");

        //identificador de postulacion
        $idPost=$data['pos']['id'];
        if (isset($_SESSION["mode"])) {
            $idPost='Pte' . date('YmdHis');
        }

        $fecha_post = date('Y-m-d');
        $tipo_documento='';
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
        
        $valores_enviados = array();
        foreach($data['pos']['datos'] AS $registro_i){
            foreach($registro_i AS $id => $value){
                $valores_enviados[$id] = $value;
                $$id = $value;
            }
        }
        $tipo_documento = (isset($pasaporte)?'pasaporte':'rut');

    //insert tabla tbl_postulante
    $sql =  "INSERT INTO tbl_postulante(
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
            referencialaboral) 
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
            
            if (isset($_SESSION["mode"])) {
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
            $fecha_titulacion='';
            $semestres='';
            
            $valores_enviados = array();
            foreach($data['pos']['estudios'] AS $registro_i){
                foreach($registro_i AS $id => $value){
                    $valores_enviados[$id] = $value;
                    $$id = $value;
                }
            }
            
            //inset tbl_estudio
            $sql =  "INSERT INTO tbl_estudio(
                    id_post, 
                    rut, 
                    tipo_estudio, 
                    titulo, 
                    estado, 
                    fecha_titulacion,
                    semestres) 
                    VALUES (
                    '$idPost',
                    '$rut',
                    '$tipoEstudio',
                    '$titulo',
                    '$estado_estudio',
                    '$fecha_titulacion',
                    $semestres
                    );";

            if (isset($_SESSION["mode"])) {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_estudio ' . mysqli_error($conn));
                die();
            }


        //tabla tbl_curso
            
        $valores_enviados = array();
        foreach($data['pos']['cursos'] AS $registro_i){
            $nombre='';
            $fecha='';
            foreach($registro_i AS $id => $value){
                $valores_enviados[$id] = $value;
                $$id = $value;
            }
            
            $sql = "INSERT INTO tbl_curso(
                    id_post,
                    rut,
                    curso,
                    fecha)
                    VALUES(
                    '$idPost',
                    '$rut',
                    '$nombre',    
                    '$fecha')";
                    
            if (isset($_SESSION["mode"])) {
                error_log('Query: '. $sql);
            }
                            
            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_curso ' . mysqli_error($conn));
                die();
            }
        }
        if(isset($imprimir_json_y_sqls) && ($imprimir_json_y_sqls == 1) ){
            echo '<br/>';
        }
        
        
        //tabla tbl_experiencia_laboral
        foreach($data['pos']['experiencia'] AS $registro_i){
            
            $empresa='';
            $cargo='';
            $fechaDesde='';
            $fechaHasta='';
            
            $valores_enviados = array();
            foreach($registro_i AS $id => $value){
                $valores_enviados[$id] = $value;
                $$id = $value;
            }
            if($experiencia != ''){
                $sql = "UPDATE `tbl_postulante` SET `experiencialaboral` = '$experiencia'  WHERE `tbl_postulante`.`id_post` = '$idPost'";

                if (isset($_SESSION["mode"])) {
                    error_log('Query: '. $sql);
                }
            
                if(!mysqli_query($conn,$sql))
                {
                    error_log('Error : tbl_postulante' . mysqli_error($conn));
                    die();
                }
                
            }else{
                
                $sql = "INSERT INTO tbl_experiencia_laboral(
                        id_post,
                        rut,
                        empresa,
                        cargo,
                        fecha_desde,
                        fecha_hasta)
                        VALUES(
                        '$idPost',
                        '$rut',
                        '$empresa',
                        '$cargo',
                        '$fechaDesde',
                        '$fechaHasta'
                        )";
                        
                if (isset($_SESSION["mode"])) {
                    error_log('Query: '. $sql);
                }
        
                if(!mysqli_query($conn,$sql))
                {
                    error_log('Error : tbl_experiencia_laboral ' . mysqli_error($conn));
                    die();
                }
            }
        }

    
        //tabla tbl_referencia_laboral
        
        $valores_enviados = array();
        foreach($data['pos']['referencia'] AS $registro_i){
            
            $empresa='';
            $nombreContacto='';
            $cargo='';
            $telefono='';
            $email='';
            $referencia_laboral ='';
            foreach($registro_i AS $id => $value){
                $valores_enviados[$id] = $value;
                $$id = $value;
            }
            
            if($referencia_laboral != ''){
                $sql = "UPDATE `tbl_postulante` SET `referencialaboral` = '$referencia_laboral'  WHERE `tbl_postulante`.`id_post` = '$idPost'";
                
                if (isset($_SESSION["mode"])) {
                    error_log('Query: '. $sql);
                }
    
                if(!mysqli_query($conn,$sql))
                {
                    error_log('Error : tbl_postulante ' . mysqli_error($conn));
                    die();
                }
                
            }else{
            
                $sql = "INSERT INTO tbl_referencia_laboral(
                        id_post,
                        rut,
                        empresa,
                        nombre_contacto,
                        cargo,
                        telefono,
                        email)
                        VALUES(
                        '$idPost',
                        '$rut',
                        '$empresa',
                        '$nombreContacto',
                        '$cargo',
                        '$telefono',
                        '$email')";
                
                if (isset($_SESSION["mode"])) {
                    error_log('Query: '. $sql);
                }

                if(!mysqli_query($conn,$sql))
                {
                    error_log('Error : tbl_referencia_laboral ' . mysqli_error($conn));
                    die();    
                }
            }
        }
    
        //tabla tbl_horario_trabajo
        $comunas='';
        $afp='';
        $isapre='';
            
        $valores_enviados = array();
        foreach($data['pos']['horarioT'] AS $registro_i){
            $dias='';
            $horarios='';
            foreach($registro_i AS $id => $value){
                $valores_enviados[$id] = $value;
                $$id = $value;
                if($id == 'dias'){
                    $$id = '';
                    foreach($value AS $dia_i){
                        $$id .= $dia_i. ', ';
                    }
                }else{
                    $$id = $value;
                }
            }
            if($dias != ''){
                
                $sql = "INSERT INTO tbl_horario_trabajo(
                        id_post,
                        rut,
                        dias,
                        horarios)
                        VALUES(
                        '$idPost',
                        '$rut',
                        '$dias',
                        '$horarios')";
                
                if (isset($_SESSION["mode"])) {
                    error_log('Query: '. $sql);
                }

                if(!mysqli_query($conn,$sql))
                {
                    error_log('Error : tbl_horario_trabajo ' . mysqli_error($conn));
                    die();
                }
        
            }
            if($comunas != ''){
                
                $sql = "INSERT INTO tbl_comuna(
                        id_post,
                        region,
                        comuna)
                        VALUES(
                        '$idPost',
                        '$region',
                        '$comunas')";
                
                if (isset($_SESSION["mode"])) {
                    error_log('Query: '. $sql);
                }
                    
                if(!mysqli_query($conn,$sql))
                {
                    error_log('Error : tbl_comuna ' . mysqli_error($conn));
                    die();    
                }
        
            }
        }
        
        $sql = "UPDATE `tbl_postulante` SET `afp` = '$afp', `prestadorsalud` = '$isapre'  WHERE `tbl_postulante`.`id_post` = '$idPost'";
        
        if (isset($_SESSION["mode"])) {
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
            
            //tabla tbl_documento
            $cv = null;
            $cerAntecedentes = null;
            $carnet = null;
            $fotografia = null;

            // Vemos los archivos cargados
            $sql = "SELECT tipo_archivo, id FROM tbl_archivo WHERE id_post = '$idPost' AND estado = 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    $$row['tipo_archivo'] = $row['id'];
                }
            }

            //$contenido_pdf_cv = file_get_contents($cv);            
            //inset tbl_documento
            $sql =  "INSERT INTO tbl_documento(
                    id_post, 
                    rut, 
                    cv, 
                    antecedentes,
                    carnet,
                    fotografia) 
                    VALUES (
                    '$idPost',
                    '$rut',
                    " . (isset($cv) && $cv!=''?$cv:'null') . ",
                    " . (isset($cerAntecedentes) && $cerAntecedentes!=''?$cerAntecedentes:'null') . ",
                    " . (isset($id) && $carnet!=''?$id:'null') . ",
                    " . (isset($fotografia) && $fotografia!=''?$fotografia:'null') . ");";
            
            if (isset($_SESSION["mode"])) {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_documento ' . mysqli_error($conn));
                die();
            }

        $sql = "UPDATE `tbl_postulante` SET `tpolera` = '$uniforme', `tpoleron` = '$uniforme2', `tpantalon` = '$tallaPantalon', `tzapatos` = '$tallaZapato', `renta` = '$renta'  WHERE `tbl_postulante`.`id_post` = '$idPost'";
        
        if (isset($_SESSION["mode"])) {
            error_log('Query: '. $sql);
        }

        if(!mysqli_query($conn,$sql))
        {
            error_log('Error : tbl_postulante ' . mysqli_error($conn));
            die();
        }
        
        
        //tabla tbl_datos_postulacion_abierta
        $valores_enviados = array();
        foreach($data['pos']['pa'] AS $registro_i){
            
            $nun='';
            $nom='';
            $cat='';
            foreach($registro_i AS $id => $value){
                $valores_enviados[$id] = $value;
                $$id = $value;
            }
            
            $sql = "INSERT INTO tbl_datos_postulacion_abierta(
                    id_post,
                    rut,
                    num,
                    nombre,
                    categoria)
                    VALUES(
                    '$idPost',
                    '$rut',
                    '$nun',
                    '$nom',
                    '$cat')";
                    
            if (isset($_SESSION["mode"])) {
                error_log('Query: '. $sql);
            }

            if(!mysqli_query($conn,$sql))
            {
                error_log('Error : tbl_datos_postulacion_abierta ' . mysqli_error($conn));
                die();
            }
        }
    
        error_log("Postulación ".$idPost." almacenada en DB!");
   }
   
   
   if(!isset($_SESSION["postdata"])){
        $_SESSION["postdata"]=array("post"=>array());
        $_SESSION["postdata"]["pos"]["id"]=$_POST['pid'];
        // var_error_log($_SESSION["postdata"]["pos"]["id"]);
   }
   if(isset($_POST['action']) && $_POST['action'] == 'firstpagedata'){
       $_SESSION["postdata"]["pos"]["pa"] = $_POST['data'];
       // var_error_log($_SESSION["postdata"]["pos"]["pa"]);
    } 
   if(isset($_POST['action']) && $_POST['action'] == 'secondpagedata'){
      $_SESSION["postdata"]["pos"]["datos"] = $_POST['data'];
      // var_error_log($_SESSION["postdata"]["pos"]["datos"]);
    } 
   if(isset($_POST['action']) && $_POST['action'] == 'thirdpagedata'){
       $_SESSION["postdata"]["pos"]["estudios"] = $_POST['data'];
       // var_error_log($_SESSION["postdata"]["pos"]["estudios"]);
       $_SESSION["postdata"]["pos"]["cursos"] = $_POST['data2'];
       // var_error_log($_SESSION["postdata"]["pos"]["cursos"]);
    } 
   if(isset($_POST['action']) && $_POST['action'] == 'fourthpagedata'){
       $_SESSION["postdata"]["pos"]["experiencia"] = $_POST['data'];
       // var_error_log($_SESSION["postdata"]["pos"]["experiencia"]);
    } 
   if(isset($_POST['action']) && $_POST['action'] == 'fifthpagedata'){
       $_SESSION["postdata"]["pos"]["referencia"] = $_POST['data'];
       // var_error_log($_SESSION["postdata"]["pos"]["referencia"]);
    } 
   if(isset($_POST['action']) && $_POST['action'] == 'sixthpagedata'){
       $_SESSION["postdata"]["pos"]["horarioT"] = $_POST['data'];
       // var_error_log($_SESSION["postdata"]["pos"]["horarioT"]);
    } 
   if(isset($_POST['action']) && $_POST['action'] == 'seventhpagedata'){
       $_SESSION["postdata"]["pos"]["documentos"] = $_POST['data'];
       save_data_in_DB();
    } 
    if(isset($_POST['action']) && $_POST['action'] == 'lastpagedata'){
        require_once('src/mailer/PHPMailerAutoload.php');

        $datos = $_SESSION["postdata"]["pos"];
        $email = '';
        $nombre = '';
        $postulaciones = '';
        $data_array = $datos["pa"];
        foreach($data_array as $field) {
            $postulaciones .= $field["nom"] . ', ';
        }
        $postulaciones = substr($postulaciones, 0, strlen($postulaciones)-2);
        $data_array = $datos["datos"];
        foreach($data_array as $field) {
            if (array_key_exists('noms', $field)) {
                $nombre = $field["noms"];
            }
            if (array_key_exists('apeP', $field)) {
                $nombre .= ' ' . $field["apeP"];
            }
            if (array_key_exists('apeP', $field)) {
                $nombre .= ' ' . $field["apeM"];
            }
            if (array_key_exists('email', $field)) {
                $email = $field["email"];
            }
        }

        error_log('To: ' . $nombre . ' <' . $email . '>');
        error_log('Jobs: ' . $postulaciones);

        error_log((extension_loaded('openssl')?'SSL loaded':'SSL not loaded'));
        error_log('Sending mail...');

        $mail = new PHPMailer();

        $mail->AddAddress($email, $nombre);
        $mail->AddAddress('andres@kurewen.cl', 'Andrés Muñoz');
        // $mail->AddAddress('curzua@portia.cl', 'curzua@portia.cl');
        // $mail->AddAddress('drincon@portia.cl', 'drincon@portia.cl');
        // $mail->AddAddress('aferreira@portia.cl', 'aferreira@portia.cl');
        $mail->Subject = 'Postulación enviada con éxito';
        $mail->Body = 'Se ha registrado la postulación de ' . $nombre . ' a los cargos de ' . $postulaciones . '.'; 
        $mail->From = "postulacion@portia.cl";
        $mail->FromName = "Postulaciones Portia";
        
        $mail->IsSMTP();
        if (isset($_SESSION["mode"])) {
            $mail->Host = 'mail.kurewen.cl';
            $mail->SMTPSecure = 'ssl'; // tls
            $mail->Port = 465; // 587
            $mail->SMTPAuth = true;
            $mail->Username = 'andres@kurewen.cl';
            $mail->Password = 'Andreskurewen';
        }
        else {
            $mail->Host = 'correo.portia.cl';
            $mail->SMTPSecure = 'ssl'; // tls
            $mail->Port = 465; // 587
            $mail->SMTPAuth = true;
            $mail->Username = 'postulacion@portia.cl';
            $mail->Password = 'PP.2018!!';
        }

        $mail->send();

        error_log('DONE!');

    }

    // Modo desarrollador
    if (isset($_SESSION["mode"])) {
        // var_error_log($_SESSION["postdata"]);
    }

?>
