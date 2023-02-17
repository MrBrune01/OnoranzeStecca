<?php
require_once "php/backend/auth.php";
session_start();
if (!empty($_POST) && isset($_POST["submit"])) {
    $result = register();
    if ($result === True) {
        $_SESSION['error-reg'] = null;
        header("Location: accedi.php");
    } else{
        $_SESSION['error-reg'] = $result;
    }
}
header("Location: registrati.php");
?>