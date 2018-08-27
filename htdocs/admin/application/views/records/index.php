<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-clock-o"></i></span><h5>Records</h5></div>
            <div class="widget-content nopadding">
                <form method="post">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th colspan="2">Cuarto 1</th>
                            <th colspan="2">Cuarto 2</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>Equipo</th>
                            <th width="10%">Tiempo</th>
                            <th>Equipo</th>
                            <th width="10%">Tiempo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($i=2; $i<=8; $i++) { ?>
                        <tr>
                            <td><?=$i;?></td>
                            <?php foreach ($records as $cuarto => $data) { ?>
                            <td><input type="text" class="form-control" name="record[<?=$cuarto;?>][<?=$i;?>][name]" value="<?=$data[$i]["name"];?>"/></td>
                            <td><input type="text" class="form-control" name="record[<?=$cuarto;?>][<?=$i;?>][time]" value="<?=$data[$i]["time"];?>"/></td>
                            <?php } ?>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
                    <input type="submit" value="Guardar" class="btn btn-primary" />
                </form>
            </div>
        </div>
    </div>
</div>
