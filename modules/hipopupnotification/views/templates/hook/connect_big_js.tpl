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
        var popup = {/literal}{$popup}{literal};
        var base_dir = "{/literal}{$base_dir}{literal}";
        var authentication_page = "{/literal}{$authentication_page}{literal}";
        function refreshParent() {
            if(redirect == "no_redirect") {
                if (popup) {
                    window.opener.location.reload();
                } else {
                    window.location.href = base_dir;
                }
            } else {
                if (popup) {
                    window.opener.location.href = authentication_page;
                } else {
                    window.location.href = authentication_page;
                }
            }
        }
        if (popup) {
            setTimeout(function(){
                window.opener.loaderOpening();
                self.close();

                window.onunload = refreshParent();
            }, 500)
        }
    {/literal}
</script>
