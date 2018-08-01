<?php
$id = $_GET['identificador'];
require_once 'db.php';
require_once 'src/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
global $conn;
$sql = "SELECT a.id_post, a.fecha_post, a.estado_post, a.rut, a.nombres, a.apellidoP, a.apellidoM, a.fecha_nacimiento, a.sexo, 
        a.estado_civil, a.nacionalidad, a.telefono, a.telefono_recado, a.email, a.provincia, a.comuna, a.domicilio, 
        a.tpolera, a.tpantalon, a.tpoleron, a.tzapatos, a.renta, a.tlicenciaconducir, a.afp, a.prestadorsalud, 
        a.experiencialaboral, a.referencialaboral, b.nombre, c.antecedentes, d.tipo_estudio, d.titulo, d.estado, 
        d.fecha_titulacion, e.dias, e.horarios, e.comunas, f.curso, f.fecha, g.empresa as exp_empresa, g.cargo as exp_cargo, 
        g.fecha_desde as exp_fecha_desde, g.fecha_hasta as exp_fecha_hasta, h.empresa as ref_empresa, h.nombre_contacto
        as ref_nombre_contacto, h.cargo as ref_cargo, h.telefono as ref_telefono, h.email as ref_email FROM 
        (
        SELECT * 
        FROM tbl_postulante
        ) a
        LEFT JOIN
        (
        SELECT id_post,nombre 
        FROM  tbl_datos_postulacion_abierta
        ) b ON a.id_post = b.id_post 
        LEFT OUTER JOIN tbl_documento c ON c.id_post = b.id_post 
        LEFT OUTER JOIN tbl_estudio d ON d.id_post = b.id_post 
        LEFT OUTER JOIN tbl_horario_trabajo e ON e.id_post = b.id_post  
        LEFT OUTER JOIN tbl_curso f ON f.id_post = b.id_post  
        LEFT OUTER JOIN tbl_experiencia_laboral g ON g.id_post = b.id_post  
        LEFT OUTER JOIN tbl_referencia_laboral h ON h.id_post = b.id_post  
        WHERE a.id_post='".$id."' 
        LIMIT 2";
$result1 = $conn->query($sql);
$result = $result1->fetch_assoc();

$content_pdf = '
<!DOCTYPE html>
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
    <h5>Nombre y apellidos  del postulante</h5><!-- pasar aqui el nombre dle psotulante -->
    <div class="row">
        <div class="col s6 m6 l6">
            <p><strong>Cargo al que postula : ' . $result['nombre'] . '</strong> </p> 
            <p><strong>' . (isset($result['rut'])?'RUT':'Pasaporte') . ' Numero : ' . (isset($result['rut'])?$result['rut']:$result['pasaporte']) . '</strong></p> 
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
                 <p><strong> Curso : </strong></p> <!-- pasar curso y fecha -->
                 <p><strong> Curso : </strong></p> <!-- pasar curso y fecha -->
                 <p><strong> Curso : </strong></p> <!-- pasar curso y fecha -->
            </div>
        </div> 
         
         

    <div class="divider"></div>
    <div class="row">
        <h5>Experiencia Laboral: </h5> <p> </p><!-- si o no -->
        <div class="col s7 m7 l7">
          
            <p><strong>Empresa y cargo : </strong></p> <!-- agregar el cargo tambien -->
            <p><strong>Empresa y cargo : </strong></p>
            <p><strong>Empresa y cargo : </strong></p>   
        </div>
        <div class="col s2 m2 l2">
            <p><strong> Desde : </strong></p> 
            <p><strong> Desde :</strong></p>  
            <p><strong> Desde :</strong></p> 
        </div>
        <div class="col s2 m2 l2">
        
             <p><strong> Hasta :</strong></p>
             <p><strong> Hasta :</strong></p> 
             <p><strong> Hasta :</strong></p>  
        </div>
        
       
    </div>
        
        
     <div class="divider"></div>
        <h5>Referencias Laborales:</h5> <!-- si o no -->
        <div class="row">
            <div class="col s7 m7 l7">
                <p><strong>Empresa :</strong> </p>
                <p><strong>Nombre del Contacto :</strong></p><!--agregar el cargo tambien --> 
            </div>
            <div class="col s5 m5 l5">
                 <p><strong>Telefono :</strong></p>
                 <p><strong>Email :</strong></p>  
            </div>
            <div class="col s7 m7 l7">
                <p><strong>Empresa : </strong></p>
                <p><strong>Nombre del Contacto :</strong></p><!--agregar el cargo tambien --> 
            </div>
            <div class="col s5 m5 l5">
                 <p><strong>Telefono :</strong></p>
                 <p><strong>Email :</strong></p>  
            </div>
            <div class="col s7 m7 l7">
                <p><strong>Empresa : </strong></p>
                <p><strong>Nombre del Contacto :</strong></p><!--agregar el cargo tambien --> 
            </div>
            <div class="col s5 m5 l5">
                 <p><strong>Telefono :</strong></p>
                 <p><strong>Email :</strong></p>  
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
       
        
        <p><strong>Comunas para Trabajar : </strong></p><!-- pasa aqui region y comunas -->
        <p><strong>Horarios seleccionados : </strong></p> <!-- pasa aqui los dias y las horas -->

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
            <p><strong>Curriculum : </strong></p><!--solo indicar si o no de lo que adjunto -->
            <p><strong>Certificado de antecedentes : </strong></p><!--solo indicar si o no de lo que adjunto -->
            <p><strong>Fotografía del o la Postulante : </strong></p><!--solo indicar si o no de lo que adjunto -->
            <p><strong>Carnet o Pasaporte : </strong></p><!--solo indicar si o no de lo que adjunto -->  
        </div>
    </div>
    <div class="divider"></div>      
            <p>Llego a través de: <!--INDICAR OPCION ELEGIDA EN GRACIAS.PHP "ESTO ES PARA DESPUES" --></p>
    </div>
</body>
</html>';

$dompdf = new Dompdf();
$dompdf->loadHtml($content_pdf);
$dompdf->render(); // Generar el PDF desde contenido HTML
$pdf = $dompdf->output(); // Obtener el PDF generado
$dompdf->stream();

?>