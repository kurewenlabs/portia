<?php
    session_start();

    $id = $_GET['identificador'];
    $postula = $_GET['postulacion'];
    require_once 'db.php';
    global $conn;
    $sql = "SELECT a.id_post, a.fecha_post, a.estado_post, a.tipo_documento, a.rut, a.nombres, a.apellidoP, a.apellidoM, a.fecha_nacimiento, a.sexo, 
                a.estado_civil, a.nacionalidad, a.telefono, a.telefono_recado, a.email, a.provincia, a.comuna, a.domicilio, 
                a.tpolera, a.tpantalon, a.tpoleron, a.tzapatos, a.renta, a.tlicenciaconducir, a.afp, a.prestadorsalud, 
                a.experiencialaboral, a.referencialaboral, b.nombre, b.estado, b.observacion, c.cv, c.antecedentes, c.carnet, 
                c.fotografia, d.tipo_estudio, d.titulo, d.estado as estado_estudio, d.fecha_titulacion, d.semestres FROM 
            (
                SELECT * 
                FROM tbl_postulante
            ) a
            LEFT JOIN
            (
                SELECT id_post, nombre, estado, observacion 
                FROM  tbl_datos_postulacion_abierta
                WHERE nombre = '".$postula."'
            ) b ON a.id_post = b.id_post 
            LEFT OUTER JOIN tbl_documento c ON c.id_post = b.id_post 
            LEFT OUTER JOIN tbl_estudio d ON d.id_post = b.id_post 
            WHERE a.id_post='".$id."' 
            LIMIT 1";
    $result1 = $conn->query($sql);
    $result = $result1->fetch_assoc();

    $sql = "SELECT * FROM tbl_curso WHERE id_post = '" . $id . "'";
    $result1 = $conn->query($sql);
    if ($result1) {
        $i = 0;
        while($fila = $result1->fetch_assoc()) {
           $result["cursos"][$i] = $fila;
           $i++;
        }
    }

    if ($result["experiencialaboral"] == 'Si') {
        $sql = "SELECT * FROM tbl_experiencia_laboral WHERE id_post = '" . $id . "'";
        $result1 = $conn->query($sql);
        if ($result1) {
            $i = 0;
            while($fila = $result1->fetch_assoc()) {
               $result["experiencia"][$i] = $fila;
               $i++;
            }
        }
    }

    if ($result["referencialaboral"] == 'Si') {
        $sql = "SELECT * FROM tbl_referencia_laboral WHERE id_post = '" . $id . "'";
        $result1 = $conn->query($sql);
        if ($result1) {
            $i = 0;
            while($fila = $result1->fetch_assoc()) {
               $result["referencias"][$i] = $fila;
               $i++;
            }
        }
    }

    $sql = "SELECT * FROM tbl_comuna WHERE id_post = '" . $id . "'";
    $result1 = $conn->query($sql);
    if ($result1) {
        $i = 0;
        while($fila = $result1->fetch_assoc()) {
           $result["comunas"][$i] = $fila;
           $i++;
        }
    }

    $sql = "SELECT * FROM tbl_horario_trabajo WHERE id_post = '" . $id . "'";
    $result1 = $conn->query($sql);
    if ($result1) {
        $i = 0;
        while($fila = $result1->fetch_assoc()) {
           $result["horarios"][$i] = $fila;
           $i++;
        }
    }

    if (isset($_SESSION["mode"])) {
        echo "<!-- ";
        print_r($result);
        echo " -->";
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <title>Administracion Sistema de Postulación Portia</title>
        <link rel="icon" href="src/img/Portia-favicon.png" type="image/png" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css">
        <link rel="stylesheet" href="https://printjs-4de6.kxcdn.com/print.min.css">
        <link rel="stylesheet" href="dist/css/main.min.css">
        <!--REQUIRED STYLE SHEETS-->
    </head>

    <body>
        <nav class="teal">
            <h6>Sistema de Postulación Portia</h6>
        </nav>
        <div class="container">
            <div class="row">
                <div class="col s6 m6 l6 ">
                    <a class="waves-effect btn-flat botonadmin" href="userportia.html.php">Volver</a>
                </div>
                <div class="col s6 m6 l6">
                    <a type="button" onclick="document.location.href = 'adminedit.pdf.php?identificador=<?php echo $id; ?>&postulacion=<?php echo $postula; ?>';"
                        class="waves-effect btn-flat botonadmin2">
                        <i class="tiny material-icons">picture_as_pdf</i>Exportar PDF</a>
                </div>
            </div>
            <h4 class="left-align prev">Previsualización Curriculum</h4>
            <p class="left-align">Usted podrá editar el curriculum ingresado además de clasificar su estado</p>
            
                <div class="row"></div>
                <div class="divider"></div>

                <div class="row">
                    <!--titulo-->
                    <div class="col s8 m8 l8">
                        <h3>Cargos Seleccionados</h3>
                    </div>

                    <div class="row">
                        <div class="col s2 col m2 col l2">
                            <a data-target="modal2" class="btn btn-small modal-trigger botonCargos">Editar cargos</a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="chip col s1 offset-s1" id="chip">
                            <?php echo $result['nombre']?>
                            <i class="close material-icons">close</i>
                        </div>
                    </div>
                </div>

                <!-- Modal EDITAR CARGOS -->
                <div id="modal2" class="modal">
                    <div class="modal-content">
                        <h4>Seleccione Cargo</h4>
                        <div class="row">
                            <div class="col s12 m3 l3">
                                <!--retail-->
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
                                            <input type="checkbox" value="reponedor grandes superficies" data-index="2" id="r2">
                                            <span>Reponedor grandes superficies</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label for="r3">
                                            <input type="checkbox" value="promotor grandes tiendas" data-index="3" id="r3">
                                            <span>Promotor (a) grandes tiendas</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label for="r4">
                                            <input type="checkbox" value="promotor supermercados" data-index="4" id="r4">
                                            <span>Promotor (a) supermercados</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label for="r5">
                                            <input type="checkbox" value="vendedor de intangibles" data-index="5" id="r5">
                                            <span>vendedor de intangibles</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label for="r6">
                                            <input type="checkbox" value="vendedor de tangibles" data-index="6" id="r6">
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

                            </div>
                            <!--retail-->



                            <div class="col s12 m3 l3">
                                <!--administrativo-->
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
                                            <input type="checkbox" value="asistente contable" data-index="13" id="a3">
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
                            </div>
                            <!--administrativo-->
                            <div class="col s12 m3 l3">
                                <!--industrial-->
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

                            </div>
                            <!--industrial-->
                            <div class="col s12 m3 l3">
                                <!--otros-->
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
                            </div>
                            <!--otros-->
                        </div>


                        <div class="modal-footer">
                            <a href="" class="modal-close waves-effect waves-green btn-flat">Actualizar</a>
                        </div>
                    </div>

                </div>

                <div class="divider"></div>
                <!-- AQUI COMIENZA LA POSTULACION --------------------------------------------------- -->



                <div class="row">
                    <div class="col s8 m8 l8">
                        <h4>1.- Datos Personales</h4>
                    </div>

                </div>

                <form action="process_editar.php" method="POST">
                    <input type="hidden" name="identificador" value="<?= $id ?>" />
                    <input type="hidden" name="pagina" value="datos_personales" />
                    <div class="row">
                        <!--documentos-->
                        <div id="datosPersonales">
                            <div class="tab input-field col s4 m4 l4">Tipo de Documento de identificacion
                                <select class="browser-default" onselect="this.className = ''" name="documento" id="documento">
                                    <option <?php if($result['tipo_documento']=="rut" ){ echo 'selected'; }?> value="rut">RUT</option>
                                    <option <?php if($result['tipo_documento']=="pasaporte" ){ echo 'selected'; }?> value="pasaporte">Pasaporte</option>
                                </select>
                            </div>
                            <div class=" input-field col s4 m4 l4 " id="rut_box">
                                <label for="rut">RUT</label>
                                <input name="rut" placeholder="Ingrese rut con digito verificador" id="rut" type="text" class="validate" value="<?php echo ($result['tipo_documento']=="rut"?$result['rut']:""); ?>">
                            </div>
                            <div class=" input-field col s4 m4 l4 " id="pasaporte_box">
                                <label for="pasaporte">Pasaporte</label>
                                <input name="pasaporte" type="tel" class="validate rut_box" id="pasaporte" type="text" class="validate" value="<?php echo ($result['tipo_documento']=="pasaporte"?$result['rut']:""); ?>">
                            </div>
                        </div>
                    </div>
                    <!--documentos-->
                    <div class="row">
                        <!--datos identificacion-->
                        <div class="tab">
                            <div class="tab input-field col s4 m4 l4">
                                <label for="first_name">Nombre</label>
                                <input name="primerNombre" id="first_name" type="text" class="validate" value="<?php echo $result['nombres']?>">
                            </div>
                            <div class="tab input-field col s4 m4 l4">
                                <label for="last_name">Apellido Paterno</label>
                                <input name="primerApellido" id="last_name" type="text" class="validate" value="<?php echo $result['apellidop']?>">
                            </div>
                            <div class="tab input-field col s4 m4 l4">
                                <label for="last_name_2">Apellido Materno</label>
                                <input name="segundoApellido" id="last_name_2" type="text" class="validate" value="<?php echo $result['apellidom']?>">
                            </div>
                        </div>

                    </div>
                    <!--datos identificacion-->
                    <div class="row">
                        <div class="tab">
                            <div class="tab input-field col s3 m3 l3">
                                <label for="txtDate">Fecha de Nacimiento</label>
                                <input name="fechaNacimiento" type="text" class="datepicker" id="txtDate" value="<?php echo $result['fecha_nacimiento']?>">
                            </div>
                            <div class="tab input-field col s3 m3 l3">
                                <select class="browser-default" id="sexo" onselect="this.className = ''" name="sexo">
                                    <option value="">Sexo</option>
                                    <option <?php if($result[ 'sexo']=="femenino" ){ print ' selected'; }?> value="femenino">Femenino</option>
                                    <option <?php if($result[ 'sexo']=="masculino" ){ print ' selected'; }?> value="masculino">Masculino</option>
                                </select>
                            </div>
                            <div class="tab input-field col s3 m3 l3">
                                <select class="browser-default" id="estado_civil" onselect="this.className = ''" name="estado_civil">
                                    <option value="">Estado Civil</option>
                                    <option <?php if($result[ 'estado_civil']=="soltero" ){ print ' selected'; }?> value="soltero">Soltero(a)</option>
                                    <option <?php if($result[ 'estado_civil']=="casado" ){ print ' selected'; }?> value="casado">Casado(a)</option>
                                    <option <?php if($result[ 'estado_civil']=="divorciado" ){ print ' selected'; }?> value="divorciado">Divorciado(a)</option>
                                    <option <?php if($result[ 'estado_civil']=="viudo" ){ print ' selected'; }?> value="viudo">Viudo(a)</option>
                                </select>
                            </div>
                            <div class="tab input-field col s3 m3 l3">
                                <label for="nacionalidad">Nacionalidad</label>
                                <input name="nacionalidad" id="nacionalidad" type="text" class="validate" value="<?php echo $result['nacionalidad']?>">
                            </div>
                        </div>
                    </div>
                    <!--datos identificacion-->
                    <div class="row">
                        <div class="">
                            <div class="input-field col s4 m4 l4">
                                <input id="telefono" type="tel" class="validate" placeholder="+56(9)" value="<?php echo $result['telefono']?>" name="telefono">
                                <label for="telefono">Telefono</label>
                            </div>
                            <div class="input-field col s4 m4 l4">
                                <input id="telefono2" type="tel" placeholder="+56(9)" class="validate" name="telefonoRecado" value="<?php echo $result['telefono_recado']?>">
                                <label for="telefono2">Telefono de Recado</label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="email" type="email" class="validate" value="<?php echo $result['email']?>" name="email">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <?php
                        // Obtenemos la información directa del servicio y la almacenamos localmente
                        $regiones = json_decode(file_get_contents('regiones.json'), true);
                    ?>
                        <div class="row">
                            <div class=" input-field col s4 m4 l4">Region
                                <select class="browser-default validate" id="region" onselect="this.className = ''" name="region">
                                    <option>Seleccione región</option>
                                    <?php 
                                        // Recorremos el JSON buscando los valores asociados a las regiones existentes
                                        foreach($regiones['regiones'] as $region) {
                                            echo "<option value='" . $region['region'] . "'" . ($result['provincia'] == $region['region']?" selected":"") . ">" . $region['region'] . "</option>\n";
                                        }
                                        $i++;
                                    ?>
                                </select>
                                <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
                            </div>
                            <script language="Javascript">
                                function cargarComunas() {
                                    var comunas = {
                                        <?php
                                            // Creamos un arreglo asociativo dinámico que llene las comunas en función de la región seleccionada
                                            $j = 1; 
                                            $k = 0;
                                            foreach($regiones['regiones'] as $region) {
                                                echo "region" . $j . " : [";
                                                natsort($region['comunas']);
                                                $z = 1;
                                                foreach($region['comunas'] as $comuna) {
                                                    echo "\"" . $comuna . "\", ";
                                                    if ($region['region'] == $result['provincia'] && $comuna == $result['comuna']) {
                                                    $k = $z;
                                                    }
                                                    $z++;
                                                }
                                                echo "\"\"],\n";
                                                $j++;
                                            }
                                            if ($k != 0) $i++;
                                        ?>
                                    };

                                    var campoRegion = document.getElementById('region');
                                    var campoComuna = document.getElementById('comuna');
                                    regionSeleccionada = campoRegion.selectedIndex;
                                    campoComuna.innerHTML = '<option>Selecciona comuna</option>';

                                    if (regionSeleccionada != "") {
                                        regionSeleccionada = comunas["region" + regionSeleccionada];
                                        regionSeleccionada.forEach(function (comuna) {
                                            if (comuna != "") {
                                                var opcion = document.createElement('option');
                                                opcion.value = comuna;
                                                opcion.text = comuna;
                                                campoComuna.add(opcion);
                                            }
                                        });
                                    }
                                    campoComuna.selectedIndex = <?php echo $k; ?>;
                                }
                            </script>
                            <div class=" input-field col s4 m4 l4">Comuna
                                <select class="browser-default validate" id="comuna" onselect="this.className = ''" name="comuna">
                                </select>
                                <!-- CONSUMIR API COMUNAS/REGIONES AQUI -->
                            </div>
                            <script language="Javascript">
                                cargarComunas();
                            </script>
                        </div>
                        <div class="row">
                            <div class="input-field col s12 m12 l12">
                                <input id="direccion" type="text" class="validate" value="<?php echo $result['domicilio']?>" name="domicilio">
                                <label for="direccion">Direccion</label>
                            </div>
                        </div>

                </form>
                <div class="divider"></div>

                <!-- --------------------------- ESTUDIOS ------------------------------ -->

                <div class="row">
                    <div class="col s8 m8 l8">
                        <h4>2.- Estudios</h4>
                    </div>

                </div>
                <div class="row">
                    <!--documentos-->
                    <div class="tab" id="estudios">
                        <div class="tab input-field col s4 m4 l4">
                            <select class="browser-default" onselect="this.className = ''" name="estudio">
                                <option value="">Tipo de Estudios</option>
                                <option value="Secundario" <?php echo ($result[ 'tipo_estudio']=='Secundario' ? "selected": ""); ?>>Secundario</option>
                                <option value="Técnico Superior" <?php echo ($result[ 'tipo_estudio']=='Técnico Superior' ? "selected": ""); ?>>Técnico Superior</option>
                                <option value="Universitario" <?php echo ($result[ 'tipo_estudio']=='Universitario' ? "selected": ""); ?>>Universitario</option>
                                <option value="Posgrado">
                                    <?php echo ($result['tipo_estudio']=='Posgrado'?"selected":""); ?>
                                </option>
                                <option value="Master" <?php echo ($result[ 'tipo_estudio']=='Master' ? "selected": ""); ?>>Master</option>
                                <option value="Doctorado" <?php echo ($result[ 'tipo_estudio']=='Doctorado' ? "selected": ""); ?>>Doctorado</option>
                                <option value="Otro" <?php echo ($result[ 'tipo_estudio']=='Otro' ? "selected": ""); ?>>Otro</option>
                            </select>
                        </div>
                        <div class="tab input-field col s8 m8 l8">
                            <label for="carrera">Titulo de la Carrera</label>
                            <input id="carrera" type="text" class="validate" value="<?php echo $result['titulo']; ?>">
                        </div>
                    </div>
                </div>
                <!--documentos-->
                <div class="row">
                    <!--datos identificacion-->
                    <div class="tab">
                        <div class="tab input-field col s4 m4 l4">
                            <select onselect="this.className = ''" name="estado_estudio" class="browser-default">
                                <option value="">Estado</option>
                                <option value="En Curso" <?php echo ($result[ 'estado_estudio']=='En Curso' ? "selected": ""); ?>>En Curso</option>
                                <option value="Graduado" <?php echo ($result[ 'estado_estudio']=='Graduado' ? "selected": ""); ?>>Graduado</option>
                                <option value="Abandonado" <?php echo ($result[ 'estado_estudio']=='Abandonado' ? "selected": ""); ?>>Abandonado</option>
                            </select>
                        </div>
                        <div class=" input-field col s2 m2 l2">
                            <div id="box_estudio" class="box_estudio">
                                <label for="txtDate2ftitulacion">Año de Titulación</label>
                                <input type="text" class="date" id="txtDate2ftitulacion" placeholder="Ingrese año" value="<?php echo $result['fecha_titulacion']; ?>">
                            </div>

                        </div>
                        <div class=" input-field col s2 m2 l2">
                            <div id="box_estudio" class="box_estudio">
                                <label for="txtSemestres">Semestres cursados</label>
                                <input type="text" class="date" id="txtSemestres" placeholder="" value="<?php echo $result['semestres']; ?>">
                            </div>

                        </div>

                        <div class="tab input-field col s4 m4 l4">
                            <select onselect="this.className = ''" name="licencia" class="browser-default">
                                <option value="">Licencia de Conducir</option>
                                <option value="Sin Licencia" <?php echo ($result[ 'tlicenciaconducir']=='Sin Licencia' || $result[ 'tlicenciaconducir']==''? "selected": ""); ?>>Sin Licencia</option>
                                <option value="Clase A1" <?php echo ($result[ 'tlicenciaconducir']=='Clase A1' ? "selected": ""); ?>>Clase A1</option>
                                <option value="Clase A2" <?php echo ($result[ 'tlicenciaconducir']=='Clase A2' ? "selected": ""); ?>>Clase A2</option>
                                <option value="Clase A3" <?php echo ($result[ 'tlicenciaconducir']=='Clase A3' ? "selected": ""); ?>>Clase A3</option>
                                <option value="Clase A4" <?php echo ($result[ 'tlicenciaconducir']=='Clase A4' ? "selected": ""); ?>>Clase A4</option>
                                <option value="Clase A5" <?php echo ($result[ 'tlicenciaconducir']=='Clase A5' ? "selected": ""); ?>>Clase A5</option>
                                <option value="Clase B" <?php echo ($result[ 'tlicenciaconducir']=='Clase B' ? "selected": ""); ?>>Clase B</option>
                                <option value="Clase C" <?php echo ($result[ 'tlicenciaconducir']=='Clase C' ? "selected": ""); ?>>Clase C</option>
                                <option value="Clase D" <?php echo ($result[ 'tlicenciaconducir']=='Clase D' ? "selected": ""); ?>>Clase D</option>
                                <option value="Clase E" <?php echo ($result[ 'tlicenciaconducir']=='Clase E' ? "selected": ""); ?>>Clase E</option>
                                <option value="Clase F" <?php echo ($result[ 'tlicenciaconducir']=='Clase F' ? "selected": ""); ?>>Clase F</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!--datos identificacion-->


                <div class="row">
                    <h4>Otros Conocimientos (Opcional)</h4>
                    <span class="comentario">*Ingrese Máximo 3</span>
                    <div class="divider"></div>
                </div>
                <div class="curso1before">
                    <div class="row" id="curso_box" class="noMargin">
                        <!--cursos-->
                        <div class=" input-field col s6 m6 l6 back-box1">
                            <label for="curso">Curso</label>
                            <input id="curso" type="text" class="validate" value="<?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=1?$result["cursos"][0]["curso"]:" "); ?>">
                        </div>
                        <div class="col s4 m4 l4 input-field back-box1">
                            <label for="txtDate3">Fecha</label>
                            <input type="text" class="date" id="txtDate3" placeholder="Ingrese mes/año" value="<?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=1?$result["cursos"][0]["fecha"]:" "); ?>">
                        </div>
                        <div class="col s2 m2 l2">
                            <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso1" onclick="myFunctionCurso1()">Agregar</div>
                            <div onclick="myFunctionEliminarCurso1()" class="waves-effect btn-delete" id="btn-delete-curso1">
                                <i class="small material-icons ">cancel</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="curso2before">
                    <div class="row" id="curso2_box" class="noMargin">
                        <!--cursos-->
                        <div class=" input-field col s6 m6 l6 back-box1">
                            <label for="curso2">Curso</label>
                            <input id="curso2" type="text" class="validate" value="<?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=2?$result["cursos"][1]["curso"]:" "); ?>">
                        </div>
                        <div class="col s4 m4 l4 input-field back-box1">
                            <label for="txtDate3c2">Fecha</label>
                            <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c2" value="<?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=2?$result["cursos"][1]["fecha"]:" "); ?>">
                        </div>
                        <div class="col s2 m2 l2">
                            <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso2" onclick="myFunctionCurso2()">Agregar</div>
                            <div onclick="myFunctionEliminarCurso2()" class="waves-effect btn-delete" id="btn-delete-curso2">
                                <i class="small material-icons ">cancel</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="curso3before">
                    <div class="row" id="curso3_box" class="noMargin">
                        <!--cursos-->
                        <div class=" input-field col s6 m6 l6 back-box1">
                            <label for="curso3">Curso</label>
                            <input id="curso3" type="text" class="validate" value="<?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=3?$result["cursos"][2]["curso"]:" "); ?>">
                        </div>
                        <div class="col s4 m4 l4 input-field back-box1">
                            <label for="txtDate3c3">Fecha</label>
                            <input type="text" class="date" placeholder="Ingrese mes/año" id="txtDate3c3" value="<?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=3?$result["cursos"][2]["fecha"]:" "); ?>">
                        </div>
                        <div class="col s2 m2 l2">
                            <div class="waves-effect waves-light btn btn-send-curso" id="btn-send-curso3" onclick="myFunctionCurso3()">Agregar</div>
                            <div onclick="myFunctionEliminarCurso3()" class="waves-effect btn-delete" id="btn-delete-curso3">
                                <i class="small material-icons ">cancel</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                </div>
                <div class="row">
                    <div class="col s12 m12 l12 boxsmart" id="cursoData">
                        <input type="hidden" id="cursoData_form">
                    </div>
                </div>

                <div class="divider"></div>
                <!-- ----------------------------------------------- EXPERIENCIA LABORAL --------------------------------- -->
                <div class="row">
                    <div class="col s8 m8 l8">
                        <h4>3.- Experiencia Laboral</h4>
                    </div>

                </div>
                <div class="row">
                    <form id="proceso3form" onsubmit="return false;">
                        <div class="row">
                            <div class=" input-field col s4 m4 l4">¿Posee experiencia laboral?
                                <select class="browser-default" onselect="this.className = ''" name="experiencia" id="experiencia">
                                    <option value=""></option>
                                    <option value="Si" <?php echo ($result[ "experiencialaboral"]=="Si" ? "selected": ""); ?>>Si</option>
                                    <option value="No" <?php echo ($result[ "experiencialaboral"]=="No" ? "selected": ""); ?>>No</option>
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
                                        <input id="empresa" type="text" class="validate" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["empresa"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s4 m4 l4">
                                        <label for="cargo">Cargo</label>
                                        <input id="cargo" type="text" class="validate" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["cargo"]:" "); ?>">

                                    </div>
                                    <div class="col s2 m2 l2 input-field dateUntil">
                                        <label for="txtDate4">Desde mes/año</label>
                                        <input type="text" class="date" id="txtDate4" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["fecha_desde"]:" "); ?>">
                                        <p>
                                            <label for="fechaCargo">
                                                <input type="checkbox" value="Al presente" id="fechaCargo" <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1 && $result["experiencia"][0]["fecha_hasta"]==""?"checked":""); ?>>
                                                <span>Al presente</span>
                                            </label>
                                        </p>
                                    </div>
                                    <div class="col s2 m2 l2 input-field" id="input-fecha-until">

                                        <label for="txtDate4h">Hasta mes/año</label>
                                        <input type="text" class="date" id="txtDate4h" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["fecha_hasta"]:" "); ?>">

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
                                        <input id="empresa2" type="text" class="validate" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["empresa"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s4 m4 l4">
                                        <label for="cargo2">Cargo</label>
                                        <input id="cargo2" type="text" class="validate" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["cargo"]:" "); ?>">
                                    </div>
                                    <div class="col s2 m2 l2 input-field">
                                        <label for="txtDate42">Desde mes/año</label>
                                        <input type="text" class="date" id="txtDate42" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["fecha_desde"]:" "); ?>">
                                        <p>
                                            <label for="fechaCargo2">
                                                <input type="checkbox" value="Al presente" id="fechaCargo2" <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2 && $result["experiencia"][1]["fecha_hasta"]==""?"checked":""); ?>>
                                                <span>Al presente</span>
                                            </label>
                                        </p>
                                    </div>
                                    <div class="col s2 m2 l2 input-field" id="input-fecha-until2">

                                        <label for="txtDate42h">Hasta mes/año</label>
                                        <input type="text" class="date" id="txtDate42h" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["fecha_hasta"]:" "); ?>">

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
                                        <input id="empresa3" type="text" class="validate" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["empresa"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s4 m4 l4">
                                        <label for="cargo3">Cargo</label>
                                        <input id="cargo3" type="text" class="validate" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["cargo"]:" "); ?>">

                                    </div>
                                    <div class="col s2 m2 l2 input-field">
                                        <label for="txtDate43">Desde mes/año</label>
                                        <input type="text" class="date" id="txtDate43" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["fecha_desde"]:" "); ?>">
                                        <p>
                                            <label for="fechaCargo3">
                                                <input type="checkbox" value="Al presente" id="fechaCargo3" <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3 && $result["experiencia"][2]["fecha_hasta"]==""?"checked":""); ?>>
                                                <span>Al presente</span>
                                            </label>
                                        </p>
                                    </div>
                                    <div class="col s2 m2 l2 input-field" id="input-fecha-until3">

                                        <label for="txtDate43h">Hasta mes/año</label>
                                        <input type="text" class="date" id="txtDate43h" value="<?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["fecha_hasta "]:" "); ?>">

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
                                        <div class="col s4 m4 l4">
                                            <span class="boxDataExpInfo" id="empresaData">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["empresa"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <span class="boxDataExpInfo" id="cargoData">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["cargo"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s1 m1 l1">
                                            <span class="boxDataExpInfo" id="fecha1Data">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["fecha_desde"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s2 m2 l2 ">
                                            <span class="boxDataExpInfo" id="fecha2Data">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?$result["experiencia"][0]["fecha_hasta"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s1 m1 l1 right-align">
                                            <div onclick="elminarExp1()" class="waves-effect btnEliminarExp" id="btnDeleteExp1">
                                                <i class="small material-icons">cancel</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="boxDataExp2">
                                    <div class="boxDataExp">
                                        <div class="col s4 m4 l4">
                                            <span class="boxDataExpInfo" id="empresaData2">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["empresa"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <span class="boxDataExpInfo" id="cargoData2">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["cargo"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s1 m1 l1">
                                            <span class="boxDataExpInfo" id="fecha1Data2">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["fecha_desde"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s2 m2 l2 ">
                                            <span class="boxDataExpInfo" id="fecha2Data2">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?$result["experiencia"][1]["fecha_hasta"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s1 m1 l1 right-align">
                                            <div onclick="elminarExp2()" class="waves-effect btnEliminarExp" id="btnDeleteExp2">
                                                <i class="small material-icons">cancel</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="boxDataExp3">
                                    <div class="boxDataExp">
                                        <div class="col s4 m4 l4">
                                            <span class="boxDataExpInfo" id="empresaData3">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["empresa"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s4 m4 l4">
                                            <span class="boxDataExpInfo" id="cargoData3">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["cargo"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s1 m1 l1">
                                            <span class="boxDataExpInfo" id="fecha1Data3">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["fecha_desde"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s2 m2 l2 ">
                                            <span class="boxDataExpInfo" id="fecha2Data3">
                                                <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?$result["experiencia"][2]["fecha_hasta"]:""); ?>
                                            </span>
                                        </div>
                                        <div class="col s1 m1 l1 right-align">
                                            <div onclick="elminarExp3()" class="waves-effect btnEliminarExp" id="btnDeleteExp3">
                                                <i class="small material-icons">cancel</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br><br>

                    </form>
                </div>

                <div class="divider"></div>
                <!-- _____________________________________________________REFERENCIA LABORAL_______________________________________ -->
                <div class="row">
                    <div class="col s8 m8 l8">
                        <h4>4.- Referencias Laborales</h4>
                    </div>

                </div>
                <div class="row">
                    <form id="proceso4form" onsubmit="return false;">
                        <div class="row">
                            <div class="tab input-field col s5 m5 l5">¿Cuenta con referencias laborales?
                                <select class="browser-default" onselect="this.className = ''" name="referencia" id="referencia_laboral">
                                    <option value=""></option>
                                    <option value="Si" <?php echo ($result[ "referencialaboral"]=="Si" ? "selected": ""); ?>>Si</option>
                                    <option value="No" <?php echo ($result[ "referencialaboral"]=="No" ? "selected": ""); ?>>No</option>
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
                                <div class=" input-field col s5 m5 l5 back-box3">
                                    <label for="empresaref">Empresa </label>
                                    <input id="empresaref" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=1?$result["referencias"][0]["empresa"]:" "); ?>">
                                </div>
                                <div class=" input-field col s5 m5 l5 back-box3">
                                    <label for="contactoref">Nombre del Contacto</label>
                                    <input id="contactoref" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=1?$result["referencias"][0]["nombre_contacto"]:" "); ?>">
                                </div>
                                <div class="row">
                                    <div class=" input-field col s4 m4 l4 back-box2">
                                        <label for="cargoref">Cargo</label>
                                        <input id="cargoref" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=1?$result["referencias"][0]["cargo"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s3 m3 l3 back-box2">
                                        <label for="telefonoref">Telefono</label>
                                        <input id="telefonoref" type="tel" class="validate" placeholder="+56(9)" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=1?$result["referencias"][0]["telefono"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s4 m4 l4 back-box2">
                                        <label for="emailref">Email</label>
                                        <input id="emailref" type="email" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=1?$result["referencias"][0]["email"]:" "); ?>">
                                    </div>
                                    <div class="col s2 m2 l2 ">
                                        <div id="boton_refs1" class="waves-effect waves-light btn-small add" onclick="myFunctionRef()">Agregar</div>
                                        <div onclick="myFunctionEliminarRef1()" class="waves-effect btn-delete-ref" id="btn-delete-ref1">
                                            <i class="small material-icons ">cancel</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="refs_box2">
                                <div class=" input-field col s5 m5 l5 back-box3">
                                    <label for="empresaref2">Empresa 2</label>
                                    <input id="empresaref2" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=2?$result["referencias"][1]["empresa"]:" "); ?>">
                                </div>
                                <div class=" input-field col s5 m5 l5 back-box3">
                                    <label for="contactoref2">Nombre del Contacto</label>
                                    <input id="contactoref2" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=2?$result["referencias"][1]["nombre_contacto"]:" "); ?>">
                                </div>
                                <div class="row">
                                    <div class=" input-field col s4 m4 l4 back-box2">
                                        <label for="cargoref2">Cargo</label>
                                        <input id="cargoref2" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=2?$result["referencias"][1]["cargo"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s3 m3 l3 back-box2">
                                        <label for="telefonoref2">Telefono</label>
                                        <input id="telefonoref2" type="tel" class="validate" placeholder="+56(9)" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=2?$result["referencias"][1]["telefono"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s4 m4 l4 back-box2">
                                        <label for="emailref2">Email</label>
                                        <input id="emailref2" type="email" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=2?$result["referencias"][1]["email"]:" "); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col s2 m2 l2">
                                            <div id="boton_refs2" class="waves-effect waves-light btn-small add" onclick="myFunctionRef2()">Agregar</div>
                                            <div onclick="myFunctionEliminarRef2()" class="waves-effect btn-delete-ref" id="btn-delete-ref2">
                                                <i class="small material-icons ">cancel</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="refs_box3">
                                <div class=" input-field col s5 m5 l5 back-box3">
                                    <label for="empresaref3">Empresa 3</label>
                                    <input id="empresaref3" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=3?$result["referencias"][2]["empresa"]:" "); ?>">
                                </div>
                                <div class=" input-field col s5 m5 l5 back-box3">
                                    <label for="contactoref3">Nombre del Contacto</label>
                                    <input id="contactoref3" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=3?$result["referencias"][2]["nombre_contacto"]:" "); ?>">
                                </div>
                                <div class="row">
                                    <div class=" input-field col s4 m4 l4 back-box2">
                                        <label for="cargoref3">Cargo</label>
                                        <input id="cargoref3" type="text" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=3?$result["referencias"][2]["cargo"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s3 m3 l3 back-box2">
                                        <label for="telefonoref3">Telefono</label>
                                        <input id="telefonoref3" type="tel" class="validate" placeholder="+56(9)" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=3?$result["referencias"][2]["telefono"]:" "); ?>">
                                    </div>
                                    <div class=" input-field col s4 m4 l4 back-box2">
                                        <label for="emailref3">Email</label>
                                        <input id="emailref3" type="email" class="validate" value="<?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=3?$result["referencias"][2]["email"]:" "); ?>">
                                    </div>
                                    <div class="row">
                                        <div class="col s2 m2 l2">
                                            <div id="boton_refs3" class="waves-effect waves-light btn-small add" onclick="myFunctionRef3()">Agregar</div>
                                            <div onclick="myFunctionEliminarRef3()" class="waves-effect btn-delete-ref" id="btn-delete-ref3">
                                                <i class="small material-icons ">cancel</i>
                                            </div>
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
                </div>

                <div class="row"></div>
                <div class="divider"></div>
                <!-- _____________________________________________________DATOS PREVISIONALES_______________________________________ -->

                <div class="row">
                    <div class="col s8 m8 l8">
                        <h4>5.- Otros Datos</h4>
                    </div>

                </div>

                <div class="row">
                    <div class="tab input-field col s6 m6 l6" id="datosPrevision">
                        <select class="browser-default" onselect="this.className = ''" name="afp">
                            <option value="">AFP</option>
                            <option value="AFP Capital" <?php echo ($result["afp"]=='AFP Capital' ? "selected": ""); ?>>AFP Capital</option>
                            <option value="AFP Cuprum" <?php echo ($result["afp"]=='AFP Cuprum' ? "selected": ""); ?>>AFP Cuprum</option>
                            <option value="AFP Habitat" <?php echo ($result["afp"]=='AFP Habitat' ? "selected": ""); ?>>AFP Habitat</option>
                            <option value="AFP Modelo" <?php echo ($result["afp"]=='AFP Modelo' ? "selected": ""); ?>>AFP Modelo</option>
                            <option value="AFP Planvital" <?php echo ($result["afp"]=='AFP Planvital' ? "selected": ""); ?>>AFP Planvital</option>
                            <option value="AFP Provida" <?php echo ($result["afp"]=='AFP Provida' ? "selected": ""); ?>>AFP Provida</option>
                        </select>
                    </div>
                    <div class=" input-field col s6 m6 l6">
                        <select class="browser-default" onselect="this.className = ''" name="isapre" id="isapre">
                            <option value="">Isapre o Fonasa</option>
                            <option value="Banmédica" <?php echo ($result["prestadorsalud"]=='Banmedica' ? "selected": ""); ?>>Banmédica</option>
                            <option value="Chuquicamata" <?php echo ($result["prestadorsalud"]=='Chuquicamata' ? "selected": ""); ?>>Chuquicamata</option>
                            <option value="Consalud" <?php echo ($result["prestadorsalud"]=='Consalud' ? "selected": ""); ?>>Consalud</option>
                            <option value="Colmena" <?php echo ($result["prestadorsalud"]=='Colmena' ? "selected": ""); ?>>Colmena</option>
                            <option value="Cruz Blanca" <?php echo ($result["prestadorsalud"]=='Cruz Blanca' ? "selected": ""); ?>>Cruz Blanca</option>
                            <option value="Cruz del Norte" <?php echo ($result["prestadorsalud"]=='Cruz del Norte' ? "selected": ""); ?>>Cruz del Norte</option>
                            <option value="Fonasa" <?php echo ($result["prestadorsalud"]=='Fonasa' ? "selected": ""); ?>>Fonasa</option>
                            <option value="Fundación" <?php echo ($result["prestadorsalud"]=='Fundacion' ? "selected": ""); ?>>Fundación</option>
                            <option value="Fusat" <?php echo ($result["prestadorsalud"]=='Fusat' ? "selected": ""); ?>>Fusat</option>
                            <option value="Nueva Masvida" <?php echo ($result["prestadorsalud"]=='Nueva Masvida' ? "selected": ""); ?>>Nueva Masvida</option>
                            <option value="Río Blanco" <?php echo ($result["prestadorsalud"]=='Rio Blanco' ? "selected": ""); ?>>Río Blanco</option>
                            <option value="San Lorenzo" <?php echo ($result["prestadorsalud"]=='San Lorenzo' ? "selected": ""); ?>>San Lorenzo</option>
                            <option value="Vida Tres" <?php echo ($result["prestadorsalud"]=='Vida Tres' ? "selected": ""); ?>>Vida Tres</option>
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
                            <select class="browser-default " id="region_work" onselect="this.className = ''" name="region_work" onchange="cargarComunasWork();">
                                <option>Seleccione región</option>
                                <?php 
                                    // Recorremos el JSON buscando los valores asociados a las regiones existentes
                                    foreach($regiones['regiones'] as $region) {
                                        echo "<option value='" . $region['region'] . "' " . ($region['region']==$result['comunas'][0]['region']?"selected":"") . ">" . $region['region'] . "</option>\n";
                                    }
                                ?>
                            </select>
                        </div>
                        <script language="Javascript">
                            function cargarComunasWork() {
                                var comunas = {
                                    <?php
                                        // Creamos un arreglo asociativo dinámico que llene las comunas en función de la región seleccionada
                                        $i = 1;
                                        $j = 0;
                                        foreach($regiones['regiones'] as $region) {
                                            echo "region" . $i . " : [";
                                            natsort($region['comunas']);
                                            $k = 1;
                                            foreach($region['comunas'] as $comuna) {
                                                echo "\"" . $comuna . "\", ";
                                                if ($comuna == $result['comunas'][0]['comuna']) {
                                                    $j = $k;
                                                }
                                                $k++;
                                            }
                                            echo "\"\"],\n";
                                            $i++;
                                        }
                                    ?>
                                };

                                var campoRegion = document.getElementById('region_work');
                                var campoComuna = document.getElementById('comuna_work');
                                regionSeleccionada = campoRegion.selectedIndex;
                                campoComuna.innerHTML = '<option>Selecciona comuna</option>';

                                if (regionSeleccionada != "") {
                                    regionSeleccionada = comunas["region" + regionSeleccionada];
                                    regionSeleccionada.forEach(function (comuna) {
                                        var opcion = document.createElement('option');
                                        opcion.value = comuna;
                                        opcion.text = comuna;
                                        campoComuna.add(opcion);
                                    });
                                }

                                campoComuna.selectedIndex = <?php echo $j; ?>;
                            }
                        </script>
                        <div class=" input-field col s4 m4 l4">Comuna
                            <select class=" browser-default" id="comuna_work" onselect="this.className = ''" name="comuna_work">
                            </select>
                        </div>
                    </div>
                    <script language="Javascript">
                        cargarComunasWork();
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
                            <?php
                                $dias_array = false;
                                if (count($result["horarios"])>=1) {
                                    $dias_array = explode(",", $result["horarios"][0]["dias"]);
                                }
                            ?>
                                <div class="row">
                                    <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                                        <select class="js-example-basic-multiple" id="dias" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                                            <option value="Todos" <?php echo ($dias_array && array_search( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                                            <option value="Lunes" <?php echo ($dias_array && array_search( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                                            <option value="Martes" <?php echo ($dias_array && array_search( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                                            <option value="Miercoles" <?php echo ($dias_array && array_search( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                                            <option value="Jueves" <?php echo ($dias_array && array_search( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                                            <option value="Viernes" <?php echo ($dias_array && array_search( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                                            <option value="Sabado" <?php echo ($dias_array && array_search( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                                            <option value="Domingo" <?php echo ($dias_array && array_search( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Horario Desde
                                        <select class="js-example-basic-multiple" id="id_label_multiple" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="1:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                                            <option value="2:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                                            <option value="3:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                                            <option value="4:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                                            <option value="5:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                                            <option value="6:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                                            <option value="7:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                                            <option value="8:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                                            <option value="9:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                                            <option value="10:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                                            <option value="11:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                                            <option value="12:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Hasta
                                        <select class="js-example-basic-multiple" id="id_label_multiple1" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="13:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                                            <option value="14:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                                            <option value="15:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                                            <option value="16:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                                            <option value="17:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                                            <option value="18:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                                            <option value="19:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                                            <option value="20:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                                            <option value="21:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                                            <option value="22:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                                            <option value="23:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                                            <option value="24:00" <?php echo (count($result[ "horarios"])>=1 && substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
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
                            <?php
                                $dias_array = false;
                                if (count($result["horarios"])>=2) {
                                    $dias_array = explode(",", $result["horarios"][1]["dias"]);
                                }
                            ?>
                                <div class="row">
                                    <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                                        <select class="js-example-basic-multiple" id="dias2" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                                            <option value="Todos" <?php echo ($dias_array && array_search( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                                            <option value="Lunes" <?php echo ($dias_array && array_search( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                                            <option value="Martes" <?php echo ($dias_array && array_search( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                                            <option value="Miercoles" <?php echo ($dias_array && array_search( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                                            <option value="Jueves" <?php echo ($dias_array && array_search( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                                            <option value="Viernes" <?php echo ($dias_array && array_search( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                                            <option value="Sabado" <?php echo ($dias_array && array_search( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                                            <option value="Domingo" <?php echo ($dias_array && array_search( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Horario Desde
                                        <select class="js-example-basic-multiple" id="id_label_multiple2" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="1:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                                            <option value="2:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                                            <option value="3:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                                            <option value="4:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                                            <option value="5:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                                            <option value="6:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                                            <option value="7:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                                            <option value="8:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                                            <option value="9:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                                            <option value="10:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                                            <option value="11:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                                            <option value="12:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Hasta
                                        <select class="js-example-basic-multiple" id="id_label_multiple12" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="13:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                                            <option value="14:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                                            <option value="15:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                                            <option value="16:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                                            <option value="17:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                                            <option value="18:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                                            <option value="19:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                                            <option value="20:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                                            <option value="21:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                                            <option value="22:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                                            <option value="23:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                                            <option value="24:00" <?php echo (count($result[ "horarios"])>=2 && substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
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
                            <?php
                                $dias_array = false;
                                if (count($result["horarios"])>=3) {
                                $dias_array = explode(",", $result["horarios"][2]["dias"]);
                                }
                            ?>
                                <div class="row">
                                    <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                                        <select class="js-example-basic-multiple" id="dias3" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                                            <option value="Todos" <?php echo ($dias_array && array_search( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                                            <option value="Lunes" <?php echo ($dias_array && array_search( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                                            <option value="Martes" <?php echo ($dias_array && array_search( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                                            <option value="Miercoles" <?php echo ($dias_array && array_search( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                                            <option value="Jueves" <?php echo ($dias_array && array_search( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                                            <option value="Viernes" <?php echo ($dias_array && array_search( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                                            <option value="Sabado" <?php echo ($dias_array && array_search( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                                            <option value="Domingo" <?php echo ($dias_array && array_search( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Horario Desde
                                        <select class="js-example-basic-multiple" id="id_label_multiple3" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="1:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                                            <option value="2:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                                            <option value="3:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                                            <option value="4:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                                            <option value="5:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                                            <option value="6:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                                            <option value="7:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                                            <option value="8:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                                            <option value="9:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                                            <option value="10:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                                            <option value="11:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                                            <option value="12:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Hasta
                                        <select class="js-example-basic-multiple" id="id_label_multiple13" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="13:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                                            <option value="14:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                                            <option value="15:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                                            <option value="16:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                                            <option value="17:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                                            <option value="18:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                                            <option value="19:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                                            <option value="20:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                                            <option value="21:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                                            <option value="22:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                                            <option value="23:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                                            <option value="24:00" <?php echo (count($result[ "horarios"])>=3 && substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
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
                            <?php
                                $dias_array = false;
                                if (count($result["horarios"])>=4) {
                                    $dias_array = explode(",", $result["horarios"][3]["dias"]);
                                }
                            ?>
                                <div class="row">
                                    <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                                        <select class="js-example-basic-multiple" id="dias4" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                                            <option value="Todos" <?php echo ($dias_array && array_search( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                                            <option value="Lunes" <?php echo ($dias_array && array_search( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                                            <option value="Martes" <?php echo ($dias_array && array_search( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                                            <option value="Miercoles" <?php echo ($dias_array && array_search( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                                            <option value="Jueves" <?php echo ($dias_array && array_search( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                                            <option value="Viernes" <?php echo ($dias_array && array_search( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                                            <option value="Sabado" <?php echo ($dias_array && array_search( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                                            <option value="Domingo" <?php echo ($dias_array && array_search( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Horario Desde
                                        <select class="js-example-basic-multiple" id="id_label_multiple4" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="1:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                                            <option value="2:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                                            <option value="3:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                                            <option value="4:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                                            <option value="5:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                                            <option value="6:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                                            <option value="7:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                                            <option value="8:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                                            <option value="9:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                                            <option value="10:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                                            <option value="11:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                                            <option value="12:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Hasta
                                        <select class="js-example-basic-multiple" id="id_label_multiple14" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="13:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                                            <option value="14:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                                            <option value="15:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                                            <option value="16:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                                            <option value="17:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                                            <option value="18:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                                            <option value="19:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                                            <option value="20:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                                            <option value="21:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                                            <option value="22:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                                            <option value="23:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                                            <option value="24:00" <?php echo (count($result[ "horarios"])>=4 && substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
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
                            <?php
                                $dias_array = false;
                                if (count($result["horarios"])>=5) {
                                    $dias_array = explode(",", $result["horarios"][4]["dias"]);
                                }
                            ?>
                                <div class="row">
                                    <div class=" input-field col s5 m5 l5">Dias disponibles para trabajar
                                        <select class="js-example-basic-multiple" id="dias5" multiple="multiple" style="width:60%" onChange="changeStatus(this);">
                                            <option value="Todos" <?php echo ($dias_array && array_search( 'Todos', $dias_array)? "selected": ""); ?>>Todos</option>
                                            <option value="Lunes" <?php echo ($dias_array && array_search( 'Lunes', $dias_array)? "selected": ""); ?>>Lunes</option>
                                            <option value="Martes" <?php echo ($dias_array && array_search( 'Martes', $dias_array)? "selected": ""); ?>>Martes</option>
                                            <option value="Miercoles" <?php echo ($dias_array && array_search( 'Miercoles', $dias_array)? "selected": ""); ?>>Miercoles</option>
                                            <option value="Jueves" <?php echo ($dias_array && array_search( 'Jueves', $dias_array)? "selected": ""); ?>>Jueves</option>
                                            <option value="Viernes" <?php echo ($dias_array && array_search( 'Viernes', $dias_array)? "selected": ""); ?>>Viernes</option>
                                            <option value="Sabado" <?php echo ($dias_array && array_search( 'Sabado', $dias_array)? "selected": ""); ?>>Sabado</option>
                                            <option value="Domingo" <?php echo ($dias_array && array_search( 'Domingo', $dias_array)? "selected": ""); ?>>Domingo</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Horario Desde
                                        <select class="js-example-basic-multiple" id="id_label_multiple5" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="1:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="1:00"?"selected":""); ?>>1:00</option>
                                            <option value="2:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="2:00"?"selected":""); ?>>2:00</option>
                                            <option value="3:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="3:00"?"selected":""); ?>>3:00</option>
                                            <option value="4:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="4:00"?"selected":""); ?>>4:00</option>
                                            <option value="5:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="5:00"?"selected":""); ?>>5:00</option>
                                            <option value="6:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="6:00"?"selected":""); ?>>6:00</option>
                                            <option value="7:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="7:00"?"selected":""); ?>>7:00</option>
                                            <option value="8:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="8:00"?"selected":""); ?>>8:00</option>
                                            <option value="9:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="9:00"?"selected":""); ?>>9:00</option>
                                            <option value="10:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="10:00"?"selected":""); ?>>10:00</option>
                                            <option value="11:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="11:00"?"selected":""); ?>>11:00</option>
                                            <option value="12:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"],'a')-1)=="12:00"?"selected":""); ?>>12:00</option>
                                        </select>
                                    </div>
                                    <div class=" input-field col s2 m2 l2">Hasta
                                        <select class="js-example-basic-multiple" id="id_label_multiple15" style="width:60%">
                                            <option value="">Obligatorio</option>
                                            <option value="13:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="13:00"?"selected":""); ?>>13:00</option>
                                            <option value="14:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="14:00"?"selected":""); ?>>14:00</option>
                                            <option value="15:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="15:00"?"selected":""); ?>>15:00</option>
                                            <option value="16:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="16:00"?"selected":""); ?>>16:00</option>
                                            <option value="17:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="17:00"?"selected":""); ?>>17:00</option>
                                            <option value="18:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="18:00"?"selected":""); ?>>18:00</option>
                                            <option value="19:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="19:00"?"selected":""); ?>>19:00</option>
                                            <option value="20:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="20:00"?"selected":""); ?>>20:00</option>
                                            <option value="21:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="21:00"?"selected":""); ?>>21:00</option>
                                            <option value="22:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="22:00"?"selected":""); ?>>22:00</option>
                                            <option value="23:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="23:00"?"selected":""); ?>>23:00</option>
                                            <option value="24:00" <?php echo (count($result[ "horarios"])>=5 && substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"],'a')+2)=="24:00"?"selected":""); ?>>24:00</option>
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
                        <div class="col s12 m12 l12  boxsmart">
                            <div id="containerDataHoras">
                                <div class="boxSmartContent" id="dias1Box">
                                    <div class="col s4 m4 l4">
                                        <span style="font-size: 20px" id="diasData1">
                                            <?php echo (count($result["horarios"])>=1?$result["horarios"][0]["dias"]:""); ?>
                                        </span>
                                    </div>
                                    <div class="col s5 m5 l5">
                                        <span style="font-size: 20px" id="comunasData1"></span>
                                    </div>
                                    <div class="col s2 m2 l2 right-align">
                                        <span style="font-size: 20px" class="right-align">
                                            <span id="horasData1">
                                                <?php echo (count($result["horarios"])>=1?substr($result["horarios"][0]["horarios"], 0, strpos($result["horarios"][0]["horarios"], 'a')-1):""); ?>
                                            </span>
                                            <span>a</span>
                                            <span id="horasData1h">
                                                <?php echo (count($result["horarios"])>=1?substr($result["horarios"][0]["horarios"], strpos($result["horarios"][0]["horarios"], 'a')+2):""); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col s1 m1 l1 right-align">
                                        <div onclick="myFunctionEliminarHora1()" class="waves-effect" id="btn-hora-hora1">
                                            <i class="small material-icons" style="color: red">cancel</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxSmartContent" id="dias2Box">
                                    <div class="col s4 m4 l4">
                                        <span style="font-size: 20px" id="diasData2">
                                            <?php echo (count($result["horarios"])>=2?$result["horarios"][1]["dias"]:""); ?>
                                        </span>
                                    </div>
                                    <div class="col s5 m5 l5">
                                        <span style="font-size: 20px" id="comunasData2"></span>
                                    </div>
                                    <div class="col s2 m2 l2 right-align">
                                        <span style="font-size: 20px" class="right-align">
                                            <span id="horasData2">
                                                <?php echo (count($result["horarios"])>=2?substr($result["horarios"][1]["horarios"], 0, strpos($result["horarios"][1]["horarios"], 'a')-1):""); ?>
                                            </span>
                                            <span>a</span>
                                            <span id="horasData2h">
                                                <?php echo (count($result["horarios"])>=2?substr($result["horarios"][1]["horarios"], strpos($result["horarios"][1]["horarios"], 'a')+2):""); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col s1 m1 l1 right-align">
                                        <div onclick="myFunctionEliminarHora2()" class="waves-effect" id="btn-hora-hora2">
                                            <i class="small material-icons" style="color: red">cancel</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxSmartContent" id="dias3Box">
                                    <div class="col s4 m4 l4">
                                        <span style=" font-size: 20px" id="diasData3">
                                            <?php echo (count($result["horarios"])>=3?$result["horarios"][2]["dias"]:""); ?>
                                        </span>
                                    </div>
                                    <div class="col s5 m5 l5">
                                        <span style=" font-size: 20px" id="comunasData3"></span>
                                    </div>
                                    <div class="col s2 m2 l2 right-align">
                                        <span style=" font-size: 20px" class="right-align">
                                            <span id="horasData3">
                                                <?php echo (count($result["horarios"])>=3?substr($result["horarios"][2]["horarios"], 0, strpos($result["horarios"][2]["horarios"], 'a')-1):""); ?>
                                            </span>
                                            <span>a</span>
                                            <span id="horasData3h">
                                                <?php echo (count($result["horarios"])>=3?substr($result["horarios"][2]["horarios"], strpos($result["horarios"][2]["horarios"], 'a')+2):""); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col s1 m1 l1 right-align">
                                        <div onclick="myFunctionEliminarHora3()" class="waves-effect" id="btn-hora-hora3">
                                            <i class="small material-icons" style="color: red">cancel</i>
                                        </div>
                                    </div>
                                </div>
                                <div class="boxSmartContent" id="dias4Box">
                                    <div class="col s4 m4 l4">
                                        <span style=" font-size: 20px" id="diasData4">
                                            <?php echo (count($result["horarios"])>=4?$result["horarios"][3]["dias"]:""); ?>
                                        </span>
                                    </div>
                                    <div class="col s5 m5 l5">
                                        <span style=" font-size: 20px" id="comunasData4"></span>
                                    </div>
                                    <div class="col s2 m2 l2 right-align">
                                        <span style=" font-size: 20px" class="right-align">
                                            <span id="horasData4">
                                                <?php echo (count($result["horarios"])>=4?substr($result["horarios"][3]["horarios"], 0, strpos($result["horarios"][3]["horarios"], 'a')-1):""); ?>
                                            </span>
                                            <span>a</span>
                                            <span id="horasData4h">
                                                <?php echo (count($result["horarios"])>=4?substr($result["horarios"][3]["horarios"], strpos($result["horarios"][3]["horarios"], 'a')+2):""); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col s1 m1 l1 right-align">
                                        <div onclick="myFunctionEliminarHora4()" class="waves-effect" id="btn-hora-hora4">
                                            <i class="small material-icons" style="color: red">cancel</i>
                                        </div>
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
                                        <span style=" font-size: 20px" class="right-align">
                                            <span id="horasData5">
                                                <?php echo (count($result["horarios"])>=5?substr($result["horarios"][4]["horarios"], 0, strpos($result["horarios"][4]["horarios"], 'a')-1):""); ?>
                                            </span>
                                            <span>a</span>
                                            <span id="horasData5h">
                                                <?php echo (count($result["horarios"])>=5?substr($result["horarios"][4]["horarios"], strpos($result["horarios"][4]["horarios"], 'a')+2):""); ?>
                                            </span>
                                        </span>
                                    </div>
                                    <div class="col s1 m1 l1 right-align">
                                        <div onclick="myFunctionEliminarHora5()" class="waves-effect" id="btn-hora-hora5">
                                            <i class="small material-icons" style="color: red">cancel</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="row"></div>
                    <div class="divider"></div>
                    <!-- _____________________________________________________DATOS UNIFORME_______________________________________ -->

                    <div class="row">
                        <div class="col s8 m8 l8">
                            <h4>Datos Uniforme</h4>
                        </div>
                    </div>

                    <div class="row">
                        <div class="tab" id="uniforme">
                            <div class="tab input-field col s4 m4 l4">
                                <select class="browser-default" onselect="this.className = ' ' " name="uniforme">
                                    <option value="">Talla Polera/camisa</option>
                                    <option value="XS" <?php echo ($result[ "tpolera"]=='XS' ? "selected": ""); ?>>XS</option>
                                    <option value="S" <?php echo ($result[ "tpolera"]=='S' ? "selected": ""); ?>>S</option>
                                    <option value="M" <?php echo ($result[ "tpolera"]=='M' ? "selected": ""); ?>>M</option>
                                    <option value="L" <?php echo ($result[ "tpolera"]=='L' ? "selected": ""); ?>>L</option>
                                    <option value="XL" <?php echo ($result[ "tpolera"]=='XL' ? "selected": ""); ?>>XL</option>
                                    <option value="XXL" <?php echo ($result[ "tpolera"]=='XXL' ? "selected": ""); ?>>XXL</option>
                                </select>
                            </div>
                            <div class="tab input-field col s4 m4 l4">
                                <select class="browser-default" onselect="this.className = ' ' " name="uniforme2">
                                    <option value="">Talla Poleron</option>
                                    <option value="XS" <?php echo ($result[ "tpoleron"]=='XS' ? "selected": ""); ?>>XS</option>
                                    <option value="S" <?php echo ($result[ "tpoleron"]=='S' ? "selected": ""); ?>>S</option>
                                    <option value="M" <?php echo ($result[ "tpoleron"]=='M' ? "selected": ""); ?>>M</option>
                                    <option value="L" <?php echo ($result[ "tpoleron"]=='L' ? "selected": ""); ?>>L</option>
                                    <option value="XL" <?php echo ($result[ "tpoleron"]=='XL' ? "selected": ""); ?>>XL</option>
                                    <option value="XXL" <?php echo ($result[ "tpoleron"]=='XXL' ? "selected": ""); ?>>XXL</option>
                                </select>
                            </div>
                            <div class="tab input-field col s4 m4 l4">
                                <label for="tallaZapato">Talla de zapatos</label>
                                <input id="tallaZapato" type="text" class="validate" value="<?php echo $result["tzapatos"]; ?>">
                            </div>
                            <div class="row">
                                <div class="tab input-field col s8 m8 l8">
                                    <label for="tallaPantalon">Talla de Pantalon (ingrese detalles si necesita)</label>
                                    <input id="tallaPantalon" type="text" class="validate" value="<?php echo $result["tpantalon"]; ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h4>Pretensiones de Renta</h4>
                        <div class="row">
                            <div class="tab">
                                <div class="tab input-field col s4 m4 l4">
                                    <select class="browser-default" onselect="this.className = ' ' " name="renta">
                                        <option value="">Seleccione Rango</option>
                                        <option value="275.000 - 350.000" <?php echo ($result[ "renta"]=='275.000 - 350.000' ? "selected": ""); ?>>275.000 - 350.000</option>
                                        <option value="350.000 - 400.000" <?php echo ($result[ "renta"]=='350.000 - 400.000' ? "selected": ""); ?>>350.000 - 400.000</option>
                                        <option value="400.000 - 450.000" <?php echo ($result[ "renta"]=='400.000 - 450.000' ? "selected": ""); ?>>400.000 - 450.000</option>
                                        <option value="450.000 - 500.000" <?php echo ($result[ "renta"]=='450.000 - 500.000' ? "selected": ""); ?>>450.000 - 500.000</option>
                                        <option value="500.000 - 550.000" <?php echo ($result[ "renta"]=='500.000 - 550.000' ? "selected": ""); ?>>500.000 - 550.000</option>
                                        <option value="550.000 - 600.000" <?php echo ($result[ "renta"]=='550.000 - 600.000' ? "selected": ""); ?>>550.000 - 600.000</option>
                                        <option value="600.000 - 800.000" <?php echo ($result[ "renta"]=='600.000 - 800.000' ? "selected": ""); ?>>600.000 - 800.000</option>
                                        <option value="800.000 - 1.000.000" <?php echo ($result[ "renta"]=='800.000 - 1.000.000' ? "selected": ""); ?>>800.000 - 1.000.000</option>
                                        <option value="Más de 1.000.000" <?php echo ($result[ "renta"]=='Mas de 1.000.000' ? "selected": ""); ?>>Más de 1.000.000</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            <!----- SECCION DE ARCHIVOS ADJUNTOS ----->
            
            <div class="row">
                <h4>Adjuntos (Opcional)</h4>
                <?php
                    require_once("db.php");
                    $files = null;
                    $sql = "SELECT id, tipo_archivo, nombre FROM tbl_archivo WHERE id_post = '" . $id . "' AND estado = 1";
                    $results = $conn->query($sql);
                    if ($results) {
                        while($fila = $results->fetch_assoc()) {
                            $files[$fila["tipo_archivo"]]["id"] = $fila["id"];
                            $files[$fila["tipo_archivo"]]["nombre"] = $fila["nombre"];
                        }
                    }
                ?>
                <div class="row">

                    <div class="row">
                        <div class="col s6 m6 l6">
                            <label>
                                Curriculum
                                (<?php echo ($files!=null && array_key_exists("cv", $files)?"<a href=\"download.php?identificador=" . $files["cv"]["id"] . "&tipo=cv\" target=\"blank\">" . $files["cv"]["nombre"] . "</a>":"Ninguno"); ?>)
                            </label>
                            <div class="file-field input-field">
                                <div class="btn-flat">                                            
                                    <input type="file" id="cv" name="curriculum">
                                </div>
                                <div class="file-path-wrapper">
                                    <i style="right: 0!important; left: auto;" id="remove-cv" onclick="removeCvPath()" class="material-icons btn-flat prefix">cancel</i>
                                    <!-- este es el btn de remover -->
                                    <input style="width: 80%" class="file-path validate" id="cv-path" type="text" placeholder="Descargar Archivo">
                                </div>
                            </div>
                        </div>
                        <div class="col s6 m6 l6">
                            <label>
                                Certificado de antecedentes
                                (<?php echo ($files!=null && array_key_exists("cerAntecedentes", $files)?"<a href=\"download.php?identificador=" . $files["cerAntecedentes"]["id"] . "&tipo=antecedentes\" target=\"blank\">" . $files["cerAntecedentes"]["nombre"] . "</a>":"Ninguno"); ?>)
                            </label>
                            <div class="file-field input-field">
                                <div class="btn-flat">
                                        <input type="file" id="cerAntecedentes" name="antecedentes">
                                </div>
                                <div class="file-path-wrapper">
                                    <i style="right: 0;left: auto" id="remove-antecedentes" onclick="removeAntecedentesPath()" class="material-icons btn-flat prefix">cancel</i>
                                    <!-- este es el btn de remover -->
                                    <input style="width: 80%" id="antecedentes-path" class="file-path validate" type="text" placeholder="Descargar Archivo">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col s6 m6 l6">
                            <label>
                                Carnet o Pasaporte
                                (<?php echo ($files!=null && array_key_exists("carnet", $files)?"<a href=\"download.php?identificador=" . $files["carnet"]["id"] . "&tipo=carnet\" target=\"blank\">" . $files["carnet"]["nombre"] . "</a>":"Ninguno"); ?>)
                            </label>
                            <div class="file-field input-field">
                                <div class="btn-flat">                                           
                                    <input type="file" id="docIdentidad" name="docIdentidad">
                                </div>
                                <div class="file-path-wrapper">
                                    <i style="right: 0;left: auto;" id="remove-id" onclick="removeIdPath()" class="material-icons btn-flat prefix">cancel</i>
                                    <!-- este es el btn de remover -->
                                    <input style="width: 80%" id="id-path" class="file-path validate" type="text" placeholder="Descargar Archivo">

                                </div>
                            </div>
                        </div>
                        <div class="col s6 m6 l6">
                            <label>
                                Fotografía del o la Postulante
                                (<?php echo ($files!=null && array_key_exists("fotografia", $files)?"<a href=\"download.php?identificador=" . $files["fotografia"]["id"] . "&tipo=fotografia\" target=\"blank\">" . $files["fotografia"]["nombre"] . "</a>":"Ninguno"); ?>)
                            </label>
                            <div class="file-field input-field">
                                <div class="btn-flat">                                            
                                    <input type="file" id="fotografia" name="fotografia">
                                </div>
                                <div class="file-path-wrapper">
                                    <i style="right: 0;left: auto" id="remove-picture" onclick="removePicturePath()" class="material-icons btn-flat prefix">cancel</i>
                                    <!-- este es el btn de remover -->
                                    <input style="width: 80%" id="picture-path" class="file-path validate" type="text" placeholder="Descargar Archivo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <div class="divider"></div>

            <!-- -----------------------------------------------BOTONES FINAL --------------------------------- -->
            <div class="row">
                <form method="POST" action="process_editar.php" id="print-edit">
                    <input type="hidden" name="identificador" value="<?= $id ?>" />
                    <input type="hidden" name="postulacion" value="<?= $postula ?>" />
                    <input type="hidden" name="pagina" value="actualizar_estado" />
                    <div class="">
                        <p>Clasificar</p>
                        <div class="clasificar col s4 m4 l4 left-align">
                            <p>
                                <label for="sinClasificar2">
                                    <input value="Sin Clasificar" id="sinClasificar2" class="with-gap" name="group1" type="radio" <?php if($result[ 'estado']=='Sin Clasificar'
                                        ) echo "checked='checked'"; else "";?>/>
                                    <span>
                                        <span class="badge yellow sinClasificar"> Sin Clasificar</span>
                                    </span>
                                </label>
                            </p>
                            <p>
                                <label for="apto2">
                                    <input value="Apto" id="apto2" class="with-gap" name="group1" type="radio" <?php if($result[ 'estado']=='Seleccionado' ) echo
                                        "checked='checked'"; else "";?>/>
                                    <span>
                                        <span class="badge green sinClasificar">Apto</span>
                                    </span>
                                </label>
                            </p>
                            <p>
                                <label for="fueraRango2">
                                    <input value="Fuera Rango Renta" id="fueraRango2" class="with-gap" name="group1" type="radio" <?php if($result[ 'estado']=='Fuera Rango Renta'
                                        ) echo "checked='checked'"; else "";?>/>
                                    <span>
                                        <span class="badge orange sinClasificar"> Fuera Rango Renta</span>
                                    </span>
                                </label>
                            </p>
                            <p>
                                <label for="noApto2">
                                    <input value="No Apto" id="noApto2" class="with-gap" name="group1" type="radio" <?php if($result[ 'estado']=='No Apto' )
                                        echo "checked='checked'"; else "";?>/>
                                    <span>
                                        <span class="badge grey sinClasificar">No Apto</span>
                                    </span>
                                </label>
                            </p>
                        </div>
                        <div class="col s4 m4 l4">
                            <p class="left-align">Observación</p>
                            <div class="input-field">
                                <textarea id="textarea1" name="observacion" class="browser-default"><?php echo $result['observacion']?></textarea>
                                <label for="textarea1"></label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col s3 m3 l3">
                                <a href="#!" class=" waves-effect waves-green btn-flat borrar">Eliminar</a>
                            </div>
                            <div class="col s3 m3 l3">
                                <button class="waves-effect waves-green btn save" type="submit" href="userportia.html.php">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--container-->
        <div class="row">
            <div class="col s12 m12 l12">
                <img src="src/img/logo.jpg" alt="" class="endLogo">
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44="
            crossorigin="anonymous"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
        <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
        <!-- script src="src/js/postulaciones.js"></script -->
        <script language="Javascript">
            <?php
    $error = $_POST['mensaje'];
    if($error <> null) { }
?>
            // RUT/Pasaporte
            if ($('#documento').val() == 'rut') {
                $('#rut_box').show();
                $('#pasaporte_box').hide();
            } else {
                $('#pasaporte_box').show();
                $('#rut_box').hide();
            }

            // Estudios
            if ($('#tipoEstudio').val() == 'Secundario') {
                $('.carreraBox').hide();
            } else {
                $('.carreraBox').show();
            }
            if ($('#estado_estudio').val() == 'En Curso') {
                $('#box_estudio').hide();
                $("#fechaEstudio").prop("checked", true);
            } else {
                $('#box_estudio').show();
                $("#fechaEstudio").prop("checked", false);
            }

            // Otros Conocimientos
            $('#curso1before').show();
            $('#btn-send-curso1').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=1?"hide()":"show()"); ?>;
            $('#btn-delete-curso1').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=1?"show()":"hide()"); ?>;
            $('#curso2before').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=2?"show()":"hide()"); ?>;
            $('#btn-send-curso2').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=2?"hide()":"show()"); ?>;
            $('#btn-delete-curso2').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=2?"show()":"hide()"); ?>;
            $('#curso3before').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=3?"show()":"hide()"); ?>;
            $('#btn-send-curso3').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=3?"hide()":"show()"); ?>;
            $('#btn-delete-curso3').
            <?php echo (array_key_exists("cursos", $result) && count($result["cursos"])>=3?"show()":"hide()"); ?>;

            // Experiencia Laboral
            $('#boxDataExp1').
            <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=1?"show()":"hide()"); ?>;
            $('#boxDataExp2').
            <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=2?"show()":"hide()"); ?>;
            $('#boxDataExp3').
            <?php echo (array_key_exists("experiencia", $result) && count($result["experiencia"])>=3?"show()":"hide()"); ?>;

            // Referencias
            $('#refs_box1').
            <?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=1?"show()":"hide()"); ?>;
            $('#refs_box2').
            <?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=2?"show()":"hide()"); ?>;
            $('#refs_box3').
            <?php echo (array_key_exists("referencias", $result) && count($result["referencias"])>=3?"show()":"hide()"); ?>;

            // Horarios Disponibles
            var containerHoras = $('#containerInputHoras');
            var inputDiaHora1 = $('#inputDiaHora');
            var boxData1 = $('#dias1Box');
            $(boxData1).
            <?php echo (count($result["horarios"])>=1?"show()":"hide()") ?>;
            $(inputDiaHora1).
            <?php echo (count($result["horarios"])==0?"show()":"hide()") ?>;
            var inputDiaHora2 = $('#inputDiaHora2');
            var boxData2 = $('#dias2Box');
            $(boxData2).
            <?php echo (count($result["horarios"])>=2?"show()":"hide()") ?>;
            $(inputDiaHora2).
            <?php echo (count($result["horarios"])==1?"show()":"hide()") ?>;
            var inputDiaHora3 = $('#inputDiaHora3');
            var boxData3 = $('#dias3Box');
            $(boxData3).
            <?php echo (count($result["horarios"])>=3?"show()":"hide()") ?>;
            $(inputDiaHora3).
            <?php echo (count($result["horarios"])==2?"show()":"hide()") ?>;
            var inputDiaHora4 = $('#inputDiaHora4');
            var boxData4 = $('#dias4Box');
            $(boxData4).
            <?php echo (count($result["horarios"])>=4?"show()":"hide()") ?>;
            $(inputDiaHora4).
            <?php echo (count($result["horarios"])==3?"show()":"hide()") ?>;
            var inputDiaHora5 = $('#inputDiaHora5');
            var boxData5 = $('#dias5Box');
            $(boxData5).
            <?php echo (count($result["horarios"])>=5?"show()":"hide()") ?>;
            $(inputDiaHora5).
            <?php echo (count($result["horarios"])==4?"show()":"hide()") ?>;
        </script>
        <script language="Javascript">
        <?php if (isset($_SESSION["mode"])) { ?>
            notie.alert({ type: 1, text: 'Modo desarrollador activado', position: 'bottom' });
        <?php } ?>
        </script>
    </body>
</html>