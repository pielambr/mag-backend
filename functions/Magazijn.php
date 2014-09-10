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
        echo '<div class="col-md-4 form-group">
                <div class="input-group">
                    <input type="text" id="barcode_code" class="form-control" placeholder="Barcode">
                </div>
                <div class="input-group">
                    <input type="text" id="barcode_name" class="form-control" placeholder="Beschrijving">
                </div>
                <div class="input-group">
                    <input type="text" id="barcode_dealer" class="form-control" placeholder="Leverancier">
                </div>
                <button id="barcode_btn" class="btn btn-default">Insert</button>
            </div>';
    }

    function printBarcodes() {
        echo '<div class="col-md-8">
                <div id="barcode_dialog" class="hidden" title="Barcode added">Barcode successfully added!</div>
                <table class="table table-bordered" id ="barcode_tabel">
                </table>
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