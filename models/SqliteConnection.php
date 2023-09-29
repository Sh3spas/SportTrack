<?php

namespace models;
use PDO;

require_once __ROOT__ . '/config.php';

/**
 * This class represents a connection to the database. There is only one instance of this class.
 */
class SqliteConnection
{

    private static $instance = null;
    
    /**
     * Returns a connection to the database.
     * @return PDO the connection to the database
     */
    public function getConnection()
    {
        $db = new PDO('sqlite:' . DB_FILE);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    }

    /**
     * Creates an instance of SqliteConnection if it doesn't exist and returns it.
     * @return SqliteConnection the unique instance of SqliteConnection
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new SqliteConnection();
        }
        return self::$instance;
    }

}
