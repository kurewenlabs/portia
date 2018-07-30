<?php
$id = $_GET['identificador'];
require_once 'db.php';
global $conn;
$sql = "SELECT * FROM (SELECT * FROM kurewenc_db_portia.tbl_postulante) a
            LEFT JOIN
    (
        SELECT id_post,nombre 
        FROM  tbl_datos_postulacion_abierta
        -- LIMIT 0 , 1s
    ) b ON a.id_post = b.id_post 
    left outer join tbl_documento c ON c.id_post=b.id_post 
    left outer join tbl_estudio d ON d.id_post=b.id_post 
    left outer join tbl_horario_trabajo e ON e.id_post=b.id_post  
    left outer join tbl_curso f ON f.id_post=b.id_post  
    left outer join tbl_experiencia_laboral g ON g.id_post=b.id_post  
    left outer join tbl_referencia_laboral h ON h.id_post=b.id_post  
    where a.id_post='".$id."' 
LIMIT 2";
$result1 = $conn->query($sql);
$result = $result1->fetch_assoc();
/*echo "<pre>";
print_r($result);
echo "</pre>"*/
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
    <h6>Administracion Sistema de Postulación Portia</h6>
</nav>
<div class="row">
    <div class="col s3 m3 l3">
        <a href="userportia.html.php" class="volverUser"> <i class="material-icons">arrow_back</i>  Volver</a>
    </div>
</div>
<div class="row">
    <h3 class="center-align">Editar postulación</h3>
    <p class="center-align"> imprimir la fecha aqui</p><!-- DEBE PASAR LA FECHA DEL DIA AQUI -->
</div>
<div class="container">
    <div class="row">
        <p>Postulacion</p>
    </div>
    <div class="row">
        <div class="col s12 m12 l12 dataPostulacion">
            <div class="col s6 m6 l6">
                <h5><?php echo $result['nombres']?> <?php echo $result['apellidop']?> <?php echo $result['apellidom']?></h5>
                <p><?php echo $result['rut']?></p>
            </div>
            <div class="col s4 m4 l4">
                <h6 class="rentaEdit"><?php echo $result['renta']?></h6>
            </div>
            <div class="col s2 m2 l2">
                <a href="adminedit.php?identificador=<?php echo $id?>" class="right-align detalleEdit">Ver Detalle</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="chip col s1 offset-s1">
            <?php echo $result['nombre']?><i class="close material-icons">close</i>
        </div>
        <div class="col s2 col m2 col l2">
            <a  data-target="modal1" class="btn modal-trigger">Editar cargos</a>
        </div>
    </div>

<!-- Modal EDITAR CARGOS -->
  <div id="modal1" class="modal">
    <div class="modal-content">
      <h4>Seleccione Cargo</h4>
 <div class="row">
   <div class="col s12 m3 l3"><!--retail-->
  <h5>Retail</h5>
 
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
 </div>     
<div class="row">
  
  
</div>
    </div>
    <div class="modal-footer">
      <a href="clasificacionuser.php" class="modal-close waves-effect waves-green btn-flat">Aceptar</a>
    </div>
  </div>













    <div class="row">

        <div class="row">
            <div class="col s6 m6 l6">
                <label>Curriculum</label>
                <div class="file-field input-field">
                    <div class="btn">
                        <span>Descargar</span>
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
                        <span>Descargar</span>
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
                        <span>Descargar</span>
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
                        <span>Descargar</span>
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

    <div class="row">
        <div class="">
            <form method="POST" action="process_editar.php" id="print-edit">
                <input type="hidden" name="identificador" value="<?= $id ?>" />
                <input type="hidden" name="pagina" value="actualizar_estado" />
                <div class="">
                    <p>Clasificar</p>
                    <div class="clasificar col s4 m4 l4 left-align">
                        <p>
                            <label for="sinClasificar2">
                                <input value="Sin Clasificar" id="sinClasificar2"  class="with-gap" name="group1" type="radio" <?php if($result['estado_post'] == 'Sin Clasificar') echo "checked='checked'"; else "";?>/>
                                <span><span class="badge yellow sinClasificar"> Sin Clasificar</span></span>
                            </label>
                        </p>
                        <p>
                            <label for="apto2">
                                <input value="Seleccionado" id="apto2"  class="with-gap" name="group1" type="radio" <?php if($result['estado_post'] == 'Seleccionado') echo "checked='checked'"; else "";?>/>
                                <span><span class="badge green sinClasificar">Apto</span></span>
                            </label>
                        </p>
                        <p>
                            <label for="fueraRango2">
                                <input value="Fuera Rango Renta" id="fueraRango2"  class="with-gap" name="group1" type="radio" <?php if($result['estado_post'] == 'Fuera Rango Renta') echo "checked='checked'"; else "";?>/>
                                <span><span class="badge orange sinClasificar"> Fuera Rango Renta</span></span>
                            </label>
                        </p>
                        <p>
                            <label for="noApto2">
                                <input value="No Apto" id="noApto2"  class="with-gap" name="group1" type="radio" <?php if($result['estado_post'] == 'No Apto') echo "checked='checked'"; else "";?>/>
                                <span><span class="badge grey sinClasificar"> No Apto</span></span>
                            </label>
                        </p>
                    </div>
                    <div class="col s4 m4 l4">
                        <p class="left-align">Observación</p>
                        <form>
                            <div class="input-field">
                                <textarea id="textarea1" name="observacion" class="browser-default"><?php echo $result['observacion']?></textarea>
                                <label for="textarea1"></label>
                            </div>
                        </form>
                    </div>
                    <div class="row">
                        <div class="col s3 m3 l3">
                            <a href="#!" class=" waves-effect waves-green btn-flat borrar">Eliminar</a>
                        </div>
                        <div class="col s3 m3 l3">
                            <button class="waves-effect waves-green btn save" type="submit" href="userportia.html.php">Guardar</button>
                        </div>
                    </div>
            </form>
        </div>

    </div>
</div>




</div><!--container-->



<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type = "text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
<script src="src/js/postulaciones.js"></script>
</body>
</html>
