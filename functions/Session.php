<?php

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

    function login($pw) {
        if($pw == $this->settings["application_password"]){
            setcookie("sko_magazijn", md5($pw), time() + 360000, '/');
            return true;
        }
        return false;
    }

    function logout() {
        setcookie("sko_magazijn", "", time()-3600, '/');
    }

    function handleRequests() {

    }
}

$session = new Session();
?>