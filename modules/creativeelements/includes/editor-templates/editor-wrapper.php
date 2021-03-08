<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com, Elementor.com
 * @copyright 2019 WebshopWorks & Elementor
 * @license   https://www.gnu.org/licenses/gpl-3.0.html
 */

namespace CreativeElements;

defined('_PS_VERSION_') or exit;

?><!DOCTYPE html>
<html class="no-js" lang="<?php echo \Context::getContext()->language->iso_code; ?>">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <?php if (\Tools::usingSecureMode()) : ?>
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <?php endif; ?>
    <title><?php _e('Creative Elements - Elementor based PageBuilder', 'elementor'); ?></title>
    <link rel="icon" type="image/x-icon" href="<?php echo _PS_IMG_ ?>favicon.ico" />
    <?php do_action('wp_head'); ?>
</head>
<body class="elementor-editor-active">
<div id="elementor-editor-wrapper">
    <div id="elementor-preview">
        <div id="elementor-loading">
            <div class="elementor-loader-wrapper">
                <div class="elementor-loader">
                    <div class="elementor-loader-box"></div>
                    <div class="elementor-loader-box"></div>
                    <div class="elementor-loader-box"></div>
                    <div class="elementor-loader-box"></div>
                </div>
                <div class="elementor-loading-title"><?php _e('Loading', 'elementor'); ?></div>
            </div>
        </div>
        <div id="elementor-preview-responsive-wrapper" class="elementor-device-desktop elementor-device-rotate-portrait">
            <div id="elementor-preview-loading">
                <i class="fa fa-spin fa-circle-o-notch"></i>
            </div>
        </div>
    </div>
    <div id="elementor-panel" class="elementor-panel"></div>
</div>
<?php do_action('wp_footer'); ?>
</body>
</html>