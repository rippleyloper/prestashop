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

{if $psv >= 1.7}
    <div class="hi_gdpr_consent gdpr_module_{$id_module|escape:'htmlall':'UTF-8'}">
        <span class="custom-checkbox">
            <input class="hi_psgdpr_consent_checkbox" name="psgdpr_consent_checkbox" type="checkbox" value="1">
            <span><i class="material-icons rtl-no-flip checkbox-checked psgdpr_consent_icon"></i></span>
            <label class="psgdpr_consent_message">
                {$gdpr_content nofilter}
            </label>
        </span>
    </div>
{else}
    <div  class="hi_gdpr_consent gdpr_module_{$id_module|escape:'htmlall':'UTF-8'}">
        <div class="form-group">
            <div class="checkbox">
                <input class="hi_psgdpr_consent_checkbox" name="psgdpr_consent_checkbox" type="checkbox" value="1">
                <div class="gdpr_content">
                    <label for="psgdpr_consent_checkbox">{$gdpr_content nofilter}</label>
                </div>
            </div>
        </div>
    </div>
{/if}