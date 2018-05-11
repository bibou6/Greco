(function($) {
	$('#sortable').sortable({
		stop : function(e, ui) {
			console.log($.map($(this).find('li'), function(el) {
				return $(el).attr('id') + ' = ' + $(el).index();
			}));
		}
	});
})(jQuery);