<?php
require_once('db.php');
require_once('manager.php');
class service_manager extends Manager
{

    public static function get()
    {
        return db::run_query("select * from service");
    }
    public static function delete($id = null)
    {
        return db::run_query("delete from service where id = ?", $id);
    }
    public static function update()
    {
    }
    public static function add($name = null, $desc = null, $price = null, $img = null, $notes = null)
    {
        $name = trim($name);
        $desc = trim($desc);
        $notes = trim($notes);
        $price = trim($price);
        $img = trim($img);
        return db::run_query("insert into service (name,descr,price,img,note) values (?,?,?,?,?);", $name, $desc, $price, $img, $notes);
    }
}
?>