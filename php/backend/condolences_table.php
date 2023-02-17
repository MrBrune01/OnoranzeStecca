<?php
require_once('php/backend/condolences_manager.php');
require_once('php/backend/dead_manager.php');
include('php/backend/page_editor.php');
$search = isset($_GET['search_cordogli']) ? $_GET['search_cordogli'] : null;
if (is_admin())
    if (isset($search))
        $condolences = condolences_manager::get_by_dead_generics($search);
    else
        $condolences = condolences_manager::get_by_dead_generics('');
else
    if (isset($search))
    $condolences = condolences_manager::get_by_user_and_dead_generics($_SESSION['username'], $search);
else
    $condolences = condolences_manager::get_by_user_and_dead_generics($_SESSION['username'], '');


//keep search string visible
if (isset($search))
    $DOM = str_replace('class="search" name="search_cordogli"', 'class="search" name="search_cordogli" value="' . htmlspecialchars($search) . '"', $DOM);

if (is_admin())
    $DOM = edit_page($DOM, '<!-- userzone -->');
$username = htmlspecialchars($_SESSION['username']);


$mail = user_manager::get_mail($username);
$DOM = str_replace('<username-to-replace></username-to-replace>', $username, $DOM);
$DOM = str_replace('<!-- account_mail -->', $mail ? $mail[0]['mail'] : "", $DOM);




$DOM = str_replace('<!-- cordogli -->', make_condolences($condolences), $DOM);
function make_condolences($cordogli_to_print)
{
    $list_element = "";
    $i = 0;
    if ($cordogli_to_print !== False) {
        foreach ($cordogli_to_print as $cordoglio) {
            $i= $i +1;
            $dead = dead_manager::get_by_id($cordoglio['dead_id'])[0];
            $dead_generals = $dead['name'] . ' ' . $dead['surname'];
            $dead_generals = htmlspecialchars($dead_generals);
            $mail = htmlspecialchars($cordoglio['username']);
            $message = htmlspecialchars($cordoglio['message']);
            $list_element .= '
            <tr>
                <td class="mailcordoglio">' . $mail . '</td>
                <td>' . $dead_generals . '</td>
                        <td>
                            <form action="condolences_wrap.php" name="edit_cordoglio" method="POST">
                            <label for="id-' . $i . '" class="hidden2">Messaggio</label>
                            <textarea class="textarea-cordoglio" name="message" id="id-' . $i . '">' . $message . '</textarea>
                            <input type="hidden" name="condolences_id" value="' . $dead['id'] . '" />
                            <input type="hidden" name="condolences_mail" value="' . $mail . '" />
                            <input class="img" type="image" alt="submit" src="images/edit.svg" name="edit_cordoglio"/></form>
                        </td>
                        <td>
                            <form action="condolences_wrap.php" name="delete_condolences" method="POST">
                            <input type="hidden" name="delete_dead_id" value="' . $dead['id'] . '" />
                            <input type="hidden" name="delete_mail" value="' . $mail . '" />
                            <input class="img" type="image" alt="submit" src="images/delete.svg" name="delete_cordoglio"/>
                            </form>
                        </td>
            </tr>';
        }
    } else
        $list_element = '<tr><th colspan="5">Nessun risultato</th></tr>';
    return $list_element;
}
