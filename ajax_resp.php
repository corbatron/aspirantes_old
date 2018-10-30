<?php
print_r($_REQUEST);
$id_tipo_respuesta = $_REQUEST['respuesta_tipo'];

if($id_tipo_respuesta==1)
{
   echo "<form method='post' target='iframe_cargar_respuestas' action='../proceso_subir_respuestas.php'>";
   echo "<table width='100%'>";
   echo "<tr>";
   echo "<td>";
   echo "<input type='text' id='respuesta' size='100'></input>";
   echo "</td>";
   echo "<td>";
   echo "<input type='button' value='Agregar' onclick='agregar_valores_text();'></input>";
   echo "</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>";
   echo "</td>";
   echo "</tr>";
   echo "</table>";
   echo "<div id='div_valores_sel'>";
   echo "</div>";
   echo "<input type='submit' value='Guardar'></input>";
   echo "<input type='hidden' id='pregunta_tito' name='pregunta_tito'></input>";
   echo "<input type='hidden' id='tito_respuesta' value='text' name='tito_respuesta'></input>";
   echo "</form>";
   echo "<iframe width='100%' height='100' id='iframe_cargar_respuestas' name='iframe_cargar_respuestas'></iframe>";
    
}

if($id_tipo_respuesta == "2")
{
    
   echo "<form method='post' target='iframe_cargar_respuestas' action='../proceso_subir_respuestas.php'>";
   echo "<table width='100%'>";
   echo "<tr>";
   echo "<td>";
   echo "<input type='text' id='respuesta' size='100'></input>";
   echo "</td>";
   echo "<td>";
   echo "<input type='button' value='Agregar' onclick='agregar_valores_check();'></input>";
   echo "</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>";
   echo "</td>";
   echo "</tr>";
   echo "</table>";
   echo "<div id='div_valores_sel'>";
   echo "</div>";
   echo "<input type='submit' value='Guardar'></input>";
   echo "<input type='hidden' id='pregunta_tito' name='pregunta_tito'></input>";
   echo "<input type='hidden' id='tito_respuesta' value='check' name='tito_respuesta'></input>";
   echo "</form>";
   echo "<iframe width='100%' height='100' id='iframe_cargar_respuestas' name='iframe_cargar_respuestas'></iframe>";
    
}


if($id_tipo_respuesta=="3")
{
    echo "<input type='text'></input>";
    echo "<input type='button'>Guardar</input>";
    
}


if($id_tipo_respuesta == "4")
{
    
   echo "<form method='post' target='iframe_cargar_respuestas' action='../proceso_subir_respuestas.php'>";
   echo "<table width='100%'>";
   echo "<tr>";
   echo "<td>";
   echo "<input type='text' id='respuesta' size='100'></input>";
   echo "</td>";
   echo "<td>";
   echo "<input type='button' value='Agregar' onclick='agregar_valores_select();'></input>";
   echo "</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>";
   echo "</td>";
   echo "</tr>";
   echo "</table>";
   echo "<div id='div_valores_sel'>";
   echo "</div>";
   echo "<input type='submit' value='Guardar'></input>";
   echo "<input type='hidden' id='pregunta_tito' name='pregunta_tito'></input>";
   echo "<input type='hidden' id='tito_respuesta' value='select' name='tito_respuesta'></input>";
   echo "</form>";
   echo "<iframe width='100%' height='100' id='iframe_cargar_respuestas' name='iframe_cargar_respuestas'></iframe>";
    
}

if($id_tipo_respuesta == "6")
{
    
   echo "<form method='post' target='iframe_cargar_respuestas' action='../proceso_subir_respuestas.php'>";
   echo "<table width='100%'>";
   echo "<tr>";
   echo "<td>";
   echo "<input type='text' id='respuesta' size='100'></input>";
   echo "</td>";
   echo "<td>";
   echo "<input type='button' value='Agregar' onclick='agregar_valores_area();'></input>";
   echo "</td>";
   echo "</tr>";
   echo "<tr>";
   echo "<td>";
   echo "</td>";
   echo "</tr>";
   echo "</table>";
   echo "<div id='div_valores_sel'>";
   echo "</div>";
   echo "<input type='submit' value='Guardar'></input>";
   echo "<input type='hidden' id='pregunta_tito' name='pregunta_tito'></input>";
   echo "<input type='hidden' id='tito_respuesta' value='area' name='tito_respuesta'></input>";
   echo "</form>";
   echo "<iframe width='100%' height='100' id='iframe_cargar_respuestas' name='iframe_cargar_respuestas'></iframe>";
    
}





?>
<script>

document.getElementById("pregunta_tito").value=document.getElementById("id_pregunta_tito").value;


function agregar_valores_select()
{

 var padre;
 padre = document.getElementById('div_valores_sel');
 var hijo;
 valor = document.getElementById('respuesta').value;
 hijo = document.createElement('DIV');
 hijo.innerHTML="<input type='hidden' name='valores[]' value='"+valor+"'></input><li>"+valor+"</li>";
 padre.appendChild(hijo);
 


}

function agregar_valores_check()
{

 var padre;
 padre = document.getElementById('div_valores_sel');
 var hijo;
 valor = document.getElementById('respuesta').value;
 hijo = document.createElement('DIV');
 hijo.innerHTML="<input type='hidden' name='valores[]' value='"+valor+"'></input><li>"+valor+"</li>texto<input type='checkbox' name='checkeados[]' value='"+valor+"'></input>";
 padre.appendChild(hijo);
 


}

function agregar_valores_text()
{

 var padre;
 padre = document.getElementById('div_valores_sel');
 var hijo;
 valor = document.getElementById('respuesta').value;
 hijo = document.createElement('DIV');
 hijo.innerHTML="<input type='hidden' name='valores[]' value='"+valor+"'></input><li>"+valor+"</li>";
 padre.appendChild(hijo);
 


}


function agregar_valores_area()
{

 var padre;
 padre = document.getElementById('div_valores_sel');
 var hijo;
 valor = document.getElementById('respuesta').value;
 hijo = document.createElement('DIV');
 hijo.innerHTML="<input type='hidden' name='valores[]' value='"+valor+"'></input><li>"+valor+"</li>";
 padre.appendChild(hijo);
 


}

</script>

