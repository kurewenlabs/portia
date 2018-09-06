<?php
  session_start();

  if (!isset($_SESSION["active_user"])) {
    header("Location: adminportia.php?status=-1", true, 301);
    exit();
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
     <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.jqueryui.min.css">
    <link rel="stylesheet" href="dist/css/main.min.css">
    <!--REQUIRED STYLE SHEETS-->
</head>
<body>
<nav class="teal">
    <h6>Administracion Sistema de Postulación Portia</h6>
    <div class="col s4 m4 l4">
        <p></p>
    </div>
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
            <!-- select class="browser-default"  id="categoria" onselect="this.className = ''" name="Categoria">
                <option value="">Categoria</option>
                <option value="Sin Clasificar">Sin Clasificar</option>
                <option value="Apto">Apto</option>
                <option value="Fuera Rango Renta">Fuera Rango Renta</option>
                <option value="No Apto">No Apto</option>
            </select -->
        </div>
        <div class="col s2 m2 l2 input-field empresa">
            <!-- select class="browser-default"  id="cargo" onselect="this.className = ''" name="cargo">
                <option>Cargo</option>
            </select -->
        </div>
        <div class="col s2 m2 l2  input-field fecha">
            <!-- label for="txtDate5">Desde</label>
            <input type="text" class="datepicker" id="txtDate5" -->
        </div>
        <div class="col s2 m2 l2 input-field fecha">
            <!-- label for="txtDate5">Hasta</label>
            <input type="text" class="datepicker" id="txtDate5" -->
        </div>
        <div class="col s2 m2 l2">
            <!-- a href="" class="waves-effect waves-light btn-small consulta">Consultar</a -->
        </div>
    </div>
    <div class="row">
        <div class="col s8 empresa">
            <h4>Detalles de Postulaciones</h4>
        </div>
    </div>
    <div class="row">
        <div class="col s4 empresa">
            <a id="exportXml" class="waves-effect btn-flat exportar"><i class="tiny material-icons">data_usage</i>Exportar XLS</a>
        </div>
    </div>
    <?php

        require_once 'db.php';
        global $conn;

        $sql = "SELECT estado, count(id) as cuenta "
            . "FROM tbl_datos_postulacion_abierta "
            . "GROUP BY estado";

        $postulacion_por_tipo = array();
        $result1 = $conn->query($sql);

        if ($result1->num_rows > 0) {
            // output data of each row
            $total = 0;
            while($row2 = $result1->fetch_assoc()) {
                $postulacion_por_tipo[ $row2['estado'] ] = $row2['cuenta'];
                $total += $row2['cuenta'];
            }
            $postulacion_por_tipo[ 'total' ] = $total;
        }

    ?>
    <div class="row">
        <div class="col s12 lineaDatos1">
            <ul class="tabs">
                <li class="tab col s2"><a href="#test1" id="total"><span class="badge teal"><?php echo isset($postulacion_por_tipo[ 'total' ])? $postulacion_por_tipo[ 'total' ]-(isset($postulacion_por_tipo[ 'Eliminado' ])? $postulacion_por_tipo[ 'Eliminado' ]: 0): 0 ?></span>Todas</a></li>
                <li class="tab col s2"><a href="#test6" id="sin_clasificar"><span class="badge yellow"><?php echo isset($postulacion_por_tipo[ 'Sin Clasificar' ])? $postulacion_por_tipo[ 'Sin Clasificar' ]: 0 ?></span>Sin Clasificar</a></li>
                <li class="tab col s2"><a href="#test2" id="apto"><span class="badge green"><?php echo isset($postulacion_por_tipo[ 'Seleccionado' ])? $postulacion_por_tipo[ 'Seleccionado' ]: 0 ?></span>Aptos</a></li>
                <li class="tab col s2"><a href="#test4" id="fuera"><span class="badge orange"><?php echo isset($postulacion_por_tipo[ 'Fuera Rango Renta' ])? $postulacion_por_tipo[ 'Fuera Rango Renta' ]: 0 ?></span>Fuera Rango Renta</a></li>
                <li class="tab col s2"><a href="#test3" id="no_apto"><span class="badge blue"><?php echo isset($postulacion_por_tipo[ 'No apto' ])? $postulacion_por_tipo[ 'No apto' ]: 0 ?></span>No Aptos</a></li>
                <li class="tab col s2"><a href="#test5" id="eliminado"><span class="badge red"><?php echo isset($postulacion_por_tipo[ 'Eliminado' ])? $postulacion_por_tipo[ 'Eliminado' ]: 0 ?></span>Eliminados</a></li>
            </ul>
        </div>
    </div>
    <div class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" class="display">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nacionalidad</th>
                    <th>Cargo</th>
                    <th>Sexo</th>
                    <th>Renta</th>
                    <th>Estado</th>
                    <th>Región</th>
                    <th>Comuna</th>
                    <th>&nbsp;</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Nacionalidad</th>
                    <th>Cargo</th>
                    <th>Sexo</th>
                    <th>Renta</th>
                    <th>Estado</th>
                    <th>Región</th>
                    <th>Comuna</th>
                    <th>&nbsp;</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div><!--container-->

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.jqueryui.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js"></script>
<!-- script src="src/jquery.table2excel.js"></script -->
<script src="src/js/postulaciones.js"></script>
<script>
    $("#exportXml").click(function(){
        window.location.href="userportia.xls.php";
    });

    /*DATATABLES*/ 
    $(document).ready(function() {
        var $postulaciones = $('#tablaPortia');
        $postulaciones.DataTable( {
            "ajax": "datatables_script.php",
            "columnDefs": [
                {
                    "targets": 7,
                    "render": function ( data, type, row, meta ) {
                        var color = "yellow";
                        if (data == 'Seleccionado') color = "green";
                        if (data == 'Fuera Rango Renta') color = "orange";
                        if (data == 'No Apto') color = "blue";
                        if (data == 'Eliminado') color = "red";
                        return "<span class=\"badge " + color + "\">" + data + "</span>";
                    }
                },
                {
                    "targets": 10,
                    "render": function ( data, type, row, meta ) {
                        if (row[7] != 'Eliminado') {
                            return "<a href='adminedit.php?identificador=" + data + "&postulacion=" + row[4] + "'><i class=\"material-icons\">edit</i></a>" +
                                   "<a href='process_editar.php?identificador=" + data + "&postulacion=" + row[4] + "&pagina=eliminar_postulacion&group1=Eliminado' onClick='return confirm(\"¿Está seguro de eliminar la postulación?\");'><i class=\"material-icons\">close</i></a>";
                        }
                        return "<a href='process_editar.php?identificador=" + data + "&postulacion=" + row[4] + "&pagina=actualizar_estado&group1=Sin Clasificar' onClick='return confirm(\"¿Está seguro de volver está postulación a Sin Clasificar?\");'><i class=\"material-icons\">undo</i></a>";
                    }
                }
            ],
            "order": [[0, "desc"]],
            "scrollCollapse": true,
            "paging": true,
            "pageLength": 50,
            "select": true,  
            "language": {
                "decimal": ",",
                "thousands": ".",
                "emptyTable": "No hay postulaciones pendientes",
                "info": "_START_ a _END_ de _TOTAL_ postulaciones",
                "infoEmpty": "0 a 0 de 0 postulaciones",
                "infoFiltered": "(Filtrado de _MAX_ postulaciones)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "_MENU_ Postulaciones",
                "loadingRecords": "Preparando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron postulaciones",
                "paginate": {
                    "first": "Primera",
                    "last": "Última",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": Ascendente",
                    "sortDescending": ": Sescendente"
                }
            } 
        } );

        $("#total").click(function(){
            $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&mModif_7=NOT&sSearch_7=Eliminado').load();
        });

        $("#sin_clasificar").click(function(){
            $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&sSearch_7=Sin Clasificar').load();
        });

        $("#apto").click(function(){
            $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&sSearch_7=Seleccionado').load();
        });

        $("#fuera").click(function(){
            $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&sSearch_7=Fuera Rango Renta').load();
        });

        $("#no_apto").click(function(){
            $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&sSearch_7=No Apto').load();
        });

        $("#eliminado").click(function(){
            $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&sSearch_7=Eliminado').load();
        });

        $postulaciones.DataTable().ajax.url('datatables_script.php?bSearchable_7=true&mModif_7=NOT&sSearch_7=Eliminado').load();
    } );

</script>
<script language="Javascript">
<?php if (isset($_SESSION["mode"])) { ?>
    notie.alert({ type: 1, text: 'Modo desarrollador activado', position: 'bottom' });
<?php } ?>

<?php
    $error = $_GET['actualizado'];
    if (isset($error)) {
        if($error != null && $error == 'error1') { 
            ?>
            notie.alert({ type: 3, text: 'No se ha podido procesar la postulación', position: 'bottom' });
            <?php
        }
        else {
            ?>
            notie.alert({ type: 1, text: 'La postulación ha sido procesada correctamente', position: 'bottom' });
            <?php
        }
    }
?>
</script>
</body>
</html>