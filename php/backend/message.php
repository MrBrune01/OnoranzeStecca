<!-- FAKE message WRAPPER FOR SIMULATE MISSING PACKAGE SENDmessage -->
<?php
function send_message($sender, $name, $message)
{

    try {
        $fake_message = fopen("message.txt", "a");
        fwrite($fake_message, "Sender: $sender\nName: $name\nMessage: $message\n\n");
        fclose($fake_message);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>