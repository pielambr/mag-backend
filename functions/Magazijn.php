<?php
require_once(dirname(__FILE__) . '/Database.php');
require_once(dirname(__FILE__) . '/Session.php');

class Magazijn {

    private $database;
    private $session;

    function __construct(){
        global $database, $session;
        $this->database = $database;
        $this->session = $session;
    }

    function addBarcode() {

    }

    function deleteBarcode(){

    }

    function updateBarcode(){

    }

    function printMagazijn() {
        if($this->session->isLoggedIn()){

        } else {
            printLogin();
        }
    }

    function printNav() {
        echo '<nav class="navbar navbar-default" role="navigation">
                <div class="container">
                    <button type="button" class="btn btn-default navbar-btn right" href="functions/Session.php?action=logout">Logout</button>
                </div>
            </nav>';
    }

    function printLogin() {
        echo '<div class = col-md-12>
                <form class="center-block" role="form" method="post" action="functions/Session.php?action=login">
                    <label for="password">Password</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
            </div>';
    }

}
$magazijn = new Magazijn();
?>