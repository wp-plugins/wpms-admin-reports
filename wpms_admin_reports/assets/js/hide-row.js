jQuery(function($) {
	//Since WordPress currently won't let me remvoe users from the user list tables with a good filter this is a work around to just hide the entire row from diplaying... 
	//In short this is a crappy front-end hack
	$('.hide-user').closest('tr').remove();
});