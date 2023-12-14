<style>
    .w_Tuesday,
    .w_Monday {
        background-color: #ddd;
    }

    .w_Mes {
        background-color: #bcf;
    }
</style>
<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title"></h5>

            <table class="table">
                <tr>
                    <td></td>
                    <?php foreach ($slots as $slot) { ?>
                        <th><?= $slot; ?></th>
                    <?php } ?>
                    <td>Acciones</td>
                </tr>
                <?php
                $mesNombre = null;
                $dias = ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
                $Meses = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
                $Now = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
                $NextTwoMonths = new DateTime('now', new DateTimeZone('America/Costa_Rica'));
                $NextTwoMonths->modify('+2 month');
                $interval = new DateInterval('P1D');
                $period = new DatePeriod(
                    $Now,
                    $interval,
                    $NextTwoMonths
                );

                foreach ($period as $date) {
                    $code = $date->format("Ymd");
                    $codes = [];
                    foreach ($slots as $slot) {
                        $codes[] = $code."1".$slot;
                    }
                    if ($Meses[(int) $date->format("n")] != $mesNombre) {
                        $mesNombre = $Meses[(int) $date->format("n")];
                ?>
                        <tr class="w_Mes">
                            <th colspan="7"><?= $mesNombre; ?></th>
                        </tr>
                    <?php
                    }
                    ?>
                    <tr class="w_<?= $date->format("l"); ?>">
                        <th><?= $dias[(int) $date->format("w")] . " " . $date->format("d"); ?></th>
                        <?php foreach ($slots as $slot) { ?>
                            <td>
                                <?php
                                $dayslot = $code . "1" . $slot;
                                if (isset($reservas[$dayslot])) {
                                    if ($reservas[$dayslot]["reservedAt"]) { ?>
                                        <a class="btn btn-secondary btn-block" href="<?php echo base_url(); ?>calendario/verreserva/<?= $reservas[$dayslot]["id"]; ?>">Reservado (<?=$reservas[$dayslot]["people"];?> personas)</a>
                                    <?php } else { ?>
                                        <a class="btn btn-danger btn-block" href="<?php echo base_url(); ?>calendario/borrarslot/<?= $dayslot; ?>">Borrar <?= $slot; ?></a>
                                    <?php
                                    }
                                } else { ?>
                                    <a class="btn btn-default btn-block" href="<?php echo base_url(); ?>calendario/abrirslot/<?= $dayslot; ?>">Abrir <?= $slot; ?></a>
                                <?php } ?>
                                <?php ?>
                            </td>
                        <?php } ?>
                        <td><a class="btn btn-info" href="<?php echo base_url(); ?>calendario/abrirdia/<?= implode("-",$codes); ?>">Abrir todo el día</a></td>
                    </tr>
                <?php
                }
                ?>
            </table>
        </div>
    </div>
</div>