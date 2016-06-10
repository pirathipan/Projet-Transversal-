'use strict';
$(function(){

	var socket = io.connect('http://localhost:8000');
	var convId = window.location.pathname.replace('/messages/', '');
	var sendButton = $('#send');
	socket.on('message ' + convId, function(message) {
		$('.messages').prepend('<p>' + message + '<p>');
	});
	sendButton.click(function(){
		console.log('click');
		var message = $('#message').val();
		var infos = {
            conversationId : convId,
            content : message,
            userId : 2
		}
		socket.emit('message', infos);

	})

});