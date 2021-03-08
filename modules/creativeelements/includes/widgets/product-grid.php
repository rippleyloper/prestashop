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

class WidgetProductGrid extends WidgetBase
{
    public function getName()
    {
        return 'product-grid';
    }

    public function getTitle()
    {
        return __('Product Grid', 'elementor');
    }

    public function getIcon()
    {
        return 'gallery-grid';
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
            'section_grid_settings',
            array(
                'label' => __('Product Grid', 'elementor'),
            )
        );

        if (!$this->ps16) {
            $this->addControl(
                'skin',
                array(
                    'label' => __('Skin', 'elementor'),
                    'type' => ControlsManager::SELECT,
                    'default' => 'product',
                    'options' => $this->_skinOptions(),
                )
            );
        }

        $this->addControl(
            'listing',
            array(
                'label' => __('Listing', 'elementor'),
                'type' => ControlsManager::SELECT,
                'default' => 'category',
                'options' => $this->_listingOptions(),
                'separator' => $this->ps16 ? '' : 'before',
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
            'num_of_prods',
            array(
                'label' => __('Product Limit', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'min' => 1,
                'default' => 8,
            )
        );

        $this->addResponsiveControl(
            'columns',
            array(
                'label' => __('Columns', 'elementor'),
                'type' => ControlsManager::NUMBER,
                'min' => 1,
                'selectors' => array(
                    '{{WRAPPER}} .elementor-product-grid > *' => implode(';', array(
                        '-ms-flex-preferred-size: calc(100% / {{VALUE}})',
                        '-webkit-flex-basis: calc(100% / {{VALUE}})',
                        'flex-basis: calc(100% / {{VALUE}})',
                        'max-width: calc(100% / {{VALUE}})',
                    )),
                ),
                'default' => 4,
                'tablet_default' => 3,
                'mobile_default' => 1,
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
                    'rand' == $orderBy
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

    protected function getProducts16($listing, $orderBy, $orderDir, $limit, $categoryId = 2)
    {
        if (\Configuration::get('PS_CATALOG_MODE')) {
            return false;
        }
        $lang_id = (int) $this->context->language->id;

        switch ($listing) {
            case 'category':
                $category = new \Category($categoryId, $lang_id);
                if ('rand' == $orderBy) {
                    $result = $category->getProducts($lang_id, 0, $limit, null, null, false, true, true, $limit);
                } else {
                    $result = $category->getProducts($lang_id, 0, $limit, $orderBy, $orderDir);
                }
                break;
            case 'prices-drop':
                $result = \Product::getPricesDrop($lang_id, 0, (int) $limit, false, $orderBy, $orderDir);
                break;
            case 'new-products':
                $result = \Product::getNewProducts($lang_id, 0, (int) $limit);
                break;
            case 'best-sales':
                $result = \ProductSale::getBestSales($lang_id, 0, (int) $limit);
                break;
        }

        if (empty($result)) {
            return false;
        }

        $currency = new \Currency($this->context->cookie->id_currency);
        $usetax = \Product::getTaxCalculationMethod((int) $this->context->customer->id) != PS_TAX_EXC;
        foreach ($result as &$row) {
            $row['price'] = \Tools::displayPrice(\Product::getPriceStatic((int) $row['id_product'], $usetax), $currency);
        }

        return $result;
    }

    protected function render()
    {
        $settings = $this->getSettings();

        if ($settings['randomize'] && $settings['listing'] == 'category') {
            $settings['order_by'] = 'rand';
        }

        $args = array(
            $settings['listing'],
            $settings['order_by'],
            $settings['order_dir'],
            $settings['num_of_prods'],
            $settings['category_id']
        );

        if ($this->ps16) {
            $tpl = _PS_THEME_DIR_ . 'product-list.tpl';
            $products = call_user_func_array(array($this, 'getProducts16'), $args);

            if (empty($products) || !file_exists($tpl)) {
                return;
            }

            $this->context->smarty->assign(array(
                'id' => '',
                'class' => 'elementor-product-grid',
                'products' => $products,
            ));
            echo $this->context->smarty->fetch($tpl);
        } else {
            $tpl = "catalog/_partials/miniatures/{$settings['skin']}.tpl";
            $products = call_user_func_array(array($this, 'getProducts'), $args);

            if (empty($products) || !file_exists(_PS_THEME_DIR_ . 'templates/' . $tpl)) {
                return;
            }

            echo '<div class="elementor-product-grid">';
            foreach ($products as &$product) {
                $this->context->smarty->assign('product', $product);
                echo $this->context->smarty->fetch($tpl);
            }
            echo '</div>';
        }
    }

    protected function _contentTemplate()
    {
    }

    public function __construct($data = array(), $args = array())
    {
        $this->context = \Context::getContext();
        $this->ps16 = version_compare(_PS_VERSION_, '1.7', '<');

        parent::__construct($data, $args);
    }
}
