<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:30
  from '/var/www/html/ps_dev/themes/PRS01/templates/_partials/header.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_60085542c4d097_91892553',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '83cc380f74495c815dd615668e3df497746cc6cc' => 
    array (
      0 => '/var/www/html/ps_dev/themes/PRS01/templates/_partials/header.tpl',
      1 => 1610129333,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_60085542c4d097_91892553 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_61877174560085542c46446_17381405', 'header_banner');
?>

<div class="full-header container">
<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_695715660085542c47229_87395021', 'header_top');
?>

<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_69787086660085542c4aef4_90178837', 'header_nav');
?>



</div>
<nav class="header-nav">
    <div class="container">
        <div class="row">
          <div class="hidden-sm-down top-nav col-md-12">
            <div class="col-md-5 col-xs-12">
              <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayNav1'),$_smarty_tpl ) );?>

            </div>
            <div class="col-md-7 right-nav">
                <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayNav2'),$_smarty_tpl ) );?>

            </div>
          </div>
          <div class="hidden-md-up text-sm-center mobile">
            <div class="top-logo" id="_mobile_logo"></div>
		  	<div id="mobile_menu">
            <div class="float-xs-left" id="menu-icon">
              <i class="material-icons">&#xE5D2;</i>
            </div>
            <div class="float-xs-right" id="_mobile_cart"></div>
            <div class="float-xs-right" id="_mobile_user_info"></div>
			</div>
            <div class="clearfix"></div>
          </div>
        </div>
    </div>
  </nav>
<?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
	<?php 
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_23825848760085542c4c5a6_06217348', 'top_column');
?>

<?php }
}
/* {block 'header_banner'} */
class Block_61877174560085542c46446_17381405 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_banner' => 
  array (
    0 => 'Block_61877174560085542c46446_17381405',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div class="header-banner">
    <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayBanner'),$_smarty_tpl ) );?>

  </div>
<?php
}
}
/* {/block 'header_banner'} */
/* {block 'header_top'} */
class Block_695715660085542c47229_87395021 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_top' => 
  array (
    0 => 'Block_695715660085542c47229_87395021',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <div class="header-top">
       <div class="row">
        <div class="col-md-2 hidden-sm-down" id="_desktop_logo">
         <?php if ($_smarty_tpl->tpl_vars['page']->value['page_name'] == 'index') {?>
				<h1>
				<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['base_url'], ENT_QUOTES, 'UTF-8');?>
">
					<img class="logo img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
				</a>
				</h1>
				<?php } else { ?>
					<a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['urls']->value['base_url'], ENT_QUOTES, 'UTF-8');?>
">
					   <img class="logo img-responsive" src="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['logo'], ENT_QUOTES, 'UTF-8');?>
" alt="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['shop']->value['name'], ENT_QUOTES, 'UTF-8');?>
">
					</a>
			 <?php }?>

        </div>
      </div>
      <div id="mobile_top_menu_wrapper" class="row hidden-md-up" style="display:none;">
        <div class="js-top-menu mobile" id="_mobile_top_menu"></div>
        <div class="js-top-menu-bottom">
          <div id="_mobile_currency_selector"></div>
          <div id="_mobile_language_selector"></div>
          <div id="_mobile_contact_link"></div>
        </div>
      </div>
	
  </div>
  <div class="position-static">
		<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayTop'),$_smarty_tpl ) );?>

		<div class="clearfix"></div>
	</div>
  <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayNavFullWidth'),$_smarty_tpl ) );?>

<?php
}
}
/* {/block 'header_top'} */
/* {block 'header_nav'} */
class Block_69787086660085542c4aef4_90178837 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'header_nav' => 
  array (
    0 => 'Block_69787086660085542c4aef4_90178837',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  
<?php
}
}
/* {/block 'header_nav'} */
/* {block 'top_column'} */
class Block_23825848760085542c4c5a6_06217348 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'top_column' => 
  array (
    0 => 'Block_23825848760085542c4c5a6_06217348',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

		<div id="top_column" class="">
			<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['hook'][0], array( array('h'=>'displayTopColumn'),$_smarty_tpl ) );?>

		 </div>
	<?php
}
}
/* {/block 'top_column'} */
}
