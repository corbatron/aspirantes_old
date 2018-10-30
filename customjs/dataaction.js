$(document).ready(function () {
        var dataaction = document.querySelectorAll('[data-action]');
        for(var i = 0; i < dataaction.length ; i++){
            document.querySelectorAll('[data-action]').item(i).addEventListener("click",function(){
                $('#iframe_1').attr("src",this.dataset.action+".php");
            },false);
        }
});
