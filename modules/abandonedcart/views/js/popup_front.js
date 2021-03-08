/**
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to http://www.prestashop.com for more information.
 * We offer the best and most useful modules PrestaShop and modifications for your online store.
 *
 * @category  PrestaShop Module
 * @author    knowband.com <support@knowband.com>
 * @copyright 2020 knowband
 * @license   see file: LICENSE.txt
 */

/**
 * This file is added by Anshul for adding Popup reminder changes.
 * It will allow to show the popup (with coupon & products in the cart) to those customers who left their carts abandoned.
 * Feature: Popup Reminder (Jan 2020)
 */

var kb_pop_time = typeof kb_pop_time == 'undefined' ? '': kb_pop_time;
var diff_in_sec = typeof diff_in_sec == 'undefined' ? '': diff_in_sec;
var current_time = typeof current_time == 'undefined' ? '': current_time;

$(document).ready(function () {
        var popup_time = parseInt(kb_pop_time);
        var current_time_new = parseInt(current_time);
        var check = accessCookie("abd_popup_again");
        
        if ((parseInt(Number(current_time_new) - Number(popup_time)) >= parseInt(Number(diff_in_sec)))) {
            //add overlay
            $('<div class="kboverlaygg"></div>').insertBefore('body');
            //show popup reminder
                $.fancybox($("#popup_front_velsof"), {
                    type: 'inline',
                    autoScale: true,
                    width: '50%',
                    height: '10%',
                    minHeight: '20',
                    minWidth: '300',
                afterClose: function () {
                    $('.kboverlaygg').remove();
//                    createCookie("abd_popup_again", '2', popup_front_again);
                    updateReminderTrack('next_show');
                }
                });
            updateReminderTrack('last_show');
            }
            });

/*
 * function added by Anshul to update the next show time in DB for tracking
 * Feature: Popup Reminder (Jan 2020)
 */
function updateReminderTrack(type) {
    var str = '';
    var date = new Date();
    if (type == 'next_show') {
        str = '&nexttime='+ parseInt(date.getTime() + (popup_front_again * 60 * 60 * 1000));
        }
    var url = abd_ajax_url + '&ajax=true&action=updatePopupReminder&id_cart='+kb_id_cart+'&id_reminder='+kb_id_reminder+'&type='+type + str;
    $.ajax({
        type: 'POST',
        url: url,
        cache: false,
        success: function (jsonData) {
        }
});
}

function createCookie(cookieName, cookieValue, HoursToExpire)
{
    var date = new Date();
    date.setTime(date.getTime() + (HoursToExpire * 60 * 60 * 1000));
    console.log(date);
    document.cookie = cookieName + "=" + cookieValue + "; expires=" + date.toGMTString();
}

function accessCookie(cookieName)
{
    var name = cookieName + "=";
    var allCookieArray = document.cookie.split(';');
    for (var i = 0; i < allCookieArray.length; i++)
    {
        var temp = allCookieArray[i].trim();
        if (temp.indexOf(name) == 0)
            return temp.substring(name.length, temp.length);
    }
    return "";
}

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}


function deleteCookie(cname) {
    var d = new Date(); //Create an date object
    d.setTime(d.getTime() - (1000 * 60 * 60 * 24)); //Set the time to the past. 1000 milliseonds = 1 second
    var expires = "expires=" + d.toGMTString(); //Compose the expirartion date
    window.document.cookie = cname + "=" + "; " + expires;//Set the cookie with name and the expiration date

}