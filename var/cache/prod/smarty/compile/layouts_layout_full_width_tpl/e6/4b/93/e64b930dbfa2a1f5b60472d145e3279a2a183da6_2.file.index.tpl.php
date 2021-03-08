<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:30
  from '/var/www/html/ps_dev/themes/PRS01/templates/index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600855426cfa04_81649894',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e64b930dbfa2a1f5b60472d145e3279a2a183da6' => 
    array (
      0 => '/var/www/html/ps_dev/themes/PRS01/templates/index.tpl',
      1 => 1610479709,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600855426cfa04_81649894 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, true);
?>


    <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1637860006600855426cc1e0_27222736', 'page_content_container');
?>

<?php $_smarty_tpl->inheritance->endChild($_smarty_tpl, 'page.tpl');
}
/* {block 'home_tab'} */
class Block_1143437280600855426ccd42_52470385 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<div id="hometab" class="home-tab container">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayHomeTab'),$_smarty_tpl ) );?>

		 </div>
	<?php
}
}
/* {/block 'home_tab'} */
/* {block 'page_content_top'} */
class Block_1281374477600855426cda39_17266724 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
}
}
/* {/block 'page_content_top'} */
/* {block 'hook_home'} */
class Block_2100621267600855426ce8e8_59065516 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

            <?php echo $_smarty_tpl->tpl_vars['HOOK_HOME']->value;?>

          <?php
}
}
/* {/block 'hook_home'} */
/* {block 'page_content'} */
class Block_2029945349600855426ce4a7_29146307 extends Smarty_Internal_Block
{
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

          <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2100621267600855426ce8e8_59065516', 'hook_home', $this->tplIndex);
?>

        <?php
}
}
/* {/block 'page_content'} */
/* {block 'page_content_container'} */
class Block_1637860006600855426cc1e0_27222736 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'page_content_container' => 
  array (
    0 => 'Block_1637860006600855426cc1e0_27222736',
  ),
  'home_tab' => 
  array (
    0 => 'Block_1143437280600855426ccd42_52470385',
  ),
  'page_content_top' => 
  array (
    0 => 'Block_1281374477600855426cda39_17266724',
  ),
  'page_content' => 
  array (
    0 => 'Block_2029945349600855426ce4a7_29146307',
  ),
  'hook_home' => 
  array (
    0 => 'Block_2100621267600855426ce8e8_59065516',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

	<div class="homebg">
		<div class="tthometab-title"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'','d'=>'Shop.Theme.Global'),$_smarty_tpl ) );?>
</div>
	</div>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1143437280600855426ccd42_52470385', 'home_tab', $this->tplIndex);
?>

      <section id="content" class="page-home">
        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_1281374477600855426cda39_17266724', 'page_content_top', $this->tplIndex);
?>


        <?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2029945349600855426ce4a7_29146307', 'page_content', $this->tplIndex);
?>

      </section>
    <?php
}
}
/* {/block 'page_content_container'} */
}
