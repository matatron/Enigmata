$(document).ready(function(){

    window.abrir = function (e) {
        $.ajax('/admin/rsvp/abrirdia/'+$(e).parent().data("day")).done(function(response) {
            console.log(response);
            $(e).parent().addClass("abierto");
        });
    }

    function getAllInfo() {

        $.ajax('/admin/rsvp/futureinfo/'+$(".daycell").first().data("day")).done(function(response) {
            console.log(response);
            $(".daycell").each(function(i, day) {
                day = $(day);
                if (response[day.data("day")] > 0) day.addClass("abierto");
            });
        });

    }



    getAllInfo();
});
