<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:26
  from 'module:ttcmsparallaxviewstemplat' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553eb1fb68_28447092',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '7beee11c75dd93845a439171a5ce2435911c5400' => 
    array (
      0 => 'module:ttcmsparallaxviewstemplat',
      1 => 1610129321,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553eb1fb68_28447092 (Smarty_Internal_Template $_smarty_tpl) {
if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
	<div id="ttcmsparallax" >
	<div class="parallex" data-source-url="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_url']->value, ENT_QUOTES, 'UTF-8');?>
/cms-parallax.jpg" style="background-image:url('<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['image_url']->value, ENT_QUOTES, 'UTF-8');?>
/cms-parallax.jpg'); background-position: 50% 65.8718%;">
	  <?php echo $_smarty_tpl->tpl_vars['cms_infos']->value['text'];?>

	  </div>
	</div>
<?php }
}
}
