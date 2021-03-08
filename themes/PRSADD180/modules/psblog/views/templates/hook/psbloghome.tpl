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

<div class="lastest_block block tmblog-latest ">
<div class="container">
	<h2 class="h1 products-section-title ">
		{l s='From The Blog' d="Shop.Theme.Global"}
		<span class="title_product">Come & Check our new spring summer collection 2017</span>
	</h2>
	<div id="spe_res">
	<div class="homeblog-inner">
		{assign var='no_blog' value=count($blogs)}
		{assign var='sliderFor' value=4} <!-- Define Number of product for SLIDER -->
		{if $no_blog >= $sliderFor}
			<ul id="blog-carousel" class="ps-carousel product_list">
		{else}
			<ul id="blog-grid" class="blog_grid product_list grid row gridcount">
		{/if}
	
		{foreach from=$blogs item=blog name="item_name" }
			<li class="blog-post {if $no_blog >= $sliderFor}item{else}product_item col-xs-12 col-sm-6 col-md-4 col-lg-4{/if}">
				<div class="blog-item">
					
					{if $blog.image}
						<div class="blog-image text-xs-center">
							<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}" class="link">
								<img src="{$blog.preview_url|escape:'html':'UTF-8'}" alt="{$blog.title|escape:'html':'UTF-8'}" class="img-fluid"/>
							</a>
							<span class="blogicons">
								<a title="Click to view Full Image" href="{$blog.preview_url|escape:'html':'UTF-8'}" data-lightbox="example-set" class="icon zoom"></a> 
								<a title="Click to view Read More" href="{$blog.link|escape:'html':'UTF-8'}" class="icon readmore_link"></a>
							</span>
							<span class="blog-created">
							<!-- <span class="fa "> {l s='date ' d='Modules.PsBlog.Shop'}- </span>  -->
							<time class="date" datetime="{strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8'}">
								<!--{l s=strtotime($blog.date_add)|date_format:"%A"|escape:'html':'UTF-8' d='Modules.PsBlog.Shop'},	--><!-- day of week -->
							   <div class="blogdate"> {l s=strtotime($blog.date_add)|date_format:"%e"|escape:'html':'UTF-8' d='Shop.Theme.Global'}</div>	<!-- day of month -->
								<div class="blogmonth">{l s=strtotime($blog.date_add)|date_format:"%B"|escape:'html':'UTF-8' d='Shop.Theme.Global'}	</div>	<!-- month-->
							   <!--  {l s=strtotime($blog.date_add)|date_format:"%Y"|escape:'html':'UTF-8' d='Modules.PsBlog.Shop'}		year --> 
							</time>
						</span>
						</div>
					{/if}
					<div class="blog_content">
					
					<div class="blog-content-wrap">		

						<h4 class="title">
							<a href="{$blog.link|escape:'html':'UTF-8'}" title="{$blog.title|escape:'html':'UTF-8'}">{$blog.title|escape:'html':'UTF-8'}</a>
						</h4>
						

						<div class="blog-meta">							
						<!--<span class="blog-author">
							<span class="fa fa-user"> {l s='Posted By' d='Modules.PsBlog.Shop'}:</span> 
							<a href="{$blog.author_link|escape:'html':'UTF-8'}" title="{$blog.author|escape:'html':'UTF-8'}">{$blog.author|escape:'html':'UTF-8'}</a> 
						</span>					
						<span class="blog-cat"> 
							<span class="fa fa-list"> {l s='In' d='Modules.PsBlog.Shop'}:</span> 
							<a href="{$blog.category_link|escape:'html':'UTF-8'}" title="{$blog.category_title|escape:'html':'UTF-8'}">{$blog.category_title|escape:'html':'UTF-8'}</a>
						</span>-->
						
					<!--	<span class="blog-hit">
							<i class="fa fa-heart"></i>{l s='Hit' d='Modules.PsBlog.Shop'}: 
							{$blog.hits|intval}
						</span> -->
						
							<div class="blog-shortinfo">
							{$blog.description|strip_tags:'UTF-8'|truncate:75:'...' nofilter}{* HTML form , no escape necessary *}

						</div>
					
					</div>
						
								
					</div>
					
					
					</div>
				</div>
			</li>
		{/foreach}
		</ul>
		
		{if $no_blog >= $sliderFor}
			<div class="customNavigation">
				<a class="btn prev blog_prev">&nbsp;</a>
				<a class="btn next blog_next">&nbsp;</a>
			</div>
		{/if}
	</div>
	</div>
</div>
</div>
<!-- /Block Last Post -->
