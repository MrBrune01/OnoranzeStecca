<?php
require_once('db.php');
require_once('manager.php');
class user_manager extends Manager
{

    public static function get_password($user)
    {
        return db::run_query('SELECT password FROM user WHERE username = ?', $user);
    }
    public static function get_by_mail($mail)
    {
        return db::run_query('SELECT * FROM user WHERE mail = ?', $mail);
    }
    public static function get_by_username($user)
    {
        return db::run_query('SELECT * FROM user WHERE username = ?', $user);
    }   
    public static function get()
    {
        return db::run_query('SELECT * FROM user');
    }
    public static function get_admin($username)
    {
        return db::run_query('SELECT * FROM admin WHERE username = ?', $username);
    }
    public static function update()
    {
    }
    public static function get_username($mail)
    {
        return db::run_query('SELECT username FROM user WHERE mail = ?', $mail);
    }
    public static function get_mail($username)
    {
        return db::run_query('SELECT mail FROM user WHERE username = ?', $username);
    }
    public static function add($mail = null, $username = null, $password = null)
    {
        db::run_query("INSERT INTO user (username, mail, password) VALUES (?,?,?);", $mail, $username, $password);
    }
    public static function delete($username = null)
    {
        db::run_query("DELETE FROM user WHERE username = ?;", $username);
    }
    public static function change_username($olduser, $username)
    {
        $all_user = db::run_query("SELECT username FROM user;");
        foreach ($all_user as $key => $value) {
            if (strtoupper($username) === strtoupper($value['username'])){
                return false;
            }
        }
        db::run_query("UPDATE user SET username = ? WHERE username = ?;", $username, $olduser);
        return true;
    }
}
?>
