<?php
/* Smarty version 3.1.33, created on 2021-01-20 15:48:32
  from 'module:smartblogviewstemplatesfr' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60087b0034d5b4_09275727',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'a053b13f1566488bf23919af737da766e9ccec8d' => 
    array (
      0 => 'module:smartblogviewstemplatesfr',
      1 => 1610129316,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
    'module:smartblog/views/templates/front/category_loop.tpl' => 1,
  ),
),false)) {
function content_60087b0034d5b4_09275727 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>
 

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_86099528760087b00159a77_94806796', 'head_seo');
?>


<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_7954402760087b001e03e5_45998093', 'content');
$_smarty_tpl->inheritance->endChild($_smarty_tpl, $_smarty_tpl->tpl_vars['layout_category']->value);
}
/* {block 'head_seo'} */
class Block_86099528760087b00159a77_94806796 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'head_seo' => 
  array (
    0 => 'Block_86099528760087b00159a77_94806796',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

    <title> <?php if ($_smarty_tpl->tpl_vars['title_category']->value != '') {
echo htmlspecialchars($_smarty_tpl->tpl_vars['title_category']->value, ENT_QUOTES, 'UTF-8');
} else {
echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All Blog News','mod'=>'smartblog'),$_smarty_tpl ) );
}?></title>
<?php
}
}
/* {/block 'head_seo'} */
/* {block 'content'} */
class Block_7954402760087b001e03e5_45998093 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'content' => 
  array (
    0 => 'Block_7954402760087b001e03e5_45998093',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

<section id="main">
    <?php if ($_smarty_tpl->tpl_vars['postcategory']->value == '') {?>
        <?php if ($_smarty_tpl->tpl_vars['title_category']->value != '') {?>
            <p class="error"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No Post in Category','mod'=>'smartblog'),$_smarty_tpl ) );?>
</p>
        <?php } else { ?>
            <p class="error"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'No Post in Blog','mod'=>'smartblog'),$_smarty_tpl ) );?>
</p>
        <?php }?>
    <?php } else { ?>
        <?php if ($_smarty_tpl->tpl_vars['smartdisablecatimg']->value == '1') {?>
            <?php $_smarty_tpl->_assignInScope('activeimgincat', '0');?>
            <?php $_smarty_tpl->_assignInScope('activeimgincat', $_smarty_tpl->tpl_vars['smartshownoimg']->value);?> 
            <?php if ($_smarty_tpl->tpl_vars['title_category']->value != '') {?>        
                <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['categoryinfo']->value, 'category');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['category']->value) {
?>
                    <div id="sdsblogCategory">
                        <?php if (($_smarty_tpl->tpl_vars['cat_image']->value != "no" && $_smarty_tpl->tpl_vars['activeimgincat']->value == 0) || $_smarty_tpl->tpl_vars['activeimgincat']->value == 1) {?>
                            <img alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['category']->value['meta_title'], ENT_QUOTES, 'UTF-8');?>
" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value->getMediaLink($_smarty_tpl->tpl_vars['smart_module_dir']->value), ENT_QUOTES, 'UTF-8');?>
/smartblog/views/img/category/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['cat_image']->value, ENT_QUOTES, 'UTF-8');?>
-single-default.jpg" class="imageFeatured">
                        <?php }?>
                        <div class="catDesc"><?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['category']->value['description'],'htmlall','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
</div>
                    </div>
                <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>  
            <?php }?>
        <?php }?>
        <div id="smartblogcat" class="block">
            <?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['postcategory']->value, 'post');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['post']->value) {
?>
                <?php $_smarty_tpl->_subTemplateRender('module:smartblog/views/templates/front/category_loop.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array('postcategory'=>$_smarty_tpl->tpl_vars['postcategory']->value), 0, true);
?>
            <?php
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
        </div>
        <?php if (!empty($_smarty_tpl->tpl_vars['pagenums']->value)) {?>
            <div class="blog_pagination">
                <div class="pagination">
                    <div class="results pagination-left"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Showing','mod'=>'smartblog'),$_smarty_tpl ) );?>
 <?php if ($_smarty_tpl->tpl_vars['limit_start']->value != 0) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['limit_start']->value, ENT_QUOTES, 'UTF-8');
} else { ?>1<?php }?> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'to','mod'=>'smartblog'),$_smarty_tpl ) );?>
 <?php if ($_smarty_tpl->tpl_vars['limit_start']->value+$_smarty_tpl->tpl_vars['limit']->value >= $_smarty_tpl->tpl_vars['total']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['total']->value, ENT_QUOTES, 'UTF-8');
} else {
echo htmlspecialchars($_smarty_tpl->tpl_vars['limit_start']->value+$_smarty_tpl->tpl_vars['limit']->value, ENT_QUOTES, 'UTF-8');
}?> <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'of','mod'=>'smartblog'),$_smarty_tpl ) );?>
 <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['total']->value, ENT_QUOTES, 'UTF-8');?>
 (<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['c']->value, ENT_QUOTES, 'UTF-8');?>
 <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Pages','mod'=>'smartblog'),$_smarty_tpl ) );?>
)</div>
                    <ul class="pagination_bottom page-list text-sm-center">
                        <?php
$_smarty_tpl->tpl_vars['k'] = new Smarty_Variable(null, $_smarty_tpl->isRenderingCache);$_smarty_tpl->tpl_vars['k']->step = 1;$_smarty_tpl->tpl_vars['k']->total = (int) ceil(($_smarty_tpl->tpl_vars['k']->step > 0 ? $_smarty_tpl->tpl_vars['pagenums']->value+1 - (0) : 0-($_smarty_tpl->tpl_vars['pagenums']->value)+1)/abs($_smarty_tpl->tpl_vars['k']->step));
if ($_smarty_tpl->tpl_vars['k']->total > 0) {
for ($_smarty_tpl->tpl_vars['k']->value = 0, $_smarty_tpl->tpl_vars['k']->iteration = 1;$_smarty_tpl->tpl_vars['k']->iteration <= $_smarty_tpl->tpl_vars['k']->total;$_smarty_tpl->tpl_vars['k']->value += $_smarty_tpl->tpl_vars['k']->step, $_smarty_tpl->tpl_vars['k']->iteration++) {
$_smarty_tpl->tpl_vars['k']->first = $_smarty_tpl->tpl_vars['k']->iteration === 1;$_smarty_tpl->tpl_vars['k']->last = $_smarty_tpl->tpl_vars['k']->iteration === $_smarty_tpl->tpl_vars['k']->total;?>
                            <?php if ($_smarty_tpl->tpl_vars['title_category']->value != '') {?>
                                <?php $_smarty_tpl->_assignInScope('options', null);?>
                                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['page'] = $_smarty_tpl->tpl_vars['k']->value+1;
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
                                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['id_category'] = $_smarty_tpl->tpl_vars['id_category']->value;
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
                                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['slug'] = $_smarty_tpl->tpl_vars['cat_link_rewrite']->value;
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
                            <?php } else { ?>
                                <?php $_smarty_tpl->_assignInScope('options', null);?>
                                <?php $_tmp_array = isset($_smarty_tpl->tpl_vars['options']) ? $_smarty_tpl->tpl_vars['options']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array['page'] = $_smarty_tpl->tpl_vars['k']->value+1;
$_smarty_tpl->_assignInScope('options', $_tmp_array);?>
                            <?php }?>
                            <?php if (($_smarty_tpl->tpl_vars['k']->value+1) == $_smarty_tpl->tpl_vars['c']->value) {?>
                                <li class="current"><a class="disabled"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value+1, ENT_QUOTES, 'UTF-8');?>
</a></li>
                            <?php } else { ?>
                                <?php if ($_smarty_tpl->tpl_vars['title_category']->value != '') {?>
                                    <li><a class="" href="<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_category_pagination',$_smarty_tpl->tpl_vars['options']->value), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value+1, ENT_QUOTES, 'UTF-8');?>
</a></li>
                                <?php } else { ?>
                                    <li><a class="" href="<?php echo htmlspecialchars(smartblog::GetSmartBlogLink('smartblog_list_pagination',$_smarty_tpl->tpl_vars['options']->value), ENT_QUOTES, 'UTF-8');?>
"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['k']->value+1, ENT_QUOTES, 'UTF-8');?>
</a></li>
                                <?php }?>
                            <?php }?>
                        <?php }
}
?>
                    </ul>
                </div>
            </div>
        <?php }?>
    <?php }?>
    <?php if (isset($_smarty_tpl->tpl_vars['smartcustomcss']->value)) {?>
        <style>
            <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['smartcustomcss']->value, ENT_QUOTES, 'UTF-8');?>

        </style>
    <?php }?>
</section>
<?php
}
}
/* {/block 'content'} */
}
