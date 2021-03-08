{*
 *  Ps Prestashop SliderShow for Prestashop 1.6.x
 *
 * @package   pssliderlayer
 * @version   3.0
 * @author    http://www.prestabrain.com
 * @copyright Copyright (C) October 2013 PrestaBrain.com <@emai:prestabrain@gmail.com>
 *               
 * @license   GNU General Public License version 2
*}

<article class="blog-item clearfix">
	{if $blog.image && $config->get('listing_show_image',1)}
		<div class="blog-image col-xs-12 col-sm-5">
			<img src="{$blog.preview_url|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" alt="" class="img-fluid" />
		</div>
	{/if}
	<div class="col-xs-12 col-sm-7 blog-content-wrap">
		{if $config->get('listing_show_title','1')}
		<h4 class="title media-heading"><a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}">{$blog.title|escape:'html':'UTF-8'}</a></h4>
		{/if}
		<div class="blog-meta">
			{if $config->get('listing_show_author','1')&&!empty($blog.author)}
			<span class="blog-author">
				<span class="fa fa-user"> {l s='Posted By' d='Modules.PsBlog.Shop'}:</span> 
				<a href="{$blog.author_link|escape:'html':'UTF-8'}" title="{$blog.author|escape:'html':'UTF-8'}">{$blog.author|escape:'html':'UTF-8'}</a> 
			</span>
			{/if}
			
			{if $config->get('listing_show_category','1')}
			<span class="blog-cat"> 
				<span class="fa fa-list"> {l s='In' d='Modules.PsBlog.Shop'}:</span> 
				<a href="{$blog.category_link|escape:'html':'UTF-8'}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title|escape:'html':'UTF-8'}</a>
			</span>
			{/if}
			
			{if $config->get('listing_show_created','1')}
			<span class="blog-created">
				<span class="fa fa-calendar"> {l s='On' d='Modules.PsBlog.Shop'}: </span> 
				<time class="date" datetime="{strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
					{l s=strtotime($blog.date_add)|date_format:"%A"|escape:'html':'UTF-8' d='Modules.PsBlog.Shop'},	<!-- day of week -->
					{l s=strtotime($blog.date_add)|date_format:"%B"|escape:'html':'UTF-8' d='Modules.PsBlog.Shop'}		<!-- month-->
					{l s=strtotime($blog.date_add)|date_format:"%e"|escape:'html':'UTF-8' d='Modules.PsBlog.Shop'},	<!-- day of month -->
					{l s=strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8' d='Modules.PsBlog.Shop'}		<!-- year -->
				</time>
			</span>
			{/if}
			
			{if isset($blog.comment_count)&&$config->get('listing_show_counter','1')}	
			<span class="blog-ctncomment">
				<span class="fa fa-comments-o"> {l s='Comment' d='Modules.PsBlog.Shop'}:</span> 
				{$blog.comment_count|intval}
			</span>
			{/if}

			{if $config->get('listing_show_hit','1')}	
			<span class="blog-hit">
				<span class="fa fa-heart"> {l s='Hit' d='Modules.PsBlog.Shop'}:</span> 
				{$blog.hits|intval}
			</span>
			{/if}
		</div>


		<div class="blog-shortinfo">
			{if $config->get('listing_show_description','1')}
			{$blog.description|strip_tags:'UTF-8'|truncate:160:'...' nofilter}{* HTML form , no escape necessary *}
			{/if}
			{if $config->get('listing_show_readmore',1)}
			<p>
				<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" class="more btn btn-default">{l s='Read more' d='Modules.PsBlog.Shop'}</a>
			</p>
			{/if}
		</div>
	</div>
</article>
	
<!---
	Translation Day of Week - NOT REMOVE
	{l s='Sunday' d='Modules.PsBlog.Shop'}
	{l s='Monday' d='Modules.PsBlog.Shop'}
	{l s='Tuesday' d='Modules.PsBlog.Shop'}
	{l s='Wednesday' d='Modules.PsBlog.Shop'}
	{l s='Thursday' d='Modules.PsBlog.Shop'}
	{l s='Friday' d='Modules.PsBlog.Shop'}
	{l s='Saturday' d='Modules.PsBlog.Shop'}
-->
<!---
	Translation Month - NOT REMOVE
		{l s='January' d='Modules.PsBlog.Shop'}
		{l s='February' d='Modules.PsBlog.Shop'}
		{l s='March' d='Modules.PsBlog.Shop'}
		{l s='April' d='Modules.PsBlog.Shop'}
		{l s='May' d='Modules.PsBlog.Shop'}
		{l s='June' d='Modules.PsBlog.Shop'}
		{l s='July' d='Modules.PsBlog.Shop'}
		{l s='August' d='Modules.PsBlog.Shop'}
		{l s='September' d='Modules.PsBlog.Shop'}
		{l s='October' d='Modules.PsBlog.Shop'}
		{l s='November' d='Modules.PsBlog.Shop'}
		{l s='December' d='Modules.PsBlog.Shop'}
-->