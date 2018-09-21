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
                <tr><td colspan=3"><h3>' . $result['nombres'] . ' ' . $result['apellidop'] . ' ' . $result['apellidom'] .'</td></tr>
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
                <tr><td colspan=3"><h3>Estudios</td></tr>       
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
                <tr><td colspan="4"><h3>Experiencia Laboral</td></tr>       
                <tr>
                    <td>Empresa</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['empresa']:'') . '</td>
                    <td>Cargo</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['cargo']:'') . '</td>
                    <td>Desde</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['fecha_desde']:'') . '</td> 
                    <td>Hasta</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=1?$result['experiencia'][0]['fecha_hasta']:'') . '</td>
                </tr>
                <tr>
                    <td>Empresa</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['empresa']:'') . '</td>
                    <td>Cargo</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['cargo']:'') . '</td>
                    <td>FecDesdehas</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['fecha_desde']:'') . '</td> 
                    <td>Hasta</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=2?$result['experiencia'][1]['fecha_hasta']:'') . '</td>
                </tr>
                <tr>
                    <td>Empresa</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['empresa']:'') . '</td>
                    <td>Desde</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['cargo']:'') . '</td>
                    <td>Fechas</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['fecha_desde']:'') . '</td> 
                    <td>Hasta</td><td>:</td><td>' . (isset($result['experiencia']) && count($result['experiencia'])>=3?$result['experiencia'][2]['fecha_hasta']:'') . '</td>
                </tr>
            </table>
            <br />
        </section>
            
        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="4"><h3>Referencias Laborales</td></tr>       
                <tr>
                    <td>Empresa</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['empresa']:'') . '</td>
                    <td>Nombre</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['nombre contacto']:'') . '</td> 
                    <td>Telefono</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['telefono']:'') . '</td>
                    <td>Email</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][0]['email']:'') . '</td>  
                </tr>
                <tr>
                    <td>Empresa</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=1?$result['referencias'][1]['empresa']:'') . '</td>
                    <td>Nombre</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['nombre contacto']:'') . '</td> 
                    <td>Telefono</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['telefono']:'') . '</td>
                    <td>Email</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=2?$result['referencias'][1]['email']:'') . '</td>  
                </tr>
                <tr>
                    <td>Empresa</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['empresa']:'') . '</td>
                    <td>Nombre</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['nombre contacto']:'') . '</td> 
                    <td>Telefono</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['telefono']:'') . '</td>
                    <td>Email</td><td>:</td><td>' . (isset($result['referencias']) && count($result['referencias'])>=3?$result['referencias'][2]['email']:'') . '</td>  
                </tr>
            </table>
            <br /> 
        </section>

        <section style="border:1px solid #eee; margin-top: 30px; padding-left: 10px">
            <table>
                <tr><td colspan="3"><h3>Otros Datos</td></tr>       
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
                <tr><td colspan="3"><h3>Adjuntos</td></tr>       
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