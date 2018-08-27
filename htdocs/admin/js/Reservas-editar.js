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
    $("#btnMover").click(function() {
        $.ajax('/admin/rsvp/alldays/').done(function(response) {
            $("#divConfirmarMover").hide();
            $("#divMoverReserva").show().removeClass("hidden");
            $("#moverFecha").empty();
            $("#moverFecha").append($("<option value='' selected>Seleccione una fecha</option>"))
            $.each(response, function(i, item) {
                $("#moverFecha").append($("<option value='"+item+"'>"+item+"</option>"))
            })
        });
    });
    $("#moverFecha").on("change", function() {
        $("#fieldID").val(window.resid);
        $.ajax('/admin/rsvp/allhours/'+$("#moverFecha").val()).done(function(response) {
            $("#moverHora").empty();
            $("#moverHora").append($("<option value='' selected>Seleccione una hora</option>"))
            $.each(response, function(i, item) {
                var parts = item.unicode.split(":");
                $("#moverHora").append($("<option value='"+item.id+"'>Cuarto "+parts[0]+" Hora "+parts[2]+"</option>"))
            })
        });
    });
    $("#moverHora").on("change", function() {
        $("#fieldID").val(window.resid);
        $("#divConfirmarMover").show();
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

    $("#buscarIp").click(function() {
        ip = $("#buscarIp").data("ip");
        $("#ipInfo").html("Buscando...");
        $.ajax('http://freegeoip.net/json/'+ip).done(function(response) {
            $("#ipInfo").html(response.region_name+", "+response.country_name);
        });
    });


});
