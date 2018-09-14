<?php
    session_start();
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
<div class="container">
  <div class="row">
    <img src="src/img/Logo-H80.jpg" alt="" style="margin-top: 20px; margin-left: 350px; ">
    <h2 style="text-align: center;">Tu Postulación ha sido enviada con Éxito!</h2>

    <div class="col s12  m12  l12 center">
      <a href="index.php" >Volver a cargos</a>
    </div>
  </div>

  
<div class="row">
  <h5>¿A través de que medio se enteró de la postulación?</h5>
  <div class="col s6 m6 l6">
   <form id="gracias" action="#">
    <p>
      <label>
        <input id="facebook" name="medio" type="radio" value="Facebook" class="with-gap" />
        <span>Facebook</span>
      </label>
    </p>
    <p>
      <label>
        <input id="laborum" name="medio" type="radio" value="Laborum" class="with-gap"/>
        <span>Laborum</span>
      </label>
    </p>
    <p>
      <label>
        <input class="with-gap" id="linkedin" name="medio" value="Linkedin" type="radio"  />
        <span>Linkedin</span>
      </label>
    </p>
    <p>
      <label>
        <input type="radio" id="computrabajo" name="medio" value="Computrabajo" class="with-gap" />
        <span>Computrabajo</span>
      </label>
    </p>
    <p>
      <label>
        <input type="radio" id="recomendacion" name="medio" value="Recomendacion" class="with-gap" />
        <span>Recomendacion</span>
      </label>
    </p>
    <p>
      <label>
        <input id="otro" name="medio" value="Otro" type="radio" class="with-gap" />
        <span>Otros</span>
      </label>
    </p>
  </form>        
  </div>


  </div>
  <button onclick="$('form#gracias').submit();" class="waves-effect waves-light btn right">Enviar</button>
  </div>

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
