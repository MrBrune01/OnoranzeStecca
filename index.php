<?php
require_once('php/backend/service_manager.php');
$title = "Le migliori onoranze ad Altivole - Onoranze Funebri Stecca";
$page = "index";
$description = "Onoranze Funebri Stecca, il forno crematorio e la casa funeraria fanno parte delle eccellenze funerarie di Altivole.";
$keywords = "onoranze, Onoranze Stecca, onoranze funebri, Altivole, onoranze Altivole, crematorio, casa funeraria, funerale";

include "php/template/header.php";
$content = "";
$DOM = file_get_contents('html/home.html');
echo ($DOM);
include "php/template/footer.php";
?>