<?php
	include ("cabecera.php");
	require_once( "sparqllib.php" );
?>	

<?php

	// Obtenemos el grafo del amigo
	$sparq_get_friendgraph = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT ?x
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick \"".$_POST['inputfriend']."\".
		}
	";
	
	// Realizamos la consulta para obtener el grafo del amigo
	$consulta_get_friendgraph = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparq_get_friendgraph)
	;
	
	foreach( $consulta_get_friendgraph as $row ){
		foreach( $consulta_get_friendgraph->fields() as $field ){			
			$friend_graph = $row[$field];
		}
	}
	
	
	// Borramos a nuestro amigo
	$sparql_del_friend = "
		WITH <linked-friends:user>
		DELETE { 
			?person <http://xmlns.com/foaf/0.1/knows> <".$friend_graph.">.
		}
		WHERE{ 
			?person <http://xmlns.com/foaf/0.1/knows> <".$friend_graph.">.
			?person <http://xmlns.com/foaf/0.1/nick> \"".$_POST['nick']."\".
		} 
	";
	
	// Realizamos la consulta para borrar a nuestro amigo
	$consulta_del_friend = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_del_friend)
	;
	
?>
	
	<div style="margin-top:250px; margin-left:250px;">
		<h3> Vaya <?php echo $_POST['nick']; ?>! Parece que ya no eres amigo de <?php echo $_POST['inputfriend']; ?>. </h3>
		<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
	</div>

<?php
	include ("footer.php");
?>