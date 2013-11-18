/*********************************************************************************/
/* Funcionalidade do CheckboxFiltrar por Estado
/*********************************************************************************/

var filtro = {"1": "Filtrando Somente Estados"} /* Variavel para novo valor do <select> */
var holder = {"1": "Informe o Estado desejado para carregar a lista de Cidades"}

/* Fun��o para Alterar propriedades e texto do <select> */
var update_cidade = function () {
	if ($("#filtro_estado").is(":checked")) {
		$("#cidades").attr('disabled', 'disabled').empty();
		$.each(filtro, function(key, value) {
			$('#cidades').append($("<option></option>").attr("value",key).text(value));
		});
	}
	else {
		$("#cidades").removeAttr("disabled");
		if ($('#estados').val() != 'UF' || ''){
			$('#cidades').load('cidades.php?estado='+$('#estados').val() );
			$('#estados').focus();
		}else{
			$.each(holder, function(key, value) {
				$('#cidades').empty();
				$('#cidades').append($("<option></option>").attr("value",key).text(value));
			});
		}
	}
};
/*var show_campo = function(){
  
};*/


$(document).ready(function(){
	$('#estados').change(function(){
		if ($('#filtro_estado').is(':checked')) {
			$(update_cidade);
		}else{
			$('#cidades').load('cidades.php?estado='+$('#estados').val() );
			$('#cidades').focus();
		}
	});
});

/* Disabilita Checkbox para evitar conflitos */
$().ready(function () {
    $('#filtro_estrutura').change(function() {
        if ($('#filtro_estrutura').is(':checked')) {
            $('#filtro_ut').attr('disabled', 'true');
        }else {
            $('#filtro_ut').removeAttr("disabled");
        }
    });

    $('#filtro_ut').change(function() {
        if ($('#filtro_ut').is(':checked')) {
            $('#filtro_estrutura').attr('disabled', 'true');
        }else {
            $('#filtro_estrutura').removeAttr("disabled");
        }
    });
});

$().ready(function() {
/*	$('#calcRota').live('change', function(){
      if ( $(this).is(':checked') ) {
         $('#orig').show();
     } else {
         $('#orig').hide();
     }
 });*/
});

/* Alteração dos Checkboxes para impedir conflito*/
$().ready(function() {
    $("#ap_estrutura").change(update_cidade);
    /*	$('#calcRota').live('change', function(){
     if ( $(this).is(':checked') ) {
     $('#orig').show();
     } else {
     $('#orig').hide();
     }
     });*/
});

$().ready(function() {
	$("#course").autocomplete("js/autoComplete.php", {
		width : 970,
		matchContains : true,
		// mustMatch: true,
		// minChars: 0,
		// multiple: true,
		// highlight: false,
		// multipleSeparator: ",",
		selectFirst : false
	});
});

$(update_cidade);

