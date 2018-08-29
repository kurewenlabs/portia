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
        echo "<div class='chip col'>" . $cargo['nom'] .  "<i class=\"close material-icons\">close</i></div>";
    } ?>
</div>

<div class="container"> 

    <div class="row">
      <ul class="progressbar">
        <li class="active"></li>
        <li class="active"></li>
        <li class="active"></li>
        <li></li>
        <li></li>
        <li></li>
      </ul>
      <div class="col s12 m12 l12 push-m2">
        <div class="progress">
          <div class="determinate" style="width: 48%"></div>
      </div>

      </div>
    </div>
    <div class="row">
      <h4>Experiencia Laboral</h4>
    </div>

  <form id="proceso3form" onsubmit="return false;">
    <div class="row"> 
      <div class=" input-field col s4 m4 l4">¿Posee experiencia laboral?
            <select class="browser-default" onselect="this.className = ''" name="experiencia" id="experiencia">
              <option value=""></option>
              <option value="Si">Si</option>
              <option value="No">No</option>
            </select>
          </div>
    </div>
    <div id="box_experiencia">
        <div class="row" id="">
            <h4>Agregar Experiencia laboral</h4>
            <span class="comentario">*Ingrese Máximo 3</span>
            <div class="divider"></div>
        </div>
        <div id="experiencia_box_1">
            <div class="row">
                <div class=" input-field col s4 m4 l4">
                    <label for="empresa">Empresa </label>
                    <input  id="empresa" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
                </div>
                <div class=" input-field col s4 m4 l4" >
                    <label for="cargo">Cargo</label>
                    <input  id="cargo" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">

                </div>
                <div class="col s2 m2 l2 input-field dateUntil">
                    <label for="txtDate4">Desde mes/año</label>
                    <input type="text" class="date" id="txtDate4" placeholder="01/2018" onchange="esfechavalida2(this.value)">
                    <p>
                        <label for="fechaCargo">
                            <input type="checkbox" value="Al presente" id="fechaCargo">
                            <span>Al presente</span>
                        </label>
                    </p>
                </div>
                <div class="col s2 m2 l2 input-field" id="input-fecha-until">
                  
                        <label for="txtDate4h">Hasta mes/año</label>
                        <input type="text" class="date" id="txtDate4h"  placeholder="01/2018" onchange="esfechavalida2(this.value)">
                    
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
                    <input  id="empresa2" type="text" class="validate">
                </div>
                <div class=" input-field col s4 m4 l4" >
                    <label for="cargo2">Cargo</label>
                    <input  id="cargo2" type="text" class="validate">

                </div>
                <div class="col s2 m2 l2 input-field">
                    <label for="txtDate42">Desde mes/año</label>
                    <input type="text" class="date" id="txtDate42" placeholder="01/2018">
                    <p>
                        <label for="fechaCargo2">
                            <input type="checkbox" value="Al presente" id="fechaCargo2">
                            <span>Al presente</span>
                        </label>
                    </p>
                </div>
                <div class="col s2 m2 l2 input-field" id="input-fecha-until2">
                   
                        <label for="txtDate42h">Hasta mes/año</label>
                        <input type="text" class="date" id="txtDate42h"  placeholder="01/2018">
                    
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
                    <input  id="empresa3" type="text" class="validate">
                </div>
                <div class=" input-field col s4 m4 l4" >
                    <label for="cargo3">Cargo</label>
                    <input  id="cargo3" type="text" class="validate">

                </div>
                <div class="col s2 m2 l2 input-field">
                    <label for="txtDate43">Desde mes/año</label>
                    <input type="text" class="date" id="txtDate43" placeholder="01/2018">
                    <p>
                        <label for="fechaCargo3">
                            <input type="checkbox" value="Al presente" id="fechaCargo3">
                            <span>Al presente</span>
                        </label>
                    </p>
                </div>
                <div class="col s2 m2 l2 input-field"id="input-fecha-until3">
            
                        <label for="txtDate43h">Hasta mes/año</label>
                        <input type="text" class="date" id="txtDate43h" placeholder="01/2018">
             
                </div>
                <div class="col s2 m2 l2">
                    <div id="boton_exp_3" class="waves-effect waves-light btn-small right" onclick="myFunctionAgregar3()">Agregar</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
      <div class="col s12 m12 l12   boxsmart">
        <p id="experienciaData" style="margin: 0"></p>
          <div id="boxDataExp1">
              <div class="boxDataExp">
                  <div class="col s3 m3 l3">
                      <span class="boxDataExpInfo" id="empresaData"></span>
                  </div>
                  <div class="col s3 m3 l3">
                      <span class="boxDataExpInfo" id="cargoData"></span>
                  </div>
                  <div class="col s2 m2 l2">
                      <span class="boxDataExpInfo" id="fecha1Data"></span>
                  </div>
                  <div class="col s3 m3 l3 ">
                      <span class="boxDataExpInfo" id="fecha2Data"></span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="elminarExp1()" class="waves-effect btnEliminarExp" id="btnDeleteExp1"><i class="small material-icons">cancel</i></div>
                  </div>
              </div>
          </div>
          <div id="boxDataExp2">
              <div class="boxDataExp">
                  <div class="col s3 m3 l3">
                      <span class="boxDataExpInfo" id="empresaData2"></span>
                  </div>
                  <div class="col s3 m3 l3">
                      <span class="boxDataExpInfo" id="cargoData2"></span>
                  </div>
                  <div class="col s2 m2 l2">
                      <span class="boxDataExpInfo" id="fecha1Data2"></span>
                  </div>
                  <div class="col s3 m3 l3 ">
                      <span class="boxDataExpInfo" id="fecha2Data2"></span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="elminarExp2()" class="waves-effect btnEliminarExp" id="btnDeleteExp2"><i class="small material-icons">cancel</i></div>
                  </div>
              </div>
          </div>
          <div id="boxDataExp3">
              <div class="boxDataExp">
                  <div class="col s3 m3 l3">
                      <span class="boxDataExpInfo" id="empresaData3"></span>
                  </div>
                  <div class="col s3 m3 l3">
                      <span class="boxDataExpInfo" id="cargoData3"></span>
                  </div>
                  <div class="col s2 m2 l2">
                      <span class="boxDataExpInfo" id="fecha1Data3"></span>
                  </div>
                  <div class="col s3 m3 l3 ">
                      <span class="boxDataExpInfo" id="fecha2Data3"></span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="elminarExp3()" class="waves-effect btnEliminarExp" id="btnDeleteExp3"><i class="small material-icons">cancel</i></div>
                  </div>
              </div>
          </div>
      </div>
    </div>
    <div class="row"></div>
    <div class="row"></div>
    <div class="row">
      <div class="col s6 m6 l6">
        <!-- <a  class="waves-effect waves-light btn-large">Atrás</a> -->
      </div>
      <div class="col s6 m6 l6 pull-m6 right">
        <button type="submit" class="waves-effect waves-light btn right" href="proceso4.php">Siguiente</button>
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
  <script src="src/js/tools.js"></script>
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