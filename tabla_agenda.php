<!-- common/img/trabajo.png  estudio.png tiempo_libre.png cursada.png-->
<script src="js/jquery-1.6.1.min.js"></script>
<script>
var vector = new Array(4);
var vector_nombres = new Array(4);

vector[0]= "common/img/estudio.png";
vector[1]= "common/img/tiempo_libre.png";
vector[2]= "common/img/cursada.png";
vector[3]= "common/img/trabajo.png";

vector_nombres[0]= "Horas destinadas a estudiar en forma grupal o individual";
vector_nombres[1]= "Horas destinadas a otras actividades";
vector_nombres[2]= "Horas de cursada en la facultad";
vector_nombres[3]= "Horas de trabajo";

elemento_anterior = "0";

function cambiarImagen(id){

 objeto = document.getElementById(id);

 pos = objeto.getAttribute('valor');
	
	if(pos==null)
	{
		pos = 0;
	}
	else
	{	
		if(parseInt(pos) + 1 == 4)
		{
			pos = 0;
		}
		else
		{
			pos = parseInt(pos) + 1;
		}
	}
 
 objeto.src = vector[pos];
 objeto.setAttribute('valor',pos);
 objeto.alt = vector_nombres[pos];
 objeto.title = vector_nombres[pos];
 pos = pos +1;
 
 var lista = document.createElement('div');
 if(document.getElementById("div_"+objeto.id+""))
	{
	 document.getElementById("i_"+objeto.name+"").value = objeto.getAttribute('valor');
	}
	else
	{
		lista.id = "div_"+objeto.id+"";
		lista.innerHTML = "<input type='hidden' name='i_"+objeto.name+"' id='i_"+objeto.name+"' value='"+objeto.getAttribute('valor')+"'></input>";
		document.getElementById('div_seleccion').appendChild(lista);
	}
 if(pos==4)
	pos= 0;
}


    function mostrar(){
     	
        obj = document.getElementById('descripcion');
        obj.style.display = 'block';
		setTimeout(no_mostrar,3000);
     
    }
     
    function no_mostrar(){
        obj = document.getElementById('descripcion');
        obj.style.display = 'none';
     
    }

</script>

<a href='#' onMouseOver='mostrar()' >Referencias </a>
<table width='50%' height='100%' border='0' cellpadding='2' cellspacing='2' align='center'>
<tr>
<td>
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>Lunes
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>Martes
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>Mi&eacute;coles
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>Jueves
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>Viernes
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>S&aacute;bado
</td>
<td bgcolor='#CCCCCC' align='center' nowrap>Domingo
</td>

</tr>
<tr>
<td bgcolor="#CCCCCC">6 AM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_1" id="0_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_2" id="0_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_3" id="0_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_4" id="0_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_5" id="0_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_6" id="0_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"0_7" id="0_7" /></td>

</tr>
<tr>
<td bgcolor='#CCCCCC'>
7 AM
</td>
<td id='' align='center'><img id='1_1' name='1_1' src='common/img/tiempo_libre.png' alt='Horas de trabajo' title='Horas de trabajo' onclick='cambiarImagen(this.id);' valor='1'>
</td>
<td align='center'><img id='1_2' name='1_2' src='common/img/tiempo_libre.png' alt='Horas de trabajo' title='Horas de trabajo' onclick='cambiarImagen(this.id);' valor='1'>
</td>
<td align='center'><img id='1_3' name='1_3' src='common/img/tiempo_libre.png' alt='Horas de trabajo' title='Horas de trabajo' onclick='cambiarImagen(this.id);' valor='1'>
</td>
<td align='center'><img id='1_4' name='1_4' src='common/img/tiempo_libre.png' alt='Horas de trabajo' title='Horas de trabajo' onclick='cambiarImagen(this.id);' valor='1'>
</td>
<td align='center'><img id='1_5' name='1_5' src='common/img/tiempo_libre.png' alt='Horas de trabajo' title='Horas de trabajo' onclick='cambiarImagen(this.id);' valor='1'>
</td>
<td align='center'><img id='1_6' name='1_6' src='common/img/tiempo_libre.png' alt='Horas de trabajo' title='Horas de trabajo' onclick='cambiarImagen(this.id);' valor='1'>
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"1_7" id="1_7" /></td>

</tr>
<tr>
<td bgcolor='#CCCCCC'>
8 AM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_1" id="2_1" /></td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_2" id="2_2" /></td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_3" id="2_3" /></td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_4" id="2_4" /></td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_5" id="2_5" /></td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_6" id="2_6" /></td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"2_7" id="2_7" /></td>

</tr>
<tr>
<td bgcolor='#CCCCCC'>9 AM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_1" id="3_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_2" id="3_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_3" id="3_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_4" id="3_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_5" id="3_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_6" id="3_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"3_7" id="3_7" /></td>


</tr>
<tr>
<td bgcolor='#CCCCCC'>10 AM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_1" id="4_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_2" id="4_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_3" id="4_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_4" id="4_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_5" id="4_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_6" id="4_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"4_7" id="4_7" /></td>


</tr>
<tr>
<td bgcolor='#CCCCCC'>11 AM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_1" id="5_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_2" id="5_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_3" id="5_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_4" id="5_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_5" id="5_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_6" id="5_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"5_7" id="5_7" /></td>


</tr>
<tr>
<td bgcolor='#CCCCCC'>12 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_1" id="6_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_2" id="6_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_3" id="6_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_4" id="6_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_5" id="6_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_6" id="6_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"6_7" id="6_7" /></td>


</tr>
<tr>
<td bgcolor='#CCCCCC'>1 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_1" id="7_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_2" id="7_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_3" id="7_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_4" id="7_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_5" id="7_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_6" id="7_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"7_7" id="7_7" /></td>


</tr>
<tr>
<td bgcolor='#CCCCCC'>2 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_1" id="8_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_2" id="8_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_3" id="8_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_4" id="8_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_5" id="8_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_6" id="8_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"8_7" id="8_7" /></td>


</tr>
<tr>
<td bgcolor='#CCCCCC'>3 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_1" id="9_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_2" id="9_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_3" id="9_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_4" id="9_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_5" id="9_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_6" id="9_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"9_7" id="9_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">4 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_1" id="10_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_2" id="10_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_3" id="10_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_4" id="10_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_5" id="10_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_6" id="10_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"10_7" id="10_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">5 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_1" id="11_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_2" id="11_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_3" id="11_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_4" id="11_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_5" id="11_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_6" id="11_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"11_7" id="11_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">6 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_1" id="12_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_2" id="12_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_3" id="12_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_4" id="12_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_5" id="12_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_6" id="12_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"12_7" id="12_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">7 PM
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_1" id="13_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_2" id="13_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_3" id="13_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_4" id="13_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_5" id="13_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_6" id="13_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"13_7" id="13_7" /></td>

</tr>
<tr>
<td bgcolor="#CCCCCC">8 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_1" id="14_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_2" id="14_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_3" id="14_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_4" id="14_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_5" id="14_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_6" id="14_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"14_7" id="14_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">9 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_1" id="15_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_2" id="15_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_3" id="15_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_4" id="15_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_5" id="15_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_6" id="15_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"15_7" id="15_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">10 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_1" id="16_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_2" id="16_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_3" id="16_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_4" id="16_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_5" id="16_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_6" id="16_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"16_7" id="16_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">11 PM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_1" id="17_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_2" id="17_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_3" id="17_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_4" id="17_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_5" id="17_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_6" id="17_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"17_7" id="17_7" /></td>


</tr>
<tr>
<td bgcolor="#CCCCCC">12 AM
</td>
<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_1" id="18_1" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_2" id="18_2" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_3" id="18_3" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_4" id="18_4" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_5" id="18_5" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_6" id="18_6" /></td>

<td align='center'><img onclick="cambiarImagen(this.id);" src="common/img/tiempo_libre.png"  name=
"18_7" id="18_7" /></td>

</tr>


</table>
<div id='descripcion' name='descripcion' style='position:absolute; width: 700px left:0px; top:0px; z-index: 99; display:none;background-color:#FFFFFF; '>
<table border='2' width='100%' cellpadding='2' cellspacing='2' align='center'>
<tr><td colspan='4' align='center'><font color="#000000" size="4"><strong>Descripci&oacute;n de los items</strong></font></td></tr>
<tr><td align='center' width='25%'>
<img src='common/img/trabajo.png' alt='Horas de trabajo' title='Horas de trabajo' /><p>Horas de trabajo
</td><td align='center' width='25%'>
<img src='common/img/estudio.png' alt='Horas destinadas a estudiar en forma grupal o individual' title='Horas destinadas a estudiar en forma grupal o individual' /><p>Horas destinadas a estudiar en forma grupal o individual
</td><td align='center' width='25%'>
<img src='common/img/tiempo_libre.png' alt='Horas destinadas a otras actividades' title='Horas destinadas a otras actividades' /><p>Horas destinadas a otras actividades
</td><td align='center' width='25%'>
<img src='common/img/cursada.png' alt='Horas de cursada en la facultad' title='Horas de cursada en la facultad' /><p>Horas de cursada en la facultad
</td></tr>
<tr><td colspan='4' align='center'>Para seleccionar el item correspondiente para cada d&iacute;a/hora, haga click en su imagen</td></tr>
</table>
</div>
<input type='hidden' name='agenda' id='agenda' value='agenda1'></input>
<br>
<div id='div_seleccion' name='div_seleccion' style='display:none;'></div>
<?

?>