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

<div class="row">
  <div class="col s5 push-s1">
    <h4>Home</h4>
    <p>/Home</p>
  </div>
  <div class="col s4 push-s4 logo">
    <img src="src/img/logo.jpg" alt="">
  </div>
</div>
<div class="divider titulo"></div>

<div class="container">
  
  <div class="row filaDatos">
 <div class="col s2 m2 l2 input-field empresa">
  <select class="browser-default"  id="empresa" onselect="this.className = ''" name="empresa">
         <option value="">Empresa</option>
          <option value="Portia">Portia</option>
          <option value="Agla">Agla</option>
      </select> 
 </div>
 <div class="col s2 m2 l2 input-field">
  <select class="browser-default"  id="categoria" onselect="this.className = ''" name="Categoria">
        <option value="">Categoria</option>
              <option value="Sin Clasificar">Sin Clasificar</option>
              <option value="Apto">Apto</option>
              <option value="Fuera Rango Renta">Fuera Rango Renta</option>
              <option value="No Apto">No Apto</option>
      </select> 
 </div>
 <div class="col s2 m2 l2 input-field">
  <select class="browser-default"  id="cargo" onselect="this.className = ''" name="cargo">
        <option value="">cargo</option>
        <option value=""></option>
        <option value=""></option>
      </select> 
 </div>
 <div class="col s2 m2 l2 push-m1 input-field fecha">
     <label for="txtDate5">Desde</label>
        <input type="text" class="datepicker" id="txtDate5">
  </div>
<div class="col s2 m2 l2 input-field">
     <label for="txtDate5">Hasta</label>
        <input type="text" class="datepicker" id="txtDate5">
  </div>
<div class="col s2 m2 l2">
    <a href="" class="waves-effect waves-light btn-small consulta">Consultar</a>
  </div>

</div>
<div class="row">
  <div class="col s12 empresa">
    <h4>Detalles de Postulaciones</h4>
  </div>
</div>
  <div class="row">
    <nav class="buscar">
    <div class="nav-wrapper ">
      <form>
        <div class="input-field">
          <input id="search" class="" type="search" required>
          <label class="label-icon" for="search"><i class="material-icons">search</i></label>
          <i class="material-icons" style="color:#000;">close</i>
        </div>
      </form>
    </div>
    <a class="waves-effect btn-flat exportar"><i class="tiny material-icons">data_usage</i>Exportar XLS</a>
  </nav>

     

  </div>

<div class="row">
    <div class="col s12 lineaDatos1">
      <ul class="tabs">
        <li class="tab col s2"><a href="#test6"><span class="badge yellow">4</span>Sin Clasificar</a></li>
        <li class="tab col s2"><a href="#test2"><span class="badge green">4</span>Seleccionadas Aptas</a></li>
        <li class="tab col s2"><a href="#test3"><span class="badge orange">4</span>Fuera Rango Renta</a></li>
        <li class="tab col s2"><a href="#test4"><span class="badge grey">4</span>No Aptos</a></li>
        <li class="tab col s2"><a href="#test5"><span class="badge red">4</span>Eliminados</a></li>
        <li class="tab col s2"><a href="#test1"><span class="badge teal">4</span>Postulaciones</a></li>
      </ul>
    </div>

</div>
    <div id="test1" class="col s12 empresa lineaDatos1">  
         <table class="centered highlight">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Empresa</th>
              <th>Postulante</th>
              <th>Nacionalidad</th>
              <th>Cargo</th>
              <th>Rango Renta</th>
              <th>Estado</th>
              <th>Adjuntos</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>02/07/2018</td>
            <td>Portia</td>
            <td><i class="small material-icons">person</i> John Doe</td>
            <td>Chileno</td>
            <td>Peoneta</td>
            <td>$350.000 - 400.000</td>
            <td><span class="badge green">OK</span></td>
            <td><i class="small material-icons">attach_file</i></td>
            <td><a class="waves-effect btn-flat botonVista" href="adminedit.php">ver</a>
            </td>

            <td><!-- Modal editar -->
  <a class="waves-effect waves-light btn-flat modal-trigger botonVista" href="#modal2">Editar</a>

  <!-- Modal Structure -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <h4>Editar Postulación</h4>
      <p>FECHA</p>                <!--  Imprimir la fecha del dia -->
    <div class="row">
      <p class="left-align">Postulación</p>
      <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
          <h6>Pedro Carrasco</h6> <!-- imprimir datos del postulante-->
          <p>16.111.222-3</p>
        </div>
        <div class="col s6 m6 l6 left-align">
          <h6 class="sueldo">$350.000 - 500.000</h6> <!-- imprimir renta del postulante-->
          <a class="waves-effect btn-flat botonVista2" href="adminedit.php">ver detalle</a>
        </div>
        </div>
    </div>

        <div class="row">
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="col s2 m2 l2">
            <a href="index.html" class="">Editar cargos</a>
          </div>
        </div>
     <div class="row">
    <form class="col s6 m6 l6">
      <div class="row">
        <label>Curriculum</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="curriculum">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
      <div class="row">
        <label>Certificado de antecedentes</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="antecedentes">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
    </form>
  </div> 
  <div class="row">
  <div class="col s4 m4 l4 left-align">
    <p>Clasificar</p>
    <div class="row">
      <div class="clasificar">
         <form action="#">
          <p>
          <label for="sinClasificar2">
            <input id="sinClasificar2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
          </label>
          </p>
          <p>
          <label for="apto2">
            <input id="apto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge green sinClasificar">Apto</span></span>
          </label>
          </p>
          <p>
          <label for="fueraRango2">
            <input id="fueraRango2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
          </label>
          </p>
           <p>
          <label for="noApto2">
            <input id="noApto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge grey sinClasificar"> No Apto</span></span>
          </label>
          </p>
    
         </form>
        </div>
      </div>
    </div>
    <div class="col s4 m4 l4">
      <p class="left-align">Observación</p>
      <form>
        <div class="input-field">
          <textarea id="textarea1" class="browser-default"></textarea>
            <label for="textarea1"></label>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn-flat borrar2">Eliminar</a>
    </div>
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn modal-close save2" type="submit">Guardar</a>
    </div>  
    </div>
    
   </div>   
  </div>
</div></td>
          </tr>
        </tbody>
      </table>
    </div>


    <div id="test2" class="col s12 empresa lineaDatos1">
    
         <table class="centered highlight">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Empresa</th>
              <th>Postulante</th>
              <th>Nacionalidad</th>
              <th>Cargo</th>
              <th>Rango Renta</th>
              <th>Estado</th>
              <th>Adjuntos</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>02/07/2018</td>
            <td>Portia</td>
            <td><i class="small material-icons">person</i> John Doe</td>
            <td>Chileno</td>
            <td>Peoneta</td>
            <td>$350.000 - 400.000</td>
            <td><span class="badge green">OK</span></td>
            <td><i class="small material-icons">attach_file</i></td>
            <td><a class="waves-effect btn-flat botonVista" href="adminedit.php">ver</a>
            </td>

            <td><!-- Modal editar -->
  <a class="waves-effect waves-light btn-flat modal-trigger botonVista" href="#modal2">Editar</a>

  <!-- Modal Structure -->
  <div id="modal2" class="modal">
    <div class="modal-content">
      <h4>Editar Postulación</h4>
      <p>FECHA</p>                <!--  Imprimir la fecha del dia -->
    <div class="row">
      <p class="left-align">Postulación</p>
      <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
          <h6>Pedro Carrasco</h6> <!-- imprimir datos del postulante-->
          <p>16.111.222-3</p>
        </div>
        <div class="col s6 m6 l6 left-align">
          <h6 class="sueldo">$350.000 - 500.000</h6> <!-- imprimir renta del postulante-->
          <a class="waves-effect btn-flat botonVista2" href="adminedit.php">ver detalle</a>
        </div>
        </div>
    </div>

        <div class="row">
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="col s2 m2 l2">
            <a href="index.html" class="">Editar cargos</a>
          </div>
        </div>
     <div class="row">
    <form class="col s8 m8 l8">
      <div class="row">
        <label>Curriculum</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="curriculum">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
      <div class="row">
        <label>Certificado de antecedentes</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="antecedentes">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
    </form>
  </div> 
  <div class="row">
  <div class="col s4 m4 l4 left-align">
    <p>Clasificar</p>
    <div class="row">
      <div class="clasificar">
         <form action="#">
          <p>
          <label for="sinClasificar2">
            <input id="sinClasificar2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
          </label>
          </p>
          <p>
          <label for="apto2">
            <input id="apto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge green sinClasificar">Apto</span></span>
          </label>
          </p>
          <p>
          <label for="fueraRango2">
            <input id="fueraRango2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
          </label>
          </p>
           <p>
          <label for="noApto2">
            <input id="noApto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge grey sinClasificar"> No Apto</span></span>
          </label>
          </p>
    
         </form>
        </div>
      </div>
    </div>
    <div class="col s4 m4 l4">
      <p class="left-align">Observación</p>
      <form>
        <div class="input-field">
          <textarea id="textarea1" class="browser-default"></textarea>
            <label for="textarea1"></label>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn-flat borrar2">Eliminar</a>
    </div>
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn modal-close save2" type="submit">Guardar</a>
    </div>  
    </div>
    
   </div>   
  </div>
</div></td>
          </tr>
        </tbody>
      </table>
    </div>
    
    <div id="test3" class="col s12 empresa lineaDatos1">
           <table class="centered highlight">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Empresa</th>
              <th>Postulante</th>
              <th>Nacionalidad</th>
              <th>Cargo</th>
              <th>Rango Renta</th>
              <th>Estado</th>
              <th>Adjuntos</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>02/07/2018</td>
            <td>Portia</td>
            <td><i class="small material-icons">person</i> John Doe</td>
            <td>Chileno</td>
            <td>Peoneta</td>
            <td>$350.000 - 400.000</td>
            <td><span class="badge green">OK</span></td>
            <td><i class="small material-icons">attach_file</i></td>
            <td><a class="waves-effect btn-flat botonVista" href="adminedit.php">ver</a>
            </td>

            <td><!-- Modal editar -->
  <a class="waves-effect waves-light btn-flat modal-trigger botonVista" href="#modal4">Editar</a>

  <!-- Modal Structure -->
  <div id="modal4" class="modal">
    <div class="modal-content">
      <h4>Editar Postulación</h4>
      <p>FECHA</p>                <!--  Imprimir la fecha del dia -->
    <div class="row">
      <p class="left-align">Postulación</p>
      <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
          <h6>Pedro Carrasco</h6> <!-- imprimir datos del postulante-->
          <p>16.111.222-3</p>
        </div>
        <div class="col s6 m6 l6 left-align">
          <h6 class="sueldo">$350.000 - 500.000</h6> <!-- imprimir renta del postulante-->
          <a class="waves-effect btn-flat botonVista2" href="adminedit.php">ver detalle</a>
        </div>
        </div>
    </div>

        <div class="row">
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="col s2 m2 l2">
            <a href="index.html" class="">Editar cargos</a>
          </div>
        </div>
     <div class="row">
    <form class="col s8 m8 l8">
      <div class="row">
        <label>Curriculum</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="curriculum">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
      <div class="row">
        <label>Certificado de antecedentes</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="antecedentes">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
    </form>
  </div> 
  <div class="row">
  <div class="col s4 m4 l4 left-align">
    <p>Clasificar</p>
    <div class="row">
      <div class="clasificar">
         <form action="#">
          <p>
          <label for="sinClasificar2">
            <input id="sinClasificar2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
          </label>
          </p>
          <p>
          <label for="apto2">
            <input id="apto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge green sinClasificar">Apto</span></span>
          </label>
          </p>
          <p>
          <label for="fueraRango2">
            <input id="fueraRango2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
          </label>
          </p>
           <p>
          <label for="noApto2">
            <input id="noApto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge grey sinClasificar"> No Apto</span></span>
          </label>
          </p>
    
         </form>
        </div>
      </div>
    </div>
    <div class="col s4 m4 l4">
      <p class="left-align">Observación</p>
      <form>
        <div class="input-field">
          <textarea id="textarea1" class="browser-default"></textarea>
            <label for="textarea1"></label>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn-flat borrar2">Eliminar</a>
    </div>
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn modal-close save2" type="submit">Guardar</a>
    </div>  
    </div>
    
   </div>   
  </div>
</div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="test4" class="col s12 empresa lineaDatos1">
         <table class="centered highlight">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Empresa</th>
              <th>Postulante</th>
              <th>Nacionalidad</th>
              <th>Cargo</th>
              <th>Rango Renta</th>
              <th>Estado</th>
              <th>Adjuntos</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>02/07/2018</td>
            <td>Portia</td>
            <td><i class="small material-icons">person</i> John Doe</td>
            <td>Chileno</td>
            <td>Peoneta</td>
            <td>$350.000 - 400.000</td>
            <td><span class="badge green">OK</span></td>
            <td><i class="small material-icons">attach_file</i></td>
            <td><a class="waves-effect btn-flat botonVista" href="adminedit.php">ver</a>
            </td>

            <td><!-- Modal editar -->
  <a class="waves-effect waves-light btn-flat modal-trigger botonVista" href="#modal4">Editar</a>

  <!-- Modal Structure -->
  <div id="modal4" class="modal">
    <div class="modal-content">
      <h4>Editar Postulación</h4>
      <p>FECHA</p>                <!--  Imprimir la fecha del dia -->
    <div class="row">
      <p class="left-align">Postulación</p>
      <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
          <h6>Pedro Carrasco</h6> <!-- imprimir datos del postulante-->
          <p>16.111.222-3</p>
        </div>
        <div class="col s6 m6 l6 left-align">
          <h6 class="sueldo">$350.000 - 500.000</h6> <!-- imprimir renta del postulante-->
          <a class="waves-effect btn-flat botonVista2" href="adminedit.php">ver detalle</a>
        </div>
        </div>
    </div>

        <div class="row">
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="col s2 m2 l2">
            <a href="index.html" class="">Editar cargos</a>
          </div>
        </div>
     <div class="row">
    <form class="col s8 m8 l8">
      <div class="row">
        <label>Curriculum</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="curriculum">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
      <div class="row">
        <label>Certificado de antecedentes</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="antecedentes">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
    </form>
  </div> 
  <div class="row">
  <div class="col s4 m4 l4 left-align">
    <p>Clasificar</p>
    <div class="row">
      <div class="clasificar">
         <form action="#">
          <p>
          <label for="sinClasificar2">
            <input id="sinClasificar2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
          </label>
          </p>
          <p>
          <label for="apto2">
            <input id="apto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge green sinClasificar">Apto</span></span>
          </label>
          </p>
          <p>
          <label for="fueraRango2">
            <input id="fueraRango2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
          </label>
          </p>
           <p>
          <label for="noApto2">
            <input id="noApto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge grey sinClasificar"> No Apto</span></span>
          </label>
          </p>
    
         </form>
        </div>
      </div>
    </div>
    <div class="col s4 m4 l4">
      <p class="left-align">Observación</p>
      <form>
        <div class="input-field">
          <textarea id="textarea1" class="browser-default"></textarea>
            <label for="textarea1"></label>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn-flat borrar2">Eliminar</a>
    </div>
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn modal-close save2" type="submit">Guardar</a>
    </div>  
    </div>
    
   </div>   
  </div>
</div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="test5" class="col s12 empresa lineaDatos1">
         <table class="centered highlight">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Empresa</th>
              <th>Postulante</th>
              <th>Nacionalidad</th>
              <th>Cargo</th>
              <th>Rango Renta</th>
              <th>Estado</th>
              <th>Adjuntos</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>02/07/2018</td>
            <td>Portia</td>
            <td><i class="small material-icons">person</i> John Doe</td>
            <td>Chileno</td>
            <td>Peoneta</td>
            <td>$350.000 - 400.000</td>
            <td><span class="badge green">OK</span></td>
            <td><i class="small material-icons">attach_file</i></td>
           <td><a class="waves-effect btn-flat botonVista" href="adminedit.php">ver</a>
            </td>

            <td><!-- Modal editar -->
  <a class="waves-effect waves-light btn-flat modal-trigger botonVista" href="#modal5">Editar</a>

  <!-- Modal Structure -->
  <div id="modal5" class="modal">
    <div class="modal-content">
      <h4>Editar Postulación</h4>
      <p>FECHA</p>                <!--  Imprimir la fecha del dia -->
    <div class="row">
      <p class="left-align">Postulación</p>
      <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
          <h6>Pedro Carrasco</h6> <!-- imprimir datos del postulante-->
          <p>16.111.222-3</p>
        </div>
        <div class="col s6 m6 l6 left-align">
          <h6 class="sueldo">$350.000 - 500.000</h6> <!-- imprimir renta del postulante-->
          <a class="waves-effect btn-flat botonVista2" href="adminedit.php">ver detalle</a>
        </div>
        </div>
    </div>

        <div class="row">
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="col s2 m2 l2">
            <a href="index.html" class="">Editar cargos</a>
          </div>
        </div>
     <div class="row">
    <form class="col s8 m8 l8">
      <div class="row">
        <label>Curriculum</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="curriculum">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
      <div class="row">
        <label>Certificado de antecedentes</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="antecedentes">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
    </form>
  </div> 
  <div class="row">
  <div class="col s4 m4 l4 left-align">
    <p>Clasificar</p>
    <div class="row">
      <div class="clasificar">
         <form action="#">
          <p>
          <label for="sinClasificar2">
            <input id="sinClasificar2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
          </label>
          </p>
          <p>
          <label for="apto2">
            <input id="apto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge green sinClasificar">Apto</span></span>
          </label>
          </p>
          <p>
          <label for="fueraRango2">
            <input id="fueraRango2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
          </label>
          </p>
           <p>
          <label for="noApto2">
            <input id="noApto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge grey sinClasificar"> No Apto</span></span>
          </label>
          </p>
    
         </form>
        </div>
      </div>
    </div>
    <div class="col s4 m4 l4">
      <p class="left-align">Observación</p>
      <form>
        <div class="input-field">
          <textarea id="textarea1" class="browser-default"></textarea>
            <label for="textarea1"></label>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn-flat borrar2">Eliminar</a>
    </div>
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn modal-close save2" type="submit">Guardar</a>
    </div>  
    </div>
    
   </div>   
  </div>
</div></td>
          </tr>
        </tbody>
      </table>
    </div>
    <div id="test6" class="col s12 empresa lineaDatos1">
         <table class="centered highlight">
        <thead>
          <tr>
              <th>Fecha</th>
              <th>Empresa</th>
              <th>Postulante</th>
              <th>Nacionalidad</th>
              <th>Cargo</th>
              <th>Rango Renta</th>
              <th>Estado</th>
              <th>Adjuntos</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>02/07/2018</td>
            <td>Portia</td>
            <td><i class="small material-icons">person</i> John Doe</td>
            <td>Chileno</td>
            <td>Peoneta</td>
            <td>$350.000 - 400.000</td>
            <td><span class="badge green">OK</span></td>
            <td><i class="small material-icons">attach_file</i></td>
            <td><a class="waves-effect btn-flat botonVista" href="adminedit.php">ver</a>
            </td>

            <td><!-- Modal editar -->
  <a class="waves-effect waves-light btn-flat modal-trigger botonVista" href="#modal6">Editar</a>

  <!-- Modal Structure -->
  <div id="modal6" class="modal">
    <div class="modal-content">
      <h4>Editar Postulación</h4>
      <p>FECHA</p>                <!--  Imprimir la fecha del dia -->
    <div class="row">
      <p class="left-align">Postulación</p>
      <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
          <h6>Pedro Carrasco</h6> <!-- imprimir datos del postulante-->
          <p>16.111.222-3</p>
        </div>
        <div class="col s6 m6 l6 left-align">
          <h6 class="sueldo">$350.000 - 500.000</h6> <!-- imprimir renta del postulante-->
          <a class="waves-effect btn-flat botonVista2" href="adminedit.php">ver detalle</a>
        </div>
        </div>
    </div>

        <div class="row">
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="chip col s1 offset-s1" id="chip">
            <i class="close material-icons">close</i>
          </div>
          <div class="col s2 m2 l2">
            <a href="index.html" class="">Editar cargos</a>
          </div>
        </div>
     <div class="row">
    <form class="col s8 m8 l8">
      <div class="row">
        <label>Curriculum</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="curriculum">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
      <div class="row">
        <label>Certificado de antecedentes</label>
        <div class="file-field input-field">
          <div class="btn">
            <span>Descargar</span>
            <input type="file" name="antecedentes">
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text"></input>
          </div>
        </div>
      </div>
    </form>
  </div> 
  <div class="row">
  <div class="col s4 m4 l4 left-align">
    <p>Clasificar</p>
    <div class="row">
      <div class="clasificar">
         <form action="#">
          <p>
          <label for="sinClasificar2">
            <input id="sinClasificar2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
          </label>
          </p>
          <p>
          <label for="apto2">
            <input id="apto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge green sinClasificar">Apto</span></span>
          </label>
          </p>
          <p>
          <label for="fueraRango2">
            <input id="fueraRango2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
          </label>
          </p>
           <p>
          <label for="noApto2">
            <input id="noApto2"  class="with-gap" name="group1" type="radio"/>
            <span><span class="badge grey sinClasificar"> No Apto</span></span>
          </label>
          </p>
    
         </form>
        </div>
      </div>
    </div>
    <div class="col s4 m4 l4">
      <p class="left-align">Observación</p>
      <form>
        <div class="input-field">
          <textarea id="textarea1" class="browser-default"></textarea>
            <label for="textarea1"></label>
        </div>
      </form>
    </div>
    <div class="row">
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn-flat borrar2">Eliminar</a>
    </div>
    <div class="col s3 m3 l3">
       <a href="#!" class=" waves-effect waves-green btn modal-close save2" type="submit">Guardar</a>
    </div>  
    </div>
    
   </div>   
  </div>
</div></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

</div><!--container-->





<!-- <div class="row">
  <div class="col s12 m12 l12">
    <img src="src/img/logo.jpg" alt="" class="endLogo">
  </div>
</div>-->


  <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type = "text/javascript"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
  <script src="src/js/postulaciones.js"></script>
</body>
</html>