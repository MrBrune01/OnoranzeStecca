<?php
$title = "Registrati - Onoranze Stecca";
$page = "registrati";
$description = "Registrati per poter accedere al tuo account e scrivere messaggi di cordoglio.";
$keywords = "registrati, Onoranze Stecca, account, registrazione";

$script = "validate";
require_once "php/backend/auth.php";

session_start();
try {
    if (is_logged()) {
        if (is_admin()) {
            header("Location: dashboard.php");
        } else {
            header("Location: account.php");
        }
    }
    $template = (file_get_contents('html/registrati.html'));

    $result = isset($_SESSION['error-reg']) ? $_SESSION['error-reg'] : null;

    session_abort();
    include "php/template/header.php";

    if (isset($_SESSION['error-reg'])) {
        $template = str_replace("<!-- errors -->", $result, $template);

    }
    echo $template;
} catch (Exception $e) {
    server_error();
}
include "php/template/footer.php";
?>