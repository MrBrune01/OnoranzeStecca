<?php
$title = "Contatti - Onoranze Stecca";
$page = "contatti";
$description = "Contattaci per avere maggiori informazioni sulle onoranze Stecca e le nostre attività.";
$keywords = "contatti, Onoranze Stecca, informazioni";
include "php/template/header.php";
require_once("php/backend/message.php");
require_once("php/backend/auth.php");
$template = file_get_contents('html/contatti.html');
$err = "";

try {
    if (!empty($_POST) && isset($_POST["submit"])) {
        if (!isset($_POST["nome"]) || !isset($_POST["cognome"]) || !isset($_POST["email"]) || !isset($_POST["messaggio"]))
            $err = "Errore: uno o più campi non sono stati compilati.";
        else {
            $result = send_message($_POST["email"], $_POST["nome"] . ' ' . $_POST["cognome"], $_POST["messaggio"]);
            if ($result === true) {
                $err = "Messaggio inviato con successo.";
            } else {
                $err = "Errore nell'invio del messaggio.";
            }
        }
    }
} catch (Exception $e) {
    server_error();
}
$template = str_replace("<!-- errors -->", $err, $template);
echo $template;
include "php/template/footer.php";
