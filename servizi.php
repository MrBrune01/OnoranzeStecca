<?php
require_once('php/backend/service_manager.php');
$title = "Servizi - Onoranze Stecca";
$page = "servizi";
$description = "Le onoranze Stecca offrono una vasta gamma di servizi funebri, dai funerali alle esequie, dalle esequie ai funerali.";
$keywords = "Onoranze Stecca, onoranze funebri Altivole, servizi funebri, funerali, esequie, crematorio, casa funeraria";

include "php/template/header.php";
$content = "";
$DOM = file_get_contents('html/servizi.html');
echo ($DOM);
include "php/template/footer.php";
