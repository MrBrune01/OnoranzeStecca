<?php
//header
$title = "Dashboard - Onoranze Stecca";
$page = "dashboard";
$description = "Dashboard - Onoranze Stecca";
$keywords = "Dashboard";
$script = "validate";

require_once('php/backend/auth.php');

session_start();
if (!is_admin())
  header("Location: accedi.php");

if (isset($_POST['logout'])) {
  session_destroy();
  session_abort();
  header("Location: index.php");
  exit();
}


session_abort();

include "php/template/header.php";
$DOM = file_get_contents('html/dashboard.html');
include "php/backend/condolences_table.php";
require_once('php/backend/dead_manager.php');

try {
  $error = isset($_SESSION['error-dash']) ? $_SESSION['error-dash'] : null;
  if (isset($_GET['search_dead'])) {
    //keep search string visible
    $DOM = str_replace('class="search" name="search_dead"', 'class="search" name="search_dead" value="' . htmlspecialchars($_GET['search_dead']) . '"', $DOM);
    $result = dead_manager::get_by_name_surname($_GET['search_dead']);
  } else
    $result = dead_manager::get_by_name_surname('');


  //edit dead
  $dead = false;
  if (isset($_POST['edit']) && is_numeric($_POST['edit']))
    $dead = dead_manager::get_by_id(($_POST['edit'])) ? dead_manager::get_by_id(($_POST['edit']))[0] : False;
  else
    $dead = dead_manager::get_first() ? dead_manager::get_first()[0] : False;
  if ($dead !== False) {
    $DOM = str_replace('<!-- imgtoreplace -->', '<img id="preview" alt="Immagine di ' . $dead['name'] . ' ' . $dead['surname'] . '" width=150 height=200 src="' . $dead['img'] . '" />', $DOM);
    $DOM = str_replace('id="id"', ' id="id" value=" ' . $dead['id'] . ' " ', $DOM);
    $DOM = str_replace('id="name"', 'id="name" value="' . $dead['name'] . '"', $DOM);
    $DOM = str_replace('id="surname"', 'id="surname" value="' . $dead['surname'] . '"', $DOM);
    $DOM = str_replace('id="born_date"', 'id="born_date" value="' . $dead['born_date'] . '"', $DOM);
    $DOM = str_replace('id="death_date"', 'id="death_date" value="' . $dead['death_date'] . '"', $DOM);
    $DOM = str_replace('id="reminder_phrase">', ' id="reminder_phrase">' . $dead['reminder_phrase'] . '', $DOM);
  }


  //print dashboard
  $DOM = str_replace('<!-- dashboard -->', make_dashboard($result), $DOM);
  if (isset($error))
    $DOM = str_replace('<!-- errors -->', '<div class="error center"><div class="center">' . $error . '</div></div>', $DOM);
  echo ($DOM);
} catch (Exception $e) {
  server_error();
}
unset($_POST);

include "php/template/footer.php";

function make_dashboard($deads_to_print)
{
  $list_element = "";
  if ($deads_to_print !== False) {
    foreach ($deads_to_print as $person) {
      $id = htmlspecialchars($person['id']);
      $name = htmlspecialchars($person['name']);
      $surname = htmlspecialchars($person['surname']);
      $death_date = htmlspecialchars($person['death_date']);
      $list_element .= '
      <tr>
        <td>' . $name . '</td>
        <td>' . $surname . '</td>
        <td class="datamorte"><time datetime="' . $death_date . '">' . dead_manager::timestamp_to_date_italian(date_create($death_date)) . '</time></td>
      <td>
        <form  action="dashboard.php#edit" method="POST">
          <input type="hidden" name="edit" value="' . $id . '" />
          <input class="img" type="image" alt="modifica ' . $name . '' . $surname . '" src="images/edit.svg" name="submit" />
        </form>
      </td>
      <td>
        <form action="dashboard_wrap.php" method="POST"><input type="hidden" name="delete" value="' . $id . '" />
          <input class="img" type="image" alt="elimina ' . $name . '' . $surname . '" src="images/delete.svg" name="submit" />
        </form>
      </td>
    </tr>';
    }
  } else
    $list_element = '<tr><th colspan="5">Nessun defunto trovato</th></tr>';
  return $list_element;
}