<?php
require_once('php/backend/user_manager.php');
function is_logged()
{
    return isset($_SESSION["username"]);
}
function server_error()
{
    http_response_code(500);
    $relative_path = dirname(__FILE__) . '/../../html/500.html';
    echo file_get_contents($relative_path);
    die();
}
function is_admin()
{
    if (!is_logged())
        return false;
    $result = user_manager::get_admin($_SESSION["username"]);
    if ($result == false || count($result) == 0)
        return false;
    return true;
}
function login()
{
    if (empty($_POST) || !isset($_POST["username"]) || !isset($_POST["password"]))
        return "Completa tutti i campi";

    $user = $_POST["username"];
    $pass = $_POST["password"];

    if (is_username($user) !== True)
        return is_username($user);
    //! per ora commentato per la password di admin
    // if (is_password($pass) !== True)
    //     return is_password($pass);

    $user = filter_var($user, FILTER_UNSAFE_RAW);
    // $pass = filter_var($pass, FILTER_SANITIZE_STRING);

    $pass = hash("sha256", $_POST["password"]);
    $db_mail = user_manager::get_password($user);
    if (empty($db_mail))
        return "Utente non registrato";

    if ($pass === $db_mail[0]["password"]) {
        $_SESSION["username"] = $user;
        return True;
    }
    return "Errore nell'accesso";

}
function get_session_user()
{
    if (is_logged()) {
        return htmlspecialchars($_SESSION["username"]);

        //$mail = isset($_SESSION["username"]) ? $_SESSION["username"] : Null;
        //$result = user_manager::get_username($mail);
//
        //if ($result != null && $result != false) {
        //    return htmlspecialchars($result[0]['username']);
        //}
    }
    return false;
}
function register()
{
    if (empty($_POST) || !isset($_POST["mail"]) || !isset($_POST["username"]) || !isset($_POST["password1"]) || !isset($_POST["password2"]))
        return "Compilare tutti i campi";

    $mail = $_POST["mail"];
    $username = $_POST["username"];
    $pass1 = $_POST["password1"];
    $pass2 = $_POST["password2"];

    if (is_mail($mail) !== True)
        return is_mail($mail);
    if (is_password($pass1) !== True)
        return is_password($pass1);
    if (is_username($username) !== True)
        return is_username($username);

    if ($pass1 != $pass2)
        return "Le <span lang=\"en\">password</span> non sono uguali";

    $mail = filter_var($mail, FILTER_SANITIZE_EMAIL);
    $pass = hash("sha256", $pass1);

    $result = user_manager::get_by_username($username);

    if ($result && count($result) > 0) {
        return "Esiste già un utente registrato con questo <span lang=\"en\">username</span>";
    }

    $chkmail = user_manager::get_by_mail($mail);
    if ($chkmail && count($chkmail) > 0) {
        return "Esiste già un utente registrato con questa <span lang=\"en\">mail</span>";
    }

    user_manager::add($username, $mail, $pass);
    return true;
}
function is_mail($mail)
{
    if (strlen($mail) > 256)
        return "La <span lang=\"en\">mail</span> può essere lunga al massimo 256 caratteri";
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL))
        return "<span lang=\"en\">Mail</span> non valida";
    return True;
}
function is_password($pass)
{
    // $password_pattern = '/^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s])[^\s]{8,256}$/';
    // if (!preg_match($password_pattern, $pass)) #|| !filter_var($pass, FILTER_SANITIZE_STRING)
    //     return "La <span lang=\"en\">password</span> deve essere lunga almeno 8 caratteri e massimo 256,deve contenere almeno un carattere maiuscolo, un carattere minuscolo, un numero e un carattere speciale";
    return True;
}
function is_username($username)
{
    $username_pattern = '/^[\w]{1,40}$/';
    if (!preg_match($username_pattern, $username)) #!filter_var($username, FILTER_SANITIZE_STRING)
        return "<span lang=\"en\">Username</span> può contenere solo lettere, numeri e <span lang=\"en\">underscore</span> e deve essere lungo al massimo 40 caratteri";

    return True;
}

?>