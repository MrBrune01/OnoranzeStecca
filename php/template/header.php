<?php
header_remove('x-powered-by');
$DOM = file_get_contents('html/template/header.html');
$DOM = str_replace('<title></title>', '<title>' . $title . '</title>', $DOM);
$DOM = str_replace('<meta name="description" content="" />', '<meta name="description" content="' . $description . '" />', $DOM);
$DOM = str_replace('<meta name="keywords" content="" />', '<meta name="keywords" content="' . $keywords . '" />', $DOM);
$DOM = str_replace('<link rel="canonical" href="https://onoranze.stecca.dev/" />', '<link rel="canonical" href="https://onoranze.stecca.dev/' . $page . '.php" />', $DOM);
$DOM = str_replace('<meta property="og:title" content="" />', '<meta property="og:title" content="' . $title . '" />', $DOM);
$DOM = str_replace('<meta property="og:description" content="" />', '<meta property="og:description" content="' . $description . '" />', $DOM);
$DOM = str_replace('<meta property="og:url" content="https://onoranze.stecca.dev/" />', '<meta property="og:url" content="https://onoranze.stecca.dev/' . $page . '.php" />', $DOM);
if (isset($script)) {
    $DOM = str_replace('<script></script>', '<script src="js/' . $script . '.js"></script>', $DOM);
} else {
    $DOM = str_replace('<script></script>', '', $DOM);
}
if (isset($image)) {
    $DOM = str_replace('<meta property="og:image" content="https://onoranze.stecca.dev/logo/png/preview.png" />', '<meta property="og:image" content="https://onoranze.stecca.dev/necrologio/' . $image . '">', $DOM);
}
if (isset($_GET['id'])) { //se non trova epigrafe non fa niente giustamente
    $DOM = str_replace('epigrafe.php', 'epigrafe.php?id=' . $_GET['id'], $DOM);
}
switch ($title) {
    case "Necrologio - Onoranze Stecca":
        $DOM = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php"><span lang="en"> Home </span></a></li><li>Necrologio</li></ul>', $DOM);
        break;
    case "Servizi - Onoranze Stecca":
        $DOM = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php"><span lang="en"> Home </span></a></li><li>Servizi</li></ul>', $DOM);
        break;
    case "Chi siamo - Onoranze Stecca":
        $DOM = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php"><span lang="en"> Home </span></a></li><li>Chi Siamo</li></ul>', $DOM);
        break;
    case "Contatti - Onoranze Stecca":
        $DOM = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php"><span lang="en"> Home </span></a></li><li>Contatti</li></ul>', $DOM);
        break;
    case "Accedi - Onoranze Stecca":
        $DOM = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php"><span lang="en"> Home </span></a></li><li>Accedi</li></ul>', $DOM);
        break;
}
if (str_contains($title, "Epigrafe di")) {
    $DOM = str_replace('<!-- <ul-to-replace></ul-to-replace> -->', '<ul><li><a href="index.php"><span lang="en"> Home </span></a></li><li><a href="necrologio.php">Necrologio</a></li><li>Epigrafe</li>', $DOM);
}
require_once "php/backend/auth.php";
session_start();
$username = get_session_user();
if ($username !== false) {
    $DOM = str_replace("Accedi", " " . $username, $DOM);
}

session_abort();


$DOM = str_replace('<li><a href="' . $page . '.php">', '<li class="current-link">', $DOM);
// $DOM = str_replace('<li><a href="index.php">', '<li class="current-link">', $DOM);
//delete the first </a> after <li class="current-link">


$start = strpos($DOM, '<li class="current-link">') + strlen('<li class="current-link">');
if ($start > 25) {
    $start = strpos($DOM, '</a>', $start);
    $DOM = substr_replace($DOM, '', $start, 4);
}
echo ($DOM);
