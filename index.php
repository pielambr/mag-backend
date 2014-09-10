<!DOCTYPE html>
<html>
<?php
error_reporting(E_ALL | E_STRICT);
ini_set('display_errors',1);
ini_set('html_errors', 1);
require_once(dirname(__FILE__) . '/functions/Magazijn.php');
global $magazijn;
?>
<head>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/magazijn.js"></script>
    <title>Magazijn</title>
</head>
<body>
<div class="container" id="content">
<?php
$magazijn->printMagazijn();
?>
</div>
</body>
</html>