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

                    <div class="form-group row">
                        <div class="col-sm-2 bold">Cupón de descuento</div>
                        <div class="col-sm-10">
                            <?=$reservacion->coupon->code;?>
                            (<?=$reservacion->couponraw;?>)
                        </div>
                        <div class="col-sm-2 bold">Descripción</div>
                        <div class="col-sm-4">
                            <p><?=$reservacion->coupon->description;?></p>
                            <p>
                                <?php if ($reservacion->coupon->discount < 0) {
    echo "12000 x (".$reservacion->people."".$reservacion->coupon->discount.") = ".(12000*($reservacion->people+$reservacion->coupon->discount));
} else {
    echo $reservacion->people." x ( ".(120*(100-$reservacion->coupon->discount)).") = ".($reservacion->people*(120*(100-$reservacion->coupon->discount)));
}
                                ?>
                            </p>
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
                        <a class="btn btn-default" href="/admin/reservas/index">Cancelar</a>
                        <button type="button" class="btn btn-default" id="btnVerMas">Más acciones</button>
                    </div>
                </form>
                <div class="hidden" id="MasAcciones">
                    <button class="btn btn-info" id="btnResend">Reenviar correo de confirmación</button>
                    <button class="btn btn-info" id="btnMover" disabled>Mover reservación</button>
                    <button class="btn btn-danger" id="btnBorrar">Borrar reservación</button>
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