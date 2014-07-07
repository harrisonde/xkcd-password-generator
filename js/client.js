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
		XKCD.assignevent.label();
		XKCD.github.respositiores = [{
			repo:'xkcd-password-generator',
			user:'harrisonde'
		}]
	XKCD.github.pull(XKCD.github.respositiores);
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
				XKCD.assignevent.slide();
				
			});
		},
		label: function(){
			$('[type="radio"]').on('click', function(){
				var parent = $(this).parent();
				var rdo = $(this);
				if(parent.hasClass('selected')){
					parent.removeClass('selected');
					rdo.attr('checked', false);
				}else{
					parent.addClass('selected');
					parent.siblings().removeClass('selected');
				}
			});
		},
		slide: function(){
			$('body,html,document').animate({ scrollTop: 0 }, 1000, 'swing');
			$('input#password').focus();
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
			var formdata = $('form').not('input#password').serialize();
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
							$('input#password').val(response);
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
							$('input#password').val(response);
							console.log(response);
						},
						error:function (xhr, ajaxOptions, thrownError){   
					       return thrownError;
					    } 
					}
				break;
			}
			jQuery.ajax(ajaxObject);	
		}
	},
	/*
	*	Method uses github api to pull information from user defined repos at runtime. The
	* 	method expects an array of repos.
	*/
	github:{
		// add data to page
		add: function(json){
		 	var pustData = json.pushed_at.split('T')[0];
		 	var forkData = json.forks_count;
			var templateA = pustData+'<span>Pushed</span>';
			var templateB = forkData+'<span>Forked</span>';
			// add to DOM
			$('#gitHistory').append(templateA);
			$('#gitFork').append(templateB);
			//window.git = json;	
		},
		// request data from github and retun as json
		pull: function(repositories){
			var i = 0;
			for(repo in repositories){
				junk = repositories;
				var repo = repositories[i].repo;
				var user = repositories[i].user;
				// make ajax request for github data
				$.ajax({
					url: 'https://api.github.com/repos/'+user+'/'+repo,
					dataType: 'json',
					error: function(textStatus, errorThrown, jqXHR ){ 
						return 'error pulling repository';						
					},
					type: "GET",
					success: function(json){
						XKCD.github.add(json);
					}
				});	
				i++;
			}
		},
	}
}