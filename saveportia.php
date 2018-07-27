<?php

require_once 'db.php';
global $conn;
$sql = "SELECT * FROM (SELECT * FROM kurewenc_db_portia.tbl_postulante) a
            LEFT JOIN
    (
        SELECT id_post,nombre 
        FROM  tbl_datos_postulacion_abierta
        -- LIMIT 0 , 1
    ) b ON a.id_post = b.id_post join tbl_documento c ON c.id_post=b.id_post where a.id_post='".$_GET['id_post']."'
LIMIT 1";
$result1 = $conn->query($sql);
$result = $result1->fetch_assoc();
//print_r($result);die;
?>

<h4>Editar Postulación</h4>
<p><?php echo $result['fecha_post'];?></p>                <!--  Imprimir la fecha del dia -->
<div class="row">
    <p class="left-align">Postulación</p>
    <div class="col s12 m12 l12 box2">
        <div class="col s6 m6 l6 left-align">
            <h6><?php echo $result['nombres']." ".$result['apellidop']?></h6> <!-- imprimir datos del postulante-->
            <p><?php echo $result['rut']?></p>
        </div>
        <div class="col s6 m6 l6 left-align">
            <h6 class="sueldo"><?php echo $result['renta']; ?></h6> <!-- imprimir renta del postulante-->
            <!--<a class="waves-effect btn-flat botonVista2" href="adminedit.html">ver detalle</a> -->
        </div>
    </div>
</div>

<div class="row">
    <div class="chip col s1 offset-s1" id="chip">
        <?php echo $result['nombre']?>
        <!--<i class="close material-icons">close</i>-->
    </div>
</div>
<div class="row">

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
                <input class="file-path validate" type="text" value="<?php echo $result['antecedentes']?>">
            </div>
        </div>
    </div>

</div>
<div class="row">
    <form method="POST" action="process_editar.php" id="print-edit">
        <input type="hidden" name="identificador" value="<?= $id ?>" />
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
                        <textarea id="textarea1" name="observacion" class="browser-default"></textarea>
                        <label for="textarea1"></label>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col s3 m3 l3">
                    <a href="#!" class=" waves-effect waves-green btn-flat borrar">Eliminar</a>
                </div>
                <div class="col s3 m3 l3">
                    <button class="waves-effect waves-green btn save" type="submit">Guardar</button>
                </div>
            </div>
    </form>
</div>