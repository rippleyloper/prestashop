<?php
/**
 * Creative Elements - Elementor based PageBuilder
 *
 * @author    WebshopWorks.com
 * @copyright 2019 WebshopWorks
 * @license   One domain support license
 */

namespace CreativeElements;

defined('_PS_VERSION_') or exit;

class WidgetProductCarousel extends WidgetBase
{
    public function getName()
    {
        return 'product-carousel';
    }

    public function getTitle()
    {
        return __('Product Carousel', 'elementor');
    }

    public function getIcon()
    {
        return 'slider-push';
    }

    public function getCategories()
    {
        return array('prestashop');
    }

    protected function _skinOptions()
    {
        $opts = array();
        $tpls = glob(_PS_THEME_DIR_ . 'templates/catalog/_partials/miniatures/*product*.tpl');

        foreach ($tpls as $tpl) {
            $opt = basename($tpl, '.tpl');
            $opts[$opt] = \Tools::ucFirst($opt);
        }

        return $opts;
    }

    protected function _listingOptions()
    {
        $opts = array(
            'category' => __('Featured Products', 'elementor'),
            'prices-drop' => __('Prices Drop', 'elementor'),
            'new-products' => __('New Products', 'elementor'),
        );

        if (!\Configuration::get('PS_CATALOG_MODE')) {
            $opts['best-sales'] = __('Best Sales', 'elementor');
        }

        return $opts;
    }

    protected function _registerControls()
    {
        $this->startControlsSection(
            'section_product_carousel',
            array(
                'label' => __('Product Carousel', 'elementor'),
            )
        );

        $this->addControl(
            'skin',
            array(
                'label' => __('Skin', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'product',
                'options' => $this->_skinOptions(),
            )
        );

        $this->addControl(
            'listing',
            array(
                'label' => __('Listing', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'category',
                'options' => $this->_listingOptions(),
                'separator' => 'before',
            )
        );

        $this->addControl(
            'category_id',
            array(
                'label' => __('Category ID', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'default' => 2,
                'min' => 2,
                'condition' => array(
                    'listing' => 'category',
                ),
            )
        );

        $this->addControl(
            'order_by',
            array(
                'label' => __('Order By', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'position',
                'options' => array(
                    'position' => __('Popularity', 'elementor'),
                    'quantity' => __('Sales Volume', 'elementor'),
                    'date_add' => __('Arrival', 'elementor'),
                    'date_upd' => __('Update', 'elementor'),
                ),
                'condition' => array(
                    'listing!' => array('new-products', 'best-sales'),
                ),
            )
        );

        $this->addControl(
            'order_dir',
            array(
                'label' => __('Order Direction', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'asc',
                'options' => array(
                    'asc' => __('Ascending', 'elementor'),
                    'desc' => __('Descending', 'elementor'),
                ),
                'condition' => array(
                    'listing!' => array('new-products', 'best-sales'),
                ),
            )
        );

        $this->addControl(
            'randomize',
            array(
                'label' => __('Randomize', 'elementor'),
                'type' => ControlsManager::SWITCHER,
                'label_on' => __('Yes', 'elementor'),
                'label_off' => __('No', 'elementor'),
                'condition' => array(
                    'listing' => 'category',
                ),
            )
        );

        $this->addControl(
            'limit',
            array(
                'label' => __('Product Limit', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'min' => 1,
                'default' => 8,
            )
        );

        $this->addControl(
            'view',
            array(
                'label' => __('View', 'elementor'),
                'type' => ControlsManager::HIDDEN,
                'default' => 'traditional',
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_additional_options',
            array(
                'label' => __('Carousel Settings', 'elementor'),
                'type' => ControlsManager::SECTION,
            )
        );

        $slides_to_show = range(1, 10);
        $slides_to_show = array_combine($slides_to_show, $slides_to_show);

        $this->addResponsiveControl(
            'slides_to_show',
            array(
                'label' => __('Products to Show', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '',
                'options' => array(
                    '' => __('Default', 'elementor'),
                ) + $slides_to_show,
            )
        );

        $this->addControl(
            'slides_to_scroll',
            array(
                'label' => __('Products to Scroll', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => '2',
                'options' => $slides_to_show,
                'condition' => array(
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->addControl(
            'navigation',
            array(
                'label' => __('Navigation', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'both',
                'options' => array(
                    'both' => __('Arrows and Dots', 'elementor'),
                    'arrows' => __('Arrows', 'elementor'),
                    'dots' => __('Dots', 'elementor'),
                    'none' => __('None', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'additional_options',
            array(
                'label' => __('Additional Options', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
            )
        );

        $this->addControl(
            'pause_on_hover',
            array(
                'label' => __('Pause on Hover', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'autoplay',
            array(
                'label' => __('Autoplay', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'autoplay_speed',
            array(
                'label' => __('Autoplay Speed', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'default' => 5000,
            )
        );

        $this->addControl(
            'infinite',
            array(
                'label' => __('Infinite Loop', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'yes',
                'options' => array(
                    'yes' => __('Yes', 'elementor'),
                    'no' => __('No', 'elementor'),
                ),
            )
        );

        $this->addControl(
            'effect',
            array(
                'label' => __('Effect', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'slide',
                'options' => array(
                    'slide' => __('Slide', 'elementor'),
                    'fade' => __('Fade', 'elementor'),
                ),
                'condition' => array(
                    'slides_to_show' => '1',
                ),
            )
        );

        $this->addControl(
            'speed',
            array(
                'label' => __('Animation Speed', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'default' => 500,
            )
        );

        $this->addControl(
            'direction',
            array(
                'label' => __('Direction', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'ltr',
                'options' => array(
                    'ltr' => __('Left', 'elementor'),
                    'rtl' => __('Right', 'elementor'),
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_navigation',
            array(
                'label' => __('Navigation', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
                'condition' => array(
                    'navigation' => array('arrows', 'dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'heading_style_arrows',
            array(
                'label' => __('Arrows', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'arrows_position',
            array(
                'label' => __('Arrows Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'inside',
                'options' => array(
                    'inside' => __('Inside', 'elementor'),
                    'outside' => __('Outside', 'elementor'),
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'arrows_size',
            array(
                'label' => __('Arrows Size', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 20,
                        'max' => 60,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'arrows_color',
            array(
                'label' => __('Arrows Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-prev:before, {{WRAPPER}} .elementor-image-carousel-wrapper .slick-slider .slick-next:before' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );
        $this->addControl(
            'arrows_bg_color',
            array(
                'label' => __('Background Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper  .slick-slider .slick-prev, {{WRAPPER}} .elementor-image-carousel-wrapper  .slick-slider .slick-next' => 'background: {{VALUE}};',
                ),
                'condition' => array(
                    'navigation' => array('arrows', 'both'),
                ),
            )
        );

        $this->addControl(
            'heading_style_dots',
            array(
                'label' => __('Dots', 'elementor'),
                'type' => ControlsManager::HEADING,
                'separator' => 'before',
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'dots_position',
            array(
                'label' => __('Dots Position', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'outside',
                'options' => array(
                    'outside' => __('Outside', 'elementor'),
                    'inside' => __('Inside', 'elementor'),
                ),
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'dots_size',
            array(
                'label' => __('Dots Size', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'min' => 5,
                        'max' => 10,
                    ),
                ),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'font-size: {{SIZE}}{{UNIT}};',
                ),
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->addControl(
            'dots_color',
            array(
                'label' => __('Dots Color', 'elementor'),
                'type' => ControlsManager::COLOR,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-dots li button:before' => 'color: {{VALUE}};',
                ),
                'condition' => array(
                    'navigation' => array('dots', 'both'),
                ),
            )
        );

        $this->endControlsSection();

        $this->startControlsSection(
            'section_style_product',
            array(
                'label' => __('Product', 'elementor'),
                'tab' => ControlsManager::TAB_STYLE,
            )
        );

        $this->addControl(
            'product_spacing',
            array(
                'label' => __('Spacing', 'elementor'),
                'type' => ControlsManager::SELECT,
                'options' => array(
                    '' => __('Default', 'elementor'),
                    'custom' => __('Custom', 'elementor'),
                ),
                'default' => '',
                'condition' => array(
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->addControl(
            'product_spacing_custom',
            array(
                'label' => __('Product Spacing', 'elementor'),
                'type' => ControlsManager::SLIDER,
                'range' => array(
                    'px' => array(
                        'max' => 100,
                    ),
                ),
                'default' => array(
                    'size' => 20,
                ),
                'show_label' => false,
                'selectors' => array(
                    // '{{WRAPPER}} .slick-list' => 'margin-left: -{{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .slick-slide .slick-slide-inner' => 'margin: 0 calc({{SIZE}}{{UNIT}} / 2);',
                ),
                'condition' => array(
                    'product_spacing' => 'custom',
                    'slides_to_show!' => '1',
                ),
            )
        );

        $this->addGroupControl(
            GroupControlBorder::getType(),
            array(
                'name' => 'product_border',
                'selector' => '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-slide-inner',
            )
        );

        $this->addControl(
            'product_border_radius',
            array(
                'label' => __('Border Radius', 'elementor'),
                'type' => ControlsManager::DIMENSIONS,
                'size_units' => array('px', '%'),
                'selectors' => array(
                    '{{WRAPPER}} .elementor-image-carousel-wrapper .elementor-image-carousel .slick-slide-inner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ),
            )
        );

        $this->endControlsSection();
    }

    public function getControls($control_id = null)
    {
        $controls = parent::getControls($control_id);

        if (_THEME_NAME_ == 'classic') {
            if (isset($controls['_margin'])) {
                $controls['_margin']['default'] = array(
                    'top' => '0',
                    'right' => '-10',
                    'bottom' => '0',
                    'left' => '-10',
                    'unit' => 'px',
                    'isLinked' => false,
                );
            }

            if (isset($controls['_css_classes'])) {
                $controls['_css_classes']['default'] = 'featured-products';
            }
        }

        return $controls;
    }

    protected function getProducts($listing, $orderBy, $orderDir, $limit, $categoryId = 2)
    {
        $query = new \PrestaShop\PrestaShop\Core\Product\Search\ProductSearchQuery();
        $query->setResultsPerPage($limit <= 0 ? 8 : (int) $limit);
        $query->setQueryType($listing);

        switch ($listing) {
            case 'category':
                $category = new \Category((int) $categoryId);
                $searchProvider = new \PrestaShop\PrestaShop\Adapter\Category\CategoryProductSearchProvider($this->context->getTranslator(), $category);
                $query->setQueryType($listing);
                $query->setSortOrder(
                    $orderBy == 'rand'
                    ? \PrestaShop\PrestaShop\Core\Product\Search\SortOrder::random()
                    : new \PrestaShop\PrestaShop\Core\Product\Search\SortOrder('product', $orderBy, $orderDir)
                );
                break;
            case 'prices-drop':
                $searchProvider = new \PrestaShop\PrestaShop\Adapter\PricesDrop\PricesDropProductSearchProvider($this->context->getTranslator());
                $query->setQueryType($listing);
                $query->setSortOrder(new \PrestaShop\PrestaShop\Core\Product\Search\SortOrder('product', $orderBy, $orderDir));
                break;
            case 'new-products':
                $searchProvider = new \PrestaShop\PrestaShop\Adapter\NewProducts\NewProductsProductSearchProvider($this->context->getTranslator());
                $query->setSortOrder(new \PrestaShop\PrestaShop\Core\Product\Search\SortOrder('product', 'date_add', 'desc'));
                break;
            case 'best-sales':
                $searchProvider = new \PrestaShop\PrestaShop\Adapter\BestSales\BestSalesProductSearchProvider($this->context->getTranslator());
                $query->setSortOrder(new \PrestaShop\PrestaShop\Core\Product\Search\SortOrder('product', 'name', 'asc'));
                break;
        }

        $result = $searchProvider->runQuery(new \PrestaShop\PrestaShop\Core\Product\Search\ProductSearchContext($this->context), $query);

        $assembler = new \ProductAssembler($this->context);
        $presenterFactory = new \ProductPresenterFactory($this->context);
        $presentationSettings = $presenterFactory->getPresentationSettings();
        $presenter = new \PrestaShop\PrestaShop\Core\Product\ProductListingPresenter(
            new \PrestaShop\PrestaShop\Adapter\Image\ImageRetriever($this->context->link),
            $this->context->link,
            new \PrestaShop\PrestaShop\Adapter\Product\PriceFormatter(),
            new \PrestaShop\PrestaShop\Adapter\Product\ProductColorsRetriever(),
            $this->context->getTranslator()
        );

        $products_for_template = array();

        foreach ($result->getProducts() as $rawProduct) {
            $products_for_template[] = $presenter->present(
                $presentationSettings,
                $assembler->assembleProduct($rawProduct),
                $this->context->language
            );
        }

        return $products_for_template;
    }

    protected function render()
    {
        $settings = $this->getSettings();

        if ($settings['randomize'] && $settings['listing'] == 'category') {
            $settings['order_by'] = 'rand';
        }
        $products = $this->getProducts(
            $settings['listing'],
            $settings['order_by'],
            $settings['order_dir'],
            $settings['limit'],
            $settings['category_id']
        );

        if (empty($products) || !file_exists(_PS_THEME_DIR_ . "templates/catalog/_partials/miniatures/{$settings['skin']}.tpl")) {
            return;
        }

        $tpl = "catalog/_partials/miniatures/{$settings['skin']}.tpl";
        $prods = array();

        foreach ($products as &$product) {
            $this->context->smarty->assign('product', $product);
            $prods[] = '<div><div class="slick-slide-inner">' . $this->context->smarty->fetch($tpl) . '</div></div>';
        }

        $is_slideshow = '1' === $settings['slides_to_show'];
        $is_rtl = ('rtl' === $settings['direction']);
        $direction = $is_rtl ? 'rtl' : 'ltr';
        $show_dots = (in_array($settings['navigation'], array('dots', 'both')));
        $show_arrows = (in_array($settings['navigation'], array('arrows', 'both')));

        $slick_options = array(
            'slidesToShow' => empty($settings['slides_to_show']) ? 4 : absint($settings['slides_to_show']),
            'slidesToShowTablet' => empty($settings['slides_to_show_tablet']) ? 3 : absint($settings['slides_to_show_tablet']),
            'slidesToShowMobile' => empty($settings['slides_to_show_mobile']) ? 1 : absint($settings['slides_to_show_mobile']),
            'autoplaySpeed' => absint($settings['autoplay_speed']),
            'autoplay' => ('yes' === $settings['autoplay']),
            'infinite' => ('yes' === $settings['infinite']),
            'pauseOnHover' => ('yes' === $settings['pause_on_hover']),
            'speed' => absint($settings['speed']),
            'arrows' => $show_arrows,
            'dots' => $show_dots,
            'rtl' => $is_rtl,
        );

        $carousel_classes = array('elementor-image-carousel');

        if ($show_arrows) {
            $carousel_classes[] = 'slick-arrows-' . $settings['arrows_position'];
        }

        if ($show_dots) {
            $carousel_classes[] = 'slick-dots-' . $settings['dots_position'];
        }

        if (!$is_slideshow) {
            $slick_options['slidesToScroll'] = absint($settings['slides_to_scroll']);
        } else {
            $slick_options['fade'] = ('fade' === $settings['effect']);
        }

        ?>
        <div class="elementor-image-carousel-wrapper elementor-slick-slider" dir="<?php echo $direction; ?>">
            <div class="<?php echo implode(' ', $carousel_classes); ?>" data-slider_options='<?php echo json_encode($slick_options); ?>'>
                <?php echo implode('', $prods); ?>
            </div>
        </div>
        <?php
    }

    protected function _contentTemplate()
    {
    }

    public function __construct($data = array(), $args = array())
    {
        $this->context = \Context::getContext();
        parent::__construct($data, $args);
    }
}
