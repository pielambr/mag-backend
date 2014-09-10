<?php
require_once(dirname(__FILE__) . '/util.php');
class Session {

    private $settings;

    function __construct() {
        $this->settings = include(dirname(__FILE__) . "/../settings.php");
        $this->handleRequests();
    }

    function isLoggedIn() {
        if(isset($_COOKIE["sko_magazijn"]) && $_COOKIE["sko_magazijn"] === md5($this->settings["application_password"])){
            return true;
        }
        return false;
    }

    function login() {
        if(Utility::checkPostRequest(("password"))){
            if($_POST["password"] == $this->settings["application_password"]){
                setcookie("sko_magazijn", md5($_POST["password"]), time() + 360000, '/');
                Utility::redirectIndex();
                die();
            }
        }
        Utility::redirectIndex();
        die();
    }

    function logout() {
        setcookie("sko_magazijn", "", time()-3600, '/');
        Utility::redirectIndex();
        die();
    }

    function handleRequests() {
        if(array_key_exists("action", $_GET)){
            switch ($_GET["action"]) {
                case "logout":
                    $this->logout();
                    return;
                case "login":
                    $this->login();
                    return;
            }
        }
    }
}

$session = new Session();
?>