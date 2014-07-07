<?php
	/**
	 *	xkcd password generator
	 *	@package xkcd password generator
	 *	Description: Create a unique password that is easy to recall from memory but difficult to guess.  
	 *
	 * Harrison DeStefano
	 * harrison.destefano@gmail.com
	 *
	 * This is the logic template file that converts form data and returns a string.
	 * Without this file all would be lost.
	 *
	 */
	 
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
		static $debug = 'off';
		static $dictionary = null;
		static $phrase = array();
		static $_CHR2NUM_FEW= 4;
		static $_CHR2NUM_MORE= 6;
		static $_CHR2NUM_LOADS= 9;
		static $_CHR2NUM_OFF = 0; #set this to 0 after dev
		static $_CHR2NUM_ON = 1;
		
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
	 
	 init();
	 /*
	 * 	Confirm if we need to build a dictioanry or use the built-in dictionary. The function will determine whether a 	
	 *	dictionaryUrl is considered to be empty (false). The dictionaryUrl is removed from the defaults array after
	 *	this function to keep things super clean.
	 */
	 function init()
	 {
	 	associateFormData();
     	switch(post_set('dictionaryUrl'))
     	{
			case true: #dictionaryUrl is not empty
				createLexicon();
				defaultsOverride();
				engenderedPhrase();
			 	engenderedFormat();
			break;
			case false: # dictionaryUrl is empty
			 	defaultsOverride();
			 	instantiateLexicon();
			 	engenderedPhrase();
			 	engenderedFormat();
			break;
		 }
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
	 *	Store the associative array of variables passed to script via HTTP POST as a static global.
   	 */
   	function associateFormData()
   	{
	   argument::$_FORMDATA = $_POST;
   	}
   	
   	/*
   	* 	Create new dictionary items by scraping raw HTML from a URL, tags are removed from said HTML, and manipulated
   	*	into a array. If URL is not found for has an issues returning data and error is thrown.
   	*/
   	function createLexicon(){
	   	try
	   	{
			$html = file_get_contents(argument::$_FORMDATA['dictionaryUrl']); # returns html in a string		
			if(!$html)
			{
				 throw new Exception('url is not valid.');
			} 
			else
			{
				$dom = new DOMDocument(); # XML documents through the DOM API with PHP 5.
				$dom->loadHTML($html);#Load HTML from a string 
				#DOMDocument throws warnings all over the place when it does. enjoy!
				$body = $dom->getElementsByTagName('body');
				foreach ($body as $body) {
					# remove all special chars from body and replace
					$clean = preg_replace('/[^A-Za-z0-9\-]/', ',', $body->nodeValue);
					#turn it into an array
					$clean = explode(',', $clean); 
					$i = 0;
					foreach($clean as &$clean_v)
					{
						if( strlen($clean_v) == 0)
						{
							unset($clean[$i]); #remove empty values
						} 
						else
						{
							$clean_v = strtolower($clean_v); #convert string to lower
						}
						$i++;
					}
					globals::$dictionary = $clean;
				}		
			}
	   	}
	   	catch(Exception $e)
	   	{
		   echo 'Caught exception: ',  $e->getMessage(), "\n";
	   	}
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
   	 *	picked via libc generator as part ot PHP's built-in array_rand() function. The results are stored as global. Option
   	 */
   	function engenderedPhrase()
   	{
	   	
		$index = array_rand(globals::$dictionary, paramater::$_DEFAULTS['numberOfWords']); #picks one or more random entries out of an array, and returns the key (or keys) of the random entries.
	 	  
	 	foreach($index as $index) #iterate over psudo-random numbers and store dictioanry text string 
	 	{
			array_push(globals::$phrase, globals::$dictionary[$index]);
	 	}
	 	  
   	}
   	
   	/*
   	*	Format the phrase array to meet the confguration options found in the configuration array. Read in the default value(s) 
   	*	checking each default with a switch statment and manipulate the phrase array value(s). 
   	*/
   	function engenderedFormat()
   	{
   		
	   	foreach(paramater::$_DEFAULTS as $s => $s_value) 
	   	{
	   		$lastItem = end(globals::$phrase);# pointer to last item in array, 
		   	
		   	switch($s) #manipulate the phrase array
		   	{
		   		case 'includeNumber':
		   			if($s_value == 1)
		   			{
		   				globals::$phrase[sizeof(globals::$phrase) - 1] = $lastItem . rand(1, 9);
		   			}	
		   		break;
		   		case 'includeSpecialSymbol':
		   			if($s_value == 1)
		   			{
			   			$count = 0;
			   			$pharseLength = sizeof(globals::$phrase);
			   			foreach(globals::$phrase as &$p_value) # pointer to array value, allows direct modification to said value.
			   			{
				   			if($count + 1 != $pharseLength) # do not add special char to list item
				   			{
					   			$p_value = $p_value . '-';
					   			$count++;	
				   			} 			   			
			   			}
			   		}	
		   		break;
		   		case 'specialCharacters':
		   			$specialChar = makeRandomChar($s_value);
		   			print_r($specialChar);
		   			globals::$phrase[sizeof(globals::$phrase) - 1] = $lastItem . $specialChar;
		   		break;
		   		case 'capitalizeFirstLetter':
		   			if($s_value == 1)
		   			{
			   			foreach(globals::$phrase as &$p_value) # loop the array, and modify the first character
			   			{
				   			$binary = decbin(ord($p_value)); # binary of the first character value.	 
				   			$bit = $binary[2]; # the 5th bit denotes upper or lower case
				   			if($bit !== 0) # do not convert if the bit is not 0 or off
				   			{
					   			$binary[1] = 0; #set 5th bit
				   			}
				   			$p_value[0] = chr(bindec($binary)); # binary converted char value
			   			}
		   			}
		   		break;
		   	}
	   	}
	   	if(paramater::$_DEFAULTS['includeSpecialSymbol'] === 1)
	   	{
		   	echo implode('', globals::$phrase);
	   	}
	   	else
	   	{
		   	echo implode(' ', globals::$phrase); 
	   	}   
   	}

   	/*
   	 * Get a randomn char (symbol) by providing optional number of [chars] to return. If no argument provided, one (1) char
   	 *	will be returned by the function. 
   	 */
   	function makeRandomChar($charsBack)
   	{
	   	$tempStore = array(); # an array to hold all requested chars
	   
	   	for($k=0; $k < $charsBack; $k++)
	   	{
			$specialChar = array('~','!','@','#','$','%','^','&','*','(',')','+','=');
		   	array_push($tempStore, $specialChar[array_rand($specialChar)] ); #picks one or more entries entries out of an array, and returns the key (or keys) of the random entries, key is passed and value is captured.
	   	}
		   	
	   	return implode('',$tempStore); #join values with no space 
   	}
   	
   	/*
   	*	Determine if a POST variable is set, return true or false as string.
   	*/
   	function post_set($variableName)
   	{ 
   		
	   	$bool = (integer) strlen(argument::$_FORMDATA[$variableName]);
	   	
	   	if($bool > 0){
		   	$bool = true;
	   	} else{
		   	$bool = false;
	   	}	   
	    return $bool;  	
   	}
   	
?>		