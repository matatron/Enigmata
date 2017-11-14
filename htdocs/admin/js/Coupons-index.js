$(document).ready(function(){
    $('.datepicker').datepicker();

    function calcularDescuento() {
        if ($("#discountField").val()<0) {
            $("#discountCalculation").html(12000*$("#discountField").val());

        }else {
            $("#discountCalculation").html(Math.round(120*(100-$("#discountField").val()))+" por persona");
        }
    }
    $("#discountField").keyup(calcularDescuento);
    calcularDescuento();
});
