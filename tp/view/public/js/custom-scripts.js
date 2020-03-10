/*------------------------------------------------------
    Author : www.webthemez.com
    License: Commons Attribution 3.0
    http://creativecommons.org/licenses/by/3.0/
---------------------------------------------------------  */

(function ($) {
	sidenav_width = 220;
    "use strict";
    
	var mainApp = {

        initFunction: function () {
          
			$('#main-menu').metisMenu();
			
            $(window).bind("load resize", function () {
                if ($(this).width() < 768) {
                    $('div.sidebar-collapse').addClass('collapse')
                } else {
                    $('div.sidebar-collapse').removeClass('collapse')
                }
            });
		
        },

        
		initialization: function () {
            mainApp.initFunction();
        }

    }
    // Initializing ///

    $(document).ready(function () {
	//$(".dropdown-button").dropdown();
	$("#sideNav").click(function(){
		if($(this).hasClass('closed')){
			$('.navbar-side').animate({left: '0px'});
			$(this).removeClass('closed');
			$('#page-wrapper').animate({'margin-left' : sidenav_width + 'px'});	
		}
		else{
			$(this).addClass('closed');
			$('.navbar-side').animate({left: 0});
			$('#page-wrapper').animate({'margin-left' : 40}); 
		}
	});
	mainApp.initFunction(); 
});

	

	var window_height = $(window).height();
	var p = $('#page-inner').offset().top;
	$('#page-inner').css('min-height', window_height - p);
	$('#page-inner').css('max-height',window_height - p);
	$('.navbar-side').css('min-height', window_height - 0);
	
	$('.navbar-side').hover(function(){
		$('.navbar-side').css('z-index',30);
	},function(){
		$('.navbar-side').css('z-index',2);
	});

	$(window).ajaxStart(function(){top.$('#ajax_pop').show();}).ajaxStop(function(){top.$('#ajax_pop').hide()});



	//$("#leftmenu").niceScroll({
		//autohidemode:"scroll"
	//});

	


}(jQuery));

