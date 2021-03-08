{*
 *  Please read the terms of the CLUF license attached to this module(cf "licences" folder)
 *
 *  @author    Línea Gráfica E.C.E. S.L.
 *  @copyright Lineagrafica.es - Línea Gráfica E.C.E. S.L. all rights reserved.
 *  @license   https://www.lineagrafica.es/licenses/license_en.pdf
 *             https://www.lineagrafica.es/licenses/license_es.pdf
 *             https://www.lineagrafica.es/licenses/license_fr.pdf
 *}
<script type="text/javascript">
	var lgsecurity_module_name = "{$lgsecurity_module_name|escape:'htmlall':'UTF-8'}";
	var lgsecurity_token       = "{$lgsecurity_token|escape:'htmlall':'UTF-8'}";
	var lgsecurity_auth_token  = "{$lgsecurity_auth_token|escape:'htmlall':'UTF-8'}";
	var lgsecurity_confirmation_message = "{l s='Are you sure you want to delete the folder and all its content?' mod='lgsecurity'}";
	var lgsecurity_error_unknown_error  = "{l s='Unknown error' mod='lgsecurity'}";
</script>

{*
<div class="lgsecurity_header">
</div>
*}
<div class="lgsecurity_content">
	<div class="alert alert-info">
		{l s='El módulo ayuda a eliminar la vulnerabilidad notificada en Enero 2020 que existe en las tiendas Prestashop 1.6.x y 1.7.x por la inclusión de la librería de PHPUnit.' mod='lgsecurity'}
		{l s='Dicha librería en versiones anteriores a 7.5.19 y 8.5.1 contienen un fallo que permite conseguir ejecutar cualquier código en su servidor, vulnerando por completo la seguridad de sus datos.' mod='lgsecurity'}
		{l s='LINEA GRAFICA E.C.E. S.L. no puede garantizar el correcto funcionamiento del módulo debido a la gran variablidad existente en las tiendas prestashop y diversos alojamientos, y por tanto no se hace responsable de su uso.' mod='lgsecurity'}
	</div>
	{if !empty($lgsecurity_warnings)}
		{foreach $lgsecurity_warnings as $warning}
		<div class="alert alert-warning">
			{$warning['message']|escape:'htmlall':'UTF-8'}
			{if isset($warning['href']) && isset($warning['text'])}
				<a href="{$warning['href']|escape:'quotes'}" target="_blank">{$warning['text']}</a>
			{/if}
		</div>
		{/foreach}
	{/if}
	<div class="panel">
		<h2 style="padding-top: 0;">{l s='Instructions' mod='lgsecurity'}</h2>
		<p>{l s='In order to check for existence of PHPUnit vulnerability caused because PHPUnit library is included as a vendor componente or in a module please follow this steps' mod='lgsecurity'}</p>
		<ol>
			<li>{l s='click on Scan to look for phpPunit Library' mod='lgsecurity'}</li>
			<li>
				{l s='Click on delete button' mod='lgsecurity'}
				<i class="icon-trash"></i>
				{l s='on a selected item of the list, and press on Accept to delete the library from disk. It will delete the entire folder and all Its content.' mod='lgsecurity'}
			</li>
		</ol>
	</div>
	<div class="panel">
		{include file='./_partials/list.tpl'}
	</div>
</div>
