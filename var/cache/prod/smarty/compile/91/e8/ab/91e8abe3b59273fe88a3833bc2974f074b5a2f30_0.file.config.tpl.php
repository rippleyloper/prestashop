<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:52
  from '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/admin/config.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085558b4fa22_19190608',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '91e8abe3b59273fe88a3833bc2974f074b5a2f30' => 
    array (
      0 => '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/admin/config.tpl',
      1 => 1611158743,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085558b4fa22_19190608 (Smarty_Internal_Template $_smarty_tpl) {
?><style>
	.cdc-info {
		background: #d9edf7;
		color: #1b809e;
		padding: 7px;
		/*border-left: solid 3px #1b809e;*/
		margin-top: 50px;
		font-weight: normal;
	}

	.cdc-warning-box {
		background: #FFF3D7;
		color: #D2A63C;
		padding: 16px;
		font-weight: bold;
		border: solid 2px #fcc94f;
		margin: 30px 0;
		text-align: center;
		font-size: 1.2em;
	}
</style>
<div class="bootstrap">


<div class="panel text-center">
	<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['module_dir']->value,'htmlall','UTF-8' ));?>
/logo.png" >
	<h1>
		Google Tag Manager Enhanced E-commerce
		<br /><small>GTM integration + Enhanced E-commerce + Google Customer Reviews</small>
	</h1>
</div>

<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
    	<a href="#tagmanager" role="tab" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Google Tag Manager','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>
    </li>
    <li role="presentation">
    	<a href="#customerreviews" role="tab" data-toggle="tab"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Google Customer Reviews','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>
    </li>
  </ul>

	<!-- Tab panes -->
	<form id="configuration_form" class="defaultForm form-horizontal cdc_googletagmanager" method="post" action="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['form_action']->value,'htmlall','UTF-8' ));?>
">
		<div class="tab-content">

			<!-- GENERAL GTM SETTINGS -->
			<div role="tabpanel" class="tab-pane active panel" id="tagmanager">
				<div class="panel-body">

					<div class="form-group">
						<label class="control-label col-lg-3"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Base configuration','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></label>
						<div class="margin-form col-lg-9"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable Google Tag Manager','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-9">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_ENABLE" id="ENABLE_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_ENABLE']->value) {?>checked<?php }?> /><label for="ENABLE_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_ENABLE" id="ENABLE_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_ENABLE']->value) {?>checked<?php }?> /><label for="ENABLE_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_GTMID">Google Tag Manager ID</label>
						<div class="margin-form col-lg-3">
							<input type="text" class="form-control" id="CDC_GTM_GTMID" placeholder="GTM-XXXXXX" name="CDC_GTM_GTMID" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['CDC_GTM_GTMID']->value,'htmlall','UTF-8' ));?>
">
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable Automatic Re-send Orders','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_ENABLE_RESEND" id="ENABLE_RESEND_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_ENABLE_RESEND']->value) {?>checked<?php }?> /><label for="ENABLE_RESEND_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_ENABLE_RESEND" id="ENABLE_RESEND_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_ENABLE_RESEND']->value) {?>checked<?php }?> /><label for="ENABLE_RESEND_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'When an order couldn\'t be sent in the first place, the module tries to re-send it later. However, the date of the order shown in Analytics will be the date when the order is sent and not the real date of the order.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_RESEND_DAYS">Maximum days to re-send orders</label>
						<div class="margin-form col-lg-3">
							<input type="number" class="form-control" id="CDC_GTM_RESEND_DAYS" name="CDC_GTM_RESEND_DAYS" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['CDC_GTM_RESEND_DAYS']->value,'htmlall','UTF-8' ));?>
" min="1" step="1">
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Maximum number of days after the order has been placed to re-send it. If this number is too small, some orders won\'t be re-sent. If the number is too big, re-sent orders may be out of sync (date too long after the real date).','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
						</div>
					</div>


                    <div class="form-group">
                        <label class="control-label col-lg-3" for="CDC_GTM_MAX_CAT_ITEMS">Maximum category items to send in datalayer</label>
                        <div class="margin-form col-lg-3">
                            <input type="number" class="form-control" id="CDC_GTM_MAX_CAT_ITEMS" name="CDC_GTM_MAX_CAT_ITEMS" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['CDC_GTM_MAX_CAT_ITEMS']->value,'htmlall','UTF-8' ));?>
" min="1" step="1">
                        </div>
                        <div class="col-lg-6">
                            <p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Maximum number of items sent to datalayer in category pages. If ou have big product name, please lower this value so the datalayer does not exceed size limit.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
                        </div>
                    </div>


                    <hr />

                    <div class="form-group">
                        <label class="control-label col-lg-3"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Customize data format','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></label>
                        <div class="margin-form col-lg-9"></div>
                    </div>


					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Always display variant ID','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_DISPLAY_VARIANT_ID" id="DISPLAY_VARIANT_ID_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_DISPLAY_VARIANT_ID']->value) {?>checked<?php }?> /><label for="DISPLAY_VARIANT_ID_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_DISPLAY_VARIANT_ID" id="DISPLAY_VARIANT_ID_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_DISPLAY_VARIANT_ID']->value) {?>checked<?php }?> /><label for="DISPLAY_VARIANT_ID_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Always display variant id with product id (PRODUCT_ID-VARIANT_ID)','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
						</div>
					</div>

                    <div class="form-group">
                        <label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Display category hierarchy','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
                        <div class="margin-form col-lg-3">
                            <span class="switch prestashop-switch fixed-width-lg">
                                <input type="radio" name="CDC_GTM_CATEGORY_HIERARCHY" id="CATEGORY_HIERARCHY_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_CATEGORY_HIERARCHY']->value) {?>checked<?php }?> /><label for="CATEGORY_HIERARCHY_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
                                <input type="radio" name="CDC_GTM_CATEGORY_HIERARCHY" id="CATEGORY_HIERARCHY_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_CATEGORY_HIERARCHY']->value) {?>checked<?php }?> /><label for="CATEGORY_HIERARCHY_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
                                <a class="slide-button btn"></a>
                            </span>
                        </div>
                        <div class="col-lg-6">
                            <p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Display category with all parents categories: "/cat1/cat2/cat3" instead of "cat3"','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
                        </div>
                    </div>

                    
                    <div class="form-group">
                        <label class="control-label col-lg-3" for="CDC_GTM_PRODUCT_NAME_FIELD"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Product name','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
                        <div class="margin-form col-lg-9 form-inline">
                            <?php $_smarty_tpl->_assignInScope('product_name_fields', array('name','link_rewrite','id'));?>
                            <select class="form-control" id="CDC_GTM_PRODUCT_NAME_FIELD" name="CDC_GTM_PRODUCT_NAME_FIELD">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product_name_fields']->value, 'product_name_field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product_name_field']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['product_name_field']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['product_name_field']->value == $_smarty_tpl->tpl_vars['CDC_GTM_PRODUCT_NAME_FIELD']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['product_name_field']->value;?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-lg-3" for="CDC_GTM_CATEGORY_NAME_FIELD"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Category name','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
                        <div class="margin-form col-lg-9 form-inline">
                            <?php $_smarty_tpl->_assignInScope('category_name_fields', array('name','link_rewrite','id'));?>
                            <select class="form-control" id="CDC_GTM_CATEGORY_NAME_FIELD" name="CDC_GTM_CATEGORY_NAME_FIELD">
                                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['category_name_fields']->value, 'category_name_field');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category_name_field']->value) {
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['category_name_field']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['category_name_field']->value == $_smarty_tpl->tpl_vars['CDC_GTM_CATEGORY_NAME_FIELD']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['category_name_field']->value;?>
</option>
                                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
                            </select>
                        </div>
                    </div>

					<hr />

					<div class="form-group">
						<label class="control-label col-lg-3"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Google Analytics User ID feature','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></label>
						<div class="margin-form col-lg-9"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add User ID in datalayer','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_ENABLE_USERID" id="ENABLE_USERID_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_ENABLE_USERID']->value) {?>checked<?php }?> /><label for="ENABLE_USERID_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_ENABLE_USERID" id="ENABLE_USERID_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_ENABLE_USERID']->value) {?>checked<?php }?> /><label for="ENABLE_USERID_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add variables "userId" and "userLogged" in datalayer','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
.</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add User ID in datalayer for guests','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_ENABLE_GUESTID" id="ENABLE_GUESTID_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_ENABLE_GUESTID']->value) {?>checked<?php }?> /><label for="ENABLE_GUESTID_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_ENABLE_GUESTID" id="ENABLE_GUESTID_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_ENABLE_GUESTID']->value) {?>checked<?php }?> /><label for="ENABLE_GUESTID_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Variable "userId" is set with guest_[GUEST_ID] when user is guest. This option allows tracking of user not loggued accross multiple sessions','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
.</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Asynchronous loading of User Info','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_ASYNC_USER_INFO" id="ASYNC_USER_INFO_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_ASYNC_USER_INFO']->value) {?>checked<?php }?> /><label for="ASYNC_USER_INFO_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_ASYNC_USER_INFO" id="ASYNC_USER_INFO_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_ASYNC_USER_INFO']->value) {?>checked<?php }?> /><label for="ASYNC_USER_INFO_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'If you have a full page cache system, you will need to load user informations asynchronously','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
.</p>
						</div>
					</div>

					<hr />

					<div class="form-group">
						<label class="control-label col-lg-3"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Remarketing','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></label>
						<div class="margin-form col-lg-9"></div>
					</div>
					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable Remarketing Parameters','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-9">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_REMARKETING_ENABLE" id="REMARKETING_ENABLE_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_REMARKETING_ENABLE']->value) {?>checked<?php }?> /><label for="REMARKETING_ENABLE_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_REMARKETING_ENABLE" id="REMARKETING_ENABLE_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_REMARKETING_ENABLE']->value) {?>checked<?php }?> /><label for="REMARKETING_ENABLE_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_REMARKETING_PRODUCTID"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Product ID in Merchant Center','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-9 form-inline">
							<?php $_smarty_tpl->_assignInScope('product_identifiers', array('id','reference','ean13','upc'));?>
							<select class="form-control" id="CDC_GTM_REMARKETING_PRODUCTID" name="CDC_GTM_REMARKETING_PRODUCTID">
								<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['product_identifiers']->value, 'product_identifier');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product_identifier']->value) {
?>
								<option value="<?php echo $_smarty_tpl->tpl_vars['product_identifier']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['product_identifier']->value == $_smarty_tpl->tpl_vars['CDC_GTM_REMARKETING_PRODUCTID']->value) {?>selected="selected"<?php }?>><?php echo $_smarty_tpl->tpl_vars['product_identifier']->value;?>
</option>
								<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
							</select>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_REMARKETING_PRODUCTPREF"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Product ID prefix','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<input type="text" class="form-control" id="CDC_GTM_REMARKETING_PRODUCTPREF" placeholder="" name="CDC_GTM_REMARKETING_PRODUCTPREF" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['CDC_GTM_REMARKETING_PRODUCTPREF']->value,'htmlall','UTF-8' ));?>
">
						</div>
                        <div class="col-lg-6">
                            <p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You can add variables to the product id prefix. Available variables are: {lang} / {LANG} -> replaced with current language ISO code (en, fr...). For example you can use: FEED1_{LANG}_','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
                        </div>
					</div>

				</div>
			</div>

			<!-- GOOGLE CUSTOMER REVIEWS SETTINGS -->
			<div role="tabpanel" class="tab-pane panel" id="customerreviews" <?php if ((version_compare($_smarty_tpl->tpl_vars['CDC_PS_VERSION']->value,'1.6','<'))) {?>style="display: block;"<?php }?>>
				<div class="panel-body">
					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable Google Customer Reviews','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_GCR_ENABLE" id="GCR_ENABLE_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_GCR_ENABLE']->value) {?>checked<?php }?> /><label for="GCR_ENABLE_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_GCR_ENABLE" id="GCR_ENABLE_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_GCR_ENABLE']->value) {?>checked<?php }?> /><label for="GCR_ENABLE_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Add the Customer Reviews badge code','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_GCR_BADGE_CODE" id="GCR_BADGE_CODE_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_GCR_BADGE_CODE']->value) {?>checked<?php }?> /><label for="GCR_BADGE_CODE_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_GCR_BADGE_CODE" id="GCR_BADGE_CODE_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_GCR_BADGE_CODE']->value) {?>checked<?php }?> /><label for="GCR_BADGE_CODE_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You must set this option to YES, unless you have already added the badge code in your source file or with Google Tag Manager','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
.</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_GCR_MERCHANT_ID"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Merchant ID','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<input type="text" class="form-control" id="CDC_GTM_GCR_MERCHANT_ID" placeholder="000000" name="CDC_GTM_GCR_MERCHANT_ID" value="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['CDC_GTM_GCR_MERCHANT_ID']->value,'htmlall','UTF-8' ));?>
">
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You can find your Google Merchant ID ','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
<a href="https://merchants.google.com/mc/customerreviews/configuration" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'in your Google merchants center','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>.</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_GCR_BADGE_POSITION"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Badge position','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<select class="form-control" id="CDC_GTM_GCR_BADGE_POSITION" name="CDC_GTM_GCR_BADGE_POSITION">
								<option value="BOTTOM_RIGHT" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_GCR_BADGE_POSITION']->value == "BOTTOM_RIGHT") {?>selected="selected"<?php }?>>
									BOTTOM_RIGHT
								</option>
								<option value="BOTTOM_LEFT" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_GCR_BADGE_POSITION']->value == "BOTTOM_LEFT") {?>selected="selected"<?php }?>>
									BOTTOM_LEFT
								</option>
							</select>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Position of the Google Customer Reviews badge.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
						</div>
					</div>

					<hr />

					<div class="form-group">
						<label class="control-label col-lg-3" rel="only_map"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Enable the order confirmation module','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<span class="switch prestashop-switch fixed-width-lg">
								<input type="radio" name="CDC_GTM_GCR_ORDER_CODE" id="GCR_ORDER_CODE_ON"  value="1" <?php if ($_smarty_tpl->tpl_vars['CDC_GTM_GCR_ORDER_CODE']->value) {?>checked<?php }?> /><label for="GCR_ORDER_CODE_ON" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Yes','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<input type="radio" name="CDC_GTM_GCR_ORDER_CODE" id="GCR_ORDER_CODE_OFF" value="0" <?php if (!$_smarty_tpl->tpl_vars['CDC_GTM_GCR_ORDER_CODE']->value) {?>checked<?php }?> /><label for="GCR_ORDER_CODE_OFF" class="label-checkbox"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
								<a class="slide-button btn"></a>
							</span>
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You must set this option to YES, unless you have already added the order confirmation code in your order confirmation page','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
.</p>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label col-lg-3" for="CDC_GTM_GCR_DELIVERY_DAYS"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Delivery delay (days)','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</label>
						<div class="margin-form col-lg-3">
							<input type="number" class="form-control" id="CDC_GTM_GCR_DELIVERY_DAYS" placeholder="X" name="CDC_GTM_GCR_DELIVERY_DAYS" value="<?php echo $_smarty_tpl->tpl_vars['CDC_GTM_GCR_DELIVERY_DAYS']->value;?>
" min="0" step="1">
						</div>
						<div class="col-lg-6">
							<p class="cdc-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The estimated number of days before an order is delivered.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div class="text-right">
			<button type="submit" value="1" id="configuration_form_submit_btn" name="submitcdc_googletagmanager" class="button btn btn-default">
				<i class="process-icon-save"></i> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Save All','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>

			</button>
		</div>
	</form>


	<div style="margin-top: 10px;">
		<p>
			<a href="https://comptoirducode.com/prestashop/modules/google-tag-manager/documentation-google-tag-manager-prestashop/" target="_blank" class="btn btn-default"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Read the module documentation','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>

            <a href="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&force_check_hooks" class="btn btn-default"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check hooks installation','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>

            <a href="http://addons.prestashop.com/ratings.php?id_product=23806" class="btn btn-default"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Rate the module','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>

            <a href="https://addons.prestashop.com/contact-community.php?id_product=23806" class="btn btn-default"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Contact support','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>
		</p>

	</div>

	<div style="margin-top: 15px; border-top: 1px dotted #999;padding-top: 15px;">
		<p>
			<b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'This module fits your needs?','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b><br>
			<a href="http://addons.prestashop.com/ratings.php?id_product=23806" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Thanks to rate-us on Prestashop marketplace','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>. <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The more we have ratings and satisfied customers, the more we enjoy to develop new features for you!','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>

		</p>
	</div>


</div>
</div>


<?php echo '<script'; ?>
>
$(document).ready(function() {

	$('#CDC_GTM_GTS_BADGE_POSITION').change(function() {
		if($(this).val() == 'USER_DEFINED') {
			$('#wrapper_CDC_GTM_GTS_CONTAINER').show(400).highlight();
		} else {
			$('#wrapper_CDC_GTM_GTS_CONTAINER').hide(400);
		}
	}).change();


 $('input[type=radio][name=bedStatus]').change(function() {
        if (this.value == 'allot') {
            alert("Allot Thai Gayo Bhai");
        }
        else if (this.value == 'transfer') {
            alert("Transfer Thai Gayo");
        }
    });
});
<?php echo '</script'; ?>
>
<?php }
}
