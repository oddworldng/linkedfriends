<?php
	include ("cabecera.php");
?>		
	<!-- <h1> Control de registro </h1> -->
	

<?php

	require_once( "sparqllib.php" );
	
	// COMPROBAMOS SI EXISTE EL NICK (USERNAME) INTRODUCIDO
	// Consulta: comprueba si existe el nick (username) introducido
	$sparql_user_exist = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT COUNT(*)
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick \"".$_POST['nick']."\"
		}"
	;
	
	// Realizamos la consulta para saber si existe el usuario en el sistema
	$consulta_user_exist = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_user_exist)
	;
	
	
	foreach( $consulta_user_exist as $row ){
		foreach( $consulta_user_exist->fields() as $field ){
			$exist = $row[$field];
		}
	}
	
	if ($exist == 0){ // Si no existe el usuario, lo creamos
		// CREAR EL USUARIO AQUI
		// Insertamos al usuario en el servidor
		$sparql_insert_user = "
			INSERT DATA { 
				GRAPH <linked-friends:user> {
					<linked-friends:user:".$_POST['nick']."> a
					<http://xmlns.com/foaf/0.1/Person>;
					<http://xmlns.com/foaf/0.1/name> \"".$_POST['name']."\";
					<http://xmlns.com/foaf/0.1/familyName> \"".$_POST['familyname']."\";
					<http://xmlns.com/foaf/0.1/nick> \"".$_POST['nick']."\";
					<http://xmlns.com/foaf/0.1/password> \"".$_POST['pass']."\";
					<http://xmlns.com/foaf/0.1/mbox> \"".$_POST['email']."\".
				} 
			}"
		;
		// Realizamos la consulta para crear el usuario
		$consulta_insert_user = sparql_get( 
			"http://localhost:8890/sparql/",
			"".$sparql_insert_user)
		;
		
		?>
		<div style="margin-top:260px; margin-left:180px;">
			<h3> Enhorabuena! <?php echo $_POST['nick']?> ya eres miembro de Linked Friends. </h3>
			<input type="button" value="Volver a la pagina principal" class="styled-button" onclick="javascript:window.location.href = 'index.php';"/>
			<input type="button" value="Login" class="styled-button" onclick="javascript:window.location.href = 'login.php';"/>
		</div>
		<?php
	}else{
		?>
		<div style="margin-top:230px; margin-left:250px;">
			<h3> ERROR. Ya existe el usuario <?php echo $_POST['nick']?> </h3>
			<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
		</div>
		<?php
	}
	
	
?>
			
<?php
	include ("footer.php");
?>