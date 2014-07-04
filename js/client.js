/*
*	xkcd password generator
*	@package xkcd password generator
*	Description: Create a unique password that is easy to recall from memory but difficult to guess.  
*	Version: 1.00
*	Author: Harrison DeStefano
*	Author URI: http://www.harrisondestefano.com
*/

XKCD = {
	/*
	* 	This is the fist process started during the inital of the xkcd password generator at
	*	runtime. This process must be started when HTML-Document has completed loading ( e.g.,
	*	document ready state).
	*/
	init:function(){
		XKCD.communicate.post();	
		XKCD.assignevent.button();
	},
	/*
	*	This method allows JavaScript to react to HTML events - JavaScript is executed when a
	*	particular event orrucrs. Events are bound to specifc event handlers at element level.		*
	*/
	assignevent: {
		button: function(){
			var buttonGenerate = $('#generate');
			buttonGenerate.on('click', function(){
				XKCD.communicate.post();	
			});
		}	
	},
	/* 
	*	Series of methods to communicate with a server in the background, without interfering 	
	*	with the current page state. Ajax ( Asynchronous JavaScript and XML ) is leveraged to 
	*   asynchronously send and retrieve data from the server. This method will a. make client
	*	-side request for a data without any arguments or b. make client-side request for data
	*	with arguments. The server logic.php will evaluate and return appropriate data.
	*/
	communicate: {
		get: function(){
			XKCD.communicate.send('get');
		},
		post: function(){
			var formdata = $('form').serialize();
			XKCD.communicate.send('post', formdata);	
		},
		send: function(method, formdata){
			var ajaxObject, fileLocation;
			fileLocation = window.location.origin+'/functions/logic.php';
			switch(method){
				case 'get':
					ajaxObject = {
						type: 'post',
						url: fileLocation, 				
						success: function(response) {
							console.log(response);
							var json = $.parseJSON(response);
							$('#password').text(json);
						},
						error:function (xhr, ajaxOptions, thrownError){   
					       return thrownError;
					    } 
					}
				break;
				case 'post':
					ajaxObject = {
						type: 'post',
						url: fileLocation, 				
						data: formdata,
						success: function(response) {
							console.log(response);
							var json = $.parseJSON(response);
							$('#password').text(json);
						},
						error:function (xhr, ajaxOptions, thrownError){   
					       return thrownError;
					    } 
					}
				break;
			}
			jQuery.ajax(ajaxObject);	
		}
	}
}