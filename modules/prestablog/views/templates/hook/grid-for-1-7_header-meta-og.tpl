{*
 * 2008 - 2020 (c) Prestablog
 *
 * MODULE PrestaBlog
 *
 * @author    Prestablog
 * @copyright Copyright (c) permanent, Prestablog
 * @license   Commercial
 *}

<!-- Module Presta Blog -->
{foreach from=$prestablog_fb_admins item=fbmoderator}
<meta property="fb:admins"       content="{$fbmoderator|escape:'html':'UTF-8'}" />
{/foreach}
{if $prestablog_fb_appid}
<meta property="fb:app_id"       content="{$prestablog_fb_appid|escape:'html':'UTF-8'}" />
{/if}
<meta property="og:url"          content="{$prestablog_news_meta_url|escape:'html':'UTF-8'}" />
<meta property="og:image"        content="{$prestablog_news_meta_img|escape:'html':'UTF-8'}" />
<meta property="og:title"        content="{$prestablog_news_meta->title|escape:'htmlall':'UTF-8'}" />
<meta property="og:description"  content="{$prestablog_news_meta->paragraph|escape:'htmlall':'UTF-8'}" />
{if $prestablog_config.prestablog_captcha_actif==1}
<script src='https://www.google.com/recaptcha/api.js'></script>
{/if}
<!-- Module Presta Blog -->

