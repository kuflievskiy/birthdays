(function (window, $, undefined) {
		
	var Calendar = function (opt) {
		$.extend(this, opt);
		this.init();
	};
	Calendar.prototype.init = function () {

	};
	$(document).ready(function () {
		new Calendar();
	})
		
})(window, jQuery);