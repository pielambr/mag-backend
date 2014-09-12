var password;
var dealers;
var map;
$('document').ready(function() {
    password = $.cookie("sko_magazijn");
    $('#barcode_btn').click(newBarcode);
    loadData();
    loadMap();
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
                if(value["latitude"] && value["longitude"] && value["latitude"] != "" && value["longitude"] != ""){
                    var loc = $('<td>').
                        html('<a href="http://maps.google.com/?q=' + value["latitude"] + ',' + value["longitude"] + '" target="_blank"><span class="glyphicon glyphicon-globe"></span></a>').
                        css("text-align", "center");
                    row.append(loc);
                }
                if(value["returned"] != 0){
                    row.addClass("success");
                }
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
        data: {"password": password, "leverancier": leverancier, "barcode": code, "description":descr}
    }).fail(function(e){
            alert("Error happened during insert");
        }).done(function(data) {
            $('#barcode_dialog').dialog();
            setTimeout(function(){ $('#barcode_dialog').dialog("close")}, 2000);
            loadData();
        })
}

function loadMap() {
    var mapDiv = $('#magazijn_map');
    var codes = [];
    if(mapDiv.length != 0) {
            var mapOptions = {
                zoom: 8,
                center: new google.maps.LatLng(-34.397, 150.644)
            };
            map = new google.maps.Map(document.getElementById('magazijn_map'),
                mapOptions);
        $.ajax({
            dataType: "json",
            type: "POST",
            url: "./functions/API.php?action=print",
            data: {"password" : password}
        }).fail(function(){
                alert("Getting barcodes failed!");
            }).done(function(data) {
                $.each(data, function(key, value){
                    // Add items that are not returned and have a last known location
                    if(value["returned"] != 1 && value["longitude"] != "" && value["latitude"] != "" && value["latitude"] && value["longitude"]) {
                        codes.push(value);
                    }
                });
                if(codes.length > 0){
                    addMarkers(codes);
                }
            });
    }
}

function addMarkers(codes) {
    var x = 0;
    var y = 0;
    $.each(codes, function(key, value) {
        var myLatlng = new google.maps.LatLng(value["latitude"], value["longitude"]);
        var infowindow = new google.maps.InfoWindow({
            content: '<div style="width:200px; height:100px">' + '<h2>' + value["code"] + '</h2>' +value["description"] + " - Supplied by: " + value["leverancier"] +'</div>'
        });
        var marker = new google.maps.Marker({
            position: myLatlng,
            title: value["code"]
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map,marker);
        });
        marker.setMap(map);
        x = value["latitude"];
        y = value["longitude"];
    });
    map.setCenter(new google.maps.LatLng(x,y));
}