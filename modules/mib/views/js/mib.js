/**
 * PrestaShop module created by VEKIA, a guy from official PrestaShop community ;-)
 *
 * @author    VEKIA https://www.prestashop.com/forums/user/132608-vekia/
 * @copyright 2010-9999 VEKIA
 * @license   This program is not free software and you can't resell and redistribute it
 *
 * CONTACT WITH DEVELOPER http://mypresta.eu
 * support@mypresta.eu
 */

$(document).ready(function () {
    var parent_carousel = $("#mypresta_mib").width();
    var item_pc = 6;
    var item_tablet = 4;
    var item_mobile = 1;

    //console.log(parent_carousel);

    if (parent_carousel > 1920){
        var item_pc = 9;
        var item_tablet = 4;
        var item_mobile = 3;
    }


    if (parent_carousel > 1024 && parent_carousel < 1920 ){
        var item_pc = 6;
        var item_tablet = 4;
        var item_mobile = 1;
    }

    if (parent_carousel > 800 && parent_carousel < 1024 ){
        var item_pc = 5;
        var item_tablet = 4;
        var item_mobile = 1;
    }

    if (parent_carousel < 800 && parent_carousel < 480){
        var item_pc = 5;
        var item_tablet = 4;
        var item_mobile = 1;
    }

    if (parent_carousel < 480){
        var item_pc = 1;
        var item_tablet = 1;
        var item_mobile = 1;
    }

    $("#MyPrestaBrandsCarousel").lightSlider({
        controls: true,
        item: item_pc,
        pager: false,
        loop: true,
        auto:true,
        pauseOnHover: true,
        slideMove: 1,
        speed: 600,
        responsive: [
            {
                breakpoint: 800,
                settings: {
                    item: item_tablet,
                    slideMove: 1,
                    slideMargin: 0,
                }
            },
            {
                breakpoint: 480,
                settings: {
                    item: item_mobile,
                    slideMove: 1
                }
            }
        ]
    });
});