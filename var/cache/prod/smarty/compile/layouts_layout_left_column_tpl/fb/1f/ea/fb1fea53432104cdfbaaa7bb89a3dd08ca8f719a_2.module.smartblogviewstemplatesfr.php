<?php
/* Smarty version 3.1.33, created on 2021-01-20 15:48:32
  from 'module:smartblogviewstemplatesfr' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60087b00dfa5f2_26650487',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'fb1fea53432104cdfbaaa7bb89a3dd08ca8f719a' => 
    array (
      0 => 'module:smartblogviewstemplatesfr',
      1 => 1610129316,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60087b00dfa5f2_26650487 (Smarty_Internal_Template $_smarty_tpl) {
?> 
<div itemtype="#" itemscope="" class="sdsarticleCat clearfix">
	<div id="smartblogpost-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['id_post'], ENT_QUOTES, 'UTF-8');?>
">
			<?php $_smarty_tpl->_assignInScope('options', null);?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['id_post'] = $_smarty_tpl->tpl_vars['post']->value['id_post'];
$_smarty_tpl->_assignInScope('options', $_tmp_array);?> 
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['slug'] = $_smarty_tpl->tpl_vars['post']->value['link_rewrite'];
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
			<div class="row">
		<div class="articleContent col-sm-5 col-xs-5">
			<a itemprop="url" href="<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value), ENT_QUOTES, 'UTF-8');?>
" title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['meta_title'], ENT_QUOTES, 'UTF-8');?>
" class="imageFeaturedLink">
				<?php $_smarty_tpl->_assignInScope('activeimgincat', '0');?>
				<?php $_smarty_tpl->_assignInScope('activeimgincat', $_smarty_tpl->tpl_vars['smartshownoimg']->value);?> 
				<?php if (($_smarty_tpl->tpl_vars['post']->value['post_img'] != "no" && $_smarty_tpl->tpl_vars['activeimgincat']->value == 0) || $_smarty_tpl->tpl_vars['activeimgincat']->value == 1) {?>
					<img itemprop="image" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['meta_title'], ENT_QUOTES, 'UTF-8');?>
" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink($_smarty_tpl->tpl_vars['smart_module_dir']->value), ENT_QUOTES, 'UTF-8');?>
/smartblog/views/img/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['post_img'], ENT_QUOTES, 'UTF-8');?>
-single-default.jpg" class="imageFeatured">
				<?php }?>
			</a>
		</div>
		<div class="blog_desc col-sm-7 col-xs-7">
		<div class="sdsarticleHeader">
			<p class='sdstitle_block'><a title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['meta_title'], ENT_QUOTES, 'UTF-8');?>
" href='<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value), ENT_QUOTES, 'UTF-8');?>
'><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['meta_title'], ENT_QUOTES, 'UTF-8');?>
</a></p>
		</div>
		<?php $_smarty_tpl->_assignInScope('options', null);?>
		<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['id_post'] = $_smarty_tpl->tpl_vars['post']->value['id_post'];
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
		<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['slug'] = $_smarty_tpl->tpl_vars['post']->value['link_rewrite'];
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
		<?php $_smarty_tpl->_assignInScope('catlink', null);?>
		<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['catlink']) ? $_smarty_tpl->tpl_vars['catlink']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['id_category'] = $_smarty_tpl->tpl_vars['post']->value['id_category'];
$_smarty_tpl->_assignInScope('catlink', $_tmp_array);?>
		<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['catlink']) ? $_smarty_tpl->tpl_vars['catlink']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['slug'] = $_smarty_tpl->tpl_vars['post']->value['cat_link_rewrite'];
$_smarty_tpl->_assignInScope('catlink', $_tmp_array);?>
		<span class="blogdetail">
			<span class="ttpost"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Posted by','mod'=>'smartblog'),$_smarty_tpl ) );?>
 </span>
			<?php if ($_smarty_tpl->tpl_vars['smartshowauthor']->value == 1) {?>&nbsp;
				<span class="author" itemprop="author"><i class="material-icons user">&#xE7FF;</i>&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['smartshowauthorstyle']->value != 0) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['firstname'], ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['lastname'], ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['lastname'], ENT_QUOTES, 'UTF-8');?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['firstname'], ENT_QUOTES, 'UTF-8');
}?></span>&nbsp;&nbsp;
			<?php }?>
			<span class="articleSection" itemprop="articleSection"><a href="<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_category',$_smarty_tpl->tpl_vars['catlink']->value), ENT_QUOTES, 'UTF-8');?>
"><i class="material-icons tags">&#xE54E;</i>&nbsp;&nbsp;<?php if ($_smarty_tpl->tpl_vars['title_category']->value != '') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['title_category']->value, ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['cat_name'], ENT_QUOTES, 'UTF-8');
}?></a></span>&nbsp;&nbsp;
			<span class="blogcomment"><a title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['totalcomment'], ENT_QUOTES, 'UTF-8');?>
 Comments" href="<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value), ENT_QUOTES, 'UTF-8');?>
#articleComments"><i class="material-icons comments">&#xE0B9;</i>&nbsp;&nbsp;<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['totalcomment'], ENT_QUOTES, 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' Comments','mod'=>'smartblog'),$_smarty_tpl ) );?>
</a></span>
			<?php if ($_smarty_tpl->tpl_vars['smartshowviewed']->value == 1) {?>&nbsp;
				<span class="viewed"><i class="material-icons eye">&#xE417;</i>&nbsp;&nbsp;<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>' views','mod'=>'smartblog'),$_smarty_tpl ) );?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['viewed'], ENT_QUOTES, 'UTF-8');?>
)</span>
			<?php }?>
		</span>
		<div class="sdsarticle-des">
			<span itemprop="description" class="clearfix">
				<div id="lipsum">
					<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'truncate' ][ 0 ], array( call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['post']->value['short_description'],'htmlall','UTF-8' )),300,'...' )), ENT_QUOTES, 'UTF-8');?>

				</div>
			</span>
		</div>
		<div class="sdsreadMore">
			<?php $_smarty_tpl->_assignInScope('options', null);?>
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['id_post'] = $_smarty_tpl->tpl_vars['post']->value['id_post'];
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>  
			<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['slug'] = $_smarty_tpl->tpl_vars['post']->value['link_rewrite'];
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>  
			<span class="more">
				<a title="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['post']->value['meta_title'], ENT_QUOTES, 'UTF-8');?>
" href="<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_post',$_smarty_tpl->tpl_vars['options']->value), ENT_QUOTES, 'UTF-8');?>
" class="r_more"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Read more','mod'=>'smartblog'),$_smarty_tpl ) );?>
</a>
			</span>
		</div>
		</div>
		</div>
	</div>
</div><?php }
}
