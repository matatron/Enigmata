<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-file"></i></span><h5>Crear Cupon</h5></div>
            <div class="widget-content nopadding">
                <form method="post" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Código</label>
                        <div class="col-sm-3 col-md-3 col-lg-4">
                            <input type="text" class="form-control input-sm" name="code" />
                        </div>
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Descuento</label>
                        <div class="col-sm-1 col-md-1 col-lg-2">
                            <input type="text" class="form-control input-sm" name="discount" id="discountField" value="16.66666666666"/>
                        </div>
                        <label class="col-sm-2 col-md-2 col-lg-2 control-label"  id="discountCalculation">Descuento</label>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Fecha límite</label>
                        <div class=" col-sm-3 col-md-3 col-lg-4">
                            <input type="text" data-date="" data-date-format="dd-mm-yyyy" value="" class="datepicker form-control input-sm"  name="limitdate"/>
                        </div>
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Usos límite</label>
                        <div class=" col-sm-3 col-md-3 col-lg-4">

                            <input type="text" class="form-control input-sm" placeholder="-1 = infinitos" name="limituses"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Grupo mínimo</label>
                        <div class=" col-sm-3 col-md-3 col-lg-4">
                            <input type="text" value="2" class="form-control input-sm"  name="mingroup"/>
                        </div>
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Descripción</label>
                        <div class=" col-sm-3 col-md-3 col-lg-4">
                            <textarea rows="2" class="form-control" name="description"></textarea>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Crear cupón</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-file"></i></span><h5>Cupones</h5></div>
            <div class="widget-content nopadding">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Fecha de creación</th>
                            <th>Usuario</th>
                            <th>Código</th>
                            <th>Descuento</th>
                            <th>Fecha límite</th>
                            <th>Usos restantes</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($coupons as $cpn) { ?>
                        <tr>
                            <td><?=date("d/M/Y h:i", $cpn->date);?></td>
                            <td><?=$cpn->user->username;?></td>
                            <td><?=$cpn->code;?></td>
                            <td><?=($cpn->discount<0) ? $cpn->discount." persona" : $cpn->discount."% descuento";?></td>
                            <td><?=date("d/M/Y", $cpn->limitdate);?></td>
                            <td><?=$cpn->limituses;?></td>
                            <td><?php
                                                         if ($cpn->limitdate != null && $cpn->limitdate<time()) echo "Vencido ";
                                                         if ($cpn->limituses == 0) echo "Agotado ";
                                ?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
