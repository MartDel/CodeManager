<?php

/**
 * A class to manage the database
 */
abstract class DatabaseManager
{
    const DB_HOST = "localhost";
    // For ouiheberg
    const DB_NAME = "codeman1_main";
    // For local linux
    // const DB_NAME = "codemanager";
    const DB_USERNAME = Passwords::DB_USERNAME;
    const DB_PASSWORD = Passwords::DB_PASSWORD;

    /**
    * Connect to the database and return it
    * @return PDO The database
    */
    public static function dbConnect(){
    	$db = new PDO('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME . ';charset=utf8', self::DB_USERNAME, self::DB_PASSWORD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	return $db;
    }
}
