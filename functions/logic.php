<?php
	/**
	 * The form logic file 
	 *
	 * Harrison DeStefano
	 * harrison.destefano@gmail.com
	 *
	 * This is the logic template file that  displays the form.
	 * Without this file all would be lost.
	 *
	 */
	 
	 associateFormData();
	 defaultsOverride();
   	 instantiateLexicon();
   	 engenderedPhrase();
	 engenderedFormat();
	 /* 
	  *	Associative arrays are arrays that use named keys that you assign to them. Any data provided by the HTTP 
	  *	POST aka user is an associative array.
	  */
	 class argument
	 {
		static $_FORMDATA = null; #associative array of variables passed to the current script via the HTTP POST	 
	 }
	 
	 // used to remember var’s value across multiple functions
	 class globals 
	 {	
		static $debug = 'on';
		static $dictionary = null;
		static $phrase = array();
		static $_CHR2NUM_FEW= 4;
		static $_CHR2NUM_MORE= 6;
		static $_CHR2NUM_LOADS= 9;
		static $_CHR2NUM_OFF = 1;
		static $_CHR2NUM_ON = 0;
		
	 }
	 
	 /* 
	  *	Associative arrays are arrays that use named keys that you assign to them. Any data provided by the HTTP 
	  *	POST aka user is an associative array so our paramaters need to be constructed in a same fashion.
	  */
	 class paramater
	 {	 
		 static $_DEFAULTS = array(
		 	'numberOfWords' => 'few', 	       #arguments are "few", "more", or "loads"
		 	'includeNumber'  => 'off',         #arguments are "on" or "off""
		 	'specialCharacters'  => 'off',     #arguments are "few", "more", or "loads"
		 	'includeSpecialSymbol' => 'off',   #arguments are "on" or "off"
		 	'capitalizeFirstLetter' => 'off'); #arguments are "on" or "off"	
	 }
	 
	 /*
	  *	Compares the values of two arrays ($_FORMDATA && $_DEFAULTS), and returns the matches. Any match found in
   	  *	defaults will be replaced with value from HTTP POST. All string based values are replaced with the proper
   	  * int.
   	  */
   	function defaultsOverride()
   	{
		foreach(argument::$_FORMDATA as $x => $x_value) #Iterate over the default array and on the inner loop evalute argument array.	
	 	{
			foreach(paramater::$_DEFAULTS as $y => $y_value) #Iterate of the argument array 
			{
				if($x === $y && $x_value != $y_value){
					 paramater::$_DEFAULTS[$y] = $x_value; #replace default value with argument value
				}
			}
		}
		// Iterate over the defaults array replacing chr with int 
		foreach(paramater::$_DEFAULTS as $y => $y_value) #Iterate of the argument array 
		{
			switch($y_value){
				case 'few':
					paramater::$_DEFAULTS[$y] = globals::$_CHR2NUM_FEW; #replace default value with argument value
				break;
				case 'more':
					paramater::$_DEFAULTS[$y] = globals::$_CHR2NUM_MORE; #replace default value with argument value
				break;
				case 'loads':
					paramater::$_DEFAULTS[$y] = globals::$_CHR2NUM_LOADS; #replace default value with argument value
				break;
				case 'off':
					paramater::$_DEFAULTS[$y] = globals::$_CHR2NUM_OFF; #replace default value with argument value
				break;
				case 'on':
					paramater::$_DEFAULTS[$y] = globals::$_CHR2NUM_ON; #replace default value with argument value
				break;
			}
		}
   	}
   	
   	/*
	 *	Store teh associative array of variables passed to script via HTTP POST as a static global.
   	 */
   	function associateFormData()
   	{
	   argument::$_FORMDATA = $_POST;
   	}
   	
   	/*
   	 *	Build the array of strings (engligh words) by reading the contents of a file (dictioanry) into a string. Once the file
   	 *	is read, convert the string into an array (explode) and store said array as global variable.
   	 */
   	function instantiateLexicon()
   	{
	   	
	   	globals::$dictionary = explode(',', file_get_contents( 'http://'. $_SERVER['HTTP_HOST'] . '/dictionary/a.txt')); #the preferred way to read the contents of a file into a string.
	   	
   	}
   	
   	/*
   	 *	Manifest pesudo-random collection of strings and store said phrase, according to arguments, as array. The collection is
   	 *	picked via libc generator as part ot PHP's built-in array_rand() function. The results are stored as global.
   	 */
   	function engenderedPhrase()
   	{
	   	
		$index = array_rand(globals::$dictionary, paramater::$_DEFAULTS['numberOfWords']); #picks one or more random entries out of an array, and returns the key (or keys) of the random entries.
	 	  
	 	foreach($index as $index) #iterate over psudo-random numbers and store dictioanry text string 
	 	{
			array_push(globals::$phrase, globals::$dictionary[$index]);
	 	}
	 	  
   	}
   	
   	// add all configuration options, loop defualts array modifing phrase array to reflect.
   	function engenderedFormat()
   	{
	   	foreach(paramater::$_DEFAULTS as $s => $s_value)
	   	{
		   	switch($s) #manipulate the phrase array
		   	{
		   		case 'includeNumber':
		   			$lastItem = end(globals::$phrase);# pointer to last item in array
		   			globals::$phrase[sizeof(globals::$phrase) - 1] = $lastItem . rand(1, 9);
		   		break;
		   	}
		   	// debuger( json_encode(globals::$phrase) );
	   	}
	
	   	debuger( json_encode(globals::$phrase) );
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