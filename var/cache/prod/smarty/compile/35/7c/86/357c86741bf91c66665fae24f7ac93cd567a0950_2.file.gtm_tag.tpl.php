<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:11:33
  from '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/hook/gtm_tag.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085635323bb1_42307832',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '357c86741bf91c66665fae24f7ac93cd567a0950' => 
    array (
      0 => '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/hook/gtm_tag.tpl',
      1 => 1611158743,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085635323bb1_42307832 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 data-keepinline="true">
var always_display_variant_id = <?php if (!empty($_smarty_tpl->tpl_vars['always_display_variant_id']->value)) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['always_display_variant_id']->value, ENT_QUOTES, 'UTF-8');
} else { ?>0<?php }?>;

/* datalayer */
dataLayer = [];
<?php if (!empty($_smarty_tpl->tpl_vars['dataLayer']->value)) {?>dataLayer.push(<?php echo $_smarty_tpl->tpl_vars['dataLayer']->value;?>
);<?php }?>

/* call to GTM Tag */
(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','<?php echo $_smarty_tpl->tpl_vars['gtm_id']->value;?>
');

/* async call to avoid cache system for dynamic data */
<?php if ($_smarty_tpl->tpl_vars['async_user_info']->value) {?>
var cdcgtmreq = new XMLHttpRequest();
cdcgtmreq.onreadystatechange = function() {
    if (cdcgtmreq.readyState == XMLHttpRequest.DONE ) {
        if (cdcgtmreq.status == 200) {
          	var datalayerJs = cdcgtmreq.responseText;
            try {
                var datalayerObj = JSON.parse(datalayerJs);
                dataLayer = dataLayer || [];
                dataLayer.push(datalayerObj);
            } catch(e) {
               console.log("[CDCGTM] error while parsing json");
            }

            <?php if ($_smarty_tpl->tpl_vars['gtm_debug']->value) {?>
            // display debug
            console.log('[CDCGTM] DEBUG ENABLED');
            console.log(datalayerObj);
            document.addEventListener('DOMContentLoaded', function() {
              if(document.getElementById("cdcgtm_debug_asynccall")) {
                  document.getElementById("cdcgtm_debug_asynccall").innerHTML = datalayerJs;
              }
            }, false);
            <?php }?>
        }
        dataLayer.push({
          'event': '<?php echo $_smarty_tpl->tpl_vars['event_datalayer_ready']->value;?>
'
        });
    }
};
cdcgtmreq.open("GET", "<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['async_url']->value, ENT_QUOTES, 'UTF-8');?>
" /*+ "?" + new Date().getTime()*/, true);
cdcgtmreq.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
cdcgtmreq.send();
<?php } else { ?>
dataLayer.push({
  'event': '<?php echo $_smarty_tpl->tpl_vars['event_datalayer_ready']->value;?>
'
});
<?php }
echo '</script'; ?>
><?php }
}
