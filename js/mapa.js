/*Jandelson: Rota variaveis*/

var directionDisplay;

var directionsService = new google.maps.DirectionsService();

var start = new google.maps.LatLng(-21.176657, -47.820761999999995);

var end = new google.maps.LatLng(-21.176657, -48.820761999999995);

/*Rota fim*/

var map;

var idInfoBoxAberto;

var infoBox = [];

var markers = [];



function initialize() {

	/* rota */ directionsDisplay = new google.maps.DirectionsRenderer();

	var mapOptions = {

		zoom: 8,

		mapTypeId: google.maps.MapTypeId.ROADMAP

	};

	map = new google.maps.Map(document.getElementById('map_canvas'),mapOptions);

	/*rota*/directionsDisplay.setMap(map);



	// Try HTML5 geolocation

	if(navigator.geolocation) {

		navigator.geolocation.getCurrentPosition(function(position) {

			var pos = new google.maps.LatLng(position.coords.latitude,

			position.coords.longitude);



			/*var infowindow = new google.maps.InfoWindow({

			map: map,

			position: pos,

			//content: 'Você está aqu!'

			});*/

			var marker1 = new google.maps.Marker({

				position: pos,

				map: map,

				title: 'Posição Detectada Automáticamente!',

				icon: 'img/local.png'

			});



			map.setCenter(pos);

		}, function() {

			handleNoGeolocation(true);

		});

	} else {

		// Browser doesn't support Geolocation

		handleNoGeolocation(false);

	}

}



function handleNoGeolocation(errorFlag) {

	if (errorFlag) {
		map.setCenter(pos);
		//var content = 'Erro: O serviço de Geolocalização falhou!';

	} else {

		var content = 'Erro: Seu navegagor não suporta a função Geolocalização';

	}



	var options = {

		map: map,

		position: new google.maps.LatLng(),

		content: content

	};



	var infowindow = new google.maps.InfoWindow(options);

	map.setCenter(options.position);

}



function calcRoute() {

	var request = {

		origin:start,

		destination:end,

		travelMode: google.maps.DirectionsTravelMode.DRIVING

	};



	directionsService.route(request, function(response, status) {

		if (status == google.maps.DirectionsStatus.OK) {

			directionsDisplay.setDirections(response);

		} else {

			alert(status);

		}



		document.getElementById('map_canvas').style.visibility = 'visible';

	});

}



initialize();



function abrirInfoBox(id, marker) {

	  //if (typeof(idInfoBoxAberto) == 'number' && typeof(infoBox[idInfoBoxAberto]) == 'object') {

	  if (typeof(idInfoBoxAberto) == 'number' || typeof(infoBox[idInfoBoxAberto]) == 'object') {

			infoBox[idInfoBoxAberto].close();

		}

		infoBox[id].open(map, marker);

		idInfoBoxAberto = id;

		

		google.maps.event.addListener(map, 'click', function() {

    	if (typeof(idInfoBoxAberto) == 'number' || typeof(infoBox[idInfoBoxAberto]) == 'object') {

      	infoBox[idInfoBoxAberto].close();

    	}

		});

}



/*Jandelson: Função para o botão de reclamações e elogios - 13/09/2013*/

function f_rec_el() {

	myWindow=window.open('','','width=500,height=500','top=10','left=1');

	myWindow.document.write("<p>TESTE!</p>");

	myWindow.focus();

}





function carregarPontos() {



	$.getJSON('js/pontos.json', function(pontos) {



		var latlngbounds = new google.maps.LatLngBounds();



		$.each(pontos, function(index, ponto) {



			var marker = new google.maps.Marker({

				position: new google.maps.LatLng(ponto.vlr_latitude, ponto.vlr_longitude),

				title: ponto.nom_estab,

				icon: 'img/marcador.png'

			});



			var myOptions = {

				content:  "<style> div.my {line-height:400%;}</style><div class=my><p class=box id=titulo_ubs><b>" + ponto.nom_estab + "</b></p>"

				+ "<p class=box> End:" + ponto.dsc_endereco + "</p>"

				+ "<p class=box> Bairro:" + ponto.dsc_bairro + "</p>"

				+ "<p class=box> Telefone:" + ponto.dsc_telefone + "</p>"

				+ "<p class=box> Cidade:" + ponto.cidade + " | Estado:" + ponto.estado + "</p>"

				// Remover comentário para voltar a funcionalidade do botão!!!

				//+ "<p class=box>" + "<input type=button value=Reclamações/Elogios id=rec_el onclick=f_rec_el() >" + "</p></div>",

				+ "<p class=box>" + "<input type=button value=Reclamações/Elogios(Breve) id=rec_el disabled=true>" + "</p></div>",

				pixelOffset: new google.maps.Size(-150, 0)

			};



			infoBox[ponto.Id] = new InfoBox(myOptions);

			infoBox[ponto.Id].marker = marker;



			infoBox[ponto.Id].listener = google.maps.event.addListener(marker, 'click', function (e) {

			abrirInfoBox(ponto.Id, marker);

			//idInfoBoxAberto = id;

		});



		markers.push(marker);



		latlngbounds.extend(marker.position);



	});



	var markerCluster = new MarkerClusterer(map, markers);



	map.fitBounds(latlngbounds);



});

}





//}



carregarPontos();





