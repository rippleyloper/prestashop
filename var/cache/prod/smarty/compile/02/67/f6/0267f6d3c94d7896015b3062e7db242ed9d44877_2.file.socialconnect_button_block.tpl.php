<?php
/* Smarty version 3.1.33, created on 2021-01-20 17:31:17
  from '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/socialconnect_button_block.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60089315c45160_87353208',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '0267f6d3c94d7896015b3062e7db242ed9d44877' => 
    array (
      0 => '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/socialconnect_button_block.tpl',
      1 => 1610117952,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60089315c45160_87353208 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['popup_login_enable_facebook']->value || $_smarty_tpl->tpl_vars['popup_login_enable_twitter']->value || $_smarty_tpl->tpl_vars['popup_login_enable_google']->value) {?>
	<div class="popup_social_connect_content clearfix">
		<?php if ($_smarty_tpl->tpl_vars['popup_login_enable_facebook']->value) {?>
						<button type="submit" onclick="fb_login();" class="sc-button sc-fb-button popup-sc-onclick-btn">
				<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'FACEBOOK','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</span>
			</button>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['popup_login_enable_twitter']->value) {?>
						<button type="submit" onclick="window.open('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['callback_url']->value,'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
', '_blank', 'toolbar=yes, scrollbars=yes, resizable=yes, top=100, left=300, width=700, height=600');" class="sc-button sc-tw-button popup-sc-onclick-btn">
				<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'TWITTER','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</span>
			</button>
		<?php }?>
		<?php if ($_smarty_tpl->tpl_vars['popup_login_enable_google']->value) {?>
						<button type="submit" class="g-signin sc-button sc-gl-button popup-sc-onclick-btn googleplusSignIn" id='googleplusSignIn-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['id_popup']->value, ENT_QUOTES, 'UTF-8');?>
'>
				<span><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'GOOGLE','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</span>
			</button>
		<?php }?>
	</div>
<?php }
}
}
