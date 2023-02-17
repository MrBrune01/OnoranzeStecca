<?php
require_once('db.php');
class condolences_manager extends Manager
{

    public static function get()
    {
        return db::run_query("SELECT * FROM cordoglio JOIN dead ON cordoglio.dead_id = dead.id ORDER BY cordoglio.date desc");
    }
    public static function get_by_mail_and_dead_generics($mail, $search_text)
    {
        $search_text = $search_text . '%';
        return db::run_query("SELECT * FROM cordoglio JOIN dead ON cordoglio.dead_id = dead.id WHERE cordoglio.mail= ? AND ( dead.name LIKE UPPER(?) OR dead.surname LIKE UPPER(?)) ORDER BY dead.death_date desc", $mail, $search_text, $search_text);
    }
    public static function get_by_user_and_dead_generics($user, $search_text)
    {
        $search_text = $search_text . '%';
        return db::run_query("SELECT * FROM cordoglio JOIN dead ON cordoglio.dead_id = dead.id WHERE cordoglio.username= ? AND ( dead.name LIKE UPPER(?) OR dead.surname LIKE UPPER(?)) ORDER BY dead.death_date desc", $user, $search_text, $search_text);
    }
    public static function get_by_dead_generics($search_text)
    {
        $search_text = $search_text . '%';
        return db::run_query("SELECT * FROM cordoglio JOIN dead ON cordoglio.dead_id = dead.id WHERE dead.name LIKE UPPER(?) OR dead.surname LIKE UPPER(?) ORDER BY dead.death_date desc", $search_text, $search_text);
    }
    public static function delete($user = null, $dead_id = null)
    {
        return db::run_query("DELETE FROM cordoglio WHERE dead_id = ? AND username = ?", $dead_id, $user);
    }
    public static function update($user = null, $dead_id = null, $rem = null)
    {
        return db::run_query("UPDATE cordoglio SET message = ? WHERE dead_id = ? AND username = ?", $rem, $dead_id, $user);
    }
    public static function get_by_dead($id)
    {
        return db::run_query("SELECT * FROM cordoglio where dead_id = ?", $id);
    }

    public static function add($id = null, $user = null, $message = null)
    {
        db::run_query("INSERT IGNORE INTO cordoglio (username,message,dead_id) values (?,?,?);", $user, $message, $id);
    }

}
?>