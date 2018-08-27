<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-file"></i></span><h5>Próximas reservacioes</h5></div>
            <div class="widget-content nopadding">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cuarto</th>
                            <th>Fecha</th>
                            <th>Personas</th>
                            <th>Responsable</th>
                            <th>Idioma</th>
                            <th>Confirmada</th>
                            <th>Cupón</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        $total = 0;
                        $lastMes = date("m", $reservaciones[0]->date);
                        foreach($reservaciones as $res) {
                            $i++;
                            $mes = date("m", $res->date);
                            if ($mes != $lastMes) {
                                $lastMes = $mes;
                        ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total del mes</td>
                            <td><?=$total;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>

<?php
                                $total = 0;
                            }
                            $total += $res->people;

                        ?>
                        <tr>
                            <td><?=$i?> </td>
                            <td class="cuarto<?=substr($res->unicode, 0, 1);?>"><?=substr($res->unicode, 0, 1);?></td>
                            <td><?=iconv('ISO-8859-2', 'UTF-8', strftime("%a, %d/%b/%Y %H:%M", $res->date));?></td>
                            <td><?=$res->people;?></td>
                            <td>
                                <?=$res->name;?><br/>
                                <?=$res->email;?><br/>
                                <a href="tel:<?=$res->phone;?>"><?=$res->phone;?></a>
                            </td>
                            <td class="<?=$res->language=="EN"?"success bold":"";?>"><?=$res->language;?></td>
                            <td class="<?=$res->confirmed?"":"danger bold";?>"><?=$res->confirmed?"Si":"No";?></td>
                            <td class="<?=($res->hasCoupon && !$res->redeemed)?"danger":"";?> <?=$res->redeemed?"success":"";?>">
                                <?=$res->hasCoupon?"SI":"";?>
                                <?=$res->redeemed?"<br>REDIMIDO":"";?>
                            </td>
                            <td><a href="/admin/reservas/editar/<?=$res->id;?>" class="btn btn-primary">Editar</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Total del mes</td>
                            <td><?=$total;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
                <a href="archive" class="btn btn-default btn-block">Ver reservas anteriores</a>
            </div>
        </div>
    </div>
</div>
