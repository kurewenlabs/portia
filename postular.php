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

<form id="selectionChange" onsubmit="return false;">
 <div class="row"><!--titulo-->
   <div class="col s6 col m6 col l6">
     <h3>Tus Cargos Seleccionados</h3>
   </div>
   <div class="col s2 col m2 col l2">
      <a data-target="modal2" class="btn btn-small modal-trigger botonCargos">Editar cargos</a>
    </div>
    <div class="col s2 col m2 col l2 return">
      <a href="index.php" class="">Volver a cargos</a>
    </div>
 </div>
<div class="row">
    <div class="col s1"></div>
    <?php foreach($dataPostulacion as $cargo) {
        echo "<div class='chip col'>" . ucwords($cargo['nom']) .  "<i class=\"close material-icons\">close</i></div>";
    } ?>

</div>

<!-- Modal EDITAR CARGOS -->
<?php
  // Cargar cargos
  $positions = array();
  $content = file_get_contents('cargos.txt');
  $lines = explode("\n", $content);
  $i=0;
  foreach($lines as $line) {
    $positions[$i] = explode(";", $line);
    $i++;
  }
  $mercados = array('retail', 'administrativo', 'industrial', 'otros');
?>

<div id="modal2" class="modal">
    <div class="modal-content">
        <h4>Seleccione Cargo</h4>
        <div class="row">
          <?php 
            foreach($mercados as $mercado) {
          ?>
          <div class="col s12 m3 l3">
            <!--retail-->
            <h5><?php echo ucwords($mercado); ?></h5>
            <div id="<?php echo $mercado; ?>">
              <?php
                $column = 1;
                foreach($positions as $position) {
                  if(strcmp(rtrim($position[3]), $mercado) == 0) {
              ?>
              <p>
                <label for="<?php echo $mercado[0] . $position[0]; ?>">
                  <input type="checkbox" name="cargo" value="<?php echo $position[1]; ?>" data-index="<?php echo $position[0]; ?>" id="<?php echo $mercado[0] . $position[0]; ?>"<?php echo (array_search($position[0], array_column($dataPostulacion, 'nun'))!==FALSE?' checked':''); ?>>
                  <span><?php echo $position[2]; ?></span>
                </label>
              </p>
              <?php
                    $column++;
                  }
                }
              ?>
            </div>
          </div>
          <?php
            }
          ?>
        </div>
        <div class="modal-footer">
          <button type="submit" class="waves-effect waves-light btn" id="buttonParent" href="proceso2.php" > Actualizar </button>
        </div>
    </div>

</div>
</form>

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
        <form id="postularform" action="processform.php" method="post" onsubmit="return false;">         
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
          <option value="Primario" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Primario') { echo "selected"; $i++; }  ?>>Básica</option>
          <option value="Secundario" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Secundario') { echo "selected"; $i++; }  ?>>Media</option>
          <option value="Técnico Superior" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Técnico Superior') { echo "selected"; $i++; }  ?>>Técnico Superior</option>
          <option value="Universitario" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Universitario') { echo "selected"; $i++; }  ?>>Universitario</option>
          <option value="Posgrado" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Posgrado') { echo "selected"; $i++; }  ?>>Posgrado</option>
          <option value="Master" <?php if (array_key_exists('tipoEstudio', $datos[$i]) && $datos[$i]['tipoEstudio'] == 'Master') { echo "selected"; $i++; }  ?>>Magister</option>
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
            <option value="En Curso" <?php if ($i<count($datos) && array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'En Curso') { echo "selected"; $i++; }  ?>>En Curso</option>
            <option value="Egresado" <?php if ($i<count($datos) && array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Egresado') { echo "selected"; $i++; }  ?>>Graduado</option>
            <option value="Titulado" <?php if ($i<count($datos) && array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Titulado') { echo "selected"; $i++; }  ?>>Titulado</option>
            <option value="Abandonado" <?php if ($i<count($datos) && array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Abandonado') { echo "selected"; $i++; }  ?>>Abandonado</option>
          </select>
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="box_estudio" class="box_estudio">
            <label for="fechaEstudio">Año de Término</label>
            <input type="text" class="date" id="fechaEstudio" name="fechaEstudio" placeholder="Ingrese año" value="<?php if ($i<count($datos) && array_key_exists('fecha_titulacion', $datos[$i])) { echo $datos[$i]['fecha_titulacion']; $i++; } ?>">
          </div>
        
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="estudiobox" class="box_estudio">
            <label for="semestres">Semestres cursados</label>
            <input type="text" class="date" id="semestres" name="semestres" placeholder="" value="<?php if ($i<count($datos) && array_key_exists('semestres', $datos[$i])) { echo $datos[$i]['semestres']; $i++; } ?>">
          </div>
        
        </div>
        <?php 
          $j = 0; 
        ?>
        <div class=" input-field col s4 m4 l4">Licencia de Conducir
          <select class="js-example-basic-multiple" multiple="multiple" onselect="this.className = ''" name="licencia" id="licencia">
            <option value=""></option>
            <option value="Sin licencia" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Sin licencia') { echo "selected";  $j++;}  ?>>Sin Licencia</option>
            <option value="Clase A1" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A1') { echo "selected"; $j++; }  ?>>Clase A1</option>
            <option value="Clase A2" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A2') { echo "selected"; $j++; }  ?>>Clase A2</option>
            <option value="Clase A3" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A3') { echo "selected"; $j++; }  ?>>Clase A3</option>
            <option value="Clase A4" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A4') { echo "selected"; $j++; }  ?>>Clase A4</option>
            <option value="Clase A5" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase A5') { echo "selected"; $j++; }  ?>>Clase A5</option>
            <option value="Clase B" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'][$j] == 'Clase B') { echo "selected"; $j++; }  ?>>Clase B</option>
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
        <input  id="curso" type="text" class="validate" value="<?php if (isset($datos[$i]) && array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3">Fecha</label>
        <input type="text" class="date" id="txtDate3" placeholder="Ingrese mes/año" value="<?php if (isset($datos[$i]) && array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
      </div>
      <!-- div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso1" onclick="myFunctionCurso1()">Agregar</div>
        <div onclick="myFunctionEliminarCurso1()" class="waves-effect btn-delete" id="btn-delete-curso1"><i class="small material-icons ">cancel</i></div>
      </div -->
    </div>
  </div>
  <div class="curso2before">
    <div class="row" id="curso2_box"><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso2">Curso</label>
        <input  id="curso2" type="text" class="validate" value="<?php if (isset($datos[$i]) && array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c2">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c2" value="<?php if (isset($datos[$i]) && array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
      </div>
      <!-- div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso2" onclick="myFunctionCurso2()">Agregar</div>
        <div onclick="myFunctionEliminarCurso2()" class="waves-effect btn-delete" id="btn-delete-curso2"><i class="small material-icons ">cancel</i></div>
      </div -->
    </div>
  </div>
  <div class="curso3before">
    <div class="row" id="curso3_box"><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso3">Curso</label>
        <input  id="curso3" type="text" class="validate" value="<?php if (isset($datos[$i]) && array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c3">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c3" value="<?php if (isset($datos[$i]) && array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
      </div>
      <!-- div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso3" onclick="myFunctionCurso3()">Agregar</div>
        <div onclick="myFunctionEliminarCurso3()" class="waves-effect btn-delete" id="btn-delete-curso3"><i class="small material-icons ">cancel</i></div>
      </div -->
    </div>
  </div>
  <div class="row">
  </div>
  <!-- div class="row">
    <div class="col s12 m12 l12 boxsmart" id="cursoData">    
      <input type="hidden" id="cursoData_form">
    </div>
  </div -->
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
        <!-- div class="col s2 m2 l2">
            <div id="boton_exp_1" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar()">Agregar</div>
        </div -->
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
          <!-- div class="col s2 m2 l2">
              <div id="boton_exp_2" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar2()">Agregar</div>
          </div -->
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
          <!-- div class="col s2 m2 l2">
              <div id="boton_exp_3" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar3()">Agregar</div>
          </div -->
      </div>
  </div>
</div>

<?php 
  $i=0;
?>

<!-- div class="row">
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
</div -->

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
        <select class="browser-default" onselect="this.className = ''" name="referencia_laboral" id="referencia_laboral">
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
                  <!-- div class="col s2 m2 l2 ">
                      <div id="boton_refs1" class="waves-effect waves-light btn-small add" onclick="myFunctionRef()">Agregar</div>
                      <div onclick="myFunctionEliminarRef1()" class="waves-effect btn-delete-ref" id="btn-delete-ref1"><i class="small material-icons ">cancel</i></div>
                  </div -->
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
                  <!-- div class="row">
                      <div class="col s2 m2 l2">
                          <div id="boton_refs2" class="waves-effect waves-light btn-small add" onclick="myFunctionRef2()">Agregar</div>
                          <div onclick="myFunctionEliminarRef2()" class="waves-effect btn-delete-ref" id="btn-delete-ref2"><i class="small material-icons ">cancel</i></div>
                      </div>
                  </div -->
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
                  <!-- div class="row">
                      <div class="col s2 m2 l2">
                          <div id="boton_refs3" class="waves-effect waves-light btn-small add" onclick="myFunctionRef3()">Agregar</div>
                          <div onclick="myFunctionEliminarRef3()" class="waves-effect btn-delete-ref" id="btn-delete-ref3"><i class="small material-icons ">cancel</i></div>
                      </div>
                  </div -->
              </div>
          </div>
             
      </div>
      <!-- div class="row">
        <div class="col s12 m12 l12  box_referencias boxsmart">
          <p id="referenciaData" style="margin: 0"></p>
        </div>
      </div -->
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
          <option value="Banmedica" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Banmedica') { echo "selected"; $i++; } ?>>Banmédica</option>
          <option value="Cruz del Norte" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Cruz del Norte') { echo "selected"; $i++; } ?>>Cruz del Norte</option>
          <option value="Nueva Masvida" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Nueva Masvida') { echo "selected"; $i++; } ?>>Nueva Masvida</option>
          <option value="Fundación" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fundacion') { echo "selected"; $i++; } ?>>Fundación</option>
          <option value="Fusat" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fusat') { echo "selected"; $i++; } ?>>Fusat</option>
          <option value="Rio Blanco" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Río Blanco') { echo "selected"; $i++; } ?>>Río Blanco</option>
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
            echo "<option value='" . $region['region'] . "'>" . $region['region'] . "</option>\n";
          }
        ?>
        </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
      </div>

        <script language="Javascript">
            function cargarComunas2() {
                var comunas = {
                <?php
                    $comunas_select = "";
                    while(array_key_exists("region", $datos[$i])) {
                      $comunas_select = $datos[$i]['region'] . "/" . $datos[$i]['comunas'] . ";" . $comunas_select;
                      $i++;
                    }

                    $j = 1;
                    foreach($regiones['regiones'] as $region) {
                        echo "region" . $j . " : [";
                        natsort($region['comunas']);
                        foreach($region['comunas'] as $comuna) {
                            echo "\"" . $comuna . "\", ";
                        }
                        echo "\"\"],\n";
                        $j++;
                    }
                ?>
                };
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

                var campoSeleccionadas = document.getElementById('comunas_disponibles');
                campoSeleccionadas.value = '<?php echo $comunas_select; ?>';
            }
        </script>
      <div class=" input-field col s4 m4 l4">Comuna
        <select class=".js-example-data-array browser-default" id="comunaswork" name="comunaswork" onselect="this.className = ''">
        </select>
      </div>
      <div class="col s2 m2 l2">
        <div id="boton_comunas" class="waves-effect waves-light btn-small add1" onclick="agregarComunas()">Agregar</div>
      </div> 
      <div class="row">
        <div class="col s12 m12 l12">
          <h4 style="color:#838383">Comunas Agregadas</h4>
        </div>
      </div>
      <div class="row">
          <div class="col s12 m12 l12">
              <input name="comunas_disponibles" id="comunas_disponibles" type="text" readonly />
          </div> 
      </div>
     <script language="Javascript">
        cargarComunas2();
        function agregarComunas() {
            var campoRegion = document.getElementById('regionwork');
            var campoComuna = document.getElementById('comunaswork');
            regionSeleccionada = campoRegion.value;
            comunaSeleccionada = campoComuna.value;
            var campoSeleccionadas = document.getElementById('comunas_disponibles');
            campoSeleccionadas.value = regionSeleccionada + "/" + comunaSeleccionada + ";" + campoSeleccionadas.value;
        }
     </script>
</div>

<div id="inputDiaHora">
    <?php
        $dias_array = false;
        if (isset($datos[$i])) {
            $dias_array = $datos[$i]['dias'];
        }
    ?>
        <div class="row">
            <div class="input-field col s5 m5 l5">Dias disponibles para trabajar
                <select name="dias_work1" class="js-example-basic-multiple" id="dias" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                    <option value="Todos" <?php echo ($dias_array && in_array( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                    <option value="Lunes" <?php echo ($dias_array && in_array( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                    <option value="Martes" <?php echo ($dias_array && in_array( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                    <option value="Miercoles" <?php echo ($dias_array && in_array( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                    <option value="Jueves" <?php echo ($dias_array && in_array( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                    <option value="Viernes" <?php echo ($dias_array && in_array( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                    <option value="Sabado" <?php echo ($dias_array && in_array( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                    <option value="Domingo" <?php echo ($dias_array && in_array( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Horario Desde
                <select name="horaini_work1" class="js-example-basic-multiple" id="id_label_multiple" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Hasta
                <select name="horafin_work1" class="js-example-basic-multiple" id="id_label_multiple1" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>

        </div>
</div>

<div id="inputDiaHora2">
    <?php
        $dias_array = false;
        if (isset($datos[$i+1])) {
          $i++;
          $dias_array = $datos[$i]['dias'];
        }
    ?>
        <div class="row">
            <div class="input-field col s5 m5 l5">Dias disponibles para trabajar
                <select name="dias_work2" class="js-example-basic-multiple" id="dias2" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                    <option value="Todos" <?php echo ($dias_array && in_array( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                    <option value="Lunes" <?php echo ($dias_array && in_array( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                    <option value="Martes" <?php echo ($dias_array && in_array( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                    <option value="Miercoles" <?php echo ($dias_array && in_array( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                    <option value="Jueves" <?php echo ($dias_array && in_array( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                    <option value="Viernes" <?php echo ($dias_array && in_array( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                    <option value="Sabado" <?php echo ($dias_array && in_array( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                    <option value="Domingo" <?php echo ($dias_array && in_array( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Horario Desde
                <select name="horaini_work2" class="js-example-basic-multiple" id="id_label_multiple2" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Hasta
                <select name="horafin_work2" class="js-example-basic-multiple" id="id_label_multiple12" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>

        </div>
</div>
<div id="inputDiaHora3">
    <?php
        $dias_array = false;
        if (isset($datos[$i+1])) {
          $i++;
          $dias_array = $datos[$i]['dias'];
        }
    ?>
        <div class="row">
            <div class="input-field col s5 m5 l5">Dias disponibles para trabajar
                <select name="dias_work3" class="js-example-basic-multiple" id="dias3" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                    <option value="Todos" <?php echo ($dias_array && in_array( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                    <option value="Lunes" <?php echo ($dias_array && in_array( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                    <option value="Martes" <?php echo ($dias_array && in_array( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                    <option value="Miercoles" <?php echo ($dias_array && in_array( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                    <option value="Jueves" <?php echo ($dias_array && in_array( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                    <option value="Viernes" <?php echo ($dias_array && in_array( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                    <option value="Sabado" <?php echo ($dias_array && in_array( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                    <option value="Domingo" <?php echo ($dias_array && in_array( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Horario Desde
                <select name="horaini_work3" class="js-example-basic-multiple" id="id_label_multiple3" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Hasta
                <select name="horafin_work3" class="js-example-basic-multiple" id="id_label_multiple13" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>
        </div>
</div>
<div id="inputDiaHora4">
    <?php
        $dias_array = false;
        if (isset($datos[$i+1])) {
          $i++;
          $dias_array = $datos[$i]['dias'];
        }
    ?>
        <div class="row">
            <div class="input-field col s5 m5 l5">Dias disponibles para trabajar
                <select name="dias_work4" class="js-example-basic-multiple" id="dias4" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                    <option value="Todos" <?php echo ($dias_array && in_array( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                    <option value="Lunes" <?php echo ($dias_array && in_array( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                    <option value="Martes" <?php echo ($dias_array && in_array( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                    <option value="Miercoles" <?php echo ($dias_array && in_array( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                    <option value="Jueves" <?php echo ($dias_array && in_array( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                    <option value="Viernes" <?php echo ($dias_array && in_array( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                    <option value="Sabado" <?php echo ($dias_array && in_array( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                    <option value="Domingo" <?php echo ($dias_array && in_array( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Horario Desde
                <select name="horaini_work4" class="js-example-basic-multiple" id="id_label_multiple4" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                </select>
            </div>
            <div class="input-field col s2 m2 l2">Hasta
                <select name="horafin_work4" class="js-example-basic-multiple" id="id_label_multiple14" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>
        </div>
</div>
<div id="inputDiaHora5">
    <?php
        $dias_array = false;
        if (isset($datos[$i+1])) {
          $i++;
          $dias_array = $datos[$i]['dias'];
        }
    ?>
        <div class="row">
            <div class="input-field col s5 m5 l5">Dias disponibles para trabajar
                <select name="dias_work5" class="js-example-basic-multiple" id="dias5" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                    <option value="Todos" <?php echo ($dias_array && in_array( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                    <option value="Lunes" <?php echo ($dias_array && in_array( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                    <option value="Martes" <?php echo ($dias_array && in_array( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                    <option value="Miercoles" <?php echo ($dias_array && in_array( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                    <option value="Jueves" <?php echo ($dias_array && in_array( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                    <option value="Viernes" <?php echo ($dias_array && in_array( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                    <option value="Sabado" <?php echo ($dias_array && in_array( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                    <option value="Domingo" <?php echo ($dias_array && in_array( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                </select>
            </div>
            <div class=" input-field col s2 m2 l2">Horario Desde
                <select name="horaini_work5" class="js-example-basic-multiple" id="id_label_multiple5" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], 0, strpos($datos[$i]['horarios'],'a')-1)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
            </div>
            <div class=" input-field col s2 m2 l2">Hasta
                <select name="horafin_work5" class="js-example-basic-multiple" id="id_label_multiple15" style="width:60%">
                    <option value=""></option>
                    <option value="1:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="1:00"?"selected":""); ?>>1:00</option>
                    <option value="2:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="2:00"?"selected":""); ?>>2:00</option>
                    <option value="3:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="3:00"?"selected":""); ?>>3:00</option>
                    <option value="4:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="4:00"?"selected":""); ?>>4:00</option>
                    <option value="5:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="5:00"?"selected":""); ?>>5:00</option>
                    <option value="6:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="6:00"?"selected":""); ?>>6:00</option>
                    <option value="7:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="7:00"?"selected":""); ?>>7:00</option>
                    <option value="8:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="8:00"?"selected":""); ?>>8:00</option>
                    <option value="9:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="9:00"?"selected":""); ?>>9:00</option>
                    <option value="10:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="10:00"?"selected":""); ?>>10:00</option>
                    <option value="11:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="11:00"?"selected":""); ?>>11:00</option>
                    <option value="12:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="12:00"?"selected":""); ?>>12:00</option>
                    <option value="13:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                    <option value="14:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                    <option value="15:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                    <option value="16:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                    <option value="17:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                    <option value="18:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                    <option value="19:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                    <option value="20:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                    <option value="21:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                    <option value="22:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                    <option value="23:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                    <option value="24:00" <?php echo ($dias_array && substr($datos[$i]['horarios'], strpos($datos[$i]['horarios'],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
                </select>
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
  <div class="tab">
    <div class="tab input-field col s4 m4 l4">Talla Polera/camisa
      <select class="browser-default" onselect="this.className = ' ' " name="uniforme" id="uniforme">
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
      <select class="browser-default" onselect="this.className = ' ' " name="uniforme2" id="uniforme2">
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
      <select class="browser-default" onselect="this.className = ' ' " name="renta" id="renta">
        <option value="">Seleccione Rango</option>
        <option value="150.000 - 275.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '150.000 - 275.000') { echo "selected"; } ?>>150.000 - 275.000</option>
        <option value="275.000 - 350.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '275.000 - 350.000') { echo "selected"; } ?>>275.000 - 350.000</option>
        <option value="350.000 - 400.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '350.000 - 400.000') { echo "selected"; } ?>>350.000 - 400.000</option>
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
    <button type="button" class="waves-effect waves-light btn right" onClick="$('#postularform').submit();" id="postularbutton">Postular</button>
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
    if($('#tipoEstudio').val() == 'Primario' || $('#tipoEstudio').val() == 'Secundario') {
      $('.carreraBox').hide();
      $('#fechaEstudio').hide();
    } else {
      $('.carreraBox').show();
      $('#fechaEstudio').show();
    }
    if($('#estado_estudio').val() == 'En Curso') {
      $('#box_estudio').hide();
      $("#estudiobox").hide();
    } else {
      $('#box_estudio').show();
      $("#estudiobox").show();
    }

    // Otros Conocimientos
    $('#curso_box').show();
    $('#curso2_box').show();
    $('#curso3_box').show();

    // Experiencia Laboral
    $('#experiencia_box_1').show();
    $('#experiencia_box_2').show();
    $('#experiencia_box_3').show();

    // Referencias
    $('#container_ref').show();
    $('#refs_box1').show();
    $('#refs_box2').show();
    $('#refs_box3').show();

    // Horarios Disponibles
    $('#inputDiaHora').show();
    $('#dias1Box').show();            
    $('#inputDiaHora2').show();
    $('#dias2Box').show();
    $('#inputDiaHora3').show();
    $('#dias3Box').show();
    $('#inputDiaHora4').show();
    $('#dias4Box').show();
    $('#inputDiaHora5').show();
    $('#dias5Box').show();

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