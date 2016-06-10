'use strict';
$(function() {
  
	var loginForm = $('#loginForm');

	loginForm.submit(function(){

		$.ajax({
			url : '/user/connect',
			method : 'POST',
			data : $(this).serialize(),
			success : function(data){

				console.log(data);

			}
		})

		return false;

	});

});