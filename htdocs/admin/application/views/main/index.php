<div class="row">
    <div class="col-xs-12 col-sm-6">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-file"></i></span><h5>Próximas reservacioes</h5><span title="<?php echo count($reservaciones); ?> reservaciones futuras" class="label label-info tip-left"><?php echo count($reservaciones); ?></span></div>
            <div class="widget-content nopadding">
                <ul class="recent-posts">
                    <?php foreach($reservaciones as $res) { ?>
                    <li>
                        <div class="user-thumb" style="    font-size: 2em">
                            <?= date("d", $res->reservationdate); ?>
                        </div>
                        <div class="article-post">
                            <span>Por: <?= $res->email; ?> el <?= date("d/M h:iA", $res->reservationdate); ?>, IP: <?= $res->ip; ?> </span>
                            <p>
                                <?= date("d/M h:i", $res->date); ?>: <?= $res->people; ?> personas
                            </p>
                            <a href="#" class="btn btn-primary btn-xs">Editar</a>
                        </div>
                    </li>
                    <?php } ?>
                    <li class="viewall">
                        <a title="Ver todas las reservacioness" class="tip-top" href="/admin/reservas/index"> + Ver todas + </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6">
        <div class="widget-box">
            <div class="widget-title"><span class="icon"><i class="fa fa-comment"></i></span><h5>Actividad reciente</h5></div>
            <div class="widget-content nopadding">
                <ul class="recent-comments">
                    <?php foreach($logs as $log) { ?>
                    <li>
                        <span class="user-info"><?=date("d/M h:iA", $log->date); ?> Usuario: <?=$log->user; ?> </span>
                        <p>
                            <?=$log->text; ?>
                        </p>
                    </li>
                    <?php } ?>
                    <li class="viewall">
                        <a title="Ver toda la actividad" class="tip-top" href="/admin/main/fulllog"> + Ver todas + </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
