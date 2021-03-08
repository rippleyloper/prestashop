{**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 *}

{extends file="helpers/form/form.tpl"}

{block name="input_row"}
	{$smarty.block.parent}
	{if $input.name == 'type'}
		<script>
		var $type = $('#type').attr('type', 'hidden');
		var $hook = $('<select name="type">').html(
			'<option value="displayHome">displayHome</option>' +
			'<option value="displayTop">displayTop</option>' +
			'<option value="displayBanner">displayBanner</option>' +
			'<option value="displayNav1">displayNav1</option>' +
			'<option value="displayNav2">displayNav2</option>' +
			'<option value="displayNavFullWidth">displayNavFullWidth</option>' +
			'<option value="displayTopColumn">displayTopColumn</option>' +
			'<option value="displayLeftColumn">displayLeftColumn</option>' +
			'<option value="displayRightColumn">displayRightColumn</option>' +
			'<option value="displayFooterBefore">displayFooterBefore</option>' +
			'<option value="displayFooter">displayFooter</option>' +
			'<option value="displayFooterAfter">displayFooterAfter</option>' +
			'<option value="displayAfterBodyOpeningTag">displayAfterBodyOpeningTag</option>' +
			'<option value="displayShoppingCart">displayShoppingCart</option>' +
			'<option value="displayShoppingCartFooter">displayShoppingCartFooter</option>' +
			'<option value="displayFooterProduct">displayFooterProduct</option>'
		).insertAfter($type);

		if (!$hook.find('[value="'+$type.val()+'"]').length) {
			$('<option>', {
				value: $type.val(),
				html: $type.val()
			}).appendTo($hook);
		}

		$hook.select2({
			tags: true,
			createTag: function(params) {
				return {
					id: params.term,
					text: params.term,
					newOption: true
				};
			},
			templateResult: function(data) {
				var $result = $('<span>').text(data.text);

				if (data.newOption) {
					$result.append(" <i>(custom)</i>");
				}
				return $result;
			}
		}).val($type.val()).trigger('change.select2');
		</script>
	{/if}
{/block}
