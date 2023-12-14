angular.module('app', [])
  .controller('BookingController', ['$scope', '$http', function($scope, $http) {
    var ctrl = window.ctrl = this;
    $scope.info = null;
    $scope.slots = null;
    $scope.slot = null;
    ctrl.selectDate = function(info) {
      $scope.info = info;
      $scope.slots = null;
      $scope.date = moment(info.dateStr).format('dddd D [de] MMMM');
      $http.get("http://enigmata.local.com/admin/calendario/reservasdia/"+info.dateStr.replace(/-/g,"")).then(function(response) {
        console.log(response.data);
        $scope.slots = response.data;
      });
    }

    ctrl.reservar = function(slot) {
      console.log(slot);
      $scope.slot = slot;
    }

    ctrl.enviarReserva = function() {
      console.log($scope.slot);
      $http.post("http://enigmata.local.com/admin/calendario/actualizarReserva/", $scope.slot).then(function(response) {
        console.log(response.data);
        $scope.info = info;
        $scope.slots = null;
      });

    }
  }]);