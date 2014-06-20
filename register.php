<?php
	include ("cabecera.php");
?>		
	
	<div style="margin-top: 210px; margin-left: 250px; z-index:1; position:absolute;">
		<form method="post" action="register-control.php">
			<!-- <h1> Registro de usuario </h1> -->
			<div>
				<table> 
					<tr>
						<td>
							<span style="color:#fff;">Nick (username): </span>
						</td>
						<td>
							<input type="text" style="width: 200px;" id="nick" name="nick"/>
						</td>
						<td>
							<span style="color:red;">*</span><span style="color:#fff;"> debe de ser unico.</span>
						</td>
					</tr>
					<tr>
						<td>
							<span style="color:#fff;">Nombre: </span>
						</td>
						<td>
							<input type="text" style="width: 200px;" id="name" name="name"/>
						</td>
					</tr>
					<tr>
						<td>
							<span style="color:#fff;">Primer apellido: </span>
						</td>
						<td>
							<input type="text" style="width: 200px;" id="familyname" name="familyname"/>
						</td>
					</tr>
					
					<tr>
						<td>
							<span style="color:#fff;">Password: </span>
						</td>
						<td>
							<input type="password" style="width: 200px;"  id="pass" name="pass"/>
						</td>
					</tr>
					<tr>
						<td>
							<span style="color:#fff;">E-mail: </span>
						</td>
						<td>
							<input type="email" style="width: 200px;" id="email" name="email"/>
						</td>
					</tr>
				</table>
				<br/>
				<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
				<input type="reset" class="styled-button" value="Limpiar datos"/>
				<input type="submit" class="styled-button" value="Registrar"/>
			</div>
		</form> 
	</div>
	
<?php
	include ("footer.php");
?>