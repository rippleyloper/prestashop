<?php
/* Smarty version 3.1.33, created on 2021-01-20 13:07:12
  from '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/admin/install.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_600855301ffe58_29912203',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'dba163e8fd4e4cb3c2e6bd0c435d7643662f7e72' => 
    array (
      0 => '/var/www/html/ps_dev/modules/cdc_googletagmanager/views/templates/admin/install.tpl',
      1 => 1611158743,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_600855301ffe58_29912203 (Smarty_Internal_Template $_smarty_tpl) {
?><style>
	.cdc-info {
		background: #d9edf7;
		color: #1b809e;
		padding: 7px;
		/*border-left: solid 3px #1b809e;*/
		margin-top: 50px;
		font-weight: normal;
	}

	.cdc-warning-box {
		background: #FFF3D7;
		color: #D2A63C;
		padding: 16px;
		font-weight: bold;
		border: solid 2px #fcc94f;
		margin: 30px 0;
		text-align: center;
		font-size: 1.2em;
	}

	.hook_ok {
		color: #00aa00;
		font-weight: bold;
	}
	.hook_nok {
		color: #cc0000;
		font-weight: bold;
	}
	.hook_list {
		font-family: monospace;
		list-style-type: square;
	}
</style>
<div class="bootstrap">


<div class="panel text-center">
	<img src="<?php echo call_user_func_array($_smarty_tpl->registered_plugins[ 'modifier' ][ 'escape' ][ 0 ], array( $_smarty_tpl->tpl_vars['module_dir']->value,'htmlall','UTF-8' ));?>
/logo.png" >
	<h1>
		Google Tag Manager Enhanced E-commerce
		<br /><small>GTM integration + Enhanced E-commerce + Google Trusted Stores</small>
	</h1>
</div>

<div>


	<div class="panel">
		<div>
			<h2>INSTALLATION</h2>
			<p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'In order to work properly, this module needs the installation of custom hooks :','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>

            <!-- Loading -->
            <div class="check-hooks-loading">
                <div class="alert alert-info"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Checking if hooks are correctly installed, please wait a couple of seconds...','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</div>
            </div>

            <!-- General error -->
            <div class="check-hooks-result check-hooks-error" style="display: none;">
                <div class="alert alert-danger"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Error while checking if hooks are correctly installed. Please contact the support, and add these informations.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</div>

                <pre id="error-detail"></pre>

                <a href="https://addons.prestashop.com/contact-community.php?id_product=23806" target="_blank" class="btn btn-info btn-lg button">
                    <b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Contact the support','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b>
                </a>

                <div style="margin-top: 15px;">
                    <em>
                        <?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I am sure that I have correctly installed the hooks but the hook locator cannot find it.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>

                        <a href="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&force_installed_hooks"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I want to bypass this verification.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>
                    </em>
                </div>
            </div>

            <!-- Success -->
            <div class="check-hooks-result check-hooks-success" style="display: none;">
                <div class="alert alert-success"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'All the hooks are correctly installed!','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</div>

                <a href="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&force_installed_hooks" class="btn btn-success btn-lg button"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Go to the configuration screen','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
 &raquo;</b></a>
            </div>

            <!-- Missing hooks -->
            <div class="check-hooks-result check-hooks-missing" style="display: none;">
                <div class="alert alert-danger"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Some hooks are missing. Please install these hooks before continuing:','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</div>
            
                <ul class="hook_list">
                </ul>

                <?php if (empty($_smarty_tpl->tpl_vars['troubleshooting']->value)) {?>
                <div style="margin: 20px 0 30px 0;">
                    <a href="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&install_hooks" class="btn btn-success btn-lg button"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Install missing hooks automatically','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></a>

                    <div style="margin: 10px 0 0 0;">
                        <em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I am sure that I have correctly installed the hooks but the hook locator cannot find it.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>

                        <a href="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&force_installed_hooks"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I want to bypass this verification.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a></em>
                    </div>
                </div>
                <?php }?>
            </div>
			
		</div>

        

        <?php if ($_smarty_tpl->tpl_vars['multishop']->value) {?>
        <div>
            <h2><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Multishops','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</h2>
            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Multishop feature is enabled and you have at least 2 shops. The automatic installation may fails if you have many themes. Please refer to the documentation and install the hooks manually.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>

            <a href="https://comptoirducode.com/prestashop/modules/google-tag-manager/documentation-google-tag-manager-prestashop/" target="_blank">
                <b>Read the documentation to know how to install hooks</b>
            </a>
        </div>
        <?php }?>

	</div>


    <!-- Troubleshooting -->
    <?php if (!empty($_smarty_tpl->tpl_vars['troubleshooting']->value)) {?>
    <div class="panel">
        <div>
            <h2><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'INSTALLATION TROUBLESHOOTING','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</h2>
            <h4 class="text-danger"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'The automatic installation has failed.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</h4>
            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'It is due to an incompatibility with your theme files.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</p>
            <p><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'You will have to install the hooks manually. Don\'t worry, this is something very easy.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></p>
            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Please read the documentation to install the missing hooks. When you are done, you can check if hooks are correctly installed by clicking on the button','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
 <b>[<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check if hooks are correctly installed','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
]</b>.</p>
        </div>


        <div style="margin: 20px 0;">
            <a href="https://comptoirducode.com/prestashop/modules/google-tag-manager/documentation-google-tag-manager-prestashop/" target="_blank" class="btn btn-info btn-lg button">
                <b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Read the documentation to know how to install hooks','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b>
            </a>
            <a href="#" id="check-hooks-installation" class="btn btn-success btn-lg button"><b><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Check if hooks are correctly installed','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</b></a>
        </div>
        <em><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I am sure that I have correctly installed the hooks but the hook locator cannot find it.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>

        <a href="<?php echo $_smarty_tpl->tpl_vars['form_action']->value;?>
&force_installed_hooks"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'I want to bypass this verification.','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a></em>


        <div>
            <h2><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Contact us','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</h2>
            <p><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'f you still have problem installing the hooks, you can contact','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
 <a href="https://addons.prestashop.com/contact-community.php?id_product=23806" target="_blank"><?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'our support team on Prestashop','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
</a>.</p>
        </div>

    </div>
    <?php }?>


</div>
</div>


<?php echo '<script'; ?>
> 

    function checkHooks() {
        var hooks = {
            'displayAfterTitle': 0,
            'displayAfterBodyOpeningTag': 0,
            'displayBeforeBodyClosingTag': 0
        };


        // reset
        $('.check-hooks-result').hide();
        $('.check-hooks-loading').show();
        $('.hook_list').empty();

        // get homepage
        console.log("GET <?php echo $_smarty_tpl->tpl_vars['check_url']->value;?>
");
        $.get("<?php echo $_smarty_tpl->tpl_vars['check_url']->value;?>
", function(page_content) {

            var success = true;

            for (var hook in hooks) {
                var hook_key = "cdcgtm_" + hook;
                console.log("search hook " + hook + "(key: " + hook_key + ") ...");
                if (page_content.indexOf(hook_key) >= 0) {
                    hooks[hook] = 1;
                    console.log("hook " + hook + " found");
                } else {
                    console.log("hook " + hook + " not found");
                    success = false;
                }
            };

            // display result
            $('.check-hooks-loading').hide();
            if(success) {
                $('.check-hooks-success').fadeIn(400);
            } else {
                $('.check-hooks-missing').fadeIn(400);

                console.log(hooks);
                for (var hook in hooks) {
                    var hookOK = 0;
                    if (hooks.hasOwnProperty(hook)) {
                        hookOK = hooks[hook];
                    }

                    var css_class = hookOK ? 'hook_ok' : 'hook_nok';
                    var text = hookOK ? "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Found','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
" : "<?php echo call_user_func_array( $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['l'][0], array( array('s'=>'Not found','mod'=>'cdc_googletagmanager'),$_smarty_tpl ) );?>
";

                    $('.hook_list').append('<li>' + hook + ': <span class="' + css_class + '">' + text + '</span></li>');
                }
            }

        }).fail(function(xhr, status) {
            var errorDetail = {
                status: xhr.status,
                head: xhr.getAllResponseHeaders()
            }
            $('#error-detail').text(JSON.stringify(errorDetail));
            
            $('.check-hooks-loading').hide();
            $('.check-hooks-error').fadeIn(400);
        });
    }

    checkHooks();
    

    $('#check-hooks-installation').on('click', function(e) {
        e.preventDefault();
        checkHooks();
    });

<?php echo '</script'; ?>
><?php }
}
