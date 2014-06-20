<html>

<head>

	<script type="text/javascript" src="lib-dracula/js/raphael-min.js"></script>
    <script type="text/javascript" src="lib-dracula/js/dracula_graffle.js"></script>
    <script type="text/javascript" src="lib-dracula/js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="lib-dracula/js/dracula_graph.js"></script>
	
	<?php
		include ("cabecera.php");
		require_once( "sparqllib.php" );

	?>	

    
</head>

<body>

	<div style="margin-top: -280px; margin-left:-300px;">
		<h3 style="color: #5B74A8;"> Grafo de amigos de <?php echo $_POST['user']; ?> </h3>
		<input type="button" class="styled-button" value="Volver" onclick="javascript:history.back();"/> 
		<input type="button" class="styled-button" value="Mostrar" onclick="javascript:Mostrar();"/> 
		
	</div>
	
	
	<script type="text/javascript" language="javascript">
		

		/* only do all this when document has finished loading (needed for RaphaelJS) */
		function Mostrar() {
			var redraw, g, renderer;
			
			var width = $(document).width() - 20;
			var height = $(document).height() - 60;
			
			g = new Graph();
			g.edgeFactory.template.style.directed = true;
			/* customize the colors of that edge */
			
			<?php
				

				global $usuario;
				global $arrayFriends;
				global $arrayFriendsVisited;
				global $terminado;
				
				$cont = 0;
				$terminado = false;
				$usuario = $_POST['user'];
				$arrayFriends[] = $usuario;
				$arrayFriendsVisited[] = $usuario;


				while($terminado == false){
					
					
					/* Obtiene la lista de amigos */
					$sparql_friends = "
						PREFIX foaf: <http://xmlns.com/foaf/0.1/>
						SELECT ?knows
						FROM <linked-friends:user>
						WHERE { 
							?x foaf:nick \"".$usuario."\".
							?x foaf:knows ?knows.
						}"
					;
					
					/* Realizamos la consulta para obtener la lista de amigos */
					$consulta_friends = sparql_get( 
						"http://localhost:8890/sparql/",
						"".$sparql_friends)
					;
					/*  Contamos si tiene amigos o no */
					foreach( $consulta_friends as $row ){
						foreach( $consulta_friends->fields() as $field ){	
							/*  Obtenemos el nick de nuestro amigo */
							$sparql_data_friends = "
								PREFIX foaf: <http://xmlns.com/foaf/0.1/>
								SELECT ?nick
								FROM <linked-friends:user>
								WHERE { 
									<".$row[$field]."> foaf:nick ?nick .
								}
							";
							
							/*  Realizamos la consulta para obtener el nombre, apellido y nick de nuestro amigo */
							$consulta_data_friends = sparql_get( 
								"http://localhost:8890/sparql/",
								"".$sparql_data_friends)
							;
							
							/*  Mostramos: Nombre Apellido (nick) */
							
							foreach( $consulta_data_friends as $row2 ){
								foreach( $consulta_data_friends->fields() as $field2 ){
									
									// Add Friend
									$existe = false;
									foreach ($arrayFriends as $arrayFriend){
										if ($arrayFriend == $row2[$field2]){
											$existe = true;
											break;
										}else{
											$existe = false;
										}
									}
									
									if ($existe == false){
										$arrayFriends[] = $row2[$field2];
									}
									
									// Create graph
									?>
									g.addEdge("<?php echo $usuario; ?>", "<?php echo $row2[$field2]; ?>", { stroke : "#bfa" , fill : "#56f", label : "Conoce a" });
									<?php
										
									
								}
							}
						}
					}

					// Add Visited
					$vNum = count($arrayFriendsVisited);
					$fNum = count($arrayFriends);

					$contador = 0;
					foreach ($arrayFriends as $arrayFriend){
						if ($contador == $vNum){
							$arrayFriendsVisited[] = $arrayFriend;
							$usuario = $arrayFriend;
							break;
						}
						$contador = $contador + 1;
					}
					
					if (($vNum != 1) and ($vNum == $fNum)){
						$terminado = true;
					}	
					
					// No tiene amigos
					if ($fNum == 1){
						$terminado = true;
						?>
						 alert('Lo siento <?php echo $_POST['user']; ?>, no tienes amigos');
						<?php
					}

					
				}

				
				
			?>
			
			st = { directed: true, label : "Label",
				"label-style" : {
					"font-size": 30
				}
			}

			/* layout the graph using the Spring layout implementation */
			var layouter = new Graph.Layout.Spring(g);
			
			/* draw the graph using the RaphaelJS draw implementation */
			renderer = new Graph.Renderer.Raphael('canvas', g, 900, 600);

		};
	</script>
	
	<div id="canvas" style="color:white; margin-top:0px; margin-left:-50px;"></div>
	

	
	<?php
		include ("footer.php");
	?>
</body>

</html>

