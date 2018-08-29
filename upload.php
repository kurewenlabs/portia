<html>
<body topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0">
<img id="loading" src="src/img/spinner.gif" width="24" height="24" /> <div id="message">Cargando...</div>
<script>
    var imagen = document.getElementById("loading");
    var message = document.getElementById("message");
</script>
<?php
    session_start();
    $id_post = $_POST['id_post'];
    $file_type = $_POST['file_type']; 

    function var_error_log( $object = null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }
    
    if (isset($_SESSION["mode"])) {
        var_error_log($_POST);
        var_error_log($_FILES);
    }

    error_log("Trying to upload the file " . $file_type);

    if(isset($_FILES[$file_type])) {
        // Make sure the file was sent without errors
        if($_FILES[$file_type]['error'] == 0) {
            // Connect to the database
            require_once("db.php");
            global $conn;
     
            // Gather all required data
            $name = $_FILES[$file_type]['name'];
            $mime = $_FILES[$file_type]['type'];
            $size = $_FILES[$file_type]['size'];
            $tmpn = $_FILES[$file_type]['tmp_name'];
            $data = addslashes(fread(fopen($tmpn, 'rb'), filesize($tmpn)));
     
            // Create the SQL query
            $query = "UPDATE tbl_archivo SET estado = 0 WHERE id_post = '{$id_post}' AND tipo_archivo = '{$file_type}'";
     
            // Execute the query
            if(!mysqli_query($conn, $query))
            {
                ?> 
                    <script> 
                        imagen.src='src/img/fail.png';
                        message.innerHTML=''; 
                    </script> 
                <?php
                die();
            }

            // Create the SQL query
            $query = "
                INSERT INTO tbl_archivo (
                    id_post, tipo_archivo, nombre, tipo, contenido
                )
                VALUES (
                    '{$id_post}', '{$file_type}', '{$name}', '{$mime}', '{$data}'
                )";
     
            // Execute the query
            $result = $conn->query($query);
     
            // Check if it was successfull
            if($result) {
                error_log('Success! Your file was successfully added!');
                ?> 
                    <script> 
                        imagen.src='src/img/done.png';
                        message.innerHTML=''; 
                    </script> 
                <?php
            }
            else {
                error_log("Error! Failed to insert the file {$conn->error}");
                ?> 
                    <script> 
                        imagen.src='src/img/fail.png';
                        message.innerHTML=''; 
                    </script> 
                <?php
            }

            // Close the mysql connection
            $conn->close();
        }
        else {
            error_log("An error accured while the file was being uploaded. Error code: ". intval($_FILES[$file_type]['error']));
            ?> 
            <script> 
                imagen.src='src/img/fail.png';
                message.innerHTML=''; 
            </script> 
            <?php
        }
     
    }
    else {
        error_log('Error! A file was not sent!');
        ?> 
        <script> 
            imagen.src='src/img/fail.png';
            message.innerHTML=''; 
        </script> 
        <?php
    }
?>
</body>
</html>
