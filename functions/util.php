<?php
class Utility {

    static function checkPostRequest($variables){
        foreach($variables as $i){
            if(!isset($_POST[$i]) || $_POST[$i] == ""){
                http_response_code(400);
                return false;
            }
        }
        return true;
    }

    static function redirectIndex(){
        header("Location: " . Utility::getPath() . "/../index.php");
        die();
    }

    static function getPath() {
        $server = 'http://' . $_SERVER['HTTP_HOST'];
        $server .= rtrim(dirname($_SERVER['PHP_SELF']), '/\\');;
        return $server;
    }

    static function checkValues($values, $arr) {
        foreach($values as $i) {
            if(!array_key_exists($i, $arr)){
                return false;
            } else {
                return true;
            }
        }
    }

    static function json_die($content) {
        header('Content-Type: application/json; Charset=UTF-8');
        die(json_encode($content));
    }
}
?>