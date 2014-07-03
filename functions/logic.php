<?php
/**
	 * The form template file 
	 *
	 * Harrison DeStefano
	 * harrison.destefano@gmail.com
	 *
	 * This is the logic template file that  displays the form.
	 * Without this file all would be lost.
	 *
	 */
	 
	 // associative array of variables passed to the current script via the HTTP POST
	 $_FORMDATA = $_POST;
   	
	 // visible throught 
	 class globals 
	 {
		
		static $debug = 'off';
		static $dictionary = null;
		static $phrase = array();
	 }
	 
	 // default setting, arguments override defaults
	 class defaults
	 {
		 
		 static $words = 6;
		 
	 }
 
   	debuger($_FORMDATA);
   	instantiateLexicon();
   	engenderedPhrase();
   	
   	// read in alphabetical dictioanry files, explode, store as an array
   	function instantiateLexicon()
   	{
	   	
	   	// the preferred way to read the contents of a file into a string.
	   	globals::$dictionary = explode(',', file_get_contents( 'http://'. $_SERVER['HTTP_HOST'] . '/dictionary/a.txt'));
	   	
   	}
   	
   	// manifest pesudo-random phrase and store said phrase
   	function engenderedPhrase(){
	   	
	 	  //Picks one or more random entries out of an array, and returns the key (or keys) of the random entries.
	 	  $index = array_rand(globals::$dictionary, defaults::$words);
	 	  
	 	  // iterate over psudo-random numbers and store dictioanry text string 
	 	  foreach($index as $index)
	 	  {
		 	  array_push(globals::$phrase, globals::$dictionary[$index]);
	 	  }
	 	  
	 	 print_r(  json_encode(globals::$phrase) );
   	}
   	
   	// devloper tools used to log out 	
	function debuger($returnThis)
	{
		// debug, if required
		if(globals::$debug == 'on')
		{
			//R eport Errors, Warnings, and Notices
			error_reporting(E_ALL);       
			
			//Display errors on page (instead of a log file)
			ini_set('display_errors', 1); 
			
			// print the post data back to the screen, you can alos look at the devloper tools network pane.
			print_r($returnThis);
		}
	}
   	
   	
?>		