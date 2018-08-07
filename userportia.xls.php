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

        $fila_post = '<tr>
                        <td> '.$fecha_post.'</td>
                        <td>'.$row["rut"].'</td>
                        <td>'.$row["nombres"].' '. $row["apellidop"].'</td>
                        <td>'.$row["nacionalidad"].'</td>
                        <td>'.$row["nombre"].'</td>
                        <td>'.$row["renta"].'</td></td>
                        <td>'.$row["estado"].'</td>';

        $fila_post .= '<td>'.$row["sexo"].'</td>
                        <td>'.$row["provincia"].'</td>
                        <td>'.$row["comuna"].'</td>';
        $fila_post .= '</tr>';

        return $fila_post;
    }

    require_once 'db.php';
    global $conn;

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
                <th>Sexo</th>
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

            if ($result->num_rows > 0) {
                // output data of each row
                while($row = $result->fetch_assoc()) {
                    //        echo "id: " . $row["id_post"]." " .$row["rut"]  ." - Name: " . $row["nombres"]. " " . $row["apellidop"]. "<br>";
                    $fila_post = imprimir_fila_post($row);
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