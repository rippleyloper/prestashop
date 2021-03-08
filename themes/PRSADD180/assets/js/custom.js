function additionalCarousel(sliderId){
	/*======  curosol For Additional ==== */
	 var tmadditional = $(sliderId);
      tmadditional.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1209,3], 
     	 itemsDesktopSmall : [991,2], 
     	 itemsTablet: [480,2], 
     	 itemsMobile : [320,1] 
      });
      // Custom Navigation Events
      $(".additional_next").click(function(){
        tmadditional.trigger('owl.next');
      })
      $(".additional_prev").click(function(){
        tmadditional.trigger('owl.prev');
      });
}

$(document).ready(function(){
	
	bindGrid();
	additionalCarousel("#main #additional-carousel");
	
	

	$('.cart_block .block_content').on('click', function (event) {
		event.stopPropagation();
	});
	
	//breadcumb//
	$('h1.h1').prependTo('.breadcrumb .container');
	//breadcumb//
	
	
	// ---------------- start more menu setting ----------------------
		
		if(jQuery(window).width() >= 1450) {	
		var max_elem = 7;
		}
		else if(jQuery(window).width() >= 1200)
		{
		var max_elem = 7;
		}
		else{
		var max_elem = 7;
		}	

		var items = $('.menu ul#top-menu > li');	
		var surplus = items.slice(max_elem, items.length);
		
		surplus.wrapAll('<li class="category more_menu" id="more_menu"><div id="top_moremenu" class="popover sub-menu js-sub-menu collapse"><ul class="top-menu more_sub_menu">');
	
		$('.menu ul#top-menu .more_menu').prepend('<a href="#" class="dropdown-item" data-depth="0"><span class="pull-xs-right hidden-md-up"><span data-target="#top_moremenu" data-toggle="collapse" class="navbar-toggler collapse-icons"><i class="material-icons add">&#xE313;</i><i class="material-icons remove">&#xE316;</i></span></span></span><i class="fa fa-plus"></i></a>');
	
		$('.menu ul#top-menu .more_menu').mouseover(function(){
			$(this).children('div').css('display', 'block');
		})
		.mouseout(function(){
			$(this).children('div').css('display', 'none');
		});
	// ---------------- end more menu setting ----------------------

});


// Add/Remove acttive class on menu active in responsive  
	$('#menu-icon').on('click', function() {

		$(this).toggleClass('active');


	});

	/*
$('.menu-icon-col').on('click', function(e) {
   // console.log(e);


    $(this).prop('aria-selected', false);

    console.log(stt);


   $('.menu-icon-col').each(function(index){

       var element = $(this); // <-- en la variable element tienes tu elemento
       console.log(index);



   });


   // $(this).toggleClass('active');


});

*/

// Loading image before flex slider load
	$(window).load(function() { 
		$(".loadingdiv").removeClass("spinner");
	});

// Flex slider load
	$(window).load(function() {
		if($('.flexslider').length > 0){ 
			$('.flexslider').flexslider({		
				slideshowSpeed: $('.flexslider').data('interval'),
				pauseOnHover: $('.flexslider').data('pause'),
				animation: "fade"
			});
		}
	});		

// Scroll page bottom to top
	$(window).scroll(function() {
		if ($(this).scrollTop() > 500) {
			$('.top_button').fadeIn(500);
		} else {
			$('.top_button').fadeOut(500);
		}
	});							
	$('.top_button').click(function(event) {
		event.preventDefault();		
		$('html, body').animate({scrollTop: 0}, 800);
	});



/*======  Carousel Slider For Feature Product ==== */
	
	var tmfeature = $("#feature-carousel");
	tmfeature.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1500,4], 
		itemsDesktopSmall : [1199,3], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2] 
	});
	// Custom Navigation Events
	$(".feature_next").click(function(){
		tmfeature.trigger('owl.next');
	})
	$(".feature_prev").click(function(){
		tmfeature.trigger('owl.prev');
	});



/*======  Carousel Slider For New Product ==== */
	
	var tmnewproduct = $("#newproduct-carousel");
	tmnewproduct.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1500,4], 
		itemsDesktopSmall : [1199,4], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2]
	});
	// Custom Navigation Events
	$(".newproduct_next").click(function(){
		tmnewproduct.trigger('owl.next');
	})
	$(".newproduct_prev").click(function(){
		tmnewproduct.trigger('owl.prev');
	});



/*======  Carousel Slider For Bestseller Product ==== */
	
	var tmbestseller = $("#bestseller-carousel");
	tmbestseller.owlCarousel({
		items : 5, //10 items above 1000px browser width
		itemsDesktop : [1500,4], 
		itemsDesktopSmall : [1199,3], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2]
	});
	// Custom Navigation Events
	$(".bestseller_next").click(function(){
		tmbestseller.trigger('owl.next');
	})
	$(".bestseller_prev").click(function(){
		tmbestseller.trigger('owl.prev');
	});



/*======  Carousel Slider For Special Product ==== */
	var tmspecial = $("#special-carousel");
	tmspecial.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1500,4], 
		itemsDesktopSmall : [1199,4], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2] 
	});
	// Custom Navigation Events
	$(".special_next").click(function(){
		tmspecial.trigger('owl.next');
	})
	$(".special_prev").click(function(){
		tmspecial.trigger('owl.prev');
	});


/*======  Carousel Slider For Accessories Product ==== */

	var tmaccessories = $("#accessories-carousel");
	tmaccessories.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1299,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2] 
	});
	// Custom Navigation Events
	$(".accessories_next").click(function(){
		tmaccessories.trigger('owl.next');
	})
	$(".accessories_prev").click(function(){
		tmaccessories.trigger('owl.prev');
	});


/*======  Carousel Slider For Viewed Product ==== */

	var tmviewed = $("#viewed-carousel");
	tmviewed.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1199,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2] 
	});
	// Custom Navigation Events
	$(".viewed_next").click(function(){
		tmviewed.trigger('owl.next');
	})
	$(".viewed_prev").click(function(){
		tmviewed.trigger('owl.prev');
	});

/*======  Carousel Slider For Crosssell Product ==== */

	var tmcrosssell = $("#crosssell-carousel");
	tmcrosssell.owlCarousel({
		items : 4, //10 items above 1000px browser width
		itemsDesktop : [1299,3], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [479,2] 
	});
	// Custom Navigation Events
	$(".crosssell_next").click(function(){
		tmcrosssell.trigger('owl.next');
	})
	$(".crosssell_prev").click(function(){
		tmcrosssell.trigger('owl.prev');
	});

/*======  curosol For Manufacture ==== */
	 var tmbrand = $("#brand-carousel");
      tmbrand.owlCarousel({
     	 items : 5, //10 items above 1000px browser width
     	 itemsDesktop : [1199,4], 
     	 itemsDesktopSmall : [991,3],
     	 itemsTablet: [767,2], 
     	 itemsMobile : [479,1] 
      });
      // Custom Navigation Events
      $(".brand_next").click(function(){
        tmbrand.trigger('owl.next');
      })
      $(".brand_prev").click(function(){
        tmbrand.trigger('owl.prev');
      });
	  

/*======  Carousel Slider For blog  ==== */
	
	var tmblog = $("#blog-carousel");
	tmblog.owlCarousel({
		items : 2, //10 items above 1000px browser width
		itemsDesktop : [1199,2], 
		itemsDesktopSmall : [991,2],
		itemsTablet: [767,2],  
		itemsMobile : [479,1] 
	});

	$(".blog_next").click(function(){
		tmblog.trigger('owl.next');
	})
	$(".blog_prev").click(function(){
		tmblog.trigger('owl.prev');
	});
	

function bindGrid()
{
	var view = $.totalStorage("display");

	if (view && view != 'grid')
		display(view);
	else
		$('.display').find('li#grid').addClass('selected');

	$(document).on('click', '#grid', function(e){
		e.preventDefault();
		display('grid');
	});

	$(document).on('click', '#list', function(e){
		e.preventDefault();
		display('list');		
	});	
}

function display(view)
{
	if (view == 'list')
	{
		$('#products ul.product_list').removeClass('grid').addClass('list row');
		$('#products .product_list > li').removeClass('col-xs-12 col-sm-6 col-md-6 col-lg-4').addClass('col-xs-12');
		
		
		$('#products .product_list > li').each(function(index, element) {
			var html = '';
			html = '<div class="product-miniature js-product-miniature" data-id-product="'+ $(element).find('.product-miniature').data('id-product') +'" data-id-product-attribute="'+ $(element).find('.product-miniature').data('id-product-attribute') +'" itemscope itemtype="http://schema.org/Product"><div class="row">';
				html += '<div class="thumbnail-container col-xs-4 col-xs-5 col-md-4">' + $(element).find('.thumbnail-container').html() + '</div>';
				
				html += '<div class="product-description center-block col-xs-4 col-xs-7 col-md-8">';
					html += '<h3 class="h3 product-title" itemprop="name">'+ $(element).find('h3').html() + '</h3>';
					
					var price = $(element).find('.product-price-and-shipping').html();       // check : catalog mode is enabled
					if (price != null) {
						html += '<div class="product-price-and-shipping">'+ price + '</div>';
					}
					
					html += '<div class="product-detail">'+ $(element).find('.product-detail').html() + '</div>';
					
					var colorList = $(element).find('.highlighted-informations').html();
					if (colorList != null) {
						html += '<div class="highlighted-informations">'+ colorList +'</div>';
					}
					
					html += '<div class="product-actions-main">'+ $(element).find('.product-actions-main').html() +'</div>';
					html += '<a class="quick-view">'+ $(element).find('.quick-view').html() +'</a>';
					
				html += '</div>';
			html += '</div></div>';
		$(element).html(html);
		});
		$('.display').find('li#list').addClass('selected');
		$('.display').find('li#grid').removeAttr('class');
		$.totalStorage('display', 'list');
	}
	else
	{
		$('#products ul.product_list').removeClass('list row').addClass('grid');
		$('#products .product_list > li').removeClass('col-xs-12').addClass('col-xs-12 col-sm-6 col-md-6 col-lg-4');
		$('#products .product_list > li').each(function(index, element) {
		var html = '';
		html += '<div class="product-miniature js-product-miniature" data-id-product="'+ $(element).find('.product-miniature').data('id-product') +'" data-id-product-attribute="'+ $(element).find('.product-miniature').data('id-product-attribute') +'" itemscope itemtype="http://schema.org/Product">';
			html += '<div class="thumbnail-container">' + $(element).find('.thumbnail-container').html() +'</div>';
			
			html += '<div class="product-description">';
				html += '<h3 class="h3 product-title" itemprop="name">'+ $(element).find('h3').html() +'</h3>';
			
				var price = $(element).find('.product-price-and-shipping').html();       // check : catalog mode is enabled
				if (price != null) {
					html += '<div class="product-price-and-shipping">'+ price + '</div>';
				}
				
				html += '<div class="product-detail">'+ $(element).find('.product-detail').html() + '</div>';
				
				html += '<div class="product-actions-main">'+ $(element).find('.product-actions-main').html() +'</div>';
				
				var colorList = $(element).find('.highlighted-informations').html();
				if (colorList != null) {
					html += '<div class="highlighted-informations">'+ colorList +'</div>';
				}
				
			html += '</div>';
		html += '</div>';
		$(element).html(html);
		});
		$('.display').find('li#grid').addClass('selected');
		$('.display').find('li#list').removeAttr('class');
		$.totalStorage('display', 'grid');
	}
}


function headerfixnormal() {
 		if ($(window).width() <= 991){
	 			if ($(this).scrollTop() >0) {
							$('.header-nav').addClass('fixed');
							
							
				}else{
							$('.header-nav').removeClass('fixed');
							
		}
		}else{
							$('.header-nav').removeClass('fixed');
							
		}
		if ($(window).width() >= 992){
	 			if ($(this).scrollTop() >20) {
							$('.header-top').addClass('fixed');
							
							
							
				}else{
							$('.header-top').removeClass('fixed');
							
				}
		}else{
							$('.header-top').removeClass('fixed');
							$('#_mobile_user_info').detach().insertAfter('.header-nav #_mobile_cart');
		}
}
jQuery(document).ready(function() {headerfixnormal();});
jQuery(window).scroll(function() {headerfixnormal();});


function responsivecolumn(){
	
	
	
	if ($(window).width() <= 991)
	{
		$('.container #columns_inner #left-column').appendTo('.container #columns_inner');
		$('.header-top #search_widget').detach().insertAfter('.header-nav #_mobile_user_info');
		
		
	}
	else if($(window).width() >= 992)
	{
		$('.container #columns_inner #left-column').prependTo('.container #columns_inner');
		$('.header-nav #search_widget').detach().insertAfter('.header-top #_desktop_user_info');
	
		
	}
}
$(window).ready(function(){responsivecolumn();});
$(window).resize(function(){responsivecolumn();});

//sign in toggle
$(document).ready(function(){
	
	 $('.tm_userinfotitle').click(function(event){
		  $(this).toggleClass('active');
		  event.stopPropagation();
		  $(".user-info").slideToggle("slow");
		});
		$(".user-info").on("click", function (event) {
		  event.stopPropagation();
		}); 
		
});
		
function searchtoggle() {
	if($(window).width() > 0){

		$('#header .search_button').click(function(event){
			$(this).toggleClass('active');
			$('#header #search_widget').toggleClass('active');
			event.stopImmediatePropagation();
			$("#header .searchtoggle").slideToggle("fast");
			$('#header .search-widget form input[type="text"]').focus();
		});
			$("#header .searchtoggle").on("click", function (event) {
				event.stopImmediatePropagation();
			});
		}
		else{
			$('#header .search_button,#header .searchtoggle').unbind();
			$('#search_widget').unbind();
			$("#header .searchtoggle").show();
		}
	}
$(window).ready(function() {searchtoggle();});
$(window).resize(function(){searchtoggle();});





    // JS for calling loadMore
		$(document).ready(function () {

			"use strict";	  
			  	var size_li_feat = $("#index #featureProduct .featured_grid li.product_item").size();
			var size_li_new = $("#index #newProduct .newproduct_grid li.product_item").size();
			var size_li_best = $("#index #bestseller .bestseller_grid li.product_item").size();
			var size_li_special = $("#index .special-products .special_grid li.product_item").size();
			
			var x= 8;
			var y= 8;
			var z= 8;
			var a= 8;

			$('#index #featureProduct .featured_grid li.product_item:lt('+x+')').fadeIn('slow');
			$('#index #newProduct .newproduct_grid li.product_item:lt('+y+')').fadeIn('slow');
			$('#index #bestseller .bestseller_grid li.product_item:lt('+z+')').fadeIn('slow');
			$('#index .special-products .special_grid li.product_item:lt('+a+')').fadeIn('slow');
			    	
			    $('.featured_grid .gridcount').click(function () {
			if(x==size_li_feat){	  	
			 $('.featured_grid .gridcount').hide();
			 $('.featured_grid .tm-message').show();
			}else{
			x= (x+5 <= size_li_feat) ? x+4 : size_li_feat;	
			        $('#index #featureProduct .featured_grid li.product_item:lt('+x+')').fadeIn(1000);	
			}
			    });	

			$('.newproduct_grid .gridcount').click(function () {
			if(y==size_li_new){	  
			$('.newproduct_grid .gridcount').hide();
			$('.newproduct_grid .tm-message').show();
			}else{
			y= (y+5 <= size_li_new) ? y+4 : size_li_new;
			        $('#index #newProduct .newproduct_grid li.product_item:lt('+y+')').fadeIn('slow');
			}
			    });	   

			$('.bestseller_grid .gridcount').click(function () {
			if(z==size_li_best){	  
			$('.bestseller_grid .gridcount').hide();
			$('.bestseller_grid .tm-message').show();
			}else{
			z= (z+5 <= size_li_best) ? z+4 : size_li_best;
			        $('#index #bestseller .bestseller_grid li.product_item:lt('+z+')').fadeIn('slow');
			}
			    });
			
				$('.special_grid .gridcount').click(function () {
			if(z==size_li_special){									 
					$('.special_grid .gridcount').hide();
					$('.special_grid .tm-message').show();
			}else{
				z= (z+5 <= size_li_special) ? z+4 : size_li_special;
				$('#index .special-products .special_grid li.product_item:lt('+a+')').fadeIn('slow');
			}
			})
		});

function headertoggle() {	
	$('#currencies-block-top').css('display','block');
	$('#header_links').css('display','block');
	$('.language-selector-wrapper').css('display','block');
	$('.language-selector-wrapper').appendTo('.user-info');
	$('.currency-selector').appendTo('.user-info');
	$('.currency-selector').css('display','block');
}
$(document).ready(function() {headertoggle();});
$(window).resize(function() {headertoggle();});

const countDownClock = (number = 100, format = 'seconds') => {

    const d = document;
    const daysElement = d.querySelector('.days');
    const hoursElement = d.querySelector('.hours');
    const minutesElement = d.querySelector('.minutes');
    const secondsElement = d.querySelector('.seconds');
    let countdown;
    convertFormat(format);


    function convertFormat(format) {
        switch (format) {
            case 'seconds':
                return timer(number);
            case 'minutes':
                return timer(number * 60);
            case 'hours':
                return timer(number * 60 * 60);
            case 'days':
                return timer(number * 60 * 60 * 24);}

    }

    function timer(seconds) {
        const now = Date.now();
        const then = now + seconds * 1000;

        countdown = setInterval(() => {
            const secondsLeft = Math.round((then - Date.now()) / 1000);

            if (secondsLeft <= 0) {
                clearInterval(countdown);
                return;
            };

            displayTimeLeft(secondsLeft);

        }, 1000);
    }

    function displayTimeLeft(seconds) {
        daysElement.textContent = Math.floor(seconds / 86400);
        hoursElement.textContent = Math.floor(seconds % 86400 / 3600);
        minutesElement.textContent = Math.floor(seconds % 86400 % 3600 / 60);
        secondsElement.textContent = seconds % 60 < 10 ? `0${seconds % 60}` : seconds % 60;
    }
};



var fechaInicio = new Date().getTime();
var fechaFin    = new Date('2019-03-17 23:59:59').getTime();

console.log(fechaInicio)

var diff = fechaFin - fechaInicio;

dias = diff/(1000*60*60*24)
/*
     start countdown
     enter number and format
     days, hours, minutes or seconds
   */

if(dias > 0){
	
    countDownClock(dias, 'days');
}

