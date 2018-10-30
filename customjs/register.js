$(document).ready(function () {

    $("#btnLogOn").click(function () {
        $.ajax({
            async: false,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: "createUserImplementation.php",
            data: "nombre=" + $('#nombre')[0].value + "&apellido=" + $('#apellido')[0].value+"&documento="+$('#documento')[0].value+"&carrera="+$('#carrera').val(),
            success: function (respuesta) {
                if (respuesta == "KO") {
                    $('#modal-1').addClass('md-show');
                } else {
		    alert("El usuario ha sido registrado exitosamente. Ser\u00e1 redireccionado a la p\u00e1gina principal");
                    $(location).attr("href", "index.php");
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
        $.ajax({
            async: false,
            cache: false,
            dataType: "html",
            type: 'POST',
            url: "createUserImplementation.php",
            data: "nombre=" + $('#nombre')[0].value + "&apellido=" + $('#apellido')[0].value+"&documento="+$('#documento')[0].value+"&carrera="+$('#carrera').val(),
            success: function (respuesta) {
                if (respuesta == "KO") {
                    $('#modal-1').addClass('md-show');
                } else {
		    alert("El usuario ha sido registrado exitosamente. Ser\u00e1 redireccionado a la p\u00e1gina principal");
                    $(location).attr("href", "index.php");
                }
            },
            beforeSend: function () {},
            error: function (objXMLHttpRequest) {}
        });
    }
});