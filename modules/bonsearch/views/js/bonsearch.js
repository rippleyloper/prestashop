/*
 * 2015-2017 Bonpresta
 *
 * Bonpresta Advanced Ajax Live Search Product
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the General Public License (GPL 2.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/GPL-2.0
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the module to newer
 * versions in the future.
 *
 *  @author    Bonpresta
 *  @copyright 2015-2017 Bonpresta
 *  @license   http://opensource.org/licenses/GPL-2.0 General Public License (GPL 2.0)
 */

$(document).ready(function() {
    var timer;

    $( "#input_search" ).keyup(function() {
        clearTimeout(timer);
        timer = setTimeout(function() {
            var search_key = $( "#input_search" ).val();
            $.ajax({
                type: 'GET',
                url: prestashop['urls']['base_url'] + 'modules/bonsearch/ajax.php',
                headers: { "cache-control": "no-cache" },
                async: true,
                data: 'search_key=' + search_key,
                success: function(data) {
                    $('#search_popup').innerHTML = data;
                }
            }) .done(function( msg ) {
                $( "#search_popup" ).html(msg);
            });
        }, 1000);
    })

    $('html').click(function() {
        $( "#search_popup" ).html('');
    });

    $('#search_popup').click(function(event){
        event.stopPropagation();
    });
});