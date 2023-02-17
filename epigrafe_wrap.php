<?php
require_once('php/backend/auth.php');
require_once('php/backend/condolences_manager.php');

if (isset($_GET['id'])){
  session_start();
  $id = $_GET['id'];
  if (isset($_POST['message']) && get_session_user()) {
    condolences_manager::add($_POST['id'], $_SESSION['username'], $_POST['message']);
    header("Location: epigrafe.php?id=". $id);
  }
  session_abort();
} else{
  header("Location: necrologio.php");
}
?>