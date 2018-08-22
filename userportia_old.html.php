<?php
  session_start();
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
        function imprimir_fila_post($row){

            $fecha_post = date("d/m/Y", strtotime($row["fecha_post"]));

            $color='';
            if($row["estado"] == 'Apto'){
                $color='green';
            }else if($row["estado"] == 'Fuera Rango Renta'){
                $color='orange';
            }else if($row["estado"] == 'No apto'){
                $color='grey';
            }else{//Sin Clasificar
                $color='yellow';
            }

            $fila_post = '<tr>
                            <td> '.$fecha_post.'</td>
                            <td>'.$row["rut"].'</td>
                            <td> '.$row["nombres"].' '. $row["apellidop"].'</td>
                            <td>'.$row["nacionalidad"].'</td>
                            <td>'.$row["nombre"].'</td>
                            <td>'. $row["sexo"] .'</td>
                            <td>'.$row["renta"].'</td>
                            <td><span class="badge '.$color.'"></span><br/>'.$row["estado"].'</td>';

            $fila_post .= '<td>'. $row["provincia"] .'</td>
                            <td>'. $row["comuna"] .'</td>
                
                
                            <td>
                    <a class="waves-effect btn-flat btn-small" href="adminedit.php?identificador='. $row['id_post'] .'&postulacion=' . $row["nombre"] . '">Ver</a>
                    </td>';
            $fila_post .= '</tr>';

            return $fila_post;
        }

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
    <div id="test1" class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                
                <th>Cargo</th>
                <th>Sexo</th>
                <th>Renta</th>
                <th>Estado</th>
                <th>Region</th>
                <th>Comuna</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //        require_once 'db.php';
            //        global $conn;

            $sql = "SELECT a.nombre, a.estado, b.* "
            . "FROM tbl_datos_postulacion_abierta a, tbl_postulante b "
            . "WHERE a.id_post = b.id_post";
            $result = $conn->query($sql);

            $fila_post_select = '';
            $fila_post_fuera_rango = '';
            $fila_post_no_apto = '';
            $fila_post_eliminado = '';
            $fila_post_sin_clasif = '';

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    //        echo "id: " . $row["id_post"]." " .$row["rut"]  ." - Name: " . $row["nombres"]. " " . $row["apellidop"]. "<br>";
                    $fila_post = imprimir_fila_post($row);

                    if($row['estado'] == 'Apto' ){
                        $fila_post_select .= $fila_post;
                    }else if($row['estado'] == 'Fuera Rango Renta'){
                        $fila_post_fuera_rango .= $fila_post;
                    }else if($row['estado'] == 'No Apto'){
                        $fila_post_no_apto .= $fila_post;
                    }else if($row['estado'] == 'Eliminados'){
                        $fila_post_eliminado .= $fila_post;
                    }else if($row['estado'] == 'Sin Clasificar'){
                        $fila_post_sin_clasif .= $fila_post;
                    }

                    echo $fila_post;
                }
            }
            // else {
            //    echo "0 results";
            //}
            ?>
            </tbody>
        </table>
    </div>
    <div id="test2" class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                <th>Cargo</th>
                <th>Sexo</th>
                
                <th>Renta</th>
                <th>Estado</th>
                <th>Region</th>
                <th>Comuna</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $fila_post_select; ?>
            </tbody>
        </table>
    </div>
    <div id="test3" class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                
                <th>Cargo</th>
                <th>Sexo</th>
                <th>Renta</th>
                <th>Estado</th>
                <th>Region</th>
                <th>Comuna</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $fila_post_no_apto; ?>
            </tbody>
        </table>
    </div>
    <div id="test4" class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                
                <th>Cargo</th>
                <th>Sexo</th>
                <th>Renta</th>
                <th>Estado</th>
                <th>Region</th>
                <th>Comuna</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $fila_post_fuera_rango; ?>
            </tbody>
        </table>
    </div>
    <div id="test5" class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                <th>Cargo</th>
                <th>Sexo</th>
                <th>Renta</th>
                <th>Estado</th>
                <th>Region</th>
                <th>Comuna</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $fila_post_eliminado; ?>
            </tbody>
        </table>
    </div>
    <div id="test6" class="col s12 empresa lineaDatos1 printTable">
        <table id="tablaPortia" id="sin_clasificar_table" class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                <th>Cargo</th>
                <th>Sexo</th>
                <th>Renta</th>
                <th>Estado</th>
                <th>Region</th>
                <th>Comuna</th>
            </tr>
            </thead>
            <tbody>
            <?php echo $fila_post_sin_clasif; ?>
            </tbody>
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
    /* $(document).ready(function() {
        $('#tablaPortia_test').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "datatables_script.php"
        } );
    } ); */
</script>

<script language="Javascript">
<?php if (isset($_SESSION["mode"])) { ?>
    notie.alert({ type: 1, text: 'Modo desarrollador activado', position: 'bottom' });
<?php } ?>
</script>
</body>
</html>