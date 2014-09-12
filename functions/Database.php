<?php

class Database
{

    private $settings;
    private $connection;

    function __construct()
    {
        $this->settings = include(dirname(__FILE__) . "/../settings.php");
        $this->connect();
    }

    function connect()
    {
        try {
            $connection_string = sprintf("mysql:host=%s;dbname=%s;charset=utf8", $this->settings["database_host"], $this->settings["database_name"]);
            $this->connection = new PDO($connection_string, $this->settings["database_user"], $this->settings["database_password"], array(PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
        } catch (PDOException $ex) {
            http_response_code(500);
            die("<b>Database error:</b> Cannot connect to database - Wrong username?");
        }
    }

    function getBarcodes()
    {
        try {
            $stmt = $this->connection->prepare("SELECT code, description, naam AS leverancier, returned, latitude, longitude, last_updated FROM barcodes
                                        LEFT OUTER JOIN leveranciers ON
                                        barcodes.leverancier = leveranciers.id
                                        UNION
                                        SELECT code, description, naam AS leverancier, returned, latitude, longitude, last_updated FROM barcodes
                                        RIGHT OUTER JOIN leveranciers ON
                                        barcodes.leverancier = leveranciers.id
                                        ");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($res){
                return $res;
            } else {
                return array();
            }
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function getLeveranciers()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM leveranciers");
            $stmt->execute();
            $res = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if($res){
                return $res;
            } else {
                return array();
            }
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function insertBarcode($values)
    {
        try {
            $leverancier_id = $values["leverancier"] ? $this->checkLeverancier($values["leverancier"]) : null;
            $stmt = $this->connection->prepare("INSERT INTO barcodes(code, description, leverancier, latitude, longitude) VALUES(:code, :descr, :lever, :lat, :long)");
            $stmt->bindParam(":lever", $leverancier_id);
            $stmt->bindParam(":code", $_POST["barcode"]);
            $stmt->bindParam(":descr", $_POST["description"]);
            $stmt->bindParam(":lat", $values["latitude"]);
            $stmt->bindParam(":long", $values["longitude"]);
            $stmt->execute();
            return array("success" => "Successfully inserted data");
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function insertLeverancier($value)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO leveranciers(naam) VALUES(:naam)");
            $stmt->bindParam(":naam", $value);
            $stmt->execute();
            return $this->connection->lastInsertId();
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function checkLeverancier($value)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM leveranciers WHERE naam = :naam");
            $stmt->bindParam(":naam", $value);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                return $row["id"];
            } else {
                return $this->insertLeverancier($value);
            }
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function checkoutBarcode($values)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE barcodes SET returned = 1 WHERE code = :code");
            $stmt->bindParam(":code", $values["barcode"]);
            $stmt->execute();
            return array("success" => "Item checked out!");
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function getBarcode($values)
    {
        try {
            $stmt = $this->connection->prepare("SELECT code, description, naam AS leverancier, returned, latitude, longitude, last_updated FROM barcodes
                                        LEFT OUTER JOIN leveranciers ON
                                        barcodes.leverancier = leveranciers.id WHERE barcodes.code = :code
                                        UNION
                                        SELECT code, description, naam AS leverancier, returned, latitude, longitude, last_updated FROM barcodes
                                        RIGHT OUTER JOIN leveranciers ON
                                        barcodes.leverancier = leveranciers.id WHERE barcodes.code = :code2
                                        ");
            $stmt->bindParam(":code", $values["barcode"]);
            $stmt->bindParam(":code2", $values["barcode"]);
            $stmt->execute();
            $res = $stmt->fetch(PDO::FETCH_ASSOC);
            if($res){
                return $res;
            } else {
                return array();
            }
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }

    function updateBarcode($values) {
        try {
            $stmt = $this->connection->prepare("UPDATE barcodes
                                                SET longitude = :longitude, latitude = :latitude
                                                WHERE code = :code");
            $stmt->bindParam(":code", $values["barcode"]);
            $stmt->bindParam(":longitude", $values["longitude"]);
            $stmt->bindParam(":latitude", $values["latitude"]);
            $stmt->execute();
            return array("success" => "Item location updated!");
        } catch (PDOException $ex) {
            http_response_code(500);
            return array("error" => $ex);
        }
    }
}


$database = new Database();
?>