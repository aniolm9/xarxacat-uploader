var anterior = "#" + $("#sho option:selected").val();
$(anterior).show();
var actual = "";

$("#sho").change(function() {
    $("#classMulti").val("---");
    $("#DWmulti").val("---");
    $("#OPmulti").val("---");
    $("#TSJAmulti").val("---");
    $("#TWmulti").val("---");
    actual = "#" + $("#sho option:selected").val();

    $(anterior).hide();
    $(actual).show();
    anterior = actual;
    actual = "";
});
