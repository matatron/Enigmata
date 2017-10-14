<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Enigmata Admin</title>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <link rel="stylesheet" href="/admin/unicorn/css/bootstrap.min.css" />
        <link rel="stylesheet" href="/admin/unicorn/css/font-awesome.css" />
        <link rel="stylesheet" href="/admin/unicorn/css/jquery.jscrollpane.css" />
        <link rel="stylesheet" href="/admin/unicorn/css/icheck/flat/blue.css" />
        <link rel="stylesheet" href="/admin/unicorn/css/select2.css" />

        <link rel="stylesheet" href="/admin/unicorn/css/unicorn.css" />
        <link rel="stylesheet" href="/admin/styles.css" />
        <!--[if lt IE 9]>
<script type="text/javascript" src="js/respond.min.js"></script>
<![endif]-->

    </head>
    <body data-color="grey" class="flat">
        <div id="wrapper">
            <div id="header">
                <h1><a href="/admin/">Enigmata</a></h1>
                <a id="menu-trigger" href="#"><i class="fa fa-bars"></i></a>
            </div>

            <div id="user-nav">
                <ul class="btn-group">
                    <?php if(Auth::instance()->logged_in()) { ?>
                    <li class="btn"><a title="" href="/admin/main/logout"><i class="fa fa-share"></i> <span class="text">Logout</span></a></li>
                    <?php } else { ?>
                    <?php } ?>
                </ul>
            </div>

            <div id="sidebar">
                <ul>
                    <li <?php if ($controller=="Main") echo 'class="active"'; ?>>
                        <a href="/admin/"><i class="fa fa-home"></i> <span>Inicio</span></a>
                    </li>
<?php if(Auth::instance()->logged_in()) { ?>
                    <li <?php if ($controller=="reservas") echo 'class="active"'; ?>>
                        <a href="/admin/reservas/index"><i class="fa fa-group"></i> <span>Reservaciones</span></a>
                    </li>
<?php if(Auth::instance()->logged_in("admin")) { ?>
                    <li <?php if ($controller=="Schedule") echo 'class="active"'; ?>>
                        <a href="/admin/schedule/index"><i class="fa fa-calendar"></i> <span>Cronograma</span></a>
                    </li>
                    <li <?php if ($controller=="Coupons") echo 'class="active"'; ?>>
                        <a href="/admin/coupons/index"><i class="fa fa-money"></i> <span>Descuentos</span></a>
                    </li>
                    <li <?php if ($controller=="Coupons") echo 'class="active"'; ?>>
                        <a href="/admin/coupons/index"><i class="fa fa-users"></i> <span>Personal</span></a>
                    </li>
<?php } ?>

<?php } else { ?>
<?php } ?>
                </ul>
            </div>

            <div id="content">
                <div id="content-header" class="mini">
                    <h1><?= $title;?></h1>
                </div>
                <div class="container-fluid">
                    <?= $content;?>
                </div>

            </div>
            <div class="row">
                <div id="footer" class="col-xs-12">
                    2017 &copy; Administración Web de Enigmata
                </div>
            </div>
        </div>

        <script src="/admin/unicorn/js/excanvas.min.js"></script>
        <script src="/admin/unicorn/js/jquery.min.js"></script>
        <script src="/admin/unicorn/js/jquery-ui.custom.js"></script>
        <script src="/admin/unicorn/js/bootstrap.min.js"></script>
        <script src="/admin/unicorn/js/jquery.flot.min.js"></script>
        <script src="/admin/unicorn/js/jquery.flot.resize.min.js"></script>
        <script src="/admin/unicorn/js/jquery.sparkline.min.js"></script>
        <script src="/admin/unicorn/js/jquery.icheck.min.js"></script>
        <script src="/admin/unicorn/js/select2.min.js"></script>

        <script src="/admin/unicorn/js/jquery.nicescroll.min.js"></script>
        <script src="/admin/unicorn/js/unicorn.js"></script>
        <script src="/admin/js/Main.js"></script>
        <script src="/admin/js/<?=$controller;?>-<?=$action;?>.js"></script>

    </body>
</html>
