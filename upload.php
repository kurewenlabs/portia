<?php
    session_start();
    $id_post = $_POST['id_post'];
    $file_type = $_POST['file_type']; 

    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }
    
    if (isset($_SESSION["mode"])) {
        var_error_log($_POST);
    }

    error_log("Trying to upload the file " . $file_type);

    if(isset($_FILES[$file_type])) {
        // Make sure the file was sent without errors
        if($_FILES[$file_type]['error'] == 0) {
            // Connect to the database
            require_once("db.php");
            global $conn;
     
            // Gather all required data
            $name = $conn->real_escape_string($_FILES[$file_type]['name']);
            $mime = $conn->real_escape_string($_FILES[$file_type]['type']);
            $data = $conn->real_escape_string(file_get_contents($_FILES  [$file_type]['tmp_name']));
            $size = intval($_FILES[$file_type]['size']);
     
            // Create the SQL query
            $query = "
                INSERT INTO tbl_archivo (
                    id_post, nombre, tipo, contenido
                )
                VALUES (
                    '{$id_post}', '{$name}', '{$mime}', '{$data}'
                )";
     
            // Execute the query
            $result = $conn->query($query);
     
            // Check if it was successfull
            if($result) {
                error_log('Success! Your file was successfully added!');
            }
            else {
                error_log("Error! Failed to insert the file {$conn->error}");
            }
        }
        else {
            error_log("An error accured while the file was being uploaded. Error code: ". intval($_FILES[$file_type]['error']));
        }
     
        // Close the mysql connection
        $conn->close();
    }
    else {
        error_log('Error! A file was not sent!');
    }
?>