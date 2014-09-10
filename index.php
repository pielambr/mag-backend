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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/ui-lightness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-2.1.1.min.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.min.js"></script>
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