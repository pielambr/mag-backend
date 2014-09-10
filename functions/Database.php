<?php

class Database {

    private $settings;
    private $connection;

    function __construct() {
        $this->settings = include(dirname(__FILE__) . "/../settings.php");
        $this->connect();
    }

    function connect() {
        try {
            $connection_string = sprintf("mysql:host=%s;dbname:%s", $this->settings["database_host"], $this->settings["database_name"]);
            $this->connection = new PDO($connection_string, $this->settings["database_user"], $this->settings["database_password"]);
        } catch (PDOException $ex){
            die("<b>Database error:</b> Cannot connect to database - Wrong username?");
        }
    }
}

$database = new Database();
?>