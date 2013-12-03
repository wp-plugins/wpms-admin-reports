jQuery(function($) {	
	var progress = 0;
	$('#update_area').hide();
	$("#update").button().click(function(event){
		
		$('#progress_bar').progressbar({value: progress});
		$('#progress_status').html("Starting Update Process...");
		$('#update_area').slideToggle();
		
		var plugin_list = JSON.parse(ajax_object.plugin_list);
		var plugin_count = plugin_list.length;
		var progress_increment = 100 / (plugin_count + 2);
		
		//start AJAX update process
		jQuery.post(
			ajax_object.ajax_url, 
			{
				action:	'update_plugin_list', 
				nonce :	ajax_object.ajax_nonce,
				json_data: plugin_list
			}, 
			function(response){
				$('#progress_status').html(response);
				progress += progress_increment;
				$( "#progress_bar" ).progressbar( "option", "value", progress );
			}
		);
		
		var str_status = '{';
		var plugins_updated = 0;
		for (var i = 0; i < plugin_count; i++) {
			var pluginName = '{"plugin_name" : "' + plugin_list[i] + '"}';
			var json_pluginName = JSON.parse(pluginName);
			jQuery.getJSON(
				ajax_object.ajax_url,
				{ 
					action: 'update_plugin_status',
					nonce :	ajax_object.ajax_nonce,
					json_data: json_pluginName
				},
				function(data) {
					plugins_updated += 1;
					$('#progress_status').html(data.message + " " + plugins_updated + " - " + plugin_count + " plugins updated");
					str_status += '"' + data.file + '" : ' + data.status;
					progress += progress_increment;
					$( "#progress_bar" ).progressbar( "option", "value", progress );
					
					//alert(plugins_udpated + '/' + plugin_count + " plugins updated");
					if( plugins_updated == plugin_count ){
						str_status += "}";
						jsonStatus = JSON.parse(str_status);
						jQuery.post(
							ajax_object.ajax_url, 
							{
								action: 'update_derelict_status',
								nonce :	ajax_object.ajax_nonce,
								json_data: jsonStatus
							}, 
							function(response){
								$('#progress_status').html(response);
								progress += progress_increment;
								$( "#progress_bar" ).progressbar( "option", "value", progress );
								location.reload();
							}
						);
					}else{
						str_status += ",";
					}
				}
			);
		}
		
	});
});