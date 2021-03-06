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
        <ul class="progressbar">
          <li class="active"></li>
          <li class="active"></li>
          <li class="active"></li>
          <li class="active"></li>
          <li></li>
          <li></li>
        </ul>
        <div class="col s12 m12 l12 push-m2">
          <div class="progress">
            <div class="determinate" style="width: 64%"></div>
        </div>

        </div>
      </div>
      <div class="row">
        <h4>Referencias Laborales</h4>
      </div>
   <form id="proceso4form" onsubmit="return false;">
      <div class="row"> 
        <div class="tab input-field col s5 m5 l5">¿Cuenta con referencias laborales?
              <select class="browser-default" onselect="this.className = ''" name="referencia" id="referencia_laboral">
                <option value=""></option>
                <option value="Si">Si</option>
                <option value="No">No</option>
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
                  <input  id="empresaref" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
              </div>
              <div class=" input-field col s6 m6 l6 back-box3" >
                  <label for="contactoref">Nombre del Contacto</label>
                  <input  id="contactoref" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
              </div>
              <div class="row">
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="cargoref">Cargo</label>
                      <input  id="cargoref" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
                  </div>
                  <div class=" input-field col s3 m3 l3 back-box2">
                      <label for="telefonoref">Telefono</label>
                      <input  id="telefonoref" type="tel" class="validate" placeholder="+56(9)" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
                  </div>
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="emailref">Email</label>
                      <input  id="emailref" type="email" class="validate" onblur="validarEmail(this.value)">
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
                  <input  id="empresaref2" type="text" class="validate">
              </div>
              <div class=" input-field col s6 m6 l6 back-box3" >
                  <label for="contactoref2">Nombre del Contacto</label>
                  <input  id="contactoref2" type="text" class="validate">
              </div>
              <div class="row">
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="cargoref2">Cargo</label>
                      <input  id="cargoref2" type="text" class="validate">
                  </div>
                  <div class=" input-field col s3 m3 l3 back-box2">
                      <label for="telefonoref2">Telefono</label>
                      <input  id="telefonoref2" type="tel" class="validate" placeholder="+56(9)">
                  </div>
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="emailref2">Email</label>
                      <input  id="emailref2" type="email" class="validate">
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
                  <input  id="empresaref3" type="text" class="validate">
              </div>
              <div class=" input-field col s6 m6 l6 back-box3" >
                  <label for="contactoref3">Nombre del Contacto</label>
                  <input  id="contactoref3" type="text" class="validate">
              </div>
              <div class="row">
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="cargoref3">Cargo</label>
                      <input  id="cargoref3" type="text" class="validate">
                  </div>
                  <div class=" input-field col s3 m3 l3 back-box2">
                      <label for="telefonoref3">Telefono</label>
                      <input  id="telefonoref3" type="tel" class="validate" placeholder="+56(9)">
                  </div>
                  <div class=" input-field col s4 m4 l4 back-box2">
                      <label for="emailref3">Email</label>
                      <input  id="emailref3" type="email" class="validate">
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
        <div class="col s12 m12 l12 box_referencias boxsmart">
          <p id="referenciaData" style="margin: 0"></p>
        </div>
      </div>
      <div class="row"></div>
      <div class="row"></div>

      <div class="row">
        
        <div class="col s6 m6 l6 pull-m6 right">
          <button type="submit" class="waves-effect waves-light btn right" href="proceso5.php">Siguiente</button>
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