<?php
require_once('php/backend/manager.php');
require_once('php/backend/condolences_manager.php');

if (isset($_POST['delete_dead_id']) && is_numeric($_POST['delete_dead_id']) && isset($_POST['delete_mail'])) {
    condolences_manager::delete($_POST['delete_mail'], $_POST['delete_dead_id']);
}
if (isset($_POST['condolences_id']) && is_numeric($_POST['condolences_id']) && isset($_POST['condolences_mail']) && isset($_POST['message'])) {
    condolences_manager::update($_POST['condolences_mail'], $_POST['condolences_id'], $_POST['message']);
}
header("Location: account.php");
?>