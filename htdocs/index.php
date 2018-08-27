<!DOCTYPE html>
<html ng-app="Enigmata">
    <head lang="es">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no"/>
        <meta name="description" content="Escape Room en Heredia, Costa rica, una aventura inmersiva y divertida para todo público. Un cuarto de escape para aventureros">
        <meta name="keywords" content="Escape room, escape, room, costa rica, heredia, juego, videojuego, teambuilding, aventura">
        <meta name="author" content="Esteban Mata">
        <title>Enigmata Escape Room, Heredia Costa Rica</title>
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
        <link rel="manifest" href="/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        <!-- styles -->
        <link href="https://fonts.googleapis.com/css?family=Lato:900|Orbitron:900|Russo+One" rel="stylesheet">
        <!--Import Google Icon Font-->
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.css"/>
        <link rel="stylesheet" href="style.css"/>
    </head>
    <body ng-controller="GlobalController as global">
        <div class="navbar-fixed">
            <ul id="dropdown1" class="dropdown-content">
                <li ng-class="{'active': activeMenu == 41}"><a href="#!cuarto1">Cronos</a></li>
                <li ng-class="{'active': activeMenu == 42}"><a href="#!cuarto2">Olivia</a></li>
            </ul>
            <ul id="dropdown2" class="dropdown-content">
                <li ng-class="{'active': activeMenu == 51}"><a href="#!historia">Historia</a></li>
                <li ng-class="{'active': activeMenu == 54}"><a href="#!prensa">Prensa</a></li>
                <li ng-class="{'active': activeMenu == 55}"><a href="#!galeria">Galerías</a></li>
            </ul>
            <nav class="white" role="navigation">
                <div class="nav-wrapper container">
                    <a id="logo-container" href="#" class="brand-logo">
                        <img src="img/logo.png" alt="Enigmata" />
                    </a>
                    <ul class="right hide-on-med-and-down">
                        <li ng-class="{'active': activeMenu == 1}">
                            <a href="#">Inicio</a>
                        </li>
                        <li ng-class="{'active': activeMenu == 2}">
                            <a href="#!faq">Preguntas</a>
                        </li>
                        <li ng-class="{'active': activeMenu == 3}">
                            <a href="#!eventos">Eventos</a>
                        </li>
                        <li ng-class="{'active': activeMenu == 4}" class="black">
                            <a class="dropdown-button white-text" href="#!" data-activates="dropdown1">Reservar <i class="fa fa-chevron-down"></i></a>
                        </li>
                        <li ng-class="{'active': activeMenu == 5}">
                            <a class="dropdown-button" href="#!" data-activates="dropdown2">Más <i class="fa fa-chevron-down"></i></a>
                        </li>
                    </ul>

                    <ul id="nav-mobile" class="side-nav">
                        <li ng-class="{'active': activeMenu == 1}">
                            <a href="#">Inicio</a>
                        </li>
                        <li ng-class="{'active': activeMenu == 2}">
                            <a href="#!faq">Preguntas</a>
                        </li>
                        <li ng-class="{'active': activeMenu == 3}">
                            <a href="#!eventos">Eventos</a>
                        </li>
                        <li class="divider"></li>
                        <li ng-class="{'active': activeMenu == 41}"><a href="#!cuarto1">Cronos</a></li>
                        <li ng-class="{'active': activeMenu == 42}"><a href="#!cuarto2">Olivia</a></li>
                        <li class="divider"></li>
                        <li ng-class="{'active': activeMenu == 51}"><a href="#!historia">Historia</a></li>
                        <li ng-class="{'active': activeMenu == 54}"><a href="#!prensa">Prensa</a></li>
                        <li ng-class="{'active': activeMenu == 55}"><a href="#!galeria">Galerías</a></li>

                    </ul>
                    <a href="#" data-activates="nav-mobile" class="button-collapse"><i class="fa fa-bars"></i></a>
                </div>
            </nav>
        </div>

        <main>
            <!-- views -->
            <div ng-view>
                <div class="center-align" style="padding-top:10%;">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div><div class="gap-patch">
                            <div class="circle"></div>
                            </div><div class="circle-clipper right">
                            <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <footer class="page-footer">
            <div class="container">
                <div class="row">
                    <div class="rightSocialIcons hide-on-med-and-up ">
                        <ul>
                            <li><a class="white-text blue-grey darken-3" href="https://www.facebook.com/enigmatacr/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i></a></li>
                            <li><a class="white-text blue-grey darken-3" href="https://www.instagram.com/enigmatacr" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                            <li><a class="white-text blue-grey darken-3" href="#!" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                    <div class="col l6 s12">
                        <h5 class="white-text">¿Dónde estamos?</h5>
                        <p class="grey-text text-lighten-4">En Heredia, calle 9 avenidas 4 y 6, frente a McDonald's.<br/>
                            2o piso debajo de Merecumbé</p>

                    </div>
                    <div class="col l3 m6 s12">
                        <h5 class="white-text">Contacto</h5>
                        <ul>
                            <li class="white-text"><i class="fa fa-phone-square" aria-hidden="true"></i> Teléfono: {{global.phone}}</li>
                            <li><a class="white-text" href="mailto:gerencia@enigmata.co.cr"><i class="fa fa-envelope" aria-hidden="true"></i> E-Mail</a></li>
                            <li><a class="white-text" href="https://www.facebook.com/enigmatacr/#" target="_blank"><i class="fa fa-commenting" aria-hidden="true"></i> Chat</a></li>
                        </ul>
                    </div>
                    <div class="col l3 m6 s12 hide-on-small-only">
                        <h5 class="white-text">Redes Sociales</h5>
                        <ul>
                            <li><a class="white-text" href="https://www.facebook.com/enigmatacr/" target="_blank"><i class="fa fa-facebook-official" aria-hidden="true"></i> Facebook</a></li>
                            <li><a class="white-text" href="https://www.instagram.com/enigmatacr" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i> Instagram</a></li>
                            <li><a class="white-text" href="#" target="_blank"><i class="fa fa-youtube" aria-hidden="true"></i> YouTube</a></li>
                        </ul>
                    </div>
                    <div class="col s12 hide-on-small-only">
                        <iframe style="-webkit-filter: grayscale(100%); filter: grayscale(100%);" width="100%" height="300" frameborder="0" style="border:0" allowfullscreen src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3929.2477454736!2d-84.11473868520585!3d9.996382892853617!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x926997039e6ceed1!2sEnigmata!5e0!3m2!1ses!2s!4v1504535435743"></iframe>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                <div class="container">
                    © 2017 Enigmata Costa Rica
                </div>
            </div>
        </footer>

        <!-- scripts -->
        <script src="bower_components/jquery/dist/jquery.min.js"></script>
        <script src="bower_components/jquery-ui/jquery-ui.min.js"></script>
        <script src="bower_components/angular/angular.min.js"></script>
        <script src="bower_components/angular-route/angular-route.min.js"></script>
        <script src="bower_components/materialize/dist/js/materialize.min.js"></script>
        <script src="bower_components/angular-materialize/src/angular-materialize.js"></script>
        <script src="bower_components/angulartics/dist/angulartics.min.js"></script>
        <script src="bower_components/angulartics-google-analytics/dist/angulartics-ga.min.js"></script>
        <script src="bower_components/ngstorage/ngStorage.min.js"></script>
        <script src="js/angular-locale_es-cr.js"></script>
<?php
        $files = array_diff(scandir('partials/'), array('..', '.'));
        foreach($files as $file) {
?>
        <script type="text/ng-template" id="<?=$file;?>">
<?php
readfile("partials/".$file);
?>
        </script>
<?php
        }
?>
        <script>
            (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                                    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

            ga('create', 'UA-93345222-1', 'auto');

        </script>
        <script src="js/main.js"></script>
    </body>
</html>
