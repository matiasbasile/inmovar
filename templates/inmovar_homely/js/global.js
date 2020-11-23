jQuery(document).ready(function($) {

"use strict";

	/***************************************************************************/
	//MAIN MENU SUB MENU TOGGLE
	/***************************************************************************/
	$('.nav.navbar-nav > li.menu-item-has-children > a').on('click', function(event){
		event.preventDefault();
		$(this).parent().find('.sub-menu').toggle();
		$(this).parent().find('.sub-menu li .sub-menu').hide();
	});

	$('.nav.navbar-nav li .sub-menu li.menu-item-has-children > a ').on('click', function(event){
		event.preventDefault();
		$(this).parent().find('.sub-menu').toggle();
	});

	/***************************************************************************/
	//ACTIVATE CHOSEN 
	/***************************************************************************/
	$("select").chosen({disable_search_threshold: 11});

	/***************************************************************************/
	//ACCORDIONS
	/***************************************************************************/
	/*
	$(function() {
		if ($( "#accordion" ).length > 0) {
	    $( "#accordion" ).accordion({
	    	heightStyle: "content",
	    	closedSign: '<i class="fa fa-minus"></i>',
  			openedSign: '<i class="fa fa-plus"></i>'
	    });
	  }
	});
	*/
	
	/***************************************************************************/
	//SLICK SLIDER - SIMPLE SLIDER
	/***************************************************************************/
	$('.slider-ppal').owlCarousel({
		loop: true,
		nav: true,
		items: 1,
		autoplay: true,
	});

	/***************************************************************************/
	//SLICK SLIDER - FEATURED PROPERTIES
	/***************************************************************************/
	$('.destacados').owlCarousel({
		loop: true,
		nav: false,
		margin: 15,
		autoplay: true,
		responsive: {
			0: {
				items: 1
			},
			589: {
				items: 2,
			},
			767: {
				items: 3,
			},
			990: {
				items: 4
			}
		},
	});

	/***************************************************************************/
	//SLICK SLIDER - PROPERTY GALLERY 
	/***************************************************************************/
	$('.property-gallery-pager').owlCarousel({
		items: 5,
		autoplay: true,
		margin: 10,
		responsive: {
			0: {
				items: 2
			},
			589: {
				items: 3,
			},
			767: {
				items: 4,
			},
			990: {
				items: 5
			}
		},
	});

	/***************************************************************************/
	//FIXED HEADER
	/***************************************************************************/
	var navToggle = $('.header-default .navbar-toggle');
	var mainMenuWrap = $('.header-default .main-menu-wrap');
	
	if ($(window).scrollTop() > 140) { 
		navToggle.addClass('fixed'); 
		mainMenuWrap.addClass('fixed');
	}


	$(window).bind('scroll', function () {
		if ($(window).scrollTop() > 140) {
		    navToggle.addClass('fixed');
		    mainMenuWrap.addClass('fixed');
		} else {
		    navToggle.removeClass('fixed');
		    mainMenuWrap.removeClass('fixed');
		}
	});

	
	/***************************************************************************/
	//INITIALIZE BLOG CREATIVE
	/***************************************************************************/
	$('.grid-blog').isotope({
	  itemSelector: '.col-lg-4'
	});
	
	/***************************************************************************/
	//INITIALIZE PRICE RANGE SLIDER
	/***************************************************************************/
	var sliders = document.getElementsByClassName('price-slider');
	var count = 0;

	for ( var i = 0; i < sliders.length; i++ ) {

		noUiSlider.create(sliders[i], {
			connect: true,
			start: [ 150000, 600000 ],
			step: 1000,
			margin:1000,
			range: {
				'min': [  2000 ],
				'max': [ 1000000 ]
			},
			tooltips: true,
			format: wNumb({
				decimals: 0,
				thousand: ',',
				prefix: '$',
			})
		});

		count = count + 1;
	}

	/***************************************************************************/
	//FILTER TOGGLE (ON GOOGLE MAPS)
	/***************************************************************************/
	$('.filter-toggle').on('click', function() {
		$(this).parent().find('form').stop(true, true).slideToggle();
	});

});