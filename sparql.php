<?php
	include ("cabecera.php");
?>
	<form method="post" action="consulta-sparql.php">
		<h1 style="color:#fff;"> Consulta SPARQL </h1>
		<textarea rows="4" cols="50" id="consulta" name="consulta"></textarea>
		<input type="button" value="Volver" class="styled-button" style="margin-top:10px;" onclick="javascript:history.back();"/>
		<input type="submit" class="styled-button" svalue="Realizar consulta"/>
	</form>

<?php
	include ("footer.php");
?>