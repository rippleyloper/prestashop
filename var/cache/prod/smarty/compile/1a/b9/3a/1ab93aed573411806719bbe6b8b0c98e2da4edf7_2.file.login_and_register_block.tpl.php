<?php
/* Smarty version 3.1.33, created on 2021-01-20 17:31:17
  from '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/login_and_register_block.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60089315aaa685_47270724',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1ab93aed573411806719bbe6b8b0c98e2da4edf7' => 
    array (
      0 => '/var/www/html/ps_dev/modules/hipopupnotification/views/templates/hook/login_and_register_block.tpl',
      1 => 1610117952,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:./socialconnect_button_block.tpl' => 1,
  ),
),false)) {
function content_60089315aaa685_47270724 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div class="popup_authentication_box">
	<div class="popup_login_register_content clearfix">
        <!-- Login block -->
        <div class="popup_login_block">
            <h2 class="popup-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Login','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</h2>
            <!-- Login Form -->
            <form name="popup_login_form" class="popup_login_form" action="#" method="POST">
                <div class="form-group">
                    <input type="text" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
" name="popup_login_email" class="<?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>form-control<?php }?> popup_login_email popup_email_icon" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
">
                </div>
                <div class="form-group password-group">
                    <input type="password" name="popup_login_password" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Password','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
" class="<?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>form-control<?php }?> popup_login_password popup_password_icon" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Password','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
">
                    <a class = 'forgot-password' href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['forgot_password_url']->value, ENT_QUOTES, 'UTF-8');?>
">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Forgot Password?','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>

                    </a>
                </div>
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'higdpr'),$_smarty_tpl ) );?>

                <div class="form-group">
                    <button type="submit" class="btn btn-default popup_login_btn <?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>btn-primary<?php }?>">
                        <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_image_dir']->value, ENT_QUOTES, 'UTF-8');?>
/ajax-loader.gif" class="popup-ajax-loader">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Login','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>

                </button>
                </div>
                <?php if ($_smarty_tpl->tpl_vars['popup_login_enable_facebook']->value || $_smarty_tpl->tpl_vars['popup_login_enable_twitter']->value || $_smarty_tpl->tpl_vars['popup_login_enable_google']->value) {?>
                    <h3 class="social-connect-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'or connect with','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</h3>
                    <?php $_smarty_tpl->_subTemplateRender("file:./socialconnect_button_block.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>
                <?php }?>
            </form>
        </div>
        <!-- Register Box -->
        <div class="popup_register_block">
            <h2 class="popup-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Register','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</h2>
            <!-- Register Form -->
            <form name="popup_register_form" class="popup_register_form" action="#" method="POST" accept-charset="utf-8">
                <div class="form-group">
                    <input type="text" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'First Name','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
" name="popup_register_fname" class="<?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>form-control<?php }?> popup_register_fname popup_user_icon" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'First Name','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
">
                </div>
                <div class="form-group">
                    <input type="text" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Last Name','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
" name="popup_register_lname" class="<?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>form-control<?php }?> popup_register_lname popup_user_icon" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Last Name','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
">
                </div>
                <div class="form-group">
                    <input type="email" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
" name='popup_register_email' class="<?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>form-control<?php }?> popup_register_email popup_email_icon " title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Email','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
">
                </div>
                <div class="form-group">
                    <input type="password" name="popup_register_password" placeholder="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Password','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
" class="<?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>form-control<?php }?> popup_register_password popup_password_icon" title="<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Password','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
">
                </div>
                <div class="popup_register_bottom_text">
                    <?php if ($_smarty_tpl->tpl_vars['psv']->value >= 1.7) {?>
                        <div class="row">
                            <div class="col-md-12">
                                <span class="custom-checkbox">
                                    <input type="checkbox" name="pn_newsletter" value="1" />
                                    <span><i class="material-icons checkbox-checked"></i></span>
                                    <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sign up for our newsletter!','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</label>
                                </span>
                            </div>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['popup_login_terms_url']->value) {?>
                            <div class="row">
                                <div class="col-md-12">
                                    <span class="custom-checkbox">
                                        <input type="checkbox" name="register_terms" value="1" />
                                        <span><i class="material-icons checkbox-checked"></i></span>
                                        <label><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I agree the','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</label>
                                        <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['popup_login_terms_url']->value, ENT_QUOTES, 'UTF-8');?>
" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Terms of Use','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</a>
                                    </span>
                                </div>
                            </div>
                        <?php }?>
                    <?php } else { ?>
                        <div class="checkbox pn-checkbox">
                            <label>
                                <input type="checkbox" name="pn_newsletter" value="1" />
                                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Sign up for our newsletter!','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>

                            </label>
                        </div>
                        <?php if ($_smarty_tpl->tpl_vars['popup_login_terms_url']->value) {?>
                            <div class="checkbox pn-checkbox">
                                <label>
                                    <input type="checkbox" name="register_terms" value="1" />
                                    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I agree the','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>

                                </label>
                                <a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['popup_login_terms_url']->value, ENT_QUOTES, 'UTF-8');?>
" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Terms of Use','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>
</a>
                            </div>
                        <?php }?>
                    <?php }?>
                </div>
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'higdpr'),$_smarty_tpl ) );?>

                <div class="form-group">
                    <button type="submit" class="btn btn-default popup_register_btn <?php if ($_smarty_tpl->tpl_vars['popup_template']->value == 'default') {?>btn-primary<?php }?>">
                        <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['module_image_dir']->value, ENT_QUOTES, 'UTF-8');?>
/ajax-loader.gif" class="popup-ajax-loader">
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Register','mod'=>'hipopupnotification'),$_smarty_tpl ) );?>

                    </button>
                </div>
            </form>
        </div>
	</div>

</div>

<?php if ($_smarty_tpl->tpl_vars['login_box_bg']->value) {?>
    <style type="text/css">
    	.popup_signin_popup #login-and-register-popup-sign{
    		background-image: url('<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['login_box_bg']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
');
    		background-repeat: <?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['login_box_bg_repeat']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
;
    	}
        .popup_signin_popup .popup_authentication_box {
            background: transparent;
        }
    </style>
<?php }
}
}
