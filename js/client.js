/*
*	xkcd password generator
*	@package xkcd password generator
*	Description: Create a unique password that is easy to recall from memory but difficult to guess.  
*	Version: 1.00
*	Author: Harrison DeStefano
*	Author URI: http://www.harrisondestefano.com
*/

XKCD = {
	// let's get this party started!
	init:function(){
		XKCD.get();	
	},	
	get: function(){
		jQuery.ajax({
			type: 'post',
			url: window.location.origin+'/functions/logic.php', 				
			success: function(endpointResponse) {
				var json = jQuery.parseJSON(endpointResponse);
				$('#password').text(json);
			},
			error:function (xhr, ajaxOptions, thrownError){   
		       return thrownError;
		    } 
		});	
	},
	// query loqic for random password by posting form data
	post: function(formdata){
		jQuery.ajax({
			type: 'post',
			url: window.location.origin+'/functions/logic.php', 				
			data: obj,
			success: function(endpointResponse) {
				var json = jQuery.parseJSON(endpointResponse);
				jQuery('.sobrietyCalculator_TotalMessage').text(json.message_text);
			},
			error:function (xhr, ajaxOptions, thrownError){   
		       return thrownError;
		    } 
		});
	}

}
// load
jQuery(document).ready( function(){
	// do not clobber 
	XKCD.init();
});