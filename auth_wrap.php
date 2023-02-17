<?php
require "php/backend/auth.php";
session_start();
if (!empty($_POST) && isset($_POST["submit"])) {
    $result = login();
    if ($result === true) {
        $_SESSION['error-login'] = null;
        if (is_admin())
            header("Location: dashboard.php");
        else
            header("Location: account.php");
    }
    $_SESSION['error-login'] = $result;
    header("Location: accedi.php");
}

?>