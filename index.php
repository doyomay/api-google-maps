<?php 
	$_POST['mapa'] = ( empty( $_POST['mapa']) == false ? json_decode( $_POST['mapa'] ) : json_decode('{"mapa":[20.94126089016319,-87.04528458740236],"tipo":"hybrid","zoom":8,"marcador":{"mapa":[-87.022705078125,20.8219127811185],"titulo":""}}') );
 ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Pruebas</title>
	<script src="https://code.jquery.com/jquery-2.1.3.min.js"></script>
	<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
	<style>
		h2{
			text-align: center;
		}
		button{
			background: blue;
			border-radius: 5px;
			color: #fff;
			cursor: pointer;
			display: block;
			height: 40px;
			margin: auto;
			margin-top: 20px;
			text-align: center;
			width: 200px;
		}
		.contenedor{

			height: 400px;
			margin: auto;
			width: 400px;
		}
		#mapa{
			height: 100%;
			width: 100%;
		}
	</style>
</head>
<body>
	<h2>mapa</h2>
	<div class="contenedor">	
		<div id="mapa"></div>
	</div>
	<form action="" method="POST">
		<label for="nombre"> Nombre: <input type="text" name="mapa-pruebas" class="mapa" id="nombre"> </label>
		<input type="text" name="mapa" id="datosMapa" hidden>
		<button id="guardar"> Mandar </button>
	</form>
	<pre>
		<?php var_dump($_POST['mapa']) ?>
	</pre>
	<p id="mapadatos">
		
		Aqui va todo
	</p>
    <script>
    $(function(){
    	var configInicial =  <?= json_encode( $_POST['mapa'] ) ?> ;
    	console.log( configInicial );
    	var map;
    	var markers = [];
    	var opciones = {};

    	function initialize() {
    	  var haightAshbury = new google.maps.LatLng(20.5745654, -87.3834575);
    	  var mapOptions = {
    	    zoom: 9,
    	    center: haightAshbury,
    	    streetViewControl: false,
    	    mapTypeId: "roadmap"
    	  };
    	  map = new google.maps.Map(document.getElementById('mapa'),
    	      mapOptions);

    	  // atachamos el evento para registrar el marcador
    	  google.maps.event.addListener(map, 'click', function(event) {
    	    addMarker(event.latLng);
    	  });

    	  // agregagamos un marcador por defaul
    	  addMarker(haightAshbury);
    	}

    	// Agrega el marcador al mapa
    	function addMarker(location) {

          clearMarkers(); // eliminamos el ultimo marcador registrado
    	  var marker = new google.maps.Marker({
    	    position: location,
    	    map: map,
    	    title : $("#nombre").val() //le podemos agregar un nombre
    	  });
    	  markers.push(marker);
    	  setInput("datosMapa", location.D, location.k); //agregamos los registros del marcador
    	}

    	// Sets the map on all markers in the array.
    	function setAllMap(map) {
    	  for (var i = 0; i < markers.length; i++) {
    	    markers[i].setMap(map);
    	  }
    	}

    	// Removes the markers from the map, but keeps them in the array.
    	function clearMarkers() {
    	  setAllMap(null);
    	  markers = [];
    	}

    	function setInput( nombre, lat, lng ){
    		/*
				- recibimos el nombre del input donde se va a poner los datos.
				- recibimos la latitud y longitud.
    		*/
    		opciones = {
    			mapa : [ map.center.lat(), map.center.lng() ],	
    			tipo : map.mapTypeId,
    			zoom : map.zoom,
    			marcador : {
    				mapa : [ lat, lng ],
    				titulo : markers[0].title
    			}
    		};
    		$("#"+nombre).val( JSON.stringify(opciones) ); //guardamos el json en formato string
    	}

    	google.maps.event.addDomListener(window, 'load', initialize);
	})
    </script>
    <script>
    $("#guardar").click(function(){
    	$("#mapadatos").text( $("#datosMapa").val() );
    });
    </script>
</body>
</html>
