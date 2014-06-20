			</div> <!-- CONTENIDO CENTRAL (END)-->
			
			<!-- COLUMNA DERECHA -->
			<div id="right">
				<div id="right-ejemplo">
					<?php
						$file = basename($_SERVER['PHP_SELF']);
						switch($file){
							case "sql.php":
								?>
								<h3>Ejemplo de consulta en SQL</h3>
								<h4>SELECT * <br>FROM <em>tabla</em> <br>WHERE <em>condicion1=condicion1</em> <br>AND <em>condicion2=condicion2</em></h4>
								<?php
							break;
							case "sparql.php":
								?>
								<h3 style="color:#fff;">Ejemplo de consulta en SPARQL</h3>
								<h4 style="color:#fff;">SELECT * </br>WHERE { </br> ?s ?p ?o</br>}</br>LIMIT 10 </h4>
								<?php
							break;
							case "index2.php":
								
								if (is_localhost() == true){
									?>
									<h3>Ejemplos de consultas en SPARQL</h3><hr/>
									<h4>SELECT * WHERE { ?s ?p ?o } LIMIT 10 </h4><hr/>
									<h4>SELECT COUNT(*) WHERE { ?s ?p ?o } </h4><hr/>
									<h4>
									PREFIX foaf: &lt;http://xmlns.com/foaf/0.1/&gt;<br/>
									SELECT ?name<br/>
									FROM &lt;linked-friends:user&gt;<br/>
									WHERE { <br/>
									     ?id foaf:name "Andres" .<br/>
										 ?id foaf:familyName "Nacimiento" .<br/>
										 ?id foaf:knows ?name .
									}
 
									</h4><hr/>
									<?php
								}else{
									?>
									<h3>Ejemplo de consulta en SPARQL</h3>
									<h4>SELECT * WHERE { ?s ?p ?o } LIMIT 10 </h4>
									<hr/>
									<h4>PREFIX dcterms: &lt;http://purl.org/dc/terms/&gt; <br/>
									    PREFIX rdfs: &lt;http://www.w3.org/2000/01/rdf-schema#&gt; <br/>
										PREFIX dbp: &lt;http://dbpedia.org/ontology/&gt; <br/>
										SELECT ?musico ?nombreMusico ?fechaNacimiento ?fechaFallecimiento <br/>
										WHERE{ 
										      ?musico dcterms:subject &lt;http://dbpedia.org/resource/Category:Spanish_musicians&gt;;
											  rdfs:label ?nombreMusico ; 
											  dbp:birthDate ?fechaNacimiento ; 
											  dbp:deathDate ?fechaFallecimiento . <br/>
										FILTER (LANG(?nombreMusico) = "es") } </h4>
									<?php
								}

							break;
							case "xquery.php":
								?>
								<h3>Ejemplo de consulta en XQuery</h3>
								<h4>LET $doc := .<br>FOR <em>$v</em> IN <em>$doc//video,<br> $va in $v/actorRef,<br> $a in $doc//actors/actor </em><br>WHERE <em>ends-with($a, 'Lisa')</em><br>AND <em>$va</em> EQ <em>$a/@id</em><br>RETURN <em>$v/title</em></h4>
								<?php
							break; 
						}
					?>
				</div>
			</div>
		</div>
		
	
		<div id="footer">
			<a href="http://virtuoso.openlinksw.com/" target="blank_"><img src="http://upload.wikimedia.org/wikipedia/en/3/3f/Virtuoso-logo-sm.png"/></a>
			<a href="http://linkeddata.org/" target="blank_"><img src="http://www.poolparty.biz/wp-content/uploads/2013/03/linked_open_data.jpg"/></a>
		</div>
	</div>
	
</body>