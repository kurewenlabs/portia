<?php
$id = $_GET['identificador'];
require_once 'db.php';
require_once 'src/dompdf/autoload.inc.php';
use Dompdf\Dompdf;
global $conn;
$sql = "SELECT * FROM (SELECT * FROM kurewenc_db_portia.tbl_postulante) a
            LEFT JOIN
    (
        SELECT id_post,nombre 
        FROM  tbl_datos_postulacion_abierta
        -- LIMIT 0 , 1s
    ) b ON a.id_post = b.id_post 
    left outer join tbl_documento c ON c.id_post=b.id_post 
    left outer join tbl_estudio d ON d.id_post=b.id_post 
    left outer join tbl_horario_trabajo e ON e.id_post=b.id_post  
    left outer join tbl_curso f ON f.id_post=b.id_post  
    left outer join tbl_experiencia_laboral g ON g.id_post=b.id_post  
    left outer join tbl_referencia_laboral h ON h.id_post=b.id_post  
    where a.id_post='".$id."' 
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
    <link rel="icon" href="src/img/Portia-favicon.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css">
    <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
    <link rel="stylesheet" href="dist/css/main.min.css">
    <!--REQUIRED STYLE SHEETS-->
</head>
<body>
<nav class="teal">
    <h6>Sistema de Postulación Portia</h6>
</nav>
<div class="container">
    <div class="row"><!--titulo-->
        <div class="col s8 m8 l8">
            <h3>Cargos Seleccionados</h3>
        </div>
    </div>
    <div class="row">
        <div class="chip col s4 offset-s1" id="chip">
            ' . $result['nombre'] . '
        </div>
    </div>


    <div class="row">
        <div class="col s8 m8 l8">
            <h4>Datos Personales</h4>
        </div>
    </div>
    <form action="process_editar.php" method="POST">
        <input type="hidden" name="identificador" value="<?= $id ?>" />
        <input type="hidden" name="pagina" value="datos_personales" />
        <div class="row"><!--documentos-->
            <div  id="datosPersonales">
                <div class="tab input-field col s4 m4 l4">Tipo de Documento de identificacion
                    <select class="browser-default" onselect="this.className = \'\'" name="documento">
                        <option>' . $result['documento'] . '</option>
                    </select>
                </div>
                <div class=" input-field col s4 m4 l4 " id="rut_box">
                    <label for="rut">' . $result['documento'] . '</label>
                    <input name="rut" placeholder="Ingrese rut con digito verificador" id="rut" type="text" class="validate" value="' . $result['rut'] . '">
                </div>
            </div>
        </div><!--documentos-->
        <div class="row"><!--datos identificacion-->
            <div class="tab">
                <div class="tab input-field col s4 m4 l4">
                    <label for="first_name">Nombre</label>
                    <input name="primerNombre"  id="first_name" type="text" class="validate" value="' . $result['nombres'] . '">
                </div>
                <div class="tab input-field col s4 m4 l4">
                    <label for="last_name">Apellido Paterno</label>
                    <input name="primerApellido" id="last_name" type="text" class="validate" value="' . $result['apellidop'] . '">
                </div>
                <div class="tab input-field col s4 m4 l4">
                    <label for="last_name_2">Apellido Materno</label>
                    <input name="segundoApellido"  id="last_name_2" type="text" class="validate" value="' . $result['apellidom'] . '">
                </div>
            </div>

        </div><!--datos identificacion-->
        <div class="row">
            <div class="tab">
                <div class="tab input-field col s3 m3 l3">
                    <label for="txtDate">Fecha de Nacimiento</label>
                    <input name="fechaNacimiento" type="text" class="datepicker" id="txtDate" value="' . $result['fecha_nacimiento'] . '">
                </div>
                <div class="tab input-field col s3 m3 l3">
                    <select class="browser-default"  id="sexo" onselect="this.className = \'\'" name="sexo">
                        <option value="">' . $result['sexo'] . '</option>
                    </select>
                </div>
                <div class="tab input-field col s3 m3 l3">
                    <select class="browser-default" id="estado_civil" onselect="this.className = \'\'" name="estado_civil">
                        <option value="">' . $result['estado_civil'] . '</option>
                    </select>
                </div>
                <div class="tab input-field col s3 m3 l3">
                    <label for="nacionalidad">Nacionalidad</label>
                    <input name="nacionalidad" id="nacionalidad" type="text" class="validate" value="' . $result['nacionalidad'] . '">
                </div>
            </div>
        </div><!--datos identificacion-->
        <div class="row">
            <div class="">
                <div class="input-field col s4 m4 l4">
                    <input id="telefono" type="tel" class="validate" placeholder="+56(9)" value="' . $result['telefono'] . '" name="telefono">
                    <label for="telefono">Telefono</label>
                </div>
                <div class="input-field col s4 m4 l4">
                    <input id="telefono2" type="tel" placeholder="*Opcional" class="validate" name="telefonoRecado" value="' . $result['telefono_recado'] . '">
                    <label for="telefono2">Telefono de Recado</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12">
                <input id="email" type="email" class="validate" value="' . $result['email'] . '" name="email">
                <label for="email">Email</label>
            </div>
        </div>
        <div class="row">
            <div class=" input-field col s4 m4 l4">Region
                <select class="browser-default validate" id="provincia" onselect="this.className = \'\'" name="region">
                    <option value="">' . $result['provincia'] . '</option>
                </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->

            </div>

            <div class=" input-field col s4 m4 l4">Comuna
                <select class="browser-default validate" id="provincia" onselect="this.className = \'\'" name="comuna">
                    <option value="">' . $result['comuna'] . '</option>
                </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
            </div>
        </div>
        <div class="row">
            <div class="input-field col s12 m12 l12">
                <input id="direccion" type="text" class="validate" value="' . $result['direccion'] . '" name="domicilio">
                <label for="direccion">Direccion</label>
            </div>
        </div>
    </form>
    <div class="divider"></div>

    <!-- --------------------------- ESTUDIOS ------------------------------ -->

    <div class="row">
        <div class="col s8 m8 l8">
            <h4>Estudios</h4>
        </div>
    </div>
    <div class="row"><!--documentos-->
        <div class="tab" id="estudios">
            <div class="tab input-field col s4 m4 l4">
                <select class="browser-default" onselect="this.className = \'\'" name="estudio">
                    <option value="">Tipo de Estudios</option>
                    <option value="Secundario">Secundario</option>
                    <option value="Técnico Superior">Técnico Superior</option>
                    <option value="Universitario">Universitario</option>
                    <option value="Posgrado">Posgrado</option>
                    <option value="Master">Master</option>
                    <option value="Doctorado">Doctorado</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="tab input-field col s8 m8 l8">
                <label for="carrera">Titulo de la Carrera</label>
                <input  id="carrera" type="text" class="validate">
            </div>
        </div>
    </div><!--documentos-->
    <div class="row"><!--datos identificacion-->
        <div class="tab">
            <div class="tab input-field col s4 m4 l4">
                <select  onselect="this.className = \'\'" name="estado_estudio" class="browser-default">
                    <option value="">Estado</option>
                    <option value="En Curso">En Curso</option>
                    <option value="Graduado">Graduado</option>
                    <option value="Abandonado">Abandonado</option>
                </select>
            </div>
            <div class=" input-field col s2 m2 l2">
                <div id="box_estudio" class="box_estudio">
                    <label for="txtDate2ftitulacion">Año de Titulación</label>
                    <input type="text" class="date" id="txtDate2ftitulacion" placeholder="Ingrese año">
                </div>

            </div>
            <div class=" input-field col s2 m2 l2">
                <div id="box_estudio" class="box_estudio">
                    <label for="txtDate2ftitulacion">Semestres cursados</label>
                    <input type="text" class="date" id="txtDate2ftitulacion" placeholder="">
                </div>

            </div>

            <div class="tab input-field col s4 m4 l4">
                <select onselect="this.className = \'\'" name="licencia" class="browser-default">
                    <option value="">Licencia de Conducir</option>
                    <option value="Clase A1">Clase A1</option>
                    <option value="Clase A2">Clase A2</option>
                    <option value="Clase A3">Clase A3</option>
                    <option value="Clase A4">Clase A4</option>
                    <option value="Clase A5">Clase A5</option>
                    <option value="Clase B">Clase B</option>
                    <option value="Clase C">Clase C</option>
                    <option value="Clase D">Clase D</option>
                    <option value="Clase E">Clase E</option>
                    <option value="Clase F">Clase F</option>
                </select>
            </div>
        </div>
    </div><!--datos identificacion-->


    <div class="row">
        <h4>Otros Conocimientos </h4>
        <div class="col s12 m12 l12 box">
            <p id="cursoData"></p>
        </div>
    </div>
    <div class="divider"></div>
    <!-- ----------------------------------------------- EXPERIENCIA LABORAL --------------------------------- -->
    <div class="row">
        <div class="col s8 m8 l8">
            <h4>Expriencia Laboral</h4>
        </div>
    </div>
    <div class="row">
        <div class="tab input-field col s4 m4 l4" id="experienciaLaboral">¿Posee experiencia laboral?
            <select class="browser-default" onselect="this.className = \'\'" name="experiencia">
                <option value=""></option>
                <option value="Si">Si</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>

    <div class="row">
        <h6> Experiencia laboral</h6>
        <div class="col s12 m12 l12 box">
            <p id="experienciaData"></p>
        </div>
    </div>
    <div class="divider"></div>
    <!-- _____________________________________________________REFERENCIA LABORAL_______________________________________ -->
    <div class="row">
        <div class="col s8 m8 l8">
            <h4>Referencias Laborales</h4>
        </div>
    </div>
    <div class="row">
        <div class="tab input-field col s5 m5 l5" id="referenciasLaborales">
            <select class="browser-default" onselect="this.className = \'\'" name="referencia">
                <option value="">¿Cuenta con referencias laborales?</option>
                <option value="Si">Si</option>
                <option value="No">No</option>
            </select>
        </div>
    </div>

    <div class="row">
        <h6>Referencias Laborales</h6>
        <div class="col s12 m12 l12 box">
            <p id="referenciaData"></p>
        </div>
    </div>
    <div class="row"></div>
    <div class="divider"></div>
    <!-- _____________________________________________________DATOS PREVISIONALES_______________________________________ -->

    <div class="row">
        <div class="col s8 m8 l8">
            <h4>Otros Datos</h4>
        </div>
    </div>

    <div class="row">
        <div class="tab input-field col s6 m6 l6" id="datosPrevision">
            <select class="browser-default" onselect="this.className = \'\'" name="afp">
                <option value="">AFP</option>
                <option value="AFP Capital">AFP Capital</option>
                <option value="AFP Cuprum">AFP Cuprum</option>
                <option value="AFP Habitat">AFP Habitat</option>
                <option value="AFP Modelo">AFP Modelo</option>
                <option value="AFP Planvital">AFP Planvital</option>
                <option value="AFP Provida">AFP Provida</option>
            </select>
        </div>
        <div class="tab input-field col s6 m6 l6">
            <select class="browser-default" onselect="this.className = \'\'" name="isapre">
                <option value="">Isapre o Fonasa</option>
                <option value="Fonasa">Fonasa</option>
                <option value="Consalud">Consalud</option>
                <option value="Colmena">Colmena</option>
                <option value="Cruz Blanca">Cruz Blanca</option>
                <option value="Chuquicamata">Chuquicamata</option>
                <option value="Banmédica">Banmédica</option>
                <option value="Cruz del Norte">Cruz del Norte</option>
                <option value="Nueva Masvida">Nueva Masvida</option>
                <option value="Fundación">Fundación</option>
                <option value="Fusat">Fusat</option>
                <option value="Río Blanco">Río Blanco</option>
                <option value="San Lorenzo">San Lorenzo</option>
                <option value="Vida Tres">Vida Tres</option>
            </select>
        </div>
    </div>
    <div class="row">
        <h4>Disponibilidad Horaria</h4>
        <div class="divider"></div>
    </div>
    <div id="containerInputHoras">
        <div id="inputDiaHora">
            <div class="row">
                <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                    <select class="js-example-basic-multiple" id="dias" multiple="multiple" style="width:60%">
                        <option value="Todos">Todos</option>
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miercoles">Miercoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                        <option value="Sabado">Sabado</option>
                        <option value="Domingo">Domingo</option>

                    </select>
                </div>
                <div class=" input-field col s2 m2 l2">Horario Desde
                    <select class="js-example-basic-multiple" id="id_label_multiple"  style="width:60%">
                        <option value="">Obligatorio</option>

                        <option value="1:00">1:00</option>
                        <option value="2:00">2:00</option>
                        <option value="3:00">3:00</option>
                        <option value="4:00">4:00</option>
                        <option value="5:00">5:00</option>
                        <option value="6:00">6:00</option>
                        <option value="7:00">7:00</option>
                        <option value="8:00">8:00</option>
                        <option value="9:00">9:00</option>
                        <option value="10:00">10:00</option>
                        <option value="11:00">11:00</option>
                        <option value="12:00">12:00</option>
                    </select>
                </div>
                <div class=" input-field col s2 m2 l2">Hasta
                    <select class="js-example-basic-multiple" id="id_label_multiple1"  style="width:60%">
                        <option value="">Obligatorio</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                        <option value="18:00">18:00</option>
                        <option value="19:00">19:00</option>
                        <option value="20:00">20:00</option>
                        <option value="21:00">21:00</option>
                        <option value="22:00">22:00</option>
                        <option value="23:00">23:00</option>
                        <option value="24:00">24:00</option>
                    </select>
                </div>

                <div class="row">
                    <div class=" input-field col s4 m4 l4">Region
                        <select class="browser-default validate" id="provincia" onselect="this.className = \'\'" name="region">
                        </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->

                    </div>
                    <div class=" input-field col s4 m4 l4">Provincia
                        <select class="browser-default validate" id="provincia" onselect="this.className = \'\'" name="provincia">
                        </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="row">
        <h6 style="color:#838383">Horarios Agregados</h6>
        <div class="col s12 m12 l12 box">

        </div>
    </div>
    <div class="row"></div>
    <div class="divider"></div>
    <!-- _____________________________________________________DATOS UNIFORME_______________________________________ -->

    <div class="row">
        <div class="col s8 m8 l8">
            <h4>Datos Uniforme</h4>
        </div>
    </div>

    <div class="row">
        <div class="tab" id="uniforme">
            <div class="tab input-field col s4 m4 l4">
                <select class="browser-default" onselect="this.className=\'\'" name="uniforme">
                    <option value="">Talla Polera/camisa</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>
            <div class="tab input-field col s4 m4 l4">
                <select class="browser-default" onselect="this.className=\'\'" name="uniforme2">
                    <option value="">Talla Poleron</option>
                    <option value="XS">XS</option>
                    <option value="S">S</option>
                    <option value="M">M</option>
                    <option value="L">L</option>
                    <option value="XL">XL</option>
                    <option value="XXL">XXL</option>
                </select>
            </div>
            <div class="tab input-field col s4 m4 l4">
                <label for="tallaZapato">Talla de zapatos</label>
                <input  id="tallaZapato" type="text" class="validate">
            </div>
            <div class="row">
                <div class="tab input-field col s8 m8 l8">
                    <label for="tallaPantalon">Talla de Pantalon (ingrese detalles si necesita)</label>
                    <input  id="tallaPantalon" type="text" class="validate">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h4>Pretensiones de Renta</h4>
        <div class="row">
            <div class="tab">
                <div class="tab input-field col s4 m4 l4">
                    <select class="browser-default" onselect="this.className=\'\'" name="renta">
                        <option value="">Seleccione Rango</option>
                        <option value="275.000 - 350.000">275.000 - 350.000</option>
                        <option value="350.000 - 400.000">350.000 - 400.000</option>
                        <option value="400.000 - 450.000">400.000 - 450.000</option>
                        <option value="450.000 - 500.000">450.000 - 500.000</option>
                        <option value="500.000 - 550.000">500.000 - 550.000</option>
                        <option value="550.000 - 600.000">550.000 - 600.000</option>
                        <option value="600.000 - 800.000">600.000 - 800.000</option>
                        <option value="800.000 - 1.000.000">800.000 - 1.000.000</option>
                        <option value="Más de 1.000.000">Más de 1.000.000</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <h4>Adjuntos (Opcional)</h4>

        <div class="row">

            <div class="row">
                <div class="col s6 m6 l6">
                    <label>Curriculum</label>
                    <div class="file-field input-field">
                        <input type="file" id="cv" name="curriculum">
                    </div>
                </div>
                <div class="col s6 m6 l6">
                    <label>Certificado de antecedentes</label>
                    <div class="file-field input-field">
                        <input type="file" id="cerAntecedentes" name="antecedentes">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col s6 m6 l6">
                    <label>Carnet o Pasaporte</label>
                    <div class="file-field input-field">
                        <input type="file" id="docIdentidad" name="docIdentidad">
                    </div>
                </div>
                <div class="col s6 m6 l6">
                    <label>Fotografía del o la Postulante</label>
                    <div class="file-field input-field">
                        <input type="file" id="fotografia" name="fotografia">
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</body>
</html>';

echo $content_pdf;
die;

$dompdf = new Dompdf();
$dompdf->loadHtml($content_pdf);
$dompdf->render(); // Generar el PDF desde contenido HTML
$pdf = $dompdf->output(); // Obtener el PDF generado
$dompdf->stream();

?>