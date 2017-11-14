$(document).ready(function(){

    var enviado = false;

    $("#btnVerMas").click(function() {
        $("#MasAcciones").show().removeClass("hidden");
        $("#btnVerMas").hide();
    })

    $("#MasAcciones").hide();

    $("#btnResend").click(function() {
        if (!enviado) {
            enviado = true;
            $("#btnResend").html("Enviando...");
            $.ajax('/admin/rsvp/resend/'+window.resid).done(function(response) {
                $("#btnResend").html("Enviado");
            });
        }
    });
    $("#btnBorrar").click(function() {
        $("#divBorrarReserva").show().removeClass("hidden");
    });
    $("#BorrarReserva").click(function() {
        $.post('/admin/rsvp/delete', {codigo: $("#VerificarBorrar").val(), id: window.resid}).done(function(response) {
            if (response.result) {
                window.location.pathname = "/admin/reservas/index";
            } else {
                $("#BorrarReserva").html("CODIGO INCORRECTO");
            }
        });
    });

});
