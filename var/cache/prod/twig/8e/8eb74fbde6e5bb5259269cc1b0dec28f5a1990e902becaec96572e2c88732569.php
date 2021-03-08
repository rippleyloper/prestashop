<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* __string_template__7e567820ece5f8a853ddc67912604b3c54881785b817321e80cc7a71e648b713 */
class __TwigTemplate_0bb9f5b3748ff09bc3eb2b2645cc9db27d457c09f4de845cc665428715cc6ab2 extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'stylesheets' => [$this, 'block_stylesheets'],
            'extra_stylesheets' => [$this, 'block_extra_stylesheets'],
            'content_header' => [$this, 'block_content_header'],
            'content' => [$this, 'block_content'],
            'content_footer' => [$this, 'block_content_footer'],
            'sidebar_right' => [$this, 'block_sidebar_right'],
            'javascripts' => [$this, 'block_javascripts'],
            'extra_javascripts' => [$this, 'block_extra_javascripts'],
            'translate_javascripts' => [$this, 'block_translate_javascripts'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"es\">
<head>
  <meta charset=\"utf-8\">
<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
<meta name=\"apple-mobile-web-app-capable\" content=\"yes\">
<meta name=\"robots\" content=\"NOFOLLOW, NOINDEX\">

<link rel=\"icon\" type=\"image/x-icon\" href=\"/ps_dev/img/favicon.ico\" />
<link rel=\"apple-touch-icon\" href=\"/ps_dev/img/app_icon.png\" />

<title>MESA • Inversierra S.A</title>

  <script type=\"text/javascript\">
    var help_class_name = 'AdminCategories';
    var iso_user = 'es';
    var lang_is_rtl = '0';
    var full_language_code = 'es-es';
    var full_cldr_language_code = 'es-ES';
    var country_iso_code = 'CL';
    var _PS_VERSION_ = '1.7.6.5';
    var roundMode = 2;
    var youEditFieldFor = '';
        var new_order_msg = 'Se ha recibido un nuevo pedido en tu tienda.';
    var order_number_msg = 'Número de pedido: ';
    var total_msg = 'Total: ';
    var from_msg = 'Desde: ';
    var see_order_msg = 'Ver este pedido';
    var new_customer_msg = 'Un nuevo cliente se ha registrado en tu tienda.';
    var customer_name_msg = 'Nombre del cliente: ';
    var new_msg = 'Un nuevo mensaje ha sido publicado en tu tienda.';
    var see_msg = 'Leer este mensaje';
    var token = '888bc29a93c49ddefa5a2689f68a41c9';
    var token_admin_orders = '55e64bb208266b996bda0c4758f993bc';
    var token_admin_customers = 'e09aeb3bdcce975f5bb6c5f1f85a1dd3';
    var token_admin_customer_threads = '824144a8b83b2c652427a94dd8a8702d';
    var currentIndex = 'index.php?controller=AdminCategories';
    var employee_token = 'eb140b54c053a01d0735766b685e8297';
    var choose_language_translate = 'Selecciona el idioma';
    var default_language = '1';
    var admin_modules_link = '/ps_dev/admin0178uoq0b/index.php/improve/modules/catalog/recommended?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE';
    var admin_notification_get_link = '/ps_dev/admin0178uoq0b/index.php/common/notifications?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE';
    var admin_notification_push_link = '/ps_dev/admin0178uoq0b/index.php/common/notifications/ack?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE';
    var tab_modules_list = 'innovativemenu,productsbycategoryslider,slidercategory,apiway';
    var update_success_msg = 'Actualización correcta';
    var errorLogin = 'PrestaShop no pudo iniciar sesión en Addons. Por favor verifica tus datos de acceso y tu conexión de Internet.';
    var search_product_msg = 'Buscar un producto';
  </script>

      <link href=\"/ps_dev/modules/creativeelements/views/css/admin.css?v=0.11.5\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/ps_dev/admin0178uoq0b/themes/new-theme/public/theme.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/ps_dev/js/jquery/plugins/chosen/jquery.chosen.css\" rel=\"stylesheet\" type=\"text/css\"/>
      <link href=\"/ps_dev/admin0178uoq0b/themes/default/css/vendor/nv.d3.css\" rel=\"stylesheet\" type=\"text/css\"/>
  
  <script type=\"text/javascript\">
var baseAdminDir = \"\\/ps_dev\\/admin0178uoq0b\\/\";
var baseDir = \"\\/ps_dev\\/\";
var changeFormLanguageUrl = \"\\/ps_dev\\/admin0178uoq0b\\/index.php\\/configure\\/advanced\\/employees\\/change-form-language?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\";
var creativePageHook = \"\";
var creativePageSave = \"Please save the form before editing with Creative Elements\";
var creativePageType = \"category\";
var currency = {\"iso_code\":\"CLP\",\"sign\":\"\$\",\"name\":\"Peso chileno\",\"format\":null};
var currency_specifications = {\"symbol\":[\",\",\".\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"currencyCode\":\"CLP\",\"currencySymbol\":\"\$\",\"positivePattern\":\"\\u00a4#,##0.00\\u00a0\",\"negativePattern\":\"-\\u00a4#,##0.00\\u00a0\",\"maxFractionDigits\":0,\"minFractionDigits\":2,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var hideEditor = [];
var host_mode = false;
var number_specifications = {\"symbol\":[\",\",\".\",\";\",\"%\",\"-\",\"+\",\"E\",\"\\u00d7\",\"\\u2030\",\"\\u221e\",\"NaN\"],\"positivePattern\":\"#,##0.###\",\"negativePattern\":\"-#,##0.###\",\"maxFractionDigits\":3,\"minFractionDigits\":0,\"groupingUsed\":true,\"primaryGroupSize\":3,\"secondaryGroupSize\":3};
var show_new_customers = \"\";
var show_new_messages = false;
var show_new_orders = \"\";
</script>
<script type=\"text/javascript\" src=\"/ps_dev/modules/creativeelements/views/js/admin.js?v=0.11.5\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/admin0178uoq0b/themes/new-theme/public/main.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/js/jquery/plugins/jquery.chosen.js\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/js/admin.js?v=1.7.6.5\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/admin0178uoq0b/themes/new-theme/public/cldr.bundle.js\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/js/tools.js?v=1.7.6.5\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/admin0178uoq0b/public/bundle.js\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/js/vendor/d3.v3.min.js\"></script>
<script type=\"text/javascript\" src=\"/ps_dev/admin0178uoq0b/themes/default/js/vendor/nv.d3.min.js\"></script>

  <style>.icon-AdminParentCreativeElements:before { content: \"\"; }</style>
<script type=\"text/html\" id=\"tmpl-btn-edit-with-ce\">
\t<a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=CreativeEditor&token=10376f7b70aa48acc8647c3495a8665f&type=category&id_page=0\" class=\"btn pointer btn-edit-with-ce\"><i class=\"material-icons\">explicit</i> Editar con Creative Elements</a>
</script>
 
<style>
.icon-AdminSmartBlog:before{
  content: \"\\f14b\";
   }
 
</style>

";
        // line 93
        $this->displayBlock('stylesheets', $context, $blocks);
        $this->displayBlock('extra_stylesheets', $context, $blocks);
        echo "</head>

<body class=\"lang-es admincategories\">

  <header id=\"header\">

    <nav id=\"header_infos\" class=\"main-header\">
      <button class=\"btn btn-primary-reverse onclick btn-lg unbind ajax-spinner\"></button>

            <i class=\"material-icons js-mobile-menu\">menu</i>
      <a id=\"header_logo\" class=\"logo float-left\" href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminDashboard&amp;token=2d981d394a60ca956a1a86913e1d9ffd\"></a>
      <span id=\"shop_version\">1.7.6.5</span>

      <div class=\"component\" id=\"quick-access-container\">
        <div class=\"dropdown quick-accesses\">
  <button class=\"btn btn-link btn-sm dropdown-toggle\" type=\"button\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\" id=\"quick_select\">
    Acceso rápido
  </button>
  <div class=\"dropdown-menu\">
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminStats&amp;module=statscheckup&amp;token=fba82a28ffc384a4f0c5640ce88c9093\"
                 data-item=\"Evaluación del catálogo\"
      >Evaluación del catálogo</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php/improve/modules/manage?token=a561583d3d09928dd320fa151ed3f331\"
                 data-item=\"Módulos instalados\"
      >Módulos instalados</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCategories&amp;addcategory&amp;token=888bc29a93c49ddefa5a2689f68a41c9\"
                 data-item=\"Nueva categoría\"
      >Nueva categoría</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php/sell/catalog/products/new?token=a561583d3d09928dd320fa151ed3f331\"
                 data-item=\"Nuevo\"
      >Nuevo</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCartRules&amp;addcart_rule&amp;token=edace1c7778cdb19ec712a244763630d\"
                 data-item=\"Nuevo cupón de descuento\"
      >Nuevo cupón de descuento</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminOrders&amp;token=55e64bb208266b996bda0c4758f993bc\"
                 data-item=\"Pedidos\"
      >Pedidos</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminModules&amp;configure=prestablog&amp;module_name=prestablog&amp;token=d8d3b56378e998d434ff062f655f7934\"
                 data-item=\"PrestaBlog\"
      >PrestaBlog</a>
          <a class=\"dropdown-item\"
         href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminModules&amp;&amp;configure=smartblog&amp;token=d8d3b56378e998d434ff062f655f7934\"
                 data-item=\"Smart Blog Setting\"
      >Smart Blog Setting</a>
        <div class=\"dropdown-divider\"></div>
          <a
        class=\"dropdown-item js-quick-link\"
        href=\"#\"
        data-rand=\"154\"
        data-icon=\"icon-AdminCatalog\"
        data-method=\"add\"
        data-url=\"index.php/sell/catalog/categories/12\"
        data-post-link=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminQuickAccesses&token=7ead0bec5765d1ab58881cbc18eb6f4b\"
        data-prompt-text=\"Por favor, renombre este acceso rápido:\"
        data-link=\"Categor&iacute;as - Lista\"
      >
        <i class=\"material-icons\">add_circle</i>
        Añadir esta página a Acceso rápido
      </a>
        <a class=\"dropdown-item\" href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminQuickAccesses&token=7ead0bec5765d1ab58881cbc18eb6f4b\">
      <i class=\"material-icons\">settings</i>
      Administrar accesos rápidos
    </a>
  </div>
</div>
      </div>
      <div class=\"component\" id=\"header-search-container\">
        <form id=\"header_search\"
      class=\"bo_search_form dropdown-form js-dropdown-form collapsed\"
      method=\"post\"
      action=\"/ps_dev/admin0178uoq0b/index.php?controller=AdminSearch&amp;token=9d6d86addc7b82c0b9bbbdcdafa0450c\"
      role=\"search\">
  <input type=\"hidden\" name=\"bo_search_type\" id=\"bo_search_type\" class=\"js-search-type\" />
    <div class=\"input-group\">
    <input type=\"text\" class=\"form-control js-form-search\" id=\"bo_query\" name=\"bo_query\" value=\"\" placeholder=\"Buscar (p. ej.: referencia de producto, nombre de cliente...)\">
    <div class=\"input-group-append\">
      <button type=\"button\" class=\"btn btn-outline-secondary dropdown-toggle js-dropdown-toggle\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">
        toda la tienda
      </button>
      <div class=\"dropdown-menu js-items-list\">
        <a class=\"dropdown-item\" data-item=\"toda la tienda\" href=\"#\" data-value=\"0\" data-placeholder=\"¿Qué estás buscando?\" data-icon=\"icon-search\"><i class=\"material-icons\">search</i> toda la tienda</a>
        <div class=\"dropdown-divider\"></div>
        <a class=\"dropdown-item\" data-item=\"Catálogo\" href=\"#\" data-value=\"1\" data-placeholder=\"Nombre del producto, SKU, referencia...\" data-icon=\"icon-book\"><i class=\"material-icons\">store_mall_directory</i> Catálogo</a>
        <a class=\"dropdown-item\" data-item=\"Clientes por nombre\" href=\"#\" data-value=\"2\" data-placeholder=\"Email, nombre...\" data-icon=\"icon-group\"><i class=\"material-icons\">group</i> Clientes por nombre</a>
        <a class=\"dropdown-item\" data-item=\"Clientes por dirección IP\" href=\"#\" data-value=\"6\" data-placeholder=\"123.45.67.89\" data-icon=\"icon-desktop\"><i class=\"material-icons\">desktop_mac</i> Clientes por dirección IP</a>
        <a class=\"dropdown-item\" data-item=\"Pedidos\" href=\"#\" data-value=\"3\" data-placeholder=\"ID del pedido\" data-icon=\"icon-credit-card\"><i class=\"material-icons\">shopping_basket</i> Pedidos</a>
        <a class=\"dropdown-item\" data-item=\"Facturas\" href=\"#\" data-value=\"4\" data-placeholder=\"Número de factura\" data-icon=\"icon-book\"><i class=\"material-icons\">book</i> Facturas</a>
        <a class=\"dropdown-item\" data-item=\"Carro\" href=\"#\" data-value=\"5\" data-placeholder=\"ID carro\" data-icon=\"icon-shopping-cart\"><i class=\"material-icons\">shopping_cart</i> Carro</a>
        <a class=\"dropdown-item\" data-item=\"Módulos\" href=\"#\" data-value=\"7\" data-placeholder=\"Nombre del módulo\" data-icon=\"icon-puzzle-piece\"><i class=\"material-icons\">extension</i> Módulos</a>
      </div>
      <button class=\"btn btn-primary\" type=\"submit\"><span class=\"d-none\">BÚSQUEDA</span><i class=\"material-icons\">search</i></button>
    </div>
  </div>
</form>

<script type=\"text/javascript\">
 \$(document).ready(function(){
    \$('#bo_query').one('click', function() {
    \$(this).closest('form').removeClass('collapsed');
  });
});
</script>
      </div>

      
      
      <div class=\"component\" id=\"header-shop-list-container\">
          <div class=\"shop-list\">
    <a class=\"link\" id=\"header_shopname\" href=\"http://localhost/ps_dev/\" target= \"_blank\">
      <i class=\"material-icons\">visibility</i>
      Ver mi tienda
    </a>
  </div>
      </div>

      
      <div class=\"component\" id=\"header-employee-container\">
        <div class=\"dropdown employee-dropdown\">
  <div class=\"rounded-circle person\" data-toggle=\"dropdown\">
    <i class=\"material-icons\">account_circle</i>
  </div>
  <div class=\"dropdown-menu dropdown-menu-right\">
    <div class=\"employee-wrapper-avatar\">
      
      <span class=\"employee_avatar\"><img class=\"avatar rounded-circle\" src=\"http://profile.prestashop.com/jdelmoral%40inversierra.cl.jpg\" /></span>
      <span class=\"employee_profile\">Bienvenido de nuevo, José</span>
      <a class=\"dropdown-item employee-link profile-link\" href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/employees/6/edit?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\">
      <i class=\"material-icons\">settings</i>
      Tu perfil
    </a>
    </div>
    
    <p class=\"divider\"></p>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/resources/documentations?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=resources-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">book</i> Recursos</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/training?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=training-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">school</i> Formación</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/experts?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=expert-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">person_pin_circle</i> Encontrar un Experto</a>
    <a class=\"dropdown-item\" href=\"https://addons.prestashop.com?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=addons-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">extension</i> Marketplace de PrestaShop</a>
    <a class=\"dropdown-item\" href=\"https://www.prestashop.com/en/contact?utm_source=back-office&amp;utm_medium=profile&amp;utm_campaign=help-center-en&amp;utm_content=download17\" target=\"_blank\"><i class=\"material-icons\">help</i> Centro de ayuda</a>
    <p class=\"divider\"></p>
    <a class=\"dropdown-item employee-link text-center\" id=\"header_logout\" href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminLogin&amp;logout=1&amp;token=1a09193cd4e5d439a509cc832cb49140\">
      <i class=\"material-icons d-lg-none\">power_settings_new</i>
      <span>Cerrar sesión</span>
    </a>
  </div>
</div>
      </div>
    </nav>

      </header>

  <nav class=\"nav-bar d-none d-md-block\">
  <span class=\"menu-collapse\" data-toggle-url=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/employees/toggle-navigation?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\">
    <i class=\"material-icons\">chevron_left</i>
    <i class=\"material-icons\">chevron_left</i>
  </span>

  <ul class=\"main-menu\">

          
                
                
        
          <li class=\"link-levelone \" data-submenu=\"1\" id=\"tab-AdminDashboard\">
            <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminDashboard&amp;token=2d981d394a60ca956a1a86913e1d9ffd\" class=\"link\" >
              <i class=\"material-icons\">trending_up</i> <span>Inicio</span>
            </a>
          </li>

        
                
                                  
                
        
          <li class=\"category-title -active\" data-submenu=\"2\" id=\"tab-SELL\">
              <span class=\"title\">Vender</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"3\" id=\"subtab-AdminParentOrders\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminOrders&amp;token=55e64bb208266b996bda0c4758f993bc\" class=\"link\">
                    <i class=\"material-icons mi-shopping_basket\">shopping_basket</i>
                    <span>
                    Pedidos
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-3\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"4\" id=\"subtab-AdminOrders\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminOrders&amp;token=55e64bb208266b996bda0c4758f993bc\" class=\"link\"> Pedidos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"5\" id=\"subtab-AdminInvoices\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/orders/invoices/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Facturas
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"6\" id=\"subtab-AdminSlip\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminSlip&amp;token=53a6948cbeb1cdbd1295a574be36fa0b\" class=\"link\"> Facturas por abono
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"7\" id=\"subtab-AdminDeliverySlip\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/orders/delivery-slips/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Albaranes de entrega
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"8\" id=\"subtab-AdminCarts\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCarts&amp;token=902c152a85930dc01bc0b0e1c6069c7c\" class=\"link\"> Carritos de compra
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                                                    
                <li class=\"link-levelone has_submenu -active open ul-open\" data-submenu=\"9\" id=\"subtab-AdminCatalog\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/catalog/products?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-store\">store</i>
                    <span>
                    Catálogo
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_up
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-9\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"10\" id=\"subtab-AdminProducts\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/catalog/products?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Productos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo -active\" data-submenu=\"11\" id=\"subtab-AdminCategories\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/catalog/categories?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Categorías
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"12\" id=\"subtab-AdminTracking\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminTracking&amp;token=269c6676f012c891b0c561b474dce5d8\" class=\"link\"> Monitoreo
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"13\" id=\"subtab-AdminParentAttributesGroups\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminAttributesGroups&amp;token=03d0f6c8ac190496c337bf7b39731647\" class=\"link\"> Atributos y Características
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"16\" id=\"subtab-AdminParentManufacturers\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/catalog/brands/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Marcas y Proveedores
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"19\" id=\"subtab-AdminAttachments\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminAttachments&amp;token=2263af60f0e8230792f299a24842ca2f\" class=\"link\"> Archivos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"20\" id=\"subtab-AdminParentCartRules\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCartRules&amp;token=edace1c7778cdb19ec712a244763630d\" class=\"link\"> Descuentos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"23\" id=\"subtab-AdminStockManagement\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/stocks/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Stocks
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"24\" id=\"subtab-AdminParentCustomer\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/customers/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-account_circle\">account_circle</i>
                    <span>
                    Clientes
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-24\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"25\" id=\"subtab-AdminCustomers\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/customers/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Clientes
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"26\" id=\"subtab-AdminAddresses\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminAddresses&amp;token=56dda63e0900d2de00e578e2a90c9c2e\" class=\"link\"> Direcciones
                              </a>
                            </li>

                                                                                                                          </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"28\" id=\"subtab-AdminParentCustomerThreads\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCustomerThreads&amp;token=824144a8b83b2c652427a94dd8a8702d\" class=\"link\">
                    <i class=\"material-icons mi-chat\">chat</i>
                    <span>
                    Servicio al Cliente
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-28\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"29\" id=\"subtab-AdminCustomerThreads\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCustomerThreads&amp;token=824144a8b83b2c652427a94dd8a8702d\" class=\"link\"> Servicio al Cliente
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"30\" id=\"subtab-AdminOrderMessage\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminOrderMessage&amp;token=a849f75677345ded4718fb8acd47c0b0\" class=\"link\"> Mensajes de Pedidos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"31\" id=\"subtab-AdminReturn\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminReturn&amp;token=2997a7b6413f33ef44887e0be8c793fc\" class=\"link\"> Devoluciones de mercancía
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"32\" id=\"subtab-AdminStats\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminStats&amp;token=fba82a28ffc384a4f0c5640ce88c9093\" class=\"link\">
                    <i class=\"material-icons mi-assessment\">assessment</i>
                    <span>
                    Estadísticas
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"42\" id=\"tab-IMPROVE\">
              <span class=\"title\">Personalizar</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"43\" id=\"subtab-AdminParentModulesSf\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/modules/manage?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    Módulos
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-43\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"44\" id=\"subtab-AdminModulesSf\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/modules/manage?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Gestor de módulos
                              </a>
                            </li>

                                                                                                                              
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"136\" id=\"subtab-AdminParentModulesCatalog\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/modules/catalog?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Catálogo de módulos
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"50\" id=\"subtab-AdminParentThemes\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/design/themes/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-desktop_mac\">desktop_mac</i>
                    <span>
                    Diseño
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-50\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"159\" id=\"subtab-AdminThemesParent\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/design/themes/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Tema y logotipo
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"172\" id=\"subtab-AdminParentCreativeElements\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCreativePage&amp;token=db90c8df13ea6f81e6dc44d87b1e6ad4\" class=\"link\"> Creative Elements PageBuilder
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"52\" id=\"subtab-AdminThemesCatalog\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/design/themes-catalog/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Catálogo de Temas
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"53\" id=\"subtab-AdminCmsContent\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/design/cms-pages/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Páginas
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"54\" id=\"subtab-AdminModulesPositions\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/design/modules/positions/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Posiciones
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"55\" id=\"subtab-AdminImages\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminImages&amp;token=de096e23786d441c2b5f967021ed83c6\" class=\"link\"> Ajustes de imágenes
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"120\" id=\"subtab-AdminLinkWidget\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/modules/link-widget/list?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Link Widget
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"137\" id=\"subtab-AdminMailThemeParent\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/design/mail_theme/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Email Themes
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"56\" id=\"subtab-AdminParentShipping\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCarriers&amp;token=429b7a82f66d150878048333c984aeef\" class=\"link\">
                    <i class=\"material-icons mi-local_shipping\">local_shipping</i>
                    <span>
                    Transporte
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-56\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"57\" id=\"subtab-AdminCarriers\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCarriers&amp;token=429b7a82f66d150878048333c984aeef\" class=\"link\"> Transportistas
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"58\" id=\"subtab-AdminShipping\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/shipping/preferences?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Preferencias
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"59\" id=\"subtab-AdminParentPayment\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/payment/payment_methods?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-payment\">payment</i>
                    <span>
                    Pago
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-59\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"60\" id=\"subtab-AdminPayment\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/payment/payment_methods?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Métodos de pago
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"61\" id=\"subtab-AdminPaymentPreferences\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/payment/preferences?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Preferencias
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"62\" id=\"subtab-AdminInternational\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/international/localization/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-language\">language</i>
                    <span>
                    Internacional
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-62\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"63\" id=\"subtab-AdminParentLocalization\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/international/localization/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Localización
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"68\" id=\"subtab-AdminParentCountries\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminZones&amp;token=d3db5e80b804a959c55875079196e659\" class=\"link\"> Ubicaciones Geográficas
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"72\" id=\"subtab-AdminParentTaxes\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/international/taxes/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Impuestos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"75\" id=\"subtab-AdminTranslations\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/improve/international/translations/settings?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Traducciones
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"76\" id=\"tab-CONFIGURE\">
              <span class=\"title\">Configurar</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"77\" id=\"subtab-ShopParameters\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/preferences/preferences?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-settings\">settings</i>
                    <span>
                    Parámetros de la tienda
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-77\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"78\" id=\"subtab-AdminParentPreferences\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/preferences/preferences?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Configuración
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"81\" id=\"subtab-AdminParentOrderPreferences\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/order-preferences/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Configuración de Pedidos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"84\" id=\"subtab-AdminPPreferences\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/product-preferences/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Configuración de Productos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"85\" id=\"subtab-AdminParentCustomerPreferences\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/customer-preferences/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Ajustes sobre clientes
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"89\" id=\"subtab-AdminParentStores\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/contacts/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Contacto
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"92\" id=\"subtab-AdminParentMeta\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/shop/seo-urls/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Tráfico &amp; SEO
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"96\" id=\"subtab-AdminParentSearchConf\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminSearchConf&amp;token=dc70e1ec86bf6dc8ae8266c3803809d3\" class=\"link\"> Buscar
                              </a>
                            </li>

                                                                                                                          </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"99\" id=\"subtab-AdminAdvancedParameters\">
                  <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/system-information/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\">
                    <i class=\"material-icons mi-settings_applications\">settings_applications</i>
                    <span>
                    Parámetros Avanzados
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-99\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"100\" id=\"subtab-AdminInformation\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/system-information/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Información
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"101\" id=\"subtab-AdminPerformance\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/performance/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Rendimiento
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"102\" id=\"subtab-AdminAdminPreferences\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/administration/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Administración
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"103\" id=\"subtab-AdminEmails\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/emails/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Dirección de correo electrónico
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"104\" id=\"subtab-AdminImport\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/import/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Importar
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"105\" id=\"subtab-AdminParentEmployees\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/employees/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Equipo
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"109\" id=\"subtab-AdminParentRequestSql\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/sql-requests/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Base de datos
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"112\" id=\"subtab-AdminLogs\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/logs/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Registros/Logs
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"113\" id=\"subtab-AdminWebservice\">
                              <a href=\"/ps_dev/admin0178uoq0b/index.php/configure/advanced/webservice-keys/?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" class=\"link\"> Webservice
                              </a>
                            </li>

                                                                                                                                                                                
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"175\" id=\"subtab-AdminCdcGoogletagmanagerOrders\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCdcGoogletagmanagerOrders&amp;token=80fe2366ee69302f71f8c5b1b4037f5a\" class=\"link\"> GTM Orders
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"128\" id=\"subtab-AdminCleverReachBase\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminCleverReachBase&amp;token=6bc7cefbaaa4f33dc8cdff2ec734db59\" class=\"link\">
                    <i class=\"material-icons mi-sms\">sms</i>
                    <span>
                    CleverReach
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"117\" id=\"tab-DEFAULT\">
              <span class=\"title\">Más</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"134\" id=\"subtab-AdminSelfUpgrade\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminSelfUpgrade&amp;token=ea9fbb5abeb6225401da4f8c49e35701\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    1-Click Upgrade
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"171\" id=\"subtab-AdminTawkto\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminTawkto&amp;token=5fea66acb708234bfad1ee7de0dbe379\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    tawk.to
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"140\" id=\"tab-mailchimppro\">
              <span class=\"title\">Mailchimp Config</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"141\" id=\"subtab-AdminMailchimpProConfig\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminMailchimpProConfig&amp;token=a299d48d83661cebe29f0997e99b10b4\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    Mailchimp Config
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                                        
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"142\" id=\"subtab-AdminMailchimpProWizard\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminMailchimpProWizard&amp;token=6c330d54053dd0e9316ef5cb528f90a1\" class=\"link\">
                    <i class=\"material-icons mi-extension\">extension</i>
                    <span>
                    Mailchimp Setup Wizard
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                                                                                                                                                                                                                                                                                                                                                                            
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"156\" id=\"tab-Management\">
              <span class=\"title\">CONTENT MANAGEMENT</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone\" data-submenu=\"157\" id=\"subtab-AdminPrestaBlog\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminPrestaBlog&amp;token=5b7146188443258d0f418252cf5e09c8\" class=\"link\">
                    <i class=\"material-icons mi-library_books\">library_books</i>
                    <span>
                    PrestaBlog
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                    </li>
                          
        
                
                                  
                
        
          <li class=\"category-title \" data-submenu=\"164\" id=\"tab-AdminSmartBlogMenu\">
              <span class=\"title\">SMARTBLOG</span>
          </li>

                          
                
                                                
                
                <li class=\"link-levelone has_submenu\" data-submenu=\"165\" id=\"subtab-AdminSmartBlog\">
                  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminBlogCategory&amp;token=e27a1b81c8617b8cac3f87cffdf06285\" class=\"link\">
                    <i class=\"material-icons mi-content_paste\">content_paste</i>
                    <span>
                    Blog
                    </span>
                                                <i class=\"material-icons sub-tabs-arrow\">
                                                                keyboard_arrow_down
                                                        </i>
                                        </a>
                                          <ul id=\"collapse-165\" class=\"submenu panel-collapse\">
                                                  
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"166\" id=\"subtab-AdminBlogCategory\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminBlogCategory&amp;token=e27a1b81c8617b8cac3f87cffdf06285\" class=\"link\"> Blog Category
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"167\" id=\"subtab-AdminBlogcomment\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminBlogcomment&amp;token=370e7d9a33ede291a2f1dbbbd430cb22\" class=\"link\"> Blog Comments
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"168\" id=\"subtab-AdminBlogPost\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminBlogPost&amp;token=c77a2ffa71a8bd540461a3c441cd1bc3\" class=\"link\"> Blog Post
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"169\" id=\"subtab-AdminImageType\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminImageType&amp;token=150b8a2df026accbef92eb5a44c261d6\" class=\"link\"> Image Type
                              </a>
                            </li>

                                                                            
                            
                                                        
                            <li class=\"link-leveltwo \" data-submenu=\"170\" id=\"subtab-AdminAboutUs\">
                              <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminAboutUs&amp;token=17dfc5fda2420a42d6d8d14128b84c0d\" class=\"link\"> AboutUs
                              </a>
                            </li>

                                                                        </ul>
                                    </li>
                          
        
            </ul>
  
</nav>

<div id=\"main-div\">
          
<div class=\"header-toolbar\">
  <div class=\"container-fluid\">

    
      <nav aria-label=\"Breadcrumb\">
        <ol class=\"breadcrumb\">
                      <li class=\"breadcrumb-item\">Catálogo</li>
          
                      <li class=\"breadcrumb-item active\">
              <a href=\"/ps_dev/admin0178uoq0b/index.php/sell/catalog/categories?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\" aria-current=\"page\">Categorías</a>
            </li>
                  </ol>
      </nav>
    

    <div class=\"title-row\">
      
          <h1 class=\"title\">
            MESA          </h1>
      

      
        <div class=\"toolbar-icons\">
          <div class=\"wrapper\">
            
                                                                                    <a
                  class=\"btn btn-primary  pointer\"                  id=\"page-header-desc-configuration-add\"
                  href=\"/ps_dev/admin0178uoq0b/index.php/sell/catalog/categories/new?id_parent=12&amp;_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\"                  title=\"Añadir nueva categoría\"                >
                  <i class=\"material-icons\">add_circle_outline</i>                  Añadir nueva categoría
                </a>
                                                                  <a
                class=\"btn btn-outline-secondary \"
                id=\"page-header-desc-configuration-modules-list\"
                href=\"/ps_dev/admin0178uoq0b/index.php/improve/modules/catalog?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\"                title=\"Módulos recomendados\"
                              >
                Módulos recomendados
              </a>
            
            
                              <a class=\"btn btn-outline-secondary btn-help btn-sidebar\" href=\"#\"
                   title=\"Ayuda\"
                   data-toggle=\"sidebar\"
                   data-target=\"#right-sidebar\"
                   data-url=\"/ps_dev/admin0178uoq0b/index.php/common/sidebar/https%253A%252F%252Fhelp.prestashop.com%252Fes%252Fdoc%252FAdminCategories%253Fversion%253D1.7.6.5%2526country%253Des/Ayuda?_token=k59xpq9qzripziPkwhvl_5UQYFyB4kZspRhVcyaBUqE\"
                   id=\"product_form_open_help\"
                >
                  Ayuda
                </a>
                                    </div>
        </div>
      
    </div>
  </div>

  
    
</div>
      
      <div class=\"content-div  \">

        

                                                        
        <div class=\"row \">
          <div class=\"col-sm-12\">
            <div id=\"ajax_confirmation\" class=\"alert alert-success\" style=\"display: none;\"></div>


  ";
        // line 1186
        $this->displayBlock('content_header', $context, $blocks);
        // line 1187
        echo "                 ";
        $this->displayBlock('content', $context, $blocks);
        // line 1188
        echo "                 ";
        $this->displayBlock('content_footer', $context, $blocks);
        // line 1189
        echo "                 ";
        $this->displayBlock('sidebar_right', $context, $blocks);
        // line 1190
        echo "
            
          </div>
        </div>

      </div>
    </div>

  <div id=\"non-responsive\" class=\"js-non-responsive\">
  <h1>¡Oh no!</h1>
  <p class=\"mt-3\">
    La versión para móviles de esta página no está disponible todavía.
  </p>
  <p class=\"mt-2\">
    Por favor, utiliza un ordenador de escritorio hasta que esta página sea adaptada para dispositivos móviles.
  </p>
  <p class=\"mt-2\">
    Gracias.
  </p>
  <a href=\"http://localhost/ps_dev/admin0178uoq0b/index.php?controller=AdminDashboard&amp;token=2d981d394a60ca956a1a86913e1d9ffd\" class=\"btn btn-primary py-1 mt-3\">
    <i class=\"material-icons\">arrow_back</i>
    Atrás
  </a>
</div>
  <div class=\"mobile-layer\"></div>

      <div id=\"footer\" class=\"bootstrap\">
    
</div>
  

      <div class=\"bootstrap\">
      <div class=\"modal fade\" id=\"modal_addons_connect\" tabindex=\"-1\">
\t<div class=\"modal-dialog modal-md\">
\t\t<div class=\"modal-content\">
\t\t\t\t\t\t<div class=\"modal-header\">
\t\t\t\t<button type=\"button\" class=\"close\" data-dismiss=\"modal\">&times;</button>
\t\t\t\t<h4 class=\"modal-title\"><i class=\"icon-puzzle-piece\"></i> <a target=\"_blank\" href=\"https://addons.prestashop.com/?utm_source=back-office&utm_medium=modules&utm_campaign=back-office-ES&utm_content=download\">PrestaShop Addons</a></h4>
\t\t\t</div>
\t\t\t
\t\t\t<div class=\"modal-body\">
\t\t\t\t\t\t<!--start addons login-->
\t\t\t<form id=\"addons_login_form\" method=\"post\" >
\t\t\t\t<div>
\t\t\t\t\t<a href=\"https://addons.prestashop.com/es/login?email=jdelmoral%40inversierra.cl&amp;firstname=Jos%C3%A9&amp;lastname=Delmoral&amp;website=http%3A%2F%2Flocalhost%2Fps_dev%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-ES&amp;utm_content=download#createnow\"><img class=\"img-responsive center-block\" src=\"/ps_dev/admin0178uoq0b/themes/default/img/prestashop-addons-logo.png\" alt=\"Logo PrestaShop Addons\"/></a>
\t\t\t\t\t<h3 class=\"text-center\">Conecta tu tienda con el mercado de PrestaShop para importar automáticamente todas tus compras de Addons.</h3>
\t\t\t\t\t<hr />
\t\t\t\t</div>
\t\t\t\t<div class=\"row\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>¿No tienes una cuenta?</h4>
\t\t\t\t\t\t<p class='text-justify'>¡Descubre el poder de PrestaShop Addons! Explora el Marketplace oficial de PrestaShop y encuentra más de 3.500 módulos y temas innovadores que optimizan las tasas de conversión, aumentan el tráfico, fidelizan a los clientes y maximizan tu productividad</p>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<h4>Conectarme a PrestaShop Addons</h4>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"username_addons\" name=\"username_addons\" type=\"text\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t</div>
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<div class=\"input-group\">
\t\t\t\t\t\t\t\t<div class=\"input-group-prepend\">
\t\t\t\t\t\t\t\t\t<span class=\"input-group-text\"><i class=\"icon-key\"></i></span>
\t\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t\t<input id=\"password_addons\" name=\"password_addons\" type=\"password\" value=\"\" autocomplete=\"off\" class=\"form-control ac_input\">
\t\t\t\t\t\t\t</div>
\t\t\t\t\t\t\t<a class=\"btn btn-link float-right _blank\" href=\"//addons.prestashop.com/es/forgot-your-password\">He olvidado mi contraseña</a>
\t\t\t\t\t\t\t<br>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div class=\"row row-padding-top\">
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<a class=\"btn btn-default btn-block btn-lg _blank\" href=\"https://addons.prestashop.com/es/login?email=jdelmoral%40inversierra.cl&amp;firstname=Jos%C3%A9&amp;lastname=Delmoral&amp;website=http%3A%2F%2Flocalhost%2Fps_dev%2F&amp;utm_source=back-office&amp;utm_medium=connect-to-addons&amp;utm_campaign=back-office-ES&amp;utm_content=download#createnow\">
\t\t\t\t\t\t\t\tCrear una Cuenta
\t\t\t\t\t\t\t\t<i class=\"icon-external-link\"></i>
\t\t\t\t\t\t\t</a>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t\t<div class=\"col-md-6\">
\t\t\t\t\t\t<div class=\"form-group\">
\t\t\t\t\t\t\t<button id=\"addons_login_button\" class=\"btn btn-primary btn-block btn-lg\" type=\"submit\">
\t\t\t\t\t\t\t\t<i class=\"icon-unlock\"></i> Iniciar sesión
\t\t\t\t\t\t\t</button>
\t\t\t\t\t\t</div>
\t\t\t\t\t</div>
\t\t\t\t</div>

\t\t\t\t<div id=\"addons_loading\" class=\"help-block\"></div>

\t\t\t</form>
\t\t\t<!--end addons login-->
\t\t\t</div>


\t\t\t\t\t</div>
\t</div>
</div>

    </div>
  
";
        // line 1297
        $this->displayBlock('javascripts', $context, $blocks);
        $this->displayBlock('extra_javascripts', $context, $blocks);
        $this->displayBlock('translate_javascripts', $context, $blocks);
        echo "</body>
</html>";
    }

    // line 93
    public function block_stylesheets($context, array $blocks = [])
    {
    }

    public function block_extra_stylesheets($context, array $blocks = [])
    {
    }

    // line 1186
    public function block_content_header($context, array $blocks = [])
    {
    }

    // line 1187
    public function block_content($context, array $blocks = [])
    {
    }

    // line 1188
    public function block_content_footer($context, array $blocks = [])
    {
    }

    // line 1189
    public function block_sidebar_right($context, array $blocks = [])
    {
    }

    // line 1297
    public function block_javascripts($context, array $blocks = [])
    {
    }

    public function block_extra_javascripts($context, array $blocks = [])
    {
    }

    public function block_translate_javascripts($context, array $blocks = [])
    {
    }

    public function getTemplateName()
    {
        return "__string_template__7e567820ece5f8a853ddc67912604b3c54881785b817321e80cc7a71e648b713";
    }

    public function getDebugInfo()
    {
        return array (  1387 => 1297,  1382 => 1189,  1377 => 1188,  1372 => 1187,  1367 => 1186,  1358 => 93,  1350 => 1297,  1241 => 1190,  1238 => 1189,  1235 => 1188,  1232 => 1187,  1230 => 1186,  133 => 93,  39 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "__string_template__7e567820ece5f8a853ddc67912604b3c54881785b817321e80cc7a71e648b713", "");
    }
}
