<button id="btn_save" class="btn btn-sm btn-primary pull-right">Guardar cambios</button>
<a href="index" class="btn btn-sm btn-default">Volver al cronograma</a>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon">
                <i class="fa fa-th"></i>
                </span><h5>Horario</h5></div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped table-hover schedule-table">
                    <thead>
                        <tr>
                            <th width="10%"></th>
                            <th width="45%">
                                <strong>Sala 1</strong>:
                                Jugadores <input type="number" id="r1min" style="width: 30px;"/>-<input type="number" id="r1max" style="width: 30px;"/>
                                Habilitada <input type="checkbox" id="r1enabled" />
                            </th>
                            <th width="45%">
                                <strong>Sala 2</strong>:
                                Jugadores <input type="number" id="r2min" style="width: 30px;"/>-<input type="number" id="r2max" style="width: 30px;"/>
                                Habilitada <input type="checkbox" id="r2enabled"/>
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