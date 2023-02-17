<?php
/*
 *  Classe per la gestione del database
 *  Implementa metodi per la connessione e gestione delle query
 */
require_once("php/backend/auth.php");
class db
{
    private static $host;
    private static $username;
    private static $password;
    private static $dbname;
    private static $mysqli;
    private static function connect($host = "db", $username = "root", $password = "q", $dbname = "onoranze")
    {

        try {
            self::$host = $host;
            self::$username = $username;
            self::$password = $password;
            self::$dbname = $dbname;
            $mysqli = new mysqli(self::$host, self::$username, self::$password, self::$dbname);
            if ($mysqli->connect_errno) {
                die('Connect failed: ' . $mysqli->connect_error);
            }
            self::$mysqli = $mysqli;
            return $mysqli;
        } catch (Exception $e) {
            server_error();
        }
    }

    public static function run_query($query, ...$params)
    {
        $mysqli = self::connect();
        $stmt = $mysqli->prepare($query);
        if (count($params) > 0) {
            $stmt->bind_param(str_repeat("s", count($params)), ...$params);
        }
        foreach ($params as $param) {
            $param = mysqli_real_escape_string($mysqli, $param);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result == false || ($result->num_rows) <= 0) {
            return false;
        }


        $result = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        $mysqli->close();
        return $result;
    }

}


?>