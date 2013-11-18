var map;
var idInfoBoxAberto;
var infoBox = [];
var markers = [];
function initialize() {
	var mapOptions = {
		zoom: 2,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	map = new google.maps.Map(document.getElementById("map_canvas"),mapOptions);

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
function carregarPontos() {

	$.getJSON('js/ponto_localiza.json', function(pontos) {
		var latlngbounds = new google.maps.LatLngBounds();
		$.each(pontos, function(index, ponto) {
			var marker = new google.maps.Marker({

				position: new google.maps.LatLng(ponto.vlr_latitude, ponto.vlr_longitude),
				
				title: ponto.nom_estab,

				icon: 'img/marcador.png'

			});

			var Myoptions = {
				
				content:  "<style> div.my {line-height:400%;}</style><div class=my><p class=box id=titulo_ubs><b>" + ponto.nom_estab + "</b></p>"

				+ "<p class=box> End:" + ponto.dsc_endereco + "</p>"

				+ "<p class=box> Bairro:" + ponto.dsc_bairro + "</p>"

				+ "<p class=box> Telefone:" + ponto.dsc_telefone + "</p>"

				+ "<p class=box> Cidade:" + ponto.cidade + " | Estado:" + ponto.estado + "</p>",
				
				pixelOffset: new google.maps.Size(-150, 0)
			};
			infoBox[ponto.Id] = new InfoBox(myOptions);
			infoBox[ponto.Id].marker = marker;
			infoBox[ponto.Id].listener = google.maps.event.addListener(marker, 'click', function (e) {
			abrirInfoBox(ponto.Id, marker);
		});
		markers.push(marker);
		latlngbounds.extend(marker.position);
	});
	var markerCluster = new MarkerClusterer(map, markers);
	map.fitBounds(latlngbounds);

});

}
carregarPontos();