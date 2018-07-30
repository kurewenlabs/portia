<?php
    require_once 'db.php';
    global $conn, $separator;

    header("Content-Type: application/vnd.ms-excel");    
    header("Content-Disposition: attachment; filename=postulaciones.xls");  
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Expires: 0");
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title>Sistema de Postulación Portia</title>
    <link rel="icon" href="http://localhost/portia/src/img/Portia-favicon.png" type="image/png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=PT+Sans+Narrow" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.css">
    <link rel="stylesheet" href="http://localhost/portia/dist/css/main.min.css">
    <!--REQUIRED STYLE SHEETS-->
</head>
<body>
<div class="container">
<?php
    function imprimir_fila_post($row){

        $fecha_post = date("d/m/Y", strtotime($row["fecha_post"]));

        $color='';
        if($row["estado_post"] == 'Seleccionado'){
            $color='green';
        }else if($row["estado_post"] == 'No apto'){
            $color='orange';
        }else if($row["estado_post"] == 'Fuera de Rango'){
            $color='grey';
        }else{//Sin Clasificar
            $color='yellow';
        }

        $fila_post = '<tr>
                        <td> '.$fecha_post.'</td>
                        <td>'.$row["rut"].'</td>
                        <td>'.$row["nombres"].' '. $row["apellidop"].'</td>
                        <td>'.$row["nacionalidad"].'</td>
                        <td>'.$row["nombre"].'</td>
                        <td>'.$row["renta"].'</td></td>
                        <td>'.$row["estado_post"].'</td>';

        $fila_post .= '<td></td>';
        $fila_post .= '</tr>';

        return $fila_post;
    }

    require_once 'db.php';
    global $conn;

    $sql = "SELECT estado_post, count(*) AS count FROM (SELECT * FROM kurewenc_db_portia.tbl_postulante) a
                        LEFT JOIN
                (
                    SELECT id_post,nombre 
                    FROM  tbl_datos_postulacion_abierta
                    -- LIMIT 0 , 1
                ) b ON a.id_post = b.id_post
            GROUP BY estado_post";

  $postulacion_por_tipo = array();
  $result1 = $conn->query($sql);

   if ($result1->num_rows > 0) {
        // output data of each row
   $total = 0;
      while($row2 = $result1->fetch_assoc()) {
         $postulacion_por_tipo[ $row2['estado_post'] ] = $row2['count'];
         $total += $row2['count'];
        }
      $postulacion_por_tipo[ 'total' ] = $total;
    }

    //    print '<pre>';
    //    print_r($postulacion_por_tipo);
    //    print '</pre>';

    ?>
    <div id="test1" class="col s12 empresa lineaDatos1 printTable">
        <table class="centered highlight">
            <thead>
            <tr>
                <th>Fecha</th>
                <th>ID</th> <!-- AQUI DEBE IMPRIMIR EL RUT O PASAPORTE -->
                <th>Postulante</th>
                <th>Nacionalidad</th>
                <th>Cargo</th>
                <th>Rango Renta</th>
                <th>Estado</th>
                <th>Adjuntos</th>
            </tr>
            </thead>
            <tbody>
            <?php
            //        require_once 'db.php';
            //        global $conn;

            $sql = "SELECT * FROM (SELECT * FROM kurewenc_db_portia.tbl_postulante) a
                                 LEFT JOIN
                         (
                             SELECT id_post,nombre 
                             FROM  tbl_datos_postulacion_abierta
                             -- LIMIT 0 , 1
                         ) b ON a.id_post = b.id_post";

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

                    if($row['estado_post'] == 'Seleccionado' ){
                        $fila_post_select .= $fila_post;
                    }else if($row['estado_post'] == 'Fuera de Rango'){
                        $fila_post_fuera_rango .= $fila_post;
                    }else if($row['estado_post'] == 'No apto'){
                        $fila_post_no_apto .= $fila_post;
                    }else if($row['estado_post'] == 'Eliminados'){
                        $fila_post_eliminado .= $fila_post;
                    }else if($row['estado_post'] == 'Sin Clasificar'){
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
</div><!--container-->

<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type = "text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/notie/4.3.1/notie.min.js"></script>
<script src="src/jquery.table2excel.js"></script>
<script src="src/js/postulaciones.js"></script>
<script>
    $("#exportXml").click(function(){
        window.location.href="userportia.xls.php";
    });
</script>
</body>
</html>