<?php
	include ("cabecera.php");
?>		
	<!-- <form method="post" action="consulta-sparql.php">
		<h1> Introduce una consulta SPARQL </h1>
		<textarea rows="4" cols="50" id="consulta" name="consulta"></textarea>
		<input type="button" value="Volver" onclick="javascript:history.back();"/>
		<input type="submit" value="Realizar consulta"/>
	</form> -->
	
	<div style="margin-top: 250px; margin-left: 320px;">
		
		<form method="post" action="acceso.php">
		<!-- <h1 style="color:#fff;"> Introduce tus datos de acceso </h1> -->
		<div>
			<table> 
				<tr>
					<td>
						<span style="color:#fff;">Nick: </span>
					</td>
					<td>
						<input type="text" id="user" name="user"/>
					</td>
				</tr>
				<tr>
					<td>
						<span style="color:#fff;">Password: </span>
					</td>
					<td>
						<input type="password" id="pass" name="pass"/>
					</td>
				</tr>
			</table>
			<br/>
			<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
			<input type="submit" value="Login" class="styled-button"/>
		</div>
	</form> 
		
	</div>
			
<?php
	include ("footer.php");
?>