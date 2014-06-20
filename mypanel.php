<?php
	include ("cabecera.php");
?>		

	<div style="margin-top: -280px; margin-left:-300px;">
		<h3> Hola, <?php echo $_POST['user']; ?> <input type="button" class="styled-button" value="Mis amigos"/> <input type="button" class="styled-button" value="Nuevo amigo"/> <input type="button" class="styled-button" value="Mi Panel"/> <input type="button" class="styled-button-red" value="Salir" onclick="javascript:location.href='index.php';"/></h3> 
	</div>
	
<?php
	$sparql_delete_user = "
		WITH <tfg:virtuoso:linked-data:user>
		DELETE { 
			?person <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?pers.
			?person <http://xmlns.com/foaf/0.1/nick> ?nick.
			?person <http://xmlns.com/foaf/0.1/mbox> ?mbox.
			?person <http://xmlns.com/foaf/0.1/familyName> ?familyName.
			?person <http://xmlns.com/foaf/0.1/password> ?password.
		}
		WHERE{ 
			?person <http://xmlns.com/foaf/0.1/nick> \"".$_POST['nick']."\".
			?person <http://www.w3.org/1999/02/22-rdf-syntax-ns#type> ?pers.
			?person <http://xmlns.com/foaf/0.1/mbox> ?mbox.
			?person <http://xmlns.com/foaf/0.1/familyName> ?familyName.
			?person <http://xmlns.com/foaf/0.1/password> ?password.
		} 
	";
?>

	
<?php
	include ("footer.php");
?>