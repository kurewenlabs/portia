<?php
  session_start();
  $data = $_SESSION["postdata"];
  $dataPostulacion = $data["pos"]["pa"];
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
   <div class="col s4 col m4 col l4">
     <h3>Tus Cargos Seleccionados</h3>
   </div>
    <div class="col s2 col m2 col l2 return">
      <a href="index.php" class="">Volver a cargos</a>
    </div>
 </div>
 <div class="row">
  <div class="chip col s1 offset-s1">
    <?php foreach($dataPostulacion as $cargo) {
        echo "<div class='chip col''>" . $cargo['nom'] .  "<i class=\"close material-icons\">close</i></div>";
    } ?>
  </div>
</div>

<div class="container"> 
<div class="row">
  <div class="col s8 m8 l8">
    <h4>Datos Personales</h4>
  </div>
  <form id="postularform" onsubmit="return false;">         
  <?php
    $datos = $data["pos"]["datos"];
    $i = 0;
  ?>
  <div class="col s4 m4 l4">
    <a class="waves-effect  btn-flat editar" href="#datosPersonales">editar</a>
  </div>
</div>
  <div class="row"><!--documentos-->
    <div class="">
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
      <div class=" input-field col s4 m4 l4 " id="pasaporte_box" value="<?php if (array_key_exists('pasaporte', $datos[$i])) { echo $datos[$i]['pasaporte']; $i++; } ?>">
        <label for="Pasaporte">Pasaporte</label>
        <input  id="Pasaporte" type="tel" class="validate rut_box">
      </div>
    </div>
  </div><!--documentos-->
<div class="row"><!--datos identificacion-->
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

</div><!--datos identificacion-->
<div class="row">
  <div class="tab">
    <div class="tab input-field col s3 m3 l3">
      <label for="txtDate">Fecha de Nacimiento</label>
      <input type="text" class="datepicker" id="txtDate" value="<?php if (array_key_exists('fNaci', $datos[$i])) { echo $datos[$i]['fNaci']; $i++; }  ?>"></div>
    </div>
    <div class="tab input-field col s3 m3 l3">
       <select class="browser-default"  id="sexo" onselect="this.className = ''" name="sexo">
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
  </div><!--datos identificacion-->
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
      </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
    
    </div>
    <script language="Javascript">
      function cargarComunas() {
        var comunas = {
          <?php
            // Creamos un arreglo asociativo dinámico que llene las comunas en función de la región seleccionada
            $j = 1; $k = 0;
            foreach($regiones['regiones'] as $region) {
              echo "region" . $j . " : [";
              foreach($region['comunas'] as $comuna) {
                echo "\"" . $comuna . "\", ";
                if ($region['region'] == $datos[$i-1]['provi'] && $comuna == $datos[$i]['comuna']) {
                  $k = $j;
                }
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
<form id="proceso2form" onsubmit="return false;">
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
        <input id="carrera" type="text" class="validate" value="<?php if (array_key_exists('titulo', $datos[$i])) { echo $datos[$i]['titulo']; $i+=2; } ?>">
      </div>
    </div>
  </div><!--documentos-->
  <div class="row"><!--datos identificacion-->
    <div class="">
      <div class=" input-field col s4 m4 l4">Estado
          <select  onselect="this.className = ''" name="estado_estudio" class="browser-default" id="estado_estudio">
            <option value=""></option>
            <option value="En Curso" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'En Curso') { echo "selected"; $i--; }  ?>>En Curso</option>
            <option value="Graduado" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Graduado') { echo "selected"; $i--; }  ?>>Graduado</option>
            <option value="Abandonado" <?php if (array_key_exists('estado_estudio', $datos[$i]) && $datos[$i]['estado_estudio'] == 'Abandonado') { echo "selected"; $i--; }  ?>>Abandonado</option>
          </select>
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="box_estudio" class="box_estudio">
            <label for="txtDate2ftitulacion">Año de Titulación</label>
            <input type="text" class="date" id="txtDate2ftitulacion" placeholder="Ingrese año" value="<?php if (array_key_exists('fecha_titulacion', $datos[$i])) { echo $datos[$i]['fecha_titulacion']; $i+=2; } ?>">
          </div>
        
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="box_estudio" class="box_estudio">
            <label for="txtDate2ftitulacion">Semestres cursados</label>
            <input type="text" class="date" id="txtDate2ftitulacion" placeholder="" value="<?php if (array_key_exists('semestres', $datos[$i])) { echo $datos[$i]['semestres']; $i++; } ?>">
          </div>
        
        </div>

        <div class=" input-field col s4 m4 l4">Licencia de Conducir
          <select onselect="this.className = ''" name="licencia" class="browser-default" id="licencia">
            <option value=""></option>
            <option value="Clase A1" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase A1') { echo "selected"; $i++; }  ?>>Clase A1</option>
            <option value="Clase A2" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase A2') { echo "selected"; $i++; }  ?>>Clase A2</option>
            <option value="Clase A3" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase A3') { echo "selected"; $i++; }  ?>>Clase A3</option>
            <option value="Clase A4" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase A4') { echo "selected"; $i++; }  ?>>Clase A4</option>
            <option value="Clase A5" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase A5') { echo "selected"; $i++; }  ?>>Clase A5</option>
            <option value="Clase B" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase B') { echo "selected"; $i++; }  ?>>Clase B</option>
            <option value="Clase C" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase C') { echo "selected"; $i++; }  ?>>Clase C</option>
            <option value="Clase D" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase D') { echo "selected"; $i++; }  ?>>Clase D</option>
            <option value="Clase E" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase E') { echo "selected"; $i++; }  ?>>Clase E</option>
            <option value="Clase F" <?php if (array_key_exists('licencia', $datos[$i]) && $datos[$i]['licencia'] == 'Clase F') { echo "selected"; $i++; }  ?>>Clase F</option>
          </select>
        </div>
    </div>
  </div><!--datos identificacion-->
  <?php
    $datos = $data["pos"]["cursos"];
    $i = 0;
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
        <input  id="curso" type="text" class="validate" value="<?php if (array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3">Fecha</label>
        <input type="text" class="date" id="txtDate3" placeholder="Ingrese mes/año" value="<?php if (array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
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
        <input  id="curso2" type="text" class="validate" value="<?php if (array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c2">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c2" value="<?php if (array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
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
        <input  id="curso3" type="text" class="validate" value="<?php if (array_key_exists('nombre', $datos[$i])) { echo $datos[$i]['nombre']; } ?>">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c3">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c3" value="<?php if (array_key_exists('fecha', $datos[$i])) { echo $datos[$i]['fecha']; $i++; } ?>">
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
    <div class="col s12 m12 l12 box" id="cursoData">
        
    <input type="hidden" id="cursoData_form">

    </div>
  </div>
<!-- ----------------------------------------------- EXPERIENCIA LABORAL --------------------------------- -->
<div class="row">
  <div class="col s8 m8 l8">
    <h4>Expriencia Laboral</h4>
  </div>
  <div class="col s4 m4 l4">
    <a class="waves-effect  btn-flat editar" href="#experienciaLaboral">editar</a>
  </div>
</div>
<?php
  $datos = $data["pos"]["experiencia"];
  $i = 0;
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
  <div class="tab input-field col s5 m5 l5">
     <label for="empresa">Empresa</label>
     <input  id="empresa" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
   </div>
   <div class="tab input-field col s5 m5 l5" >
     <label for="cargo">Cargo</label>
     <input  id="cargo" type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">
   </div>
   <div class="col s2 m2 l2 input-field">
     <label for="txtDate4">Fecha</label>
        <input type="text" class="datepicker" id="txtDate4" value="<?php if (array_key_exists('fechaDesde', $datos[$i])) { echo $datos[$i]['fechaDesde']; $i++; } ?>">
  </div>
</div>
<div class="row">
  <div class="col s2 m2 l2">
    <a href="" class="waves-effect waves-light btn-large" onclick="myFunctionAgregar()">Agregar</a>
  </div>
</div> 
<div class="row">
  <div class="col s12 m12 l12 box">
    <p id="experienciaData"></p>
  </div>
</div>

<!-- _____________________________________________________REFERENCIA LABORAL_______________________________________ -->
  <div class="row">
  <div class="col s8 m8 l8">
    <h4>Referencias Laborales</h4>
  </div>
  <div class="col s4 m4 l4">
    <a class="waves-effect  btn-flat editar" href="#referenciasLaborales">editar</a>
  </div>
</div>
<?php
  $datos = $data["pos"]["referencia"];
  $i = 0;
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
<div class="row">
  <h4>Agregar Referencias</h4>
  <span class="comentario">*Ingrese Máximo 3</span>
  <div class="divider"></div>
</div>
<div class="row">
  <div class="tab input-field col s6 m6 l6">
     <label for="empresa2">Empresa</label>
     <input  id="empresa2" type="text" class="validate" value="<?php if (array_key_exists('empresa', $datos[$i])) { echo $datos[$i]['empresa']; } ?>">
   </div>
   <div class="tab input-field col s6 m6 l6" >
     <label for="contacto2">Nombre del Contacto</label>
     <input  id="contacto2" type="text" class="validate" value="<?php if (array_key_exists('nombreContacto', $datos[$i])) { echo $datos[$i]['nombreContacto']; } ?>">
   </div>
   <div class="row">
     <div class="tab input-field col s4 m4 l4">
     <label for="cargo2">Cargo</label>
     <input  id="cargo2"type="text" class="validate" value="<?php if (array_key_exists('cargo', $datos[$i])) { echo $datos[$i]['cargo']; } ?>">
   </div>
   <div class="tab input-field col s4 m4 l4">
     <label for="telefono2">Telefono</label>
     <input  id="telefono2"type="text" class="validate" value="<?php if (array_key_exists('telefono', $datos[$i])) { echo $datos[$i]['telefono']; } ?>">
   </div>
   <div class="tab input-field col s4 m4 l4">
     <label for="email2">Email</label>
     <input  id="email2" type="email" class="validate" value="<?php if (array_key_exists('email', $datos[$i])) { echo $datos[$i]['email']; $i++; } ?>">
   </div>
  <div class="row">
    <div class="col s2 m2 l2">
     <a href="" class="waves-effect waves-light btn-large" onclick="myFunctionRef()">Agregar</a>
    </div>
  </div> 
   </div>
</div>

<div class="row">
  <div class="col s12 m12 l12 box">
    <p id="referenciaData"></p>
  </div>
</div>
<div class="row"></div>
<div class="row"></div>

<!-- _____________________________________________________DATOS PREVISIONALES_______________________________________ -->

<div class="row">
  <div class="col s8 m8 l8">
    <h4>Datos Previsionales</h4>
  </div>
  <div class="col s4 m4 l4">
    <a class="waves-effect  btn-flat editar" href="#datosPrevision">editar</a>
  </div>
</div>
<?php
  $datos = $data["pos"]["horarioT"];
  $i = 0;
?>
<div class="row"> 
  <div class="tab input-field col s6 m6 l6" id="datosPrevision">AFP
        <select class="browser-default" onselect="this.className = ''" name="afp">
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
        <select class="browser-default" onselect="this.className = ''" name="isapre">
          <option value=""></option>
          <option value="Fonasa" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fonasa') { echo "selected"; $i++; } ?>>Fonasa</option>
          <option value="Consalud" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Consalud') { echo "selected"; $i++; } ?>>Consalud</option>
          <option value="Colmena" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Colmena') { echo "selected"; $i++; } ?>>Colmena</option>
          <option value="Cruz Blanca" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Cruz Blanca') { echo "selected"; $i++; } ?>>Cruz Blanca</option>
          <option value="Chuquicamata" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Chuquicamata') { echo "selected"; $i++; } ?>>Chuquicamata</option>
          <option value="Banmédica" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Banmédica') { echo "selected"; $i++; } ?>>Banmédica</option>
          <option value="Cruz del Norte" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Cruz del Norte') { echo "selected"; $i++; } ?>>Cruz del Norte</option>
          <option value="Nueva Masvida" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Nueva Masvida') { echo "selected"; $i++; } ?>>Nueva Masvida</option>
          <option value="Fundación" <?php if (array_key_exists('isapre', $datos[$i]) && $datos[$i]['isapre'] == 'Fundación') { echo "selected"; $i++; } ?>>Fundación</option>
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
<?php
  $dias = $datos[$i]['dias'];
  $j = 0;
?>
<div class="row">
  <div class="tab input-field col s5 m5 l5">Dias disponibles para trabajar
      <select class="js-example-basic-multiple" id="id_label_multiple" multiple="multiple" style="width:60%">
         <option value="Todos">Todos</option>
         <option value="Lunes" <?php if ($dias[$j] == 'Lunes') { echo "selected"; $j++; } ?>>Lunes</option>
         <option value="Martes" <?php if ($dias[$j] == 'Martes') { echo "selected"; $j++; } ?>>Martes</option>
         <option value="Miercoles" <?php if ($dias[$j] == 'Miercoles') { echo "selected"; $j++; } ?>>Miercoles</option>
         <option value="Jueves" <?php if ($dias[$j] == 'Jueves') { echo "selected"; $j++; } ?>>Jueves</option>
         <option value="Viernes" <?php if ($dias[$j] == 'Viernes') { echo "selected"; $j++; } ?>>Viernes</option>
         <option value="Sabado" <?php if ($dias[$j] == 'Sabado') { echo "selected"; $j++; } ?>>Sabado</option>
         <option value="Domingo" <?php if ($dias[$j] == 'Domingo') { echo "selected"; $j++; } ?>>Domingo</option>

      </select>   
  </div>
  <?php
    $horario = $datos[$i]['horarios'];
    $i++;
    $horario_inicio = substr($horario, 0, strpos($horario, 'a')-1);
    $horario_final = substr($horario, strpos($horario, 'a')+2);
  ?>
  <div class="tab input-field col s2 m2 l2">Horario Desde
      <select class="js-example-basic-multiple" id="id_label_multiple" multiple="multiple" style="width:60%">
        <option value="1:00" <?php echo ($horario_inicio=='1:00'?"selected":""); ?>>1:00</option>
          <option value="2:00" <?php echo ($horario_inicio=='2:00'?"selected":""); ?>>2:00</option>
          <option value="3:00" <?php echo ($horario_inicio=='3:00'?"selected":""); ?>>3:00</option>
          <option value="4:00" <?php echo ($horario_inicio=='4:00'?"selected":""); ?>>4:00</option>
          <option value="5:00" <?php echo ($horario_inicio=='5:00'?"selected":""); ?>>5:00</option>
          <option value="6:00" <?php echo ($horario_inicio=='6:00'?"selected":""); ?>>6:00</option>
          <option value="7:00" <?php echo ($horario_inicio=='7:00'?"selected":""); ?>>7:00</option>
          <option value="8:00" <?php echo ($horario_inicio=='8:00'?"selected":""); ?>>8:00</option>
          <option value="9:00" <?php echo ($horario_inicio=='9:00'?"selected":""); ?>>9:00</option>
          <option value="10:00" <?php echo ($horario_inicio=='10:00'?"selected":""); ?>>10:00</option>
          <option value="11:00" <?php echo ($horario_inicio=='11:00'?"selected":""); ?>>11:00</option>
          <option value="12:00" <?php echo ($horario_inicio=='12:00'?"selected":""); ?>>12:00</option>
      </select>   
  </div>
  <div class="tab input-field col s2 m2 l2">Hasta
      <select class="js-example-basic-multiple" id="id_label_multiple" multiple="multiple" style="width:60%">
         <option value="13:00" <?php echo ($horario_final=='13:00'?"selected":""); ?>>13:00</option>
          <option value="14:00" <?php echo ($horario_final=='14:00'?"selected":""); ?>>14:00</option>
          <option value="15:00" <?php echo ($horario_final=='15:00'?"selected":""); ?>>15:00</option>
          <option value="16:00" <?php echo ($horario_final=='16:00'?"selected":""); ?>>16:00</option>
          <option value="17:00" <?php echo ($horario_final=='17:00'?"selected":""); ?>>17:00</option>
          <option value="18:00" <?php echo ($horario_final=='18:00'?"selected":""); ?>>18:00</option>
          <option value="19:00" <?php echo ($horario_final=='19:00'?"selected":""); ?>>19:00</option>
          <option value="20:00" <?php echo ($horario_final=='20:00'?"selected":""); ?>>20:00</option>
          <option value="21:00" <?php echo ($horario_final=='21:00'?"selected":""); ?>>21:00</option>
          <option value="22:00" <?php echo ($horario_final=='22:00'?"selected":""); ?>>22:00</option>
          <option value="23:00" <?php echo ($horario_final=='23:00'?"selected":""); ?>>23:00</option>
          <option value="24:00" <?php echo ($horario_final=='24:00'?"selected":""); ?>>24:00</option>
      </select>   
  </div>
  <div class="col s3 m3 l3">
    <a href="" class="waves-effect waves-light btn agregar">Agregar</a>
  </div>
</div>
<div class="row">
  <div class=" input-field col s4 m4 l4">Region
        <select class="browser-default validate" id="provincia" onselect="this.className = ''" name="region">
        <?php 
          // Recorremos el JSON buscando los valores asociados a las regiones existentes
          foreach($regiones['regiones'] as $region) {
            echo "<option value='" . $region['region'] . "'" . (array_key_exists('provi', $datos[$i]) && $datos[$i]['provi'] == $region['region']?" selected":"") . ">" . $region['region'] . "</option>\n";
          }
          $i++;
        ?>
        </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
      </div>

      <div class=" input-field col s4 m4 l4">Comuna
        <select class="browser-default validate" id="comuna" onselect="this.className = ''" name="comuna">
        </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
     </div> 
</div>
<div class="row">
  <h4 style="color:#838383">Horarios Agregados</h4>
</div>
<div class="row">
  <div class="col s12 m12 l12 box">
    
  </div>
</div>
<div class="row"></div>
<div class="row"></div>
<!-- _____________________________________________________DATOS UNIFORME_______________________________________ -->

<div class="row">
  <div class="col s8 m8 l8">
    <h4>Datos Uniforme</h4>
  </div>
  <div class="col s4 m4 l4">
    <a class="waves-effect  btn-flat editar" href="#uniforme">editar</a>
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
        <option value="275.000 - 350.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '275.000 - 350.000') { echo "selected"; $i++; } ?>>275.000 - 350.000</option>
        <option value="350.000 - 400.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '350.000 - 300.000') { echo "selected"; $i++; } ?>>350.000 - 400.000</option>
        <option value="400.000 - 450.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '400.000 - 450.000') { echo "selected"; $i++; } ?>>400.000 - 450.000</option>
        <option value="450.000 - 500.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '450.000 - 500.000') { echo "selected"; $i++; } ?>>450.000 - 500.000</option>
        <option value="500.000 - 550.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '500.000 - 550.000') { echo "selected"; $i++; } ?>>500.000 - 550.000</option>
        <option value="550.000 - 600.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '550.000 - 600.000') { echo "selected"; $i++; } ?>>550.000 - 600.000</option>
        <option value="600.000 - 800.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '600.000 - 800.000') { echo "selected"; $i++; } ?>>600.000 - 800.000</option>
        <option value="800.000 - 1.000.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == '800.000 - 1.000.000') { echo "selected"; $i++; } ?>>800.000 - 1.000.000</option>
        <option value="Más de 1.000.000" <?php if (array_key_exists('renta', $datos[$i]) && $datos[$i]['renta'] == 'Más de 1.000.000') { echo "selected"; $i++; } ?>>Más de 1.000.000</option>
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
                  <div class="btn">
                    <span>Adjuntar</span>
                    <input type="file" id="cv" name="curriculum">
                  </div>
                  <div class="file-path-wrapper">
                    <i style="right: 0!important; left: auto;" id="remove-cv" onclick="removeCvPath()" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                    <input style="width: 80%" class="file-path validate" id="cv-path" type="text" placeholder="Adjuntar Archivo">

                  </div>
                </div>
                </div>
                <div class="col s6 m6 l6">
                <label>Certificado de antecedentes</label>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Adjuntar</span>
                    <input type="file" id="cerAntecedentes" name="antecedentes">
                  </div>
                  <div class="file-path-wrapper">
                      <i style="right: 0;left: auto" id="remove-antecedentes" onclick="removeAntecedentesPath()" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                      <input style="width: 80%"  id="antecedentes-path" class="file-path validate" type="text" placeholder="Adjuntar Archivo">
                  </div>
                </div>
                </div>
              </div>
              <div class="row">
                <div class="col s6 m6 l6">
                <label>Carnet o Pasaporte</label>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Adjuntar</span>
                    <input type="file" id="docIdentidad" name="docIdentidad">
                  </div>
                  <div class="file-path-wrapper">
                      <i style="right: 0;left: auto;" id="remove-id" onclick="removeIdPath()" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                    <input style="width: 80%" id="id-path" class="file-path validate" type="text" placeholder="Adjuntar Archivo">

                  </div>
                </div>
                </div>
                <div class="col s6 m6 l6">
                <label>Fotografía del o la Postulante</label>
                <div class="file-field input-field">
                  <div class="btn">
                    <span>Adjuntar</span>
                    <input type="file" id="fotografia" name="fotografia">
                  </div>
                  <div class="file-path-wrapper">
                      <i style="right: 0;left: auto" id="remove-picture" onclick="removePicturePath()" class="material-icons btn-flat prefix">cancel</i><!-- este es el btn de remover -->
                    <input style="width: 80%" id="picture-path" class="file-path validate" type="text" placeholder="Adjuntar Archivo">
                  </div>
                </div>
                </div>
              </div>
            
          </div>
        </div>
</div>

<div class="row"></div>
<div class="row"></div>

<!-- -----------------------------------------------BOTONES FINAL --------------------------------- -->
<div class="row">
  <div class="col s6 m6 l6 pull-m6 right">
    <button type="submit" class="waves-effect waves-light btn right" >Postular</button>
  </div>
</div>
</form>
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
</body>
</html>