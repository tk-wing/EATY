<?php
    session_start();

    $_SSESION = [];

    session_destroy();

    header("Location: signin.php");
    exit();

?>