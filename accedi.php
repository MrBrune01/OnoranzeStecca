<?php
$title = "Accedi - Onoranze Stecca";
$page = "accedi";
$description = "Accedi al tuo account per scrivere messaggi di cordoglio e gestire le tue informazioni personali.";
$keywords = "accedi, Onoranze Stecca, login, account, messaggi, informazioni personali, accesso";

$script = "validate";
require "php/backend/auth.php";


session_start();
if (is_logged()) {
    if (is_admin())
        header("Location: dashboard.php");
    else
        header("Location: account.php");

}
$template = (file_get_contents('html/accedi.html'));

$err = isset($_SESSION['error-login']) ? $_SESSION['error-login'] : null;

session_write_close();
session_abort();

include "php/template/header.php";
try {
    if (isset($err))
        $template = str_replace("<!-- errors -->", $err, $template);

    echo $template;
} catch (Exception $e) {
    server_error();
}
include "php/template/footer.php";
?>