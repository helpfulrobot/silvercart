<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Widgets
 */

/**
 * Provides a view of items of a definable productgroup.
 *
 * @package Silvercart
 * @subpackage Widgets
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 26.05.2011
 * @license see license file in modules root directory
 * @copyright 2013 pixeltricks GmbH
 */
class SilvercartProductGroupItemsWidget extends SilvercartWidget implements SilvercartProductSliderWidget {
    
    /**
     * Attributes.
     * 
     * @var array
     */
    public static $db = array(
        'numberOfProductsToShow'        => 'Int',
        'numberOfProductsToFetch'       => 'Int',
        'fetchMethod'                   => "Enum('random,sortOrderAsc','random')",
        'GroupView'                     => 'VarChar(255)',
        'isContentView'                 => 'Boolean',
        'Autoplay'                      => 'Boolean(1)',
        'autoPlayDelayed'               => 'Boolean(1)',
        'autoPlayLocked'                => 'Boolean(0)',
        'buildArrows'                   => 'Boolean(1)',
        'buildNavigation'               => 'Boolean(1)',
        'buildStartStop'                => 'Boolean(1)',
        'slideDelay'                    => 'Int',
        'stopAtEnd'                     => 'Boolean(0)',
        'transitionEffect'              => "Enum('fade,horizontalSlide,verticalSlide','fade')",
        'useSlider'                     => "Boolean(0)",
        'useRoundabout'                 => "Boolean(0)",
        'SilvercartProductGroupPageID'  => 'Int',
        'useSelectionMethod'            => "Enum('productGroup,products','productGroup')"
    );

    /**
     * Has_many relationships.
     *
     * @var array
     */
    public static $many_many = array(
        'SilvercartProducts' => 'SilvercartProduct'
    );
    
    /**
     * field casting
     *
     * @var array
     */
    public static $casting = array(
        'FrontTitle'                    => 'VarChar(255)',
        'FrontContent'                  => 'Text',
    );
    
    /**
     * Set default values.
     * 
     * @var array
     */
    public static $defaults = array(
        'numberOfProductsToShow'    => 5,
        'numberOfProductsToFetch'   => 5,
        'slideDelay'                => 5000
    );
    
    /**
     * 1:1 or 1:n relationships.
     *
     * @var array
     */
    public static $has_many = array(
        'SilvercartProductGroupItemsWidgetLanguages' => 'SilvercartProductGroupItemsWidgetLanguage'
    );
    
    /**
     * Getter for the front title depending on the set language
     *
     * @return string  
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 27.01.2012
     */
    public function getFrontTitle() {
        return $this->getLanguageFieldValue('FrontTitle');
    }
    
    /**
     * Getter for the FrontContent depending on the set language
     *
     * @return string The HTML front content 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 27.01.2012
     */
    public function getFrontContent() {
        return $this->getLanguageFieldValue('FrontContent');
    }
    
    /**
     * Returns an array of field/relation names (db, has_one, has_many, 
     * many_many, belongs_many_many) to exclude from form scaffolding in
     * backend.
     * This is a performance friendly way to exclude fields.
     * Excludes all fields that are added in a ToggleCompositeField later.
     * 
     * @return array
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 21.02.2013
     */
    public function excludeFromScaffolding() {
        $parentExcludes = parent::excludeFromScaffolding();
        
        $excludeFromScaffolding = array_merge(
                $parentExcludes,
                array(
                    'Autoplay',
                    'autoPlayDelayed',
                    'autoPlayLocked',
                    'buildArrows',
                    'buildNavigation',
                    'buildStartStop',
                    'slideDelay',
                    'stopAtEnd',
                    'transitionEffect',
                    'useSlider',
                    'useRoundabout',
                    'GroupView',
                    'SilvercartProductGroupPageID'
                )
        );
        $this->extend('updateExcludeFromScaffolding', $excludeFromScaffolding);
        return $excludeFromScaffolding;
    }
    
    /**
     * Returns the input fields for this widget.
     * 
     * @return FieldList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 13.03.2014
     */
    public function getCMSFields() {
        $fetchMethods = array(
            'random'       => $this->fieldLabel('fetchMethodRandom'),
            'sortOrderAsc' => $this->fieldLabel('fetchMethodSortOrderAsc')
        );
        $fields = SilvercartWidgetTools::getCMSFieldsForProductSliderWidget($this, $fetchMethods);
        
        return $fields;
    }
    
    /**
     * Returns the slider tab input fields for this widget.
     * 
     * @param TabSet &$rootTabSet The root tab set
     * 
     * @return FieldList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function getCMSFieldsSliderTab(&$rootTabSet) {
        SilvercartWidgetTools::getCMSFieldsSliderTabForProductSliderWidget($this, $rootTabSet);
    }
    
    /**
     * Returns the slider tab input fields for this widget.
     * 
     * @param TabSet &$rootTabSet The root tab set
     * 
     * @return FieldList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function getCMSFieldsRoundaboutTab(&$rootTabSet) {
        SilvercartWidgetTools::getCMSFieldsRoundaboutTabForProductSliderWidget($this, $rootTabSet);
    }
    
    /**
     * Adds the database relation sort as default and returns the 
     * SilvercartProducts relation.
     * 
     * @param string $filter MySQL filter
     * @param string $sort   MySQL sort
     * @param string $join   MySQL join
     * @param string $limit  MySQL limit
     * 
     * @return ComponentSet
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 03.06.2015
     */
    public function SilvercartProducts($filter = "", $sort = "", $join = "", $limit = "") {
        if (empty($sort)) {
            $result  = DB::query('SELECT "SilvercartProductID" FROM "SilvercartProductGroupItemsWidget_SilvercartProducts" WHERE "SilvercartProductGroupItemsWidgetID" = ' . $this->ID . ' ORDER BY "ID" ASC');
            $idOrder = array_keys($result->map());
            if (count($idOrder) > 0) {
                $sort = 'FIELD("SilvercartProduct"."ID",' . implode(',', $idOrder) . ')';
            }
        }
        return $this->getManyManyComponents('SilvercartProducts', $filter, $sort, $join, $limit);
    }
    
    /**
     * Returns the title of this widget.
     * 
     * @return string
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.08.2013
     */
    public function Title() {
        $title = $this->fieldLabel('Title');
        if (!empty($this->FrontTitle)) {
            $title .= ': ' . $this->FrontTitle;
        }
        return $title;
    }
    
    /**
     * Returns the title of this widget for display in the WidgetArea GUI.
     * 
     * @return string
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.08.2013
     */
    public function CMSTitle() {
        $title = $this->fieldLabel('CMSTitle');
        if (!empty($this->FrontTitle)) {
            $title .= ': ' . $this->FrontTitle;
        }
        return $title;
    }
    
    /**
     * Returns the description of what this template does for display in the
     * WidgetArea GUI.
     * 
     * @return string
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 26.05.2011
     */
    public function Description() {
        return $this->fieldLabel('Description');
    }

    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     *
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 03.03.2014
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
                parent::fieldLabels($includerelations),
                SilvercartWidgetTools::fieldLabelsForProductSliderWidget($this),
                array(
                    'SilvercartProductGroupPage'                 => _t('SilvercartProductGroupItemsWidget.STOREADMIN_FIELDLABEL'),
                    'SilvercartProductGroupPageDescription'      => _t('SilvercartProductGroupItemsWidget.SilvercartProductGroupPageDescription'),
                    'useSelectionMethod'                         => _t('SilvercartProductGroupItemsWidget.USE_SELECTIONMETHOD'),
                    'SelectionMethodProductGroup'                => _t('SilvercartProductGroupItemsWidget.SELECTIONMETHOD_PRODUCTGROUP'),
                    'SelectionMethodProducts'                    => _t('SilvercartProductGroupItemsWidget.SELECTIONMETHOD_PRODUCTS'),
                    'ProductGroupTab'                            => _t('SilvercartProductGroupItemsWidget.CMS_PRODUCTGROUPTABNAME'),
                    'SilvercartProductGroupItemsWidgetLanguages' => _t('SilvercartConfig.TRANSLATIONS'),
                    'SelectProductDescription'                   => _t("SilvercartProductGroupItemsWidget.SELECT_PRODUCT_DESCRIPTION"),
                    'SilvercartProducts'                         => _t('SilvercartProduct.PLURALNAME')    
                )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }
    
    /**
     * We set checkbox field values here to false if they are not in the post
     * data array.
     *
     * @param array $data The post data array
     *
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function populateFromPostData($data) {
        SilvercartWidgetTools::populateFromPostDataForProductSliderWidget($this, $data);
        parent::populateFromPostData($data);
    }
}

/**
 * Provides a view of items of a definable productgroup.
 *
 * @package Silvercart
 * @subpackage Widgets
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 26.05.2011
 * @license see license file in modules root directory
 * @copyright 2013 pixeltricks GmbH
 */
class SilvercartProductGroupItemsWidget_Controller extends SilvercartWidget_Controller implements SilvercartProductSliderWidget_Controller {

    /**
     * Product elements
     *
     * @var ArrayList 
     */
    protected $elements = null;
    
    /**
     * Returns the elements
     *
     * @return ArrayList
     */
    public function getElements() {
        return $this->elements;
    }

    /**
     * Sets the elements
     *
     * @param ArrayList $elements Elements to set
     * 
     * @return void
     */
    public function setElements(ArrayList $elements) {
        $this->elements = $elements;
    }
    
    /**
     * Register forms for the contained products.
     * 
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function init() {
        SilvercartWidgetTools::initProductSliderWidget($this);
    }
    
    /**
     * Insert the javascript necessary for the anything slider.
     *
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function initAnythingSlider() {
        SilvercartWidgetTools::initAnythingSliderForProductSliderWidget($this);
    }
    
    /**
     * Insert the javascript necessary for the roundabout slider.
     *
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public function initRoundabout() {
        SilvercartWidgetTools::initRoundaboutForProductSliderWidget($this);
    }
    
    /**
     * Returns a number of products from the chosen productgroup.
     * 
     * @return ArrayList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.08.2013
     */
    public function ProductPages() {
        if ($this->elements !== null &&
            $this->elements !== false) {
            $template = SilvercartWidgetTools::getGroupViewTemplateName($this);
            foreach ($this->elements as $page) {
                $page->Content = $page->renderWith($template);
            }
            return $this->elements;
        }
        switch ($this->useSelectionMethod) {
            case 'products':
                $this->elements = $this->getElementsByProducts();
                break;
            case 'productGroup':
            default:
                $this->elements = $this->getElementsByProductGroup();
                break;
        }

        if (!$this->SilvercartProductGroupPageID) {
            return false;
        }
        
        if (!$this->numberOfProductsToFetch) {
            $this->numberOfProductsToFetch = SilvercartProductGroupItemsWidget::$defaults['numberOfProductsToFetch'];
        }
        if (!$this->numberOfProductsToShow) {
            $this->numberOfProductsToShow = SilvercartProductGroupItemsWidget::$defaults['numberOfProductsToShow'];
        }

        if ($this->numberOfProductsToFetch < $this->numberOfProductsToShow) {
            $this->numberOfProductsToFetch = $this->numberOfProductsToShow;
        }

        if ($this->numberOfProductsToFetch == $this->numberOfProductsToShow ||
            $this->useSelectionMethod == 'products') {
            $products = $this->elements;
        } else {
            $productgroupPage = DataObject::get_by_id(
                'SilvercartProductGroupPage',
                $this->SilvercartProductGroupPageID
            );

            if (!$productgroupPage) {
                return false;
            }
            $productgroupPageSiteTree = ModelAsController::controller_for($productgroupPage);

            switch ($this->fetchMethod) {
                case 'sortOrderAsc':
                    $products = $productgroupPageSiteTree->getProducts($this->numberOfProductsToFetch);
                    break;
                case 'random':
                default:
                    $products = $productgroupPageSiteTree->getRandomProducts($this->numberOfProductsToFetch);
            }
        }

        $pages          = array();
        $pageProducts   = array();
        $pageNr         = 0;
        $pageProductIdx = 1;
        $isFirst        = true;

        if ($products->exists()) {
            $products = new ArrayList($products->toArray());
            foreach ($products as $product) {
                $product->addCartFormIdentifier = $this->ID.'_'.$product->ID;
                $pageProducts[] = $product;
                $pageProductIdx++;

                if ($pageNr > 0) {
                    $isFirst = false;
                }
                if ($pageProductIdx > $this->numberOfProductsToShow) {
                    $pages[$pageNr] = new ArrayData(
                            array(
                                'Elements' => new ArrayList($pageProducts),
                                'IsFirst'  => $isFirst
                            )
                    );
                    $pageProductIdx = 1;
                    $pageProducts   = array();
                    $pageNr++;
                }
            }
        }

        if (!array_key_exists($pageNr, $pages) &&
            !empty($pageProducts)) {

            if ($pageNr > 0) {
                $isFirst = false;
            }

            $pages[$pageNr] = new ArrayData(
                    array(
                        'Elements' => new ArrayList($pageProducts),
                        'IsFirst'  => $isFirst
                    )
            );
        }

        $this->elements = new ArrayList($pages);
        
        return $this->elements;
    }

    /**
     * Returns the elements for the static slider view.
     * 
     * @return ArrayList
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.02.2013
     */
    public function Elements() {
        if (is_null($this->elements)) {
            switch ($this->useSelectionMethod) {
                case 'products':
                    $this->elements = $this->getElementsByProducts();
                    break;
                case 'productGroup':
                default:
                    $this->elements = $this->getElementsByProductGroup();
                    break;
            }

            $this->elements = new ArrayList($this->elements->toArray());

            foreach ($this->elements as $element) {
                $element->addCartFormIdentifier = $this->ID.'_'.$element->ID;
            }
        }

        return $this->elements;
    }
    
    /**
     * Creates the cache key for this widget.
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>, Sascha Koehler <skoehler@pixeltricks.de>
     * @since 02.07.2012
     */
    public function WidgetCacheKey() {
        $key = SilvercartWidgetTools::ProductWidgetCacheKey($this);
        return $key;
    }
    
    /**
     * Returns the content for non slider widgets
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 30.05.2012
     */
    public function ElementsContent() {
        return $this->customise(array(
            'Elements' => $this->Elements(),
        ))->renderWith(SilvercartWidgetTools::getGroupViewTemplateName($this));
    }

    /**
     * Returns the manually chosen products.
     * 
     * @return ArrayList
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 03.02.2012
     */
    public function getElementsByProducts() {
        $products = $this->SilvercartProducts();
        
        foreach ($products as $product) {
            $product->addCartFormIdentifier = $this->ID.'_'.$product->ID;
        }

        return $products;
    }

    /**
     * Returns a number of products from the chosen productgroup.
     * 
     * @return DataList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.02.2013
     */
    public function getElementsByProductGroup() {
        $elements = new ArrayList();

        if (!$this->SilvercartProductGroupPageID) {
            return $elements;
        }

        if (!$this->numberOfProductsToShow) {
            $this->numberOfProductsToShow = SilvercartProductGroupItemsWidget::$defaults['numberOfProductsToShow'];
        }

        $productgroupPage = DataObject::get_by_id(
            'SilvercartProductGroupPage',
            $this->SilvercartProductGroupPageID
        );

        if (!$productgroupPage) {
            return $elements;
        }
        $productgroupPageSiteTree = ModelAsController::controller_for($productgroupPage);

        if (!SilvercartWidget::$use_product_pages_for_slider &&
            $this->useSlider) {
            $fetchLimit = $this->numberOfProductsToFetch;
        } else {
            $fetchLimit = $this->numberOfProductsToShow;
        }
        
        switch ($this->fetchMethod) {
            case 'sortOrderAsc':
                $elements = $productgroupPageSiteTree->getProducts()->limit($fetchLimit);
                break;
            case 'random':
            default:
                $elements = $productgroupPageSiteTree->getRandomProducts($fetchLimit);
        }
        
        return $elements;
    }
    
    /**
     * Returns the title of the product group that items are shown.
     *
     * @return string
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 15.04.2011
     */
    public function ProductGroupTitle() {
        $title = '';
        
        if (!$this->SilvercartProductGroupPageID) {
            return $title;
        }
        
        $productgroupPage = DataObject::get_by_id(
            'SilvercartProductGroupPage',
            $this->SilvercartProductGroupPageID
        );
        
        if (!$productgroupPage) {
            return $title;
        }
        
        $title = $productgroupPage->MenuTitle;
        
        return $title;
    }
}

/**
 * Translation object of SilvercartProductGroupItemsWidget
 * 
 * @package Silvercart
 * @subpackage Translation
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 27.01.2012
 * @license see license file in modules root directory
 */
class SilvercartProductGroupItemsWidgetLanguage extends DataObject {
    
    /**
     * Attributes.
     *
     * @var array
     */
    public static $db = array(
        'FrontTitle'                    => 'VarChar(255)',
        'FrontContent'                  => 'Text'
    );
    
    /**
     * 1:1 or 1:n relationships.
     *
     * @var array
     */
    public static $has_one = array(
        'SilvercartProductGroupItemsWidget' => 'SilvercartProductGroupItemsWidget'
    );
    
    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string The objects singular name 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 13.07.2012
     */
    public function singular_name() {
        return SilvercartTools::singular_name_for($this);
    }


    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string the objects plural name
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 13.07.2012
     */
    public function plural_name() {
        return SilvercartTools::plural_name_for($this); 
    }
    
    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     *
     * @return array
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 27.01.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'FrontTitle'                        => _t('WidgetSetWidget.FRONTTITLE'),
                    'FrontContent'                      => _t('WidgetSetWidget.FRONTCONTENT'),
                    'SilvercartProductGroupItemsWidget' => _t('SilvercartProductGroupItemsWidget.SINGULARNAME')
                )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }

    /**
     * Summary fields
     *
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.04.2012
     */
    public function summaryFields() {
        $summaryFields = array_merge(
                parent::summaryFields(),
                array(
                    'FrontTitle'    => $this->fieldLabel('FrontTitle'),
                )
        );

        $this->extend('updateSummaryFields', $summaryFields);
        return $summaryFields;
    }
}