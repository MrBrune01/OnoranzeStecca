<?php
$title = "Account - Onoranze Stecca";
$page = "account";
$description = "Gestisci le tue informazioni personali e i tuoi messaggi di cordoglio.";
$keywords = "account, Onoranze Stecca, informazioni personali, messaggi, cordoglio";
$script = "validate";

require_once('php/backend/auth.php');
require_once('php/backend/user_manager.php');
session_start();
try {
    if (!is_logged()) {
        header("Location: index.php");
    } elseif (is_admin()) {
        $is_ad = true;
        if (isset($_SERVER['REQUEST_URI']) && str_contains($_SERVER['REQUEST_URI'], 'account.php'))
            header("Location: dashboard.php");

    }

    if (isset($_POST['delete-account'])) {
        $user = $_SESSION['username'];
        user_manager::delete($user);
        session_destroy();
        session_abort();
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        session_abort();
        header("Location: index.php");
        exit();
    }

    if (isset($_POST['change-username'])) {
        $username_pattern = '/^[\w]{1,40}$/';
        if (isset($_POST['username']) && !empty($_POST['username'])){
            if (preg_match($username_pattern, $_POST['username'])){
                $olduser = $_SESSION['username'];
                $username = $_POST['username'];
                $result = user_manager::change_username($olduser, $username);
                if ($result)
                    $_SESSION['username'] = $username;
                header("Location: account.php");
                exit();
            }
        }
    }
} catch (Exception $e) {
    server_error();
}

session_abort();
include "php/template/header.php";
$DOM = file_get_contents('html/account.html');
$condolences = [];
include "php/backend/condolences_table.php";

echo ($DOM);

if (!is_admin())
    include "php/template/footer.php";
?>