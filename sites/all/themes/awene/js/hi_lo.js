$(document).ready(function() {
	$('#hi-lo-switch').hover(function(){
		$('#hi-switch, #lo-switch').slideDown('700');
	},
	function() {
		$('#hi-switch, #lo-switch').slideUp('700');
	});
});