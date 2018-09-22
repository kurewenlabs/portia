<?php
    session_start();

    if (!isset($_SESSION["active_user"])) {
        header("Location: adminportia.php?status=-1", true, 301);
        exit();
    }

    $id = $_GET['identificador'];
    $postula = $_GET['postulacion'];

    require_once 'db.php';
    require_once 'src/dompdf/autoload.inc.php';

    use Dompdf\Dompdf;
    global $conn;
    $sql = "SELECT a.id_post, a.fecha_post, a.estado_post, a.tipo_documento, a.rut, a.nombres, a.apellidoP, a.apellidoM, a.fecha_nacimiento, a.sexo, 
                a.estado_civil, a.nacionalidad, a.telefono, a.telefono_recado, a.email, a.provincia, a.comuna, a.domicilio, 
                a.tpolera, a.tpantalon, a.tpoleron, a.tzapatos, a.renta, a.tlicenciaconducir, a.afp, a.prestadorsalud, 
                a.experiencialaboral, a.referencialaboral, a.medio, b.nombre, b.estado, b.observacion, c.cv, c.antecedentes, c.carnet, 
                c.fotografia, d.tipo_estudio, d.titulo, d.estado as estado_estudio, d.fecha_titulacion, d.semestres FROM 
            (
                SELECT * 
                FROM tbl_postulante
            ) a
            LEFT JOIN
            (
                SELECT id_post, nombre, estado, observacion 
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
    <style type="text/css">
        body {
            font-family: Helvetica;
        }
    </style>
</head>
<body>
    <div class="container">

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <br />
            <table>
                <tr><td>Fecha de Postulacion</td><td>:</td><td>' . $result['fecha_post'] . '</td></tr>
                <tr><td>Clasificacion</td><td>:</td><td>' . $result['estado_post'] . '</td></tr>
                <tr><td>Observaciones</td><td>:</td><td>' . $result['observacion'] . '</td></tr>
            </table>
            <br />
        </section>

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="3"><h3>' . $result['nombres'] . ' ' . $result['apellidop'] . ' ' . $result['apellidom'] .'</h3></td></tr>
                <tr><td>Cargo al que postula</td><td>:</td><td>' . $result['nombre'] . '</td></tr> 
                <tr><td>' . ($result['tipo_documento']=='rut'?'RUT':'Pasaporte') . ' Numero</td><td>:</td><td>' . $result['rut'] . '</td></tr> 
                <tr><td>Fecha de Nacimiento</td><td>:</td><td>' . $result['fecha_nacimiento'] . '</td></tr> 
                <tr><td>Sexo</td><td>:</td><td>' . $result['sexo'] . '</td></tr>    
                <tr><td>Estado Civil</td><td>:</td><td>' . $result['estado_civil'] . '</td></tr>    
                <tr><td>Nacionalidad</td><td>:</td><td>' . $result['nacionalidad'] . '</td></tr> 
                <tr><td>Telefonos</td><td>:</td><td>' . $result['telefono'] . ' ' . ($result['telefono_recado'] != ''?'(' . $result['telefono_recado'] . ' solo recados)':'') . '</td></tr>    
                <tr><td>Correo</td><td>:</td><td>' . $result['email'] . '</td></tr>              
                <tr><td>Direccion</td><td>:</td><td>' . $result['domicilio'] . '</td></tr> 
                <tr><td>Region</td><td>:</td><td>' . $result['comuna'] . ' ' . $result['provincia'] . '</td></tr>     
            </table>    
            <br />
        </section>

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="3"><h3>Estudios</h3></td></tr>       
                <tr><td>Nivel</td><td>:</td><td>' . $result['tipo_estudio'] . '</td></tr> 
                <tr><td>Título (si aplica)</td><td>:</td><td>' . $result['titulo'] . '</td></tr> 
                <tr><td>Año de Egreso</td><td>:</td><td>' . $result['fecha_titulacion'] . '</td></tr>
                <tr><td>Estado</td><td>:</td><td>' . $result['estado_estudio'] . '</td></tr>
                <tr><td>Semestres Cursados</td><td>:</td><td>' . $result['semestres'] . '</td></tr>
                <tr><td>Licencia de Conducir</td><td>:</td><td>' . $result['tlicenciaconducir'] . '</td></tr>
                <tr><td>Curso</td><td>:</td><td>' . (isset($result['cursos']) && count($result['cursos'])>=1?$result['cursos'][0]['curso'] . ', ' . $result['cursos'][0]['fecha']:'') . '</td></tr>
                <tr><td>Curso</td><td>:</td><td>' . (isset($result['cursos']) && count($result['cursos'])>=2?$result['cursos'][1]['curso'] . ', ' . $result['cursos'][1]['fecha']:'') . '</td></tr>
                <tr><td>Curso</td><td>:</td><td>' . (isset($result['cursos']) && count($result['cursos'])>=3?$result['cursos'][2]['curso'] . ', ' . $result['cursos'][2]['fecha']:'') . '</td></tr>
            </table>
            <br />
        </section> 
            
        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="12"><h3>Experiencia Laboral</h3></td></tr>';
                if (isset($result['experiencia'])) {
                    for($i=0; $i<count($result['experiencia']); $i++) {
                        $content_pdf .= '                <tr>
                    <td>Empresa</td><td>:</td><td>' . $result['experiencia'][$i]['empresa'] . '</td>
                    <td>Cargo</td><td>:</td><td>' . $result['experiencia'][$i]['cargo'] . '</td>
                    <td>Desde</td><td>:</td><td>' . $result['experiencia'][$i]['fecha_desde'] . '</td> 
                    <td>Hasta</td><td>:</td><td>' . ($result['experiencia'][$i]['fecha_hasta']!=''?$result['experiencia'][$i]['fecha_hasta']:'Actualidad') . '</td>
                </tr>';
                    }
                }
                else {
                    $content_pdf .= '                <tr><td colspan="12">No tiene</td></tr>';
                }
                $content_pdf .= '            </table>
            <br />
        </section>
            
        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td><h3>Referencias Laborales</h3></td></tr>';
                if (isset($result['referencias'])) {
                    for($i=0; $i<count($result['referencias']); $i++) {
                        $content_pdf .= '                <tr><td><table>
                    <tr><td>Empresa</td><td>:</td><td>' . $result['referencias'][$i]['empresa'] . '</td></tr>
                    <tr><td>Nombre</td><td>:</td><td>' . $result['referencias'][$i]['nombre_contacto'] . '</td></tr>
                    <tr><td>Cargo</td><td>:</td><td>' . $result['referencias'][$i]['cargo'] . '</td></tr>
                    <tr><td>Telefono</td><td>:</td><td>' . $result['referencias'][$i]['telefono'] . '</td></tr>
                    <tr><td>Email</td><td>:</td><td>' . $result['referencias'][$i]['email'] . '</td></tr>  
                </table></td></tr>';
                    }
                }
                else {
                    $content_pdf .= '                <tr><td>No tiene</td></tr>';
                }
                $content_pdf .= '            </table>
            <br /> 
        </section>

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="3"><h3>Otros Datos</h3></td></tr>       
                <tr><td>AFP</td><td>:</td><td>' . $result['afp'] . '</td></tr> 
                <tr><td>Isapre o Fonasa</td><td>:</td><td>' . $result['prestadorsalud'] . '</td></tr>
                <tr><td>Comunas para Trabajar</td><td>:</td><td>' . $result['comunas'][0]['comuna'] . ', región ' . $result['comunas'][0]['region'] . ' </td></tr>
                <tr><td>Horarios seleccionados</td><td>:</td><td>';
                foreach($result['horarios'] as $horario) {
                    $content_pdf .= substr($horario['dias'], 0, strlen($horario['dias'])-2) . ' (' . $horario['horarios'] . '), ';
                }
                $content_pdf = substr($content_pdf, 0, strlen($content_pdf)-2);
                $content_pdf .= '</td></tr>
                <tr><td>Talla Polera/camisa</td><td>:</td><td>' . $result['tpolera'] . '</td></tr>        
                <tr><td>Talla Poleron</td><td>:</td><td>' . $result['tpoleron'] . '</td></tr>
                <tr><td>Talla de zapatos</td><td>:</td><td>' . $result['tzapatos'] . '</td></tr>
                <tr><td>Talla de Pantalon</td><td>:</td><td>' . $result['tpantalon'] . '</td></tr>
                <tr><td>Renta</td><td>:</td><td>' . $result['renta'] . '</td></tr>  
            </table>
            <br /> 
        </section>

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="3"><h3>Adjuntos</h3></td></tr>       
                <tr><td>Curriculum</td><td>:</td><td>' . ($files!=null && array_key_exists("cv", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["cv"]["id"] . "&tipo=cv\" target=\"blank\">" . $files["cv"]["nombre"] . "</a>":"No entregado") . '</td></tr>
                <tr><td>Certificado de antecedentes</td><td>:</td><td>' . ($files!=null && array_key_exists("cerAntecedentes", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["cerAntecedentes"]["id"] . "&tipo=antecedentes\" target=\"blank\">" . $files["cerAntecedentes"]["nombre"] . "</a>":"No entregado") . '</td></tr>
                <tr><td>Fotografía del o la Postulante</td><td>:</td><td>' . ($files!=null && array_key_exists("fotografia", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["fotografia"]["id"] . "&tipo=fotografia\" target=\"blank\">" . $files["fotografia"]["nombre"] . "</a>":"No entregado") . '</td></tr>
                <tr><td>Carnet o Pasaporte</td><td>:</td><td>' . ($files!=null && array_key_exists("carnet", $files)?"<a href=\"" . $base_url . "download.php?identificador=" . $files["carnet"]["id"] . "&tipo=carnet\" target=\"blank\">" . $files["carnet"]["nombre"] . "</a>":"No entregado") . '</td></tr>
            </table>
            <br /> 
        </section>

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr>
                    <td>Llegó a través de ' . (isset($result['medio'])?$result['medio']:'no especificado') . '</td>
                </tr>
            </table>
        </section>
    </div>
</body>
</html>';

    /* echo $content_pdf;
    die(); */

    $dompdf = new Dompdf();
    $dompdf->loadHtml($content_pdf);
    $dompdf->render(); // Generar el PDF desde contenido HTML
    $pdf = $dompdf->output(); // Obtener el PDF generado
    $dompdf->stream();

?>