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
        <select class="browser-default"  id="categoria" onselect="this.className = ''" name="Categoria">
              <option value="">Categoria</option>
              <option value="Sin Clasificar">Sin Clasificar</option>
              <option value="Apto">Apto</option>
              <option value="Fuera Rango Renta">Fuera Rango Renta</option>
              <option value="No Apto">No Apto</option>
            </select>
       </div>
       <div class="col s2 m2 l2 input-field empresa">
        <select class="browser-default"  id="cargo" onselect="this.className = ''" name="cargo">
              <option value="">cargo</option>
              <!-- INSERTAR AQUI API DE LAS POSTULACIONES -->
            </select>
       </div>
       <div class="col s2 m2 l2  input-field fecha">
           <label for="txtDate5">Desde</label>
              <input type="text" class="datepicker" id="txtDate5">
        </div>
       <div class="col s2 m2 l2 input-field fecha">
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
        <div class="col s12 empresa">
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
                <li class="tab col s2"><a href="#test6"><span class="badge yellow"><?php echo isset($postulacion_por_tipo[ 'Sin Clasificar' ])? $postulacion_por_tipo[ 'Sin Clasificar' ]: 0 ?></span>Sin Clasificar</a></li>
                <li class="tab col s2"><a href="#test1"><span class="badge teal"><?php echo isset($postulacion_por_tipo[ 'total' ])? $postulacion_por_tipo[ 'total' ]: 0 ?></span>Postulaciones</a></li>
                <li class="tab col s2"><a href="#test2"><span class="badge green"><?php echo isset($postulacion_por_tipo[ 'Apto' ])? $postulacion_por_tipo[ 'Apto' ]: 0 ?></span>Seleccionadas Aptas</a></li>
                <li class="tab col s2"><a href="#test4"><span class="badge orange"><?php echo isset($postulacion_por_tipo[ 'Fuera Rango Renta' ])? $postulacion_por_tipo[ 'Fuera Rango Renta' ]: 0 ?></span>Fuera Rango Renta</a></li>
                <li class="tab col s2"><a href="#test3"><span class="badge grey"><?php echo isset($postulacion_por_tipo[ 'No apto' ])? $postulacion_por_tipo[ 'No apto' ]: 0 ?></span>No Aptos</a></li>
                <li class="tab col s2"><a href="#test5"><span class="badge red"><?php echo isset($postulacion_por_tipo[ 'Eliminados' ])? $postulacion_por_tipo[ 'Eliminados' ]: 0 ?></span>Eliminados</a></li>
                
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
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Fecha de Nacimiento</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>Fecha</th>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Fecha de Nacimiento</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
</div><!--container-->

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.18/js/dataTables.jqueryui.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<script src="src/js/postulaciones.js"></script>
<script>
    $("#exportXml").click(function(){
        window.location.href="userportia.xls.php";
    });

    /*DATATABLES*/ 
    //$(document).ready(function() {
        $('#tablaPortia').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "datatables_script.php"
        } );
    //} );
</script>
</body>
</html>