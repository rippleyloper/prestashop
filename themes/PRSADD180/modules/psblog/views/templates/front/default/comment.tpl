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

<div id="blog-localengine">
		<form class="form-horizontal" method="post" id="comment-form" action="{$blog_link|escape:'html':'UTF-8'}" onsubmit="return false;">
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputFullName">{l s='Full Name' d='Modules.PsBlog.Shop'}</label>
				<div class="col-lg-9">
					<input type="text" name="fullname" placeholder="{l s='Enter your full name' d='Modules.PsBlog.Shop'}" id="inputFullName" class="form-control">
				</div>
			</div>

			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputEmail">{l s='Email' d='Modules.PsBlog.Shop'}</label>
				<div class="col-lg-9">
					<input type="text" name="email" placeholder="{l s='Enter your email' d='Modules.PsBlog.Shop'}" id="inputEmail" class="form-control">
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-lg-3 control-label" for="inputComment">{l s='Comment' d='Modules.PsBlog.Shop'}</label>
				<div class="col-lg-9">
					<textarea type="text" name="comment" rows="6" placeholder="{l s='Enter your comment' d='Modules.PsBlog.Shop'}" id="inputComment" class="form-control"></textarea>
				</div>
			</div>
			 <div class="form-group">
			 	 <img src="{$captcha_image|escape:'html':'UTF-8'}" alt="" align="left"/>
				 <input class="form-control" type="text" name="captcha" value="" size="10" />
			 </div>
			 <input type="hidden" name="id_psblog_blog" value="{$id_psblog_blog|intval}">
			<div class="form-group">
					<div class="col-lg-9 col-lg-offset-3"><button class="btn btn-default" name="submitcomment" type="submit">{l s='Submit' d='Modules.PsBlog.Shop'}</button></div>
			</div>
		</form>
</div>