<?php
require_once('php/backend/auth.php');
require_once('php/backend/condolences_manager.php');

if (isset($_GET['id'])){
  session_start();
  $id = $_GET['id'];
  if (isset($_POST['message']) && get_session_user()) {
    if (!condolences_manager::condolance_exists($_SESSION['username'], $_POST['id'])){
      condolences_manager::add($_POST['id'], $_SESSION['username'], $_POST['message']);
    }else{ 
      condolences_manager::update($_SESSION['username'], $_POST['id'], $_POST['message']);
    }
    header("Location: epigrafe.php?id=". $id);
  }
  session_abort();
} else{
  header("Location: necrologio.php");
}
?>