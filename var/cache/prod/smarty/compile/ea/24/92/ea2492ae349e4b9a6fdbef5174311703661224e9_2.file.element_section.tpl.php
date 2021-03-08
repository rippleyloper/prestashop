<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:23
  from '/var/www/html/ps_dev/modules/creativeelements/views/templates/hook/element_section.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553b116b55_15976046',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ea2492ae349e4b9a6fdbef5174311703661224e9' => 
    array (
      0 => '/var/www/html/ps_dev/modules/creativeelements/views/templates/hook/element_section.tpl',
      1 => 1610992939,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553b116b55_15976046 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_assignInScope('settings', $_smarty_tpl->tpl_vars['this']->value->getSettings());
$_smarty_tpl->_assignInScope('classes', array());
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['this']->value->getClassControls(), 'control');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['control']->value) {
?>
	<?php if (empty($_smarty_tpl->tpl_vars['settings']->value[$_smarty_tpl->tpl_vars['control']->value['name']]) || !$_smarty_tpl->tpl_vars['this']->value->isControlVisible($_smarty_tpl->tpl_vars['control']->value)) {
continue 1;
}?>
	<?php $_tmp_array = isset($_smarty_tpl->tpl_vars['classes']) ? $_smarty_tpl->tpl_vars['classes']->value : array();
if (!is_array($_tmp_array) || $_tmp_array instanceof ArrayAccess) {
settype($_tmp_array, 'array');
}
$_tmp_array[] = ($_smarty_tpl->tpl_vars['control']->value['prefix_class']).($_smarty_tpl->tpl_vars['settings']->value[$_smarty_tpl->tpl_vars['control']->value['name']]);
$_smarty_tpl->_assignInScope('classes', $_tmp_array);
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>

<div class="elementor-section elementor-element elementor-element-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->getId(), ENT_QUOTES, 'UTF-8');?>
 elementor-<?php if ($_smarty_tpl->tpl_vars['this']->value->getData('isInner')) {?>inner<?php } else { ?>top<?php }?>-section <?php echo htmlspecialchars(implode(' ',$_smarty_tpl->tpl_vars['classes']->value), ENT_QUOTES, 'UTF-8');?>
" data-element_type="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['this']->value->getName(), ENT_QUOTES, 'UTF-8');?>
" <?php if (!empty($_smarty_tpl->tpl_vars['settings']->value['animation'])) {?>data-animation="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value['animation'], ENT_QUOTES, 'UTF-8');?>
"<?php }?>>
	<?php if ('video' === $_smarty_tpl->tpl_vars['settings']->value['background_background'] && $_smarty_tpl->tpl_vars['settings']->value['background_video_link']) {?>
		<?php $_smarty_tpl->_assignInScope('video_id', \CreativeElements\Utils::getYoutubeIdFromUrl($_smarty_tpl->tpl_vars['settings']->value['background_video_link']));?>
		<div class="elementor-background-video-container elementor-hidden-phone">
		<?php if ($_smarty_tpl->tpl_vars['video_id']->value) {?>
			<div class="elementor-background-video" data-video-id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['video_id']->value, ENT_QUOTES, 'UTF-8');?>
"></div>
		<?php } else { ?>
			<video class="elementor-background-video elementor-html5-video" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['settings']->value['background_video_link'], ENT_QUOTES, 'UTF-8');?>
" autoplay loop muted></video>
		<?php }?>
		</div>
	<?php }?>

	<?php if (in_array($_smarty_tpl->tpl_vars['settings']->value['background_overlay_background'],array('classic','gradient'))) {?>
		<div class="elementor-background-overlay"></div>
	<?php }?>
	<div class="elementor-container elementor-column-gap-<?php echo htmlspecialchars(call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['settings']->value['gap'],'html','UTF-8' )), ENT_QUOTES, 'UTF-8');?>
">
		<div class="elementor-row">
			<?php
$_from = $_smarty_tpl->smarty->ext->_foreach->init($_smarty_tpl, $_smarty_tpl->tpl_vars['this']->value->getChildren(), 'child');
if ($_from !== null) {
foreach ($_from as $_smarty_tpl->tpl_vars['child']->value) {
echo htmlspecialchars($_smarty_tpl->tpl_vars['child']->value->printElement(), ENT_QUOTES, 'UTF-8');
}
}
$_smarty_tpl->smarty->ext->_foreach->restore($_smarty_tpl, 1);?>
		</div>
	</div>
</div>
<?php }
}
