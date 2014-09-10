<?php
class Utility {
    function __construct() {
        $this->handleRequests();
    }

    function handleRequests() {
        if(array_key_exists("redirect", $_GET)){
            header("Location: " . $_GET["redirect"]);
        }
    }

    function checkGetRequest($variables) {
        //
    }

    static function checkPostRequest($variables){
        foreach($variables as $i){
            if(!isset($_POST[$i])){
                http_response_code(400);
                return false;
            }
        }
        return true;
    }

    static function redirect($url){
        header("Location: " . dirname(__FILE__) . "/util.php?request=" . $url);
    }
}
$util = new Utility();
?>