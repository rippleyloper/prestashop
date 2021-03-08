/*
 * Custom code goes here.
 * A template should always ship with an empty custom.js
 */
 
/* --------------------------- TmplateTrip JS ------------------------------ */

/* ----------- Start Page-loader ----------- */
		$(window).load(function() 
		{ 
			$(".ttloading-bg").fadeOut("slow");
		})
/* ----------- End Page-loader ----------- */

$(document).ready(function(){
				   
/* Go to Top JS START */
		if ($('#goToTop').length) {
			var scrollTrigger = 100, // px
				backToTop = function () {
					var scrollTop = $(window).scrollTop();
					if (scrollTop > scrollTrigger) {
						$('#goToTop').addClass('show');
					} else {
						$('#goToTop').removeClass('show');
					}
				};
			backToTop();
			$(window).on('scroll', function () {
				backToTop();
			});
			$('#goToTop').on('click', function (e) {
				e.preventDefault();
				$('html,body').animate({
					scrollTop: 0
				}, 700);
			});
		}
	/* Go to Top JS END */
	
	/*---------------- Start Search ---------------- */

	$(".top-nav .ttsearch_button ").click(function() {
	$('.top-nav .ttsearchtoggle').parent().toggleClass('active');
	$(".user-info").css('display','none');
	$('.top-nav .ttsearchtoggle').toggle('fast', function() {
	});
	$('.top-nav #search_query_top').attr('autofocus', 'autofocus').focus();
	});
	
	/*---------------- End Search ---------------- */
		$("#index #ttcmsbanner,#index .ttspecial-products").wrapAll("<div class='offer-special container'></div>");
		$("#index #ttcmsbanner,#index .ttspecial-products").wrapAll("<div class='row'></div>");
	
	/* ----------- Start Templatetrip user info ----------- */

$('.ttuserheading').click(function(event){
if ($(".currency-selector")[0]){
$(".language-selector > ul").css('display', 'none');
}
if ($(".language-selector")[0]){
$(".currency-selector > ul").css('display', 'none');
}
$(this).toggleClass('active');
event.stopPropagation();
$(".user-info").slideToggle("fast");
$(".ttsearchtoggle").css('display','none');
$("#search_widget").removeClass("active");
});
$(".user-info").on("click", function (event) {
event.stopPropagation();
});
$('#_desktop_language_selector').appendTo('.user-info');
$('#_desktop_currency_selector').appendTo('.user-info');

$(".currency-selector.ttdropdown").click(function(){
$(this).toggleClass('open');
$( ".currency-selector > ul" ).slideToggle( "2000" );	
$(".language-selector > ul").slideUp("slow");
$(".language-selector").removeClass('open');
    	});

        $(".language-selector.ttdropdown").click(function(){
$(this).toggleClass('open');
$( ".language-selector > ul" ).slideToggle( "2000" );	   
$(".currency-selector > ul").slideUp("slow");
$(".currency-selector").removeClass('open');

       	});


/* ----------- End Templatetrip user info ----------- */
	
	$( "#index #ttcmsservices, #index #ttcmstestimonial" ).wrapAll( "<div class='container col-sm-12 ttservices-testimonial clearfix'><div class='row'></div></div>" 	);
	
	/* -------------- Start Homepage Tab ------------------- */

	$("#hometab").prepend("<div class='tabs'><ul class='nav nav-tabs'></ul></div>");
	$("#hometab .ttfeatured-products .tab-title").wrap("<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#ttfeatured-content'></a></li>");
	$("#hometab .ttbestseller-products .tab-title").wrap("<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#ttbestseller-content'></a></li>");
	$("#hometab .ttnew-products .tab-title").wrap("<li class='nav-item'><a class='nav-link' data-toggle='tab' href='#ttnew-content'></a></li>");
	$("#hometab .tabs ul.nav-tabs").append($("#hometab > section li.nav-item"));
	
	$("#hometab > section.ttfeatured-products").wrap("<div class='tab-pane row fade' id='ttfeatured-content'>");
	$("#hometab > section.ttbestseller-products").wrap("<div class='tab-pane row fade' id='ttbestseller-content'>");
	$("#hometab > section.ttnew-products").wrap("<div class='tab-pane row fade' id='ttnew-content'>");
	$("#hometab > .tab-pane").wrapAll("<div class='home-tab-content' id='home-tab-content' />");
	$("#hometab").append($("#hometab > .home-tab-content"));
	
	$('#hometab .tabs ul.nav-tabs > li:first-child a').addClass('active');
	$('#hometab #home-tab-content .tab-pane:first-child').addClass('in active');

/* -------------- End Homepage Tab ------------------- */
	
	
		/* ------------ Start Add Product Bootsrap class JS --------------- */
	
	colsCarousel = $('#right-column, #left-column').length;
	if (colsCarousel == 2) {
		ci=2;
	} else if (colsCarousel == 1) {
		ci=3;
	} else {
		ci=3;
	}

	
		var cols_count = $('#right-column, #left-column').length;
		if (cols_count == 2) {
			$('#content .products .product-miniature, #content-wrapper .products .product-miniature').attr('class', 'product-miniature js-product-miniature product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
		} else if (cols_count == 1) {
			$('#content .products .product-miniature, #content-wrapper .products .product-miniature').attr('class', 'product-miniature js-product-miniature product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#content .products .product-miniature, #content-wrapper .products .product-miniature').attr('class', 'product-miniature js-product-miniature product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
		}
		
	/* ------------ End Add Product Bootsrap class JS --------------- */
	
	/* ----------- carousel For FeatureProduct ----------- */
	
	 var ttfeature = $(".ttfeatured-products .products");
      ttfeature.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".ttfeature_next").click(function(){
        ttfeature.trigger('owl.next');
      })

      $(".ttfeature_prev").click(function(){
        ttfeature.trigger('owl.prev');
      })
	  
	  
	 /* ----------- carousel For ttnew-products ----------- */
	 
	 var ttnew = $(".ttnew-products .products");
      ttnew.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".ttnew_next").click(function(){
        ttnew.trigger('owl.next');
      })

      $(".ttnew_prev").click(function(){
        ttnew.trigger('owl.prev');
      })
	  
	  
	 /* ----------- carousel For bestseller ----------- */
	 
	 var ttbestseller = $(".ttbestseller-products .products");
      ttbestseller.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".ttbestseller_next").click(function(){
        ttbestseller.trigger('owl.next');
      })

      $(".ttbestseller_prev").click(function(){
        ttbestseller.trigger('owl.prev');
      })
	  
	  
	 /* ----------- carousel For ttspecial ----------- */
	 
	 var ttspecial = $(".ttspecial-products .products");
      ttspecial.owlCarousel({
     	 items : 1, //10 items above 1000px browser width
     	 itemsDesktop : [1200,1], 
     	 itemsDesktopSmall : [991,1], 
     	 itemsTablet: [767,1], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".ttspecial_next").click(function(){
        ttspecial.trigger('owl.next');
      })

      $(".ttspecial_prev").click(function(){
        ttspecial.trigger('owl.prev');
      })
	  
/* ----------- carousel For viewproduct ----------- */
	 
	 var viewproduct = $(".view-product .products");
      viewproduct.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".viewproduct_next").click(function(){
        viewproduct.trigger('owl.next');
      })

      $(".viewproduct_prev").click(function(){
        viewproduct.trigger('owl.prev');
      })
	  
	  
	/* ----------- carousel For Crossselling ----------- */
	
	 var Crossselling = $(".crossselling-product .products");
      Crossselling.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".Crossselling_next").click(function(){
        Crossselling.trigger('owl.next');
      })

      $(".Crossselling_prev").click(function(){
        Crossselling.trigger('owl.prev');
      })
	  
	  
	  /* ----------- carousel For Categoryproducts ----------- */
	  
	  var Categoryproducts = $(".category-products .products");
      Categoryproducts.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".Categoryproducts_next").click(function(){
        Categoryproducts.trigger('owl.next');
      })

      $(".Categoryproducts_prev").click(function(){
        Categoryproducts.trigger('owl.prev');
      })
	  
	  
	  /* ----------- carousel For accessories ----------- */
	  
	  var accessories = $(".product-accessories .products");
      accessories.owlCarousel({
     	 items : 4, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,3], 
     	 itemsTablet: [767,2], 
     	 itemsMobile : [480,1] 
      });

      // Custom Navigation Events
      $(".accessories_next").click(function(){
        accessories.trigger('owl.next');
      })

      $(".accessories_prev").click(function(){
        accessories.trigger('owl.prev');
      })
	  
	 /* ----------- Start Carousel For Topcategories  ----------- */

			$("#tt_cat_featured").owlCarousel({
			navigation:true,
			navigationText: [
			"<i class='material-icons'>&#xE5CB;</i>",
			"<i class='material-icons'>&#xE5CC;</i>"],
			items:6, //10 items above 1000px browser width
			itemsDesktop : [1200,4], 
			itemsDesktopSmall : [991,3], 
			itemsTablet: [767,3], 
			itemsMobile : [543,2] 
			});

/* ----------- End Carousel For Topcategories  ----------- */
	  
	/* -----------Start carousel For tt_categoryslider ----------- */
	
	 var ttcategoryslider = $("#ttcategorytabs .tab-content .tab-pane .ttcategory .products").owlCarousel({
	items: 4, //10 items above 1000px browser width
	itemsDesktop : [1200,4], 
	itemsDesktopSmall : [991,3], 
	itemsTablet: [767,2], 
	itemsMobile : [480,1] 
	});
	
	  // Custom Navigation Events
		  $(".ttcategory_next").click(function(){
			ttcategoryslider.trigger('owl.next');
		  })
	
		  $(".ttcategory_prev").click(function(){
			ttcategoryslider.trigger('owl.prev');
		  })
	/* -----------Start carousel For TT- cms category ----------- */

 
var ttcategory = $("#ttcategory-carousel");
      ttcategory.owlCarousel({
 autoPlay : true,
     	 items :5, //10 items above 1000px browser width
     	 itemsDesktop : [1200,4], 
     	 itemsDesktopSmall : [991,4], 
     	 itemsTablet: [767,3], 
     	 itemsMobile : [480,1] 
      });
/* -----------End carousel For TT- cms category ----------- */
	
	/* -----------Start carousel For TT- brand logo ----------- */
	 var ttbrandlogo = $("#ttbrandlogo-carousel");
		  ttbrandlogo.owlCarousel({
		  autoPlay : true,
			 items :5, //10 items above 1000px browser width
			 itemsDesktop : [1200,5], 
			 itemsDesktopSmall : [991,4], 
			 itemsTablet: [767,3], 
			 itemsMobile : [480,2] 
		  });
		  
		// Custom Navigation Events
		$(".ttbrandlogo_next").click(function(){
		ttbrandlogo.trigger('owl.next');
		})
		
		$(".ttbrandlogo_prev").click(function(){
		ttbrandlogo.trigger('owl.prev');
		})
		  
		  
	/* -----------End carousel For TT brand logo ----------- */
	  
	/* ----------- Start Carousel For Productpage Thumbs ----------- */
	
		$("#ttproduct-thumbs").owlCarousel({
		navigation:true,
		navigationText: [
			"<i class='material-icons'>&#xE5CB;</i>",
			"<i class='material-icons'>&#xE5CC;</i>"],
		items: 4, //10 items above 1000px browser width
		itemsDesktop : [1200,4], 
		itemsDesktopSmall : [991,3], 
		itemsTablet: [767,2], 
		itemsMobile : [480,1] 
	});
	
	/* ----------- End Carousel Productpage Thumbs ----------- */	
	 /* ------------ Start TemplateTrip Parallax JS ------------ */
	 
	var isMobile = /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent);
	if(!isMobile) {
	if($(".parallex").length){  $(".parallex").sitManParallex({  invert: false });};    
	}else{
	$(".parallex").sitManParallex({  invert: true });
	}	

/* ------------ End TemplateTrip Parallax JS ------------ */  
/* ----------- Start SmartBlog JS ----------- */
	 
			var smartblog = $("#smartblog-carousel");
			  smartblog.owlCarousel({	
		 autoPlay:true,
				 items :3, //10 items above 1000px browser width
				 itemsDesktop : [1200,3], 
				 itemsDesktopSmall : [991,2], 
				 itemsTablet: [767,2], 
				 itemsMobile : [480,1] 
			  });
		  
		   // Custom Navigation Events
			  $(".ttblog_next").click(function(){
				smartblog.trigger('owl.next');
			  })
		
			  $(".ttblog_prev").click(function(){
				smartblog.trigger('owl.prev');
			  })
		
/* ----------- End SmartBlog JS ----------- */
  /* -----------Start carousel For Testimonial ----------- */
	 var tttestimonial= $("#tttestimonial-carousel");
      tttestimonial.owlCarousel({
		 autoPlay : true,
		 pagination : true,
         paginationNumbers : true,
     	 items : 1, //10 items above 1000px browser width
     	 itemsDesktop : [1200,1], 
     	 itemsDesktopSmall : [991,1], 
     	 itemsTablet: [767,1], 
     	 itemsMobile : [480,1] 
      });

 /* ----------- End carousel For Testimonial ----------- */
 
 
 /* ----------- Start Templatetrip AddToCart Button ----------- */
 
	$( ".tt-button-container .add-to-cart" ).mousedown(function() {
	  var form_className = $(this).parent().attr('class');
	  $(this).parent().attr('id',form_className);
	
	  var hidden_page_className = $(this).parent().find('.product-quantity .product_page_product_id').attr('class');
	  $(this).parent().find('.product-quantity .product_page_product_id').attr('id',hidden_page_className);
	
	  var customization_className = $(this).parent().find('.product-quantity .product_customization_id').attr('class');
	  $(this).parent().find('.product-quantity .product_customization_id').attr('id',customization_className);
	
	  var quantity_className = $(this).parent().find('.product-quantity .quantity_wanted').attr('class');
	  $(this).parent().find('.product-quantity .quantity_wanted').attr('id',quantity_className);
	});
	
	$( ".tt-button-container .add-to-cart" ).mouseup(function() {
	  $(this).parent().removeAttr('id');
	  $(this).parent().find('.product-quantity > input').removeAttr('id');
	});

	$("#product-comments-list-header").click(function(){
			$(this).toggleClass("active");
			$(".product-comments-list-main").slideToggle();
	});

/* ----------- End Templatetrip AddToCart Button ----------- */
	productadditional("#main #tt-jqzoom");				   

});	 

function productadditional(productId){
	 var ttadditional = $(productId);
      ttadditional.owlCarousel({
		navigation:true,
		navigationText: [
		"<i class='material-icons'>&#xE5CB;</i>",
		"<i class='material-icons'>&#xE5CC;</i>"],
     	 items : 3, //10 items above 1000px browser width
     	 itemsDesktop : [1200,3], 
     	 itemsDesktopSmall : [991,2], 
     	 itemsTablet: [767,3], 
     	 itemsMobile : [543,2] 
      });
}
function header() {	
 if (jQuery(window).width() > 1199){
     if (jQuery(this).scrollTop() > 400)
        {    
            jQuery('.header-nav').addClass("fixed");
 
    	}else{
      	 jQuery('.header-nav').removeClass("fixed");
      	}
    } else {
      jQuery('.header-nav').removeClass("fixed");
      }
}
 
$(document).ready(function(){header();});
jQuery(window).resize(function() {header();});
jQuery(window).scroll(function() {header();});


/*--------- Start js for left-column -------------*/
	
	function responsivecolumn()
	{
		if ($(document).width() <= 991) 
		{
			$('.container #left-column').insertAfter('#content-wrapper');
		}
		else if($(document).width() >= 992)
		{
			$('.container #left-column').insertBefore('#content-wrapper');
		}
	}
	$(document).ready(function(){responsivecolumn();});
	$(window).resize(function(){responsivecolumn();});
	
/*--------- End js for left-column -------------*/
	/* ---------------- start Templatetrip link more menu ----------------------*/
	
		var max_link =3;
		var items = $('.topmenu .menu ul#top-menu > li');
		var surplus = items.slice(max_link, items.length);
		surplus.wrapAll('<li class="more_menu ttmenu"><div class="top-menu sub-menu clearfix">');
		$('.more_menu').prepend('<a href="#" class="level-top">More</a>');
		$('.more_menu').mouseover(function(){
		$(this).children('div').addClass('shown-link');
		})
		$('.more_menu').mouseout(function(){
		$(this).children('div').removeClass('shown-link');
		});
	
	/* ---------------- End Templatetrip link more menu ----------------------*/


function bindGrid()
{
	var view = localStorage.getItem('display');
	if (view == 'list')
		display(view);
	else
		$('.display').find('#ttgrid').addClass('active');
	//Grid	
	$(document).on('click', '#ttgrid', function(e){
		e.preventDefault();
		display('grid');
	});
	//List
	$(document).on('click', '#ttlist', function(e){
		e.preventDefault();
		display('list');		
	});	
}
$("#products .product-list .thumbnail-container .ttproduct-image .product-list-reviews").each(function(){
	$(this).insertAfter($(this).parent().parent().parent().find(".ttproduct-desc .product-title"));
});
$("#products .product-grid .thumbnail-container .ttproduct-desc .product-list-reviews").each(function(){
	$(this).appendTo($(this).parent().parent().parent().find(".ttproduct-image"));
});
$("#products .product-list .thumbnail-container .ttproduct-image .ttproducthover").each(function(){
    $(this).appendTo($(this).parent().parent().find(".ttproduct-desc"));
});
$("#products .product-grid .thumbnail-container .ttproduct-desc .ttproducthover").each(function(){
    $(this).appendTo($(this).parent().parent().parent().find(".ttproduct-image"));
});

function display(view)
{
	if (view == 'list')
	{
		$('#ttgrid').removeClass('active');
		$('#ttlist').addClass('active');
		$('#content-wrapper .products.product-thumbs .product-miniature').attr('class', 'product-miniature js-product-miniature product-list col-xs-12');
		$('#content-wrapper .products.product-thumbs .product-miniature .ttproduct-image').attr('class', 'ttproduct-image col-xs-5 col-sm-5 col-md-4');
		$('#content-wrapper .products.product-thumbs .product-miniature .ttproduct-desc').attr('class', 'ttproduct-desc col-xs-7 col-sm-7 col-md-8');
		$("#products .product-list .thumbnail-container .ttproduct-image .ttproducthover").each(function(){
			$(this).appendTo($(this).parent().parent().find(".ttproduct-desc"));
		});
		$("#products .product-list .thumbnail-container .ttproduct-image .product-list-reviews").each(function(){
			$(this).insertAfter($(this).parent().parent().parent().find(".ttproduct-desc .product-title"));
		});
		$('#ttlist').addClass('active');
		$('.grid-list').find('#ttlist').addClass('selected');
		$('.grid-list').find('#ttgrid').removeAttr('class');
		localStorage.setItem('display', 'list');
	}
	else
	{
		$('#ttlist').removeClass('active');
		$('#ttgrid').addClass('active');

		var cols_count = $('#right-column, #left-column').length;
		if (cols_count == 2) {
			$('#js-product-list .products.product-thumbs .product-miniature').attr('class', 'product-miniature js-product-miniature product-grid col-lg-6 col-md-6 col-sm-12 col-xs-12');
		} else if (cols_count == 1) {
			$('#js-product-list .products.product-thumbs .product-miniature').attr('class', 'product-miniature js-product-miniature product-grid col-lg-4 col-md-4 col-sm-6 col-xs-12');
		} else {
			$('#js-product-list .products.product-thumbs .product-miniature').attr('class', 'product-miniature js-product-miniature product-grid col-lg-3 col-md-3 col-sm-6 col-xs-12');
		}
		$("#products .product-grid .thumbnail-container .ttproduct-desc .ttproducthover").each(function(){
			$(this).appendTo($(this).parent().parent().parent().find(".ttproduct-image"));
		});
		$("#products .product-grid .thumbnail-container .ttproduct-desc .product-list-reviews").each(function(){
			$(this).appendTo($(this).parent().parent().parent().find(".ttproduct-image"));
		});
		$('#content-wrapper .products.product-thumbs .product-miniature .ttproduct-image').attr('class', 'ttproduct-image');
		$('#content-wrapper .products.product-thumbs .product-miniature .ttproduct-desc').attr('class', 'ttproduct-desc');
		
		$('.grid-list').find('#ttgrid').addClass('selected');
		$('.grid-list').find('#ttlist').removeAttr('class');
		localStorage.setItem('display', 'grid');
	}
}
$(document).ready(function(){
	bindGrid();
});


/* ------------ End Grid List JS --------------- */