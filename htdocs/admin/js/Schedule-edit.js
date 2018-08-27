$(document).ready(function(){
    /*

        $.ajax('/admin/rsvp/abrirdia/'+$(e).parent().data("day")).done(function(response) {
            $(e).parent().addClass("abierto");
        });


*/

    window.habilitar = function(button) {
        $.ajax('/admin/rsvp/habilitar/'+$(button).parent().data("unicode")).done(function(response) {
            actualizarDatos();
        });
    }

    window.inhabilitar = function(button) {
        $.ajax('/admin/rsvp/inhabilitar/'+$(button).parent().parent().data("unicode")).done(function(response) {
            actualizarDatos();
        });
    }

    function newSlot(unicode) {
        var s = $("#slotTemplate > div").clone();
        s.data("unicode", unicode);
        s.click(function(e) {
        });
        return s;
    }

    function newReservation(res) {
        var s = $("#resTemplate > div").clone();
        s.data("unicode", res.unicode);
        s.data("id", res.id);
        $(".resname", s).text(res.name);
        $(".editar", s).attr("href", "/admin/reservas/editar/"+res.id);
        if (res.people) s.addClass("reservado");
        s.click(function(e) {
        });
        return s;
    }

    function actualizarDatos() {

        $.ajax('/admin/rsvp/fulldayinfo/'+window.daycode).done(function(response) {
            window.data = response;

            $("#daycontent .dayslot").remove();
            $.each(window.data.slots, function(i, slots) {
                $.each(slots, function(t) {
                    $("#r"+i+t).append(newSlot(i+":"+window.daycode+":"+t));
                });
            });

            $("#daycontent .dayres").remove();
            $.each(window.data.reservations, function(i, res) {
                $("#r"+i).append(newReservation(res));
            });

        });

    }

    actualizarDatos();
    window.actualizarDatos = actualizarDatos;
});
