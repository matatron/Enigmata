<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fa fa-align-justify"></i>
                </span>
                <h5>Detalles de la reservación</h5>
            </div>
            <div class="widget-content nopadding">
                <form action="#" method="get" class="form-horizontal">
                    <div class="row">
                        <div class="col-sm-2 bold">Fecha</div>
                        <div class="col-sm-4">
                            <?=date("d/m/Y h:i",$reservacion->date);?>
                        </div>
                        <div class="col-sm-2 bold">Código</div>
                        <div class="col-sm-4">
                            <?=$reservacion->unicode;?>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col-sm-2 bold">Hecha por</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->name;?></div>
                        </div>
                        <div class="col-sm-2 bold">Personas</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->people;?></div>
                        </div>
                        <div class="col-sm-2 bold">Teléfono</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->phone;?></div>
                        </div>
                        <div class="col-sm-2 bold">Email</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->email;?></div>
                        </div>
                        <div class="col-sm-2 bold">Hecha el</div>
                        <div class="col-sm-4">
                            <div><?=date("d/m/Y h:i",$reservacion->reservationdate);?></div>
                        </div>
                        <div class="col-sm-2 bold">Desde el IP</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->ip;?></div>
                        </div>
                    </div>
                    <br/>


                    <!--div class="form-group">
                        <label class="col-sm-3 col-md-3 col-lg-2 control-label">Read-only input</label>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <input type="text" class="form-control input-sm" placeholder="You can only read this..." readonly />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="" class="col-sm-3 col-md-3 col-lg-2 control-label">Input with icon</label>
                        <div class="col-sm-9 col-md-9 col-lg-10">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="input-icon icon-sm">
                                        <i class="fa fa-tint"></i>
                                        <input type='text' title="Tooltip on input field" class="tip-bottom form-control input-sm"  placeholder="This is a placeholder..." />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div-->

                    <div class="form-group row">
                        <div class="col-sm-2 bold">Comentarios</div>
                        <div class="col-sm-10">
                            <textarea rows="5" class="form-control"></textarea>
                        </div>
                        <div class="col-sm-2 bold">Estado</div>
                        <div class="col-sm-10">
                            <select class="">
                                <option value="0">Sin confirmar</option>
                                <option value="1">Confirmada</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        <a class="btn btn-default" href="/admin/reservas/index">Cancelar</a>
                        <button class="btn btn-default">Más acciones</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>