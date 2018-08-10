<?php
session_start();
$dataPostulacion = $_SESSION["postdata"]["pos"]["pa"];
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
            <li class="active"></li>
            <li class="active"></li>
            <li class="active"></li>
            <li class="active"></li>
          </ul>
          <div class="col s12 m12 l12 push-m2">
            <div class="progress">
              <div class="determinate" style="width: 100%"></div>
          </div>

          </div>
        </div>
        <div class="row">
          <h4>Datos de Uniforme</h4>
        </div>

  <form id="proceso6form" onsubmit="return false;">         
        <div class="row">
          <div class="tab">
            <div class="tab input-field col s4 m4 l4">Talla Polera/camisa
              <select class="browser-default" onselect="this.className = ' ' " name="uniforme" id="uniforme">
                <option value=""></option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
              </select>
            </div>
            <div class="tab input-field col s4 m4 l4">Talla Poleron/Chaqueta
              <select class="browser-default" onselect="this.className = ' ' " name="uniforme2" id="uniforme2">
                <option value=""></option>
                <option value="XS">XS</option>
                <option value="S">S</option>
                <option value="M">M</option>
                <option value="L">L</option>
                <option value="XL">XL</option>
                <option value="XXL">XXL</option>
              </select>
            </div>
            <div class="tab input-field col s4 m4 l4">Talla de zapatos
                <label for="tallaZapato"></label>
                <input  id="tallaZapato" type="text" class="validate">
              </div>
              <div class="row">
                <div class="tab input-field col s8 m8 l8">Talla de Pantalon (ingrese detalles si necesita)
                <label for="tallaPantalon"></label>
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
              <select class="browser-default" onselect="this.className = ' ' " name="renta" id="renta">
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

        <div class="row"></div>
        <div class="row"></div>
        <div class="row">
       
          <div class="col s6 m6 l6 pull-m6 right">
            <button type="submit" class="waves-effect waves-light btn right" >Siguiente</button>
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
