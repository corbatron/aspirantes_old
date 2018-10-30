$(document).ready(function () {
        var dataaction = document.querySelectorAll('[data-year]');
        for(var i = 0; i < dataaction.length ; i++){
            document.querySelectorAll('[data-year]').item(i).addEventListener("click",function(){
			//redirige/recarga la pagina
				$.ajax({
					type: "POST",
					url: "submit.php",
					data: {
						from: "cambiarAnio",
						anio: this.dataset.year
					},
				success: function(e) {
//console.log(e);
					window.location.href = "main.php"        
					}
				});
	        },false);
        }
});
