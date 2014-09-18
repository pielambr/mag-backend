<?php
require_once(dirname(__FILE__) . '/util.php');
require_once(dirname(__FILE__) . '/Database.php');

class API {

    private $database;
    private $settings;

    function __construct() {
        global $database;
        $this->settings = include(dirname(__FILE__) . "/../settings.php");
        $this->database = $database;
        $this->handleRequests();
    }

    function handleRequests() {
        if(array_key_exists("action", $_GET)) {
            switch($_GET["action"]) {
                case "print":
                    $this->printBarcode();
                    return;
                case "insert":
                    $this->insertBarcode();
                    return;
                case "update":
                    $this->updateBarcode();
                    return;
                case "get":
                    $this->getBarcode();
                    return;
                case "dealers":
                    $this->returnDealers();
                    return;
                case "checkout":
                    $this->checkoutBarcode();
                case "delete":
                    $this->deleteBarcode();
                default:
                    $this->api_error();
                    return;
            }
        } else {
            $this->api_error();
        }
    }

    function validPassword() {
        if($_POST["password"] == md5($this->settings["application_password"])) {
            return true;
        }
        return false;
    }

    function printBarcode() {
        if(Utility::checkPostRequest(array("password"))){
            if($this->validPassword()){
                Utility::json_die($this->database->getBarcodes());
            }
        }
        $this->missing_parameters();
    }

    function insertBarcode() {
        if(Utility::checkPostRequest(array("barcode", "description", "password"))){
            if($this->validPassword()){
                Utility::json_die($this->database->insertBarcode($_POST));
            }
        }
        $this->missing_parameters();
    }

    function updateBarcode() {
        if(Utility::checkPostRequest(array("barcode", "password", "latitude", "longitude"))){
            if($this->validPassword()){
                Utility::json_die($this->database->updateBarcode($_POST));
            }
        }
        $this->missing_parameters();
    }

    function checkoutBarcode() {
        if(Utility::checkPostRequest(array("barcode", "password"))){
            if($this->validPassword()){
                Utility::json_die($this->database->checkoutBarcode($_POST));
            }
        }
        $this->missing_parameters();
    }

    function getBarcode() {
        if(Utility::checkPostRequest(array("barcode", "password"))) {
            if($this->validPassword()) {
                Utility::json_die($this->database->getBarcode($_POST));
            }
        }
        $this->missing_parameters();
    }

    function returnDealers() {
        if(Utility::checkPostRequest(array("password"))) {
            if($this->validPassword()) {
                Utility::json_die($this->database->getLeveranciers());
            }
        }
        $this->missing_parameters();
    }

    function deleteBarcode() {
        if(Utility::checkPostRequest(array("barcode", "password"))) {
            if($this->validPassword()) {
                Utility::json_die($this->database->deleteBarcode($_POST));
            }
        }
        $this->missing_parameters();
    }

    function api_error() {
        http_response_code(400);
        Utility::json_die(array("error" => "Not a valid API call"));
    }

    function missing_parameters() {
        http_response_code(400);
        Utility::json_die(array("error" => "Missing parameters"));
    }

}
$api = new API();
?>