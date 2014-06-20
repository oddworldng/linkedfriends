<html>
<head>
	<link href='http://fonts.googleapis.com/css?family=Ruluko' rel='stylesheet' type='text/css'> <!-- H1 -->
	<link href='http://fonts.googleapis.com/css?family=Shadows+Into+Light' rel='stylesheet' type='text/css'> <!-- SPAN -->
	<link href='http://fonts.googleapis.com/css?family=Bad+Script' rel='stylesheet' type='text/css'> <!-- TITULO: Linked Friends -->
	<link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'> <!-- H3 -->
	
	<link type="text/css" rel="stylesheet" href="styles.css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
	<link rel="shortcut icon" href="http://www.ehas.org/wp-content/uploads/2012/02/favicon.ico-200x189.png">
	<title>Virtuoso :: Linked Friends</title>
</head>
<!-- <body> -->
<?php 
	$file = basename($_SERVER['PHP_SELF']); 
	if ($file == "friend-graph.php"){
		?> <body style="background-image: url('wood.jpg'); background-size:100% 100%; background-repeat:no-repeat;"> 
		<div class="headertext2">
			<h1> Linked Friends </h1>
		</div>
		<?php
	}else{
		?> <body style="background-image: url('amigos.jpg'); background-size:100% 100%; background-repeat:no-repeat; background-position:fixed;">
		<div class="headertext">
			<h1> Linked Friends </h1>
		</div>
		<?php
	}
	
?>

	
	
	<?php
		
		function is_localhost() {
			$whitelist = array( '127.0.0.1', '::1' );
			if( in_array( $_SERVER['REMOTE_ADDR'], $whitelist) )
				return true;
		}
	?>

	<div id="wrapper">
		<div id="header">
			<!-- <img src="header2.png"/> -->
		</div>
		
		<div id="container">
		
			<!-- COLUMNA IZQUIERDA -->
			<div id="left">
			</div>
			
			<!-- CONTENIDO CENTRAL (BEGIN)-->
			<div id="content">