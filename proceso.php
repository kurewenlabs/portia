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
    <li class=""></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
  </ul>
  <div class="col s12 m12 l12 push-m2">
    <div class="progress">
      <div class="determinate" style="width: 16%"></div>
  </div>

  </div>
</div>

<form id="procesoform" onsubmit="return false;">
<div class="row">
  <h4>Datos Personales</h4>
</div>
  <div class="row"><!--documentos-->
    <div class="">
      <div class=" input-field col s4 m4 l4">Documento de Identificacion
        <select class="browser-default" onselect="this.className = ''" name="documento" id="tipo_doc">
          <option value="rut">RUT</option>
          <option value="pasaporte">Pasaporte</option>
        </select>
      </div>
      <div class=" input-field col s4 m4 l4 " id="rut_box">
        <label for="rut">RUT</label>
        <input placeholder="123456789" id="rut" class="validate" type="text" onblur="esrut(this.value)">
      </div>
      <div class=" input-field col s4 m4 l4 " id="pasaporte_box">
        <label for="pasaporte">Pasaporte</label>
        <input  id="pasaporte" type="text" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
      </div>
    </div>
  </div><!--documentos-->
<div class="row"><!--datos identificacion-->
  <div class="">
    <div class=" input-field col s4 m4 l4">
        <label for="first_name">Nombres</label>
        <input  id="first_name" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
      </div>
      <div class=" input-field col s4 m4 l4">
        <label for="last_name">Apellido Paterno</label>
        <input  id="last_name" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
      </div>
      <div class=" input-field col s4 m4 l4">
        <label for="last_name_2">Apellido Materno</label>
        <input  id="last_name_2" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
      </div>
  </div>

</div><!--datos identificacion-->
<div class="row">
  <div class="">
    <div class=" input-field col s3 m3 l3">
      <label for="txtDate">Fecha de Nacimiento</label>
      <input type="text"  id="txtDate" onchange="esfechavalida(this.value)"></div>
    </div>
    <div class=" input-field col s3 m3 l3">
       <select class="browser-default"  id="sexo" onselect="this.className = ''" name="sexo">
        <option value="">Sexo</option>
        <option value="femenino">Femenino</option>
        <option value="masculino">Masculino</option>
      </select>
    </div>
    <div class=" input-field col s3 m3 l3">
      <select class="browser-default validate" id="estado_civil" onselect="this.className = ''" name="estado_civil">
        <option value="">Estado Civil</option>
        <option value="soltero">Soltero(a)</option>
        <option value="casado">Casado(a)</option>
        <option value="divorciado">Divorciado(a)</option>
        <option value="viudo">Viudo(a)</option>
      </select>
    </div>
    <div class=" input-field col s3 m3 l3">
        <label for="nacionalidad">Nacionalidad</label>
        <input  id="nacionalidad" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
      </div>
  </div><!--datos identificacion-->
  <div class="row">
    <div class="">
      <div class="input-field col s4 m4 l4">
          <input id="telefono" type="tel" class="validate" placeholder="+56(9)" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
          <label for="telefono">Telefono</label>
        </div>
      <div class="input-field col s4 m4 l4">
          <input id="telefono2" type="tel" placeholder="*+56(9) Opcional " class="validate" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
          <label for="telefono2">Telefono de Recado</label>
        </div>
    </div>
  </div>
  <div class="row">
    <div class="input-field col s12">
          <input id="email" type="email" class="validate" onblur="validarEmail(this.value)">
          <label for="email">Email</label>
        </div>
  </div>
<div class="row">
  <?php
    // Obtenemos la información directa del servicio y la almacenamos localmente
    $regiones = json_decode(file_get_contents('regiones.json'), true);
  ?>
  <div class=" input-field col s4 m4 l4">Region
      <select class="browser-default validate" id="region" onselect="this.className = ''" name="region" onchange="cargarComunas();">
        <option>Seleccione región</option>
        <?php 
          // Recorremos el JSON buscando los valores asociados a las regiones existentes
          foreach($regiones['regiones'] as $region) {
            echo "<option value='" . $region['region'] . "'>" . $region['region'] . "</option>\n";
          }
        ?>
      </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
    
    </div>

    <script language="Javascript">
      function cargarComunas() {
        var comunas = {
          <?php
            // Creamos un arreglo asociativo dinámico que llene las comunas en función de la región seleccionada
            $i = 1;
            foreach($regiones['regiones'] as $region) {
              echo "region" . $i . " : [";
              natsort($region['comunas']);
              foreach($region['comunas'] as $comuna) {
                echo "\"" . $comuna . "\", ";
              }
              echo "\"\"],\n";
              $i++;
            }
          ?>
        };
        
        var campoRegion = document.getElementById('region');
        var campoComuna = document.getElementById('comuna');
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
      }
    </script>

    <div class=" input-field col s4 m4 l4">Comuna
      <select class="browser-default validate" id="comuna" onselect="this.className = ''" name="comuna">
      </select> <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
  </div>
</div>
<div class="row">
  <div class="input-field col s12 m12 l12">
    <input id="direccion" type="text" class="validate" onblur="aMayusculas(this.value,this.id)">
    <label for="direccion">Direccion</label>
  </div>
</div>
<div class="row"></div>

<div class="row">
  <div class="col s6 m6 l6">
    <a href="index.html" class="waves-effect waves-light btn">Cancelar</a>
  </div>
  <div class="col s6 m6 l6 pull-m6 right">
     <button type="submit" class="waves-effect waves-light btn right" id="buttonParent" href="proceso2.php" > Continuar </button>
   <!--  <a  type="submit" class="waves-effect waves-light btn-large right">Siguiente</a> -->
  </div>
</div>
</div><!--container-->
<div class="row">
  <div class="col s12 m12 l12">
    <img src="src/img/logo.jpg" alt="" class="endLogo">
  </div>
</div>
</form>

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
