var chk1 = $("input[type='checkbox'][value='subs']");
var chk2 = $("input[type='checkbox'][value='encodar']");

chk1.on('change', function(){
    chk2.prop('checked', this.checked);
    chk2.prop('disabled', this.checked);
});