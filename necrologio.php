<?php
$title = "Necrologio - Onoranze Stecca";
$page = "necrologio";
$description = "Consulta il necrologio delle onoranze Stecca per sapere chi è morto e quando.";
$keywords = "necrologio, Onoranze Stecca, morti, morti recenti, morti di oggi, morti di ieri, morti Altivole";
include "php/template/header.php";
require_once('php/backend/dead_manager.php');
$DOM = file_get_contents('html/necrologio.html');

try {
  $DOM = str_replace(' <!-- necrologio -->', make_board(dead_manager::get_necrologio()), $DOM);
  echo ($DOM);
} catch (Exception $e) {
  server_error();
}
include "php/template/footer.php";

function make_board($deads_to_print)
{
  $CARD = "";
  foreach ($deads_to_print as $person) {
    $id = htmlspecialchars($person['id']);
    $name = htmlspecialchars($person['name']);
    $surname = htmlspecialchars($person['surname']);
    $born_date = date_create($person['born_date']);
    $death_date = date_create($person['death_date']);
    $reminder_phrase = htmlspecialchars($person['reminder_phrase']);
    $img = htmlspecialchars($person['img']);
    $eta = date_diff($death_date, $born_date);


    $CARD .= ' 
            <div class="card">
            <a href="epigrafe.php?id=' . $id . '"> <img class="obituary-img" src="' . $img . '" alt="" /></a>
              <div class="container">
              <a href="epigrafe.php?id=' . $id . '"><h2>' . $name . " " . $surname . '</h2></a>
                  <h2>di anni: ' . $eta->format('%Y') . '</h2>
                  <p class="date">Morto il: <time class="date" datetime="' . $death_date->format('Y-m-d') . '" >' . dead_manager::timestamp_to_date_italian($death_date) . '</time></p>
              </div>
            </div>';
  }
  return $CARD;
}
