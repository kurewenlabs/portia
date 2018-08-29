<?php
    session_start();

    $id = $_GET['identificador'];
    $postula = $_GET['postulacion'];

    require_once 'db.php';
    require_once 'src/dompdf/autoload.inc.php';

    use Dompdf\Dompdf;
    global $conn;
    $sql = "SELECT a.id_post, a.fecha_post, a.estado_post, a.tipo_documento, a.rut, a.nombres, a.apellidoP, a.apellidoM, a.fecha_nacimiento, a.sexo, 
                a.estado_civil, a.nacionalidad, a.telefono, a.telefono_recado, a.email, a.provincia, a.comuna, a.domicilio, 
                a.tpolera, a.tpantalon, a.tpoleron, a.tzapatos, a.renta, a.tlicenciaconducir, a.afp, a.prestadorsalud, 
                a.experiencialaboral, a.referencialaboral, b.nombre, c.cv, c.antecedentes, c.carnet, c.fotografia, d.tipo_estudio, d.titulo, d.estado, 
                d.fecha_titulacion, d.semestres FROM 
            (
                SELECT * 
                FROM tbl_postulante
            ) a
            LEFT JOIN
            (
                SELECT id_post,nombre 
                FROM  tbl_datos_postulacion_abierta
                WHERE nombre = '".$postula."'
            ) b ON a.id_post = b.id_post 
            LEFT OUTER JOIN tbl_documento c ON c.id_post = b.id_post 
            LEFT OUTER JOIN tbl_estudio d ON d.id_post = b.id_post 
            WHERE a.id_post='".$id."' 
            LIMIT 1";
    $result1 = $conn->query($sql);
    $result = $result1->fetch_assoc();

    $sql = "SELECT * FROM tbl_curso WHERE id_post = '" . $id . "'";
    $result1 = $conn->query($sql);
    if ($result1) {
        $i = 0;
        while($fila = $result1->fetch_assoc()) {
           $result["cursos"][$i] = $fila;
           $i++;
        }
    }

    if ($result["experiencialaboral"] == 'Si') {
        $sql = "SELECT * FROM tbl_experiencia_laboral WHERE id_post = '" . $id . "'";
        $result1 = $conn->query($sql);
        if ($result1) {
            $i = 0;
            while($fila = $result1->fetch_assoc()) {
               $result["experiencia"][$i] = $fila;
               $i++;
            }
        }
    }

    if ($result["referencialaboral"] == 'Si') {
        $sql = "SELECT * FROM tbl_referencia_laboral WHERE id_post = '" . $id . "'";
        $result1 = $conn->query($sql);
        if ($result1) {
            $i = 0;
            while($fila = $result1->fetch_assoc()) {
               $result["referencias"][$i] = $fila;
               $i++;
            }
        }
    }

    $sql = "SELECT * FROM tbl_comuna WHERE id_post = '" . $id . "'";
    $result1 = $conn->query($sql);
    if ($result1) {
        $i = 0;
        while($fila = $result1->fetch_assoc()) {
           $result["comunas"][$i] = $fila;
           $i++;
        }
    }
    
    $sql = "SELECT * FROM tbl_horario_trabajo WHERE id_post = '" . $id . "'";
    $result1 = $conn->query($sql);
    if ($result1) {
        $i = 0;
        while($fila = $result1->fetch_assoc()) {
           $result["horarios"][$i] = $fila;
           $i++;
        }
    }

    $files = null;
    $sql = "SELECT id, tipo_archivo, nombre FROM tbl_archivo WHERE id_post = '" . $id . "' AND estado = 1";
    $results = $conn->query($sql);
    if ($results) {
        while($fila = $results->fetch_assoc()) {
            $files[$fila["tipo_archivo"]]["id"] = $fila["id"];
            $files[$fila["tipo_archivo"]]["nombre"] = $fila["nombre"];
        }
    }
    $base_url = substr($_SERVER['HTTP_REFERER'], 0, strrpos($_SERVER['HTTP_REFERER'], "/")+1);

    $content_pdf = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Administracion Sistema de Postulación Portia</title>
    <link rel="stylesheet" href="dist/css/main.min.css">
</head>
<body>
    <div class="container">

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px"> <!--esto es para despues --->
            <p><strong>Fecha de Postulacion : ' . $result['fecha_post'] . '</strong></p>
            <p><strong>Clasificacion : ' . $result['estado_post'] . '</strong></p>
            <p><strong>Observaciones : </strong></p>
        </section>

        <div class="row">
            <div class="col s6 m6 l6">
                <h5>' . $result['nombres'] . '' . $result['apellidoP'] . '</h5><!-- pasar aqui el nombre dle psotulante -->
                <p><strong>Cargo al que postula : ' . $result['nombre'] . '</strong> </p> 
                <p><strong>' . ($result['tipo_documento']=='rut'?'RUT':'Pasaporte') . ' Numero : ' . $result['rut'] . '</strong></p> 
                <p><strong>Fecha de Nacimiento : ' . $result['fecha_nacimiento'] . '</strong> </p> 
                <p><strong>Sexo : ' . $result['sexo'] . '</strong></p>    
            </div>
            <div class="col s6 m6 l6 ">
                <p><strong>Estado Civil : ' . $result['estado_civil'] . ' </p>    
                <p><strong>Nacionalidad : ' . $result['nacionalidad'] . '</strong> </p> 
                <p><strong>Telefonos : ' . $result['telefono'] . ' ' . ($result['telefono_recado'] != ''?'(' . $result['telefono_recado'] . ' solo recados)':'') . '</strong></p>    
                <p><strong>Correo : ' . $result['email'] . '</strong></p>              
                <p><strong>Direccion : ' . $result['domicilio'] . '</strong></p> 
                <p><strong>Region : ' . $result['comuna'] . ' ' . $result['provincia'] . '</strong></p> <!--pasar aqui comuna y region -->     
            </div>
        </div>    

        <div class="divider"></div>

        <div class="row">
            <div class="col s6 m6 l6">
                <h5>Estudios : </h5><p> </p> <!-- passar aqui tipo de estudios -->       
                <p><strong>Titulo de la carrera : ' . $result['titulo'] . '</strong></p> 
                <p><strong>Estado : ' . $result['estado'] . '</strong> </p><!-- pasar año y semestres cursados -->
                <p><strong>Licencia de conducir : ' . $result['tlicenciaconducir'] . '</strong> </p> 
            </div>
            <div class=" col s6 m6 l6">
                <h5>Otros Conocimientos : </h5>
                <p><strong> Curso : ' . (isset($result['cursos']) && count($result['cursos'])>=1?$result['cursos'][0]['curso'] . ', ' . $result['cursos'][0]['fecha']:'') . '</strong></p> <!-- pasar curso y fecha -->
                <p><strong> Curso : ' . (isset($result['cursos']) && count($result['cursos'])>=2?$result['cursos'][1]['curso'] . ', ' . $result['cursos'][1]['fecha']:'') . '</strong></p> <!-- pasar curso y fecha -->
                <p><strong> Curso : ' . (isset($result['cursos']) && count($result['cursos'])>=3?$result['cursos'][2]['curso'] . ', ' . $result['cursos'][2]['fecha']:'') . '</strong></p> <!-- pasar curso y fecha -->
            </div>
        </div> 
            
        <div class="divider"></div>

        <div class="row">
            <h5>Experiencia Laboral: </h5> <p> </p><!-- si o no -->
            <div class="col s7 m7 l7">
                <p><strong>Empresa y cargo : ' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['empresa'] . ', ' . $result['experiencia'][0]['cargo']:'') . '</strong></p> <!-- agregar el cargo tambien -->
                <p><strong>Empresa y cargo : ' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['empresa'] . ', ' . $result['experiencia'][1]['cargo']:'') . '</strong></p>
                <p><strong>Empresa y cargo : ' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['empresa'] . ', ' . $result['experiencia'][2]['cargo']:'') . '</strong></p>   
            </div>
            <div class="col s2 m2 l2">
                <p><strong> Desde : ' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['fecha_desde']:'') . '</strong></p> 
                <p><strong> Desde : ' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['fecha_desde']:'') . '</strong></p>  
                <p><strong> Desde : ' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['fecha_desde']:'') . '</strong></p> 
            </div>
            <div class="col s2 m2 l2">
            
                <p><strong> Hasta : ' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['fecha_hasta']:'') . '</strong></p>
                <p><strong> Hasta : ' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['fecha_hasta']:'') . '</strong></p> 
                <p><strong> Hasta : ' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['fecha_hasta']:'') . '</strong></p>  
            </div>
            
        
        </div>
            
        <div class="divider"></div>

        <h5>Referencias Laborales:</h5> <!-- si o no -->
        <div class="row">
            <div class="col s7 m7 l7">
                <p><strong>Empresa : ' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['empresa']:'') . '</strong> </p>
                <p><strong>Nombre del Contacto : ' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['nombre contacto']:'') . '</strong></p><!--agregar el cargo tambien --> 
            </div>
            <div class="col s5 m5 l5">
                <p><strong>Telefono : ' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['telefono']:'') . '</strong></p>
                <p><strong>Email : ' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['email']:'') . '</strong></p>  
            </div>
            <div class="col s7 m7 l7">
                <p><strong>Empresa : ' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['empresa']:'') . '</strong> </p>
                <p><strong>Nombre del Contacto : ' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['nombre contacto']:'') . '</strong></p><!--agregar el cargo tambien --> 
            </div>
            <div class="col s5 m5 l5">
                <p><strong>Telefono : ' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['telefono']:'') . '</strong></p>
                <p><strong>Email : ' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['email']:'') . '</strong></p>  
            </div>
            <div class="col s7 m7 l7">
                <p><strong>Empresa : ' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['empresa']:'') . '</strong> </p>
                <p><strong>Nombre del Contacto : ' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['nombre contacto']:'') . '</strong></p><!--agregar el cargo tambien --> 
            </div>
            <div class="col s5 m5 l5">
                <p><strong>Telefono : ' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['telefono']:'') . '</strong></p>
                <p><strong>Email : ' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['email']:'') . '</strong></p>  
            </div>
        </div>
        

        <div class="divider"></div>

        <h5>Datos Previsionales</h5>
        <div class="row">
            <div class="col s6 m6 l6">
                <p><strong>Afp : ' . $result['afp'] . '</strong></p> 
            </div>
            <div class="col s6 m6 l6">
                <p><strong>Isapre o Fonasa : ' . $result['prestadorsalud'] . '</strong></p>
            </div>
        </div>
        
        <p><strong>Comunas para Trabajar : ' . $result['comunas'][0]['comuna'] . ', región ' . $result['comunas'][0]['region'] . ' </strong></p>

        <p><strong>Horarios seleccionados : ';
        
        foreach($result['horarios'] as $horario) {
            $content_pdf .= substr($horario['dias'], 0, strlen($horario['dias'])-2) . ' (' . $horario['horarios'] . '), ';
        }
        $content_pdf = substr($content_pdf, 0, strlen($content_pdf)-2);

        $content_pdf .= '</strong></p> <!-- pasa aqui los dias y las horas -->

        <div class="divider"></div>

        <h5>Uniforme</h5>
        <div class="row">
            <div class="col s6 m6 l6 ">
                <p><strong>Talla Polera/camisa : ' . $result['tpolera'] . '</strong></p>        
                <p><strong>Talla Poleron : ' . $result['tpoleron'] . '</strong></p>
                <p><strong>Talla de zapatos : ' . $result['tzapatos'] . '</strong></p>
                <p><strong>Talla de Pantalon : ' . $result['tpantalon'] . '</strong></p>
                <p><strong>Renta :</strong></p>     
            </div>
            <div class="col s6 m6 l6">Adjuntos
                <p><strong>Curriculum : ' . ($files!=null && array_key_exists("cv", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["cv"]["id"] . "&tipo=cv\" target=\"blank\">" . $files["cv"]["nombre"] . "</a>":"No entregado") . '</strong></p><!--solo indicar si o no de lo que adjunto -->
                <p><strong>Certificado de antecedentes : ' . ($files!=null && array_key_exists("cerAntecedentes", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["cerAntecedentes"]["id"] . "&tipo=antecedentes\" target=\"blank\">" . $files["cerAntecedentes"]["nombre"] . "</a>":"No entregado") . '</strong></p><!--solo indicar si o no de lo que adjunto -->
                <p><strong>Fotografía del o la Postulante : ' . ($files!=null && array_key_exists("fotografia", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["fotografia"]["id"] . "&tipo=fotografia\" target=\"blank\">" . $files["fotografia"]["nombre"] . "</a>":"No entregado") . '</strong></p><!--solo indicar si o no de lo que adjunto -->
                <p><strong>Carnet o Pasaporte : ' . ($files!=null && array_key_exists("carnet", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["carnet"]["id"] . "&tipo=carnet\" target=\"blank\">" . $files["carnet"]["nombre"] . "</a>":"No entregado") . '</strong></p><!--solo indicar si o no de lo que adjunto -->  
            </div>
        </div>

        <div class="divider"></div>      
                <p>Llego a través de: <!--INDICAR OPCION ELEGIDA EN GRACIAS.PHP "ESTO ES PARA DESPUES" --></p>
        </div>
    </div>
</body>
</html>';

    $dompdf = new Dompdf();
    $dompdf->loadHtml($content_pdf);
    $dompdf->render(); // Generar el PDF desde contenido HTML
    $pdf = $dompdf->output(); // Obtener el PDF generado
    $dompdf->stream();

?>