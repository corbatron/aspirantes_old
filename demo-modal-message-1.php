<link href='http://fonts.googleapis.com/css?family=Rosarivo' rel='stylesheet' type='text/css'>

<script type="text/javascript" src="js/jscharts.js"></script>

<style>
	 h1{
        font-family: 'Rosarivo', serif;
        font-size: 48px;
      }
	  	 h3 {
        font-family: 'Rosarivo', serif;
        font-size: 20px;
      }
</style>
<form name="myForm" method="post" action="veriflogin.php" enctype="multipart/form-data">

	<table width='100%'>
		<tr>
			<td><img src="../images/logoutn.png"></td><td><H3>Sistema Integral de Tutorias </H3></td>
		</tr>
		<tr>
			<td><label for="firstname">A&ntilde;o de ingreso:</label></td>
			<td><select id='anio_ingreso' name='anio_ingreso' style='width:120Px'><option value='2012'>2012</option><option value='2013'>2013</option></select></td>
		</tr>
		<tr>
			<td><label for="firstname">Usuario:</label></td>
			<td><input type="text" name="firstname" id="firstname"></td>
		</tr>
		<tr>
			<td><label for="lastname">Contrase&ntilde;a:</label></td>
			<td><input type="password" name="lastname" id="lastname"></td>
		</tr>
		<tr>
			<td colspan='2' align="center">
			<input type="submit" value="Validar"></td>
		</tr>
	</table>
	<script type="text/javascript">
	document.myForm.firstname.focus();
	
	function mostrar()
	{
		
		alert(document.getElementById('lastname').value);
		
	}
	</script>
