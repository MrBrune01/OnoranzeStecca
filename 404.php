<?php

http_response_code(404);

$title = "Page not found - Onoranze Stecca";
$page = "404";
$description = "Page not found - Onoranze Stecca";
$keywords = "404";
include "php/template/header.php";
$DOM = file_get_contents('html/404.html');
echo ($DOM);

include "php/template/footer.php";

?>