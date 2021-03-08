{strip}
    {addJsDef pat=$path}
    {addJsDef root_path=$root_path}
    {addJsDef admin_path=$admin_path}
{/strip}

{*Start: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
{*End: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}

<script>
    var pat = "{$path}";
    var admin_path = "{$admin_path}";
    var root_path = "{$root_path}";
    var action = "{$action}";
    var ac_curr_sign = "{$currency_sign}";
    var ac_curr_format = "{$currency_format}";
    var ac_currency_blank = "{$currency_blank}";
    var priceDisplayPrecision = {$smarty.const._PS_PRICE_DISPLAY_PRECISION_|intval};
    var email_non_discount = {$non_discount_email_value};
    var email_err = "{l s='Incorrect email id' mod='abandonedcart'}";
    var image_path = "{$image_path}";
    var languages_js = '{$languages_js}'; {*Feature: Push Notification (Jan 2020)*}
</script>
{* Start code Added and Modified by Priyanshu on 20-August-2020 to implement the Admin panel design changes *}
<style type="text/css">
    #menuVel li a.glyphicons img {
        position: absolute;
        left: 15px;
        top: 10px;
    }
    #menuVel .slim-scroll > ul > li.active > a, #menuVel > ul > li.active > a {
        background: #dff3f8;
        color: #0092c8 !important;
        border-left: 5px solid #4ac7e0;
    }
    /*For Table header*/
    .pure-table thead {
        background: #ecf6fb;
    }
    .pure-table tbody tr td, .pure-table thead tr th {
        font-size: 13px !important;
    }
    .pure-table-odd td {
        background-color: #fff;
    }
    .pure-table tr {
        border-bottom: 1px solid #eaf0f3;
    }
    .pure-table tbody tr td {
        border-left: 0;
        padding-top: 10px;
        padding-bottom: 10px;
    }
    .pure-table td:last-child, .pure-table th:last-child {
        border-right:0;
    }
    .pure-table tbody tr:hover td {
        background: #f1f6f9 !important;
    }	


    .pure-table tbody tr td.list_action_btn {
        width: 84px;
    }
    table.pure-table tbody tr td.list_action_btn a.glyphicons.edit i:before {
        color: #526d9e;
    }
    table.pure-table tbody tr td.list_action_btn a.glyphicons.remove i:before {
        color: #e6644e;
    }
    .list_action_btn .glyphicons.remove {
        display: inline-block;
        vertical-align: middle;
        margin-top: 2px;
    }
    
    {literal}
        .faq-span{max-height:10px;}
        .faq-row{background: rgba(230, 230, 236, 0.37);
                 border-radius:3px;
                 margin-top:10px;
                 padding: 30px;
                 cursor: pointer;
                 padding-left: 10px;
                 padding-top: 15px;}
        .question{font-family:initial;color:rgb(213, 81, 81) !important;font-size:17px !important;}
        .answer{display:none;font-family:initial;font-size:15px;line-height:20px;letter-spacing:1px;}
    {/literal}
</style>
{* End code Added and Modified by Priyanshu on 20-August-2020 to implement the Admin panel design changes *}

<div id="velsof_abandoncart_container" class="content">
    <div class="box">
        <div class="navbar main hidden-print" style="width: 100%; background: white; margin-bottom: 7px;" >
            <!-- Brand & save buttons -->		

            <table class="topbuttons" style="width: 150px; border-spacing: 10px; border-collapse: separate; margin-top: -12px;">
                <tr>
                    <td>
                        <a style="text-decoration: none;" onclick="submitConfiguration();" href="javascript:void(0)">
                            <span class="btn btn-block btn-success action-btn" style="padding:7px;">{l s='Save' mod='abandonedcart'}</span>
                        </a>
                    </td>
                    <td>
                        <a style="text-decoration: none;" href="{$cancel_action}">
                            <span class="btn btn-block btn-danger action-btn" style="padding:7px;">{l s='Cancel' mod='abandonedcart'}</span>
                        </a>
                    </td>
                </tr>
            </table>

            <table class="topbuttons" style="width: 360px; border-spacing: 10px; border-collapse: separate; margin-top: -12px;">
                <tr>
                    <td>
                        <a style="text-decoration: none;" href="{$front_cron_url}cron=update_carts&secure_key={$secure_key}&type=manual" target="_blank">
                            <span class="btn btn-block btn-success action-btn" style="text-shadow: none;padding:7px;">{l s='Update Abandoned Cart List' mod='abandonedcart'}</span>
                        </a>
                    </td>
                    <td>
                        <a style="text-decoration: none;" onclick='if (!confirm("{l s='Do you want to Run Cron Manually?' mod='abandonedcart'}"))
                                    return false;' href="{$front_cron_url}cron=send_mails&secure_key={$secure_key}&type=manual" target="_blank">
                            <span class="btn btn-block btn-success action-btn" style="text-shadow: none;padding: 7px;">{l s='Run Send Mail Cron Manually' mod='abandonedcart'}</span>
                        </a>
                    </td>
                    <td>
                        <a style="text-decoration: none;" onclick='if (!confirm("{l s='Do you want to Run Cron Manually?' mod='abandonedcart'}"))
                                    return false;' href="{$front_cron_url}cron=send_push_notifications&secure_key={$secure_key}&type=manual" target="_blank">
                            <span class="btn btn-block btn-success action-btn" style="text-shadow: none;padding: 7px;">{l s='Send Notifications Manually' mod='abandonedcart'}</span>
                        </a>
                    </td>
                </tr>
            </table>

        </div>
        <div class="velsof-container" style="  width:100%;">
            <div class="widget velsof-widget-left" style="  width:100%">
                <div class="widget-body velsof-widget-left" style="  width:100%">
                    <div id="wrapper" style=" ">
                        <div id="menuVel" class="hidden-print ui-resizable" style="margin-right: 7px;">
                            <div class="slimScrollDiv">
                                <div class="slim-scroll">
                                    <ul>
                                        {* Start code Added and Modified by Priyanshu on 20-August-2020 to implement the Admin panel design changes *}
                                        <li class="active"><a class="glyphicons settings" href="#tab_general_settings" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon1.png' /><span>{l s='General Settings' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons message_empty" href="#tab_email" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon2.png' /><span>{l s='Email Templates' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons money" href="#tab_incentive" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon3.png' /><span>{l s='Serial Reminders' mod='abandonedcart'}</span></a></li>
                                                    {*Start: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                                        <li class=""><a class="glyphicons money" href="#tab_popup" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon4.png' /><span>{l s='Popup Template' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons money" href="#tab_popup_reminder" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon5.png' /><span>{l s='Popup Reminders' mod='abandonedcart'}</span></a></li>
                                                    {*End: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}

                                        <li class=""><a class="glyphicons shopping_bag" href="#tab_cart" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon6.png' /><span>{l s='View Abandoned Carts' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons transfer" href="#tab_rate" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon7.png' /><span>{l s='View Converted Carts' mod='abandonedcart'}</span></a></li>
                                                    {*Start: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                                        <li class=""><a class="glyphicons money" href="#tab_fcm_configuration" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon8.png' /><span>{l s='Web Browser Configuration' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons money" href="#tab_web_broswer_reminder" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon9.png' /><span>{l s='Web Browser Reminders' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons money" href="#tab_web_push_click_list" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon10.png' /><span>{l s='View Notification Click Data' mod='abandonedcart'}</span></a></li>
                                                    {*End: Added by Anshul (Feature: Push Notification (Jan 2020))*}

                                                    {*Start: Added By Shubham (Feature: Cron Log (Jan 2020))*}
                                        <li class=""><a class="glyphicons stopwatch" href="#tab_cron_log" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon11.png' /><span>{l s='Cron Log' mod='abandonedcart'}</span></a></li>
                                                    {*End: Added By Shubham (Feature: Cron Log (Jan 2020))*}
                                        <li class=""><a class="glyphicons stats" href="#tab_analytics" data-toggle="tab" onclick="getGraph();"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon12.png' /><span>{l s='Analytics' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons circle_question_mark" href="#tab_faq" data-toggle="tab"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon13.png' /><span>{l s='FAQs' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons pen" href="#tab_suggest" data-toggle="tab" ><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon14.png' /><span>{l s='Suggesstions' mod='abandonedcart'}</span></a></li>
                                        <li class=""><a class="glyphicons bookmark" target="_blank" href="https://addons.prestashop.com/en/149_knowband"><img src='{$image_path|escape:'htmlall':'UTF-8'}tab_icons/icon15.png' /><span>{l s='Other Plugins' mod='abandonedcart'}</span></a></li>
                                        {* Start code Added and Modified by Priyanshu on 20-August-2020 to implement the Admin panel design changes *}
                                    </ul>
                                    <div class="clearfix"></div>
                                    <div class="separator bottom"></div>
                                </div>
                            </div>
                            <div class="ui-resizable-handle ui-resizable-e" style="z-index: 1000;"></div>
                        </div>

                        <div id="content">
                            <div class="box">
                                <div class="content tabs">
                                    <div class="layout" style="padding:0 10px;">
                                        <div class="tab-content even-height">
                                            <!--------------- Start - General Setings -------------------->

                                            <div id="tab_general_settings" class="tab-pane active">
                                                <form action="{$action}" id="cart-re-display-form" method="post">
                                                    <input type="hidden" name="enable_cart_redisplay" value="1" >
                                                </form>
                                                <form action="{$action}" name="popup" method="post" enctype="multipart/form-data" id="abandoncart_configuration_form">
                                                    <input type="hidden" name="abd_configuration_form" value="1" >
                                                    <div class="block">
                                                        <h4  class='velsof-tab-heading' style="font-size: 20px;" >{l s='General Settings' mod='abandonedcart'}</h4>
                                                        {if !$cart_redisplay}
                                                            <div class="alert alert-danger">{l s='Your Cart Re-display' mod='abandonedcart'} <i style="margin-top:3px;" class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="bottom" data-original-title="{l s='When disabled, customers won\'t be able to view previously added cart items upon login.' mod='abandonedcart'}"></i> {l s='setting is' mod='abandonedcart'} <b>{l s='OFF' mod='abandonedcart'}</b> {l s='due to which this plugin will not work. Click' mod='abandonedcart'} <a href="javascript:void(0)" onclick="$('#cart-re-display-form').submit();">{l s='here' mod='abandonedcart'}</a> {l s='to enable it.' mod='abandonedcart'}</div>
                                                        {/if}
                                                        <table class="form" style="width: 99%;">
                                                            <tr>
                                                                <td class="name settings"><span class="control-label">{l s='Enable/Disable' mod='abandonedcart'}: </span>
                                                                    <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enable/Disable this plugin' mod='abandonedcart'}"></i>
                                                                </td>
                                                                <td class="settings">
                                                                    <input type="hidden" value="0" name="velsof_abandoncart[enable]" />
                                                                    {if $velsof_abandoncart['enable'] eq 1}

                                                                        <div class="make-switch" data-on="primary" data-off="default">
                                                                            <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart[enable]" id="abandoncart_enable" checked="checked" />
                                                                        </div>

                                                                    {else}
                                                                        <div class="make-switch" data-on="primary" data-off="default">
                                                                            <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart[enable]" id="abandoncart_enable"/>
                                                                        </div>

                                                                    {/if}

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="name settings"><span class="control-label">{l s='Delete Customer Data On Delete Request' mod='abandonedcart'}: </span>
                                                                    <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="bottom" data-original-title="{l s='Enable/Disable to delete customer data on GDPR module delete request.' mod='abandonedcart'}"></i>
                                                                    <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='Enable/Disable to delete customer data on GDPR module delete request.' mod='abandonedcart'}</p>
                                                                </td>
                                                                <td class="settings">
                                                                    <input type="hidden" value="0" name="velsof_abandoncart[enable_delete]" />
                                                                    {if isset($velsof_abandoncart['enable_delete']) && $velsof_abandoncart['enable_delete'] eq 1}

                                                                        <div class="make-switch" data-on="primary" data-off="default">
                                                                            <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart[enable_delete]" id="abandoncart_delete_enable" checked="checked" />
                                                                        </div>

                                                                    {else}
                                                                        <div class="make-switch" data-on="primary" data-off="default">
                                                                            <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart[enable_delete]" id="abandoncart_delete_enable"/>
                                                                        </div>

                                                                    {/if}

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="name settings">
                                                                    <span>{l s='Mark Abandon Cart' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Time period after which the cart is assumed as abandon' mod='abandonedcart'}"></i>
                                                                    <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='If the delay is zero then the carts will be immediately added in abandoned carts list.' mod='abandonedcart'}</p>
                                                                </td>

                                                                <td class="settings">
                                                                    <div class="span2" style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="velsof_abandoncart[delay_days]" value="{$velsof_abandoncart['delay_days']|escape:'htmlall':'UTF-8'}"/> <span class="stg-sml-lbl">{l s='Day(s)' mod='abandonedcart'}</span></div>
                                                                    <div class="span2"><input class="required_entry hint_txt_inline int_txt" type="text" name="velsof_abandoncart[delay_hours]" value="{$velsof_abandoncart['delay_hours']|escape:'htmlall':'UTF-8'}"/> <span class="stg-sml-lbl">{l s='Hrs' mod='abandonedcart'}</span></div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="name settings">
                                                                    <span>{l s='Enable Auto Email' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Send reminder/discount emails automatically, after the delay set by you for corresponding emails.' mod='abandonedcart'}"></i>
                                                                </td>
                                                                <td class="settings">
                                                                    <input type="radio"  name="velsof_abandoncart[schedule]" value="1" style="margin-bottom: 7px;"  {if $velsof_abandoncart['schedule'] eq 1} checked="checked" {/if} /><b style="margin-left: 8px;">{l s='Yes' mod='abandonedcart'}</b>
                                                                    <input type="radio" style="margin-left: 10px; margin-bottom: 7px;" name="velsof_abandoncart[schedule]" value="0" {if $velsof_abandoncart['schedule'] eq 0} checked="checked" {/if} /><b style="margin-left: 8px;">{l s='No' mod='abandonedcart'}</b>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="name settings"><span class="control-label">{l s='Testing Mode' mod='abandonedcart'}: </span>
                                                                    <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enable this module to test mode' mod='abandonedcart'}"></i>
                                                                    <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='By enabling it ,all the email will send to a particular email id for testing purposes.' mod='abandonedcart'}</p>
                                                                </td>
                                                                <td class="settings">
                                                                    {if isset($velsof_abandoncart['enable_test']) && $velsof_abandoncart['enable_test'] eq 1}
                                                                        <div class="make-switch" data-on="primary" data-off="default">
                                                                            <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart[enable_test]" id="abandoncart_enable_test" checked="checked"/>
                                                                        </div>

                                                                    {else}
                                                                        <div class="make-switch" data-on="primary" data-off="default" >
                                                                            <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart[enable_test]" id="abandoncart_enable_test"/>
                                                                        </div>

                                                                    {/if}

                                                                </td>
                                                            </tr>
                                                            <tr class="vss_testing_html" {if !isset($velsof_abandoncart['enable_test']) || $velsof_abandoncart['enable_test']==0} style="display:none" {/if}>
                                                                <td class="name settings">
                                                                    <span>{l s='E-Mail ID' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enter the email id for testing mode' mod='abandonedcart'}"></i>
                                                                    <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='All the Abandoned cart email will be sent to this email id' mod='abandonedcart'}</p>
                                                                </td>

                                                                <td class="settings">
                                                                    <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart[testing_email_id]" value="{$velsof_abandoncart['testing_email_id']|escape:'htmlall':'UTF-8'}"/></div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        {* Start - Code Modified by RS on 06-Sept-2017 for adding the warning to configure the CRON jobs before enabling the module *}
                                                        <div id="cron_instructions">
                                                            {* Start - Code Added by RS on 06-Sept-2017 for adding the warning to configure the CRON jobs before enabling the module *}
                                                            <div class="alert alert-warning">
                                                                {l s='Please make sure you configure the CRON jobs as specified below before enabling the module on your store.' mod='abandonedcart'}
                                                                {l s='It is strongly recommended that the CRON jobs run once an hour.' mod='abandonedcart'}
                                                            </div>
                                                            {* End - Code Added by RS on 06-Sept-2017 for adding the warning to configure the CRON jobs before enabling the module *}
                                                            <div class="widget" id="cron_instructions" data-toggle="collapse-widget" style="margin: 15px 8px 0px 0px;{if $velsof_abandoncart['schedule'] eq 0} display:none;{/if} ">
                                                                <div class="widget-head" >
                                                                    <h3 class="heading" style='margin: 0px; height: 0px;'>{l s='Cron Instructions' mod='abandonedcart'}</h3>
                                                                </div>
                                                                <div class="widget-body" style="padding: 10px;">
                                                                    <p style="color:#A7A7A7; font-size: 13px; font-weight:normal;">
                                                                        {l s='Add the cron to your store via control panel/putty to send email to customer automatically according to your serial reminder settings. Find below the Instruction to add the cron.' mod='abandonedcart'}<br /><br />
                                                                        <b>{l s='URLs to Add to Cron via Control Panel' mod='abandonedcart'}</b><br>
                                                                        {$front_cron_url}cron=update_carts&secure_key={$secure_key}<br><br>
                                                                        {$front_cron_url}cron=send_mails&secure_key={$secure_key}<br><br>
                                                                        {*Start: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                                                                        {$front_cron_url}cron=send_push_notifications&secure_key={$secure_key}<br><br>
                                                                        {*End: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                                                                        <b>{l s='Cron setup via SSH' mod='abandonedcart'}</b><br />
                                                                        5 * * * * curl -O /dev/null '{$front_cron_url}cron=update_carts&secure_key={$secure_key}'<br /><br />
                                                                        11 * * * * curl -O /dev/null '{$front_cron_url}cron=send_mails&secure_key={$secure_key}'<br /><br />
                                                                        {*Start: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                                                                        15 * * * * curl -O /dev/null '{$front_cron_url}cron=send_push_notifications&secure_key={$secure_key}'<br /><br />
                                                                        {*End: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {* End - Code Modified by RS on 06-Sept-2017 for adding the warning to configure the CRON jobs before enabling the module *}
                                                    </div>
                                                </form>
                                            </div>
                                            <!--------------- End - General Settings -------------------->

                                            <!--------------- Start - Email Template -------------------->

                                            <div id="tab_email" class="tab-pane">
                                                <div id="tab_email_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading'>{l s='Email Templates' mod='abandonedcart'}</h4>
                                                    <div class="alert alert-info">{l s='To change template name, double click on corresponding name edit it and press enter key.' mod='abandonedcart'}</div>
                                                    <div id="etemplate-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:50px;">{l s='S.No.' mod='abandonedcart'}</th>
                                                                        <th>{l s='Name' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Name of the email template' mod='abandonedcart'}"></i></th>
                                                                        <th style="width:30%">{l s='Type' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Type of email template' mod='abandonedcart'}"></i></th>
                                                                        <th style="width:12%">{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="email_template_list_body">
                                                                    {if $email_templates['flag']}
                                                                        {$i = 0}
                                                                        {foreach $email_templates['data'] as $templ}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}" id="email_template_list_{$templ['id_template']|escape:'htmlall':'UTF-8'}" class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td id="email_template_row_id_{$templ['id_template']|escape:'htmlall':'UTF-8'}" class="right">{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="email_template_row_nm_{$templ['id_template']|escape:'htmlall':'UTF-8'}" data="{$templ['id_template']|escape:'htmlall':'UTF-8'}" class="cge_tmlte_cell">{$templ['name']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="email_template_row_type_{$templ['id_template']|escape:'htmlall':'UTF-8'}">{$templ['template_type_text']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="list_action_btn">
                                                                                    <a href="javascript:void(0)" onclick="openEmailTranslationPopup({$templ['id_template']|escape:'htmlall':'UTF-8'});" class="glyphicons edit"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to edit Translation' mod='abandonedcart'}"></i></a>
                                                                                    <a href="javascript:void(0)" onclick="remEmailTemplate({$templ['id_template']|escape:'htmlall':'UTF-8'});" class="glyphicons remove"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to delete' mod='abandonedcart'}"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="4" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="6" class="right">
                                                                            <img id="modal_email_template_load" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                                            <a onclick="loadNewEmailTemplate();" class="btn btn-success"><span>{l s='Add New' mod='abandonedcart'}</span></a>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                            <input id="etemplate_list_current_page" type="hidden" name="etemplate_list_current_page" value="1" />
                                                        </div>
                                                        <div id= "template_pagination" class="paginator-block block">
                                                            {$email_templates['pagination']}   
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget" id="email_template_variables" style="margin: 43px 8px 0px 0px;">
                                                    <div class="widget-head" >
                                                        <h3 class="heading" style='margin: 0px; height: 0px;'>{l s='Template Variables Definition' mod='abandonedcart'}</h3>
                                                    </div>
                                                    <div class="widget-body" style="padding: 10px;">
                                                        <p style="color:#777777; font-size: 13px; font-weight:normal;">
                                                        <div class="bootstrap row-no-display" style="display: block; margin-bottom: 5px;">
                                                            <div class="alert alert-warning" style="margin-bottom:0;">{l s='Below is a list of all the variables that are used in email templates in this plugin. While editing any mail template please keep in mind that you do not edit or remove any of them, you can only move them.' mod='abandonedcart'}</div>
                                                        </div>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{firstname}{/literal}</b> - {l s='Firstname of the customer going to receive the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{lastname}{/literal}</b> - {l s='Lastname of the customer going to receive the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{cart_content}{/literal}</b> - {l s='Content of the cart abandoned by the customer on your store listing all the products in the cart and links to the product pages. Also contains a button for Direct Checkout.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{discount_code}{/literal}</b> - {l s='Coupon code of the discount provided to the customer through the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{discount_value}{/literal}</b> - {l s='Value of the coupon code sent with the email to the customer. The value can be percentage or fixed amount.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{total_amount}{/literal}</b> - {l s='Minimum cart value that is required in order to use the coupon code sent in the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{date_end}{/literal}</b> - {l s='Date through which the coupon code in the email is valid.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{shop_name}{/literal}</b> - {l s='Name of your shop.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{shop_url}{/literal}</b> - {l s='Direct URL to your shop.' mod='abandonedcart'}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--------------- End - Email Template -------------------->

                                            <!--------------- Start - Incentive -------------------->

                                            <div id="tab_incentive" class="tab-pane">
                                                <div id="tab_incentive_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">

                                                    <h4 class='velsof-tab-heading'>{l s='Reminders List' mod='abandonedcart'}</h4>
                                                    <div class="alert alert-info">{l s='To enable/disable any reminder, just double click on corresponding status.' mod='abandonedcart'}</div>
                                                    <div id="inc-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table id='velsof_incentive' class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{l s='S.No.' mod='abandonedcart'}</th>
                                                                        <th>{l s='Template' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Email template which will be used with this incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Reminder Type' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Type of this incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Discount Value' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Actual amount of discount' mod='abandonedcart'}"></i></th>                                                                        
                                                                        <th>{l s='Coupon Validity' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Duration upto which coupon will remain active' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Status' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Status of the incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Delay' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='After what time the incentive email should be sent' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="incentive_list_body">
                                                                    {if $incentive_list['flag']}
                                                                        {$i = 0}
                                                                        {foreach $incentive_list['data'] as $inc}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}" id="incentive_list_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}" class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td id="incentive_row_id_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}" class="right">{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="incentive_row_nm_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['name']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="incentive_row_type_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['discount_type_txt']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="right" id="incentive_row_val_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['discount_value_txt']|escape:'htmlall':'UTF-8'}</td>                                                                                
                                                                                <td id="incentive_row_cvalid_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['coupon_validity_txt']|escape:'htmlall':'UTF-8'}</td>                                                                                
                                                                                <td id="incentive_row_stat_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}" data="{$inc['id_incentive']|escape:'htmlall':'UTF-8'}_{$inc['status']|escape:'htmlall':'UTF-8'}" class="ac_enable_disable_incentive">
                                                                                    <span class="{if $inc['status'] == 1}enabled_reminder_button">&#10004{else}disabled_reminder_button">&#10060{/if}&nbsp;{$inc['status_txt']|escape:'htmlall':'UTF-8'}</span>
                                                                                </td>
                                                                                <td id="incentive_row_dely_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['delay_txt']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="list_action_btn">
                                                                                    <a href="javascript:void(0)" onclick="editIncentive({$inc['id_incentive']|escape:'htmlall':'UTF-8'});" class="glyphicons edit"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to edit' mod='abandonedcart'}"></i></a>
                                                                                    <a href="javascript:void(0)" onclick="remIncentive({$inc['id_incentive']|escape:'htmlall':'UTF-8'});" class="glyphicons remove"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to delete' mod='abandonedcart'}"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="10" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr><td colspan="10" class="right">
                                                                            <img id="modal_incentive_form_load" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                                            <a onclick="editIncentive(0);" class="btn btn-success"><span>{l s='Add New' mod='abandonedcart'}</span></a>
                                                                        </td></tr>
                                                                </tfoot>
                                                            </table>
                                                            <input id="abd_incentive_list_current_page" type="hidden" name="abd_incentive_list_current_page" value="1" />
                                                        </div>
                                                        <div id= "reminder_pagination" class="paginator-block block">
                                                            {$incentive_list['pagination']|escape:'quotes':'UTF-8'}   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--------------- End - Incentive -------------------->


                                            <!--------------- Start - Popup Template -------------------->
                                            {*Start: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                                            <div id="tab_popup" class="tab-pane">
                                                <div id="tab_popup_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading'>{l s='Popup Templates' mod='abandonedcart'}</h4>
                                                    <div id="popup_template-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:50px;">{l s='S.No.' mod='abandonedcart'}</th>
                                                                        <th>{l s='Name' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Name of the Popup Template' mod='abandonedcart'}"></i></th>

                                                                        <th style="width:12%">{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="popup_template_list_body">
                                                                    {if $popup_templates['flag']}
                                                                        {$i = 0}
                                                                        {foreach $popup_templates['data'] as $templ}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}" id="email_template_list_{$templ['id_template']|escape:'htmlall':'UTF-8'}" class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td id="popup_template_row_id_{$templ['id_template']|escape:'htmlall':'UTF-8'}" class="right">{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="popup_template_row_nm_{$templ['id_template']|escape:'htmlall':'UTF-8'}" data="{$templ['id_template']|escape:'htmlall':'UTF-8'}" class="cge_tmlte_cell">{$templ['name']|escape:'htmlall':'UTF-8'}</td>

                                                                                <td class="list_action_btn">
                                                                                    <a href="javascript:void(0)" onclick="openPopupTemplateTranslationPopup({$templ['id_template']|escape:'htmlall':'UTF-8'});" class="glyphicons edit"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to edit Translation' mod='abandonedcart'}"></i></a>
                                                                                    <a href="javascript:void(0)" onclick="remPopupTemplate({$templ['id_template']|escape:'htmlall':'UTF-8'});" class="glyphicons remove"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to delete' mod='abandonedcart'}"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="4" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr>
                                                                        <td colspan="6" class="right">
                                                                            <img id="modal_popup_template_load" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                                            <a onclick="loadNewPopUpTemplate();" class="btn btn-success"><span>{l s='Add New' mod='abandonedcart'}</span></a>
                                                                        </td>
                                                                    </tr>
                                                                </tfoot>
                                                            </table>
                                                            <input id="popup_template_list_current_page" type="hidden" name="popup_template_list_current_page" value="1" />
                                                        </div>
                                                        <div id= "popup_template_pagination" class="paginator-block block">
                                                            {$popup_templates['pagination']}   
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="widget" id="email_template_variables" style="margin: 43px 8px 0px 0px;">
                                                    <div class="widget-head" >
                                                        <h3 class="heading" style='margin: 0px; height: 0px;'>{l s='Template Variables Definition' mod='abandonedcart'}</h3>
                                                    </div>
                                                    <div class="widget-body" style="padding: 10px;">
                                                        <p style="color:#777777; font-size: 13px; font-weight:normal;">
                                                        <div class="bootstrap row-no-display" style="display: block; margin-bottom: 5px;">
                                                            <div class="alert alert-warning" style="margin-bottom:0;">{l s='Below is a list of all the variables that are used in email templates in this plugin. While editing any mail template please keep in mind that you do not edit or remove any of them, you can only move them.' mod='abandonedcart'}</div>
                                                        </div>

                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{firstname}{/literal}</b> - {l s='Firstname of the customer going to receive the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{lastname}{/literal}</b> - {l s='Lastname of the customer going to receive the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{email}{/literal}</b> - {l s='Email of the customer going to receive the email.' mod='abandonedcart'}</span>
                                                        {*                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{checkout_button}{/literal}</b> - {l s='' mod='abandonedcart'}</span>*}
                                                        {*   <span style="display: block;margin-bottom: 5px;"><b>{literal}{logo}{/literal}</b> - {l s='Logo of your shop.' mod='abandonedcart'}</span>*}
                                                        {*                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{show_discount_box}{/literal}</b> - {l s='' mod='abandonedcart'}</span>*}
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{discount_from}{/literal}</b> - {l s='Start Date of the discount from which discount is valid' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{discount_to}{/literal}</b> - {l s='Date through which the coupon code in the email is valid.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{reduction}{/literal}</b> - {l s='How much discount will customer get.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{cart_content}{/literal}</b> - {l s='Content of the cart abandoned by the customer on your store listing all the products in the cart and links to the product pages. Also contains a button for Direct Checkout.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{discount_code}{/literal}</b> - {l s='Coupon code of the discount provided to the customer through the email.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{discount_value}{/literal}</b> - {l s='Value of the coupon code sent with the email to the customer. The value can be percentage or fixed amount.' mod='abandonedcart'}</span>
                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{total_amount}{/literal}</b> - {l s='Minimum cart value that is required in order to use the coupon code sent in the email.' mod='abandonedcart'}</span>
                                                        {*                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{date_end}{/literal}</b> - {l s='Date through which the coupon code in the email is valid.' mod='abandonedcart'}</span>*}
                                                        {*                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{shop_name}{/literal}</b> - {l s='Name of your shop.' mod='abandonedcart'}</span>*}
                                                        {*                                                        <span style="display: block;margin-bottom: 5px;"><b>{literal}{shop_url}{/literal}</b> - {l s='Direct URL to your shop.' mod='abandonedcart'}</span>*}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--------------- End - Popup Template -------------------->

                                            <!--------------- Start - Popup Reminder -------------------->

                                            <div id="tab_popup_reminder" class="tab-pane">
                                                <div id="tab_popup_incentive_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">

                                                    <h4 class='velsof-tab-heading'>{l s='Popup Reminders List' mod='abandonedcart'}</h4>
                                                    <div id="inc-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table id='velsof_incentive' class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{l s='S.No.' mod='abandonedcart'}</th>
                                                                        <th>{l s='Template' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Popup template which will be used with this incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Priority' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Priority of this reminder' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Discount Value' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Actual amount of discount' mod='abandonedcart'}"></i></th>                                                                        
                                                                        <th>{l s='Coupon Validity' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Duration upto which coupon will remain active' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Status' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Status of the incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Delay' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='After what time the incentive popup should display' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Date' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Which date popup displays' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="popup_incentive_list_body">
                                                                    {if $popup_reminder_incentive_list['flag']}
                                                                        {$i = 0}
                                                                        {foreach $popup_reminder_incentive_list['data'] as $inc}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}" id="incentive_list_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}" class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td id="popup_incentive_row_id_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}" >{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="popup_incentive_row_nm_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['name']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="popup_incentive_row_type_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['priority']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="popup_incentive_row_val_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['discount_value_txt']|escape:'htmlall':'UTF-8'}</td>                                                                                
                                                                                <td id="popup_incentive_row_cvalid_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['coupon_validity_txt']|escape:'htmlall':'UTF-8'}</td>                                                                                
                                                                                <td id="popup_incentive_row_stat_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}" data="{$inc['id_incentive']|escape:'htmlall':'UTF-8'}_{$inc['status']|escape:'htmlall':'UTF-8'}" class="ac_enable_disable_incentive">
                                                                                    <span class="{if $inc['status'] == 1}enabled_reminder_button">&#10004{else}disabled_reminder_button">&#10060{/if}&nbsp;{$inc['status_txt']|escape:'htmlall':'UTF-8'}</span>
                                                                                </td>
                                                                                <td id="popup_incentive_row_dely_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['frequency_hour']|escape:'htmlall':'UTF-8'} {l s='Hour' mod='abandonedcart'} &nbsp; {$inc['frequency_minutes']|escape:'htmlall':'UTF-8'} {l s='Minutes' mod='abandonedcart'} </td>
                                                                                <td id="popup_incentive_row_date_{$inc['id_incentive']|escape:'htmlall':'UTF-8'}">{$inc['date_from']|escape:'htmlall':'UTF-8'} - {$inc['date_to']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="list_action_btn">
                                                                                    <a href="javascript:void(0)" onclick="editPopupReminder({$inc['id_incentive']|escape:'htmlall':'UTF-8'});" class="glyphicons edit"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to edit' mod='abandonedcart'}"></i></a>
                                                                                    <a href="javascript:void(0)" onclick="remPopupIncentive({$inc['id_incentive']|escape:'htmlall':'UTF-8'});" class="glyphicons remove"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to delete' mod='abandonedcart'}"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="10" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr><td colspan="10" class="right">
                                                                            <img id="modal_popup_reminder_form_load" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                                            <a onclick="editPopupReminder(0);" class="btn btn-success"><span>{l s='Add New' mod='abandonedcart'}</span></a>
                                                                        </td></tr>
                                                                </tfoot>
                                                            </table>
                                                            <input id="abd_popup_incentive_list_current_page" type="hidden" name="abd_popup_incentive_list_current_page" value="1" />
                                                        </div>
                                                        <div id= "popup_reminder_pagination" class="paginator-block block">
                                                            {$incentive_list['pagination']|escape:'quotes':'UTF-8'}   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {*End: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                                            <!--------------- End - Popup Reminder -------------------->


                                            <!----------START: WEB BROWSER REMINDER ----------->
                                             {*Start: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                                            <div id="tab_web_broswer_reminder" class="tab-pane">
                                                <div id="tab_WebBrowser_incentive_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">

                                                    <h4 class='velsof-tab-heading'>{l s='WebBrowser Reminders List' mod='abandonedcart'}</h4>
                                                    <div id="inc-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table id='velsof_incentive' class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{l s='S.No.' mod='abandonedcart'}</th>
                                                                        <th>{l s='Name' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Push Notification template which will be used with this incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Discount Value' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Actual amount of discount' mod='abandonedcart'}"></i></th>                                                                        
                                                                        <th>{l s='Coupon Validity' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Duration upto which coupon will remain active' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Status' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Status of the incentive' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Delay' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='After what time the incentive popup should display' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Date' mod='abandonedcart'} <i class="icon-question-sign tooltip_color" data-toggle="tooltip" data-placement="top" data-original-title="{l s='Which date popup displays' mod='abandonedcart'}"></i></th>
                                                                        <th>{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="WebBrowser_incentive_list_body">
                                                                    {if $WebBrowser_reminder_incentive_list['flag']}
                                                                        {$i = 0}
                                                                        {foreach $WebBrowser_reminder_incentive_list['data'] as $inc}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}" id="incentive_list_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}" class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td id="WebBrowser_incentive_row_id_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}" class="right">{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="WebBrowser_incentive_row_nm_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}">{$inc['name']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td id="WebBrowser_incentive_row_val_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}">{$inc['discount_value_txt']|escape:'htmlall':'UTF-8'}</td>                                                                                
                                                                                <td id="WebBrowser_incentive_row_cvalid_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}">{$inc['coupon_validity_txt']|escape:'htmlall':'UTF-8'}</td>                                                                                
                                                                                <td id="WebBrowser_incentive_row_stat_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}" data="{$inc['id_reminder']|escape:'htmlall':'UTF-8'}_{$inc['status']|escape:'htmlall':'UTF-8'}" class="ac_enable_disable_incentive">
                                                                                    <span class="{if $inc['status'] == 1}enabled_reminder_button">&#10004{else}disabled_reminder_button">&#10060{/if}&nbsp;{$inc['status_txt']|escape:'htmlall':'UTF-8'}</span>
                                                                                </td>
                                                                                <td id="WebBrowser_incentive_row_dely_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}">{$inc['abandon_hour']|escape:'htmlall':'UTF-8'} {l s='Hour' mod='abandonedcart'} &nbsp; {$inc['abandon_min']|escape:'htmlall':'UTF-8'} {l s='Minutes' mod='abandonedcart'} </td>
                                                                                <td id="WebBrowser_incentive_row_date_{$inc['id_reminder']|escape:'htmlall':'UTF-8'}">{$inc['date_from']|escape:'htmlall':'UTF-8'} - {$inc['date_to']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="list_action_btn">
                                                                                    <a href="javascript:void(0)" onclick="editWebBrowserReminder({$inc['id_reminder']|escape:'htmlall':'UTF-8'});" class="glyphicons edit"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to edit' mod='abandonedcart'}"></i></a>
                                                                                    <a href="javascript:void(0)" onclick="remWebBrowserIncentive({$inc['id_reminder']|escape:'htmlall':'UTF-8'});" class="glyphicons remove"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to delete' mod='abandonedcart'}"></i></a>
                                                                                </td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="10" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                                <tfoot>
                                                                    <tr><td colspan="10" class="right">
                                                                            <img id="modal_WebBrowser_reminder_form_load" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                                            <a onclick="editWebBrowserReminder(0);" class="btn btn-success"><span>{l s='Add New' mod='abandonedcart'}</span></a>
                                                                        </td></tr>
                                                                </tfoot>
                                                            </table>
                                                            <input id="abd_WebBrowser_incentive_list_current_page" type="hidden" name="abd_WebBrowser_incentive_list_current_page" value="1" />
                                                        </div>
                                                        <div id="WebBrowser_reminder_pagination" class="paginator-block block">
                                                            {$incentive_list['pagination']|escape:'quotes':'UTF-8'}   
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!----------END: WEB BROWSER REMINDER ----------->

                                            <!--START: WEB REMINDER CONFIGURATION ADDED BY ANSHUL-->
                                            <div id="tab_fcm_configuration" class="tab-pane">
                                                <div class="block">


                                                    <form action="{$action}" name="popup" method="post" enctype="multipart/form-data" id="abandoncart_configuration_form_fcm">
                                                        <input type="hidden" name="abd_configuration_form_fcm" value="1" >
                                                        <div class="block">
                                                            <h4 class='velsof-tab-heading'>{l s='WebBrowser Configuration' mod='abandonedcart'}</h4>

                                                            <table class="form" style="width: 99%;">
                                                                <tr>
                                                                    <td class="name settings"><span class="control-label">{l s='Enable/Disable Notifications' mod='abandonedcart'}: </span>
                                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enable/Disable the Notifications' mod='abandonedcart'}"></i>
                                                                    </td>
                                                                    <td class="settings">
                                                                        <input type="hidden" value="0" name="velsof_abandoncart_fcm[enable_notify]" />
                                                                        {if $velsof_abandoncart_fcm['enable_notify'] eq 1}

                                                                            <div class="make-switch" data-on="primary" data-off="default">
                                                                                <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart_fcm[enable_notify]" checked="checked" />
                                                                            </div>

                                                                        {else}
                                                                            <div class="make-switch" data-on="primary" data-off="default">
                                                                                <input class="make-switch" type="checkbox" value="1" name="velsof_abandoncart_fcm[enable_notify]" />
                                                                            </div>

                                                                        {/if}

                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="name settings">
                                                                        <span class="required"> *</span><span>{l s='API Key' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[apiKey]" value="{$velsof_abandoncart_fcm['apiKey']|escape:'htmlall':'UTF-8'}"/>

                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;">
                                                                    <td class="name settings">
                                                                        <span>{l s='OAuth Domain' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[authDomain]" value="{$velsof_abandoncart_fcm['authDomain']|escape:'htmlall':'UTF-8'}" readonly/></div>
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;">
                                                                    <td class="name settings">
                                                                        <span>{l s='Database URL' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[databaseURL]" value="{$velsof_abandoncart_fcm['databaseURL']|escape:'htmlall':'UTF-8'}" readonly/></div>
                                                                    </td>
                                                                </tr>
                                                                <tr style="">
                                                                    <td class="name settings">
                                                                        <span class="required"> *</span><span>{l s='Project Id' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[projectId]" value="{$velsof_abandoncart_fcm['projectId']|escape:'htmlall':'UTF-8'}"/></div>
                                                                    </td>
                                                                </tr>
                                                                <tr style="display:none;">
                                                                    <td class="name settings">
                                                                        <span>{l s='Storage Bucket' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[storageBucket]" value="{$velsof_abandoncart_fcm['storageBucket']|escape:'htmlall':'UTF-8'}" readonly/></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="name settings">
                                                                        <span class="required"> *</span><span>{l s='Messaging Sender Id' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[messagingSenderId]" value="{$velsof_abandoncart_fcm['messagingSenderId']|escape:'htmlall':'UTF-8'}"/></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td class="name settings">
                                                                        <span class="required"> *</span><span>{l s='Server Key' mod='abandonedcart'}: </span><i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title=""></i>
                                                                    </td>

                                                                    <td class="settings">
                                                                        <div style="margin-left:0;"><input class="required_entry hint_txt_inline" type="text" name="velsof_abandoncart_fcm[server_key]" value="{$velsof_abandoncart_fcm['server_key']|escape:'htmlall':'UTF-8'}"/></div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="block" >
                                                    <div id="steps_to_configure_v3" class="panel steps_to_config_v3">
                                                        <div class="steps_panel-heading">
                                                            {l s='Steps To Configure FireBase API:' mod='abandonedcart'}
                                                        </div>
                                                        <br>
                                                        <div class="">
                                                            <div class="panel-group abandonedcart_step_accordion" id="abandonedcartv3_dropbox_accordion">
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse1">{l s='Firebase Console' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse1" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='Click on the link below.' mod='abandonedcart'}</b></pre>
                                                                            <p style="text-align: center;"><a href="https://console.firebase.google.com/" target="_blank">{l s='Click here to go to the Firebase Console.' mod='abandonedcart'}</a></p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse2">{l s='STEP 1' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse2" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='1. Click on Create a Project.' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step1.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse3">{l s='STEP 2' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse3" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='2. Enter your project name, check the terms & conditions & click on the continue button as pointed in the below screenshot.' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step2.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse4">{l s='STEP 3' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse4" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='3. Again click on the Continue button as pointed in the below screenshot.' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step3.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse5">{l s='STEP 4' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse5" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='4. Select your location. Hover on the ? mark to display the description and click on the continue button as pointed in the below screenshot.' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step4.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse6">{l s='STEP 5' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse6" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='5. Click on Continue again.' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step5.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse7">{l s='STEP 6' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse7" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='6. Click on Project Settings button as pointed in the below screenshot.' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step6.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse8">{l s='STEP 7' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse8" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='7. Copy the Project Id from here and paste it into [ Web Browser Configuration -> Project Id ].' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step7.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="panel panel-default">
                                                                    <div class="steps_panel-heading">
                                                                        <a data-toggle="collapse" data-parent="#abandonedcartv3_dropbox_accordion" href="#abandonedcartv3_step_collapse9">{l s='STEP 8, 9, 10' mod='abandonedcart'}</a>
                                                                    </div>
                                                                    <div id="abandonedcartv3_step_collapse9" class="panel-collapse collapse">
                                                                        <div class="panel-body">
                                                                            <pre><b>{l s='8. Copy the Server Key from here and paste it into [ Web Browser Configuration -> Server Key ].' mod='abandonedcart'}</b></pre>
                                                                            <pre><b>{l s='9. Copy the Legacy server key from here and paste it into [ Web Browser Configuration -> API Key ].' mod='abandonedcart'}</b></pre>
                                                                            <pre><b>{l s='10. Copy the Sender ID from here and paste it into [ Web Browser Configuration -> Messaging Sender Id ].' mod='abandonedcart'}</b></pre>
                                                                            <img src='{$image_path|escape:'htmlall':'UTF-8'}manual_steps/step8,9,10.png' />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                            {*End: Added by Anshul (Feature: Push Notification (Jan 2020))*}

                                            <!--END: -->

                                            <!--------------- Start - View Abandoned Cart -------------------->

                                            <div id="tab_cart" class="tab-pane">
                                                <div id="tab_abandon_list_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading' style="font-size: 20px;">
                                                        {l s='Abandoned Cart List' mod='abandonedcart'}
                                                        <div class="abd-pnl-topside">
                                                            <span style="width: 135px; float: left;">
                                                                <span style="float: left;"><label>{l s='Show' mod='abandonedcart'}: </label></span>									    
                                                                <span style="float: left;">
                                                                    <select name="carts_per_page" onchange="getAbandonedListonchange(this);">
                                                                        <option>10</option>
                                                                        <option>20</option>
                                                                        <option>50</option>
                                                                        <option>100</option>
                                                                        <option>200</option>
                                                                        <option>500</option>
                                                                    </select>
                                                                </span>
                                                            </span>
                                                            <!-- Start - Code Modified by RS for solving the problem of time delay on page load when there are a lot of carts  -->
                                                            <span style="float: right;"><a href="javascript:void(0)" onclick="getAbandonedList($('#abd_list_current_page').attr('value'), '1');" class="btn btn-block btn-primary">{l s='Refresh' mod='abandonedcart'}</a></span>
                                                            <!-- End - Code Modified by RS for solving the problem of time delay on page load when there are a lot of carts  -->
                                                        </div>
                                                    </h4>
                                                    <div id="abd-list-filters" class="block abd-tbl-filter-blk">
                                                        <h4>{l s='Filter By' mod='abandonedcart'}:</h4>
                                                        <div class="span">
                                                            <div class="f-label">{l s='Email' mod='abandonedcart'}: </div>
                                                            <div class="span1">
                                                                <select name="abd_filter_type">
                                                                    <option value="1">{l s='Equals To' mod='abandonedcart'}</option>
                                                                    <option value="2">{l s='Has Word' mod='abandonedcart'}</option>
                                                                </select>
                                                            </div>
                                                            <div class="span3">
                                                                <input type="text" name="abd_filter_type_email" value="" />
                                                            </div>
                                                        </div>
                                                        <div class="span2">
                                                            <select name="abd_filter_ctype">
                                                                <option value="">{l s='Choose Customer Type' mod='abandonedcart'}</option>
                                                                <option value="1">{l s='Registered' mod='abandonedcart'}</option>
                                                                <option value="2">{l s='Guest (without info)' mod='abandonedcart'}</option>
                                                                <option value="3">{l s='Guest (with info)' mod='abandonedcart'}</option>
                                                                <option value="4">{l s='Tracked Customers' mod='abandonedcart'}</option>
                                                            </select>
                                                        </div>
                                                        <div class="span1">
                                                            <a href="javascript:void(0)" onclick="getAbandonedList($('#abd_list_current_page').attr('value'));" class="btn btn-block btn-info">{l s='Search' mod='abandonedcart'}</a>
                                                        </div>
                                                        <div class="span1">
                                                            <a href="javascript:void(0)" onclick="resetAbandonedListFilter($('#abd_list_current_page').attr('value'));" class="btn btn-block btn-warning">{l s='Reset' mod='abandonedcart'}</a>
                                                        </div>
                                                        <div class="clearfix"></div>
                                                    </div>
                                                    <div id="abd-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th>{l s='S.No.' mod='abandonedcart'}</th>
                                                                        <th style="width:29%;">{l s='Customer' mod='abandonedcart'}</th>
                                                                        <th>{l s='Type' mod='abandonedcart'}</th>
                                                                        <th>{l s='Current Incentive' mod='abandonedcart'}</th>
                                                                        <th style="width:18%;">{l s='Last Visit' mod='abandonedcart'}</th>
                                                                        <th style="width:15%">{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="abandon_cart_list_body">
                                                                    {if $abandon_list['flag']}
                                                                        {$i = 0}
                                                                        {foreach $abandon_list['data'] as $customer_details}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td class="right">{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>
                                                                                    {if $customer_details['id_customer'] > 0}
                                                                                        <span class="tbl-cl-main-txt">{$customer_details['firstname']|escape:'htmlall':'UTF-8'}&nbsp;{$customer_details['lastname']|escape:'htmlall':'UTF-8'}</span>
                                                                                        <span class="tbl-cl-sub-txt">{$customer_details['email']|escape:'htmlall':'UTF-8'}</span>
                                                                                    {elseif isset($customer_details['tracked']) && ($customer_details['tracked'] == 1)}
                                                                                        {if $customer_details['firstname'] != 'ABC' && $customer_details['firstname'] != 'DEF'}
                                                                                            <span class="tbl-cl-main-txt">{$customer_details['firstname']|escape:'htmlall':'UTF-8'}&nbsp;{$customer_details['lastname']|escape:'htmlall':'UTF-8'}</span>
                                                                                        {else}
                                                                                            <span class="tbl-cl-main-txt">{l s='Guest Customer' mod='abandonedcart'}</span>
                                                                                        {/if}
                                                                                        <span class="tbl-cl-sub-txt">{$customer_details['email']|escape:'htmlall':'UTF-8'}</span>
                                                                                    {else}
                                                                                        <span class="tbl-cl-main-txt">{l s='Guest Customer' mod='abandonedcart'}</span>
                                                                                    {/if}
                                                                                    <span class="tbl-cl-sub-txt" style="display: block;">{l s='Language' mod='abandonedcart'}: {$customer_details['language_text']|escape:'htmlall':'UTF-8'}</span>
                                                                                </td>
                                                                                <td>{if $customer_details['is_guest'] eq 1} {l s='Guest' mod='abandonedcart'} {else} {l s='Registered' mod='abandonedcart'} {/if}</td>
                                                                                <td>
                                                                                    {if !$customer_details['has_coupon']}
                                                                                        {if isset($customer_details['reminder_sent']) && $customer_details['reminder_sent'] eq 1}
                                                                                            {l s='Reminder Sent' mod='abandonedcart'}
                                                                                        {else}
                                                                                            {l s='No Coupon code sent' mod='abandonedcart'}
                                                                                        {/if}
                                                                                    {else}
                                                                                        <a href="javascript:void(0)" onclick="displayCouponDetail({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, '{$customer_details['email']|escape:'htmlall':'UTF-8'}')">{l s='Coupon Details' mod='abandonedcart'}</a>
                                                                                    {/if}
                                                                                </td>
                                                                                <td>{$customer_details['date_upd']|escape:'htmlall':'UTF-8'}</td>
                                                                                {if $customer_details['id_customer'] <= 0}
                                                                                    <td class="list_action_btn">
                                                                                        {*Start: Changes done by Anshul to fix discount reminder sending issue even if email id is present*}
                                                                                        {*Start: Changes by Tarun to disable the manual buttons to send mails for unsubscribed customer*}
                                                                                        {if isset($customer_details['tracked']) && ($customer_details['tracked'] == 1)}
                                                                                            {if isset($customer_details['unsubscribed']) && ($customer_details['unsubscribed'] == 0)}
                                                                                                <a href="javascript:void(0)" onclick="displayReminderModal({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, {$customer_details['id_cart']|escape:'htmlall':'UTF-8'}, {$customer_details['id_abandon']|escape:'htmlall':'UTF-8'}, {$customer_details['id_lang']|escape:'htmlall':'UTF-8'})" class="glyphicons bell"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Send non discount E-mail to customer' mod='abandonedcart'}"></i></a>
                                                                                                <a href="javascript:void(0)" onclick="displayDisocuntEmailModal({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, {$customer_details['id_cart']|escape:'htmlall':'UTF-8'}, {$customer_details['id_abandon']|escape:'htmlall':'UTF-8'}, {$customer_details['id_lang']|escape:'htmlall':'UTF-8'})" class="glyphicons gift"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Send discount E-mail to customer' mod='abandonedcart'}"></i></a>    
                                                                                            {else}
                                                                                                <a href="javascript:void(0)" onclick="" class="glyphicons bell disabaled_glyphicons"><i data-toggle="tooltip" style="cursor: default;" data-placement="top" data-original-title="{l s='Customer unsubscribed himself' mod='abandonedcart'}"></i></a>
                                                                                                <a href="javascript:void(0)" onclick="" class="glyphicons gift disabaled_glyphicons"><i data-toggle="tooltip" style="cursor: default;" data-placement="top" data-original-title="{l s='Customer unsubscribed himself' mod='abandonedcart'}"></i></a>
                                                                                            {/if}
                                                                                        {else}
                                                                                            <a href="javascript:void(0)" onclick="" class="glyphicons bell disabaled_glyphicons"><i data-toggle="tooltip" style="cursor: default;" data-placement="top" data-original-title="{l s='Email Id not available for this customer' mod='abandonedcart'}"></i></a>
                                                                                            <a href="javascript:void(0)" onclick="" class="glyphicons gift disabaled_glyphicons"><i data-toggle="tooltip" style="cursor: default;" data-placement="top" data-original-title="{l s='Email Id not available for this customer' mod='abandonedcart'}"></i></a>
                                                                                        {/if}
                                                                                        {*End: Changes done by Anshul to fix discount reminder sending issue even if email id is present*}
                                                                                        <a href="javascript:void(0)" onclick="displayCartDetail({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, {$customer_details['id_cart']|escape:'htmlall':'UTF-8'})" class="glyphicons shopping_cart"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='View products in cart' mod='abandonedcart'}"></i></a>
                                                                                        <a type="{$customer_details['id_abandon']|escape:'htmlall':'UTF-8'}" onclick="deleteAbandon(this);" class="glyphicons remove"><i data-toggle="tooltip" data-placement="top" data-original-title="{l s='Click to remove this abandon cart' mod='abandonedcart'}"></i></a>
                                                                                    </td>
                                                                                {else}
                                                                                    <td class="list_action_btn">
                                                                                        {if isset($customer_details['unsubscribed']) && ($customer_details['unsubscribed'] == 0)}
                                                                                            <a href="javascript:void(0)" onclick="displayReminderModal({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, {$customer_details['id_cart']|escape:'htmlall':'UTF-8'}, {$customer_details['id_abandon']|escape:'htmlall':'UTF-8'}, {$customer_details['id_lang']|escape:'htmlall':'UTF-8'})" class="glyphicons bell"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Send non discount E-mail to customer' mod='abandonedcart'}"></i></a>
                                                                                            <a href="javascript:void(0)" onclick="displayDisocuntEmailModal({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, {$customer_details['id_cart']|escape:'htmlall':'UTF-8'}, {$customer_details['id_abandon']|escape:'htmlall':'UTF-8'}, {$customer_details['id_lang']|escape:'htmlall':'UTF-8'})" class="glyphicons gift"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Send discount E-mail to customer' mod='abandonedcart'}"></i></a>
                                                                                        {else}
                                                                                            <a href="javascript:void(0)" onclick="" class="glyphicons bell disabaled_glyphicons"><i data-toggle="tooltip" style="cursor: default;" data-placement="top" data-original-title="{l s='Customer unsubscribed himself' mod='abandonedcart'}"></i></a>
                                                                                            <a href="javascript:void(0)" onclick="" class="glyphicons gift disabaled_glyphicons"><i data-toggle="tooltip" style="cursor: default;" data-placement="top" data-original-title="{l s='Customer unsubscribed himself' mod='abandonedcart'}"></i></a>
                                                                                        {/if}
                                                                                        <a href="javascript:void(0)" onclick="displayCartDetail({$customer_details['id_customer']|escape:'htmlall':'UTF-8'}, {$customer_details['id_cart']|escape:'htmlall':'UTF-8'})" class="glyphicons shopping_cart"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='View products in cart' mod='abandonedcart'}"></i></a>
                                                                                        <a type="{$customer_details['id_abandon']|escape:'htmlall':'UTF-8'}" onclick="deleteAbandon(this);" class="glyphicons remove"><i data-toggle="tooltip" data-placement="top" data-original-title="{l s='Click to remove this abandon cart' mod='abandonedcart'}"></i></a>
                                                                                        {*End: Changes by Tarun to disable the manual buttons to send mails for unsubscribed customer*}
                                                                                    </td>
                                                                                {/if}                                                                                    
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="6" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                            </table>
                                                            <input id="abd_list_current_page" type="hidden" name="abd_list_current_page" value="1" />
                                                        </div>
                                                        <div class="paginator-block block right">
                                                            {$abandon_list['pagination']|escape:'quotes':'UTF-8'}  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!--------------- End - View Abandoned Cart -------------------->

                                            <!--------------- Start - Converted Cart List -------------------->
                                            <div id="tab_rate" class="tab-pane">
                                                <div id="tab_converted_list_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading' style="font-size: 20px;">{l s='Converted Cart List' mod='abandonedcart'}</h4>
                                                    <div id="converted-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:65px;">{l s='S. No' mod='abandonedcart'}</th>
                                                                        <th>{l s='Reference' mod='abandonedcart'}</th>
                                                                        <th style="width:20%;">{l s='Customer' mod='abandonedcart'}</th>
                                                                        <th style="width:23%;">{l s='Status' mod='abandonedcart'}</th>
                                                                        <th style="width:12%;">{l s='Order Total' mod='abandonedcart'}</th>
                                                                        <th style="width:18%;">{l s='Date & Time' mod='abandonedcart'}</th>
                                                                        <th style="width:9%">{l s='Actions' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="converted-list_body">
                                                                    {if $converted_carts['flag']}
                                                                        {$i = 0}
                                                                        {foreach $converted_carts['data'] as $convert}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td class="right">{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$convert['reference']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>
                                                                                    <span class="tbl-cl-main-txt">{$convert['firstname']|escape:'htmlall':'UTF-8'}&nbsp;{$convert['lastname']|escape:'htmlall':'UTF-8'}</span>
                                                                                    <span class="tbl-cl-sub-txt">{$convert['email']|escape:'htmlall':'UTF-8'}</span>
                                                                                </td>
                                                                                <td>{$convert['status']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="right">{$convert['formatted_total']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$convert['date_add']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="list_action_btn center"><a href="{$convert['order_url']}" target="_blank" class="glyphicons riflescope"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Click to view order detail' mod='abandonedcart'}"></i></a></td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="7" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                            </table>
                                                            <input id="converted_list_current_page" type="hidden" name="converted_list_current_page" value="1" />
                                                        </div>
                                                        <div class="paginator-block block right">
                                                            {$converted_carts['pagination']|escape:'quotes':'UTF-8'}  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--------------- End - Converted Cart List ------------------>

                                            <!--------------- Start - Converted Cart List -------------------->
                                            <!-- Added By Anshul -->
                                            <div id="tab_web_push_click_list" class="tab-pane">
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading' style="font-size: 20px;">{l s='Clicked Notification Data' mod='abandonedcart'}</h4>
                                                    <div id="converted-list-block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:20px;">{l s='S. No' mod='abandonedcart'}</th>
                                                                        <th style="width:20%;">{l s='Reminder Name' mod='abandonedcart'}</th>
                                                                        <th style="width:20%;">{l s='Clicked' mod='abandonedcart'}</th>
                                                                        <th style="width:20%;">{l s='Sent At' mod='abandonedcart'}</th>
                                                                        <th style="width:20%">{l s='View Cart' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="converted-list_body">
                                                                    {if isset($getclickpushdata[0]['flag'])}
                                                                        {$i = 0}
                                                                        {foreach $getclickpushdata as $convert}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td >{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$convert['reminder_name']|escape:'htmlall':'UTF-8'}</td>

                                                                                <td>{$convert['is_clicked']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$convert['sent_at']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td ><a href="{$convert['cart_link']}" target="_blank" class="glyphicons riflescope"><i data-toggle="tooltip"  data-placement="top" data-original-title="{l s='View Cart' mod='abandonedcart'}">{$convert['id_cart']}</i></a></td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="7" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--------------- End - Converted Cart List ------------------>

                                            <!--------------- Start - Analytics -------------------->

                                            <div id="tab_analytics" class="tab-pane" style='width:98.7%'>
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading' style="font-size: 20px;">{l s='Analytics' mod='abandonedcart'}</h4>
                                                    {* Start - Code added by RS on 07-Sept-2017 for adding a button to update cart totals in case the module has been updated *}
                                                    {if $cart_total_column_added}
                                                        <div class="alert alert-warning">
                                                            {l s='Since you have updated the module from an older version, please click on the following button to update the Analytics data. The process might take some time depedning upon the number of Abandoned Carts in your store.' mod='abandonedcart'}
                                                        </div>
                                                        <a style="text-decoration: none;" href="{$front_cron_url|escape:'htmlall':'UTF-8'}cron=update_analytics&secure_key={$secure_key|escape:'htmlall':'UTF-8'}" target="_blank">
                                                            <span class="btn btn-block btn-success action-btn" style="text-shadow: none;">{l s='Update Analytics Data' mod='abandonedcart'}</span>
                                                        </a>
                                                    {else}
                                                        <div class="row">
                                                            <div class="widget" id="pieChartHolder1">
                                                                <div class="widget-head">
                                                                    <h4 class="heading" style="font-size: 1.2em;">{l s='Abandoned vs Converted Carts' mod='abandonedcart'}</h4>
                                                                </div>
                                                                <div class="widget-body">
                                                                    <div id="placeholder"></div>
                                                                </div>
                                                            </div>

                                                            <div class="widget" id="pieChartHolder2">
                                                                <div class="widget-head">
                                                                    <h4 class="heading" style="font-size: 1.2em;">{l s='Abandoned vs Converted Amount' mod='abandonedcart'}</h4>
                                                                </div>
                                                                <div class="widget-body">
                                                                    <input type="hidden" name="vss_format_currency_helper" id="vss_format_currency_helper" value="0">
                                                                    <div id="placeholder2"></div>
                                                                </div>
                                                            </div>

                                                            <div class="widget">
                                                                <div class="widget-head">
                                                                    <h4 class="heading" style="font-size: 1.2em;">{l s='Carts Count Vs Days' mod='abandonedcart'}</h4>
                                                                </div>
                                                                <div class="widget-body" style="height: 550px;">
                                                                    <table style="margin: 16px 0px 0px 37px;">
                                                                        <tr>
                                                                            <td style='width: 10%; text-align: right;' >
                                                                                <label>{l s='Start date' mod='abandonedcart'}: &nbsp;</label>
                                                                            </td>
                                                                            <td style="width:20%">
                                                                                <input type="text" value="{$start_date|escape:'htmlall':'UTF-8'}" class="datepicker" id="date-start" name="velsof_abandoncart[start_date]"  />
                                                                            </td>

                                                                            <td style='width: 10%; text-align: right;'>
                                                                                <label>{l s='End date' mod='abandonedcart'}: &nbsp;</label>
                                                                            </td>
                                                                            <td style="width:20%">
                                                                                <input type="text" value="{$end_date|escape:'htmlall':'UTF-8'}" class="datepicker" id="date-end" name="velsof_abandoncart[end_date]"  />
                                                                            </td>
                                                                            <td style='padding: 0px 0px 11px 46px;'>
                                                                                <a style='width: 30%; height: 27px;' id="velsof_filter" onClick="generateGraph();" class="btn btn-default">{l s='Filter' mod='abandonedcart'}</a>
                                                                                {* Start - Code added by RS on 07-Sept-2017 for adding a loader when the Graph is being rendered *}
                                                                                <img id="abd_analytics_loader" src="{str_replace('admin/', '', $image_path)|escape:'htmlall':'UTF-8'}loading16.gif" style="display: none;">
                                                                                {* End - Code added by RS on 07-Sept-2017 for adding a loader when the Graph is being rendered *}
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <div id='error_date' style='color:red; text-align: center;'></div>
                                                                    <div id="graph_loader" style="display:block;width:98%;text-align:center;margin:10px;"><div id="flot-placeholder"></div></div>
                                                                    <div id="graph_loader_legend"></div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    {/if}
                                                    {* End - Code added by RS on 07-Sept-2017 for adding a button to update cart totals in case the module has been updated *}
                                                </div>
                                                <!--------------- End - Analyitcs -------------------->						    
                                            </div>



                                            <!--------------- Start - - Cron Log -------------------->
                                            {*Start: Added By Shubham (Feature: Cron Log (Jan 2020))*}
                                            <div id="tab_cron_log" class="tab-pane">
                                                <div id="tab_cron_log_msg_bar" class="modal_process_status_blk alert"></div>
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading' style="font-size: 20px;">{l s='Cron log' mod='abandonedcart'}</h4>
                                                    <div id="cron_log_block" class="abd-bigldr-blk">
                                                        <div class="tbl-blk">
                                                            <div class="abd-bigloader"></div>
                                                            <table class="pure-table">
                                                                <thead>
                                                                    <tr>
                                                                        <th style="width:65px;">{l s='S No.' mod='abandonedcart'}</th>
                                                                        <th style="width:5%;">{l s='Cron ID' mod='abandonedcart'}</th>
                                                                        <th style="width:15%;">{l s='Name' mod='abandonedcart'}</th>
                                                                        <th style="width:10%;">{l s='Type' mod='abandonedcart'}</th>
                                                                        <th style="width:12%;">{l s='Status' mod='abandonedcart'}</th>
                                                                        <th style="width:18%;">{l s='Start Time' mod='abandonedcart'}</th>
                                                                        <th style="width:18%">{l s='End Time' mod='abandonedcart'}</th>
                                                                        <th style="width:12%">{l s='Action' mod='abandonedcart'}</th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody id="cron-list_body">

                                                                    {if $cron_list['flag']}
                                                                        {$i = 0}
                                                                        {foreach $cron_list['data'] as $cron}
                                                                            <tr class="pure-table-{if $i%2 == 0}even{else}odd{/if}">
                                                                                <td>{($i+1)|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$cron['id_cron']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>
                                                                                    <span class="tbl-cl-main-txt">{$cron['name']|escape:'htmlall':'UTF-8'}</span>
                                                                                    {*                                                                                        <span class="tbl-cl-sub-txt">{$cron['type']|escape:'htmlall':'UTF-8'}</span>*}
                                                                                </td>
                                                                                <td>{$cron['type']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$cron['status']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="right">{$cron['start_time']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td>{$cron['end_time']|escape:'htmlall':'UTF-8'}</td>
                                                                                <td class="list_action_btn center">
                                                                                    <button type="button" onclick="loadCronPopUp({$cron['id_cron']});" class="btn btn-primary">{l s='View cron details' mod='abandonedcart'}</button>  
                                                                                </td>
                                                                            </tr>
                                                                            {$i = $i+1}
                                                                        {/foreach}
                                                                    {else}
                                                                        <tr class="pure-table-odd empty-tbl">
                                                                            <td colspan="7" class="center"><span>{l s='List is empty' mod='abandonedcart'}</span></td>
                                                                        </tr>
                                                                    {/if}
                                                                </tbody>
                                                            </table>
                                                            <input id="cron_list_current_page" type="hidden" name="cron_list_current_page" value="1" />
                                                        </div>
                                                        <div class="cron_pagination paginator-block block right">
                                                            {$cron_list['pagination']|escape:'quotes':'UTF-8'}  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {*End: Added By Shubham (Feature: Cron Log (Jan 2020))*}
                                            <!--------------- End - Cron Log ------------------>



                                            <!--------------- Start - Frequently Asked Questions -------------------->

                                            <div id="tab_faq" class="tab-pane">
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading'>{l s='Frequently Asked Questions (Click to expand)' mod='abandonedcart'}</h4>
                                                    <div class="row faq-row" id="1">
                                                        <div class="span faq-span" id="faq-span1">
                                                            <p style="margin-bottom: 0; margin-right: 5px">
                                                                <span class="question" style="font-weight: bold; font-size: 15px;">{l s='1. Is it compulsary to use CRON?' mod='abandonedcart'}</span><br><br>
                                                                <span class="answer" id="answer1" style="color: black;">
                                                                    {l s='We understand that you may be uncomfortable with CRON configuration therefore this module has an option to update abandoned cart list and send reminder emails manually. But we recommend all to use CRON as in case of large amount of abandoned carts, it is not possible for admin to send emails manually.' mod='abandonedcart'}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row faq-row" id="2">
                                                        <div class="span faq-span" id="faq-span2">
                                                            <p style="margin-bottom: 0; margin-right: 5px">
                                                                <span class="question" style="font-weight: bold; font-size: 15px;">{l s='2. How will I know if some customer places order using coupon code from abandoned cart email?' mod='abandonedcart'}</span><br><br>
                                                                <span class="answer" id="answer2" style="color: black;">
                                                                    {l s='You can check complete order information of such customers in "Converted lists" tab of our admin panel.' mod='abandonedcart'}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row faq-row" id="3">
                                                        <div class="span faq-span" id="faq-span3">
                                                            <p style="margin-bottom: 0; margin-right: 5px">
                                                                <span class="question" style="font-weight: bold; font-size: 15px;">{l s='3. Is it compulsary to enable "Redisplay cart at login"?' mod='abandonedcart'}</span><br><br>
                                                            <div class="answer" id="answer3" style="color: black;">
                                                                {l s='No, it is not compulsary but there is a drawback and 0 benefit for not enabling it therefore it is highly recommended to enable it.' mod='abandonedcart'}<br>
                                                                <br> {l s='If a customer logins to your store, he will not find his previously added products in the cart and everytime he abandones a cart, a new entry will be made for him in abandoned cart list.' mod='abandonedcart'}
                                                            </div>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row faq-row" id="4">
                                                        <div class="span faq-span" id="faq-span4">
                                                            <p style="margin-bottom: 0; margin-right: 5px">
                                                                <span class="question" style="font-weight: bold; font-size: 15px;">{l s='4. How many serial reminders should I setup for best result?' mod='abandonedcart'}</span><br><br>
                                                                <span class="answer" id="answer4" style="color: black;">
                                                                    {l s='It has been found that three abandoned cart messages increased revenue by 56 percent, versus sending just one but there is no hard and fast rule for this. Testing is always a best way to determine what fits best for you.' mod='abandonedcart'} 
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="row faq-row" id="5">
                                                        <div class="span faq-span" id="faq-span5">
                                                            <p style="margin-bottom: 0; margin-right: 5px">
                                                                <span class="question" style="font-weight: bold; font-size: 15px;">{l s='5.  I need your help, can I contact you?' mod='abandonedcart'}</span><br><br>
                                                                <span class="answer" id="answer5" style="color: black;">
                                                                    {l s='Yes, if you have any query or facing some issue, don\'t hesitate to raise a ticket for the same.' mod='abandonedcart'}
                                                                </span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>    
                                            </div>

                                            <!--------------- End - Frequently Asked Questions -------------------->

                                            <!--------------- Start - Suggestions Tab -------------------->

                                            <div id="tab_suggest" class="tab-pane">
                                                <div class="block">
                                                    <h4 class='velsof-tab-heading' style="font-size: 20px;">{l s='Suggestions' mod='abandonedcart'}</h4>
                                                    <div style= "  text-align:center;padding: 25px; height:140px;margin: 40px;margin-bottom:0px; background: aliceblue;">
                                                        <div><span style="font-size:18px;" >{l s='Want us to include some feature in next version of this module?' mod='abandonedcart'}</span>
                                                            <br>
                                                            <br>
                                                            <a style="text-decoration:none;" target="_blank" href="http://addons.prestashop.com/ratings.php"><span style="margin-left:30%;max-width:40% !important;font-size:18px;" class='btn btn-block btn-success action-btn'>{l s='Share your idea' mod='abandonedcart'}</span></a><div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div style="margin-left:40px;color:rgb(240, 29, 53);"><br>*** &nbsp; {l s='If you like our module, don\'t forget to give us 5 STAR rating on the above link. This will definitely boost our morale.' mod='abandonedcart'}</div>          
                                                    <!--------------- End - Suggestions Tab -------------------->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Start - Email Template Pop up -->
                    <div class="modal fade" id="modal_email_template" tab-index="-1" aria-hidden="true" aria-labelledby="modal-email">
                        <div class="modal-dialog" style="width:70%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="closeTemplatePopup()"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body" style="padding-bottom:0;">
                                    <div class="row row-no-display">
                                        <div class="span" style="margin-left:0; width:86%;">
                                            <div id="modal_email_template_process_status" class="modal_process_status_blk alert" style="display:none;"></div>
                                        </div>
                                    </div>
                                    <form id="email_template_editor_form" style="margin-bottom:0;">
                                        <div class="bootstrap row-no-display">
                                            <div class="alert alert-warning" style="margin-bottom:0;">{l s='This template will be saved for all translations in system. Later, you can edit this template for each translation one by one according to your needs.' mod='abandonedcart'}</div>
                                        </div>
                                        <input id="email_template_form_key" type="hidden" name="email_template[id_template]" value=""/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Select Type' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Type of the email. Non discount email type will be considered as reminder email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $email_types as $key => $text}
                                                                <span class="radio"><input class="inline" {if $non_discount_email_value neq $key}id="rd-temp-type-dis" checked="checked"{else}id="rd-temp-type-ndis"{/if} type="radio" onclick="getEmailTemplateToEdit();" name="email_template[type]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Template Name' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Name of the template. Please make sure template name should be unique.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6"><input class="required_entry" id="email_template_name_inp" type="text" name="email_template[name]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Cart Template' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Choose the cart template design' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='The preview shown below is only related to the cart content of the email(Not the whole email template)' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <select id="vss_cart_template" name="email_template[cart_template]" onchange="cart_preview(this);">
                                                                <option value='1'>{l s='Cart Template 1' mod='abandonedcart'}</option>
                                                                <option value='2'>{l s='Cart Template 2' mod='abandonedcart'}</option>
                                                                <option value='3'>{l s='Cart Template 3' mod='abandonedcart'}</option>
                                                                <option value='4'>{l s='Cart Template 4' mod='abandonedcart'}</option>
                                                                <option value='5'>{l s='Cart Template 5' mod='abandonedcart'}</option>
                                                                <option value='6'>{l s='Cart Template 6' mod='abandonedcart'}</option>
                                                                <option value='7'>{l s='Cart Template 7' mod='abandonedcart'}</option>
                                                                <option value='8'>{l s='Cart Template 8' mod='abandonedcart'}</option>
                                                                <option value='9'>{l s='Cart Template 9' mod='abandonedcart'}</option>
                                                                <option value='10'>{l s='Cart Template 10' mod='abandonedcart'}</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Subject' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Subject of the email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6"><input class="required_entry" id="email_template_subject_inp" type="text" name="email_template[subject]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Content of the email which will be sent to customers.' mod='abandonedcart'}"></i>
                                                        <div class="widget" style="margin: 25px auto;">
                                                            <div class="widget-head">
                                                                <h3 class="heading" style='margin: 0px; height: 0px;margin-left:24%;'>{l s='CART CONTENT PREVIEW' mod='abandonedcart'}</h3>
                                                            </div>
                                                            <div class="widget-body" style="padding: 10px;text-align:center;">
                                                                <img id="vss_cart_image" style="border:1px solid gray;" src='{$image_path}cart_image_1.png'>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ac_modal_form_field" style="padding-top:2%;vertical-align: top;">
                                                        <div class="span"><textarea style="height:100%;" id="email_template_body_inp_editor" name="email_template[body]" class="autoload_rte"  rows="10"></textarea></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <button type="button" onclick="closeTemplatePopup()" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="saveEmailTemplate(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_email_template_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Email Template Pop up -->

                    <!-- Start - Popup Template Pop up -->
                    {*Start: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                    <div class="modal fade" id="modal_popup_template" tab-index="-1" aria-hidden="true" aria-labelledby="modal-popup">
                        <div class="modal-dialog" style="width:70%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="closeTemplatePopupFront()"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body" style="padding-bottom:0;">

                                    <form id="popup_template_editor_form" style="margin-bottom:0;">
                                        <div class="bootstrap row-no-display">
                                            <div class="alert alert-warning" style="margin-bottom:0;">{l s='This template will be saved for all translations in system. Later, you can edit this template for each translation one by one according to your needs.' mod='abandonedcart'}</div>
                                        </div>
                                        <input id="popup_template_form_key" type="hidden" name="popup_template[id_template]" value=""/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">

                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Template Name' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Name of the template. Please make sure template name should be unique.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6"><input class="required_entry" id="popup_template_name_inp" type="text" name="popup_template[name]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Cart Template' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Choose the cart template design' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='The preview shown below is only related to the cart content of the email(Not the whole email template)' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <select id="popup_cart_template" name="popup_template[cart_template]" onchange="popup_cart_preview(this);">
                                                                <option value='1'>{l s='Cart Template 1' mod='abandonedcart'}</option>
                                                                <option value='2'>{l s='Cart Template 2' mod='abandonedcart'}</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Popup Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Content of the Popup which will be sent to customers.' mod='abandonedcart'}"></i>
                                                        <div class="widget" style="margin: 25px auto;">
                                                            <div class="widget-head">
                                                                <h3 class="heading" style='margin: 0px; height: 0px;margin-left:24%;'>{l s='CART CONTENT PREVIEW' mod='abandonedcart'}</h3>
                                                            </div>
                                                            <div class="widget-body" style="padding: 10px;text-align:center;">
                                                                <img id="popup_cart_image" style="border:1px solid gray;" src='{$image_path}cart_image_1.png'>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ac_modal_form_field" style="padding-top:2%;vertical-align: top;">
                                                        <div class="span"><textarea style="height:100%;" id="popup_template_body_inp_editor" name="popup_template[body]" class="autoload_rte"  rows="10"></textarea></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <button type="button" onclick="closeTemplatePopupFront()" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="savePopUpTemplate(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_popup_template_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    {*End: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                    <!-- End - Front Popup Template Pop up -->

                    <!-- Start - Email Template Translation Pop up -->
                    <div class="modal fade" id="modal_email_template_translation" tab-index="-1" aria-hidden="true" aria-labelledby="modal-email">
                        <div class="modal-dialog" style="width:70%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close"  onclick="closeTemplateTranslationPopup();"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body" style="padding-bottom:0;">
                                    <div class="row row-no-display">
                                        <div class="span" style="margin-left:0; width:86%;">
                                            <div id="modal_email_template_translation_process_status" class="modal_process_status_blk alert" style="display:none;"></div>
                                        </div>
                                    </div>
                                    <form id="email_template_translation_editor_form" style="margin-bottom:0;">
                                        <input type="hidden" name="email_template_translation[id_template]" value=""/>
                                        <input type="hidden" name="email_template_translation[id_template_content]" value=""/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Select translation' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Language of the email' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span3">
                                                            <select name="email_template_translation[id_lang]" onchange="getEmailTemplateTranslation($(this).val());">
                                                                <option value='0'>{l s='Select translation' mod='abandonedcart'}</option>
                                                                {foreach $languages as $val}
                                                                    <option value='{$val['id_lang']|escape:'htmlall':'UTF-8'}'>{$val['name']|escape:'htmlall':'UTF-8'}</option>
                                                                {/foreach}
                                                            </select>
                                                            <img id="template_translation_loader" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Cart Template' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Choose the cart template design' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='The preview shown below is only related to the cart content of the email(Not the whole email template)' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field" >
                                                        <div class="span">
                                                            <select name="email_template_translation[cart_template]" onchange="cart_preview(this);">
                                                                <option value='1'>{l s='Cart Template 1' mod='abandonedcart'}</option>
                                                                <option value='2'>{l s='Cart Template 2' mod='abandonedcart'}</option>
                                                                <option value='3'>{l s='Cart Template 3' mod='abandonedcart'}</option>
                                                                <option value='4'>{l s='Cart Template 4' mod='abandonedcart'}</option>
                                                                <option value='5'>{l s='Cart Template 5' mod='abandonedcart'}</option>
                                                                <option value='6'>{l s='Cart Template 6' mod='abandonedcart'}</option>
                                                                <option value='7'>{l s='Cart Template 7' mod='abandonedcart'}</option>
                                                                <option value='8'>{l s='Cart Template 8' mod='abandonedcart'}</option>
                                                                <option value='9'>{l s='Cart Template 9' mod='abandonedcart'}</option>
                                                                <option value='10'>{l s='Cart Template 10' mod='abandonedcart'}</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Subject' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Subject of the email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6"><input class="required_entry" type="text" name="email_template_translation[subject]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Content of the email which will be sent to customers.' mod='abandonedcart'}"></i>
                                                        <div class="widget" style="margin: 25px auto;">
                                                            <div class="widget-head" style="text-align:center;">
                                                                <h3 class="heading" style='margin: 0px; height: 0px;margin-left:24%;'>{l s='CART CONTENT PREVIEW' mod='abandonedcart'}</h3>
                                                            </div>
                                                            <div class="widget-body" style="padding: 10px;text-align:center;">
                                                                <img id="vss_cart_image_template" style="border:1px solid gray;" src=''>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ac_modal_form_field" style="vertical-align: top;">
                                                        <div class="span"><textarea  id="email_template_translation_body_inp_editor" name="email_template_translation[body]" class="autoload_rte"  rows="10"></textarea></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <button type="button" onclick="closeTemplateTranslationPopup();" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="saveEmailTemplateTranslation(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_email_template_translation_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Email Template Translation Pop up -->

                    <!-- Start - Popup Template Translation Pop up -->
                    {*Start: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                    <div class="modal fade" id="modal_popup_template_translation" tab-index="-1" aria-hidden="true" aria-labelledby="modal-email">
                        <div class="modal-dialog" style="width:70%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close"  onclick="closePopupTemplateTranslationPopup();"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body" style="padding-bottom:0;">
                                    <div class="row row-no-display">
                                        <div class="span" style="margin-left:0; width:86%;">
                                            <div id="modal_popup_template_translation_process_status" class="modal_process_status_blk alert" style="display:none;"></div>
                                        </div>
                                    </div>
                                    <form id="popup_template_translation_editor_form" style="margin-bottom:0;">
                                        <input type="hidden" name="popup_template_translation[id_template]" value=""/>
                                        <input type="hidden" name="popup_template_translation[id_template_content]" value=""/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Select translation' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Language of the Popup Template' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span3">
                                                            <select name="popup_template_translation[id_lang]" onchange="getPopupTemplateTranslation($(this).val());">
                                                                <option value='0'>{l s='Select translation' mod='abandonedcart'}</option>
                                                                {foreach $languages as $val}
                                                                    <option value='{$val['id_lang']|escape:'htmlall':'UTF-8'}'>{$val['name']|escape:'htmlall':'UTF-8'}</option>
                                                                {/foreach}
                                                            </select>
                                                            <img id="template_translation_loader" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Template Name' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Name of the Template.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6" id="tab_popup_msg_bar"><input class="required_entry" type="text" name="popup_template_translation[subject]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Cart Template' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Choose the cart template design' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='The preview shown below is only related to the cart content of the email(Not the whole email template)' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field" >
                                                        <div class="span">
                                                            <select name="popup_template_translation[cart_template]" onchange="popup_cart_preview(this);">
                                                                <option value='1'>{l s='Cart Template 1' mod='abandonedcart'}</option>
                                                                <option value='2'>{l s='Cart Template 2' mod='abandonedcart'}</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Popup Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Content of the Popup which will be display on the front.' mod='abandonedcart'}"></i>
                                                        <div class="widget" style="margin: 25px auto;">
                                                            <div class="widget-head">
                                                                <h3 class="heading" style='margin: 0px; height: 0px;margin-left:24%;'>{l s='CART CONTENT PREVIEW' mod='abandonedcart'}</h3>
                                                            </div>
                                                            <div class="widget-body" style="padding: 10px;text-align:center;">
                                                                <img id="popup_cart_image_template" style="border:1px solid gray;" src='{$image_path}cart_image_1.png'>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="ac_modal_form_field" style="vertical-align: top;">
                                                        <div class="span"><textarea  id="popup_template_translation_body_inp_editor" name="popup_template_translation[body]" class="autoload_rte"  rows="10"></textarea></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <button type="button" onclick="closePopupTemplateTranslationPopup();" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="savePopupTemplateTranslation(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_popup_template_translation_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    {*End: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                    <!-- End - Popup Template Translation Pop up -->

                    <!-- Start - Incentive Form Pop up -->
                    <div class="modal fade" id="modal_incentive_form" tab-index="-1" aria-hidden="true" aria-labelledby="modal-incentive-form">
                        <div class="modal-dialog" style="width:50%">
                            <div class="modal-content">
                                <div class="modal-body" style="padding-bottom:0;">
                                    <div class="row">
                                        <div class="span" style="margin-left:0; width:100%;">
                                            <div id="modal_incentive_form_process_status" class="modal_process_status_blk alert" style="display:none;"></div>
                                        </div>
                                    </div>
                                    <form id="modal_incentive_form_editor" style="margin-bottom:0;">
                                        <input id="modal_incentive_form_key" type="hidden" name="incentive[id_incentive]" value="0"/>
                                        <input id="modal_incentive_type" type="hidden" name="incentive[incentive_type]" value="0"/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Template Name' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Name of the template used with this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span5">
                                                            <select class="dropdn_templates" name="incentive[id_template]" onchange="checkTemplateType(this)">
                                                                <option value='0'>{l s='Select template' mod='abandonedcart'}</option>
                                                                {if count($dropdown_template_list) > 0}
                                                                    {foreach $dropdown_template_list as $templ}
                                                                        <option value='{$templ['id_template']|escape:'htmlall':'UTF-8'}'>{$templ['name']|escape:'htmlall':'UTF-8'}</option>
                                                                    {/foreach}
                                                                {/if}
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Type' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Type of the discount in this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $discount_types as $key => $text}
                                                                <span class="radio"><input {if $key == $default_discount_type}checked="checked"{/if} class="inline" type="radio" name="incentive[discount_type]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Value' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Value of the discount.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="incentive[discount_value]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Min Cart Amount' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Minimum amount of cart required in order to use coupon in this reminder.' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='Minimum amount of cart required in order to use coupon in this reminder.' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="incentive[min_cart_value]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Coupon Validity(in Days)' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Date upto which coupon will be valid for this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span" style="width:100%; margin-left:0;">
                                                                <input style="width:100px;" class="required_entry txt_w_lbl" type="text" name="incentive[coupon_validity]" value=""/>                                                            
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Allow Free Shipping' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='This option will do shipping free for this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <span class="radio"><input class="inline" type="radio" name="incentive[has_free_shipping]" value="1">{l s='Yes' mod='abandonedcart'}</span>
                                                            <span class="radio"><input checked="checked" class="inline" type="radio" name="incentive[has_free_shipping]" value="0">{l s='No' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Minimum Cart Value' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enter the minimum cart value for which this reminder has to be sent' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='This is the minimum cart value for which this reminder has to be sent.' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="incentive[min_cart_value_for_mails]" value="" placeholder=""/></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Status' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Status of incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $incentive_statuses as $key => $text}
                                                                <span class="radio"><input {if $key == $default_incentive_status}checked="checked"{/if} class="inline" type="radio" name="incentive[status]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Delay' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Delay time after which this email send to customers who has abandon cart.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span2" style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="incentive[delay_days]" value=""/> <span class="txt_w_lbl">{l s='Days' mod='abandonedcart'}</span></div>
                                                            <div class="span2"><input class="required_entry hint_txt_inline int_txt" type="text" name="incentive[delay_hrs]" value=""/> <span class="txt_w_lbl">{l s='Hrs' mod='abandonedcart'}</span></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="dismiss_ac_modal('modal_incentive_form')" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="checkTemplateTypeAndProceed(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_incentive_form_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Incentive Form Pop up -->

                    <!-- Start - Popup Reminder Form Pop up -->
                    {*Start: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                    <div class="modal fade" id="modal_popup_incentive_form" tab-index="-1" aria-hidden="true" aria-labelledby="modal-incentive-form">
                        <div class="modal-dialog" style="width:50%">
                            <div class="modal-content">
                                <div class="modal-body" style="padding-bottom:0;">
                                    <div class="row">
                                        <div class="span" style="margin-left:0; width:100%;">
                                            <div id="modal_popup_incentive_form_process_status" class="modal_process_status_blk alert" style="display:none;"></div>
                                        </div>
                                    </div>
                                    <form id="modal_popup_reminder_form_editor" style="margin-bottom:0;">
                                        <input id="modal_popup_reminder_incentive_form_key" type="hidden" name="popup_incentive[id_incentive]" value="0"/>
                                        <input id="modal_incentive_type" type="hidden" name="popup_incentive[incentive_type]" value="0"/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Template Name' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Name of the template used with this incentive. Make sure to select non discount popup if you select discount type as NO DISCOUNT' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span5">
                                                            <select class="dropdn_templates" name="popup_incentive[id_template]" onchange="checkTemplateType(this)">
                                                                <option value='0'>{l s='Select template' mod='abandonedcart'}</option>
                                                                {if count($dropdown_popup_templates) > 0}
                                                                    {foreach $dropdown_popup_templates as $templ}
                                                                        <option value='{$templ['id_template']|escape:'htmlall':'UTF-8'}'>{$templ['name']|escape:'htmlall':'UTF-8'}</option>
                                                                    {/foreach}
                                                                {/if}
                                                            </select>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Type' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Type of the discount in this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $discount_types as $key => $text}
                                                                <span class="radio"><input {if $key == $default_discount_type}checked="checked"{/if} class="inline" type="radio" name="popup_incentive[discount_type]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                            <span class="radio"><input class="inline" type="radio" name="popup_incentive[discount_type]" value="2">{l s='No Discount' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Value' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Value of the discount.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="popup_incentive[discount_value]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Priority' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Value of the Priority.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="popup_incentive[priority]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Available From' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Date from discount is valid' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field" >
                                                        {*                                                        <div class="span" id="datepicker" data-date-format="mm-dd-yyyy"><input class="required_entry " type="text" name="popup_incentive[date_from]" value=""  /></div>*}
                                                        <div id="datepicker" class="input-group date" data-date-format="yyyy-mm-dd" style="width: 50%;">
                                                            <input class="required_entry " type="text" name="popup_incentive[date_from]" value="" readonly />
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='To' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='End Date of the discount is valid' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        {*                                                        <div class="span"><input class="required_entry" type="date" name="popup_incentive[date_to]" value=""/></div>*}
                                                        <div id="datepicker1" class="input-group date" data-date-format="yyyy-mm-dd" style="width: 50%;">
                                                            <input class="required_entry " type="text" name="popup_incentive[date_to]" value="" readonly />
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </div>
                                                    </td>
                                                </tr>


                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Min Cart Amount' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Minimum amount of cart required in order to use coupon in this reminder.' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='Minimum amount of cart required in order to use coupon in this reminder.' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="popup_incentive[min_cart_value]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Coupon Validity(in Days)' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Date upto which coupon will be valid for this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span" style="width:100%; margin-left:0;">
                                                                <input style="width:100px;" class="required_entry txt_w_lbl" type="text" name="popup_incentive[coupon_validity]" value=""/>                                                            
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Allow Free Shipping' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='This option will do shipping free for this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <span class="radio"><input class="inline" type="radio" name="popup_incentive[has_free_shipping]" value="1">{l s='Yes' mod='abandonedcart'}</span>
                                                            <span class="radio"><input checked="checked" class="inline" type="radio" name="popup_incentive[has_free_shipping]" value="0">{l s='No' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Minimum Cart Value' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enter the minimum cart value for which this reminder has to be sent' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='This is the minimum cart value for this pop up to be shown.' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="popup_incentive[min_cart_value_for_popup]" value="" placeholder=""/></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Status' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Status of incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $incentive_statuses as $key => $text}
                                                                <span class="radio"><input {if $key == $default_incentive_status}checked="checked"{/if} class="inline" type="radio" name="popup_incentive[status]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Delay' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Delay of the popup display in front when first product is added into cart' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span2" style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="popup_incentive[frequency_hour]" value=""/> <span class="txt_w_lbl">{l s='Hour' mod='abandonedcart'}</span></div>
                                                            <div class="span2"><input class="required_entry hint_txt_inline int_txt" type="text" name="popup_incentive[frequency_minutes]" value=""/> <span class="txt_w_lbl">{l s='Minutes' mod='abandonedcart'}</span></div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Display popup again after' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Frequancy of Display popup again in front after closing popup' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span2" style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="popup_incentive[frequuency_popup_again]" value=""/> <span class="txt_w_lbl">{l s='Hour' mod='abandonedcart'}</span></div>

                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="dismiss_ac_modal('modal_popup_incentive_form')" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="checkPopupReminderTemplateTypeAndProceed(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_Popup_Reminder_incentive_form_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    {*End: Added By Shubham (Feature: Popup Reminder (Jan 2020))*}
                    <!-- End - Popup Reminder Form Pop up -->


                    <!--- Start - Web Browser Reminder -->
                     {*Start: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                    <div class="modal fade" id="modal_WebBrowser_reminder_form" tab-index="-1" aria-hidden="true" aria-labelledby="modal-incentive-form">
                        <div class="modal-dialog" style="width:50%">
                            <div class="modal-content">
                                <div class="modal-body" style="padding-bottom:0;">
                                    <div class="row">
                                        <div class="span" style="margin-left:0; width:100%;">
                                            <div id="modal_WebBrowser_incentive_form_process_status" class="modal_process_status_blk alert" style="display:none;"></div>
                                        </div>
                                    </div>
                                    <form id="modal_WebBrowser_reminder_form_editor" style="margin-bottom:0;">
                                        <input id="modal_WebBrowser_reminder_incentive_form_key" type="hidden" name="WebBrowser_reminder[id_reminder]" value="0"/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <!-- REMINDER NAME -->
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Reminder Name' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enter the Reminder Name.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <input class="required_entry" type="text" name="WebBrowser_reminder[name]" value=""/>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- PRIORITY -->
                                                <tr class="discount_popup_incentive_fields" style="display:none;">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Priority' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Value of the Priority.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="WebBrowser_reminder[priority]" value=""/></div>
                                                    </td>
                                                </tr>

                                                <!-- STATUS -->
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Status' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Status of reminder.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $incentive_statuses as $key => $text}
                                                                <span class="radio"><input {if $key == $default_incentive_status}checked="checked"{/if} class="inline" type="radio" name="WebBrowser_reminder[status]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Abandon Hour -->
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Delay' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Delay of the Web browser notification display in front when first product is added into cart' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span2" style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="WebBrowser_reminder[abandon_hour]" value=""/> <span class="txt_w_lbl">{l s='Hour' mod='abandonedcart'}</span></div>
                                                            <div class="span2"><input class="required_entry hint_txt_inline int_txt" type="text" name="WebBrowser_reminder[abandon_min]" value=""/> <span class="txt_w_lbl">{l s='Minutes' mod='abandonedcart'}</span></div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Available date from and to -->                                                
                                                <tr class="discount_WebBrowser_reminder_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Available From' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Date from discount is valid' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field" >
                                                        <div id="datepickerWeb" class="input-group date" data-date-format="yyyy-mm-dd" style="width: 50%;">
                                                            <input class="required_entry " type="text" name="WebBrowser_reminder[date_from]" value="" readonly />
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="discount_WebBrowser_reminder_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='To' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='End Date of the discount is valid' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div id="datepickerWeb1" class="input-group date" data-date-format="yyyy-mm-dd" style="width: 50%;">
                                                            <input class="required_entry " type="text" name="WebBrowser_reminder[date_to]" value="" readonly />
                                                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Frequency Again -->                                                
                                                <tr style="display:none;">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Display Notification again after' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Frequancy of Display Notification again in front after closing.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span2" style="margin-left:0;"><input class="required_entry hint_txt_inline int_txt" type="text" name="WebBrowser_reminder[frequency_again]" value=""/> <span class="txt_w_lbl">{l s='Hour' mod='abandonedcart'}</span></div>

                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- DISCOUNT TYPE -->
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Type' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Type of the discount in this reminder.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $discount_types as $key => $text}
                                                                <span class="radio"><input {if $key == $default_discount_type}checked="checked"{/if} class="inline" type="radio" name="WebBrowser_reminder[discount_type]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                            <span class="radio"><input class="inline" type="radio" name="WebBrowser_reminder[discount_type]" value="2">{l s='No Discount' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- DISCOUNT VALUE -->
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Value' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Value of the discount.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="WebBrowser_reminder[discount_value]" value=""/></div>
                                                    </td>
                                                </tr>

                                                <!-- Has Free Shipping -->
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Allow Free Shipping' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='This option will do shipping free for this reminder.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <span class="radio"><input class="inline" type="radio" name="WebBrowser_reminder[has_free_shipping]" value="1">{l s='Yes' mod='abandonedcart'}</span>
                                                            <span class="radio"><input checked="checked" class="inline" type="radio" name="WebBrowser_reminder[has_free_shipping]" value="0">{l s='No' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- MIN CART VALUE -->
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Min Cart Amount' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Minimum amount of cart required in order to use coupon in this reminder.' mod='abandonedcart'}"></i>
                                                        <p class="help" style="font-size: 11px;"><b>{l s='Note' mod='abandonedcart'}: </b>{l s='Minimum amount of cart required in order to use coupon in this reminder.' mod='abandonedcart'}</p>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="WebBrowser_reminder[min_cart_value_coupon]" value=""/></div>
                                                    </td>
                                                </tr>

                                                <!-- COUPON VALIDATY DAYS -->
                                                <tr class="discount_popup_incentive_fields">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Coupon Validity(in Days)' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Date upto which coupon will be valid for this incentive.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span" style="width:100%; margin-left:0;">
                                                                <input style="width:100px;" class="required_entry txt_w_lbl" type="text" name="WebBrowser_reminder[coupon_validity]" value=""/>                                                            
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- NOTIFY SUBJECT -->
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Web Browser Notification Subject' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enter the Web Browser Notification Subject.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field" style="display:grid;">
                                                        {foreach from=$languages item='lang'}
                                                            <div class='span0'><img src="{$img_lang_dir}{$lang['id_lang']|intval}.jpg" alt="{$lang['name']}" title="{$lang['name']}"/></div>
                                                            <div class="span">
                                                                <input class="required_entry int_txt" type="text" name="WebBrowser_reminder[notify_title_{$lang['id_lang']|intval}]" value="" style='width:100% !important'/>
                                                                <span id="WebBrowser_subject_{$lang['id_lang']|intval}_error" ></span>
                                                            </div>
                                                            <br>
                                                        {/foreach}
                                                    </td>
                                                </tr>

                                                <!-- NOTIFY CONTENT -->
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Web Browser Notification Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Enter the Web Browser Notification Content.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        {foreach from=$languages item='lang'}
                                                            <div class='span0' style="clear:both;"><img src="{$img_lang_dir}{$lang['id_lang']|intval}.jpg" alt="{$lang['name']}" title="{$lang['name']}"/></div>
                                                            <div class="span" style="clear:both;">
                                                                <textarea class="required_entry" type="text" name="WebBrowser_reminder[notify_content_{$lang['id_lang']|intval}]" rows="4" cols="60" ></textarea>
                                                                <span id="WebBrowser_content_{$lang['id_lang']|intval}_error"></span>
                                                                <span style="font-size: 11px;text-align: center;">
                                                                    {l s='Please do not remove the placeholders with {{}}. These details will be filled automatically.' mod='abandonedcart'}
                                                                </span>
                                                            </div>
                                                        {/foreach}


                                                    </td>

                                                </tr>

                                                <!--END-->
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="dismiss_ac_modal('modal_WebBrowser_reminder_form')" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    <button type="button" onclick="saveWebBrowserReminder(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>
                                    <img class="modal_WebBrowser_Reminder_form_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    {*End: Added by Anshul (Feature: Push Notification (Jan 2020))*}
                    <!--- End - Web Browser Reminder -->

                    <!----------- Start - Email Reminder Modal ------------>
                    <div class="modal fade" id="reminder_email_modal" tab-index="-1" aria-hidden="true" aria-labelledby="modal-email">
                        <div class="modal-dialog" style="width:60%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="dismiss_ac_modal('reminder_email_modal');
                                            $('#reminder_email_modal .row-no-display').hide();"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body" style="padding-top:0;">
                                    <form id="reminder_email_form" style="margin-bottom:0;">
                                        <input type="hidden" name="email_reminder[id_cart]" value=""/>
                                        <input type="hidden" name="email_reminder[id_customer]" value=""/>
                                        <input type="hidden" name="email_reminder[id_abandon]" value=""/>
                                        <input type="hidden" name="email_reminder[id_lang]" value=""/>
                                        <input type="hidden" name="cart_template" value=""/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Choose Template' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Select template which you want to use as reminder.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span5">
                                                            <select class="dropdn_templates_translation_ndis" name="email_reminder[id_template_content]" onchange="getTemplate($(this).val(), 'reminder_email_modal')">
                                                                <option value='0' disabled="disabled">{l s='Select template' mod='abandonedcart'}</option>
                                                                {if count($dropdown_tran_template_list) > 0}
                                                                    {foreach $dropdown_tran_template_list as $templ}
                                                                        {if $non_discount_email_value == $templ['type']}
                                                                            <option value='{$templ['id_template_content']|escape:'htmlall':'UTF-8'}'>{$templ['name']|escape:'htmlall':'UTF-8'}({$templ['language_text']|escape:'htmlall':'UTF-8'})</option>
                                                                        {/if}
                                                                    {/foreach}
                                                                {/if}
                                                            </select>
                                                            <img class="template_loader" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Subject' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Subject of the email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6"><input class="required_entry" type="text" name="single_email_subject" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Content of the email which will be sent to customers.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><textarea id="reminder_email_modal_body_editor" name="single_email_body" class="autoload_rte"  rows="10"></textarea></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <div class="row">
                                        <div id="modal-reminder-email-status" class="sending-eml-progress"></div>
                                    </div>
                                    <button onclick="dismiss_ac_modal('reminder_email_modal');
                                            $('#reminder_email_modal .row-no-display').hide();" type="button" class="btn btn-default modal-action-btn">{l s='Close' mod='abandonedcart'}</button>
                                    <a href="javascript:void(0)" onclick="sendReminderMail()" class="btn btn-primary modal-action-btn" >{l s='Send Email' mod='abandonedcart'}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!----------- End - Email Reminder Modal ------------>

                    <!-------- Start - Incentive Email Modal --------->
                    <div class="modal fade" id="modal_incentive_email" tab-index="-1" aria-hidden="true" aria-labelledby="modal-email">
                        <div class="modal-dialog" style="width:55%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="dismiss_ac_modal('modal_incentive_email');"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body" style="padding-top:0;">
                                    <form id="discount_email_form" style="margin-bottom:0;">
                                        <input type="hidden" name="email_discount[id_cart]" value=""/>
                                        <input type="hidden" name="email_discount[id_customer]" value=""/>
                                        <input type="hidden" name="email_discount[id_abandon]" value=""/>
                                        <input type="hidden" name="email_discount[id_lang]" value=""/>
                                        <input type="hidden" name="cart_template" value=""/>
                                        <div style="overflow-y:auto !important;">
                                            <table class="list form" style="width:100%">
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Type' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Type of the discount in this email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            {foreach $discount_types as $key => $text}
                                                                <span class="radio"><input {if $key == $default_discount_type}checked="checked"{/if} class="inline" type="radio" name="email_discount[discount_type]" value="{$key|escape:'htmlall':'UTF-8'}">{$text|escape:'htmlall':'UTF-8'}</span>
                                                                {/foreach}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Discount Value' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Value of the discount.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="email_discount[discount_value]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Min Cart Amount' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Minimum amount of cart for which discount will be applicable. If left blank, then system will assume minimum cart amount as 0.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><input class="required_entry int_txt" type="text" name="email_discount[min_cart_value]" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Coupon Validity(in days)' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Days upto which coupon will be valid for this discount.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <div class="span" style="width:100%; margin-left:0;">
                                                                <input style="width:100px;" class="required_entry txt_w_lbl" type="text" name="email_discount[coupon_validity]" value=""/>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Allow Free Shipping' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='This option will do shipping free for this discount.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <span class="radio"><input class="inline" type="radio" name="email_discount[has_free_shipping]" value="1">{l s='Yes' mod='abandonedcart'}</span>
                                                            <span class="radio"><input checked="checked" class="inline" type="radio" name="email_discount[has_free_shipping]" value="0">{l s='No' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Stop auto Email' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='This option will not send automatic discount email for this abandon cart in future.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span">
                                                            <span class="radio"><input class="inline" type="radio" name="email_discount[auto_email]" value="1">{l s='Yes' mod='abandonedcart'}</span>
                                                            <span class="radio"><input checked="checked" class="inline" type="radio" name="email_discount[auto_email]" value="0">{l s='No' mod='abandonedcart'}</span>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Choose Template' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Select template which you want to use in this email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span5">
                                                            <select class="dropdn_templates_translation_dis" name="email_discount[id_template_content]" onchange="getTemplate($(this).val(), 'modal_incentive_email')">
                                                                <option value='0' disabled="disabled">{l s='Select template' mod='abandonedcart'}</option>
                                                                {if count($dropdown_tran_template_list) > 0}
                                                                    {foreach $dropdown_tran_template_list as $templ}
                                                                        {if $non_discount_email_value != $templ['type']}
                                                                            <option value='{$templ['id_template_content']|escape:'htmlall':'UTF-8'}'>{$templ['name']|escape:'htmlall':'UTF-8'}({$templ['language_text']|escape:'htmlall':'UTF-8'})</option>
                                                                        {/if}
                                                                    {/foreach}
                                                                {/if}
                                                            </select>
                                                            <img class="template_loader" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Subject' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color"  data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Subject of the email.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span6"><input class="required_entry" type="text" name="single_email_subject" value=""/></div>
                                                    </td>
                                                </tr>
                                                <tr class="row-no-display">
                                                    <td class="ac_modal_form_label ac_modal_form_field"><span class="control-label"><span class="required"> *</span>{l s='Email Content' mod='abandonedcart'}</span>
                                                        <i class="icon-question-sign tooltip_color" data-toggle="tooltip"  data-placement="top" data-original-title="{l s='Content of the email which will be sent to customers.' mod='abandonedcart'}"></i>
                                                    </td>
                                                    <td class="ac_modal_form_field">
                                                        <div class="span"><textarea id="modal_incentive_email_body_editor" name="single_email_body" class="autoload_rte"  rows="10"></textarea></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <div class="row">
                                        <div id="modal-incentive-email-status" class="sending-eml-progress"></div>
                                    </div>
                                    <button onclick="dismiss_ac_modal('modal_incentive_email');" type="button" class="btn btn-default modal-action-btn">{l s='Close' mod='abandonedcart'}</button>
                                    <a href="javascript:void(0)" onclick="sendDiscountEmail()" class="btn btn-primary modal-action-btn" id="sendemail_reminder" >{l s='Send Email' mod='abandonedcart'}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-------- End - Incentive Email Modal ---------------->

                    <!-- Start - Cron  Pop up -->
                    {*Start: Added By Shubham (Feature: Cron Log (Jan 2020))*}
                    <div class="modal fade" id="modal_cron_template" tab-index="-1" aria-hidden="true" aria-labelledby="modal-popup">
                        <div class="modal-dialog" style="width:70%">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" onclick="closeCronDetailPopup()"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>
                                <div class="modal-body " style="padding-bottom:0;padding: 25px;">
                                    <h3>{l s='Customers Details' mod='abandonedcart'}</h3>                
                                    <div class="modal_cron_body" style="overflow-y:auto !important;">
                                    </div>
                                </div>
                                <div class="modal-footer row-no-display">
                                    <button type="button" onclick="closeCronDetailPopup()" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                    {*                                    <button type="button" onclick="savePopUpTemplate(this);" class="btn btn-primary">{l s='Save' mod='abandonedcart'}</button>*}
                                    {*                                    <img class="modal_popup_template_progress" src="{$path|escape:'htmlall':'UTF-8'}views/img/loading16.gif" style="display:none;">*}
                                </div>
                            </div>
                        </div>
                    </div>
                    {*End: Added By Shubham (Feature: Cron Log (Jan 2020))*}
                    <!-- End - Cron Popup  -->

                    <!-------- Start - Display Cart Product Modal -------->
                    <div class="modal fade ac_modal_popup" id="cart_detail_modal" tab-index="-1" aria-hidden="true" aria-labelledby="modal-cart">
                        <div class="modal-dialog" style="width:51%">
                            <div class="modal-content">
                                <div class="modal-header" style="text-align: center;">
                                    <button type="button" class="close" onclick="removeCartDetailModal();"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                    <h4 class="modal-title"><div class="ac_modal_customer_name"></div>{l s='Cart Details' mod='abandonedcart'}</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="cart_detail_loader" class="abd-modalloader"></div>
                                    <table id="cart_detail_tbl" class="list form" style="text-align: center; display:none;">
                                        <tr>
                                            <th style='width: 20%;'>{l s='IMAGE' mod='abandonedcart'}</th>
                                            <th style="width:190px;">{l s='ITEMS' mod='abandonedcart'}</th>
                                            <th>{l s='MODEL' mod='abandonedcart'}</th>
                                            <th>{l s='QUANTITY' mod='abandonedcart'}</th>
                                            <th>{l s='UNIT PRICE' mod='abandonedcart'}</th>
                                            <th>{l s='TOTAL' mod='abandonedcart'}</th>
                                        </tr>
                                        <tbody id="ac_cart_product_row">
                                        </tbody>                                                            
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button onclick="removeCartDetailModal();" type="button"  class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-------- End - Display Cart Product Modal -------->

                    <!-- Start - Delete Abandon Confirmation Modal --->
                    <div class="modal fade" id="modal_abandon_remove"  tab-index="-1" aria-hidden="true" aria-labelledby="modal_abandon_remove">
                        <div class="modal-dialog" style="width:20%">
                            <div class="modal-content">
                                <!--<div class="modal-header">
                                        <button type="button" class="close" onclick="dismiss_ac_modal('modal_abandon_remove');"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                </div>-->
                                <div class="modal-body">
                                    <div id="abandon_remove_processing" class="abd-modalloader"></div>
                                    <div id="abd-rem-confrm-msg">{l s='Are You sure you want to delete this abandon cart?' mod='abandonedcart'}</div>
                                </div>
                                <div class="modal-footer modal-action-btn">
                                    <button onclick="delAbandonAction(1)" type="button" class="btn btn-default">{l s='Yes' mod='abandonedcart'}</button>
                                    <button onclick="delAbandonAction(0)" type="button" class="btn btn-default">{l s='No' mod='abandonedcart'}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End - Delete Abandon Confirmation Modal --->

                    <!-------- Start - Coupon Detail Popup ---------------->
                    <div class="modal fade ac_modal_popup" id="coupon_detail_modal"  tab-index="-1" aria-hidden="true" aria-labelledby="coupon_detail_modal">
                        <div class="modal-dialog" style="width:50%">
                            <div class="modal-content">
                                <div class="modal-header" style="text-align: center;">
                                    <button type="button" class="close" onclick="removeCouponDetailModal();"><span aria-hidden="true">&times;</span><span class="sr-only">{l s='Close' mod='abandonedcart'}</span></button>
                                    <h4 class="modal-title" ><div class="ac_modal_customer_name"></div>{l s='Coupon Details' mod='abandonedcart'} ({l s='Active Only' mod='abandonedcart'})</h4>
                                </div>
                                <div class="modal-body">
                                    <div id="coupon_detail_loader" class="abd-modalloader"></div>
                                    <table id="coupon-detail-tbl" class="list form" style="text-align: center; display:none;">
                                        <thead>
                                            <tr>
                                                <th style='width:5%;'>&nbsp;</th>
                                                <th class="left">{l s='Coupon Code' mod='abandonedcart'}</th>
                                                <th class="right">{l s='Discount' mod='abandonedcart'}</th>
                                                <th class="right">{l s='Minimum Amount' mod='abandonedcart'}</th>
                                                <th class="left">{l s='Valid From' mod='abandonedcart'}</th>
                                                <th class="left">{l s='Valid to' mod='abandonedcart'}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ac_coupon_detail_row">    
                                        </tbody>                                                            
                                    </table>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" onclick="removeCouponDetailModal();" id="close_coupon" class="btn btn-default">{l s='Close' mod='abandonedcart'}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-------- End - Coupon Detail Popup ----------------> 

                </div>
            </div>
        </div>
        <script type="text/javascript">

            var ac_cart_total_msg = "{l s='Cart Total' mod='abandonedcart'}";
            var required_field_msg = "{l s='Required Field' mod='abandonedcart'}";
            var empty_list_msg = "{l s='List is empty' mod='abandonedcart'}";
            var invalid_flt_msg = "{l s='Enter only number or decimal value' mod='abandonedcart'}";
            var invalid_num_msg = "{l s='Enter only numbers' mod='abandonedcart'}";
            var invalid_date_msg = "{l s='Enter date in valid format. (Ex: YYYY-MM-DD)' mod='abandonedcart'}";
            var ac_abandoned_carts_label = "{l s='Abandoned Carts' mod='abandonedcart'}";
            var ac_converted_carts_label = "{l s='Converted Carts' mod='abandonedcart'}";
            var ac_converted_amount_label = "{l s='Converted Amount' mod='abandonedcart'}";
            var ac_abandoned_amount_label = "{l s='Abandoned Amount' mod='abandonedcart'}";
            var ac_start_date_msg = "{l s='Please enter start date' mod='abandonedcart'}";
            var ac_end_date_msg = "{l s='Please enter end date' mod='abandonedcart'}";
            var ac_date_msg = "{l s='End date should be greater than start date' mod='abandonedcart'}";
            var ac_guest_txt = "{l s='Guest' mod='abandonedcart'}";
            var ac_registered_txt = "{l s='Registered' mod='abandonedcart'}";
            var ac_no_coupon_txt = "{l s='No Coupon code sent' mod='abandonedcart'}";
            var reminder_sent_txt = "{l s='Reminder Sent' mod='abandonedcart'}";
            var ac_coupon_details_txt = "{l s='Coupon Details' mod='abandonedcart'}";
            var ac_send_non_discount_email_txt = "{l s='Send non discount E-mail to customer' mod='abandonedcart'}";
            var ac_send_discount_email_txt = "{l s='Send discount E-mail to customer' mod='abandonedcart'}";
            var ac_view_products_txt = "{l s='View products in cart' mod='abandonedcart'}";
            var ac_remove_cart_txt = "{l s='Click to remove this abandon cart' mod='abandonedcart'}";
            var ac_email_not_txt = "{l s='Email Id not available for this customer' mod='abandonedcart'}";
            {*changes by tarun to show the text for unsubscribed abandoned carts*}
            var ac_unsubscribe_txt = "{l s='You cannot send email. Customer unsubscribed himself.' mod='abandonedcart'}";
            {*changes over*}
            var ac_no_data_found_txt = "{l s='No data found' mod='abandonedcart'}";
            var ac_timeline_label = "{l s='Timeline' mod='abandonedcart'}";
            var ac_num_carts_label = "{l s='No. of Carts' mod='abandonedcart'}";
            var ac_carts_amount_label = "{l s='Carts Amount' mod='abandonedcart'}";
            var ac_gust_cus_label = "{l s='Guest Customer' mod='abandonedcart'}";

            var invalid_num_msg = "{l s='Enter only positive numbers' mod='abandonedcart'}";
            var invalid_day_range = "{l s='Please enter days from 0 to 1000.' mod='abandonedcart'}";
            var invalid_num_range = "{l s='Please enter hours from 0 to 24.' mod='abandonedcart'}";
            var all_mandatory = "{l s='All the fields are mandatory' mod='abandonedcart'}";
            var max_255_length = "{l s='Maximum 255 characters allowed' mod='abandonedcart'}";
            var required_days = "{l s='Please enter number of days' mod='abandonedcart'}";
            var required_hours = "{l s='Please enter number of hours' mod='abandonedcart'}";
            var required_email = "{l s='Please enter the email id' mod='abandonedcart'}";
            var required_template_name = "{l s='Please enter the Template Name' mod='abandonedcart'}";
            var required_email_subject = "{l s='Please enter the Email Subject' mod='abandonedcart'}";
            var required_email_content = "{l s='Please enter the Email Content' mod='abandonedcart'}";
            var select_template_name = "{l s='Please select the Template Name' mod='abandonedcart'}";
            var required_discount_value = "{l s='Please enter the Discount Value' mod='abandonedcart'}";
            var required_min_cart = "{l s='This field can not be empty.' mod='abandonedcart'}";
            var required_coupon_validity = "{l s='Please enter the Coupon Validity' mod='abandonedcart'}";
            var required_minimum_cart = "{l s='Please enter the Minimum Cart Value' mod='abandonedcart'}";
            var number_length_error = "{l s='Limit exceeds, value must be less than 10000000000.' mod='abandonedcart'}";

            var remove_confirm_msg = "{l s='Are you sure to want to remove template?' mod='abandonedcart'}";
            var remove_reminder_msg = "{l s='Are you sure to want to remove this serial reminder?' mod='abandonedcart'}";
            var click_to_del = "{l s='Click to delete' mod='abandonedcart'}";
            var edit_trans_msg = "{l s='Click to edit Translation' mod='abandonedcart'}";
            var edit_click_msg = "{l s='Click to edit' mod='abandonedcart'}";
            var delete_click_msg = "{l s='Click to delete' mod='abandonedcart'}";
            var sel_temp_msg = "{l s='Select template' mod='abandonedcart'}";
            {*Start: Popup Reminder & Push Notification (Jan 2020)*}
            var required_msg = "{l s='One of the fields from API KEY, SENDER ID,PROJECT ID & SERVER KEY are empty in Web Browser Configuration tab.' mod='abandonedcart'}";
            var select_template_name_subject = "{l s='Please enter subject name.' mod='abandonedcart'}";
            var select_template_name_content = "{l s='Please enter the content.' mod='abandonedcart'}";
            var number_notzero_error = "{l s='Priority can not be zero.' mod='abandonedcart'}";
            var number_notzero_error_dis = "{l s='This field can not be zero.' mod='abandonedcart'}";
            var selected_abd_rem_id = 0;
            var required_popup_name = "{l s='Please enter the Template Name' mod='abandonedcart'}";
            var required_popup_content = "{l s='Please enter the PopUp Content' mod='abandonedcart'}";
            var invalid_hour_range = "{l s='Please enter hours from 0 to 24.' mod='abandonedcart'}";
            var required_minutes = "{l s='Please enter number of minutes' mod='abandonedcart'}";
            var invalid_minutes_range = "{l s='Please enter hours from 0 to 60.' mod='abandonedcart'}";
            var remove_popup_reminder_msg = "{l s='Are you sure to want to remove this Popup reminder?' mod='abandonedcart'}";

            var s_no = "{l s='S. No' mod='abandonedcart'}";
            var email_id = "{l s='Email Id' mod='abandonedcart'}";
            var action_trans = "{l s='Action' mod='abandonedcart'}";
            var no_data = "{l s='No data updated' mod='abandonedcart'}";
            var view_cron_details = "{l s='View cron details' mod='abandonedcart'}";
            var email_cron = "{l s='Emails are sent to following customers' mod='abandonedcart'}";
            var link_admin_cart = "{$link_admin_cart}";
            var link_admin_customer = "{$link_admin_customer}";
            var view_cart = "{l s='View Cart' mod='abandonedcart'}";
            var hour_trans = "{l s='Hour' mod='abandonedcart'}";
            var min_trans = "{l s='Minutes' mod='abandonedcart'}";
            {*End: Popup Reminder & Push Notification (Jan 2020)*}
            var iso = 'en';
            var pathCSS = "{$root_path|escape:'htmlall':'UTF-8'}themes/default-bootstrap/css/";
            var ad = "{$admin_path|escape:'htmlall':'UTF-8'}";
            $(document).ready(function () {

                //added below two lines to show answer of first FAQ
                $('#faq-span1').css('max-height', 'none');
                $('#answer1').css('display', 'block')

                // Carousal in FAQ
                $('.faq-row').off('click').on('click', function () {
                    var element_id = this.id;
                    var i = 1;
                    for (i = 1; i < 20; i++)
                    {
                        if (i != element_id) {
                            //to hide answer of previously opened FAQ question
                            $('#faq-span' + i).css('max-height', '10px');
                            $('#answer' + i).css('display', 'none');
                        }
                    }
                    //added below to lines to show answer of question, when admin click on it
                    $('#faq-span' + element_id).css('max-height', 'none');
                    $('#answer' + element_id).css('display', 'block');

                });

                // Execute when tab Informations has finished loading
                _tinyMCE = tinySetup({
                    editor_selector: "autoload_rte",
                    theme_advanced_resizing: true,
                    theme_advanced_resizing_use_cookie: false,
                    extended_valid_elements: "img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name]",
                    setup: function (ed) {
                        ed.on('keydown', function (ed, e) {
                            /*ed.onInit.add(function() {
                             var width = ed.getWin().clientWidth;
                             var height = 400;
                             
                             ed.theme.resizeTo(width, height);
                             });*/
                            tinyMCE.triggerSave();
                            textarea = $('#' + tinymce.activeEditor.id);
                            var max = textarea.parent('div').find('span.counter').data('max');
                            if (max != 'none')
                            {
                                count = tinyMCE.activeEditor.getBody().textContent.length;
                                rest = max - count;
                                if (rest < 0)
                                    textarea.parent('div').find('span.counter').html('<span style="color:red;">Maximum ' + max + ' characters : ' + rest + '</span>');
                                else
                                    textarea.parent('div').find('span.counter').html(' ');
                            }
                        });
                    }
                });


            });

        </script>
        {*
        * DISCLAIMER
        *
        * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
        * versions in the future. If you wish to customize PrestaShop for your
        * needs please refer tohttp://www.prestashop.com for more information.
        * We offer the best and most useful modules PrestaShop and modifications for your online store.
        *
        * @category  PrestaShop Module
        * @author    knowband.com <support@knowband.com>
        * @copyright 2020 knowband
        * @license   see file: LICENSE.txt
        *
        * Description
        *
        * Admin tpl file
        *}

