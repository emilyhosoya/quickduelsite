/*----------------------------------------------------*/
/*	Template Animations
/*----------------------------------------------------*/
	
$(document).ready(function(){
	
		"use strict";
	
		$('#intro').waypoint(function() {		
            setTimeout(function(){$('#intro_description').addClass('animated fadeInLeft')},200);			
            setTimeout(function(){$('#intro_image').addClass('animated fadeInRight')},200);
        }, { offset: '65%' });
	
		$('#features').waypoint(function() {		
            setTimeout(function(){$('#feature-1').addClass('animated fadeInRight')},400);			
            setTimeout(function(){$('#feature-2').addClass('animated fadeInRight')},600);
            setTimeout(function(){$('#feature-3').addClass('animated fadeInRight')},800);
			setTimeout(function(){$('#feature-4').addClass('animated fadeInRight')},1000);
			setTimeout(function(){$('#feature-5').addClass('animated fadeInRight')},1200);
			setTimeout(function(){$('#feat_image').addClass('animated fadeInLeft')},1400);
        }, { offset: '65%' });
		
		$('#feature_1').waypoint(function() {
            setTimeout(function(){$('.banner_content_1').addClass('animated fadeInRight')},400);
            setTimeout(function(){$('#features_image_1').addClass('animated fadeInLeft')},400);
        }, { offset: '75%' });

		$('#feature_2').waypoint(function() {
            setTimeout(function(){$('#features_image_2').addClass('animated fadeInRight')},400);
            setTimeout(function(){$('.banner_content_2').addClass('animated fadeInLeft')},400);
        }, { offset: '75%' });
		
		$('#v_banner_video').waypoint(function() {
			setTimeout(function(){$('#v_banner_video').addClass('animated fadeInDown')},400);
            setTimeout(function(){$('.video-description').addClass('animated fadeInUp')},400);
        }, { offset: '90%' });
		
		$('#newsletter').waypoint(function() {
            setTimeout(function(){$('#newsletter_form').addClass('animated fadeInRight')},400);
            setTimeout(function(){$('#newsletter_title').addClass('animated fadeInLeft')},400);
		}, { offset: '90%' });
		
		$('#call_to_action').waypoint(function() {
            setTimeout(function(){$('.stores').addClass('animated fadeInUp')},400);
		}, { offset: '90%' });
		
		$('#footer').waypoint(function() {
            setTimeout(function(){$('#footer_copy').addClass('animated fadeInUp')},400);
            setTimeout(function(){$('#footer_icons').addClass('animated fadeInDown')},400);
		}, { offset: '94%' });
		
		
});