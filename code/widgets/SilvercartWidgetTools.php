<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Base
 */

/**
 * Provides methods for common widget tasks in SilverCart.
 * 
 * @package Silvercart
 * @subpackage Widgets
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 28.03.2012
 * @license see license file in modules root directory
 */
class SilvercartWidgetTools extends Object {
    
    /**
     * Returns the slider tab input fields for this widget.
     * 
     * @param SilvercartWidget $widget      Widget to initialize
     * @param TabList          &$rootTabSet The root tab set
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.03.2014
     * @deprecated since version 3.1 - Use getCMSFieldsSliderToggleForSliderWidget instead.
     */
    public static function getCMSFieldsSliderTabForProductSliderWidget(SilvercartWidget $widget, &$rootTabSet) {
        self::getCMSFieldsSliderToggleForSliderWidget($widget, $rootTabSet);
    }
    
    /**
     * Returns the input fields for this widget.
     * 
     * @param Widget $widget       Widget to initialize
     * @param array  $fetchMethods Optional list of product fetch methods
     * 
     * @return FieldList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 13.03.2014
     */
    public static function getCMSFieldsForProductSliderWidget(Widget $widget, $fetchMethods = array()) {
        if (empty($fetchMethods)) {
            $fetchMethods               = array(
                    'random'        => $widget->fieldLabel('fetchMethodRandom'),
                    'sortOrderAsc'  => $widget->fieldLabel('fetchMethodSortOrderAsc'),
                    'sortOrderDesc' => $widget->fieldLabel('fetchMethodSortOrderDesc'),
            );
        }
        $fields = SilvercartDataObject::getCMSFields($widget, 'ExtraCssClasses', false);
        
        $productGroupDropdown = new TreeDropdownField(
                'SilvercartProductGroupPageID',
                $widget->fieldLabel('SilvercartProductGroupPage'),
                'SiteTree'
        );
        $productGroupDropdown->setTreeBaseID(SilvercartTools::PageByIdentifierCode('SilvercartProductGroupHolder')->ID);
        
        $toggleFields = array(
            $fields->dataFieldByName('numberOfProductsToShow'),
            $fields->dataFieldByName('numberOfProductsToFetch'),
            $fields->dataFieldByName('fetchMethod'),
            SilvercartGroupViewHandler::getGroupViewDropdownField('GroupView', $widget->fieldLabel('GroupView'), $widget->GroupView),
        );
        
        $fields->dataFieldByName('fetchMethod')->setSource($fetchMethods);
        $fields->dataFieldByName('numberOfProductsToShow')->setDescription($widget->fieldLabel('numberOfProductsToShowInfo'));
        $fields->dataFieldByName('isContentView')->setDescription($widget->fieldLabel('isContentViewInfo'));
        
        if (is_object($fields->dataFieldByName('useSelectionMethod'))) {
            $fields->dataFieldByName('useSelectionMethod')->setSource(
                        array(
                            'productGroup' => $widget->fieldLabel('SelectionMethodProductGroup'),
                            'products'     => $widget->fieldLabel('SelectionMethodProducts')
                        )
            );
            $toggleFields[] = $fields->dataFieldByName('useSelectionMethod');
            $productGroupDropdown->setDescription($widget->fieldLabel('SilvercartProductGroupPageDescription'));
        }
        $toggleFields[] = $productGroupDropdown;
        $productDataToggle = ToggleCompositeField::create(
                'ProductDataToggle',
                $widget->fieldLabel('ProductDataToggle'),
                $toggleFields
        )->setHeadingLevel(4);
        
        $productRelationToggle = ToggleCompositeField::create(
                'ProductRelationToggle',
                $widget->fieldLabel('ProductRelationToggle'),
                array(
                    $fields->dataFieldByName('SilvercartProducts'),
                )
        )->setHeadingLevel(4);
        
        $fields->removeByName('numberOfProductsToShow');
        $fields->removeByName('numberOfProductsToFetch');
        $fields->removeByName('fetchMethod');
        $fields->removeByName('useSelectionMethod');
        $fields->removeByName('SilvercartProducts');
        
        $fields->addFieldToTab("Root.Main", $productDataToggle);
        $fields->addFieldToTab("Root.Main", $productRelationToggle);
        
        $widget->getCMSFieldsSliderTab($fields);
        //$widget->getCMSFieldsRoundaboutTab($fields);
        
        return $fields;
    }
    
    /**
     * Adds the slider toggle input fields for this widget.
     * 
     * @param SilvercartWidget $widget Widget to initialize
     * @param TabList          $fields Fields to add toggle to
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.03.2014
     */
    public static function getCMSFieldsSliderToggleForSliderWidget(SilvercartWidget $widget, $fields) {
        $useSlider          = new CheckboxField('useSlider',        $widget->fieldLabel('useSlider'));
        $autoplay           = new CheckboxField('Autoplay',         $widget->fieldLabel('Autoplay'));
        $slideDelay         = new TextField('slideDelay',           $widget->fieldLabel('slideDelay'));
        $buildArrows        = new CheckboxField('buildArrows',      $widget->fieldLabel('buildArrows'));
        $buildNavigation    = new CheckboxField('buildNavigation',  $widget->fieldLabel('buildNavigation'));
        $buildStartStop     = new CheckboxField('buildStartStop',   $widget->fieldLabel('buildStartStop'));
        $autoPlayDelayed    = new CheckboxField('autoPlayDelayed',  $widget->fieldLabel('autoPlayDelayed'));
        $autoPlayLocked     = new CheckboxField('autoPlayLocked',   $widget->fieldLabel('autoPlayLocked'));
        $stopAtEnd          = new CheckboxField('stopAtEnd',        $widget->fieldLabel('stopAtEnd'));
        $transitionEffect   = new DropdownField(
            'transitionEffect',
            $widget->fieldLabel('transitionEffect'),
            array(
                'fade'              => $widget->fieldLabel('transitionEffectFade'),
                'horizontalSlide'   => $widget->fieldLabel('transitionEffectHSlide'),
                'verticalSlide'     => $widget->fieldLabel('transitionEffectVSlide'),
            )
        );
        
        $sliderToggle = ToggleCompositeField::create(
                'Slider',
                $widget->fieldLabel('SlideshowTab'),
                array(
                    $useSlider,
                    $autoplay,
                    $slideDelay,
                    $buildArrows,
                    $buildNavigation,
                    $buildStartStop,
                    $autoPlayDelayed,
                    $autoPlayLocked,
                    $stopAtEnd,
                    $transitionEffect,
                )
        )->setHeadingLevel(4);
        $fields->addFieldToTab("Root.Main", $sliderToggle);
    }
    
    /**
     * Returns the slider tab input fields for this widget.
     * 
     * @param Widget $widget      Widget to initialize
     * @param TabSet &$rootTabSet The root tab set
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public static function getCMSFieldsRoundaboutTabForProductSliderWidget(Widget $widget, &$rootTabSet) {
        $tab        = new Tab('roundabout',                 $widget->fieldLabel('RoundaboutTab'));
        $useSlider  = new CheckboxField('useRoundabout',    $widget->fieldLabel('useRoundabout'));
        
        $tab->push($useSlider);
        $rootTabSet->push($tab);
    }
    
    /**
     * Default initialization of a product slider widget
     * 
     * @param SilvercartWidget_Controller $widget Widget to initialize
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public static function initProductSliderWidget(SilvercartWidget_Controller $widget) {
        if (SilvercartWidget::$use_product_pages_for_slider &&
            ($widget->useSlider ||
             $widget->useRoundabout)) {
            $widget->ProductPages();
        } else {
            $widget->Elements();
        }
        
        if ($widget->getElements()->count() > 0) {
            $elementIdx = 0;

            if (SilvercartWidget::$use_product_pages_for_slider &&
                ($widget->useSlider ||
                 $widget->useRoundabout)) {
                // Roundabout / Slider
                foreach ($widget->getElements() as $productPage) {
                    foreach ($productPage as $elementHolder) {
                        $elements = array();
                        if ($elementHolder instanceof ArrayList) {
                            $elements = $elementHolder;
                        } elseif ($elementHolder instanceof ArrayData) {
                            $elements = $elementHolder->Elements;
                        }
                        foreach ($elements as $element) {
                            self::registerAddCartFormForProductWidget($widget, $element, $elementIdx);
                        }
                    }
                }
            } else {
                // Standard view
                foreach ($widget->getElements() as $element) {
                    self::registerAddCartFormForProductWidget($widget, $element, $elementIdx);
                }
            }
        }
        
        if ($widget->useSlider) {
            $widget->initAnythingSlider();
        } elseif ($widget->useRoundabout) {
            $widget->initRoundabout();
        }
    }
    
    /**
     * Insert the javascript necessary for the anything slider.
     * 
     * @param SilvercartWidget_Controller $widget Widget to initialize
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public static function initAnythingSliderForProductSliderWidget(SilvercartWidget_Controller $widget) {
        if (!SilvercartWidget::$use_anything_slider) {
            return;
        }
        $autoplay           = 'false';
        $autoPlayDelayed    = 'false';
        $autoPlayLocked     = 'true';
        $stopAtEnd          = 'false';
        $buildArrows        = 'false';
        $buildStartStop     = 'false';
        $buildNavigation    = 'false';

        if ($widget->Autoplay) {
            $autoplay = 'true';
        }
        if ($widget->buildArrows) {
            $buildArrows = 'true';
        }
        if ($widget->buildNavigation) {
            $buildNavigation = 'true';
        }
        if ($widget->buildStartStop) {
            $buildStartStop = 'true';
        }
        if ($widget->autoPlayDelayed) {
            $autoPlayDelayed = 'true';
        }
        if ($widget->autoPlayLocked) {
            $autoPlayLocked = 'false';
        }
        if ($widget->stopAtEnd) {
            $stopAtEnd = 'true';
        }

        switch ($widget->transitionEffect) {
            case 'horizontalSlide':
                $vertical           = 'false';
                $animationTime      = 500;
                $delayBeforeAnimate = 0;
                $effect             = 'swing';
                break;
            case 'verticalSlide':
                $vertical           = 'true';
                $animationTime      = 500;
                $delayBeforeAnimate = 0;
                $effect             = 'swing';
                break;
            case 'fade':
            default:
                $vertical           = 'false';
                $animationTime      = 0;
                $delayBeforeAnimate = 500;
                $effect             = 'fade';
        }

        $jsID = $widget->ClassName . 'Slider' . $widget->ID;
        Requirements::customScript(
            sprintf('
                $(document).ready(function() {
                    $("#%s")
                    .anythingSlider({
                        autoPlay:           %s,
                        autoPlayDelayed:    %s,
                        autoPlayLocked:     %s,
                        stopAtEnd:          %s,
                        buildArrows:        %s,
                        buildNavigation:    %s,
                        buildStartStop:     %s,
                        delay:              %d,
                        animationTime:      %s,
                        delayBeforeAnimate: %d,
                        theme:              \'silvercart-default\',
                        vertical:           %s,
                        navigationFormatter: function(index, panel){
                            panel.css("display", "block");
                            return index;
                        }
                    })
                    .anythingSliderFx({
                        // base FX definitions
                        // ".selector" : [ "effect(s)", "size", "time", "easing" ]
                        // "size", "time" and "easing" are optional parameters, but must be kept in order if added
                        \'.panel\' : [ \'%s\', \'\', 500, \'easeInOutCirc\' ]
                    });
                });
                ',
                $jsID,
                $autoplay,
                $autoPlayDelayed,
                $autoPlayLocked,
                $stopAtEnd,
                $buildArrows,
                $buildNavigation,
                $buildStartStop,
                $widget->slideDelay,
                $animationTime,
                $delayBeforeAnimate,
                $vertical,
                $effect
            )
        );
    }
    
    /**
     * Insert the javascript necessary for the roundabout slider.
     * 
     * @param SilvercartWidget_Controller $widget Widget to initialize
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public static function initRoundaboutForProductSliderWidget(SilvercartWidget_Controller $widget) {
        $jsID = $widget->ClassName . 'Slider' . $widget->ID;
        Requirements::customScript(
            sprintf('
                $(document).ready(function() {
                    $("#%s").roundabout({
                        shape:        "square",
                        duration:     500,
                        minScale:     1.0,
                        maxScale:     1.0,
                        minOpacity:   0.9,
                        tilt:         0.0,
                        degree:       0
                    });
                    $("#%s .roundabout-in-focus").css({
                        width: \'670px\',
                        height: \'252px\',
                        margin: \'-13px 0px 0px -150px\'
                    });
                    $("#%s .roundabout-in-focus .c20r").css("display", "block");
                    $("#%s .roundabout-in-focus .c30l").css("display", "block");
                    
                    $("#%s .roundabout-moveable-item").bind("focus", function() {
                        $(this).animate({
                                width: \'+=335\',
                                height: \'+=26\',
                                marginLeft: \'-=150\',
                                marginTop: \'-=13\'
                            },
                            400,
                            ""
                        );
                        $(this).find(".c20r").show();
                        $(this).find(".c30l").show();
                        
                        return true;
                    });
                    $("#%s .roundabout-moveable-item").bind("blur", function() {
                        $(this).find(".c20r").hide();
                        $(this).find(".c30l").hide();
                        
                        $(this).css({
                            width: \'-=335\',
                            height: \'-=26\',
                            marginLeft: \'+=150\',
                            marginTop: \'+=13\'
                        });
                        
                        return true;
                    });
                });
                ',
                $jsID,
                $jsID,
                $jsID,
                $jsID,
                $jsID,
                $jsID
            )
        );
    }
    
    /**
     * Returns the template to render the products with
     *
     * @param SilvercartWidget_Controller $widget              Widget to get template for
     * @param string                      $templateBaseContent Base name for the content widget template
     * @param string                      $templateBaseSidebar Base name for the sidebar widget template
     * 
     * @return string
     */
    public static function getGroupViewTemplateName(SilvercartWidget_Controller $widget, $templateBaseContent = 'SilvercartProductGroupPage', $templateBaseSidebar = 'SilvercartWidgetProductBox') {
        if (empty($widget->GroupView)) {
            $widget->GroupView = SilvercartGroupViewHandler::getDefaultGroupViewInherited();
        }
        if ($widget->isContentView) {
            $groupViewTemplateName = SilvercartGroupViewHandler::getProductGroupPageTemplateNameFor($widget->GroupView, $templateBaseContent);
        } else {
            $groupViewTemplateName = SilvercartGroupViewHandler::getProductGroupPageTemplateNameFor($widget->GroupView, $templateBaseSidebar);
        }
        return $groupViewTemplateName;
    }

    /**
     * Default form registration routine of a product slider widget
     *
     * @param SilvercartWidget_Controller $widget          Widget to initialize
     * @param DataObject                  $element         Element to add cart form for
     * @param int                         &$elementIdx     Element counter to use as ID and increment
     * @param string                      $addCartFormName The name of the form
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.02.2013
     */
    public static function registerAddCartFormForProductWidget(SilvercartWidget_Controller $widget, $element, &$elementIdx, $addCartFormName = 'ProductAddCartForm') {
        if ($element instanceof SilvercartProduct) {
            if (empty($widget->GroupView)) {
                $widget->GroupView = SilvercartGroupViewHandler::getDefaultGroupViewInherited();
            }
            $controller             = Controller::curr();
            $groupView              = $widget->GroupView;
            $productAddCartFormName = SilvercartGroupViewHandler::getCartFormNameFor($groupView);
            $formIdentifier         = $addCartFormName . $widget->ID . '_' . $element->ID;
            $productAddCartForm     = new $productAddCartFormName(
                $controller,
                array('productID' => $element->ID)
            );

            $controller->registerCustomHtmlForm(
                $formIdentifier,
                $productAddCartForm
            );
            
            $elementIdx++;
        }
    }
    
    /**
     * We set checkbox field values here to false if they are not in the post
     * data array.
     *
     * @param SilvercartWidget_Controller $widget Widget to initialize
     * @param array                       $data   The post data array
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public static function populateFromPostDataForProductSliderWidget(SilvercartWidget_Controller $widget, $data) {
        $widget->write();
        if (!array_key_exists('isContentView', $data)) {
            $widget->isContentView = 0;
        }
        if (!array_key_exists('GroupView', $data)) {
            $widget->GroupView = SilvercartGroupViewHandler::getDefaultGroupViewInherited();
        }
        if (!array_key_exists('Autoplay', $data)) {
            $widget->autoplay = 0;
        }
        if (!array_key_exists('buildArrows', $data)) {
            $widget->buildArrows = 0;
        }
        if (!array_key_exists('buildNavigation', $data)) {
            $widget->buildNavigation = 0;
        }
        if (!array_key_exists('buildStartStop', $data)) {
            $widget->buildStartStop = 0;
        }
        if (!array_key_exists('autoPlayDelayed', $data)) {
            $widget->autoPlayDelayed = 0;
        }
        if (!array_key_exists('autoPlayLocked', $data)) {
            $widget->autoPlayLocked = 0;
        }
        if (!array_key_exists('stopAtEnd', $data)) {
            $widget->stopAtEnd = 0;
        }
        if (!array_key_exists('useSlider', $data)) {
            $widget->useSlider = 0;
        }
    }

    /**
     * Field labels for display in tables.
     * 
     * @param Widget $widget Widget to initialize
     *
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 28.03.2012
     */
    public static function fieldLabelsForProductSliderWidget(Widget $widget) {
        return array(
            'FrontTitle'                    => _t('SilvercartProductSliderWidget.FRONTTITLE'),
            'FrontContent'                  => _t('SilvercartProductSliderWidget.FRONTCONTENT'),
            'numberOfProductsToShow'        => _t('SilvercartProductSliderWidget.NUMBEROFPRODUCTSTOSHOW'),
            'numberOfProductsToShowInfo'    => _t('SilvercartProductSliderWidget.NUMBEROFPRODUCTSTOSHOW_INFO'),
            'numberOfProductsToFetch'       => _t('SilvercartProductSliderWidget.NUMBEROFPRODUCTSTOFETCH'),
            'fetchMethod'                   => _t('SilvercartProductSliderWidget.FETCHMETHOD'),
            'useListView'                   => _t('SilvercartProductSliderWidget.USE_LISTVIEW'),
            'GroupView'                     => _t('SilvercartProductSliderWidget.GROUPVIEW'),
            'isContentView'                 => _t('SilvercartProductSliderWidget.IS_CONTENT_VIEW'),
            'isContentViewInfo'             => _t('SilvercartProductSliderWidget.IS_CONTENT_VIEW_INFO'),
            'Autoplay'                      => _t('SilvercartProductSliderWidget.AUTOPLAY'),
            'autoPlayDelayed'               => _t('SilvercartProductSliderWidget.AUTOPLAYDELAYED'),
            'autoPlayLocked'                => _t('SilvercartProductSliderWidget.AUTOPLAYLOCKED'),
            'buildArrows'                   => _t('SilvercartProductSliderWidget.BUILDARROWS'),
            'buildNavigation'               => _t('SilvercartProductSliderWidget.BUILDNAVIGATION'),
            'buildStartStop'                => _t('SilvercartProductSliderWidget.BUILDSTARTSTOP'),
            'slideDelay'                    => _t('SilvercartProductSliderWidget.SLIDEDELAY'),
            'stopAtEnd'                     => _t('SilvercartProductSliderWidget.STOPATEND'),
            'transitionEffect'              => _t('SilvercartProductSliderWidget.TRANSITIONEFFECT'),
            'useSlider'                     => _t('SilvercartProductSliderWidget.USE_SLIDER'),
            'useRoundabout'                 => _t('SilvercartProductSliderWidget.USE_ROUNDABOUT'),
            'AddImage'                      => _t('SilvercartProductSliderWidget.AddImage'),

            'ProductDataToggle'             => _t('SilvercartProductSliderWidget.ProductDataToggle'),
            'ProductRelationToggle'         => _t('SilvercartProductSliderWidget.ProductRelationToggle'),
            'RoundaboutTab'                 => _t('SilvercartProductSliderWidget.CMS_ROUNDABOUTTABNAME'),
            'SliderTab'                     => _t('SilvercartProductSliderWidget.CMS_SLIDERTABNAME'),
            'SlideshowTab'                  => _t('SilvercartProductSliderWidget.CMS_SLIDERTABNAME'),
            'BasicTab'                      => _t('SilvercartProductSliderWidget.CMS_BASICTABNAME'),
            'DisplayTab'                    => _t('SilvercartProductSliderWidget.CMS_DISPLAYTABNAME'),

            'transitionEffectFade'          => _t('SilvercartProductSliderWidget.TRANSITION_FADE'),
            'transitionEffectHSlide'        => _t('SilvercartProductSliderWidget.TRANSITION_HORIZONTALSLIDE'),
            'transitionEffectVSlide'        => _t('SilvercartProductSliderWidget.TRANSITION_VERTICALSLIDE'),

            'fetchMethodRandom'             => _t($widget->ClassName() . '.FETCHMETHOD_RANDOM',         _t('SilvercartProductSliderWidget.FETCHMETHOD_RANDOM')),
            'fetchMethodSortOrderAsc'       => _t($widget->ClassName() . '.FETCHMETHOD_SORTORDERASC',   _t('SilvercartProductSliderWidget.FETCHMETHOD_SORTORDERASC')),
            'fetchMethodSortOrderDesc'      => _t($widget->ClassName() . '.FETCHMETHOD_SORTORDERDESC',  _t('SilvercartProductSliderWidget.FETCHMETHOD_SORTORDERDESC')),
        );
    }
    
    /**
     * Loads the requirements for this object
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 11.06.2012
     */
    public static function loadRequirements() {
        Requirements::themedCSS('SilvercartAnythingSlider');
    }
    
    /**
     * Creates the cache key for this widget.
     * 
     * @param SilvercartWidget_Controller $widget Widget to get cache key for
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.11.2014
     */
    public static function ProductWidgetCacheKey($widget) {
        $key                    = '';
        if ($widget->Elements() instanceof SS_List &&
            $widget->Elements()->exists()) {
            $map = $widget->Elements()->map('ID', 'LastEditedForCache');
            if ($map instanceof SS_Map) {
                $productMap = $map->toArray();
            } else {
                $productMap = $map;
            }
            if (!is_array($productMap)) {
                $productMap = array();
            }
            if ($widget->Elements()->exists() &&
                (empty($productMap) ||
                (count($productMap) == 1 &&
                array_key_exists('', $productMap)))) {
                $productMap = array();
                foreach ($widget->Elements() as $page) {
                    $map = $page->Elements->map('ID', 'LastEditedForCache');
                    if ($map instanceof SS_Map) {
                        $productMapToAdd = $map->toArray();
                    } else {
                        $productMapToAdd = $map;
                    }
                    $productMap = array_merge( 
                            $productMap,
                            $productMapToAdd
                    );
                }
            }
            $productMapIDs          = implode('_', array_keys($productMap));
            sort($productMap);
            $productMapLastEdited   = array_pop($productMap);
            $groupIDs               = '';

            if (Member::currentUserID() > 0) {
                $groupIDs = implode('-', SilvercartCustomer::currentUser()->getGroupIDs());
            }
            $keyParts = array(
                i18n::get_locale(),
                $productMapIDs,
                $productMapLastEdited,
                $widget->LastEdited,
                $groupIDs
            );

            $key = implode('_', $keyParts);
        }
        
        return $key;
    }
    
}
