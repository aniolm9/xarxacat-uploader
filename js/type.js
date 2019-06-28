var tipus_anterior = "";
var tipus_actual = "";

$("#tipus").change(function() {
    var selected = $("#tipus option:selected").val();
    if (selected == "capitol" || selected == "minisodi" || selected == "prequel") {
        tipus_actual = "#numero";
    }
    else if (selected == "peli") {
        tipus_actual = "#any";
    }

    $(tipus_anterior).hide();
    $(tipus_actual).show();
    tipus_anterior = tipus_actual;
    tipus_actual = "";
});
