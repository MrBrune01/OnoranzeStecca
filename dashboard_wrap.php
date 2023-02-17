<?php
session_start();
require_once('php/backend/dead_manager.php');
try {
  if (isset($_POST['delete']) && is_numeric($_POST['delete'])) {
    $error = dead_manager::delete($_POST['delete']);
    $_SESSION['error-dash'] = $error;
    header("Location: account.php");
  }
  if (isset($_POST['update'])) {
    $error = dead_manager::update($_POST['id'], $_POST['name_edit'], $_POST['surname_edit'], $_POST['born_date_edit'], $_POST['death_date_edit'], $_POST['reminder_phrase'], is_file($_FILES['img_edit']['tmp_name']) ? $_FILES['img_edit'] : null);
    $_SESSION['error-dash'] = $error;
    header("Location: account.php");
  }
  if (isset($_POST['add'])) {
    $error = dead_manager::add($_POST['name'], $_POST['surname'], $_POST['born_date'], $_POST['death_date'], $_POST['rem'], $_FILES['img']);
    $_SESSION['error-dash'] = $error;
    require_once('php/backend/sitemap.php');
    $id = dead_manager::get_last_id()[0]['id'];
    update_sitemap($id);
    header("Location: account.php");
  }
} catch (Exception $e) {
  server_error();
}
header("Location: account.php");
?>