<?php
    session_start();
    $data = $_SESSION["postdata"];
    $dataPostulacion = $_SESSION["postdata"]["pos"]["pa"];

    if (isset($_SESSION["mode"])) {
        echo "<!--";
        print_r($_SESSION);
        echo "-->";
    } 
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sistema de Postulación Portia</title>
    <link rel="icon" href="src/img/Portia-favicon.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css">
    <link rel="stylesheet" href="dist/css/main.min.css">
    <!--REQUIRED STYLE SHEETS-->
  </head>
  <body>
    <nav class="teal">
      <h6>Sistema de Postulación Portia</h6>
    </nav>

    <div class="row"><!--titulo-->
      <div class="col s6 col m6 col l6">
        <h3>Tus Cargos Seleccionados</h3>
      </div>
        <div class="col s2 col m2 col l2 return">
          <a href="index.php" class="">Volver a cargos</a>
        </div>
    </div>

    <!-- --------------------------- CARGOS ------------------------------ -->

    <div class="row">
      <div class="col s1"></div>
        <?php foreach($dataPostulacion as $cargo) {
          echo "<div class='chip col'>" . $cargo['nom'] .  "<i class=\"close material-icons\">close</i></div>";
        } ?>
      </div>
      <div class="container"> 
        <div class="row">
        <div class="col s12 m12 l12">
          <h5 class="center">Revise su postulación completa antes de enviar a Portia. Usted podrá editar o corregir cualquier dato de su postulación en esta pantalla.</h5>
          <p class="center">Consejo: Asegúrese que todos sus datos personales y contacto estén bien escritos antes de postular.</p>
        </div>
      </div>

      <!-- --------------------------- DATOS PERSONALES ------------------------------ -->

      <div class="row">
        <div class="col s8 m8 l8">
          <h4>Datos Personales</h4>
        </div>
      </div>
      <div class="row">
        <form id="postularform" onsubmit="return false;">         
        <?php
          $datos = $data["pos"]["datos"];
          $i = 0;
        ?>

      <!--documentos-->
      <div class="row">
        <div class=" input-field col s4 m4 l4">Documento de Identificacion
          <select class="browser-default" onselect="this.className = ''" name="documento" id="tipo_doc">
            <option value="rut" <?php if (array_key_exists('rut', $datos[0])) echo "selected" ?>>RUT</option>
            <option value="pasaporte" <?php if (array_key_exists('pasaporte', $datos[0])) echo "selected" ?>>Pasaporte</option>
          </select>
        </div>
        <div class=" input-field col s4 m4 l4 " id="rut_box">
          <label for="rut">RUT</label>
          <input placeholder="ej. 11111111-1" id="rut" type="tel" class="validate rut_box" value="<?php if (array_key_exists('rut', $datos[$i])) { echo $datos[$i]['rut']; $i++; } ?>">
        </div>
        <div class=" input-field col s4 m4 l4 " id="pasaporte_box">
          <label for="pasaporte">Pasaporte</label>
          <input  id="pasaporte" type="tel" class="validate rut_box" value="<?php if (array_key_exists('pasaporte', $datos[$i])) { echo $datos[$i]['pasaporte']; $i++; } ?>">
        </div>
      </div>
    <!--documentos-->

    <!--datos identificacion-->
    <div class="row">
      <div class="tab">
        <div class="tab input-field col s4 m4 l4">
          <label for="first_name">Nombres</label>
          <input  id="first_name" type="text" class="validate" value="<?php if (array_key_exists('noms', $datos[$i])) { echo $datos[$i]['noms']; $i++; }  ?>">
        </div>
        <div class="tab input-field col s4 m4 l4">
          <label for="last_name">Apellido Paterno</label>
          <input  id="last_name" type="text" class="validate" value="<?php if (array_key_exists('apeP', $datos[$i])) { echo $datos[$i]['apeP']; $i++; }  ?>">
        </div>
        <div class="tab input-field col s4 m4 l4">
          <label for="last_name_2">Apellido Materno</label>
          <input  id="last_name_2" type="text" class="validate" value="<?php if (array_key_exists('apeM', $datos[$i])) { echo $datos[$i]['apeM']; $i++; }  ?>">
        </div>
      </div>
    </div>
    <!--datos identificacion-->

    <div class="row">
      <div class="tab">
        <div class="tab input-field col s3 m3 l3">
          <label for="txtDate">Fecha de Nacimiento</label>
          <input type="text" class="datepicker" id="txtDate" value="<?php if (array_key_exists('fNaci', $datos[$i])) { echo $datos[$i]['fNaci']; $i++; }  ?>"></div>
        </div>
        <div class="tab input-field col s3 m3 l3">
          <select class="browser-default" id="sexo" onselect="this.className = ''" name="sexo">
            <option value="">Sexo</option>
            <option value="femenino" <?php if (array_key_exists('sexo', $datos[$i]) && $datos[$i]['sexo'] == 'femenino') { echo "selected"; $i++; }  ?>>Femenino</option>
            <option value="masculino" <?php if (array_key_exists('sexo', $datos[$i]) && $datos[$i]['sexo'] == 'masculino') { echo "selected"; $i++; }  ?>>Masculino</option>
          </select>
        </div>
        <div class="tab input-field col s3 m3 l3">
          <select class="browser-default" id="estado_civil" onselect="this.className = ''" name="estado_civil">
            <option value="">Estado Civil</option>
            <option value="soltero" <?php if (array_key_exists('eCivil', $datos[$i]) && $datos[$i]['eCivil'] == 'soltero') { echo "selected"; $i++; }  ?>>Soltero(a)</option>
            <option value="casado" <?php if (array_key_exists('eCivil', $datos[$i]) && $datos[$i]['eCivil'] == 'casado') { echo "selected"; $i++; }  ?>>Casado(a)</option>
            <option value="divorciado" <?php if (array_key_exists('eCivil', $datos[$i]) && $datos[$i]['eCivil'] == 'divorciado') { echo "selected"; $i++; }  ?>>Divorciado(a)</option>
            <option value="viudo" <?php if (array_key_exists('eCivil', $datos[$i]) && $datos[$i]['eCivil'] == 'viudo') { echo "selected"; $i++; }  ?>>Viudo(a)</option>
          </select>
        </div>
        <div class="tab input-field col s3 m3 l3">
          <label for="nacionalidad">Nacionalidad</label>
          <input  id="nacionalidad" type="text" class="validate" value="<?php if (array_key_exists('nacionalidad', $datos[$i])) { echo $datos[$i]['nacionalidad']; $i++; }  ?>">
        </div>
      </div>
      <div class="row">
        <div class="">
          <div class="input-field col s4 m4 l4">
            <input id="telefono" type="tel" class="validate" placeholder="+56(9)" value="<?php if (array_key_exists('telefono', $datos[$i])) { echo $datos[$i]['telefono']; $i++; }  ?>">
            <label for="telefono">Telefono</label>
          </div>
          <div class="input-field col s4 m4 l4">
            <input id="telefono2" type="tel" placeholder="*Opcional" class="validate" value="<?php if (array_key_exists('telRec', $datos[$i])) { echo $datos[$i]['telRec']; $i++; } ?>">
            <label for="telefono2">Telefono de Recado</label>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="input-field col s12">
          <input id="email" type="email" class="validate" value="<?php if (array_key_exists('email', $datos[$i])) { echo $datos[$i]['email']; $i++; } ?>">
          <label for="email">Email</label>
        </div>
      </div>

      <?php
        // Obtenemos la información directa del servicio y la almacenamos localmente
        $regiones = json_decode(file_get_contents('regiones.json'), true);
      ?>
      <div class="row">
        <div class=" input-field col s4 m4 l4">Region
          <select class="browser-default validate" id="region" onselect="this.className = ''" name="region" onchange="cargarComunas();">
          <option>Seleccione región</option>
            <?php 
              // Recorremos el JSON buscando los valores asociados a las regiones existentes
              foreach($regiones['regiones'] as $region) {
                echo "<option value='" . $region['region'] . "'" . (array_key_exists('provi', $datos[$i]) && $datos[$i]['provi'] == $region['region']?" selected":"") . ">" . $region['region'] . "</option>\n";
              }
              $i++;
            ?>
          </select>        
        </div>
        <script language="Javascript">
          function cargarComunas() {
            var comunas = {
              <?php
                // Creamos un arreglo asociativo dinámico que llene las comunas en función de la región seleccionada
                $j = 1; 
                $k = 0;
                foreach($regiones['regiones'] as $region) {
                  echo "region" . $j . " : [";
                  $z = 1;
                  foreach($region['comunas'] as $comuna) {
                    echo "\"" . $comuna . "\", ";
                    if ($region['region'] == $datos[$i-1]['provi'] && $comuna == $datos[$i]['comuna']) {
                      $k = $z;
                    }
                    $z++;
                  }
                  echo "\"\"],\n";
                  $j++;
                }
                if ($k != 0) $i++;
                ?>
            };
            
            var campoRegion = document.getElementById('region');
            var campoComuna = document.getElementById('comuna');
            regionSeleccionada = campoRegion.selectedIndex;
            campoComuna.innerHTML = '<option>Selecciona comuna</option>';

            if (regionSeleccionada != "") {
              regionSeleccionada = comunas["region" + regionSeleccionada];
              regionSeleccionada.forEach(function(comuna){
                if (comuna!="") {
                  var opcion = document.createElement('option');
                  opcion.value = comuna;
                  opcion.text = comuna;
                  campoComuna.add(opcion);
                }
              });
            }
            campoComuna.selectedIndex = <?php echo $k; ?>;
          }
        </script>
        <div class=" input-field col s4 m4 l4">Comuna
          <select class="browser-default validate" id="comuna" onselect="this.className = ''" name="comuna">
          </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
        </div>
        <script language="javascript">
          cargarComunas();
        </script>
      </div>
      <div class="row">
        <div class="input-field col s12 m12 l12">
          <input id="direccion" type="text" class="validate" value="<?php if (array_key_exists('direccion', $datos[$i])) { echo $datos[$i]['direccion']; $i++; } ?>">
          <label for="direccion">Direccion</label>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>

      <!-- --------------------------- ESTUDIOS ------------------------------ -->

<div class="row">
    <h4>Estudios</h4>
</div>
<?php
  $datos = $data["pos"]["estudios"];
  $i = 0;
?>
  <div class="row"><!--documentos-->
    <div class="">
      <div class=" input-field col s4 m4 l4">Tipo de Estudios
        <select id="tipoEstudio" class="browser-default" onselect="this.className = ''" name="estudio">
          <option value=""></option>
          <option value="Secundario" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Secundario') { echo "selected"; $i++; }  ?>>Secundario</option>
          <option value="Técnico Superior" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Técnico Superior') { echo "selected"; $i++; }  ?>>Técnico Superior</option>
          <option value="Universitario" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Universitario') { echo "selected"; $i++; }  ?>>Universitario</option>
          <option value="Posgrado" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Posgrado') { echo "selected"; $i++; }  ?>>Posgrado</option>
          <option value="Master" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Master') { echo "selected"; $i++; }  ?>>Master</option>
          <option value="Doctorado" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Doctorado') { echo "selected"; $i++; }  ?>>Doctorado</option>
          <option value="Otro" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Otro') { echo "selected"; $i++; }  ?>>Otro</option>
        </select>
      </div>
      <div class="input-field col s8 m8 l8 carreraBox">
        <label for="carrera">Titulo de la Carrera</label>
        <input id="carrera" type="text" class="validate" value="<?php if (array_key_exists('titulo', $datos[$i])) { echo $datos[$i]['titulo']; $i++; } ?>">
      </div>
    </div>
  </div><!--documentos-->
  <div class="row"><!--datos identificacion-->
    <div class="">
      <div class=" input-field col s4 m4 l4">Estado
          <select  onselect="this.className = ''" name="estado_estudio" class="browser-default" id="estado_estudio">
            <option value=""></option>
            <option value="En Curso" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'En Curso') { echo "selected"; $i++; }  ?>>En Curso</option>
            <option value="Egresado" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Egresado') { echo "selected"; $i++; }  ?>>Graduado</option>
            <option value="Titulado" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Titulado') { echo "selected"; $i++; }  ?>>Titulado</option>
            <option value="Abandonado" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Abandonado') { echo "selected"; $i++; }  ?>>Abandonado</option>
          </select>
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="box_estudio" class="box_estudio">
            <label for="fechaEstudio">Año de Titulación</label>
            <input type="text" class="date" id="fechaEstudio" name="fechaEstudio" placeholder="Ingrese año" value="<?php if (array_key_exists('fechaEstudio', $datos[$i])) { echo $datos[$i]['fechaEstudio']; $i++; } ?>">
          </div>
        
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="box_estudio" class="box_estudio">
            <label for="semestres">Semestres cursados</label>
            <input type="text" class="date" id="semestres" name="semestres" placeholder="" value="<?php if (array_key_exists('semestres', $datos[$i])) { echo $datos[$i]['semestres']; $i++; } ?>">
          </div>
        
        </div>
        <div class=" input-field col s4 m4 l4">Licencia de Conducir
          <select class="js-example-basic-multiple" multiple="multiple" onselect="this.className = ''" name="licencia" id="licencia">
            <option value=""></option>
            <?php $j = 0; ?>
            <option value="Sin licencia" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Sin licencia') { echo "selected";  $j++;}  ?>>Sin Licencia</option>
            <option value="Clase A1" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A1') { echo "selected"; $j++; }  ?>>Clase A1</option>
            <option value="Clase A2" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A2') { echo "selected"; $j++; }  ?>>Clase A2</option>
            <option value="Clase A3" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A3') { echo "selected"; $j++; }  ?>>Clase A3</option>
            <option value="Clase A4" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A4') { echo "selected"; $j++; }  ?>>Clase A4</option>
            <option value="Clase A5" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A5') { echo "selected"; $j++; }  ?>>Clase A5</option>
            <option value="Clase B" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase B') { echo "selected"; $j++;}  ?>>Clase B</option>
            <option value="Clase C" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase C') { echo "selected"; $j++; }  ?>>Clase C</option>
            <option value="Clase D" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase D') { echo "selected"; $j++; }  ?>>Clase D</option>
            <option value="Clase E" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase E') { echo "selected"; $j++; }  ?>>Clase E</option>
            <option value="Clase F" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase F') { echo "selected"; $j++; }  ?>>Clase F</option>
            <?php $i++; ?>
          </select>
        </div>
    </div>
  </div><!--datos identificacion-->
  <?php
    $datos = $data["pos"]["cursos"];
    $i = 0;
    $maxcursos = (isset($datos)?sizeof($datos):0);
  ?>
  <div class="row">
    <h4>Otros Conocimientos (Opcional)</h4>
    <span class="comentario">*Ingrese Máximo 3</span>
    <div class="divider"></div>
  </div>
  <div class="curso1before">
    <div class="row" id="curso_box"><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso">Curso</label>
        <input  id="curso" type="text" class="validate" value="<?php if (isset($datos) && array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3">Fecha</label>
        <input type="text" class="date" id="txtDate3" placeholder="Ingrese mes/año" value="<?php if (isset($datos) && array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
      </div>
      <div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso1" onclick="myFunctionCurso1()">Agregar</div>
        <div onclick="myFunctionEliminarCurso1()" class="waves-effect btn-delete" id="btn-delete-curso1"><i class="small material-icons ">cancel</i></div>
      </div>
    </div>
  </div>
  <div class="curso2before">
    <div class="row" id="curso2_box"><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso2">Curso</label>
        <input  id="curso2" type="text" class="validate" value="<?php if (isset($datos) && array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c2">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c2" value="<?php if (isset($datos) && array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
      </div>
      <div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso2" onclick="myFunctionCurso2()">Agregar</div>
        <div onclick="myFunctionEliminarCurso2()" class="waves-effect btn-delete" id="btn-delete-curso2"><i class="small material-icons ">cancel</i></div>
      </div>
    </div>
  </div>
  <div class="curso3before">
    <div class="row" id="curso3_box"><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso3">Curso</label>
        <input  id="curso3" type="text" class="validate" value="<?php if (isset($datos) && array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c3">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c3" value="<?php if (isset($datos) && array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
      </div>
      <div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso3" onclick="myFunctionCurso3()">Agregar</div>
        <div onclick="myFunctionEliminarCurso3()" class="waves-effect btn-delete" id="btn-delete-curso3"><i class="small material-icons ">cancel</i></div>
      </div>
    </div>
  </div>
  <div class="row">
  </div>
  <div class="row">
    <div class="col s12 m12 l12 boxsmart" id="cursoData">    
      <input type="hidden" id="cursoData_form">
    </div>
  </div>
<!-- ----------------------------------------------- EXPERIENCIA LABORAL --------------------------------- -->
<div class="row">
  <div class="col s8 m8 l8">
    <h4>Expriencia Laboral</h4>
  </div>
</div>
<?php
  $datos = $data["pos"]["experiencia"];
  $i = 0;
  $maxexperiencia = sizeof($datos)-1;
?>
<div class="row"> 
      <div class=" input-field col s4 m4 l4">¿Posee experiencia laboral?
            <select class="browser-default" onselect="this.className = ''" name="experiencia" id="experiencia">
              <option value=""></option>
              <option value="Si" <?php echo (count($datos)>1?"selected":""); ?>>Si</option>
              <option value="No" <?php echo (count($datos)==1?"selected":""); ?>>No</option>
            </select>
          </div>
    </div>
<div class="row">
  <h4>Agregar Experiencia laboral</h4>
  <span class="comentario">*Ingrese Máximo 3</span>
  <div class="divider"></div>
</div>
<div class="row">
  <div id="experiencia_box_1">
    <div class="row">
        <div class=" input-field col s4 m4 l4">
            <label for="empresa">Empresa </label>
            <input  id="empresa" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
        </div>
        <div class=" input-field col s4 m4 l4" >
            <label for="cargo">Cargo</label>
            <input  id="cargo" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">
        </div>
        <div class="col s2 m2 l2 input-field dateUntil">
            <label for="txtDate4">Desde mes/año</label>
            <input type="text" class="date" id="txtDate4" value="<?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; } ?>">
            <p>
                <label for="fechaCargo">
                    <input type="checkbox" value="Al presente" id="fechaCargo" <?php if (array_key_exists('fechaHasta', $datos[$i]) && $datos[$i]['fechaHasta']=="") { echo "checked"; } ?>>
                    <span>Al presente</span>
                </label>
            </p>
        </div>
        <div class="col s2 m2 l2 input-field" id="input-fecha-until">
                <label for="txtDate4h">Hasta mes/año</label>
                <input type="text" class="date" id="txtDate4h" value="<?php if (array_key_exists('fechaHasta', $datos[$i])) { echo $datos[$i]['fechaHasta']; $i++; } ?>">            
        </div>
        <div class="col s2 m2 l2">
            <div id="boton_exp_1" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar()">Agregar</div>
        </div>
    </div>
  </div>
  <div id="experiencia_box_2">
      <div class="row">
          <div class=" input-field col s4 m4 l4">
              <label for="empresa2">Empresa </label>
              <input  id="empresa2" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
          </div>
          <div class=" input-field col s4 m4 l4" >
              <label for="cargo2">Cargo</label>
              <input  id="cargo2" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">

          </div>
          <div class="col s2 m2 l2 input-field">
              <label for="txtDate42">Desde mes/año</label>
              <input type="text" class="date" id="txtDate42" value="<?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; } ?>">
              <p>
                  <label for="fechaCargo2">
                      <input type="checkbox" value="Al presente" id="fechaCargo2" <?php if (array_key_exists('fechaHasta', $datos[$i]) && $datos[$i]['fechaHasta']=="") { echo "checked"; } ?>>
                      <span>Al presente</span>
                  </label>
              </p>
          </div>
          <div class="col s2 m2 l2 input-field" id="input-fecha-until2">
              
                  <label for="txtDate42h">Hasta mes/año</label>
                  <input type="text" class="date" id="txtDate42h" value="<?php if (array_key_exists('fechaHasta', $datos[$i])) { echo $datos[$i]['fechaHasta']; $i++; } ?>">
              
          </div>
          <div class="col s2 m2 l2">
              <div id="boton_exp_2" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar2()">Agregar</div>
          </div>
      </div>
  </div>
  <div id="experiencia_box_3">
      <div class="row">
          <div class=" input-field col s4 m4 l4">
              <label for="empresa3">Empresa </label>
              <input  id="empresa3" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
          </div>
          <div class=" input-field col s4 m4 l4" >
              <label for="cargo3">Cargo</label>
              <input  id="cargo3" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">

          </div>
          <div class="col s2 m2 l2 input-field">
              <label for="txtDate43">Desde mes/año</label>
              <input type="text" class="date" id="txtDate43" value="<?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; } ?>">
              <p>
                  <label for="fechaCargo3">
                      <input type="checkbox" value="Al presente" id="fechaCargo3" <?php if (array_key_exists('fechaHasta', $datos[$i]) && $datos[$i]['fechaHasta']=="") { echo "checked"; } ?>>
                      <span>Al presente</span>
                  </label>
              </p>
          </div>
          <div class="col s2 m2 l2 input-field" id="input-fecha-until3">
      
                  <label for="txtDate43h">Hasta mes/año</label>
                  <input type="text" class="date" id="txtDate43h" value="<?php if (array_key_exists('fechaHasta', $datos[$i])) { echo $datos[$i]['fechaHasta']; $i++; } ?>">
        
          </div>
          <div class="col s2 m2 l2">
              <div id="boton_exp_3" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar3()">Agregar</div>
          </div>
      </div>
  </div>
</div>

<?php 
  $i=0;
?>

<div class="row">
  <div class="col s12 m12 l12  box boxexperiencia boxsmart">
    <p id="experienciaData" style="margin: 0"></p>
      <div id="boxDataExp1">
          <div class="boxDataExp">
              <div class="col s3 m3 l3">
                  <span class="boxDataExpInfo" id="empresaData"><?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?></span>
              </div>
              <div class="col s3 m3 l3">
                  <span class="boxDataExpInfo" id="cargoData"><?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?></span>
              </div>
              <div class="col s2 m2 l2">
                  <span class="boxDataExpInfo" id="fecha1Data"><?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; } ?></span>
              </div>
              <div class="col s2 m2 l2 ">
                  <span class="boxDataExpInfo" id="fecha2Data"><?php if (array_key_exists('fechaHasta', $datos[$i])) { echo $datos[$i]['fechaHasta']; $i++; } ?></span>
              </div>
              <div class="col s2 m2 l2 right-align">
                  <div onclick="elminarExp1()" class="waves-effect btnEliminarExp" id="btnDeleteExp1"><i class="small material-icons">cancel</i></div>
              </div>
          </div>
      </div>
      <div id="boxDataExp2">
          <div class="boxDataExp">
              <div class="col s3 m3 l3">
                  <span class="boxDataExpInfo" id="empresaData2"><?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?></span>
              </div>
              <div class="col s3 m3 l3">
                  <span class="boxDataExpInfo" id="cargoData2"><?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?></span>
              </div>
              <div class="col s2 m2 l2">
                  <span class="boxDataExpInfo" id="fecha1Data2"><?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; } ?></span>
              </div>
              <div class="col s2 m2 l2 ">
                  <span class="boxDataExpInfo" id="fecha2Data2"><?php if (array_key_exists('fechaHasta', $datos[$i])) { echo $datos[$i]['fechaHasta']; $i++; } ?></span>
              </div>
              <div class="col s2 m2 l2 right-align">
                  <div onclick="elminarExp2()" class="waves-effect btnEliminarExp" id="btnDeleteExp2"><i class="small material-icons">cancel</i></div>
              </div>
          </div>
      </div>
      <div id="boxDataExp3">
          <div class="boxDataExp">
              <div class="col s3 m3 l3">
                  <span class="boxDataExpInfo" id="empresaData3"><?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?></span>
              </div>
              <div class="col s3 m3 l3">
                  <span class="boxDataExpInfo" id="cargoData3"><?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?></span>
              </div>
              <div class="col s2 m2 l2">
                  <span class="boxDataExpInfo" id="fecha1Data3"><?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; } ?></span>
              </div>
              <div class="col s2 m2 l2 ">
                  <span class="boxDataExpInfo" id="fecha2Data3"><?php if (array_key_exists('fechaHasta', $datos[$i])) { echo $datos[$i]['fechaHasta']; $i++; } ?></span>
              </div>
              <div class="col s2 m2 l2 right-align">
                  <div onclick="elminarExp3()" class="waves-effect btnEliminarExp" id="btnDeleteExp3"><i class="small material-icons">cancel</i></div>
              </div>
          </div>
      </div>
  </div>
</div>

<!-- _____________________________________________________REFERENCIA LABORAL_______________________________________ -->
  <div class="row">
  <div class="col s8 m8 l8">
    <h4>Referencias Laborales</h4>
  </div>
</div>
<?php
  $datos = $data["pos"]["referencia"];
  $i = 0;
  $maxreferencias = sizeof($datos);
?>
<div class="row"> 
  <div class="tab input-field col s5 m5 l5" id="referenciasLaborales">¿Cuenta con referencias laborales?
        <select class="browser-default" onselect="this.className = ''" name="referencia">
          <option value=""></option>
          <option value="Si" <?php echo (count($datos)>1?"selected":""); ?>>Si</option>
          <option value="No" <?php echo (count($datos)==1?"selected":""); ?>>No</option>
        </select>
      </div>
</div>
<div id="container_ref">
          <div class="row">
              <h4>Agregar Referencias</h4>
              <span class="comentario">*Ingrese Máximo 3</span>
              <div class="divider"></div>
          </div>
          <div class="row" id="refs_box1">
              <div class=" input-field col s6 m6 l6 back-box3">
                  <label for="empresaref">Empresa </label>
                  <input  id="empresaref" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
              </div>
              <div class=" input-field col s6 m6 l6 back-box3" >
                  <label for="contactoref">Nombre del Contacto</label>
                  <input  id="contactoref" type="text" class="validate" value="<?php if (array_key_exists('nombreContacto', $datos[$i])) { echo $datos[$i]['nombreContacto']; } ?>">
              </div>
              <div class="row">
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="cargoref">Cargo</label>
                      <input  id="cargoref" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">
                  </div>
                  <div class=" input-field col s3 m3 l3 back-box2">
                      <label for="telefonoref">Telefono</label>
                      <input  id="telefonoref" type="tel" class="validate" value="<?php if (array_key_exists('telefono', $datos[$i])) { echo $datos[$i]['telefono']; } ?>">
                  </div>
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="emailref">Email</label>
                      <input  id="emailref" type="email" class="validate" value="<?php if (array_key_exists('email', $datos[$i])) { echo $datos[$i]['email']; $i++; } ?>">
                  </div>
                  <div class="col s2 m2 l2 ">
                      <div id="boton_refs1" class="waves-effect waves-light btn-small add" onclick="myFunctionRef()">Agregar</div>
                      <div onclick="myFunctionEliminarRef1()" class="waves-effect btn-delete-ref" id="btn-delete-ref1"><i class="small material-icons ">cancel</i></div>
                  </div>
              </div>
          </div>
          <div class="row" id="refs_box2">
              <div class=" input-field col s6 m6 l6 back-box3">
                  <label for="empresaref2">Empresa 2</label>
                  <input  id="empresaref2" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
              </div>
              <div class=" input-field col s6 m6 l6 back-box3" >
                  <label for="contactoref2">Nombre del Contacto</label>
                  <input  id="contactoref2" type="text" class="validate" value="<?php if (array_key_exists('nombreContacto', $datos[$i])) { echo $datos[$i]['nombreContacto']; } ?>">
              </div>
              <div class="row">
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="cargoref2">Cargo</label>
                      <input  id="cargoref2" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">
                  </div>
                  <div class=" input-field col s3 m3 l3 back-box2">
                      <label for="telefonoref2">Telefono</label>
                      <input  id="telefonoref2" type="tel" class="validate" value="<?php if (array_key_exists('telefono', $datos[$i])) { echo $datos[$i]['telefono']; } ?>">
                  </div>
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="emailref2">Email</label>
                      <input  id="emailref2" type="email" class="validate" value="<?php if (array_key_exists('email', $datos[$i])) { echo $datos[$i]['email']; $i++; } ?>">
                  </div>
                  <div class="row">
                      <div class="col s2 m2 l2">
                          <div id="boton_refs2" class="waves-effect waves-light btn-small add" onclick="myFunctionRef2()">Agregar</div>
                          <div onclick="myFunctionEliminarRef2()" class="waves-effect btn-delete-ref" id="btn-delete-ref2"><i class="small material-icons ">cancel</i></div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="row" id="refs_box3">
              <div class=" input-field col s6 m6 l6 back-box3">
                  <label for="empresaref3">Empresa 3</label>
                  <input  id="empresaref3" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
              </div>
              <div class=" input-field col s6 m6 l6 back-box3" >
                  <label for="contactoref3">Nombre del Contacto</label>
                  <input  id="contactoref3" type="text" class="validate" value="<?php if (array_key_exists('nombreContacto', $datos[$i])) { echo $datos[$i]['nombreContacto']; } ?>">
              </div>
              <div class="row">
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="cargoref3">Cargo</label>
                      <input  id="cargoref3" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">
                  </div>
                  <div class=" input-field col s3 m3 l3 back-box2">
                      <label for="telefonoref3">Telefono</label>
                      <input  id="telefonoref3" type="tel" class="validate" value="<?php if (array_key_exists('telefono', $datos[$i])) { echo $datos[$i]['telefono']; } ?>">
                  </div>
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="emailref3">Email</label>
                      <input  id="emailref3" type="email" class="validate" value="<?php if (array_key_exists('email', $datos[$i])) { echo $datos[$i]['email']; $i++; } ?>">
                  </div>
                  <div class="row">
                      <div class="col s2 m2 l2">
                          <div id="boton_refs3" class="waves-effect waves-light btn-small add" onclick="myFunctionRef3()">Agregar</div>
                          <div onclick="myFunctionEliminarRef3()" class="waves-effect btn-delete-ref" id="btn-delete-ref3"><i class="small material-icons ">cancel</i></div>
                      </div>
                  </div>
              </div>
          </div>
             
      </div>
      <div class="row">
        <div class="col s12 m12 l12  box_referencias boxsmart">
          <p id="referenciaData" style="margin: 0"></p>
        </div>
      </div>
<div class="row"></div>
<div class="row"></div>

<!-- _____________________________________________________DATOS PREVISIONALES_______________________________________ -->

<div class="row">
  <div class="col s8 m8 l8">
    <h4>Datos Previsionales</h4>
  </div>
</div>
<?php
  $datos = $data["pos"]["horarioT"];
  $i = 0;
?>
<div class="row"> 
  <div class="tab input-field col s6 m6 l6" id="datosPrevision">AFP
        <select class="browser-default" onselect="this.className = ''" name="afp" id="afp">
          <option value=""></option>
          <option value="AFP Capital" <?php if (array_key_exists('afp', $datos[$i]) && $datos[$i]['afp'] == 'AFP Capital') { echo "selected"; $i++; } ?>>AFP Capital</option>
          <option value="AFP Cuprum" <?php if (array_key_exists('afp', $datos[$i]) && $datos[$i]['afp'] == 'AFP Cuprum') { echo "selected"; $i++; } ?>>AFP Cuprum</option>
          <option value="AFP Habitat" <?php if (array_key_exists('afp', $datos[$i]) && $datos[$i]['afp'] == 'AFP Habitat') { echo "selected"; $i++; } ?>>AFP Habitat</option>
          <option value="AFP Modelo" <?php if (array_key_exists('afp', $datos[$i]) && $datos[$i]['afp'] == 'AFP Modelo') { echo "selected"; $i++; } ?>>AFP Modelo</option>
          <option value="AFP Planvital" <?php if (array_key_exists('afp', $datos[$i]) && $datos[$i]['afp'] == 'AFP Planvital') { echo "selected"; $i++; } ?>>AFP Planvital</option>
          <option value="AFP Provida" <?php if (array_key_exists('afp', $datos[$i]) && $datos[$i]['afp'] == 'AFP Provida') { echo "selected"; $i++; } ?>>AFP Provida</option>
        </select>
      </div>
      <div class="tab input-field col s6 m6 l6">Isapre o Fonasa
        <select class="browser-default" onselect="this.className = ''" name="isapre" id="isapre">
          <option value=""></option>
          <option value="Fonasa" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fonasa') { echo "selected"; $i++; } ?>>Fonasa</option>
          <option value="Consalud" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Consalud') { echo "selected"; $i++; } ?>>Consalud</option>
          <option value="Colmena" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Colmena') { echo "selected"; $i++; } ?>>Colmena</option>
          <option value="Cruz Blanca" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Cruz Blanca') { echo "selected"; $i++; } ?>>Cruz Blanca</option>
          <option value="Chuquicamata" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Chuquicamata') { echo "selected"; $i++; } ?>>Chuquicamata</option>
          <option value="Banmédica" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Banmedica') { echo "selected"; $i++; } ?>>Banmédica</option>
          <option value="Cruz del Norte" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Cruz del Norte') { echo "selected"; $i++; } ?>>Cruz del Norte</option>
          <option value="Nueva Masvida" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Nueva Masvida') { echo "selected"; $i++; } ?>>Nueva Masvida</option>
          <option value="Fundación" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fundacion') { echo "selected"; $i++; } ?>>Fundación</option>
          <option value="Fusat" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fusat') { echo "selected"; $i++; } ?>>Fusat</option>
          <option value="Río Blanco" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Río Blanco') { echo "selected"; $i++; } ?>>Río Blanco</option>
          <option value="San Lorenzo" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'San Lorenzo') { echo "selected"; $i++; } ?>>San Lorenzo</option>
          <option value="Vida Tres" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Vida Tres') { echo "selected"; $i++; } ?>>Vida Tres</option>
        </select>
      </div>
</div>
<div class="row">
  <h4>Agregar Horario</h4>
  <div class="divider"></div>
</div>
<div class="row">
  <div class=" input-field col s4 m4 l4">Region
        <select class="browser-default validate" id="regionwork" onselect="this.className = ''" name="regionwork" onchange="cargarComunas2();">
          <option value="">Selecciona region</option>
        <?php 
          // Recorremos el JSON buscando los valores asociados a las regiones existentes
          foreach($regiones['regiones'] as $region) {
            echo "<option value='" . $region['region'] . "'" . (array_key_exists('region', $datos[$i]) && $datos[$i]['region'] == $region['region']?" selected":"") . ">" . $region['region'] . "</option>\n";
          }
        ?>
        </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
      </div>

        <script language="Javascript">
            function cargarComunas2() {
                // var comunas = [
                var comunas = {
                <?php
                    $j = 1;
                    $k = 0;
                    foreach($regiones['regiones'] as $region) {
                        echo "region" . $j . " : [";
                        natsort($region['comunas']);
                        $z = 1;
                        foreach($region['comunas'] as $comuna) {
                            echo "\"" . $comuna . "\", ";
                            if ($region['region'] == $datos[$i]['region'] && $comuna == $datos[$i]['comunas']) {
                              $k = $z;
                            }
                            $z++;
                        }
                        echo "\"\"],\n";
                        $j++;
                    }
                    /* $i = 1;
                    foreach($regiones['regiones'] as $region) {
                        echo "                {\n";
                        echo "                    region" . $i . " : [\n";
                        natsort($region['comunas']);
                        $j = 1;
                        foreach($region['comunas'] as $comuna) {
                            echo "                        {\n";
                            echo "                            id: '" . $comuna . "',\n";
                            echo "                            text: '" . $comuna . "'\n";
                            echo "                        }" . ($j<sizeof($region['comunas'])?",":"") . "\n";
                            $j++;
                        }
                        echo "                    ]\n";
                        echo "                }" . ($i<sizeof($regiones['regiones'])?",":"") . "\n";
                        $i++;
                    } */
                ?>
                };
                // ];
                
                /* var campoRegion = document.getElementById('region');
                regionSeleccionada = campoRegion.selectedIndex;
                var data = comunas["region" + regionSeleccionada];

                $("#comuna").select2({
                    data: data,
                    closeOnSelect: false
                }); */                      
                var campoRegion = document.getElementById('regionwork');
                var campoComuna = document.getElementById('comunaswork');
                regionSeleccionada = campoRegion.selectedIndex;
                campoComuna.innerHTML = '<option>Selecciona comuna</option>';

                if (regionSeleccionada != "") {
                    regionSeleccionada = comunas["region" + regionSeleccionada];
                    regionSeleccionada.forEach(function(comuna){
                        var opcion = document.createElement('option');
                        opcion.value = comuna;
                        opcion.text = comuna;
                        campoComuna.add(opcion);
                    });
                }

                campoComuna.selectedIndex = <?php echo $k; ?>;
            }
        </script>
      <div class=" input-field col s4 m4 l4">Comuna
        <select class=".js-example-data-array browser-default" id="comunaswork" name="comunaswork" onselect="this.className = ''">
        </select>
     </div> 
     <script language="Javascript">
        cargarComunas2();
     </script>
     <?php $i++; ?>
</div>
<div class="row">
  <div class="tab input-field col s5 m5 l5">Dias disponibles para trabajar
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
  <div class="tab input-field col s2 m2 l2">Horario Desde
      <select class="js-example-basic-multiple" id="id_label_multiple" multiple="multiple" style="width:60%">
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
  <div class="tab input-field col s2 m2 l2">Hasta
      <select class="js-example-basic-multiple" id="id_label_multiple1" multiple="multiple" style="width:60%">
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
  <div class="col s3 m3 l3">
    <a href="" class="waves-effect waves-light btn agregar">Agregar</a>
  </div>
</div>

   <div class="row">
        <h4 style="color:#838383">Horarios Agregados</h4>
      </div>
      <?php                   
        $show_horarios = 0;
        $max_horarios = sizeof($datos)-2;
      ?>
  <!-- ------------------------------------------------------------- CAJA DE HORARIOS AGREGADOS-------------------------- -->
      <div class="row">
        <div class="col s12 m12 l12  boxsmart" >
          <div id="containerDataHoras">
              <div class="boxSmartContent" id="dias1Box">
                <?php
                  if ($max_horarios > $show_horarios) {
                    $dias = $datos[$i]['dias'];
                    $j = 0;
                    $horario = $datos[$i]['horarios'];
                    $horario_inicio = substr($horario, 0, strpos($horario, 'a')-1);
                    $horario_final = substr($horario, strpos($horario, 'a')+2);
                    $i++;
                    $show_horarios++;
                  } else {
                    $dias = null;
                    $horario_inicio = "";
                    $horario_final = "";
                  }
                ?>
                  <div class="col s9 m9 l9">
                      <span style="color: gray; font-size: 20px" id="diasData1">
                        <?php
                          if ($dias != null) {
                            foreach($dias as $dia) {
                              echo $dia . ", "; 
                            } 
                          }
                        ?>
                      </span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="color: gray; font-size: 20px" class="right-align" >
                      <span id="horasData1"><?php echo $horario_inicio; ?></span>
                      <span>a</span>
                      <span id="horasData1h"><?php echo $horario_final; ?></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora1()" class="waves-effect" id="btn-hora-hora1"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias2Box">
                <?php
                  if ($max_horarios > $show_horarios) {
                    $dias = $datos[$i]['dias'];
                    $j = 0;
                    $horario = $datos[$i]['horarios'];
                    $horario_inicio = substr($horario, 0, strpos($horario, 'a')-1);
                    $horario_final = substr($horario, strpos($horario, 'a')+2);
                    $i++;
                    $show_horarios++;
                  } else {
                    $dias = null;
                    $horario_inicio = "";
                    $horario_final = "";
                  }
                ?>
                  <div class="col s4 m4 l4">
                      <span style="color: gray; font-size: 20px" id="diasData2">
                        <?php
                          if ($dias != null) {
                            foreach($dias as $dia) {
                              echo $dia . ", "; 
                            } 
                          }
                        ?>
                      </span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style="color: gray; font-size: 20px" id="comunasData2"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="color: gray; font-size: 20px" class="right-align" >
                      <span id="horasData2"><?php echo $horario_inicio; ?></span>
                      <span>a</span>
                      <span id="horasData2h"><?php echo $horario_final; ?></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora2()" class="waves-effect" id="btn-hora-hora2"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias3Box">
                <?php
                  if ($max_horarios > $show_horarios) {
                    $dias = $datos[$i]['dias'];
                    $j = 0;
                    $horario = $datos[$i]['horarios'];
                    $horario_inicio = substr($horario, 0, strpos($horario, 'a')-1);
                    $horario_final = substr($horario, strpos($horario, 'a')+2);
                    $i++;
                    $show_horarios++;
                  } else {
                    $dias = null;
                    $horario_inicio = "";
                    $horario_final = "";
                  }
                ?>
                  <div class="col s4 m4 l4">
                      <span style="color: gray; font-size: 20px" id="diasData3">
                        <?php
                          if ($dias != null) {
                            foreach($dias as $dia) {
                              echo $dia . ", "; 
                            } 
                          }
                        ?>
                      </span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style="color: gray; font-size: 20px" id="comunasData3"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="color: gray; font-size: 20px" class="right-align" >
                      <span id="horasData3"><?php echo $horario_inicio; ?></span>
                      <span>a</span>
                      <span id="horasData3h"><?php echo $horario_final; ?></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora3()" class="waves-effect" id="btn-hora-hora3"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias4Box">
                <?php
                  if ($max_horarios > $show_horarios) {
                    $dias = $datos[$i]['dias'];
                    $j = 0;
                    $horario = $datos[$i]['horarios'];
                    $horario_inicio = substr($horario, 0, strpos($horario, 'a')-1);
                    $horario_final = substr($horario, strpos($horario, 'a')+2);
                    $i++;
                    $show_horarios++;
                  } else {
                    $dias = null;
                    $horario_inicio = "";
                    $horario_final = "";
                  }
                ?>
                  <div class="col s4 m4 l4">
                      <span style="color: gray; font-size: 20px" id="diasData4">
                        <?php
                          if ($dias != null) {
                            foreach($dias as $dia) {
                              echo $dia . ", "; 
                            } 
                          }
                        ?>
                      </span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style="color: gray; font-size: 20px" id="comunasData4"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="color: gray; font-size: 20px" class="right-align" >
                      <span id="horasData4"><?php echo $horario_inicio; ?></span>
                      <span>a</span>
                      <span id="horasData4h"><?php echo $horario_final; ?></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora4()" class="waves-effect" id="btn-hora-hora4"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias5Box">
                <?php
                  if ($max_horarios > $show_horarios) {
                    $dias = $datos[$i]['dias'];
                    $j = 0;
                    $horario = $datos[$i]['horarios'];
                    $horario_inicio = substr($horario, 0, strpos($horario, 'a')-1);
                    $horario_final = substr($horario, strpos($horario, 'a')+2);
                    $i++;
                    $show_horarios++;
                  } else {
                    $dias = null;
                    $horario_inicio = "";
                    $horario_final = "";
                  }
                ?>
                  <div class="col s4 m4 l4">
                      <span style="color: gray; font-size: 20px" id="diasData5">
                        <?php
                          if ($dias != null) {
                            foreach($dias as $dia) {
                              echo $dia . ", "; 
                            } 
                          }
                        ?>
                      </span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style="color: gray; font-size: 20px" id="comunasData5"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="color: gray; font-size: 20px" class="right-align" >
                      <span id="horasData5"><?php echo $horario_inicio; ?></span>
                      <span>a</span>
                      <span id="horasData5h"><?php echo $horario_final; ?></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora5()" class="waves-effect" id="btn-hora-hora5"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
          </div>
        </div>

      </div>

<div class="row"></div>
<div class="row"></div>
<!-- _____________________________________________________DATOS UNIFORME_______________________________________ -->

<div class="row">
  <div class="col s8 m8 l8">
    <h4>Datos Uniforme</h4>
  </div>
</div>
<?php
  $datos = $data["pos"]["documentos"];
  $i = 0;
?>
<div class="row">
  <div class="tab" id="uniforme">
    <div class="tab input-field col s4 m4 l4">Talla Polera/camisa
      <select class="browser-default" onselect="this.className = ' ' " name="uniforme">
        <option value=""></option>
        <option value="XS" <?php if (array_key_exists('uniforme', $datos[$i]) && $datos[$i]['uniforme'] == 'XS') { echo "selected"; $i++; } ?>>XS</option>
        <option value="S" <?php if (array_key_exists('uniforme', $datos[$i]) && $datos[$i]['uniforme'] == 'S') { echo "selected"; $i++; } ?>>S</option>
        <option value="M" <?php if (array_key_exists('uniforme', $datos[$i]) && $datos[$i]['uniforme'] == 'M') { echo "selected"; $i++; } ?>>M</option>
        <option value="L" <?php if (array_key_exists('uniforme', $datos[$i]) && $datos[$i]['uniforme'] == 'L') { echo "selected"; $i++; } ?>>L</option>
        <option value="XL" <?php if (array_key_exists('uniforme', $datos[$i]) && $datos[$i]['uniforme'] == 'XL') { echo "selected"; $i++; } ?>>XL</option>
        <option value="XXL" <?php if (array_key_exists('uniforme', $datos[$i]) && $datos[$i]['uniforme'] == 'XXL') { echo "selected"; $i++; } ?>>XXL</option>
      </select>
    </div>
    <div class="tab input-field col s4 m4 l4">Talla Poleron
      <select class="browser-default" onselect="this.className = ' ' " name="uniforme2">
        <option value=""></option>
        <option value="XS" <?php if (array_key_exists('uniforme2', $datos[$i]) && $datos[$i]['uniforme2'] == 'XS') { echo "selected"; $i++; } ?>>XS</option>
        <option value="S" <?php if (array_key_exists('uniforme2', $datos[$i]) && $datos[$i]['uniforme2'] == 'S') { echo "selected"; $i++; } ?>>S</option>
        <option value="M" <?php if (array_key_exists('uniforme2', $datos[$i]) && $datos[$i]['uniforme2'] == 'M') { echo "selected"; $i++; } ?>>M</option>
        <option value="L" <?php if (array_key_exists('uniforme2', $datos[$i]) && $datos[$i]['uniforme2'] == 'L') { echo "selected"; $i++; } ?>>L</option>
        <option value="XL" <?php if (array_key_exists('uniforme2', $datos[$i]) && $datos[$i]['uniforme2'] == 'XL') { echo "selected"; $i++; } ?>>XL</option>
        <option value="XXL" <?php if (array_key_exists('uniforme2', $datos[$i]) && $datos[$i]['uniforme2'] == 'XXL') { echo "selected"; $i++; } ?>>XXL</option>
      </select>
    </div>
    <div class="tab input-field col s4 m4 l4">Talla de zapatos
        <label for="tallaZapato"></label>
        <input  id="tallaZapato" type="text" class="validate" value="<?php if (array_key_exists('tallaZapato', $datos[$i])) { echo $datos[$i]['tallaZapato']; $i++; } ?>">
      </div>
      <div class="row">
        <div class="tab input-field col s8 m8 l8">Talla de Pantalon (ingrese detalles si necesita)
        <label for="tallaPantalon"></label>
        <input  id="tallaPantalon" type="text" class="validate" value="<?php if (array_key_exists('tallaPantalon', $datos[$i])) { echo $datos[$i]['tallaPantalon']; $i++; } ?>">
      </div>
      </div>
  </div>
</div>
<div class="row">
  <h4>Pretensiones de Renta</h4>
  <div class="row">
  <div class="tab">
    <div class="tab input-field col s4 m4 l4">
      <select class="browser-default" onselect="this.className = ' ' " name="renta">
        <option value="">Seleccione Rango</option>
        <option value="275.000 - 350.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '275.000 - 350.000') { echo "selected"; } ?>>275.000 - 350.000</option>
        <option value="350.000 - 400.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '350.000 - 300.000') { echo "selected"; } ?>>350.000 - 400.000</option>
        <option value="400.000 - 450.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '400.000 - 450.000') { echo "selected"; } ?>>400.000 - 450.000</option>
        <option value="450.000 - 500.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '450.000 - 500.000') { echo "selected"; } ?>>450.000 - 500.000</option>
        <option value="500.000 - 550.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '500.000 - 550.000') { echo "selected"; } ?>>500.000 - 550.000</option>
        <option value="550.000 - 600.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '550.000 - 600.000') { echo "selected"; } ?>>550.000 - 600.000</option>
        <option value="600.000 - 800.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '600.000 - 800.000') { echo "selected"; } ?>>600.000 - 800.000</option>
        <option value="800.000 - 1.000.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '800.000 - 1.000.000') { echo "selected"; } ?>>800.000 - 1.000.000</option>
        <option value="Más de 1.000.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == 'Mas de 1.000.000') { echo "selected"; } ?>>Más de 1.000.000</option>
      </select>
    </div>
  </div>
</div>

</div>
</form>      

<div class="row">
  <h4>Adjuntos (Opcional)</h4>
  <?php
    require_once("db.php");
    $files = null;
    $sql = "SELECT id, tipo_archivo, nombre FROM tbl_archivo WHERE id_post = '" . $data["pos"]["id"] . "' AND estado = 1";
    $results = $conn->query($sql);
    if ($results) {
      while($fila = $results->fetch_assoc()) {
        $files[$fila["tipo_archivo"]]["id"] = $fila["id"];
        $files[$fila["tipo_archivo"]]["nombre"] = $fila["nombre"];
      }
    }
  ?>          
  <div class="row">
    
      <div class="row">
        <div class="col s6 m6 l6">
          <label>
            Curriculum
            (<?php echo ($files!=null && array_key_exists("cv", $files)?"<a href=\"download.php?identificador=" . $files["cv"]["id"] . "&tipo=cv\" target=\"blank\">" . $files["cv"]["nombre"] . "</a>":"Ninguno"); ?>)
          </label>
          <iframe frameborder="0" width="200" height="28" name="cv_loader"></iframe>
          <form id="form_cv" class="form_cv" method="POST" action="upload.php" enctype="multipart/form-data" target="cv_loader">
            <input type="hidden" name="id_post" value="<?php echo $data["id"]; ?>" />
            <input type="hidden" name="file_type" value="cv" />
            <div class="file-field input-field">
              <div class="btn">
                <span>Adjuntar</span>
                <input type="file" id="cv" name="cv" onchange="$('#form_cv').submit();">
              </div>
              <div class="file-path-wrapper">
                <i style="right: 0!important; left: auto;" id="remove-cv" onclick="removeCvPath();" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                <input style="width: 80%" class="file-path validate" id="cv-path" type="text" placeholder="Adjuntar Archivo">
              </div>
            </div>
          </form>
        </div>
        <div class="col s6 m6 l6">
          <label>
            Certificado de antecedentes
            (<?php echo ($files!=null && array_key_exists("cerAntecedentes", $files)?"<a href=\"download.php?identificador=" . $files["cerAntecedentes"]["id"] . "&tipo=antecedentes\" target=\"blank\">" . $files["cerAntecedentes"]["nombre"] . "</a>":"Ninguno"); ?>)
          </label>
          <iframe frameborder="0" width="200" height="28" name="antecedentes_loader"></iframe>
          <form id="form_antecedentes" class="form_antecedentes" method="POST" action="upload.php" enctype="multipart/form-data" target="antecedentes_loader">
            <input type="hidden" name="id_post" value="<?php echo $data["id"]; ?>" />
            <input type="hidden" name="file_type" value="cerAntecedentes" />
            <div class="file-field input-field">
              <div class="btn">
                <span>Adjuntar</span>
                <input type="file" id="cerAntecedentes" name="cerAntecedentes" onchange="$('#form_antecedentes').submit();">
              </div>
              <div class="file-path-wrapper">
                <i style="right: 0!important; left: auto;" id="remove-antecedentes" onclick="removeAntecedentesPath();" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                <input style="width: 80%" class="file-path validate" id="antecedentes-path" type="text" placeholder="Adjuntar Archivo">
              </div>
            </div>
          </form>
      </div>
      <div class="row">
        <div class="col s6 m6 l6">
          <label>
            Carnet o Pasaporte
            (<?php echo ($files!=null && array_key_exists("carnet", $files)?"<a href=\"download.php?identificador=" . $files["carnet"]["id"] . "&tipo=carnet\" target=\"blank\">" . $files["carnet"]["nombre"] . "</a>":"Ninguno"); ?>)
          </label>
          <iframe frameborder="0" width="200" height="28" name="id_loader"></iframe>
          <form id="form_id" class="form_id" method="POST" action="upload.php" enctype="multipart/form-data" target="id_loader">
            <input type="hidden" name="id_post" value="<?php echo $data["id"]; ?>" />
            <input type="hidden" name="file_type" value="carnet" />
            <div class="file-field input-field">
              <div class="btn">
                <span>Adjuntar</span>
                <input type="file" id="carnet" name="carnet" onchange="$('#form_id').submit();">
              </div>
              <div class="file-path-wrapper">
                <i style="right: 0!important; left: auto;" id="remove-id" onclick="removeIdPath();" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                <input style="width: 80%" class="file-path validate" id="id-path" type="text" placeholder="Adjuntar Archivo">
              </div>
            </div>
          </form>
        </div>
        <div class="col s6 m6 l6">
          <label>
            Fotografía del Postulante
            (<?php echo ($files!=null && array_key_exists("fotografia", $files)?"<a href=\"download.php?identificador=" . $files["fotografia"]["id"] . "&tipo=fotografia\" target=\"blank\">" . $files["fotografia"]["nombre"] . "</a>":"Ninguno"); ?>)
          </label>
          <iframe frameborder="0" width="200" height="28" name="picture_loader"></iframe>
          <form id="form_picture" class="form_picture" method="POST" action="upload.php" enctype="multipart/form-data" target="picture_loader">
            <input type="hidden" name="id_post" value="<?php echo $data["id"]; ?>" />
            <input type="hidden" name="file_type" value="fotografia" />
            <div class="file-field input-field">
              <div class="btn">
                <span>Adjuntar</span>
                <input type="file" id="fotografia" name="fotografia" onchange="$('#form_picture').submit();">
              </div>
              <div class="file-path-wrapper">
                <i style="right: 0!important; left: auto;" id="remove-picture" onclick="removePicturePath();" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                <input style="width: 80%" class="file-path validate" id="picture-path" type="text" placeholder="Adjuntar Archivo">
              </div>
            </div>
          </form>
        </div>
      </div>
    
  </div>
</div>

<div class="row"></div>
<div class="row"></div>

<!-- -----------------------------------------------BOTONES FINAL --------------------------------- -->
<div class="row">
  <div class="col s6 m6 l6 right">
    <button type="button" class="waves-effect waves-light btn right" onClick="$('#postularform').submit();">Postular</button>
  </div>
</div>
</div><!--container-->

<div class="row">
  <div class="col s12 m12 l12">
    <img src="src/img/logo.jpg" alt="" class="endLogo">
  </div>
</div>

  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type = "text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
  <script src="src/js/postulaciones.js"></script>
  <script language="Javascript">
    // RUT/Pasaporte
    if($('#tipo_doc').val() == 'rut') {
      $('#rut_box').show();
      $('#pasaporte_box').hide();
    } else {
      $('#pasaporte_box').show();
      $('#rut_box').hide();
    }

    // Estudios
    if($('#tipoEstudio').val() == 'Secundario') {
      $('.carreraBox').hide();
    } else {
      $('.carreraBox').show();
    }
    if($('#estado_estudio').val() == 'En Curso') {
      $('#box_estudio').hide();
      $("#fechaEstudio").prop("checked", true);
    } else {
      $('#box_estudio').show();
      $("#fechaEstudio").prop("checked", false);
    }

    // Otros Conocimientos
    $('#curso_box').show();
    $('#btn-send-curso1').<?php echo ($maxcursos>=1?"hide()":"show()"); ?>;
    $('#btn-delete-curso1').<?php echo ($maxcursos>=1?"show()":"hide()"); ?>;
    $('#curso2_box').<?php echo ($maxcursos>=2?"show()":"hide()"); ?>;
    $('#btn-send-curso2').<?php echo ($maxcursos>=2?"hide()":"show()"); ?>;
    $('#btn-delete-curso2').<?php echo ($maxcursos>=2?"show()":"hide()"); ?>;
    $('#curso3_box').<?php echo ($maxcursos>=3?"show()":"hide()"); ?>;
    $('#btn-send-curso3').<?php echo ($maxcursos>=3?"hide()":"show()"); ?>;
    $('#btn-delete-curso3').<?php echo ($maxcursos>=3?"show()":"hide()"); ?>;

    // Experiencia Laboral
    $('#boxDataExp1').<?php echo ($maxexperiencia>=1?"show()":"hide()"); ?>;
    $('#boxDataExp2').<?php echo ($maxexperiencia>=2?"show()":"hide()"); ?>;
    $('#boxDataExp3').<?php echo ($maxexperiencia>=3?"show()":"hide()"); ?>;

    // Referencias
    $('#refs_box1').<?php echo ($maxreferencias>=1?"show()":"hide()"); ?>;
    $('#refs_box2').<?php echo ($maxreferencias>=2?"show()":"hide()"); ?>;
    $('#refs_box3').<?php echo ($maxreferencias>=3?"show()":"hide()"); ?>;

    // Horarios Disponibles
    var containerHoras = $('#containerInputHoras');
    var inputDiaHora1 = $('#inputDiaHora');
    var boxData1 = $('#dias1Box');
    $(boxData1).<?php echo ($show_horarios>=1?"show()":"hide()") ?>;
    $(inputDiaHora1).<?php echo ($show_horarios==0?"show()":"hide()") ?>;
    var inputDiaHora2 = $('#inputDiaHora2');
    var boxData2 = $('#dias2Box');
    $(boxData2).<?php echo ($show_horarios>=2?"show()":"hide()") ?>;
    $(inputDiaHora2).<?php echo ($show_horarios==1?"show()":"hide()") ?>;
    var inputDiaHora3 = $('#inputDiaHora3');
    var boxData3 = $('#dias3Box');
    $(boxData3).<?php echo ($show_horarios>=3?"show()":"hide()") ?>;
    $(inputDiaHora3).<?php echo ($show_horarios==2?"show()":"hide()") ?>;
    var inputDiaHora4 = $('#inputDiaHora4');
    var boxData4 = $('#dias4Box');
    $(boxData4).<?php echo ($show_horarios>=4?"show()":"hide()") ?>;
    $(inputDiaHora4).<?php echo ($show_horarios==3?"show()":"hide()") ?>;
    var inputDiaHora5 = $('#inputDiaHora5');
    var boxData5 = $('#dias5Box');
    $(boxData5).<?php echo ($show_horarios>=5?"show()":"hide()") ?>;
    $(inputDiaHora5).<?php echo ($show_horarios==4?"show()":"hide()") ?>;
  </script>

  <script language="Javascript">
  <?php 
    if (isset($_SESSION["mode"])) {
  ?>
      notie.alert({ type: 1, text: 'Modo desarrollador activado', position: 'bottom' });
  <?php
    }
  ?>
  </script>

</body>
</html>