<?php
	/**
	 *	xkcd password generator
	 *	@package xkcd password generator
	 *	Description: Create a unique password that is easy to recall from memory but difficult to guess.  
	 *
	 * Harrison DeStefano
	 * harrison.destefano@gmail.com 
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
		<script type="text/javascript">
			/*
			 *	Client side JavaScript for use with our xkcd password generator. The init()
			 * 	method must be executed when the DOM HTML completes loading.
			 */
			jQuery(document).ready( function(){
				// do not clobber 
				XKCD.init();
			});
		</script>
	</head>
	<body>
		<section id="pageWrapper">
			<?php
				 require('templates/form.php');
				 require('templates/footer.php');
			?>