(function($){
	$(document).ready(function(){
		$('.products .product > a > img').tooltipster({
			content: 'Loading...',
			contentAsHTML: true,
			maxWidth:500,
			functionBefore: function(origin, continueTooltip) {

				// we'll make this function asynchronous and allow the tooltip to go ahead and show the loading notification while fetching our data
				continueTooltip();

				// next, we want to check if our data has already been cached
				if (origin.data('ajax') !== 'cached') {
					$.ajax({
						type: 'POST',
						data:{
							action: 'get_product_description',
							productId: $(this).parent().next().val()
						},
						url: custom_values.ajaxurl,
						success: function(data) {
							
							// update our tooltip content with our returned data and cache it
							origin.tooltipster('content', data.description).data('ajax', 'cached');
						}
					});
				}
			}
		});
	});
	
})(jQuery);