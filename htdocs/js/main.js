(function () {
    'use strict';
    var app = angular.module('Enigmata', [
        'ngRoute',
        'ui.materialize',
        'angulartics', 'angulartics.google.analytics',
        'ngStorage'
    ]);
    app.config([
        '$locationProvider',
        '$routeProvider',
        function($locationProvider, $routeProvider) {
            $locationProvider.hashPrefix('!');
            // routes
            var mainTitle = 'Enigmata Escape Room',
                prefix = mainTitle + ' > ';
            $routeProvider
                .when("/", {
                title: mainTitle,
                activeMenu: 1,
                templateUrl: "home.html",
                controller: "MainController"
            })
                .when("/faq", {
                title: prefix + 'Preguntas frecuentes',
                activeMenu: 2,
                templateUrl: "faq.html",
                controller: "MainController"
            })
                .when("/eventos", {
                title: prefix + 'Eventos',
                activeMenu: 3,
                templateUrl: "eventos.html",
                controller: "EventosController"
            })
                .when("/cuarto1", {
                title: prefix + 'Reservar en Cronos',
                activeMenu: 4,
                templateUrl: "cuarto1.html",
                controller: "RoomController as roomCtrl"
            })
                .when("/cuarto2", {
                title: prefix + 'Reservar en Esper',
                activeMenu: 4,
                templateUrl: "cuarto2.html",
                controller: "RoomController as roomCtrl"
            })

                .when("/historia", {
                title: prefix + 'Historia',
                activeMenu: 51,
                templateUrl: "historia.html",
                controller: "HistoriaController"
            })
                .when("/nosotros", {
                title: prefix + 'Nosotros',
                activeMenu: 52,
                templateUrl: "nosotros.html",
                controller: "NosotrosController"
            })
                .when("/consejos", {
                title: prefix + 'Consejos',
                activeMenu: 53,
                templateUrl: "consejos.html",
                controller: "ConsejosController"
            })
                .when("/prensa", {
                title: prefix + 'Prensa',
                activeMenu: 54,
                templateUrl: "prensa.html",
                controller: "PrensaController"
            })
                .when("/galeria", {
                title: prefix + 'Galeria',
                activeMenu: 55,
                templateUrl: "galeria.html",
                controller: "GaleriaController"
            })
                .when("/right", {
                title: prefix + 'Exito',
                activeMenu: 0,
                templateUrl: "right.html",
                controller: "RightController"
            })
                .when("/wrong", {
                title: prefix + 'Error',
                activeMenu: 0,
                templateUrl: "wrong.html",
                controller: "WrongController"
            })
                .when("/calificacion", {
                title: prefix + 'Calificación de experiencia',
                activeMenu: 0,
                templateUrl: "calificacion.html",
                controller: "ReviewController"
            })
                .otherwise({
                redirectTo: '/'
            });

        }
    ]);

    app.run(['$rootScope', '$route', '$location', '$timeout', function($rootScope, $route, $location, $timeout) {
        $rootScope.$on('$routeChangeSuccess', function() {
            document.title = $route.current.title;
            $rootScope.activeMenu = $route.current.activeMenu;
            window.scrollTo(0, 0);
            $timeout(function() {
                $('.button-collapse').off("click").sideNav({
                    closeOnClick: true
                });
                $('.parallax').parallax();
            }, 100);
        });
    }]);

    //Load controller
    app.controller('GlobalController', ['$scope', function($scope) {
        this.price = 12000;
        this.priceUS = 22;
        this.phone = "(506) 2260 8922 & (506) 8842 0134";
        this.rsvpEnabled = true;
    }]);
    app.controller('MainController', ['$scope', function($scope) {
        $scope.test = "Testing...";
    }]);

    app.controller('HomeController', ['$scope', '$interval', '$sessionStorage', '$http', function($scope, $interval, $sessionStorage, $http) {

        $scope.$storage = $sessionStorage.$default({
            finalDate: new Date((new Date()).getTime()+3600000)
        });

        var homectrl = this;
        var finalDate = new Date($scope.$storage.finalDate);

        homectrl.timeleft = "00:00";

        function updateTime() {
            var now = new Date();
            //homectrl.timeleft =  (now > finalDate) ? 'GAME OVER' : finalDate - now;
            homectrl.timeleft =  finalDate - now;
        }

        $('#modal1').modal({
            startingTop: '50%'
        });
        $( "#draggable" ).draggable();
        $( "#droppable" ).droppable({
            drop: function( event, ui ) {
                console.log('Algo se abrió...');
                $('#modal1').modal('open');
            }
        });

        homectrl.checkCode = function() {
            $http.get('/rsvp/webquest/?code='+homectrl.specCode).then(function(response) {
                homectrl.results = response;
            }, function() {
            });
        }

        $interval(updateTime,100);

    }]);

    app.controller('ReviewController', ['$scope', '$http', '$interval', '$timeout', '$filter', function($scope, $http, $interval, $timeout, $filter) {
        console.log("calificacion")
    }]);

    app.controller('RoomController', ['$scope', '$http', '$interval', '$timeout', '$filter', function($scope, $http, $interval, $timeout, $filter) {
        var roomCtrl = this;
        roomCtrl.step = 1;
        roomCtrl.thisday = new Date();
        roomCtrl.minDate = new Date(roomCtrl.thisday.getFullYear(), roomCtrl.thisday.getMonth(), 1);
        roomCtrl.thisday = roomCtrl.minDate;
        roomCtrl.reservation = {};
        roomCtrl.reservation.people = 1;
        roomCtrl.reservation.coupon = '';
        roomCtrl.showLoading = false;
        roomCtrl.lastCode = ''

        window.roomCtrl = roomCtrl;

        roomCtrl.slots = [];

        roomCtrl.getMonthData = function() {
            roomCtrl.showLoading = true;
            $('.tooltipped').tooltip('remove');
            $http.get('/rsvp/month/'+roomCtrl.room+'/'+roomCtrl.thisday.getFullYear()+'/'+(roomCtrl.thisday.getMonth()+1)).then(function(response) {
                roomCtrl.showLoading = false;
                roomCtrl.weeks = response.data;
                $timeout(function() {
                    $('.tooltipped').tooltip();
                }, 200);
            }, function() {

            });
        }

        roomCtrl.nextMonth = function() {
            if (roomCtrl.thisday.getMonth() == 11) {
                roomCtrl.thisday = new Date(roomCtrl.thisday.getFullYear() + 1, 0, 1);
            } else {
                roomCtrl.thisday = new Date(roomCtrl.thisday.getFullYear(), roomCtrl.thisday.getMonth() + 1, 1);
            }
            roomCtrl.getMonthData();
        }
        roomCtrl.prevMonth = function() {
            if (roomCtrl.thisday.getMonth() == 0) {
                roomCtrl.thisday = new Date(roomCtrl.thisday.getFullYear() - 1, 11, 1);
            } else {
                roomCtrl.thisday = new Date(roomCtrl.thisday.getFullYear(), roomCtrl.thisday.getMonth() - 1, 1);
            }
            roomCtrl.getMonthData();
        }
        roomCtrl.selectDay = function(date) {
            roomCtrl.step = 2;
            roomCtrl.selectedDate = date;
            roomCtrl.selectedDateJS = new Date(date);

            roomCtrl.showLoading = true;
            $http.get('/rsvp/day/'+roomCtrl.room+'/'+date).then(function(response) {
                roomCtrl.showLoading = false;
                roomCtrl.slots = response.data;

                $('.collapsible').collapsible('open', 1);
            });
        }

        roomCtrl.selectSlot = function(slot) {
            roomCtrl.step = 3;
            roomCtrl.selectedSlot = slot;
            roomCtrl.peopleChoices = [];
            roomCtrl.reservation.id = slot.id;
            roomCtrl.reservation.room_humana = roomCtrl.room;
            roomCtrl.reservation.fecha_humana = $filter("date")(roomCtrl.selectedDateJS,'fullDate','+0000');
            roomCtrl.reservation.hora_humana = slot.start;
            var minimum = 2;
            //todo: por ahora son 2 minimo, esto depende del cuerto y de la reservacion
            roomCtrl.reservation.people = minimum;
            for(var i=minimum; i<=slot.people; i++) {
                roomCtrl.peopleChoices.push({value: i, label: i + ' jugador'+(i>1?"es":"")});
            }
            $('.collapsible').collapsible('open', 2);
        }

        roomCtrl.backStep = function(step) {
            roomCtrl.step = step;
            switch(roomCtrl.step) {
                case 1:
                    roomCtrl.selectedDate = null;
                    roomCtrl.selectedSlot = null;
                    roomCtrl.showLoading = false;
                    roomCtrl.slots = [];
                    $('.collapsible').collapsible('open', 0);
                    break;
                case 2:
                    roomCtrl.selectedSlot = [];
                    $('.collapsible').collapsible('open', 1);
                    break;
                case 3:
                    $('.collapsible').collapsible('open', 2);
                    break;
            }
        }

        roomCtrl.submitForm = function(isValid) {
            console.log("Submit form");
            if (isValid) {
                roomCtrl.showLoading = true;
                $http.post('/rsvp/submit/', roomCtrl.reservation).then(function(response) {
                    if (response.data.id > 0) {
                        roomCtrl.showLoading = false;
                        roomCtrl.reservationResume = response.data;
                        roomCtrl.step = 4;
                        $('.collapsible').collapsible('open', 3);
                        roomCtrl.getMonthData();
                    } else {
                        //error al guardar reservacion, revisar datos
                        roomCtrl.showLoading = false;
                    }
                }, function (error) {
                    console.log(error);
                    //error en el servidor, revisar datos
                });
            }
        };

        roomCtrl.verificarCodigo = function() {
            roomCtrl.lastCode = roomCtrl.reservation.coupon;
            roomCtrl.codeDescription = "";
            $http.get('/rsvp/checkcode/?code='+roomCtrl.reservation.coupon).then(function(response) {
                if (response.data.id > 0) {

                }
                roomCtrl.codeDescription = response.data.description;
            }, function() {

            });

        }

        roomCtrl.interval = $interval(function() {
            if (roomCtrl.room>0) {
                $interval.cancel(roomCtrl.interval);
                roomCtrl.getMonthData();
            }
        },100);

    }]);


}());

(function($){
    $(function(){
        $('.button-collapse').off("click").sideNav({
            closeOnClick: true
        });
        $(".dropdown-button").dropdown();
    }); // end of document ready
})(jQuery); // end of jQuery name space
