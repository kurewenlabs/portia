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
  <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
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
        echo "<div class=\"chip col\">" . $cargo['nom'] .  "<i class=\"close material-icons\">close</i></div>";
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
          <li></li>
        </ul>
        <div class="col s12 m12 l12 push-m2">
          <div class="progress">
            <div class="determinate" style="width: 80%"></div>
        </div>

        </div>
      </div>
      <div class="row">
        <h4>Datos Previsonales</h4>
      </div>

  <form id="proceso5form" onsubmit="return false;">    
      <div class="row"> 
        <div class=" input-field col s6 m6 l6">
              <select class="browser-default" onselect="this.className = ''" name="afp" id="afp">
                <option value="">AFP</option>
                <option value="AFP Capital">AFP Capital</option>
                <option value="AFP Cuprum">AFP Cuprum</option>
                <option value="AFP Habitat">AFP Habitat</option>
                <option value="AFP Modelo">AFP Modelo</option>
                <option value="AFP Planvital">AFP Planvital</option>
                <option value="AFP Provida">AFP Provida</option>
              </select>
            </div>
            <div class=" input-field col s6 m6 l6">
              <select class="browser-default" onselect="this.className = ''" name="isapre" id="isapre">
                <option value="">Isapre o Fonasa</option>
                <option value="Banmedica">Banmédica</option>
                <option value="Chuquicamata">Chuquicamata</option>
                <option value="Consalud">Consalud</option>
                <option value="Colmena">Colmena</option> 
                <option value="Cruz Blanca">Cruz Blanca</option>
                <option value="Cruz del Norte">Cruz del Norte</option>
                <option value="Fonasa">Fonasa</option>
                <option value="Fundacion">Fundación</option>
                <option value="Fusat">Fusat</option>
                <option value="Nueva Masvida">Nueva Masvida</option>
                <option value="Rio Blanco">Río Blanco</option>
                <option value="San Lorenzo">San Lorenzo</option>
                <option value="Vida Tres">Vida Tres</option>
              </select>
            </div>
      </div>
      <div class="row">
        <h4>Comunas disponibles para Trabajar</h4>
        <div class="divider"></div>
      </div>
        <?php
            // Obtenemos la información directa del servicio y la almacenamos localmente
            $regiones = json_decode(file_get_contents('regiones.json'), true);
        ?>
        <div class="row">
        <div class="input-field col s4 m4 l4">Region
                <select class="" id="regionwork" onselect="this.className = ''" name="regionwork" onchange="cargarComunas();">
                <option>Seleccione región</option>
                <?php 
                // Recorremos el JSON buscando los valores asociados a las regiones existentes
                foreach($regiones['regiones'] as $region) {
                    echo "<option value='" . $region['region'] . "'>" . $region['region'] . "</option>\n";
                }
                ?>
                </select>
        </div>
        <script language="Javascript">
            function cargarComunas() {
                // var comunas = [
                var comunas = {
                <?php
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
                    /* $i = 1;
                    foreach($regiones['regiones'] as $region) {
                        echo "                {\n";
                        echo "                    region" . $i . " : [\n";
                        natsort($region['comunas']);
                        $j = 1;
                        foreach($region['comunas'] as $comuna) {
                            echo "                        {\n";
                            echo "                            id: '" . $comuna . "',\n";
                            echo "                            text: '" . $comuna . "'\n";
                            echo "                        }" . ($j<sizeof($region['comunas'])?",":"") . "\n";
                            $j++;
                        }
                        echo "                    ]\n";
                        echo "                }" . ($i<sizeof($regiones['regiones'])?",":"") . "\n";
                        $i++;
                    } */
                ?>
                };
                // ];
                
                /* var campoRegion = document.getElementById('region');
                regionSeleccionada = campoRegion.selectedIndex;
                var data = comunas["region" + regionSeleccionada];

                $("#comuna").select2({
                    data: data,
                    closeOnSelect: false
                }); */                      
                var campoRegion = document.getElementById('regionwork');
                var campoComuna = document.getElementById('comunaswork');
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
            <div class="input-field col s4 m4 l4">Comuna
                <select class=".js-example-data-array browser-default" id="comunaswork" name="comunaswork" onselect="this.className = ''">
                </select>
            </div> 
        </div>
      <script language="Javascript">
        function changeStatus(select) {
          if (select.selectedIndex == 0) {
            for(var i=1; i<select.length; i++) {
              select.options[i].selected = false;
            }
          }
        }
      </script>
      <div class="divider"></div>
      <div id="containerInputHoras">
        <h4>Seleccione Horario</h4>
          <div id="inputDiaHora">
              <div class="row">
                  <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                      <select class="js-example-basic-multiple" id="dias" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                          <option value="Todos">Todos</option>
                          <option value="Lunes">Lunes</option>
                          <option value="Martes">Martes</option>
                          <option value="Miercoles">Miercoles</option>
                          <option value="Jueves">Jueves</option>
                          <option value="Viernes">Viernes</option>
                          <option value="Sabado">Sabado</option>
                          <option value="Domingo">Domingo</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Horario Desde
                      <select class="js-example-basic-multiple" id="id_label_multiple" placeholder="Obligatorio"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Hasta
                      <select class="js-example-basic-multiple" id="id_label_multiple1" placeholder="Obligatorio"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>

                  <div class="row">
                      <div class="col s2 m2 l2">
                          <div id="boton_dias1" class="waves-effect waves-light btn-small add1" onclick="agregarDias1()">Agregar</div>
                      </div>
                  </div>
              </div>
          </div>

          <div id="inputDiaHora2">
              <div class="row">
                  <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                      <select class="js-example-basic-multiple" id="dias2" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                          <option value="Todos">Todos</option>
                          <option value="Lunes">Lunes</option>
                          <option value="Martes">Martes</option>
                          <option value="Miercoles">Miercoles</option>
                          <option value="Jueves">Jueves</option>
                          <option value="Viernes">Viernes</option>
                          <option value="Sabado">Sabado</option>
                          <option value="Domingo">Domingo</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Horario Desde
                      <select class="js-example-basic-multiple" id="id_label_multiple2"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Hasta
                      <select class="js-example-basic-multiple" id="id_label_multiple12"  style="width:60%">
                          <option value=""></option>
                          
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>

                  <div class="row">
                      
                      <div class="col s2 m2 l2">
                          <div id="boton_dias2" class="waves-effect waves-light btn-small add1 " onclick="agregarDias2()">Agregar</div>
                      </div>

                  </div>
                   

              </div>
          </div>
          <div id="inputDiaHora3">
              <div class="row">
                  <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                      <select class="js-example-basic-multiple" id="dias3" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                          <option value="Todos">Todos</option>
                          <option value="Lunes">Lunes</option>
                          <option value="Martes">Martes</option>
                          <option value="Miercoles">Miercoles</option>
                          <option value="Jueves">Jueves</option>
                          <option value="Viernes">Viernes</option>
                          <option value="Sabado">Sabado</option>
                          <option value="Domingo">Domingo</option>

                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Horario Desde
                      <select class="js-example-basic-multiple" id="id_label_multiple3"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Hasta
                      <select class="js-example-basic-multiple" id="id_label_multiple13"  style="width:60%">
                         <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>

                  <div class="row">
                      
                      <div class="col s2 m2 l2">
                          <div id="boton_dias3" class="waves-effect waves-light btn-small add1 " onclick="agregarDias3()">Agregar</div>
                      </div>

                  </div>
          
              </div>
          </div>
          <div id="inputDiaHora4">
              <div class="row">
                  <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                      <select class="js-example-basic-multiple" id="dias4" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                          <option value="Todos">Todos</option>
                          <option value="Lunes">Lunes</option>
                          <option value="Martes">Martes</option>
                          <option value="Miercoles">Miercoles</option>
                          <option value="Jueves">Jueves</option>
                          <option value="Viernes">Viernes</option>
                          <option value="Sabado">Sabado</option>
                          <option value="Domingo">Domingo</option>

                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Horario Desde
                      <select class="js-example-basic-multiple" id="id_label_multiple4"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Hasta
                      <select class="js-example-basic-multiple" id="id_label_multiple14"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>

                  <div class="row">
                     
                      <div class="col s2 m2 l2">
                          <div id="boton_dias4" class="waves-effect waves-light btn-small add1 " onclick="agregarDias4()">Agregar</div>
                      </div>

                  </div>
                   
                
              </div>
          </div>
          <div id="inputDiaHora5">
              <div class="row">
                  <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                      <select class="js-example-basic-multiple" id="dias5" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                          <option value="Todos">Todos</option>
                          <option value="Lunes">Lunes</option>
                          <option value="Martes">Martes</option>
                          <option value="Miercoles">Miercoles</option>
                          <option value="Jueves">Jueves</option>
                          <option value="Viernes">Viernes</option>
                          <option value="Sabado">Sabado</option>
                          <option value="Domingo">Domingo</option>

                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Horario Desde
                      <select class="js-example-basic-multiple" id="id_label_multiple5"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>
                  <div class=" input-field col s2 m2 l2">Hasta
                      <select class="js-example-basic-multiple" id="id_label_multiple15"  style="width:60%">
                          <option value=""></option>
                          <option value="1:00">1:00</option>
                          <option value="2:00">2:00</option>
                          <option value="3:00">3:00</option>
                          <option value="4:00">4:00</option>
                          <option value="5:00">5:00</option>
                          <option value="6:00">6:00</option>
                          <option value="7:00">7:00</option>
                          <option value="8:00">8:00</option>
                          <option value="9:00">9:00</option>
                          <option value="10:00">10:00</option>
                          <option value="11:00">11:00</option>
                          <option value="12:00">12:00</option>
                          <option value="13:00">13:00</option>
                          <option value="14:00">14:00</option>
                          <option value="15:00">15:00</option>
                          <option value="16:00">16:00</option>
                          <option value="17:00">17:00</option>
                          <option value="18:00">18:00</option>
                          <option value="19:00">19:00</option>
                          <option value="20:00">20:00</option>
                          <option value="21:00">21:00</option>
                          <option value="22:00">22:00</option>
                          <option value="23:00">23:00</option>
                          <option value="24:00">24:00</option>
                      </select>
                  </div>

                  <div class="row">
                      
                      <div class="col s2 m2 l2">
                          <div id="boton_dias5" class="waves-effect waves-light btn-small add1 " onclick="agregarDias5()">Agregar</div>
                      </div>

                  </div>
                 

              </div>
          </div>
      </div>
      
      <div class="row">
        <h4 style="color:#838383">Horarios Agregados</h4>
      </div>
      <div class="row">
        <div class="col s12 m12 l12  boxsmart" >
          <div id="containerDataHoras">
              <div class="boxSmartContent" id="dias1Box">
                  <div class="col s4 m4 l4">
                      <span style="font-size: 20px" id="diasData1"></span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style="font-size: 20px" id="comunasData1"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="font-size: 20px" class="right-align" >
                      <span id="horasData1"></span>
                      <span>a</span>
                      <span id="horasData1h"></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora1()" class="waves-effect" id="btn-hora-hora1"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias2Box">
                  <div class="col s4 m4 l4">
                      <span style="font-size: 20px" id="diasData2"></span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style="font-size: 20px" id="comunasData2"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style="font-size: 20px" class="right-align" >
                      <span id="horasData2"></span>
                      <span>a</span>
                      <span id="horasData2h"></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora2()" class="waves-effect" id="btn-hora-hora2"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias3Box">
                  <div class="col s4 m4 l4">
                      <span style=" font-size: 20px" id="diasData3"></span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style=" font-size: 20px" id="comunasData3"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style=" font-size: 20px" class="right-align" >
                      <span id="horasData3"></span>
                      <span>a</span>
                      <span id="horasData3h"></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora3()" class="waves-effect" id="btn-hora-hora3"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias4Box">
                  <div class="col s4 m4 l4">
                      <span style=" font-size: 20px" id="diasData4"></span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style=" font-size: 20px" id="comunasData4"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style=" font-size: 20px" class="right-align" >
                      <span id="horasData4"></span>
                      <span>a</span>
                      <span id="horasData4h"></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora4()" class="waves-effect" id="btn-hora-hora4"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
              <div class="boxSmartContent" id="dias5Box">
                  <div class="col s4 m4 l4">
                      <span style=" font-size: 20px" id="diasData5"></span>
                  </div>
                  <div class="col s5 m5 l5">
                      <span style=" font-size: 20px" id="comunasData5"></span>
                  </div>
                  <div class="col s2 m2 l2 right-align">
                  <span style=" font-size: 20px" class="right-align" >
                      <span id="horasData5"></span>
                      <span>a</span>
                      <span id="horasData5h"></span>
                  </span>
                  </div>
                  <div class="col s1 m1 l1 right-align">
                      <div onclick="myFunctionEliminarHora5()" class="waves-effect" id="btn-hora-hora5"><i class="small material-icons" style="color: red">cancel</i></div>
                  </div>
              </div>
          </div>
        </div>

      </div>
      <br><br>
      <div class="row">
        <div class="col s6 m6 l6">
          <!-- <a href="proceso4.html" class="waves-effect waves-light btn-large">Atrás</a> -->
        </div>
        <div class="col s6 m6 l6 pull-m6 right">
          <button type="submit" class="waves-effect waves-light btn right" href="proceso6.php">Siguiente</button>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
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