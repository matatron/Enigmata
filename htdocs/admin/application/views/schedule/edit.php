<script>
    window.daycode = "<?=$id?>";
</script>
<div id="resTemplate" class="hidden">
    <div class="dayres">
        <a href="#" class="btn btn-xs btn-info pull-right editar" target="_blank">Editar</a>
        <div class="conDatos">
            Reservado por <span class="resname"></span>
        </div>
        <div class="sinDatos">
            Espacio sin reservar
            <button onclick="inhabilitar(this)" class="btn btn-xs btn-default pull-right">Inhabilitar</button>
        </div>
    </div>
</div>
<div id="slotTemplate" class="hidden">
    <div class="dayslot">
        <button onclick="habilitar(this)" class="btn  btn-block btn-default pull-right">&gt;&gt;</button>
    </div>
</div>
<button id="btn_save" class="btn btn-sm btn-default pull-right" onclick="actualizarDatos()">Recargar datos</button>
<button id="btn_save" class="btn btn-sm btn-primary pull-right">Guardar cambios</button>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon">
                <i class="fa fa-th"></i>
                </span><h5>Horario</h5></div>
            <div class="widget-content nopadding" id="daycontent">
                <table class="table table-bordered table-striped table-hover schedule-table">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="45%">
                                <strong>Sala 1</strong>:
                            </th>
                            <th width="45%">
                                <strong>Sala 2</strong>:
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
    for($i=0; $i<28; $i++) {
        $hora = $i*0.5+8;
        $horaReloj = "".floor($hora).":".(($i%2==0)?"00":"30");
        $horaMilitar = "".floor($hora).(($i%2==0)?"00":"30");
                        ?>
                        <tr>
                            <td><div class="schedule-hour"><?=$horaReloj; ?></div></td>
                            <td id="r1<?=$horaMilitar;?>" data-room="r1" data-key="<?=$horaMilitar;?>"></td>
                            <td id="r2<?=$horaMilitar;?>" data-room="r2" data-key="<?=$horaMilitar;?>"></td>
                        </tr>
                        <?php
    }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<button id="btn_save" class="btn btn-sm btn-primary pull-right">Guardar cambios</button>