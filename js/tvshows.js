var anterior = "#" + $("#show option:selected").val();
$(anterior).show();
var actual = "";

$("#show").change(function() {
    $("#ClassMulti").val("---");
    $("#DWMulti").val("---");
    $("#OPMulti").val("---");
    $("#TSJAMulti").val("---");
    $("#TWMulti").val("---");
    actual = "#" + $("#show option:selected").val();

    $(anterior).hide();
    $(actual).show();
    anterior = actual;
    actual = "";
});
