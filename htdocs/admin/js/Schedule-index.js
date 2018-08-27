$(document).ready(function(){

    window.abrir = function (e) {
        $.ajax('/admin/rsvp/abrirdia/'+$(e).parent().data("day")).done(function(response) {
            console.log(response);
            $(e).parent().addClass("abierto");
        });
    }

    window.cerrar = function (e) {
        $.ajax('/admin/rsvp/cerrardia/'+$(e).parent().data("day")).done(function(response) {
            console.log(response);
            (response == 0) ? $(e).parent().removeClass("abierto") : $(e).parent().addClass("abierto");
        });
    }

    function getAllInfo() {

        $.ajax('/admin/rsvp/futureinfo/'+$(".daycell").first().data("day")).done(function(response) {
            $("#cronograma").show();
            $(".daycell").each(function(i, day) {
                day = $(day);
                if (response[day.data("day")] > 0) day.addClass("abierto");
            });
        });

    }


    $("#cronograma").hide();

    getAllInfo();
});
