<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:31
  from 'module:ttcategoryfeatureviewstem' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085543e00645_45481532',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '9b5fcd2fbf758086bc3898baa9ddbf680ec639eb' => 
    array (
      0 => 'module:ttcategoryfeatureviewstem',
      1 => 1610632480,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085543e00645_45481532 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('tt_cnt', "1");
$_smarty_tpl->_assignInScope('tt_total', "0");
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tt_categories']->value, 'item_category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item_category']->value) {
$_smarty_tpl->_assignInScope('tt_total', $_smarty_tpl->tpl_vars['tt_total']->value+1);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<div id="tt_category_feature" class="container tt_category_feature">
	<h3 class="tt-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Categorías','mod'=>'ttcategoryfeature'),$_smarty_tpl ) );?>
</h3>
	<?php if (isset($_smarty_tpl->tpl_vars['tt_categories']->value) && count($_smarty_tpl->tpl_vars['tt_categories']->value) > 0) {?>
		<div class="list_carousel responsive clearfix">
			<div id="tt_cat_featured" class="product-list">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['tt_categories']->value, 'item_category', false, NULL, 'tt_categories', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['item_category']->value) {
?>
			<?php $_smarty_tpl->_assignInScope('category', $_smarty_tpl->tpl_vars['item_category']->value['category']);?>
				 <div class="item <?php if (intval((isset($_smarty_tpl->tpl_vars['__smarty_foreach_item_category']->value['first']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_item_category']->value['first'] : null))) {?>first_item<?php } elseif (intval((isset($_smarty_tpl->tpl_vars['__smarty_foreach_item_category']->value['last']) ? $_smarty_tpl->tpl_vars['__smarty_foreach_item_category']->value['last'] : null))) {?>last_item<?php }?>">
					<div class="content">
					
					<?php if (isset($_smarty_tpl->tpl_vars['tt_config']->value->showimg) && $_smarty_tpl->tpl_vars['tt_config']->value->showimg == 1) {?>
						<div class="cat-img col-sm-4">
							<a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value->id_category,$_smarty_tpl->tpl_vars['category']->value->link_rewrite),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value->name,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
								<?php if ($_smarty_tpl->tpl_vars['category']->value->id_image && $_smarty_tpl->tpl_vars['item_category']->value['cat_thumb'] == 1) {?>
									<img src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['path_ssl']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
img/c/<?php echo htmlspecialchars(intval($_smarty_tpl->tpl_vars['category']->value->id_category), ENT_QUOTES, 'UTF-8');?>
_thumb.jpg" alt=""/>
								<?php } else { ?>
									<img class="replace-2x" src="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['path_ssl']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
img/c/<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['iso_code']->value,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
.jpg" alt=""/>
								<?php }?>
							</a>
						</div>
					<?php }?>
										<div class="ttcat-content col-sm-8">
					<div class="cat-infor">
						<h4 class="title">
							<a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['category']->value->id_category,$_smarty_tpl->tpl_vars['category']->value->link_rewrite),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
								<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value->name,'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>

							</a>
						</h4>	
					</div>
					<?php if ($_smarty_tpl->tpl_vars['item_category']->value['sub_cat'] > 0 && isset($_smarty_tpl->tpl_vars['tt_config']->value->showsub) && $_smarty_tpl->tpl_vars['tt_config']->value->showsub == 1) {?>
					<div class="sub-cat">	
						<ul>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['item_category']->value['sub_cat'], 'sub_cat', false, NULL, 'sub_cat_info', array (
));
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['sub_cat']->value) {
?>
								<li>
									<a href="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['link']->value->getCategoryLink($_smarty_tpl->tpl_vars['sub_cat']->value['id_category'],$_smarty_tpl->tpl_vars['sub_cat']->value['link_rewrite']),'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['sub_cat']->value['name'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['sub_cat']->value['name'] )), ENT_QUOTES, 'UTF-8');?>
</a>
								</li>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</ul>
					</div>
					<?php }?>
					</div>

					</div>
				 </div>
			 <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
			 </div>
		<?php if ($_smarty_tpl->tpl_vars['tt_total']->value > 3) {?>
		
		<?php }?>
	</div>
		<?php } else { ?>
		<p class="alert alert-warning"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'There is no category','mod'=>'ttcategoryfeature'),$_smarty_tpl ) );?>
</p>
	<?php }?>
</div><?php }
}
