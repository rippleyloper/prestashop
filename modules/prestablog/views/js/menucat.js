/**
 * 2008 - 2020 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial

 */

$(document).ready(function() {
	  $('i.idi').click(function(e) {



 event.stopPropagation();
	var submenu2 = $(e.target).closest('ul').children('ul li ul.sub-menu');
     var sub = submenu2.context.nextElementSibling;
    var submenu = $(e.target).closest('li').children('ul.sub-menu');
     for (let i = 0; i < submenu.length; i++) {

     	if(sub.classList.contains("hidden"))
	{
		var submenu1 = document.querySelectorAll('ul li ul');
       for (let i = 0; i < submenu1.length; i++) {
       	if(submenu1[i].classList.contains("hidden"))
	{
     	} else {
		submenu1[i].classList.remove("block");
     	submenu1[i].classList.add("hidden");
     }
     }
		sub.classList.remove("hidden");
     	sub.classList.add("block");
     	} else {
     	var submenu1 = document.querySelectorAll('ul li ul');
       for (let i = 0; i < submenu1.length; i++) {
       	if(submenu1[i].classList.contains("hidden"))
	{
     	} else {
		submenu1[i].classList.remove("block");
     	submenu1[i].classList.add("hidden");
     }
     }

		sub.classList.remove("block");
     	sub.classList.add("hidden");
     }

	}
  });



       /*if(sub.classList.contains("hidden"))
	{
		sub.classList.remove("hidden");
     	sub.classList.add("block");
     	} else {
		sub.classList.remove("block");
     	sub.classList.add("hidden");
     }*/

 });


$(document).ready(function() {
  $('i.idi2').click(function(e) {

    e.preventDefault();
    var submenu = $(e.target).closest('li').children('.sub-menu');

     for (let i = 0; i < submenu.length; i++) {
     	if(submenu[i].classList.contains("hidden"))
	{
     	submenu[i].classList.remove("hidden");
     	submenu[i].classList.add("block");
     	} else {
		submenu[i].classList.remove("block");
     	submenu[i].classList.add("hidden");
     }
	}

  });
});

jQuery(document).ready(function(){
	$("div#menu-mobile, div#menu-mobile-close").click(function() {
			$("#prestablog_menu_cat nav").toggle();
	});
});
