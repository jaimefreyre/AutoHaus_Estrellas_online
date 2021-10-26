const apo =angular.module('encuesta', []);
apo.controller('BaseCtrl', ['$scope', '$http', function ($scope, $http) {

	//const ['si', 'no'] = ['si', 'no'];
	///const nusa = ['nuevo', 'usado'];
	const base = this;
	base.respuestas = {};

    base.getParamsNombre = function(name) {
    	name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    	var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    	results = regex.exec(location.search);
    	return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	base.getVariable = function(variable) {
	   var query = window.location.search.substring(1);
	   var vars = query.split("&");
	   for (var i=0; i < vars.length; i++) {
	       var pair = vars[i].split("=");
	       if(pair[0] == variable) {
	           return pair[1];
	       }
	   }
	   return false;
	}

	base.numeroId = base.getParamsNombre('id');
	console.log(base.numeroId);

	var urlbusquedaId = 'http://apptablets0km.com/EncuestaO/datos/api.php?selector=IDFILTRO&id=' + base.numeroId;
	if (base.numeroId) {
		$http({method: 'get', url: urlbusquedaId}).
	    then(function(response) {
	    		base.respuestas = response.data;
	    		console.log(base.respuestas);
	    		console.log(response);
	    	},
	     	function(response){
	     		console.log(response);
	     	}
	    );	
    }

  	$http({method: 'get', url: 'datos/Datos.json'}).
    then(function(response) {
 	  //$scope.status = response.status;
      //$scope.data = response.data;
    	console.log(response)
    	base.dt = response.data;
    }, function(response) {
      //$scope.data = response.data || 'Request failed';
      //$scope.status = response.status;
    	console.log(response)
  	});

    $http({method: 'get', url: 'datos/json.json'}).
    then(function(response) {
 	  //$scope.status = response.status;
      //$scope.data = response.data;
    	console.log(response)
    	base.preguntas = response.data;
    }, function(response) {
      //$scope.data = response.data || 'Request failed';
      //$scope.status = response.status;
    	console.log(response)
  	});

	/*base.preguntas = {
		'¿Cual es su grado de satisfaccion con el trato del Personal recibido en el concesionario?' : 'estrellas',
		'¿Que satisfaccion encuentra con la organizacion del concesionario?' : 'estrellas',
		'¿Que satisfaccion encuentra en general, con el asesoramiento recibido, por parte de los empleados del concesionario?' : 'estrellas',
		'Teniendo en cuenta todos los aspectos de compra de su Vehiculo ¿Cual es su grado de satisfaccion General respectos de los servicios brindados por el concesionario?' : 'estrellas',
		'¿Cual es su nivel de satisfaccion con respeto a la atencion y explicacion de los tramites administrativos y sus tiempos?' : 'estrellas',
		'¿Le ofrecieron prueba de manejo?' : ['si', 'no'],
		'¿Se contacto el asesor luego de la entrega?' : ['si', 'no'],
		'¿Como calificaria el nivel de explicaciones y condiciones tecnicas y de limpieza de su 0km al momento de la entrega?' : 'estrellas',
		'¿Volveria a comprar en Auto Haus?' : ['si', 'no']
	};
	*/
	
    base.swiper = new Swiper('.swiper-container', {
      pagination: {
        el: '.swiper-pagination',
        type: 'progressbar',
      },
      observer : true,
      allowTouchMove : false,	
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
    });

    base.final = null;
    base.swiper.on('reachEnd', function(e){
    	base.final = 1;
    })


    base.siguienteSlider = function(){
    	
	    	console.log('se activo siguiente')
	    	base.swiper.slideNext();
		
	}

}]);

apo.directive('pregunta', [function ($http) {
	return {
		templateUrl: 'pregunta.html',
		replace: true,
		transclude: true,
		restrict: 'EA',
		scope: {titulo : '=titulo', indice : '=indice', uid : '=uid', final : '=final', opciones : '=opciones', slide : '=slide', respuestas : '=respuestas'},
		controller: function($scope, $http) {
		    $scope.estrellas = [5,4,3,2,1];

		    $scope.enviarInformacion = function(uid){
		    	if (uid){
		    		var dir1 = 'datos/guardar.php?orden=update&uid='+uid;
		    	} else {
		    		var dir1 = 'datos/guardar.php?orden=nuevo';
		    		this.respuestas[4] = 'Sin Foto';
			   }
			    
			    $http({method: 'post', data: this.respuestas, url: dir1}).then(
			    	function(response){
			    		console.log(response)
			    		jQuery('.swiper-container').after('<h2 class="agradecimiento">Muchas Gracias por su Colaboracion</h2>');
			    		//jQuery('.swiper-container').after('<h2 class="agradecimiento"> '+ response.data +' </h2>');
		    		}, 
			    	function(response){
			    		console.log('fallo')
			    	}
			    );
			



			}


			$scope.GoogleBase = function(){
				var entradasGoogle = ['entry.1158292438','entry.1403311993','entry.422861747','entry.69360404','entry.1260897011','entry.1897457605','entry.2073020133','entry.1862619501','entry.1113343840','entry.2124438376','entry.351987351','entry.726446599','entry.793894223','entry.714531979'];
				var googleDatos = '';
				for (var i = 0; i < entradasGoogle.length; i++) {
						googleDatos = googleDatos + '&' + entradasGoogle[i] + '=' + this.respuestas[i];
					}
				$http({
					method : 'POST',
					url : "https://docs.google.com/forms/d/e/1FAIpQLScsxbLKGVP8Cqilc18OCZPzPjl6hs8JI5UG_AUkPaHJgSK3xw/formResponse",
					headers: {'Content-Type': 'application/x-www-form-urlencoded'},
					data: googleDatos
					})
					.then(
						function mySucces(response) {
							console.log(response.data);
						},
						function myError(response) {
							console.log(googleDatos);
							console.log('fallo gogle')
						}
					);
					console.log(googleDatos);

			}


		    $scope.sigui = function(){
		    	if (this.final) {
		    		$scope.enviarInformacion(this.uid);
		    		jQuery('.swiper-container').hide();
		    		$scope.GoogleBase();
		    		console.log(this.respuestas);
		    	}
		    	else{
		    		this.slide.slideNext(400);
		    	}
		    }
		    
		    $scope.valorOpciones = function(val, ttq, key){
		    	let tt = ttq +5;
		    	console.log('.opciones'+tt+' .'+key);
		    	for (var i = 0; i < 6; i++) {
		    		jQuery('.opciones'+ttq+' .'+i).css('backgroundColor','white');
		    	}
		    	jQuery('.opciones'+ttq+' .'+key).css('backgroundColor','orange');
		    	this.respuestas[tt] = val;
		    	//setTimeout($scope.sigui(), 30000);
		    	
		    }
		    
		    $scope.valor = function(val, ttq){
		    	let tt = ttq +5;
		    	console.log(tt);
		    	console.log('.'+tt+' .'+val);
		    	this.respuestas[tt] = val;
		    	for (var i = val; i > 0; i--) {
		    		jQuery('.'+ttq+' .'+i).css('color','orange');
		    	}
		    	for (var i = val+1; i < 6; i++) {
		    		jQuery('.'+ttq+' .'+i).css('color','grey');
		    	}
		    	//$scope.sigui();
		    }

		},
		link: function postLink(scope) {
		}
	};
}])
