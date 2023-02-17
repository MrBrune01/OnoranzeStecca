<?php
$title = "Chi siamo - Onoranze Stecca";
$page = "chi-siamo";
$description = "Le onoranze Stecca sono una delle più antiche aziende funebri di Altivole, fondata nel 33 da Giuseppe Stecca.";
$keywords = "Onoranze Stecca, Altivole, azienda funebre, funerale, onoranze funebri, crematorio, casa funeraria, Giuseppe Stecca";
include "php/template/header.php";
echo (file_get_contents('html/chi-siamo.html'));
include "php/template/footer.php";
?>