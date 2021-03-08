<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:21
  from '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085539ee9e33_25893096',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '24df52599a854f27d0b97cd222b71584c845722a' => 
    array (
      0 => '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/header.tpl',
      1 => 1610117952,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085539ee9e33_25893096 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
    
        var psv = <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['psv']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
;
        var enable_header_login_popup = Boolean(<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['enable_header_login_popup']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
);
        var enable_responsive = Boolean(<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['enable_responsive']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
);
        var resize_start_point = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['resize_start_point']->value, ENT_QUOTES, 'UTF-8');?>
;
        var enable_facebook_login = Boolean(<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['enable_facebook_login']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
);
        var facebook_app_id = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['facebook_app_id']->value, ENT_QUOTES, 'UTF-8');?>
';
        var gp_client_id = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['gp_client_id']->value, ENT_QUOTES, 'UTF-8');?>
';
        var enable_google_login = '<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['enable_google_login']->value, ENT_QUOTES, 'UTF-8');?>
';
        var pn_social_redirect = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['redirect']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var my_account_url = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['my_account_url']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var controller_name = '<?php echo $_smarty_tpl->tpl_vars['controller_name']->value;?>
';
        var hi_popup_module_dir = '<?php echo $_smarty_tpl->tpl_vars['hi_popup_module_dir']->value;?>
';
        var popup_secure_key = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popup_secure_key']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var popup_sc_front_controller_dir = '<?php echo $_smarty_tpl->tpl_vars['popup_sc_front_controller_dir']->value;?>
';
        var popup_sc_loader = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popup_sc_loader']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var popup_sc_loader = '<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['popup_sc_loader']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
';
        var pn_back_url = '<?php echo $_smarty_tpl->tpl_vars['pn_back_url']->value;?>
';
        var baseDir = <?php if ($_smarty_tpl->tpl_vars['psv']->value >= 1.7) {?>  prestashop.urls.base_url <?php } else { ?> baseDir <?php }?> ;
        var hiPopup = {};
        var hiPopupExit = {};
    
<?php echo '</script'; ?>
>

<style type="text/css">
     @media (max-width: <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['hide_start_point']->value, ENT_QUOTES, 'UTF-8');?>
px) {
        .mfp-wrap, .mfp-bg{
            display: none;
        }
     }
</style>

<?php if ($_smarty_tpl->tpl_vars['enable_google_login']->value) {?>
    <?php echo '<script'; ?>
 src="https://apis.google.com/js/api:client.js"><?php echo '</script'; ?>
>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['enable_facebook_login']->value) {?>
    <?php echo '<script'; ?>
 type="text/javascript">
          window.fbAsyncInit = function() {
            FB.init({
              appId      : facebook_app_id,
              xfbml      : true,
              version    : 'v2.9'
            });
            FB.AppEvents.logPageView();
          };
          
              (function(d, s, id){
                 var js, fjs = d.getElementsByTagName(s)[0];
                 if (d.getElementById(id)) {return;}
                 js = d.createElement(s); js.id = id;
                 js.src = "//connect.facebook.net/en_US/sdk.js";
                 fjs.parentNode.insertBefore(js, fjs);
               }(document, 'script', 'facebook-jssdk'));
          
    <?php echo '</script'; ?>
>
<?php }
}
}
