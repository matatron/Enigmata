<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-file"></i></span><h5>Próximas reservacioes</h5></div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Cuarto</th>
                            <th>Personas</th>
                            <th>Correo</th>
                            <th>Confirmada</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($reservaciones     as $res) { ?>
                        <tr>
                            <td><?=date("d/M h:i", $res->date);?></td>
                            <td><?=substr($res->unicode, 0, 1);?></td>
                            <td><?=$res->people;?></td>
                            <td><?=$res->email;?></td>
                            <td><?=$res->confirmed?"Si":"No";?></td>
                            <td><a href="/admin/reservas/editar/<?=$res->id;?>" class="btn btn-primary">Editar</a></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
