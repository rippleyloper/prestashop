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

class WidgetLogin extends WidgetBase
{
    public function getName()
    {
        return 'login';
    }

    public function getTitle()
    {
        return __('Login', 'elementor');
    }

    public function getIcon()
    {
        return 'lock-user';
    }

    public function getCategories()
    {
        return array('prestashop');
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_fields_content',
            array(
                'label' => __('Form Fields', 'elementor'),
            )
        );

        $this->addControl(
            'show_labels',
            array(
                'label' => __('Label', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => 'yes',
                'label_off' => __('Hide', 'elementor'),
                'label_on' => __('Show', 'elementor'),
            )
        );

        $this->addControl(
            'input_size',
            array(
                'label' => __('Input Size', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'xs' => __('Extra Small', 'elementor'),
                    'sm' => __('Small', 'elementor'),
                    'md' => __('Medium', 'elementor'),
                    'lg' => __('Large', 'elementor'),
                    'xl' => __('Extra Large', 'elementor'),
                ),
                'default' => 'sm',
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_button_content',
            array(
                'label' => __('Button', 'elementor'),
            )
        );

        $this->addControl(
            'button_text',
            array(
                'label' => __('Text', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => __('Log In', 'elementor'),
            )
        );

        $this->addControl(
            'button_size',
            array(
                'label' => __('Size', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    'xs' => __('Extra Small', 'elementor'),
                    'sm' => __('Small', 'elementor'),
                    'md' => __('Medium', 'elementor'),
                    'lg' => __('Large', 'elementor'),
                    'xl' => __('Extra Large', 'elementor'),
                ),
                'default' => 'sm',
            )
        );

        $this->addResponsiveControl(
            'align',
            array(
                'label' => __('Alignment', 'elementor'),
                'type' => ControlsManager::CHOOSE,
                'options' => array(
                    'start' => array(
                        'title' => __('Left', 'elementor'),
                        'icon' => 'fa fa-align-left',
                    ),
                    'center' => array(
                        'title' => __('Center', 'elementor'),
                        'icon' => 'fa fa-align-center',
                    ),
                    'end' => array(
                        'title' => __('Right', 'elementor'),
                        'icon' => 'fa fa-align-right',
                    ),
                    'stretch' => array(
                        'title' => __('Justified', 'elementor'),
                        'icon' => 'fa fa-align-justify',
                    ),
                ),
                'prefix_class' => 'elementor%s-button-align-',
                'default' => '',
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_login_content',
            array(
                'label' => __('Additional Options', 'elementor'),
            )
        );

        $this->addControl(
            'redirect_after_login',
            array(
                'label' => __('Redirect After Login', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'label_off' => __('Off', 'elementor'),
                'label_on' => __('On', 'elementor'),
            )
        );

        $this->addControl(
            'redirect_url',
            array(
                'type' => ControlsManager::URL,
                'show_label' => false,
                'show_external' => false,
                'separator' => false,
                'placeholder' => __('https://your-link.com', 'elementor'),
                'description' => __('Note: Because of security reasons, you can ONLY use your current domain here.', 'elementor'),
                'condition' => array(
                    'redirect_after_login' => 'yes',
                ),
            )
        );

        $this->addControl(
            'redirect_after_logout',
            array(
                'label' => __('Redirect After Logout', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => '',
                'label_off' => __('Off', 'elementor'),
                'label_on' => __('On', 'elementor'),
            )
        );

        $this->addControl(
            'redirect_logout_url',
            array(
                'type' => ControlsManager::URL,
                'show_label' => false,
                'show_external' => false,
                'separator' => false,
                'placeholder' => __('https://your-link.com', 'elementor'),
                'description' => __('Note: Because of security reasons, you can ONLY use your current domain here.', 'elementor'),
                'condition' => array(
                    'redirect_after_logout' => 'yes',
                ),
            )
        );

        $this->addControl(
            'show_lost_password',
            array(
                'label' => __('Lost your password?', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => 'yes',
                'label_off' => __('Hide', 'elementor'),
                'label_on' => __('Show', 'elementor'),
            )
        );

        if (get_option('users_can_register')) {
            $this->addControl(
                'show_register',
                array(
                    'label' => __('Register', 'elementor'),
                    'type' => ControlsManager::SWITCHER,
                    'default' => 'yes',
                    'label_off' => __('Hide', 'elementor'),
                    'label_on' => __('Show', 'elementor'),
                )
            );
        }

        $this->addControl(
            'show_remember_me',
            array(
                'label' => __('Remember Me', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => 'yes',
                'label_off' => __('Hide', 'elementor'),
                'label_on' => __('Show', 'elementor'),
            )
        );

        $this->addControl(
            'show_logged_in_message',
            array(
                'label' => __('Logged in Message', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'default' => 'yes',
                'label_off' => __('Hide', 'elementor'),
                'label_on' => __('Show', 'elementor'),
            )
        );

        $this->addControl(
            'custom_labels',
            array(
                'label' => __('Custom Label', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'condition' => array(
                    'show_labels' => 'yes',
                ),
            )
        );

        $this->addControl(
            'user_label',
            array(
                'label' => __('Username Label', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => __(' Username or Email Address', 'elementor'),
                'condition' => array(
                    'show_labels' => 'yes',
                    'custom_labels' => 'yes',
                ),
            )
        );

        $this->addControl(
            'user_placeholder',
            array(
                'label' => __('Username Placeholder', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => __(' Username or Email Address', 'elementor'),
                'condition' => array(
                    'show_labels' => 'yes',
                    'custom_labels' => 'yes',
                ),
            )
        );

        $this->addControl(
            'password_label',
            array(
                'label' => __('Password Label', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => __('Password', 'elementor'),
                'condition' => array(
                    'show_labels' => 'yes',
                    'custom_labels' => 'yes',
                ),
            )
        );

        $this->addControl(
            'password_placeholder',
            array(
                'label' => __('Password Placeholder', 'elementor'),
                'type' => ControlsManager::TEXT,
                'default' => __('Password', 'elementor'),
                'condition' => array(
                    'show_labels' => 'yes',
                    'custom_labels' => 'yes',
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style',
            array(
                'label' => __('Form', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'row_gap',
            array(
                'label' => __('Rows Gap', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => '10',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group' => 'margin-bottom: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-form-fields-wrapper' => 'margin-bottom: -{{SIZE}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'links_color',
            array(
                'label' => __('Links Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group > a' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ),
            )
        );

        $this->addControl(
            'links_hover_color',
            array(
                'label' => __('Links Hover Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group > a:hover' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_labels',
            array(
                'label' => __('Label', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => array(
                    'show_labels!' => '',
                ),
            )
        );

        $this->addControl(
            'label_spacing',
            array(
                'label' => __('Spacing', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'default' => array(
                    'size' => '0',
                ),
                'range' => array(
                    'px' => array(
                        'min' => 0,
                        'max' => 60,
                    ),
                ),
                'selectors' => array(
                    'body {{WRAPPER}} .elementor-field-group > label' => 'padding-bottom: {{SIZE}}{{UNIT}};',
                    // for the label position = above option
                ),
            )
        );

        $this->addControl(
            'label_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-form-fields-wrapper' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .elementor-form-fields-wrapper',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_field_style',
            array(
                'label' => __('Fields', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'field_text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group .elementor-field' => 'color: {{VALUE}};',
                ),
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_3,
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'field_typography',
                'selector' => '{{WRAPPER}} .elementor-field-group .elementor-field, {{WRAPPER}} .elementor-field-subgroup label',
                'scheme' => SchemeTypography::TYPOGRAPHY_3,
            )
        );

        $this->addControl(
            'field_background_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '#ffffff',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'background-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'background-color: {{VALUE}};',
                ),
                'separator' => 'before',
            )
        );

        $this->addControl(
            'field_border_color',
            array(
                'label' => __('Border Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-color: {{VALUE}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper::before' => 'color: {{VALUE}};',
                ),
                'separator' => 'before',
            )
        );

        $this->addControl(
            'field_border_width',
            array(
                'label' => __('Border Width', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'placeholder' => '1',
                'size_units' => array('px'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'field_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-field-group .elementor-field:not(.elementor-select-wrapper)' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .elementor-field-group .elementor-select-wrapper select' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_button_style',
            array(
                'label' => __('Button', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->startControlsTabs('tabs_button_style');

        $this->startControlsTab(
            'tab_button_normal',
            array(
                'label' => __('Normal', 'elementor'),
            )
        );

        $this->addControl(
            'button_text_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'default' => '',
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlTypography::getType(),
            array(
                'name' => 'button_typography',
                'scheme' => SchemeTypography::TYPOGRAPHY_4,
                'selector' => '{{WRAPPER}} .elementor-button',
            )
        );

        $this->addControl(
            'button_background_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'scheme' => array(
                    'type' => SchemeColor::getType(),
                    'value' => SchemeColor::COLOR_4,
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'button_border',
                'placeholder' => '1px',
                'default' => '1px',
                'selector' => '{{WRAPPER}} .elementor-button',
                'separator' => 'before',
            )
        );

        $this->addControl(
            'button_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->addControl(
            'button_text_padding',
            array(
                'label' => __('Text Padding', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', 'em', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsTab();

        $this->startControlsTab(
            'tab_button_hover',
            array(
                'label' => __('Hover', 'elementor'),
            )
        );

        $this->addControl(
            'button_hover_color',
            array(
                'label' => __('Text Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button:hover' => 'color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'button_background_hover_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button:hover' => 'background-color: {{VALUE}};',
                ),
            )
        );

        $this->addControl(
            'button_hover_border_color',
            array(
                'label' => __('Border Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-button:hover' => 'border-color: {{VALUE}};',
                ),
                'condition' => array(
                    'button_border_border!' => '',
                ),
            )
        );

        $this->addControl(
            'button_hover_animation',
            array(
                'label' => __('Animation', 'elementor'),
                'type' => ControlsManager::HOVER_ANIMATION,
            )
        );

        $this->endControlsTab();

        $this->endControlsTabs();

        $this->endControlsSection();
    }

    private function formFieldsRenderAttributes()
    {
        $settings = $this->getSettings();

        if (!empty($settings['button_size'])) {
            $this->addRenderAttribute('button', 'class', 'elementor-size-' . $settings['button_size']);
        }

        if ($settings['button_hover_animation']) {
            $this->addRenderAttribute('button', 'class', 'elementor-animation-' . $settings['button_hover_animation']);
        }

        $this->addRenderAttribute(
            array(
                'wrapper' => array(
                    'class' => array(
                        'elementor-form-fields-wrapper',
                    ),
                ),
                'field-group' => array(
                    'class' => array(
                        'elementor-field-type-text',
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-col-100',
                    ),
                ),
                'submit-group' => array(
                    'class' => array(
                        'elementor-field-group',
                        'elementor-column',
                        'elementor-field-type-submit',
                        'elementor-col-100',
                    ),
                ),

                'button' => array(
                    'class' => array(
                        'elementor-button',
                    ),
                    'name' => 'wp-submit',
                ),
                'user_label' => array(
                    'for' => 'user',
                ),
                'user_input' => array(
                    'type' => 'text',
                    'name' => 'log',
                    'id' => 'user',
                    'placeholder' => $settings['user_placeholder'],
                    'class' => array(
                        'elementor-field',
                        'elementor-field-textual',
                        'elementor-size-' . $settings['input_size'],
                    ),
                ),
                'password_input' => array(
                    'type' => 'password',
                    'name' => 'pwd',
                    'id' => 'password',
                    'placeholder' => $settings['password_placeholder'],
                    'class' => array(
                        'elementor-field',
                        'elementor-field-textual',
                        'elementor-size-' . $settings['input_size'],
                    ),
                ),
                //TODO: add unique ID
                'label_user' => array(
                    'for' => 'user',
                    'class' => 'elementor-field-label',
                ),

                'label_password' => array(
                    'for' => 'password',
                    'class' => 'elementor-field-label',
                ),
            )
        );

        if (!$settings['show_labels']) {
            $this->addRenderAttribute('label', 'class', 'elementor-screen-only');
        }

        $this->addRenderAttribute('field-group', 'class', 'elementor-field-required')
            ->addRenderAttribute('input', 'required', true)
            ->addRenderAttribute('input', 'aria-required', 'true')
        ;
    }

    protected function render()
    {
        $settings = $this->getSettings();
        $current_url = remove_query_arg('fake_arg');
        $logout_redirect = $current_url;

        if ('yes' === $settings['redirect_after_login'] && !empty($settings['redirect_url']['url'])) {
            $redirect_url = $settings['redirect_url']['url'];
        } else {
            $redirect_url = $current_url;
        }

        if ('yes' === $settings['redirect_after_logout'] && !empty($settings['redirect_logout_url']['url'])) {
            $logout_redirect = $settings['redirect_logout_url']['url'];
        }

        if (is_user_logged_in() && !Plugin::elementor()->editor->isEditMode()) {
            if ('yes' === $settings['show_logged_in_message']) {
                $current_user = wp_get_current_user();

                echo '<div class="elementor-login">' .
                sprintf(__('You are Logged in as %1$s (<a href="%2$s">Logout</a>)', 'elementor'), $current_user->display_name, wp_logout_url($logout_redirect)) .
                    '</div>';
            }

            return;
        }

        $this->formFieldsRenderAttributes();
        ?>
        <form class="elementor-login elementor-form" method="post" action="<?php echo esc_url(site_url('wp-login.php', 'login_post')); ?>">
            <input type="hidden" name="redirect_to" value="<?php echo esc_attr($redirect_url); ?>">
            <div <?php echo $this->getRenderAttributeString('wrapper'); ?>>
                <div <?php echo $this->getRenderAttributeString('field-group'); ?>>
                    <?php
                    if ($settings['show_labels']) {
                        echo '<label ' . $this->getRenderAttributeString('user_label') . '>' . $settings['user_label'] . '</label>';
                    }

                    echo '<input size="1" ' . $this->getRenderAttributeString('user_input') . '>';
                    ?>
                </div>
                <div <?php echo $this->getRenderAttributeString('field-group'); ?>>
                    <?php
                    if ($settings['show_labels']) {
                        echo '<label ' . $this->getRenderAttributeString('password_label') . '>' . $settings['password_label'] . '</label>';
                    }

                    echo '<input size="1" ' . $this->getRenderAttributeString('password_input') . '>';
                    ?>
                </div>

                <?php if ('yes' === $settings['show_remember_me']) : ?>
                    <div class="elementor-field-type-checkbox elementor-field-group elementor-column elementor-col-100 elementor-remember-me">
                        <label for="elementor-login-remember-me">
                            <input type="checkbox" id="elementor-login-remember-me" name="rememberme" value="forever">
                            <?php echo __('Remember Me', 'elementor'); ?>
                        </label>
                    </div>
                <?php endif;?>

                <div <?php echo $this->getRenderAttributeString('submit-group'); ?>>
                    <button type="submit" <?php echo $this->getRenderAttributeString('button'); ?>>
                            <?php if (!empty($settings['button_text'])) : ?>
                                <span class="elementor-button-text"><?php echo $settings['button_text']; ?></span>
                            <?php endif;?>
                    </button>
                </div>

                <?php
                $show_lost_password = 'yes' === $settings['show_lost_password'];
                $show_register = get_option('users_can_register') && 'yes' === $settings['show_register'];
                ?>
                <?php if ($show_lost_password || $show_register) : ?>
                    <div class="elementor-field-group elementor-column elementor-col-100">
                        <?php if ($show_lost_password) : ?>
                            <a class="elementor-lost-password" href="<?php echo wp_lostpassword_url($redirect_url); ?>">
                                <?php echo __('Lost your password?', 'elementor'); ?>
                            </a>
                        <?php endif;?>

                        <?php if ($show_register) : ?>
                            <?php if ($show_lost_password) : ?>
                                <span class="elementor-login-separator"> | </span>
                            <?php endif;?>
                            <a class="elementor-register" href="<?php echo wp_registration_url(); ?>">
                                <?php echo __('Register', 'elementor'); ?>
                            </a>
                        <?php endif;?>
                    </div>
                <?php endif;?>
            </div>
        </form>
        <?php
    }

    protected function _contentTemplate()
    {
        ?>
        <div class="elementor-login elementor-form">
            <div class="elementor-form-fields-wrapper">
                <# fieldGroupClasses = 'elementor-field-group elementor-column elementor-col-100 elementor-field-type-text'; #>
                <div class="{{ fieldGroupClasses }}">
                    <# if ( settings.show_labels ) { #>
                        <label class="elementor-field-label" for="user" >{{{ settings.user_label }}}</label>
                        <# } #>
                            <input size="1" type="text" id="user" placeholder="{{ settings.user_placeholder }}" class="elementor-field elementor-field-textual elementor-size-{{ settings.input_size }}" />
                </div>
                <div class="{{ fieldGroupClasses }}">
                    <# if ( settings.show_labels ) { #>
                        <label class="elementor-field-label" for="password" >{{{ settings.password_label }}}</label>
                        <# } #>
                            <input size="1" type="password" id="password" placeholder="{{ settings.password_placeholder }}" class="elementor-field elementor-field-textual elementor-size-{{ settings.input_size }}" />
                </div>

                <# if ( settings.show_remember_me ) { #>
                    <div class="elementor-field-type-checkbox elementor-field-group elementor-column elementor-col-100 elementor-remember-me">
                        <label for="elementor-login-remember-me">
                            <input type="checkbox" id="elementor-login-remember-me" name="rememberme" value="forever">
                            <?php echo __('Remember Me', 'elementor'); ?>
                        </label>
                    </div>
                <# } #>

                <div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100">
                    <button type="submit" class="elementor-button elementor-size-{{ settings.button_size }}">
                        <# if ( settings.button_text ) { #>
                            <span class="elementor-button-text">{{ settings.button_text }}</span>
                        <# } #>
                    </button>
                </div>

                <# if ( settings.show_lost_password || settings.show_register ) { #>
                    <div class="elementor-field-group elementor-column elementor-col-100">
                        <# if ( settings.show_lost_password ) { #>
                            <a class="elementor-lost-password" href="<?php // TODO ?>">
                                <?php echo __('Lost your password?', 'elementor'); ?>
                            </a>
                        <# } #>

                        <?php if (get_option('users_can_register')) {?>
                            <# if ( settings.show_register ) { #>
                                <# if ( settings.show_lost_password ) { #>
                                    <span class="elementor-login-separator"> | </span>
                                <# } #>
                                <a class="elementor-register" href="<?php // TODO ?>">
                                    <?php echo __('Register', 'elementor'); ?>
                                </a>
                            <# } #>
                        <?php }?>
                    </div>
                <# } #>
            </div>
        </div>
        <?php
    }
}
