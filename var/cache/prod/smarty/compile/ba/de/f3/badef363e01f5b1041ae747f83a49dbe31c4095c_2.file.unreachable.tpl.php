<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:18:00
  from '/var/www/html/ps_dev/themes/PRS01/templates/checkout/_partials/steps/unreachable.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600857b8275242_91326948',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'badef363e01f5b1041ae747f83a49dbe31c4095c' => 
    array (
      0 => '/var/www/html/ps_dev/themes/PRS01/templates/checkout/_partials/steps/unreachable.tpl',
      1 => 1610129334,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600857b8275242_91326948 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_loadInheritance();
$_smarty_tpl->inheritance->init($_smarty_tpl, false);
$_smarty_tpl->inheritance->instanceBlock($_smarty_tpl, 'Block_2100868794600857b8273425_84241605', 'step');
?>

<?php }
/* {block 'step'} */
class Block_2100868794600857b8273425_84241605 extends Smarty_Internal_Block
{
public $subBlocks = array (
  'step' => 
  array (
    0 => 'Block_2100868794600857b8273425_84241605',
  ),
);
public function callBlock(Smarty_Internal_Template $_smarty_tpl) {
?>

  <section class="checkout-step -unreachable" id="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['identifier']->value, ENT_QUOTES, 'UTF-8');?>
">
    <h1 class="step-title h3">
      <span class="step-number"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['position']->value, ENT_QUOTES, 'UTF-8');?>
</span> <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['title']->value, ENT_QUOTES, 'UTF-8');?>

    </h1>
  </section>
<?php
}
}
/* {/block 'step'} */
}
