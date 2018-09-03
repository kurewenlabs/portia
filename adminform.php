<?php
    session_start();

    function validateLogin($user, $pass) {
        require_once 'db.php';
        global $conn;
        $sql = 'SELECT count(id) cont FROM tbl_usuario WHERE correo = "' . $user . '" AND clave = "' . $pass . '";';
        $cursos = $conn->query($sql);
        $result = $cursos->fetch_assoc();
        return (isset($result['cont']) && $result['cont'] != '0');
    }

    function var_error_log( $object=null ){
        ob_start();                    // start buffer capture
        var_dump( $object );           // dump the values
        $contents = ob_get_contents(); // put the buffer into a variable
        ob_end_clean();                // end capture
        error_log( $contents );        // log contents of the result of var_dump( $object )
    }

    if(isset($_POST['action']) && $_POST['action'] == 'login'){
        $login_status = validateLogin($_POST['data'][0]['email'], $_POST['data'][1]['password']);
        if (!$login_status) {
            error_log('Error : tbl_usuario ');
            echo 'FAIL';
        }
        $_SESSION["active_user"] = $_POST['data'][0]['email'];
        $_SESSION["active_data"] = date("Y-m-d H:i:s");
        var_error_log($_SESSION);
    } 

    if(isset($_GET['action']) && $_GET['action'] == 'logout'){
        unset($_SESSION["active_user"]);
        unset($_SESSION["active_data"]);
        header("Location: adminportia.php", true, 301);
        exit();
    } 
?>