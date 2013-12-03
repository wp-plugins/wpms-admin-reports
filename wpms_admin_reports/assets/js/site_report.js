jQuery(function($) {
	var progress = 0;
	$('#update_area').hide();
	$("#update").button().click(function(event){
		$("#update").unbind('click');
		$('#progress_bar').progressbar({value: progress});
		$('#progress_status').html("Checking status of sites...");
		$('#update_area').slideToggle();
		
		//alert(ajax_object.site_list);
		var site_list = JSON.parse(ajax_object.site_list);
		//alert(site_list[0]);
		var site_count = site_list.length;
		//alert(site_count);
		var progress_increment = 100 / (site_count + 1 );
		//alert(ajax_object.ajax_nonce);
		
		var str_status = '{';
		var sites_updated = 0;
		for (var i = 0; i < site_count; i++) {
			
			var siteName = '{"site_name" : "' + site_list[i] + '"}';
			//alert(siteName);
			var json_sitename = JSON.parse(siteName);
			jQuery.getJSON(
				ajax_object.ajax_url,
				{ 
					action :	'site_check',
					nonce :		ajax_object.ajax_nonce,
					json_data : json_sitename
				},
				function(data) {
					sites_updated += 1;
					$('#progress_status').html(data.message + " " + sites_updated + " - " + site_count + " sites updated");
					str_status += '"' + data.site_name + '" : "' + data.status + '"';
					progress += progress_increment;
					$( "#progress_bar" ).progressbar( "option", "value", progress );
					
					//alert(sites_udpated + '/' + site_count + " sites updated");
					if( sites_updated == site_count ){
						str_status += "}";
						//alert(str_status);
						jsonStatus = JSON.parse(str_status);
						jQuery.post(
							ajax_object.ajax_url, 
							{
								action:		'update_site_status',
								nonce :		ajax_object.ajax_nonce,
								json_data: 	jsonStatus
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