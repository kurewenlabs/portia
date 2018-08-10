<?php
  session_start();
  if (array_key_exists("mode", $_GET)) {
    $_SESSION["mode"] = $_GET["mode"];
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
   <div class="col s5 push-s1">
     <h3>Postulaciones Abiertas</h3>
   </div>
   <div class="col s4 push-s4 logo">
     <img src="src/img/logo.jpg" alt="Portia">
   </div>
 </div>
<div class="divider titulo"></div>

  <form action="#" id="selectionForm" onsubmit="return false;">
<div class="row" id="seleccion">

  <div class="col s12 m3 l3"><!--retail-->
  <h5>Retail</h5>
  <p>Seleccione uno o varios</p> 
   <div id="retail">
    <p>
      <label for="r1">
        <input type="checkbox" value="reponedor supermercados" data-index="1" id="r1">
        <span>Reponedor supermercados</span>
      </label>
    </p>
    <p>
      <label for="r2">
        <input type="checkbox" value="reponedor grandes superficies"  data-index="2" id="r2">
        <span>Reponedor grandes superficies</span>
      </label>
    </p>
    <p>
      <label for="r3">
        <input type="checkbox" value="promotor grandes tiendas"  data-index="3" id="r3">
        <span>Promotor (a) grandes tiendas</span>
      </label>
    </p>
    <p>
      <label for="r4">
        <input type="checkbox" value="promotor supermercados"  data-index="4" id="r4">
        <span>Promotor (a) supermercados</span>
      </label>
    </p>
    <p>
      <label for="r5">
        <input type="checkbox" value="vendedor de intangibles"  data-index="5" id="r5">
        <span>vendedor de intangibles</span>
      </label>
    </p>
    <p>
      <label for="r6">
        <input type="checkbox" value="vendedor de tangibles"  data-index="6" id="r6">
        <span>vendedor de tangibles</span>
      </label>
    </p>
    <p>
      <label for="r7">
        <input type="checkbox" value="supervisor de promotores" data-index="7" id="r7">
        <span>Supervisor de promotores</span>
      </label>
    </p>
    <p>
      <label for="r8">
        <input type="checkbox" value="supervisor de mercaderistas" data-index="8" id="r8">
        <span>Supervisor de mercaderista</span>
      </label>
    </p>
    <p>
      <label for="r9">
        <input type="checkbox" value="merchandising" data-index="9" id="r9">
        <span>Merchandising</span>
      </label>
    </p>
    <p>
      <label for="r10">
        <input type="checkbox" value="trade marketing" data-index="10" id="r10">
        <span>Trade Marketing</span>
      </label>
    </p>
   </div>

  </div><!--retail-->



  <div class="col s12 m3 l3"> <!--administrativo-->
<h5>Administrativo</h5>
  <p>Seleccione uno o varios</p> 
    <div id="administrativo">
    <p>
      <label for="a1">
        <input type="checkbox" value="digitador" id="a1" data-index="11">
        <span>Digitador</span>
      </label>
    </p>
    <p>
      <label for="a2">
        <input type="checkbox" value="asistente de calidad" data-index="12" id="a2">
        <span>Asistente de calidad</span>
      </label>
    </p>
    <p>
      <label for="a3">
        <input type="checkbox" value="asistente contable"data-index="13"  id="a3">
        <span>Asistente contable</span>
      </label>
    </p>
    <p>
      <label for="a4">
        <input type="checkbox" value="ejecutiva de cuenta" data-index="14" id="a4">
        <span>Ejecutiva de cuenta</span>
      </label>
    </p>
    <p>
      <label for="a5">
        <input type="checkbox" value="analista de invetario" data-index="15" id="a5">
        <span>Analista de inventario</span>
      </label>
    </p>
    <p>
      <label for="a6">
        <input type="checkbox" value="gestor de ventas" data-index="16" id="a6">
        <span>Gestor de ventas</span>
      </label>
    </p>
    <p>
      <label for="a7">
        <input type="checkbox" value="ejecutivo de call center" data-index="17" id="a7">
        <span>Ejecutivo de call center</span>
      </label>
    </p>
    <p>
      <label for="a8">
        <input type="checkbox" value="informatico" data-index="18" id="a8">
        <span>Informático</span>
      </label>
    </p>
    <p>
      <label for="a9">
        <input type="checkbox" value="alumno en practica" data-index="19" id="a9">
        <span>Alumno en practica</span>
      </label>
    </p>
    <p>
      <label for="a10">
        <input type="checkbox" value="secretaria" data-index="20" id="a10">
        <span>Secretaria</span>
      </label>
    </p>
    <p>
      <label for="a11">
        <input type="checkbox" value="junior" data-index="21" id="a11">
        <span>Junior</span>
      </label>
    </p>
    <p>
      <label for="a12">
        <input type="checkbox" value="capacitador" data-index="22" id="a12">
        <span>Capacitador</span>
      </label>
    </p>
    <p>
      <label for="a13">
        <input type="checkbox" value="captador" data-index="23" id="a13">
        <span>Captador</span>
      </label>
    </p>
    <p>
      <label for="a14">
        <input type="checkbox" value="administrativo de archivo" data-index="24" id="a14">
        <span>Administrativo de Archivo</span>
      </label>
    </p>
    <p>
      <label for="a15">
        <input type="checkbox" value="ejecutiva de beneficios" data-index="25" id="a15">
        <span>Ejecutiva de beneficios</span>
      </label>
    </p>
    <p>
      <label for="a16">
        <input type="checkbox" value="administrativo de despacho" data-index="26" id="a16">
        <span>Administrativo de despacho</span>
      </label>
    </p>
   </div>
  </div><!--administrativo-->
  <div class="col s12 m3 l3"><!--industrial-->
    <h5>Industrial</h5>
  <p>Seleccione uno o varios</p> 
   <div id="industrial">
    <p>
      <label for="i1">
        <input type="checkbox" value="conductor grua horquilla" data-index="27" id="i1">
        <span>Conductor grua horquilla</span>
      </label>
    </p>
    <p>
      <label for="i2">
        <input type="checkbox" value="operario produccion" data-index="28" id="i2">
        <span>Operario producción</span>
      </label>
    </p>
    <p>
      <label for="i3">
        <input type="checkbox" value="operario de bodega" data-index="29" id="i3">
        <span>Operario de bodega</span>
      </label>
    </p>
    <p>
      <label for="i4">
        <input type="checkbox" value="manipuladoras de alimentos" data-index="30" id="i4">
        <span>Manipuladoras de alimentos</span>
      </label>
    </p>
    <p>
      <label for="i5">
        <input type="checkbox" value="maestro panadero" data-index="31" id="i5">
        <span>Maestro Panadero</span>
      </label>
    </p>
    <p>
      <label for="i6">
        <input type="checkbox" value="maestro de cocina" data-index="32" id="i6">
        <span>Maestro de cocina</span>
      </label>
    </p>
     <p>
      <label for="i7">
        <input type="checkbox" value="Ayudante de cocina" data-index="33" id="i7">
        <span>Ayudante de cocina</span>
      </label>
    </p>
     <p>
      <label for="i8">
        <input type="checkbox" value="ayudante de panadero" data-index="34" id="i8">
        <span>Ayudante de panadero</span>
      </label>
    </p>
    <p>
      <label for="i9">
        <input type="checkbox" value="Runner" id="i9" data-index="35">
        <span>Runner</span>
      </label>
    </p>
    <p>
      <label for="i10">
        <input type="checkbox" value="Peoneta" id="i10" data-index="36">
        <span>Peoneta</span>
      </label>
    </p>
    <p>
      <label for="i11">
        <input type="checkbox" value="colorista" id="i11" data-index="37">
        <span>Colorista</span>
      </label>
    </p>
    <p>
      <label for="i12">
        <input type="checkbox" value="carnicero" id="i12" data-index="38">
        <span>Carnicero</span>
      </label>
    </p>
    <p>
      <label for="i13">
        <input type="checkbox" value="envasador" id="i13" data-index="39">
        <span>Envasador</span>
      </label>
    </p>
    <p>
      <label for="i14">
        <input type="checkbox" value="empaquetador" id="i14" data-index="40">
        <span>Empaquetador</span>
      </label>
    </p>
    <p>
      <label for="i15">
        <input type="checkbox" value="mecanico" id="i15" data-index="41">
        <span>Mecánico</span>
      </label>
    </p>
    <p>
      <label for="i16">
        <input type="checkbox" value="encargado de area" id="i16" data-index="42">
        <span>Encargado de area</span>
      </label>
    </p>
    <p>
      <label for="i17">
        <input type="checkbox" value="supervisor de producción" id="i17" data-index="43">
        <span>Supervisor de producción</span>
      </label>
    </p>
   </div>
  
  </div><!--industrial-->
  <div class="col s12 m3 l3"><!--otros-->
      <h5>Otros</h5>
  <p>Seleccione uno o varios</p> 
   <div id="otros">
 
    <p>
      <label for="o1">
        <input type="checkbox" value="conductor licencia A3" id="o1" data-index="44">
        <span>Conductor licencia A3</span>
      </label>
    </p>
    <p>
      <label for="o2">
        <input type="checkbox" value="conductor licencia B" id="o2" data-index="45">
        <span>Conductor licencia B</span>
      </label>
    </p>
    <p>
      <label for="o3">
        <input type="checkbox" value="guardia" id="o3" data-index="46">
        <span>Guardia</span>
      </label>
    </p>
    <p>
      <label for="04">
        <input type="checkbox" value="Auxiliar de aseo" id="04" data-index="47">
        <span>Auxiliar de aseo</span>
      </label>
    </p>
    <p>
      <label for="o5">
        <input type="checkbox" value="Asesora del hogar" id="o5" data-index="48">
        <span>Asesora del hogar</span>
      </label>
    </p>
    <p>
      <label for="06">
        <input type="checkbox" value="Manicuristas" id="06" data-index="49">
        <span>Manicuristas</span>
      </label>
    </p>
    <p>
      <label for="07">
        <input type="checkbox" value="Cajero" id="07" data-index="50">
        <span>Cajero</span>
      </label>
    </p>
    </div>
  </div><!--otros-->

</div><!--row checkboxes-->
<div class="row">
  <div class="col s2 push-s10">
      <button type="submit" class="waves-effect waves-light btn" id="buttonParent" href="proceso.php" > Continuar </button>
   <!--  <a  type="submit" class="waves-effect waves-light btn" id="buttonParent">Continuar</a> -->
  </div>
</div>

 </form>

  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
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
