$(document).ready(function () {
        var dataform = document.querySelectorAll('[data-form]');
        for(var i = 0; i < dataform.length ; i++){
            document.querySelectorAll('[data-form]').item(i).addEventListener("click",function(){
                $('#content-area').load("formBuilder.php?formulario="+this.dataset.form);
            },false);
        }
});
