angular.module('ArcangularApp', [])
  .controller('OrdenController', function($scope, $http, $timeout) {
    var ctrl = window.ctrl = this;

    ctrl.currentPerson = 0;

    ctrl.personas = function(num) {
      ctrl.orden.personas += num;
      if(ctrl.orden.personas == 0) ctrl.orden.personas=1;
      while(ctrl.orden.personas > ctrl.orden.nombres.length) ctrl.orden.nombres.push({id: (ctrl.orden.nombres.length+1)+"-"+time(), nombre: 'Persona '+(ctrl.orden.nombres.length+1)});
      if(ctrl.orden.personas < ctrl.orden.nombres.length && ctrl.orden.nombres[ctrl.orden.nombres.length-1].nombre.indexOf('Persona') > -1) ctrl.orden.nombres.pop();
    }
    ctrl.setPerson = function(index) {
      ctrl.currentPersonIndex = index;
      document.getElementById("personNameField").focus();
    }

    ctrl.getData = function(id) {
      if (id) {
        ctrl.currentOrderId = id;
        $http({
          method : "GET",
            url : "/orden/json_ver/"+ctrl.currentOrderId
        }).then(function mySuccess(response) {
          ctrl.orden = response.data;
          ctrl.orden.personas = parseInt(ctrl.orden.personas);
          ctrl.orden.nombres = JSON.parse(ctrl.orden.nombres);
          ctrl.orden.pedidos = (ctrl.orden.pedidos=='""')?[]:JSON.parse(ctrl.orden.pedidos);
          if(ctrl.orden.nombres == null) {
            ctrl.orden.nombres = [];
            while(ctrl.orden.personas > ctrl.orden.nombres.length) ctrl.orden.nombres.push({id: time(), nombre:'Persona '+(ctrl.orden.nombres.length+1)});
          }
        }, function myError(response) {
          //$scope.myWelcome = response.statusText;
        });
      }
    }

    ctrl.addProductToOrder = function(node, person) {
      document.querySelectorAll('input[class=form-check-input]:checked').forEach(function(e) {e.checked = false; });
      ctrl.currentModel = JSON.parse(node.currentTarget.parentElement.parentElement.parentElement.getAttribute("data-model"));
      document.getElementById("notasPedido").value = '';
      var data  = {
        id: ctrl.currentOrderId+"-"+time(),
        precio: ctrl.currentModel.precio,
        preparacion: ctrl.currentModel.preparacion,
        enviado: 0,
        preparando: 0,
        listo: 0,
        cobrado: 0,
        agregadoPor: 0,
        pendiente: 1,
        notas: "",
        opciones: [],
        producto: ctrl.currentModel.id,
        nombre: ctrl.currentModel.nombre,
        persona: person
      }
      ctrl.orden.pedidos.push(data);
      ctrl.currentProduct = ctrl.orden.pedidos[ctrl.orden.pedidos.length-1];
    }

    ctrl.updateOptions = function() {
      ctrl.currentProduct.opciones = Array.from(document.querySelectorAll('input[class=form-check-input]:checked')).map(function(e) {return JSON.parse(e.value) });
    }

    ctrl.porProducto = function(p) {
        console.log(p);
    }

    ctrl.editProductInOrder = function(node, p) {
      ctrl.currentModel = JSON.parse(node.currentTarget.parentElement.parentElement.parentElement.getAttribute("data-model"));
      ctrl.currentProduct = ctrl.orden.pedidos.filter(function(e) {return (e.enviado == 0 && e.producto == ctrl.currentModel.id && e.persona.id == p.id)})[0]
      ctrl.currentPerson = ctrl.orden.nombres.findIndex(function(e) { return e.id == ctrl.currentProduct.persona.id });
      $timeout(function() {
        document.querySelectorAll('input[class=form-check-input]').forEach(function(e) {
          if (ctrl.currentProduct.opciones.findIndex(function(o) {return o.texto == JSON.parse(e.value).texto}) > -1) {
            e.checked = true;
          } else {
            e.checked = false;
          }
        });
      },50);

    }

    ctrl.removeProductFromOrder = function() {
      if (confirm("¿Desea remover este pedido?"))  {
        ctrl.orden.pedidos.splice(ctrl.orden.pedidos.findIndex(function(e) {
          return e.id == ctrl.currentProduct.id;
        }),1);
      }
    }

    ctrl.assignProductTo = function(index) {
      ctrl.currentPerson = index;
      ctrl.currentProduct.persona = ctrl.orden.nombres[ctrl.currentPerson];
    }

    ctrl.enviarPedidos = function() {
      ctrl.orden.pedidos.forEach(function(e, i) {
        if (e.enviado == 0) {
          ctrl.orden.pedidos[i].enviado = time();
          if (e.preparacion == 2) {
            ctrl.orden.pedidos[i].preparando = time();
            ctrl.orden.pedidos[i].listo = time();

          }
        }
      });
      ctrl.saveData();
    }
    ctrl.removeProduct = function(index) {
      if (confirm("¿Desea remover este pedido?"))  ctrl.orden.pedidos.splice(index,1);
    }

    ctrl.countUnsend =  function() {
      if (ctrl.orden && ctrl.orden.pedidos.length) return ctrl.orden.pedidos.filter(function(e) {return e.enviado == 0}).length;
      return 0;
    }

    ctrl.hasUnsend = function (persona, id) {
      return ctrl.orden.pedidos.filter(function(e) {return (e.enviado == 0 && e.producto == id && e.persona.id == persona.id)}).length > 0;
    }
    ctrl.saveData = function() {
      ctrl.currentProduct = null;
      $http({
        method : "POST",
          url : "/orden/guardar/",
          data: ctrl.orden
      }).then(function mySuccess(response) {
      }, function myError(response) {
      });
    }

    ctrl.getClass = function(p) {
      return (p.enviado == 0) ? "sin-enviar" : (p.preparando == 0) ? "enviado" : (p.listo == 0) ? "preparando" : (p.cobrado != 0) ? "cobrado": "listo";
    }

    ctrl.nombreCon = function (l) {
      if (ctrl.orden.nombres[ctrl.currentPersonIndex].nombre.indexOf("Persona") > -1) ctrl.orden.nombres[ctrl.currentPersonIndex].nombre = "";
      ctrl.orden.nombres[ctrl.currentPersonIndex].nombre += l;
      $http({
        method : "GET",
          url : "/extras/nombre/"+ctrl.orden.nombres[ctrl.currentPersonIndex].nombre,
      }).then(function mySuccess(response) {
        ctrl.posiblesNombres = response.data;
      }, function myError(response) {
      });
    }
    ctrl.borrarLetra = function () {
      ctrl.orden.nombres[ctrl.currentPersonIndex].nombre = ctrl.orden.nombres[ctrl.currentPersonIndex].nombre.slice(0,-1);
      $http({
        method : "GET",
          url : "/extras/nombre/"+ctrl.orden.nombres[ctrl.currentPersonIndex].nombre,
      }).then(function mySuccess(response) {
        ctrl.posiblesNombres = response.data;
      }, function myError(response) {
      });
    }

  })
  .controller("ProductoController", function($http) {
    var ctrl = window.ctrl = this;

    ctrl.guardarCambios = function() {
      $http({
        method : "POST",
          url : "/menu/guardar/",
          data: ctrl.producto
      }).then(function mySuccess(response) {

        //ctrl.producto = response.data;
        //ctrl.producto.precio = parseInt(ctrl.producto.precio);
      }, function myError(response) {
        //$scope.myWelcome = response.statusText;
      });
    }

    ctrl.getData = function(id) {
      if (id) {
        ctrl.currentProductId = id;
        $http({
          method : "GET",
            url : "/menu/json_ver/"+ctrl.currentProductId
        }).then(function mySuccess(response) {
          ctrl.producto = response.data;
          ctrl.producto.precio = parseInt(ctrl.producto.precio);
          ctrl.producto.opciones = (ctrl.producto.opciones == "")?[]:JSON.parse(ctrl.producto.opciones);
        }, function myError(response) {
          //$scope.myWelcome = response.statusText;
        });
      } else {
        ctrl.producto = {
          nombre: '',
          apodo: '',
          descripcion: '',
          precio: 0,
          ingredientes: [],
          opciones: [],
        };
      }
    }
  })
  .controller("CategoriaController", function($http) {
    var ctrl = window.ctrl = this;

    ctrl.guardarCambios = function() {
      $http({
        method : "POST",
          url : "/menu/guardarcat/",
          data: ctrl.categoria
      }).then(function mySuccess(response) {

        //ctrl.producto = response.data;
        //ctrl.producto.precio = parseInt(ctrl.producto.precio);
      }, function myError(response) {
        //$scope.myWelcome = response.statusText;
      });
    }

    ctrl.getData = function(id) {
      if (id) {
        ctrl.catId = id;
        $http({
          method : "GET",
            url : "/menu/json_cat/"+ctrl.catId
        }).then(function mySuccess(response) {
          ctrl.categoria = response.data;
          ctrl.categoria.opciones = (ctrl.categoria.cat_opciones == "" || ctrl.categoria.cat_opciones == null)?[]:JSON.parse(ctrl.categoria.cat_opciones);
        }, function myError(response) {
          //$scope.myWelcome = response.statusText;
        });
      }
    }
  })
  .controller("CocinaController", function($http, $interval) {
    var ctrl = window.ctrl = this;

    ctrl.activos = null;
    ctrl.ids = '';
    ctrl.actualizarActivos = function() {
      $http({
        method : "GET",
          url : "/cocina/activos/",
      }).then(function mySuccess(response) {

        var nids = response.data.map(function(e) {
          return e.id;
        }).join(",");
        console.log(nids);
        ctrl.activos = response.data;

        if (nids != ctrl.ids) {
          ctrl.ids = nids;
          beep();
        }
      }, function myError(response) {
        //$scope.myWelcome = response.statusText;
      });

    }

    ctrl.getClass = function(p) {
      return (p.enviado == 0) ? "sin-enviar" : (p.preparando == 0) ? "enviado" : (p.listo == 0) ? "preparando" : (p.cobrado != 0) ? "cobrado": "listo";
    }
    ctrl.preparar = function(orden) {
      $http({
        method : "GET",
          url : "/cocina/marcarpreparando/"+orden.orden+"/"+orden.id,
      }).then(function mySuccess(response) {
        ctrl.actualizarActivos();
      }, function myError(response) {
        //$scope.myWelcome = response.statusText;
      });
    }

    ctrl.completar = function(orden) {
      $http({
        method : "GET",
          url : "/cocina/marcarlisto/"+orden.orden+"/"+orden.id,
      }).then(function mySuccess(response) {
        ctrl.actualizarActivos();
      }, function myError(response) {
        //$scope.myWelcome = response.statusText;
      });
    }

    function beep() {
        var beepsound = new Audio('/public/ding.wav');
        beepsound.play();
    }

    $interval(ctrl.actualizarActivos, 10000);
    ctrl.actualizarActivos();
  })
  .controller("CajaController", function($http) {
    var ctrl = window.ctrl = this;

    ctrl.getData = function(id) {
      if (id) {
        ctrl.currentOrderId = id;
        $http({
          method : "GET",
            url : "/orden/json_ver/"+ctrl.currentOrderId
        }).then(function mySuccess(response) {
          ctrl.orden = response.data;
          ctrl.orden.personas = parseInt(ctrl.orden.personas);
          ctrl.orden.nombres = JSON.parse(ctrl.orden.nombres);
          ctrl.orden.pedidos = JSON.parse(ctrl.orden.pedidos);
          ctrl.orden.pedidos.forEach(function(articulo, i) {
            var precio = parseInt(articulo.precio);
            articulo.opciones.forEach(function(e) {
              precio += parseInt(e.costo);
            });
            var porcentajes = {};
            ctrl.orden.nombres.forEach(function(e) {
              porcentajes[e.id] = (e.id == articulo.persona.id)?1:0;
              if (articulo.listo == 0) porcentajes[e.id] = 0;
            });
            ctrl.orden.pedidos[i].porcentajes = porcentajes;
            ctrl.orden.pedidos[i].preciofinal = precio;

          });
          ctrl.getFacturas();
        }, function myError(response) {
          //$scope.myWelcome = response.statusText;
        });
      }
    }

    ctrl.getFacturas = function() {
      $http({
        method : "GET",
          url : "/caja/facturaspororden/"+ctrl.currentOrderId
      }).then(function mySuccess(response) {
        ctrl.facturas = response.data;
      }, function myError(response) {
        //$scope.myWelcome = response.statusText;
      });
    }

    ctrl.calcularPersona = function(persona) {
      var total = 0;
      ctrl.orden.pedidos.forEach(function(e){
          if (e.cobrado == 0) {
              total += e.preciofinal*e.porcentajes[persona.id];
          }
      });
      return Math.round(total);
    }

    ctrl.pedidosDe = function(persona) {
      var pedidos = [];
      ctrl.orden.pedidos.forEach(function(articulo, i) {
        if (articulo.listo != 0 && articulo.cobrado == 0 && articulo.porcentajes[persona.id] > 0) {
          pedidos.push(articulo);
        }
      });
      return pedidos;
    }

    ctrl.generarFactura = function(persona) {
      var detalle = [];
      var total = 0;
      ctrl.orden.pedidos.forEach(function(articulo, i) {
        if (articulo.listo != 0 && articulo.cobrado == 0 && articulo.porcentajes[persona.id] > 0) {
          detalle.push({
            nombre: articulo.nombre,
            id: articulo.id,
            cantidad: articulo.porcentajes[persona.id],
            precio: articulo.porcentajes[persona.id] * articulo.preciofinal,
            opciones: articulo.opciones
          });
          articulo.pendiente -= articulo.porcentajes[persona.id];
          if (articulo.pendiente <= 0) {
            articulo.cobrado = time();
          }
          total += articulo.porcentajes[persona.id] * articulo.preciofinal;
        }
      });
      var data  = {
        nombre: persona.nombre,
        orden: ctrl.currentOrderId,
        detalle: detalle,
        pendiente: ctrl.orden.pedidos,
        total: total
      }
      $http({
        method : "POST",
          url : "/caja/facturar/",
          data: data
      }).then(function mySuccess(response) {
        //printZpl(response.data);
        ctrl.getFacturas();
      }, function myError(response) {
      });
    }

    ctrl.pasarCuenta = function(articulo, persona, direccion) {
      var valor = articulo.porcentajes[persona.id];
      var index = ctrl.orden.nombres.findIndex(function(e) { return e.id == persona.id; })
      index = (index + direccion + ctrl.orden.nombres.length)%ctrl.orden.nombres.length;
      articulo.porcentajes[persona.id] = articulo.porcentajes[ctrl.orden.nombres[index].id];
      articulo.porcentajes[ctrl.orden.nombres[index].id] = valor;
    }

    ctrl.getClass = function(p) {
      return (p.enviado == 0) ? "sin-enviar" : (p.preparando == 0) ? "enviado" : (p.listo == 0) ? "preparando" : (p.cobrado != 0) ? "cobrado": "listo";
    }

  })
  .controller("HaciendaController", function($http, $httpParamSerializer) {

  })
  .controller("CopycoderController", function($http) {
    var ctrl = window.ctrl = this;
    ctrl.codificar = function() {
      $http({
          method : "GET",
          url : "/copycoder/codify/",
          params: {
            path: document.getElementById("path").value,
            pixels: document.getElementById("pixels").value
        }
      }).then(function mySuccess(response) {
        document.getElementById("coded").innerHTML="<img src=\""+response.data+"?r="+Math.random()+"\">";
      }, function myError(response) {
        
      });
    }
  });;

  function printZpl(zpl) {
    var printWindow = window.open();
    printWindow.document.open('text/plain')
    printWindow.document.write(zpl);
    printWindow.document.close();
    printWindow.focus();
    printWindow.print();
    printWindow.close();
  }

  function time() {
    return Math.floor(Date.now() / 1000);
  }