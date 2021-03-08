<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:29
  from 'module:ttcategorysliderviewstemp' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085541a96648_43388986',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '6dea89cbbc4a883db9e9eb6a414c66adb3c0c61b' => 
    array (
      0 => 'module:ttcategorysliderviewstemp',
      1 => 1610632859,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'file:catalog/_partials/miniatures/product.tpl' => 1,
  ),
),false)) {
function content_60085541a96648_43388986 (Smarty_Internal_Template $_smarty_tpl) {
?>
<div id="ttcategorytabs" class="tabs products_block container clearfix"> 
<div class="tt-titletab">
	 <h1 class="h1 products-section-title text-uppercase tt-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Categorías top','mod'=>'ttcategoryslider'),$_smarty_tpl ) );?>
</h1> 
	 <ul id="ttcategory-tabs" class="nav nav-tabs clearfix">
		<?php $_smarty_tpl->_assignInScope('count', 0);?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ttcategorysliderinfos']->value, 'ttcategorysliderinfo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value) {
?>
			<li class="nav-item">
				<a href="#tab_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['id'], ENT_QUOTES, 'UTF-8');?>
" data-toggle="tab" class="nav-link <?php if ($_smarty_tpl->tpl_vars['count']->value == 0) {?>active<?php }?>"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['name'], ENT_QUOTES, 'UTF-8');?>
</a>
			</li>
			<?php $_smarty_tpl->_assignInScope('count', $_smarty_tpl->tpl_vars['count']->value+1);?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</ul>
</div>
	<div class="tab-content">
		<?php $_smarty_tpl->_assignInScope('tabcount', 0);?>
		<?php $_smarty_tpl->_assignInScope('tabcat', 0);?>
		<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ttcategorysliderinfos']->value, 'ttcategorysliderinfo');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value) {
?>
			<div id="tab_<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['id'], ENT_QUOTES, 'UTF-8');?>
" class="tab-pane <?php if ($_smarty_tpl->tpl_vars['tabcount']->value == 0) {?>active<?php }?> row">
				<?php if (isset($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['product']) && $_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['product']) {?>
                            <div class="categoryimage col-sm-12">
					<?php if (isset($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['cate_id']) && $_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['cate_id']) {?>
	                        <?php if ($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['id'] == $_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['cate_id']['id_category']) {?>
                                <img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['cate_id']['image'], ENT_QUOTES, 'UTF-8');?>
" alt="" class="category_img"/>
							<?php } else { ?>
								<img src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_url']->value, ENT_QUOTES, 'UTF-8');?>
/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['cate_id']['image'], ENT_QUOTES, 'UTF-8');?>
" alt="" class="category_img"/>
							<?php }?>
                    <?php }?>
                            </div>

						<div class="ttcategory col-sm-12">
						<ul class="products owl-carousel row">
						<?php $_smarty_tpl->_assignInScope('tt_total', 0);?>
							<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['ttcategorysliderinfo']->value['product'], 'product');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['product']->value) {
?>
								<li class="categoryslider">
									<?php $_smarty_tpl->_subTemplateRender("file:catalog/_partials/miniatures/product.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('product'=>$_smarty_tpl->tpl_vars['product']->value), 0, true);
?>
								</li>
								<?php $_smarty_tpl->_assignInScope('tt_total', $_smarty_tpl->tpl_vars['tt_total']->value+1);?>
							<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
						</ul>
					</div>
				<?php } else { ?>
					<div class="alert alert-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No Products in current tab at this time.','mod'=>'ttcategoryslider'),$_smarty_tpl ) );?>
</div>
				<?php }?>
				<?php if ($_smarty_tpl->tpl_vars['tt_total']->value > 5) {?>
					<div class="customNavigation">
						<a class="btn prev ttcategory_prev"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Prev','mod'=>'ttcategoryslider'),$_smarty_tpl ) );?>
</a>
						<a class="btn next ttcategory_next"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Next','mod'=>'ttcategoryslider'),$_smarty_tpl ) );?>
</a>
					</div>
					<?php }?>
			</div> 
		<?php $_smarty_tpl->_assignInScope('tabcount', $_smarty_tpl->tpl_vars['tabcount']->value+1);?>
		<?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
	</div> 
</div><?php }
}
