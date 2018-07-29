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
    <h3 class="center-align">Editar postulación</h3>
    <p class="center-align"> imprimir la fecha aqui</p>
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
            <a href="index.html" class="">Editar cargos</a>
        </div>
    </div>
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
                            <button class="waves-effect waves-green btn save" type="submit" href="userportia.html.php">Volver</a>Guardar</button>
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
