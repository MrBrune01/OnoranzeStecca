<?php

http_response_code(500);

$title = "Server error  - Onoranze Stecca";
$page = "500";
$description = "Server error - Onoranze Stecca";
$keywords = "500";
include "php/template/header.php";
$DOM = file_get_contents('html/500.html');
echo ($DOM);

include "php/template/footer.php";

?>