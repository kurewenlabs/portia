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
    <h6>Administracion Sistema de Postulación Portia</h6>
 </nav>
<!--container-->
<div class="container"> 
 <div class="row">
   <h4 style="text-align: center;">Inicie Sesión</h4>
 </div>
 <div class="row">
  <div class="container">
        <div class="z-depth-1 grey lighten-4 row login">

          <form id="login" class="col s12 m12 l12" method="post" onSubmit="return false;">
            <div class='row'>
              <div class='col s12'>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='email' name='email' id='email'/>
                <label for='email'>Usuario</label>
              </div>
            </div>

            <div class='row'>
              <div class='input-field col s12'>
                <input class='validate' type='password' name='password' id='password'/>
                <label for='password'>Contraseña</label>
              </div>
              
            </div>

            <br />
            <center>
              <div class='row'>
                <button type="submit" class="waves-effect waves-light btn-large center" href="">Login</button>
              </div>
            </center>
          </form>
        </div>
      </div>



    <div class="section"></div>
    <div class="section"></div>
 </div>
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

<?php if (isset($_GET["status"])) {
  ?>
  <script language="Javascript">
    notie.alert({ type: 3, text: 'Nombre de usuario o contraseña inválidos', position: 'bottom' });
    $('#email').css('border-color' , 'red');
  </script>
  <?php
}
?>
</body>
</html>