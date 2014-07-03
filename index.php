<?php
	/**
	 * The main template file 
	 *
	 * Harrison DeStefano
	 * harrison.destefano@gmail.com
	 *
	 * Create a unique password that is easy to recall from memory but difficult to guess.  
	 *
	 * This is the main template file that calls all the other files.
	 * Without this file all would be lost.
	 *
	 */
?>
<!DOCTYPE html>
<html>
	<head>
	    <title>XKCD Password Generator</title>
		<link href="css/normalize.3.0.1.css" media="screen" rel="stylesheet" type="text/css">
		<link href="css/styles.css" media="screen" rel="stylesheet" type="text/css">
		<script src="js/vendor/jQuery-10.1.2.js" type="text/javascript"></script>
		<script src="js/client.js" type="text/javascript"></script>
	</head>
	<body>
		<section id="pageWrapper">
			<?php
				 require('functions/logic.php');
				 require('templates/form.php');
				 require('templates/footer.php');
			?>