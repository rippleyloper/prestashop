<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:26
  from 'module:productcommentsviewstempl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_6008553e37b159_06891262',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'e9e4d0b935584380ea8beb3f467908e1cd2486f5' => 
    array (
      0 => 'module:productcommentsviewstempl',
      1 => 1610129329,
      2 => 'module',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_6008553e37b159_06891262 (Smarty_Internal_Template $_smarty_tpl) {
echo '<script'; ?>
 type="text/javascript">
  document.addEventListener("DOMContentLoaded", function() {
    const $ = jQuery;
    const productId = <?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
;
    const productReview = $('#product-list-reviews-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
');
	const productReviewc = $('#product-list-reviews-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
 .comments-nb');
	const productReviewg = $('#product-list-reviews-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
 .grade-stars');
    const productCommentGradeUrl = '<?php echo $_smarty_tpl->tpl_vars['product_comment_grade_url']->value;?>
';
    $.get(productCommentGradeUrl, { id_product: productId }, function(jsonResponse) {
      var jsonData = false;
      try {
        jsonData = JSON.parse(jsonResponse);
      } catch (e) {
      }

      if (jsonData) {
        if (jsonData.id_product && (jsonData.comments_nb != 0)) {
			$(productReviewc).html('('+jsonData.comments_nb+')');
		  $(productReviewg).rating({ grade: jsonData.average_grade, starWidth: 16 });		  
		  productReview.closest('.thumbnail-container').addClass('has-reviews');
		  productReview.css('visibility', 'visible');
        }
      }
    });
  });
<?php echo '</script'; ?>
>
<?php if ($_smarty_tpl->tpl_vars['nb_comments']->value != 0) {?>
<div id="product-list-reviews-<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['product']->value['id'], ENT_QUOTES, 'UTF-8');?>
" class="product-list-reviews">
  <div class="grade-stars small-stars"></div>
  <div class="comments-nb"></div>
</div>
<?php }?>

<?php if ($_smarty_tpl->tpl_vars['nb_comments']->value != 0) {?>
<div itemprop="aggregateRating" itemtype="http://schema.org/AggregateRating" itemscope>
  <meta itemprop="reviewCount" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['nb_comments']->value, ENT_QUOTES, 'UTF-8');?>
" />
  <meta itemprop="ratingValue" content="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['average_grade']->value, ENT_QUOTES, 'UTF-8');?>
" />
</div>
<?php }
}
}
