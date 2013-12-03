jQuery(function($) {
	
	$('.wpmsar-hidden').hide();
	
	$('.wpmsar-show-more').click( function(){
		var thislink = $(this);
		$(this).parent().parent().find('.wpmsar-hidden').slideToggle("slow", function(){
			if($(this).is(':hidden')){
				thislink.html('Show');
			}else{
				thislink.html('Hide');
			}
		});
	});
	
	$('#wpmsar_report_table').tablesorter().tablesorterPager({
		container:		$('.pager'),
		size:			20,
		positionFixed: 	false,
		cssNext: 		'.next-page',
		cssPrev: 		'.prev-page',
		cssFirst: 		'.first-page',
		cssLast: 		'.last-page',
		cssPageDisplay: '.pagedisplay',
		cssPageSize: 	'.pagesize',
		cssDisabled: 	'disabled'
	});
});