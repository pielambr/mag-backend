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
            $connection_string = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $this->settings["database_host"], $this->settings["database_name"]);
            $this->connection = new PDO($connection_string, $this->settings["database_user"], $this->settings["database_password"], array(PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $ex){
            http_response_code(500);
            die("<b>Database error:</b> Cannot connect to database - Wrong username?");
        }
    }

    function getBarcodes() {
        $stmt = $this->connection->prepare("SELECT code, description, naam AS leverancier, returned, latitude, longitude FROM barcodes
                                        LEFT OUTER JOIN leveranciers ON
                                        barcodes.leverancier = leveranciers.id
                                        UNION
                                        SELECT code, description, naam AS leverancier, returned, latitude, longitude FROM barcodes
                                        RIGHT OUTER JOIN leveranciers ON
                                        barcodes.leverancier = leveranciers.id
                                        ");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    function getLeveranciers() {
        $stmt = $this->connection->prepare("SELECT * FROM leveranciers");
        $stmt->execute();
        $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $res;
    }

    function insertBarcode($values) {
        try {
            $leverancier_id = $values["leverancier"] ? $this->checkLeverancier($values["leverancier"]) : null;
            $stmt = $this->connection->prepare("INSERT INTO barcodes(code, description, leverancier, latitude, longitude) VALUES(:code, :descr, :lever, :lat, :long)");
            $stmt->bindParam(":lever", $leverancier_id);
            $stmt->bindParam(":code", $_POST["barcode"]);
            $stmt->bindParam(":descr", $_POST["beschr"]);
            $stmt->bindParam(":lat", $values["latitude"]);
            $stmt->bindParam(":long", $values["longitude"]);
            $stmt->execute();
            return array("success" => "Successfully inserted data");
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function insertLeverancier($value) {
        $stmt = $this->connection->prepare("INSERT INTO leveranciers(naam) VALUES(:naam)");
        $stmt->bindParam(":naam", $value);
        $stmt->execute();
        return $this->connection->lastInsertId();
    }

    function checkLeverancier($value) {
        $stmt = $this->connection->prepare("SELECT * FROM leveranciers WHERE naam = :naam");
        $stmt->bindParam(":naam", $value);
        $stmt->execute();
        if($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row["id"];
        } else {
            return $this->insertLeverancier($value);
        }
    }
}

$database = new Database();
?>