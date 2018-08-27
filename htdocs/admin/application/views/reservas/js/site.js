var 
    _linkCondiciones = '.linkCondiciones',
    activityTimeout = null,
    _startActivityChecking = true,
    _exitModal = '#exitModal',
    _modal='#modal',
    _activityModal='#activityModal',
    _mainMultiProductoTabs = '#mainMultiProductoTabs',
    _showMenuTabs = '#showMenuTabs',
    _tab = '.mainMultiTabs a[data-toggle="tab"]';

$(function() {
    'use strict';
    // set the cookie for 1 hour
    function setCookie(cname, cvalue, exhours) {
        var d = new Date();
        // add cookie expiry date to be one hour from the current time
        d.setTime(d.getTime() + ( (exhours * 60 * 60 * 1000) * 2) );
        var expires = "expires=" + d.toGMTString();
        // Pass the name, cookie value and expiry time into the cookie
        document.cookie = cname + "=" + cvalue + "; " + expires;
    }

    function getCookie(cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[ i ];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }


    function checkCookie() {
        var popUp = getCookie("poppedUp");
        // if the cookie isn't empty, then don't show the modal, otherwise show the modal
        if (popUp != "" ) {} else {
            if ( !$(_exitModal).is(':visible') && !$(_modal).is(':visible')){
                // Hide All Modal
                $(_modal).modal('hide');
                // show modal
                $(_exitModal).modal('show');
                // change the value of the cookie so that we know the visitor has seent the cookie
                popUp = 1;
                setCookie("poppedUp", popUp, 1);
            }
        }
    } 

    function startActivityCheckingCookie(){
        if (activityTimeout) {
            clearTimeout(activityTimeout);
        }
        activityTimeout = setTimeout(function() { 
            var popUp = getCookie("poppedAc");
            if (popUp != "" ) {} else {
                if ( !$(_exitModal).is(':visible') && !$(_modal).is(':visible')){
                    // show modal
                    $(_activityModal).modal('show');
                }
            }
        }, 20000); //20 segundos
    }

    function startActivityChecking(){
        $(document.body).mousemove(function(){
           startActivityCheckingCookie();     
        });

        $(document).scroll(function(){
            startActivityCheckingCookie(); 
        });

        $(document).keydown(function() {
            startActivityCheckingCookie(); 
        });

        $(document).keypress(function() {
            startActivityCheckingCookie(); 
        });

        $(document).keyup(function() {
            startActivityCheckingCookie(); 
        });
    }

    function getParam(parametro, url) {
        //si no hay url se coge la actual
        var getParamReturn = '';
        if (url === undefined) {
            url = window.location.href;
        }
        //parametro ='email';
        try {
            parametro = parametro.replace(/[\[]/, '\\\[').replace(/[\]]/, '\\\]');
            //console.log(parametro);
            var regexS = '[\\?&]' + parametro + '=([^&#]*)';
            var regex = new RegExp(regexS);
            var results = regex.exec(url);
            if (results === null) {
                getParamReturn = '';
            } else {
                getParamReturn = results[1];
            }
        } catch (e) {
            getParamReturn = '';
        }
        return getParamReturn;
    }
    
    function cargaPestana() {
        var pestana = getParam('tab', window.location.href);
        var abrePest = '';
        var tipoproducto;
        var plan = '';
        if (pestana !== '') {
            abrePest = $('[data-tipo-tab=' + pestana + ']').attr('id');
            $('.nav > li > a[href="' + abrePest + '"]').parent().addClass('active');
            $('.nav > li > a[href="#' + abrePest + '"]').parent().addClass('active');

            $('.tabsNav').removeClass('active');
            $('#' + abrePest).addClass('active');

        } else {
            abrePest = '#tab1';
            $('.nav > li > a[href="' + abrePest + '"]').parent().addClass('active');
            
            $('.tabsNav').removeClass('active');
            $(abrePest).addClass('active');
        }

    }

    function cambiaPestana(elem, tipoLp, tipoTab) {

        var campaign = getParam('campaign', window.location.href);

        if (tipoTab !== undefined && tipoTab !== '' && tipoTab !== 'undefined') {

            if (campaign !== undefined && campaign !== '' && campaign !== 'undefined') {
                window.history.pushState(null, null, '?tab=' + tipoTab + '&campaign=' + campaign);
            } else {
                window.history.pushState(null, null, '?tab=' + tipoTab);
            }

        } else {

            if (campaign !== undefined && campaign !== '' && campaign !== 'undefined') {
                window.history.pushState(null, null, '?campaign=' + campaign);
            } else {
                window.history.pushState(null, null, '?');
            }

        }


        if ($(window).width() < 768 || $(window).width() === 768) {
            $('.slick-track').each(function() { $(this).attr('style', '') });
            $('.slick-slide').each(function() { $(this).attr('style', '') });

            $(_mainMultiProductoTabs).slideUp();
        }
        
        $('.slick-slider').each(function() { 
            $(this).slick('setPosition') 
        });
    }

    /*************************************************************************************************/
    /*function showModalLoading() {
        $(_modalLoading).modal('show');
    }*/
    /*************************************************************************************************/
    /*function showModalInformation(res) {
        $(_modalLoading).modal('hide');
        $(_informationModal).find('.modal-container #informationModal_Title').html(res);
        $(_informationModal).modal('show');
    }*/

    function sendDataLayer(category, action, label) {
        dataLayer.push({
            'event': 'trackEvent',
            'eventCategory': category,
            'eventAction': action,
            'eventLabel': label
        });
    }

    /*var callServices = function(temp_telf_val, num_documento_val) {
        //muestro el modal de loading 
        showModalLoading();
        
        var myData = "nombres=-"
            + "&celular=" + temp_telf_val
            + "&producto_codigo=" + " "
            + "&producto_nombre=" + " "
            + "&producto_categoria=" + "Portabilidad"
            + "&producto_tipo=" + "Movil"
            + "&fuente=" + " "
            + "&medio=" + " "
            + "&campana=" + " "
            + "&contenido=" + " "
            + "&gclid=" + " "
            + "&terminos=" + ""
            + "&origen=" + "Formulario C2C Móvil"
            + "&cliente_tipo=" + ""
            + "&proveedor=" + " "
            + "&linea_tipo=" + ""
            + "&atm_landing_page=" + " "
            + "&atm_page=" + " "
            + "&atm_previous_page=" + " "
            + "&atm_device_category=" + " "
            + "&numero_documento=" + num_documento_val;

        console.log(myData);

        $.post("http://tiendaonline.movistar.com.pe/campanas/click-to-call/save.php", myData, function (response) {
            switch (response.status) {
                case "success":
                    showModalInformation('¡En breve nos pondremos en contacto contigo! Nuestro horario de atención es de Lunes a Sábado de 8:00 am. a 10:00 pm.')
                    console.log("gracias");
                break;
                case "error-duplicate":
                    showModalInformation('Ya tienes un pedido registrado.<br / >En breve te estaremos llamando.')
                    console.log("errorDuplicado");
                break;
                case "error-ws":
                    showModalInformation('Lo sentimos <br />Ocurrió un error interno.')
                    console.log("errorOtro");
                break;
                default:
                    showModalInformation('Lo sentimos <br />Ocurrió un error interno.')
                    console.log("errorOtro");
            }
        });
    };*/
    /*************************************************************************************************/

    /*$.validator.setDefaults({
        submitHandler: function(e) {
            var inputs = {
                temp_telf_val: e[0].value,
                num_documento_val: e[1].value
            };
            
            callServices(inputs.temp_telf_val, inputs.num_documento_val);
        }
    });*/

    /*************************************************************************************************/
    function validateForms() {
        $.each($('.js-formCall'), function() {
            $(this).validate({
                errorElement: 'span',
                rules: {
                    telNumber: {
                        required: true,
                        minlength: 9,
                        maxlength: 9,
                        digits: true
                    },
                    cedulaNumber: {
                        required: true,
                        minlength: 8,
                        maxlength: 8,
                        digits: true
                    },
                },
                messages: {
                    telNumber: {
                        required: 'Ingresa tu número de teléfono',
                        minlength: 'El número de teléfono debe tener 9 dígitos',
                        maxlength: 'El número de teléfono debe tener 9 dígitos',
                        digits: 'Introduce un número de teléfono válido'
                    },
                    cedulaNumber: {
                        required: "El número de cédula es requerido.",
                        minlength: 'El número cédula debe tener 8 dígitos',
                        maxlength: 'El número cédula debe tener 8 dígitos',
                        digits: "Por favor ingrese un número de cédula valido."
                    }
                }
            });
        });

    } //end validateForms

    /************************************************************************************/
    ///Click en ver todos términos y condiciones
    $('.moreButton').on('click', function(event) {
        event.preventDefault();
        var terminos = $(this).parent().parent();
        terminos.find('.terminos__extendedContent').slideDown();
        terminos.find('.lessButton').show();
        $(this).hide();
    });
    /************************************************************************************/
    ///Click en ver menos términos y condiciones
    $('.lessButton').on('click', function(event) {
        event.preventDefault();
        var terminos = $(this).parent().parent();
        terminos.find('.terminos__extendedContent').slideUp();
        terminos.find('.moreButton').show();
        $(this).hide();
    });

    $(document).on('click', _linkCondiciones, function() {
        sendDataLayer('Link Terminos y Condiciones', 'Click', $(this).find('.text').html());
    });

    /**********************************************************************************/
    $(document).on('click, touchstart', _showMenuTabs, function(e) {
        e.preventDefault();
        e.stopPropagation();
        if ($(_mainMultiProductoTabs).is(':visible')) {
            $(_mainMultiProductoTabs).slideUp();
        } else {
            $(_mainMultiProductoTabs).slideDown();
        }

        sendDataLayer('Click Menu Mobile', 'Click', $(this).find('.text').html());
    });

    $(_tab).on('shown.bs.tab', function(e) {
        var etiqueta,
            tipoLp,
            tipoTab,
            target = $(e.target).attr('href'); // activated tab
        etiqueta = $(target).attr('data-etiqueta');
        tipoLp = $(target).attr('data-tipo-lp');
        tipoTab = $(target).attr('data-tipo-tab');

        cambiaPestana(target, tipoLp, tipoTab);
       
        sendDataLayer('Menu '+tipoLp , 'Click', etiqueta);

        $('.contenido').addClass('degradado');
        $('.contenido').removeClass('contenidoOpen');
    });
    

    $(document).ready(function () { 
        /*if ( _startActivityChecking ) {
            startActivityChecking();
        }

        $(document).on('mouseleave', function () {
            checkCookie();
        });*/


        cargaPestana();

        //validate form
        validateForms();

        /******  Analytics - inicio   *****/
        
        $('[data-nombre-landing]').each(function() {
            $(this).attr('data-nombre-landing', nombreLP_DLPE);
        });

        /******  Analytics - final   *****/

        
        /*************** Teléfono de contacto *************************************************************/
        $('.js-contactTitle__phone').each(function() {
            $(this).html(telefono_contacto);
        })

        var tel = "tel:" + telefono_contacto.replace(/-/g, '');
        $('.js-contact-phone').each(function() {
            $(this).attr('href', tel);
        });

        $('[data-nombre-landing]').each(function() {
            $(this).attr('data-nombre-landing', nombreLP_DLPE);
        });
    });
});
var
_slider,
    _sliderSmall,
    _sliderVentajas;

$(function() {
    'use strict';
    /*************** Teléfono de contacto *************************************************************/
    /* Función Inicia Carousel, define las variables que le vamos a transmitir a los dos carousels */
    function iniciaCarouselIconos(firstMobileSlide, flechas, conFlechas) {
        var settings = {
            centerMode: false,
            dots: true,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            initialSlide: firstMobileSlide,
            arrows: conFlechas,
            centerPadding: '0',
        };
        return settings;
    }
    /*************** Teléfono de contacto *************************************************************/
    /* Función Inicia Carousel, define las variables que le vamos a transmitir a los dos carousels */
    function iniciaCarouselPlanes(firstMobileSlide) {

        var settings = {
            centerMode: false,
            dots: true,
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            initialSlide: firstMobileSlide,
            arrows: true,
            centerPadding: '0',
            prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
            nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
        };
        console.log(settings);
        return settings;
    }
    /*************************************************************************************************/
    function iniciaCarouselMasDeTresElementos(firstDesktopSlide, firstMobileSlide) {

        var settings = {

            infinite: false,
            centerPadding: '0',
            centerMode: false,
            slidesToShow: 3,
            slidesToScroll: 1,
            initialSlide: parseInt(firstDesktopSlide),
            draggable: true,
            dots: true,
            arrows: true,
            prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
            nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',

            responsive: [{
                breakpoint: 900,
                settings: {
                    slidesToShow: 1,
                    centerPadding: '0',
                }
            },
                         {
                             breakpoint: 800,
                             settings: {
                                 slidesToShow: 1,
                                 centerPadding: '0',
                                 prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                                 nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                             }
                         }, {
                             breakpoint: 481,
                             settings: {
                                 initialSlide: parseInt(firstMobileSlide),
                                 slidesToShow: 1,
                                 centerPadding: '0',
                                 prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                                 nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                             }
                         }
                        ]
        };

        return settings;
    }
    /*************************************************************************************************/
    function iniciaCarouselElements(firstDesktopSlide, firstMobileSlide, elementos) {

        var settings = {

            infinite: false,
            centerPadding: '0',
            centerMode: false,
            slidesToShow: elementos,
            slidesToScroll: 1,
            initialSlide: parseInt(firstDesktopSlide),
            draggable: true,
            dots: true,
            arrows: true,
            prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
            nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',

            responsive: [{
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 1,
                        centerPadding: '0',
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 1,
                        centerPadding: '0',
                        prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                        nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                    }
                }, {
                    breakpoint: 481,
                    settings: {
                        initialSlide: parseInt(firstMobileSlide),
                        slidesToShow: 1,
                        centerPadding: '0',
                        prevArrow: '<img class="planes_arrow newswrapper_prev masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                        nextArrow: '<img class="planes_arrow newswrapper_next masDeTres" src="images/iconos/keyboard-left-arrow-button.svg"/>',
                    }
                }
            ]
        };

        return settings;
    }
    /*************************************************************************************************/
    function inicializaSliders () {
        var nslides;
        var mobileSlide = 0;
        var desktopSlide = 0;

        $('.planSlider').each(function() {
            nslides = $(this).attr('data-num-elements');
            if (nslides > 3) {
                $(this).addClass('slider-n-elements');
            } else {
                $(this).addClass('slider-3-elements');
            }
        });


        if ($(window).width() < 800 || $(window).width() === 800) {
            $('.slider-3-elements').each(function() {
                mobileSlide = $(this).attr('data-start-mobile');
                if (mobileSlide === undefined) {
                    mobileSlide = 0;
                }
                _sliderSmall = iniciaCarouselPlanes(mobileSlide);
                $(this).slick(_sliderSmall);
                $(this).slick('setPosition');

            });
        } else {
            $('.slider-3-elements').find('.planesMovistar__BlockCol').each(function() {
                $(this).addClass('tresElementos');
            });
        }
        $('.slider-n-elements').each(function() {
            mobileSlide = $(this).attr('data-start-mobile');
            desktopSlide = $(this).attr('data-start-desktop');
            if (mobileSlide === undefined) {
                mobileSlide = 0;
            }
            if (desktopSlide === undefined) {
                desktopSlide = 0;
            }
            _slider = iniciaCarouselMasDeTresElementos(desktopSlide, mobileSlide);
            $(this).slick(_slider);
            $(this).slick('setPosition');

            console.log('slider big');

        });
        $(window).on('resize', function() {
            if ($(window).width() < 800 || $(window).width() === 800) {
                if (!$('.slider-3-elements').hasClass('slick-initialized')) {
                    $('.slider-3-elements').each(function() {
                        mobileSlide = $(this).attr('data-start-mobile');
                        if (mobileSlide === undefined) {
                            mobileSlide = 0;
                        }
                        _sliderSmall = iniciaCarouselPlanes(mobileSlide);
                        $(this).slick(_sliderSmall);
                        $(this).slick('setPosition');
                        $(this).find('.planesMovistar__BlockCol').removeClass('tresElementos');
                    });
                }
            } else {
                if ($('.slider-3-elements').hasClass('slick-initialized')) {
                    $('.slider-3-elements').removeClass('slick-initialized');
                    $('.slider-3-elements').slick('unslick');
                    $('.slider-3-elements').find('.planesMovistar__BlockCol').each(function() {
                        $(this).addClass('tresElementos');
                    });
                }
                $('#mainMultiProductoTabs').css('display', 'block');
            }
        });
    }
    /*************************************************************************************************/
    function inicializaSlidesMobile (slider,objeto ) {
        if (!$(slider).hasClass('slick-initialized')) {
            $(slider).each(function() {
                objeto = iniciaCarouselIconos(0,false,' ');
                $(this).slick(objeto);
                $(this).slick('setPosition');
            });
        }
    }
    /************************************************************************************************/
    function desactivarSlidesDesktop (slider) {
        if ($(slider).hasClass('slick-initialized')) {
            $(slider).removeClass('slick-initialized');
            $(slider).slick('unslick');
        }
    }
    /*************************************************************************************************/
    function inicializaSliderIconos(sliderIcono) {
        var firstMobileSlide = 0;
        var secondMobileSlide = 0;
        var hasFlechas = false;
        var urlFlechas = ' ';
        $(window).on('resize', function() {
            if ($(window).width() < 800 || $(window).width() === 800) {
                inicializaSlidesMobile(sliderIcono,_sliderVentajas);
            } else {
                desactivarSlidesDesktop (sliderIcono);
            }
        });
        if ($(window).width() < 800 || $(window).width() === 800) {
            inicializaSlidesMobile(sliderIcono,_sliderVentajas);
        }
    }
    /******************************************************************************************/
   function inicializarCuatroSlides() {
     $('.planSlider-extended').each(function(){
        $(this).slick(iniciaCarouselElements(0,0,4));
     });
   }
   /******************************************************************************************/
   function inicializarCincoSlides() {
     $('.planSlider-extendedCaracteristicas').each(function(){
        $(this).slick(iniciaCarouselElements(0,0,5));
     });
   }
    /**************************************************************************************/
    $().ready(function() {
        
        inicializarCuatroSlides();
        inicializarCincoSlides();
        inicializaSliders();

    }); //end ready
});