<?php
	include ("cabecera.php");
?>		
	<!-- <h1 style="color: #fff;"> Control de acceso </h1> -->
	

<?php

	require_once( "sparqllib.php" );
	
	// Consulta: devuelve los usuarios del sistema
	$sparql_users = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT ?nick
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick ?nick
		}"
	;
	
	// Consulta: devuelve la contraseña de un determinado usuario
	$sparql_password = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT ?password
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick \"".$_POST['user']."\".
			?x foaf:password ?password.
      
		}"
	;
	
	// Realizamos la consulta para obtener los usuarios registrados en el sistema
	$consulta_users = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_users)
	;
	
	// Comprobamos que existe el usuario en nuestro sistema
	$userExist = false;
	foreach( $consulta_users as $row ){
		foreach( $consulta_users->fields() as $field ){
			if ($row[$field] == $_POST['user']){
				$userExist = true;
			}
		}
	}
	
	// Si el usuario existe, comprobamos la contraseña
	if ($userExist){
	
		//echo "Existe el usuario " .$_POST['user']; ?> <br/> <?php
		
		// Realizamos la consulta para obtener los usuarios registrados en el sistema
		$consulta_password = sparql_get( 
			"http://localhost:8890/sparql/",
			"".$sparql_password)
		;
		
		// Comprobamos que existe el usuario en nuestro sistema
		$passExist = false;
		foreach( $consulta_password as $row2 ){
			foreach( $consulta_password->fields() as $field2 ){
				if ($row2[$field2] == $_POST['pass']){
					$passExist = true;
				}
			}
		}
		
		if ($passExist){
			?>
			<div style=" margin-top:240px; margin-left:280px;">
				<h1 style="color:#fff;"> Bienvenido <?php echo $_POST['user']?>. </h1>
				<form method="post" action="main.php">
				
					<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
					<input type="submit" class="styled-button" value="Continuar"/>		
					<input type="hidden" value="<?php echo $_POST['user']?>"/ name="user"/>
					
				</form>
			</div>
			<?php
		}else{	
			?> 
				<div style="margin-top:250px; margin-left:180px;">
					<h3 style="color:#fff;"> ERROR. <?php echo $_POST['user']?>, has introducido un password incorrecto. </h3>
					<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
				</div>
			<?php
		}
		
	}else{
		?> 
			<div style="margin-top:250px; margin-left:250px;">
				<h3 style="color:#fff;"> ERROR. No existe el usuario <?php echo $_POST['user']?>. </h3>
				<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
			</div>
		<?php
	}
	

	
	
	/*echo "Usuario: " . $_POST['user']; ?><br/><?php
	echo "Password: " . $_POST['pass'];*/

?>
	</div>		
<?php
	include ("footer.php");
?>