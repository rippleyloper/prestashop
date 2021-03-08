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

<div class="{if $psv >= 1.6}form-horizontal col-lg-10 {else}form_content{/if}">
    {foreach $errors as $error}
        <div class="{if $psv >= 1.6}alert alert-danger{else}error{/if}">
            {$error|escape:'htmlall':'UTF-8'}
        </div>
    {/foreach}
    {foreach $success as $succes}
        <div class="{if $psv >= 1.6}alert alert-success{else}conf{/if}">
            {$succes|escape:'htmlall':'UTF-8'}
        </div>
    {/foreach}
    {if $tab != ''}
        {$tab nofilter}
    {/if}
    {$content nofilter}
    <div id="sc-modal_form" class="modal fade">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <p>{l s='1). If you want to delete your customer only from your tabel submit  "Delete from table".
                        All data will be removed from the table.' mod="hipopupnotification"}
                    </p>
                    <p>{l s='2). If you want your customers to be 
                        able to register again with the same 
                        email address submit "Full delete". 
                        All data will be removed from the database.' mod="hipopupnotification"}
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary delete_table" data-id ='' data-delete-type ='delete_table'>{l s='Delete from table' mod='hipopupnotification'}</button>
                    <button type="button" class="btn btn-primary delete_full" data-id ='' data-delete-type ='delete_full'>{l s='Delete from customers table' mod='hipopupnotification'}</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
