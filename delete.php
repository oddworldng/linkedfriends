<?php
	include ("cabecera.php");
	require_once( "sparqllib.php" );
?>		

<?php
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
	
	/*
	SELECT *
	FROM <linked-friends:user>
	WHERE {?s ?p ?o}
	*/
	
	// Realizamos la consulta para borrar un usuario del servidor
	$consulta_delete_nofriends_user = sparql_get( 
		"http://localhost:8890/sparql/",
		"".$sparql_delete_nofriends_user)
	;
	
?>

	<div style="margin-top:250px; margin-left:250px;">
		<h3 style="color:#fff;"> Se ha borrado el usuario <?php echo $_POST['nick']?> correctamente. </h3>
		<input type="button" value="Volver a la pagina principal" class="styled-button" onclick="javascript:window.location.href = 'index.php';"/>
	</div>

<?php
	include ("footer.php");
?>