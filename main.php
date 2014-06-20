<?php
	include ("cabecera.php");
	require_once( "sparqllib.php" );
?>		

	<div style="margin-top: -280px; margin-left:-300px;">
		
		<form method="post" action="friend-graph.php">
			<h3> Hola, <?php echo $_POST['user']; ?> 
			<input type="button" class="styled-button" value="Mis amigos" onclick="showFriends();"/> 
			<input type="button" class="styled-button" value="Nuevo amigo" onclick="showUsers();"/> 
			<input type="button" class="styled-button" value="Mi Panel" onclick="showPanel();"/> 
			<input type="submit" class="styled-button-orange" value="Grafo de amigos"/>
			<input type="hidden" value="<?php echo $_POST['user']; ?>" name="user" />
			<input type="button" class="styled-button-red" value="Salir" onclick="javascript:location.href='index.php';"/>
			</h3> 
		</form>
		
	</div>
	
	<!-- SCRIPTS -->
	
	<!-- MIS AMIGOS -->
	<script language="javascript"> 
	
		function showFriends(){
			if (document.getElementById('divFriendsList').style.display !== 'none') {
				document.getElementById('divFriendsList').style.display = 'none';
			}
			else {
				document.getElementById('divUsersList').style.display = 'none';
				document.getElementById('divMiPanel').style.display = 'none';
				document.getElementById('divFriendsList').style.display = 'block';
				
			}
		}
		
	</script>
	
	<!-- NUEVO AMIGO -->
	<script language="javascript"> 
		
		function showUsers(){

			if (document.getElementById('divUsersList').style.display !== 'none') {
				document.getElementById('divUsersList').style.display = 'none';
			}
			else {
				document.getElementById('divFriendsList').style.display = 'none';
				document.getElementById('divMiPanel').style.display = 'none';
				document.getElementById('divUsersList').style.display = 'block';
			}
		}
		
	</script>
	
	<!-- MI PANEL -->
	<script language="javascript"> 
		
		function showPanel(){
			if (document.getElementById('divMiPanel').style.display !== 'none') {
				document.getElementById('divMiPanel').style.display = 'none';
			}
			else {
				document.getElementById('divUsersList').style.display = 'none';
				document.getElementById('divFriendsList').style.display = 'none';
				document.getElementById('divMiPanel').style.display = 'block';
			}
		}
		
	</script>
	
<!-- LISTA DE AMIGOS -->
<?php 
	// Obtiene la lista de amigos
	$sparql_friends = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT ?knows
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick \"".$_POST['user']."\".
			?x foaf:knows ?knows.
		}"
	;
	
	// Realizamos la consulta para obtener la lista de amigos
	$consulta_friends = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_friends)
	;
	
	// Contamos si tiene amigos o no
	$cont = 0;
	foreach( $consulta_friends as $row ){
		foreach( $consulta_friends->fields() as $field ){			
			$cont = $cont + 1;
		}
	}
	
	
?>

	<div style="margin-top: 10px; margin-left: -300px; display:none;" id="divFriendsList">
		<h1> Tus amigos </h1>
		
		<?php
		// Si NO tiene amigos
		if ($cont == 0){
		?> 
			<h3> No tienes amigos todavia. </h3>
			<input type="button" class="styled-button" value="Actualizar lista" onclick="window.location.reload();"/>
		<?php
		// Si tiene amigos
		}else{
			$contador = 0;
			foreach( $consulta_friends as $row ){
				foreach( $consulta_friends->fields() as $field ){
				
					// Obtenemos el nick de nuestros amigos (knows)
					$sparql_data_friends = "
						PREFIX foaf: <http://xmlns.com/foaf/0.1/>
						SELECT ?nick
						FROM <linked-friends:user>
						WHERE { 
							<".$row[$field]."> foaf:nick ?nick .
						}
					";
					
					// Realizamos la consulta para obtener el nombre, apellido y nick de nuestro amigo
					$consulta_data_friends = sparql_get( 
						"http://localhost:8890/sparql/",
						"".$sparql_data_friends)
					;
					
					// Mostramos: Nombre Apellido (nick)
					
					foreach( $consulta_data_friends as $row2 ){
						
						?> <h3> <?php
						
						foreach( $consulta_data_friends->fields() as $field2 ){

							if ($contador == 0){
								?> <input type="radio" name="radio-friend" checked="checked" value="<?php echo $row2[$field2]; ?>" id="radiofriend<?php echo $contador; ?>" onClick="SelectedRadioButtonFriends(<?php echo $contador; ?>);"/> <?php
							}else{
								?> <input type="radio" name="radio-friend" value="<?php echo $row2[$field2]; ?>" id="radiofriend<?php echo $contador; ?>" onClick="SelectedRadioButtonFriends(<?php echo $contador; ?>);"/> <?php
							}
							echo $row2[$field2];
							
							$contador = $contador + 1;

						}
						
						?> </h3> <?php 
					}
					
				}
			}
			
			?> 
				<form method="post" action="delete-friend.php" onsubmit="CheckRadioButton_deleteFriend();">
					<input type="submit" class="styled-button-red" value="Borrar"/>
					<input type="hidden" value="" name="inputfriend" id="inputfriend"/>
					<input type="hidden" value="<?php echo $_POST['user'] ?>" name="nick"/>
					<input type="button" class="styled-button" value="Actualizar lista" onclick="window.location.reload();"/> 
				</form>
				
				
			<?php
		}
		?>
	</div>
	
	<script language="javascript">
	
		// Comprueba si no has seleccionado ningún usuario, en ese caso, elige el primero de la lista de amigos
		function CheckRadioButton_deleteFriend(){
			if (document.getElementById('inputfriend').value == ""){
				var friendSelected = document.getElementById("radiofriend0").value;
				document.getElementById('inputfriend').value = friendSelected;
			}
		}
		
		// Agrega el usuario seleccionado a un input type hidden (id: radioselected)
		function SelectedRadioButtonFriends(id){
			document.getElementById('inputfriend').value = document.getElementById('radiofriend'+id).value;
		}
		
	</script>

<!-- LISTA DE USUARIOS REGISTRADOS EN EL SERVIDOR (SIN CONTAR CONMIGO, NI MIS AMIGOS) -->
<?php 
	$sparql_users = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT ?nick
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick ?nick.
		}"
	;
	
	// Realizamos la consulta para saber si existe el usuario en el sistema
	$consulta_users = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_users)
	;
	
	$contUsers = 0;
	foreach( $consulta_users as $row ){
		foreach( $consulta_users->fields() as $field ){
			//echo $row[$field];
			$contUsers = $contUsers + 1;
		}
	}
	
	function isFriend($user){
		$existe = false;
		$sparql_frnds = "
			PREFIX foaf: <http://xmlns.com/foaf/0.1/>
			SELECT ?knows
			FROM <linked-friends:user>
			WHERE { 
					?x foaf:nick \"".$_POST['user']."\".
					?x foaf:knows ?knows.
			}
		"; 
		$consulta_frnds = sparql_get( 
			"http://localhost:8890/sparql/",
			"".$sparql_frnds)
		;
		
		foreach( $consulta_frnds as $row1 ){
			foreach( $consulta_frnds->fields() as $field1 ){
			
				// Obtenemos el nick de nuestro amigo
				$sparql_data_frnds = "
					PREFIX foaf: <http://xmlns.com/foaf/0.1/>
					SELECT ?nick
					FROM <linked-friends:user>
					WHERE { 
						<".$row1[$field1]."> foaf:nick ?nick .
					}
				";
				
				$consulta_data_frnds = sparql_get( 
					"http://localhost:8890/sparql/",
					"".$sparql_data_frnds)
				;
				
				foreach( $consulta_data_frnds as $row2 ){
					foreach( $consulta_data_frnds->fields() as $field2 ){
						if ($row2[$field2] == $user){
							return true;
						}else{
							$existe = false;
						}
					}
				}
				
			}
		}
		return $existe;
	}
	
?>

	<div style="margin-top: 10px; margin-left: -300px; display:none;" id="divUsersList">
		<h1> Lista de usuarios registrados </h1>
		
		<?php
		if ($contUsers == 0){
		?> 
			<h3> No hay usuarios registrados. </h3>
		<?php
		}else{
			$contUsers_ = 0;
			foreach( $consulta_users as $row ){
				foreach( $consulta_users->fields() as $field ){
					if ( ($row[$field] != $_POST['user']) and (!isFriend($row[$field])) ){
						if ($contUsers_ == 0){
							?> <h3> <input type="radio" name="radio-add-friend" value="<?php echo $row[$field]; ?>" id="<?php echo $contUsers_ ?>" checked="checked" onClick="SelectedRadioButton(<?php echo $contUsers_; ?>);"/>  <?php echo $row[$field]; ?> </h3> <?php
						}else{
							?> <h3> <input type="radio" name="radio-add-friend" value="<?php echo $row[$field]; ?>" id="<?php echo $contUsers_ ?>" onClick="SelectedRadioButton(<?php echo $contUsers_; ?>);"/> <?php echo $row[$field]; ?> </h3> <?php
						}
						$contUsers_ = $contUsers_ + 1;
					}
					
				}
			}
			?>
			<form method="post" action="add-friend.php" onsubmit="CheckRadioButton();">
				<input type="submit" class="styled-button" value="Agregar"/>
				<input type="button" class="styled-button" value="Actualizar lista" onclick="window.location.reload();"/>
				<input type="hidden" value="<?php echo $_POST['user'];?>" name="nick"/>
				<input type="hidden" value="" name="radioselected" id="radioselected"/>
			</form>
			
			<?php
		}
		?>
	</div>
	
	<script language="javascript">
	
		// Comprueba si no has seleccionado ningún usuario, en ese caso, elige el primero de la lista de amigos
		function CheckRadioButton(){
			if (document.getElementById('radioselected').value == ""){
				var userSelected = document.getElementById("0").value;
				document.getElementById('radioselected').value = userSelected;
			}
		}
		
		// Agrega el usuario seleccionado a un input type hidden (id: radioselected)
		function SelectedRadioButton(contUsers){
			var userSelected = document.getElementById(contUsers).value;
			document.getElementById('radioselected').value = userSelected;
		}
		
	</script>

<!-- MI PANEL -->
	<div style="margin-top: 10px; margin-left: -300px; display:none;" id="divMiPanel">
		<h1> Opciones de cuenta </h1>
		
		<h3> Cambiar password </h3>
		<input type="button" class="styled-button" value="Cambiar" />
		<h3> Borrar cuenta </h3>
		<form method="post" action="delete.php">
			<input type="submit" class="styled-button-red" value="Darme de baja"/>
			<input type="hidden" value="<?php echo $_POST['user'];?>" name="nick"/>
		</form>
	</div>



<?php
	include ("footer.php");
?>