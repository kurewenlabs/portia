<?php
  session_start();
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
<div class="row">
    <div class="col s1"></div>
    <?php foreach($dataPostulacion as $cargo) {
        echo "<div class='chip col''>" . $cargo['nom'] .  "<i class=\"close material-icons\">close</i></div>";
    } ?>
</div>

<div class="container"> 

  <div class="row">
    <ul class="progressbar">
      <li class="active"></li>
      <li class="active"></li>
      <li></li>
      <li></li>
      <li></li>
      <li></li>
    </ul>
    <div class="col s12 m12 l12 push-m2">
      <div class="progress">
        <div class="determinate" style="width: 32%"></div>
    </div>

    </div>
  </div>
  <div class="row">
    <h4>Estudios</h4>
  </div>

<form id="proceso2form" onsubmit="return false;">
  <div class="row"><!--documentos-->
    <div class="">
      <div class=" input-field col s4 m4 l4">Tipo de Estudios
        <select id="tipoEstudio" class="browser-default" onselect="this.className = ''" name="estudio">
          <option value=""></option>
          <option value="Básica">Enseñanza Básica</option>
          <option value="Media">Enseñanza Media</option>
          <option value="Técnico Superior">Técnico Superior</option>
          <option value="Universitario">Universitario</option>
          <option value="Posgrado">Posgrado</option>
        </select>
      </div>
      <div class="input-field col s8 m8 l8 carreraBox" id="carrerabox">
        <label for="carrera">Titulo de la Carrera</label>
        <input id="carrera" type="text" class="validate">
      </div>
    </div>
  </div><!--documentos-->
  <div class="row"><!--datos identificacion-->
    <div class="">
      <div class=" input-field col s4 m4 l4">Estado
          <select  onselect="this.className = ''" name="estado_estudio" class="browser-default" id="estado_estudio">
            <option value=""></option>
            <option value="En Curso">En Curso</option>
            <option value="Graduado">Egresado</option>
            <option value="Abandonado">Titulado</option>
          </select>
        </div>
        <div class=" input-field col s2 m2 l2">
          <div id="box_estudio" class="box_estudio">
            <label for="fechaEstudio">Año </label>
            <input type="text" class="date" id="fechaEstudio" name="fechaEstudio" placeholder="Ingrese año">
          </div>
        
        </div>
        <div class=" input-field col s2 m2 l2">
          <div class="box_estudio" id="estudiobox">
            <label for="semestres">Semestres cursados</label>
            <input type="text" class="date" id="semestres" namew="semestres" placeholder="Semestres">
          </div>
        </div>

    </div>
  </div><!--datos identificacion-->
  <div class="row">
     <div class=" input-field col s4 m4 l4">Licencia de Conducir
          <select class="js-example-basic-multiple" multiple="multiple" onselect="this.className = ''" name="licencia" id="licencia">
            <option value="Sin licencia">Sin Licencia</option>
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
  <div class="row">
    <h4>Otros Conocimientos (Opcional)</h4>
    <span class="comentario">*Ingrese Máximo 3</span>
    <div class="divider"></div>
  </div>
  <div class="curso1before">
    <div class="row" id="curso_box" ><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso">Curso</label>
        <input  id="curso" type="text" class="validate">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3">Fecha</label>
        <input type="text" class="date" id="txtDate3" placeholder="Ingrese mes/año">
      </div>
      <div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso1" onclick="myFunctionCurso1()">Agregar</div>
        <div onclick="myFunctionEliminarCurso1()" class="waves-effect btn-delete" id="btn-delete-curso1"><i class="small material-icons ">cancel</i></div>
      </div>
    </div>
  </div>
  <div class="curso2before">
    <div class="row" id="curso2_box" ><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso2">Curso</label>
        <input  id="curso2" type="text" class="validate">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c2">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c2">
      </div>
      <div class="col s2 m2 l2">
        <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso2" onclick="myFunctionCurso2()">Agregar</div>
        <div onclick="myFunctionEliminarCurso2()" class="waves-effect btn-delete" id="btn-delete-curso2"><i class="small material-icons ">cancel</i></div>
      </div>
    </div>
  </div>
  <div class="curso3before">
    <div class="row" id="curso3_box" ><!--cursos-->
      <div class=" input-field col s6 m6 l6 back-box1">
        <label for="curso3">Curso</label>
        <input  id="curso3" type="text" class="validate">
      </div>
      <div class="col s4 m4 l4 input-field back-box1">
        <label for="txtDate3c3">Fecha</label>
        <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c3">
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
  <div class="row"></div>
  <div class="row"></div>
  <div class="row">
    <!-- <div class="col s6 m6 l6">
      <a  class="waves-effect waves-light btn-large">Atrás</a>
    </div> -->
    <div class="col s6 m6 l6 pull-m6 right">
      <button type="submit" class="waves-effect waves-light btn right" href="proceso3.php">Siguiente</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
  <script src="src/js/postulaciones.js"></script>

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
