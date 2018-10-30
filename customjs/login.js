$(document).ready(function () {



    $("#btnLogOn").click(function () {

    if($('#anio_ingreso').val()==0){
	 $('#modal-1').addClass('md-show');
	 return;
	}
        $.ajax({
            async: false,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: "veriflogin.php",
            data: "firstname=" + $('#username')[0].value + "&lastname=" + $('#password')[0].value+"&anio_ingreso="+$('#anio_ingreso').val()+ "&indicator=true",
            success: function (respuesta) {
		console.log(respuesta);
                if (respuesta == "KO") {
                    $('#modal-1').addClass('md-show');
                } else {
                    $(location).attr("href", "main.php");
                }
            },
            beforeSend: function () {},
            error: function (objXMLHttpRequest) {}
        });
    });

    $("#md-close").click(function () {
        $("#modal-1").removeClass('md-show');
    });
});

$(document).keypress(function (event) {
    var keycode = (event.keyCode ? event.keyCode : event.which);
    if (keycode == '13') {

    if($('#anio_ingreso').val()==0){
	 $('#modal-1').addClass('md-show');
	 return;
	}


        $.ajax({
            async: false,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: "veriflogin.php",
            data: "firstname=" + $('#username')[0].value + "&lastname=" + $('#password')[0].value+"&anio_ingreso="+$('#anio_ingreso').val()+"&indicator=true",
            success: function (respuesta) {
		console.log(respuesta);
                if (respuesta == "KO") {
                    $('#modal-1').addClass('md-show');
                } else {
                    $(location).attr("href", "main.php");
                }
            },
            beforeSend: function () {},
            error: function (objXMLHttpRequest) {}
        });
    }
});