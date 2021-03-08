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

<!-- Block Last post-->

<div class="lastest_block block">
	<h4 class="block_title">{l s='Latest posts' d="Shop.Theme.Global"}</h4>
	<div class="block_content">
		{foreach from=$blogs item=blog name="item_name" }
			<div class="blog_container row clearfix">
				{if $blog.image}
					<div class="blog-image col-xs-4 col-sm-4 text-xs-center">
						<a href="{$blog.link_rewrite|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" class="link">
							<img src="{$blog.preview_url|escape:'html':'UTF-8'}" alt="{$blog.title|escape:'html':'UTF-8'}" class="img-fluid"/>
						</a>
					</div>
				{/if}
				<div class="blog-inner col-xs-8 col-sm-8">
					<div class="blog-meta">
						<span class="blog-author">
							<span class="fa fa-user"> {l s='Posted By' d='Shop.Theme.Global'}:</span> 
							<a href="{$blog.author_link|escape:'html':'UTF-8'}" title="{$blog.author|escape:'html':'UTF-8'}">{$blog.author|escape:'html':'UTF-8'}</a> 
						</span>					
												<span class="blog-created">
							<span class="fa fa-calendar"> {l s='On' d='Shop.Theme.Global'}: </span> 
							<time class="date" datetime="{strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
								{l s=strtotime($blog.date_add)|date_format:"%A"|escape:'html':'UTF-8' d='Shop.Theme.Global'},	<!-- day of week -->
								{l s=strtotime($blog.date_add)|date_format:"%B"|escape:'html':'UTF-8' d='Shop.Theme.Global'}		<!-- month-->
								{l s=strtotime($blog.date_add)|date_format:"%e"|escape:'html':'UTF-8' d='Shop.Theme.Global'},	<!-- day of month -->
								{l s=strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8' d='Shop.Theme.Global'}		<!-- year -->
							</time>
						</span>
						<span class="blog-cat"> 
							<span class="fa fa-list"> {l s='In' d='Shop.Theme.Global'}:</span> 
							<a href="{$blog.category_link|escape:'html':'UTF-8'}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title|escape:'html':'UTF-8'}</a>
						</span>

					</div>
					<h4 class="blog-title">
						<a href="{$blog.link_rewrite|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}">{$blog.title|escape:'html':'UTF-8'}</a>
					</h4>				
				</div>
			</div>
		{/foreach}
	</div>
</div>
<!-- /Block Last Post -->
