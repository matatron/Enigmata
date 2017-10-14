<a class="btn btn-default pull-right" href="slots">Modificar horario de salas</a>
<div class="table-responsive">
    <table class="table" style="table-layout: fixed">
        <tr>
            <th>Semana</th>
            <td>Lunes</td>
            <td>Martes</td>
            <td>Miercoles</td>
            <td>Jueves</td>
            <td>Viernes</td>
            <td>Sabado</td>
            <td>Domingo</td>
        </tr>
        <?php
        $day = $data["weekstart"];
        for($i=0; $i<12; $i++)
        { ?>
        <tr>
            <th><?=date("W", $day); ?></th>
            <?php for($j=0; $j<7; $j++) { ?>
            <td class="daycell month<?=date("m", $day); ?>" data-day="<?=date("Y-n-j", $day); ?>">
                <?=date("d", $day); $day += 86400;?>
                <button class="btn btn-block accion-abrir" onclick="abrir(this)">Abrir</button>
                <button class="btn btn-block accion-editar btn-info"  onclick="editar(this)">Editar</button>
            </td>
            <?php } ?>
        </tr>
        <?php

        } ?>
    </table>
</div>