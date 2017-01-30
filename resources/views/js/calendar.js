(function (window, $, undefined) {
		
	var Calendar = function (opt) {
		$.extend(this, opt);
//		setTimeout(function(){})
		this.init();
	};
	Calendar.prototype.init = function () {
		$('[data-toggle="popover"]').popover({
			container: 'body',
			html: true,
			placement: 'auto right'
		}).on("click",function(e){
			$('[data-toggle="popover"]').not(this).popover('hide');
			e.preventDefault();
		});
	};
	$(document).ready(function () {
		new Calendar();
	})
		
})(window, jQuery);