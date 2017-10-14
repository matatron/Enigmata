$(document).ready(function(){

    $('.schedule-table td').click(function() {
        var slot = $(this).data('key');
        $(this).append(newSlot());
    });

    function newSlot() {
        var s = $("<div class='slot'></div>");
        s.click(function(e) {
            e.stopPropagation();
            $(this).remove();
        });
        return s;
    }

    function saveSlots() {
        var object = {
            r1 : {
                minimum: 0,
                maximum: 0,
                enabled: 0,
                slots: []
            },
            r2 : {
                minimum: 0,
                maximum: 0,
                enabled: 0,
                slots: []
            }
        };
        $('.slot').each(function(i, item) {
            item = $(item).parent();
            object[item.data('room')].slots.push(item.data('key'));
        });
        object.r1.slots.sort();
        object.r2.slots.sort();
        object.r1.minimum = $("#r1min").val();
        object.r1.maximum = $("#r1max").val();
        object.r2.minimum = $("#r2min").val();
        object.r2.maximum = $("#r2max").val();
        object.r1.enabled = $("#r1enabled").prop("checked") ? 1 : 0;
        object.r2.enabled = $("#r2enabled").prop("checked") ? 1 : 0;
        $.post('/admin/settings/write', object)
            .done(function( data ) {
            console.log( "Data Loaded: " + data );
        });
    }

    window.actualizarSlots = function() {
        $(".slot").remove();
        $.ajax('/admin/settings/read').done(function(response) {
            window.settings = response;

            $("#r1min").val(response.r1.minimum);
            $("#r1max").val(response.r1.maximum);
            $("#r2min").val(response.r2.minimum);
            $("#r2max").val(response.r2.maximum);
            $("#r1enabled").prop("checked", response.r1.enabled);
            $("#r3enabled").prop("checked", response.r1.enabled);
            $.each(window.settings.r1.slots, function(i, s) {
                $('#r1'+s).append(newSlot());
            });
            $.each(window.settings.r2.slots, function(i, s) {
                $('#r2'+s).append(newSlot());
            });
        });

    }

    $('input').iCheck('destroy');
    $("#btn_save").click(saveSlots);
    actualizarSlots();
});
