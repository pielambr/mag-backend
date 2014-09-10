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
            $this->printNavigation();
            $this->printBarcodes();
            $this->printBarcodeForm();
        } else {
            $this->printLogin();
        }
    }

    function printBarcodeForm() {
        echo '<div class="col-md-4">
                <form role="form">
                    <label for="code">Code</label>
                    <input type="text" class="form-control" id="code" placeholder="Barcode">
                    <label for="name">Naam</label>
                    <input type="text" class="form-control" id="name" placeholder="Product naam">
                    <label for="name">Leverancier</label>
                    <input type="text" class="form-control" id="dealer" placeholder="Leverancier">
                    <button type="submit" class="btn btn-default">Insert</button>
            </form>';
    }

    function printBarcodes() {
        echo '<div class="col-md-8">
                <table class="table table-bordered">'
                        . '' .
                '</table>
            </div>';
    }

    function printNavigation() {
        echo '<nav class="navbar navbar-default" role="navigation">
                <div class="container">
                    <a type="button" class="btn btn-default navbar-btn right" href="functions/Session.php?action=logout">Logout</a>
                </div>
            </nav>';
    }

    function printLogin() {
        echo '<div class = col-md-4>
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