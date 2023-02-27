<?php
require_once('php/backend/dead_manager.php');
require_once('php/backend/page_editor.php');
require_once('php/backend/condolences_manager.php');
$person = dead_manager::get_by_id($_GET['id']);

if ($person === false || $person == null) {
  header("Location: 404.php");
  exit();
}
$person = $person[0];
$p_name = htmlspecialchars($person['name']);
$p_surname = htmlspecialchars($person['surname']);
$p_born_date = date_create(htmlspecialchars($person['born_date']));
$p_death_date = date_create(htmlspecialchars($person['death_date']));
$p_reminder_phrase = htmlspecialchars($person['reminder_phrase']);
$p_img = htmlspecialchars($person['img']);
$p_id = htmlspecialchars($person['id']);
$p_eta = date_diff($p_death_date, $p_born_date);

//header
$title = "Epigrafe di " . $p_name . " " . $p_surname . " - Onoranze Stecca";
$page = "epigrafe";
$description = "Epigrafe di " . $p_name . " " . $p_surname;
$keywords = "Onoranze Stecca, Epigrafe, " . $p_name . " " . $p_surname . ", " . $p_name . ", " . $p_surname;
$image = substr($p_img, strrpos($p_img, '/') + 1);
$image = substr($image, 0, -4) . "png";
$script = "validate";



require_once('php/backend/auth.php');

// add cordoglio


include "php/template/header.php";

try {
  $DOM = file_get_contents('html/epigrafe.html');
  //se non loggato mostra il messaggio di login
  if (is_logged())
    $DOM = str_replace('<!-- cordoglio_zone -->', '', $DOM);
  else
    $DOM = edit_page($DOM, '<!-- cordoglio_zone -->', '<div class="login-message"><p>Effettua il <a href="accedi.php"> <span lang="en">login</span></a> per lasciare un messaggio di cordoglio</p></div>');
  $DOM = str_replace('<!-- epigrafe_nome -->', $p_name . " " . $p_surname, $DOM);
  $DOM = str_replace('<!-- epigrafe_eta -->', $p_eta->format('%Y'), $DOM);
  $DOM = str_replace('<born-date-to-replace></born-date-to-replace>', dead_manager::timestamp_to_date_italian($p_born_date), $DOM);
  $DOM = str_replace('<death-date-to-replace></death-date-to-replace>', dead_manager::timestamp_to_date_italian($p_death_date), $DOM);
  $DOM = str_replace('<reminder-phrase-to-replace></reminder-phrase-to-replace>', $p_reminder_phrase, $DOM);
  $DOM = str_replace('<img-to-replace></img-to-replace>', $p_img, $DOM);
  $DOM = str_replace('<id-to-replace></id-to-replace>', $p_id, $DOM);
  $DOM = str_replace('<!-- messaggi_cordoglio -->', make_board(condolences_manager::get_by_dead($p_id)), $DOM);

  echo ($DOM);
} catch (Exception $e) {
  server_error();
}


include "php/template/footer.php";
function make_board($cordogli)
{
  $CARD = "";
  if ($cordogli !== false) {
    foreach ($cordogli as $cordoglio) {
      $message = htmlspecialchars($cordoglio['message'], ENT_QUOTES);
      $username = htmlspecialchars($cordoglio['username'], ENT_QUOTES);

      $CARD .= '
    <div class="card w100">
      <div class="container">
        <h2>' . $username . '</h2>
        <p class="description">' . $message . '</p>
      </div>
    </div>
    ';
    }
  }
  return $CARD;
}
?>