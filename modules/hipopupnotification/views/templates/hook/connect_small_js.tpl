{**
* 2012 - 2020 HiPresta
*
* MODULE Popup Notification
*
* @author    HiPresta <support@hipresta.com>
* @copyright HiPresta 2020
* @license   Addons PrestaShop license limitation
* @link      http://www.hipresta.com
*
* NOTICE OF LICENSE
*
* Don't use this module on several shops. The license provided by PrestaShop Addons
* for all its modules is valid only once for a single shop.
*}

<script type="text/javascript">
    {literal}
        var redirect = "{/literal}{$redirect}{literal}";
        function refreshParent() {
            if(redirect == "no_redirect") {
                window.opener.location.reload();
            } else {
                window.opener.location.href = "{/literal}{$authentication_page}{literal}";
            }
        }
        setTimeout(function(){
            window.opener.loaderOpening();
            self.close();
            window.onunload = refreshParent();
        }, 500)
    {/literal}
</script>