var password;
var dealers;
$('document').ready(function() {
    password = $.cookie("sko_magazijn");
    $('#barcode_btn').click(newBarcode);
    loadData();
});

function loadData() {
    var table = $('#barcode_tabel');
    if(table.length != 0) {
        loadBarcodes();
        loadDealers();
    }
}

function loadBarcodes() {
    var table = $('#barcode_tabel');
    // Load barcodes
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "./functions/API.php?action=print",
        data: {"password" : password}
    }).fail(function(){
            alert("Getting barcodes failed!");
        })
        .done(function(data){
            table.empty();
            $.each(data, function(key, value){
                var row = $('<tr>');
                var code = $('<td>').text(value["code"]);
                row.append(code);
                var descr = $('<td>').text(value["description"]);
                row.append(descr);
                var lever = $('<td>').text(value["leverancier"]);
                row.append(lever);
                table.append(row);
            });
        });
}

function loadDealers() {
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "./functions/API.php?action=dealers",
        data: {"password": password}
    }).fail(function(){
            alert("Getting dealers failed!");
        })
        .done(function(data){
            dealers = [];
            $.each(data, function(key, value) {
                dealers.push(value["naam"]);
            });
            $('#barcode_dealer').autocomplete({source: dealers});
        });
}

function newBarcode() {
    var code = $('#barcode_code').val();
    var descr = $('#barcode_name').val();
    var leverancier = $('#barcode_dealer').val();
    $.ajax({
        dataType: "json",
        type: "POST",
        url: "./functions/API.php?action=insert",
        data: {"password": password, "leverancier": leverancier, "barcode": code, "beschr":descr}
    }).fail(function(e){
            alert("Error happened during insert");
        }).done(function(data) {
            $('#barcode_dialog').dialog();
            setTimeout(function(){ $('#barcode_dialog').dialog("close")}, 2000);
            loadData();
        })
}