<?
include("ver_login.php");
?>
<form name="querysonline" action="executequery.php" target="iframe_query" >
<table>
<tr>
<td colspan='2'>
<textarea name="query_ex" rows="10" cols="100" wrap="virtual"></textarea><br>
</td>
</tr>
<tr>
<td>
Usuario</td><td><input  type='text' width='10' name='usuario' id='usuario'></input><br>
</td>
</tr>
<tr>
<td>
Password</td><td><input  type='password' width='10' name='password' id='password'></input><br>
</td>
</tr>
<tr>
<td>
<input type="submit" value="Ejecutar query"/>
</td>
</tr>
</table>
</form>
<iframe id="iframe_query" name='iframe_query' width="100%" height="400px">
</iframe>
