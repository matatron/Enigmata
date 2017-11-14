<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-file"></i></span><h5>Próximas reservacioes</h5></div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Cuarto</th>
                            <th>Personas</th>
                            <th>Correo</th>
                            <th>Confirmada</th>
                            <th>Cupón</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0;
                        $total = 0;
                        foreach($reservaciones     as $res) {
                            $i++;
                            $total += $res->people;
                        ?>
                        <tr>
                            <td><?=$i;?></td>
                            <td><?=iconv('ISO-8859-2', 'UTF-8', strftime("%a, %d/%b/%Y %H:%M", $res->date));?></td>
                            <td><?=substr($res->unicode, 0, 1);?></td>
                            <td><?=$res->people;?></td>
                            <td><?=$res->email;?></td>
                            <td class="<?=$res->confirmed?"":"text-danger bold";?>"><?=$res->confirmed?"Si":"No";?></td>
                            <td><?=$res->coupon->code;?></td>
                            <td><a href="/admin/reservas/editar/<?=$res->id;?>" class="btn btn-primary">Editar</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td><?=$total;?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
