<?php
	include ("cabecera.php");
?>

	<h1> Consulta realizada </h1>
	<?php
		if ($_POST['consulta'] == ""){
			echo "No ha introducido ninguna consulta";
		}else{
			echo $_POST['consulta'];
		}
	?>
	<h1> Resultado de la consulta </h1>
	<?php
		require_once( "sparqllib.php" );
 
		if (is_localhost() == true){ // VERSION LOCALHOST
			$data = sparql_get( 
			"http://localhost:8890/sparql/",
			"".$_POST['consulta']);
		}else{ // VERSION ONLINE
			$data = sparql_get( 
				"http://dbpedia.org/sparql/",
				//"http://rdf.ecs.soton.ac.uk/sparql/",
				//"http://localhost:8890/sparql",
				"".$_POST['consulta']);
		}
		if( !isset($data) )
		{
			print "<p>Error: ".sparql_errno().": ".sparql_error()."</p>";
		}
		 
		print "<table class='example_table'>";
		print "<tr>";
		foreach( $data->fields() as $field )
		{
			print "<th>$field</th>";
		}
		print "</tr>";
		foreach( $data as $row )
		{
			print "<tr>";
			foreach( $data->fields() as $field )
			{
				print "<td>$row[$field]</td>";
			}
			print "</tr>";
		}
		print "</table>";

	?>
	<hr/>
	<span> Guia utilizada: <a href="http://graphite.ecs.soton.ac.uk/sparqllib/" target="blank_">Guia</a> </span></br>
	<span> Libreria utilizada: <a href="https://github.com/cgutteridge/PHP-SPARQL-Lib/blob/master/sparqllib.php" target="blank_">Libreria</a> </span></br>
	<span> <strong>AVISO</strong>: En la version online se utiliza <a href="http://dbpedia.org/sparql" target="blank_">dbpedia</a>, y la version local usamos Virtuoso <a href="http://localhost:8890/sparql" target="blank_">http://localhost:8890/sparql</a></span></br>
	<hr/></br>
	<input type="button" value="Volver" onclick="javascript:history.back();"/>
	<input type="button" value="Inicio" onclick="javascript:location.href='index.php';"/>
	</br>

<?php
	//include ("footer.php");
?>