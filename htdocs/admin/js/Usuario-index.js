$(document).ready(function(){

    $('.toggler').on('ifClicked ifChanged ifChecked ifUnchecked', function(event){
        var id = $(event.target).data("id");
        if(event.type ==="ifChecked"){
            console.log("check", id);
            $.ajax('/admin/usuario/sendemail/'+id).done(function(response) {
            });

        }
        if(event.type ==="ifUnchecked"){
            console.log("uncheck", id);
            $.ajax('/admin/usuario/nosendemail/'+id).done(function(response) {
            });
        }
    });
});
