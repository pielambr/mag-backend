<!DOCTYPE html>
<html>
<?php
require_once('./functions/Magazijn.php');
?>
<head>
    <link type="text/css" rel="stylesheet" href="css/bootstrap.min.css">
    <script src="js/magazijn.js"></script>
    <title>Magazijn</title>
</head>
<body>
<div class="container" id="content">
<?php
if($magazijn->isLoggedin()) {
?>

    <div class="col-md-12">
        <form role="form">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" placeholder="Barcode">
            <label for="name">Naam</label>
            <input type="text" class="form-control" id="name" placeholder="Product naam">
            <label for="name">Leverancier</label>
            <input type="text" class="form-control" id="dealer" placeholder="Leverancier">
            <button type="submit" class="btn btn-default">Insert</button>
        </form>
        <table class="table table-bordered">
            <?php $magazijn->printMagazijn(); ?>
        </table>
    </div>
<?php } else { ?>

<?php } ?>
</div>
</body>
</html>