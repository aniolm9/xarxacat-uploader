var anterior = "#" + $("#show option:selected").val();
$(anterior).show();
var actual = "";

$("#show").change(function() {
    $("#ClassMulti").val("---");
    $("#DWmulti").val("---");
    $("#OPmulti").val("---");
    $("#TSJAmulti").val("---");
    $("#TWmulti").val("---");
    actual = "#" + $("#show option:selected").val();

    $(anterior).hide();
    $(actual).show();
    anterior = actual;
    actual = "";
});
