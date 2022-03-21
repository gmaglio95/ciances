/**
 * File custom.js
 *
 * Sensei S2 jQuery scripts
 *
 * Contains jQuery scripts for sticky header, animation on scroll and menù mobile.
 *
 * @package Sensei S2
 * @version 2.2.5
 */

jQuery.noConflict();
jQuery(document).ready(function() {
  jQuery('.navbar').click(function() {
    jQuery('.nav').toggleClass('wide');
  });

  jQuery('.fade').addClass("hidden").viewportChecker({
    classToAdd: 'visible animated fadeInUp',
    offset: 100
  });

  jQuery(window).scroll(function(){
  	if (jQuery(window).scrollTop() > 0) {
  		jQuery('.header').addClass('sticky-menu');
  		jQuery('.top').addClass('show');
  	} else {
  		jQuery('.header').removeClass('sticky-menu');
  		jQuery('.top').removeClass('show');
  	}
  });
});
