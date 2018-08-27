<script>
    window.resid = <?=$reservacion->id;?>;
</script>
<div class="row">
    <div class="col-xs-12">
        <div class="widget-box">
            <div class="widget-title">
                <span class="icon">
                    <i class="fa fa-align-justify"></i>
                </span>
                <a class="btn btn-default pull-right" href="/admin/reservas/index">Volver a reservaciones</a>
                <h5>Detalles de la reservación</h5>
            </div>
            <div class="widget-content nopadding">
                <form method="post" class="form-horizontal">
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
                        <div class="col-sm-2 bold">Cuarto</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->unicode[0];?></div>
                        </div>
                        <div class="col-sm-2 bold">Personas</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->people;?></div>
                        </div>
                        <div class="col-sm-2 bold">Hecha por</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->name;?></div>
                        </div>
                        <div class="col-sm-2 bold">Teléfono</div>
                        <div class="col-sm-4">
                            <div><a href="tel:<?=$reservacion->phone;?>"><?=$reservacion->phone;?></a></div>
                        </div>
                        <div class="col-sm-2 bold">Email</div>
                        <div class="col-sm-4">
                            <input type="text" name="email" value="<?=$reservacion->email;?>" />
                        </div>
                        <div class="col-sm-2 bold">Idioma</div>
                        <div class="col-sm-4">
                            <select class="" name="language">
                                <option value="" <?=($reservacion->language!="EN")?"selected":"";?>>Español</option>
                                <option value="EN" <?=($reservacion->language=="EN")?"selected":"";?>>Inglés</option>
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 bold">Hecha el</div>
                        <div class="col-sm-4">
                            <div><?=date("d/m/Y h:i",$reservacion->reservationdate);?></div>
                        </div>
                        <div class="col-sm-2 bold">Desde el IP</div>
                        <div class="col-sm-4">
                            <div><?=$reservacion->ip;?><button class="btn btn-small btn-sm" type="button" id="buscarIp" data-ip="<?=$reservacion->ip;?>">Buscar</button></div>
                            <div id="ipInfo"></div>
                        </div>
                    </div>
                    <br/>

                    <div class="form-group row">
                        <div class="col-sm-2 bold">Cupón o código</div>
                        <div class="col-sm-6">
                            <pre><?=$reservacion->couponraw;?></pre>
                        </div>
                        <div class="col-sm-4">
                            <input type="checkbox" name="redeemed" value="1" <?=$reservacion->redeemed?"checked":"";?> />Cupón Redimido<br/>
                            <a href="http://www.yuplon.com/retailer/coupons" target="_blank">Sitio de Yuplón</a><br/>
                            Usuario: gerencia@enigmata.co.cr <br/>
                            Pass: enig3187

                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 bold">Comentarios</div>
                        <div class="col-sm-10">
                            <textarea rows="5" class="form-control" name="comments"><?=$reservacion->comments;?></textarea>
                        </div>
                        <div class="col-sm-2 bold">Estado</div>
                        <div class="col-sm-10">
                            <select class="" name="confirmed">
                                <option value="0" <?=($reservacion->confirmed==0)?"selected":"";?>>Sin confirmar</option>
                                <option value="1" <?=($reservacion->confirmed==1)?"selected":"";?>>Confirmada</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary btn-sm">Guardar</button>
                        <button type="button" class="btn btn-default" id="btnVerMas">Más acciones</button>
                        <a class="btn btn-default pull-right" href="/admin/reservas/index">Volver a reservaciones</a>
                    </div>
                </form>
                <div class="hidden" id="MasAcciones">
                    <button class="btn btn-info" id="btnResend">Reenviar correo de confirmación</button>
                    <button class="btn btn-info" id="btnMover">Mover reservación</button>
                    <button class="btn btn-danger" id="btnBorrar">Borrar reservación</button>
                </div>
                <div class="hidden row" id="divMoverReserva">
                <form action="/admin/rsvp/move/" method="post">
                    <div class="col-sm-3">
                        <h4>Elija la fecha</h4>
                        <select id="moverFecha">
                            <opttion value=""></opttion>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <h4>Elija hora</h4>
                        <select id="moverHora" name="targetID">
                        </select>
                    </div>
                    <div class="col-sm-4" id="divConfirmarMover">
                        <input type="hidden" id="fieldID" name="sourceID"/>
                        <button type="submit" class="btn btn-danger" id="btnConfirmarMover" >Mover reservación</button>
                    </div>
                </form>
                </div>
                <div class="hidden" id="divBorrarReserva">
                    <h4>¿Desea borrar esta reservación?</h4>
                    <p>Para confirmar, escriba Enigmata en el siguiente campo y presione borrar:</p>
                    <input type="text" class="form-control" id="VerificarBorrar"/><button type="button" id="BorrarReserva" class="btn btn-danger">BORRAR</button>
                </div>
            </div>
        </div>
    </div>
</div>