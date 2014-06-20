<?php
	include ("cabecera.php");
	require_once( "sparqllib.php" );
?>		

<?php

	// Obtiene el grafo del amigo que queremos agregar
	$sparql_user_graph = "
		PREFIX foaf: <http://xmlns.com/foaf/0.1/>
		SELECT *
		FROM <linked-friends:user>
		WHERE { 
			?x foaf:nick \"".$_POST['radioselected']."\".
		}
	";
	
	// Realizamos la consulta para obtener el grafo del amigo que queremos agregar
	$consulta_user_graph = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_user_graph)
	;
	
	// Guardamos en la variable "friend_graph" el grafo del nuevo amigo
	foreach( $consulta_user_graph as $row ){
		foreach( $consulta_user_graph->fields() as $field ){
			$friend_graph = $row[$field];
		}
	}
	
	
	// Inserta un nuevo amigo
	$sparql_insert_friend = "
		INSERT DATA { 
			GRAPH <linked-friends:user> {
				<linked-friends:user:".$_POST['nick']."> a
				<http://xmlns.com/foaf/0.1/Person>;
				<http://xmlns.com/foaf/0.1/knows> <".$friend_graph.">.
			} 
		}"
	;
	
	// Realizamos la consulta para agregar al nuevo amigo
	$consulta_insert_friend = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_insert_friend)
	;
	

/*
$sparql_delete_nofriends_user = "
		WITH <linked-friends:user>
		DELETE { 
			?person <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?pers.
			?person <http://xmlns.com/foaf/0.1/nick> \"".$_POST['nick']."\".
			?person <http://xmlns.com/foaf/0.1/mbox> ?mbox.
			?person <http://xmlns.com/foaf/0.1/name> ?name.
			?person <http://xmlns.com/foaf/0.1/familyName> ?familyName.
			?person <http://xmlns.com/foaf/0.1/password> ?password.
		}
		WHERE{ 
			?person <http://xmlns.com/foaf/0.1/nick> \"".$_POST['nick']."\".
			?person <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?pers.
			?person <http://xmlns.com/foaf/0.1/mbox> ?mbox.
			?person <http://xmlns.com/foaf/0.1/name> ?name.
			?person <http://xmlns.com/foaf/0.1/familyName> ?familyName.
			?person <http://xmlns.com/foaf/0.1/password> ?password.
		} 
	";
	*/
	
	
	/*
	SELECT *
	FROM <linked-friends:user>
	WHERE {?s ?p ?o}
	*/
	
	// Realizamos la consulta para borrar un usuario del servidor
	/*$consulta_delete_nofriends_user = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_delete_nofriends_user)
	;*/
	
?>

	<div style="margin-top:250px; margin-left:250px;">
		<h3> Enhorabuena <?php echo $_POST['nick']; ?>! ahora eres amigo de <?php echo $_POST['radioselected']?>. </h3>
		<input type="button" value="Volver" class="styled-button" onclick="javascript:history.back();"/>
	</div>

<?php
	include ("footer.php");
?>