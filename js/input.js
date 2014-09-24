(function($){
	"use strict";
    
    	$.reyBackground = $.reyBackground || {};
		
    	$(document).ready(function () {
    	     $.reyBackground.init();
    	});

    $.reyBackground.init = function(){

			$('.clearfix .rey-color').wpColorPicker();
		

    };

})(jQuery);