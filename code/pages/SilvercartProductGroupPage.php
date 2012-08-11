<?php
/**
 * Copyright 2010, 2011 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * SilverCart is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SilverCart is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SilverCart.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Silvercart
 * @subpackage Pages
 */

/**
 * Displays products with similar attributes
 *
 * @package Silvercart
 * @subpackage Pages
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @since 20.10.2010
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2010 pixeltricks GmbH
 */
class SilvercartProductGroupPage extends Page {

    /**
     * Set allowed childrens for this page.
     *
     * @var array
     */
    public static $allowed_children = array('SilvercartProductGroupPage');

    /**
     * ???.
     *
     * @var boolean
     */
    public static $can_be_root = false;
    
    /**
     * The icon for this page type in the backend sitetree.
     * 
     * @var string
     */
    public static $icon = "silvercart/images/page_icons/product_group";

    /**
     * Attributes.
     *
     * @var array
     */
    public static $db = array(
        'productsPerPage'               => 'Int',
        'productGroupsPerPage'          => 'Int',
        'useContentFromParent'          => 'Boolean(0)',
        'DefaultGroupView'              => 'VarChar(255)',
        'UseOnlyDefaultGroupView'       => 'Enum("no,yes,inherit","inherit")',
        'DefaultGroupHolderView'        => 'VarChar(255)',
        'UseOnlyDefaultGroupHolderView' => 'Enum("no,yes,inherit","inherit")',
        'DoNotShowProducts'             => 'Boolean(0)',
    );

    /**
     * Has-one relationships.
     *
     * @var array
     */
    public static $has_one = array(
        'GroupPicture'                      => 'Image',
        'SilvercartGoogleMerchantTaxonomy'  => 'SilvercartGoogleMerchantTaxonomy'
    );

    /**
     * Has-many relationships.
     *
     * @var array
     */
    public static $has_many = array(
        'SilvercartProducts' => 'SilvercartProduct'
    );

    /**
     * Belongs-many-many relationships.
     *
     * @var array
     */
    public static $belongs_many_many = array(
        'SilvercartMirrorProducts'      => 'SilvercartProduct',
        'SilvercartProductExporters'    => 'SilvercartProductExporter',
    );

    /**
     * Contains all manufacturers of the products contained in this product
     * group page.
     *
     * @var boolean
     */
    protected $manufacturers = null;
    
    /**
     * Contains the number of all active SilvercartProducts for this page for
     * caching purposes.
     *
     * @var int
     */
    protected $activeSilvercartProducts = null;
    
    /**
     * Indicator to check whether getCMSFields is called
     *
     * @var boolean
     */
    protected $getCMSFieldsIsCalled = false;

    /**
     * Constructor. Extension to overwrite the groupimage's "alt"-tag with the
     * name of the productgroup.
     *
     * @param array $record      Array of field values. Normally this contructor is only used by the internal systems that get objects from the database.
     * @param bool  $isSingleton This this to true if this is a singleton() object, a stub for calling methods. Singletons don't have their defaults set.
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.02.2011
     */
    public function  __construct($record = null, $isSingleton = false) {
        parent::__construct($record, $isSingleton);
        $this->drawCMSFields = true;

        if ($this->GroupPictureID > 0) {
            $this->GroupPicture()->Title = $this->Title;
        }
    }
    
    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.05.2012
     */
    public function singular_name() {
        SilvercartTools::singular_name_for($this);
    }
    
    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.05.2012
     */
    public function plural_name() {
        SilvercartTools::plural_name_for($this);
    }
    
    /**
     * Overwrites the function LinkingMode in SiteTree
     * Other than the default behavior current should be returned for the
     * product category defined via session. This is neccessary for products
     * that are mirrored into a category.
     * If the product category is not set in the session the method behaves like
     * the overwritten one.
     * 
     * @return string current, section or link; to be used in the template
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 29.6.2011
     */
    public function LinkingMode() {
        if (Session::get("SilvercartProductGroupPageID") && Controller::curr() instanceof SilvercartProductGroupPage_Controller) {
            if ($this->ID == Session::get("SilvercartProductGroupPageID")) {
                return 'current';
            }
        } elseif ($this->isCurrent()) {
            return "current";
        } elseif ($this->isSection()) {
            return 'section';
        } else {
            return 'link';
        }
    }

    /**
     * builds the ProductPages link according to its custom URL rewriting rule
     *
     * @param string $action is ignored
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 03.07.2012
     */
    public function Link($action = null) {
        $returnProductLink = false;
        
        if (Controller::curr()->hasMethod('isProductDetailView') &&
            Controller::curr()->isProductDetailView() &&
            Controller::curr()->data()->ID == $this->ID &&
            Controller::curr()->data() === $this) {
            $returnProductLink  = true;
            $URLSegment         = Controller::curr()->urlParams['ID'];
        } elseif (Controller::curr()->hasMethod('isProductDetailView') &&
                  Controller::curr()->isProductDetailView()) {
            $translations   = $this->getTranslations();
            if ($translations) {
                $translation    = $translations->find('ID', Controller::curr()->data()->ID);
                if ($translation) {
                    $product            = Controller::curr()->getDetailViewProduct();
                    if ($product) {
                        $returnProductLink  = true;
                        $productLanguage    = $product->getLanguageFor(Translatable::get_current_locale());
                        $URLSegment         = SilvercartTools::string2urlSegment($productLanguage->Title);
                    }
                }
            }
        }
        
        if ($returnProductLink) {
            $link = parent::Link($action) . Controller::curr()->urlParams['Action'] . '/' . $URLSegment;
        } else {
            $link = parent::Link($action);
        }
        return $link;
    }

    /**
     * returns the original page link. This is needed by the breadcrumbs. When
     * a product detail view is requested, the default method self::Link() will
     * return a modified link to the products detail view. This controller handles
     * both (product group views and product detail views), so a product detail
     * view won't have a related parent to show in breadcrumbs. The controller
     * itself will be the parent, so there must be two different links for one
     * controller.
     *
     * @return string
     * 
     * @see self::Link()
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.02.2011
     */
    public function OriginalLink() {
        return parent::Link(null);
    }
    
    /**
     * Returns the back link
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.05.2012
     */
    public function BackLink() {
        if (Controller::curr()->getRequest()->requestVar('_REDIRECT_BACK_URL')) {
            $url = Controller::curr()->getRequest()->requestVar('_REDIRECT_BACK_URL');
        } elseif (Controller::curr()->getRequest()->getHeader('Referer')) {
            $url = Controller::curr()->getRequest()->getHeader('Referer');
        } else {
            $url = $this->OriginalLink();
        }
        if (!$this->isInternalUrl($url) ||
            $url == $this->Link()) {
            $url = $this->OriginalLink();
        }
        return $url;
    }
    
    /**
     * Returns the back page
     *
     * @return SiteTree
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.05.2012
     */
    public function BackPage() {
        $url            = $this->BackLink();
        $relativeUrl    = Director::makeRelative($url);
        if (strpos($relativeUrl, '?') !== false) {
            $blankUrl   = substr($relativeUrl, 0, strpos($relativeUrl, '?'));
        } elseif (strpos($relativeUrl, '#') !== false) {
            $blankUrl   = substr($relativeUrl, 0, strpos($relativeUrl, '#'));
        } else {
            $blankUrl   = $relativeUrl;
        }
        $backPage = SiteTree::get_by_link($blankUrl);
        
        // If no backPage has been found we could come from a product detail
        // page. Try to get the product title then.
        if (!$backPage) {
            $urlElems = explode('/', $blankUrl);
            array_pop($urlElems);
            $productId = array_pop($urlElems);
            if (is_numeric($productId)) {
                $silvercartProduct = DataObject::get_by_id(
                    'SilvercartProduct',
                    Convert::raw2xml($productId)
                );

                if ($silvercartProduct) {
                    $backPage = new DataObject();
                    $backPage->MenuTitle = $silvercartProduct->Title;
                }
            } else {
                $backPage = new DataObject();
                $backPage->MenuTitle = _t('SilvercartPage.BACK_TO_DEFAULT');
            }
        }
        
        return $backPage;
    }
    
    /**
     * Returns whether the given url is an internal url
     * 
     * @param string $url URL to check
     *
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.05.2012
     */
    public function isInternalUrl($url) {
        $isInternalUrl  = false;
        if (Director::is_absolute_url($url) &&
            strpos($url, $_SERVER['SERVER_NAME'])) {
            $isInternalUrl  = true;
        }
        return $isInternalUrl;
    }

    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     *
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.10.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
            parent::fieldLabels($includerelations),
            array(
                'productsPerPage'               => _t('SilvercartProductGroupPage.PRODUCTSPERPAGE'),
                'productGroupsPerPage'          => _t('SilvercartProductGroupPage.PRODUCTGROUPSPERPAGE'),
                'useContentFromParent'          => _t('SilvercartProductGroupPage.USE_CONTENT_FROM_PARENT'),
                'DefaultGroupView'              => _t('SilvercartProductGroupPage.DEFAULTGROUPVIEW'),
                'UseOnlyDefaultGroupView'       => _t('SilvercartProductGroupPage.USEONLYDEFAULTGROUPVIEW'),
                'DefaultGroupHolderView'        => _t('SilvercartProductGroupPage.DEFAULTGROUPHOLDERVIEW'),
                'UseOnlyDefaultGroupHolderView' => _t('SilvercartProductGroupPage.USEONLYDEFAULTGROUPHOLDERVIEW'),
                'DoNotShowProducts'             => _t('SilvercartProductGroupPage.DONOTSHOWPRODUCTS'),
                'SilvercartProductExporters'    => _t('SilvercartProductExporter.SINGULARNAME'),
            )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }

    /**
     * Return all fields of the backend.
     *
     * @return FieldSet Fields of the CMS
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 24.03.2011
     */
    public function getCMSFields() {
        $this->getCMSFieldsIsCalled = true;
        $fields = parent::getCMSFields();
        
        $useOnlydefaultGroupviewSource  = array(
            'inherit'   => _t('SilvercartProductGroupPage.DEFAULTGROUPVIEW_DEFAULT'),
            'yes'       => _t('Silvercart.YES'),
            'no'        => _t('Silvercart.NO'),
        );
        
        $useContentField                    = new CheckboxField('useContentFromParent',     $this->fieldLabel('useContentFromParent'));
        $doNotShowProductsField             = new CheckboxField('DoNotShowProducts',        $this->fieldLabel('DoNotShowProducts'));
        $productsPerPageField               = new TextField('productsPerPage',              $this->fieldLabel('productsPerPage'));
        $defaultGroupViewField              = SilvercartGroupViewHandler::getGroupViewDropdownField('DefaultGroupView', $this->fieldLabel('DefaultGroupView'), $this->DefaultGroupView, _t('SilvercartProductGroupPage.DEFAULTGROUPVIEW_DEFAULT'));
        $useOnlyDefaultGroupViewField       = new DropdownField('UseOnlyDefaultGroupView',  $this->fieldLabel('UseOnlyDefaultGroupView'), $useOnlydefaultGroupviewSource, $this->UseOnlyDefaultGroupView);
        $productGroupsPerPageField          = new TextField('productGroupsPerPage',         $this->fieldLabel('productGroupsPerPage'));
        $defaultGroupHolderViewField        = SilvercartGroupViewHandler::getGroupViewDropdownField('DefaultGroupHolderView', $this->fieldLabel('DefaultGroupHolderView'), $this->DefaultGroupHolderView, _t('SilvercartProductGroupPage.DEFAULTGROUPVIEW_DEFAULT'));
        $useOnlyDefaultGroupHolderViewField = new DropdownField('UseOnlyDefaultGroupHolderView',  $this->fieldLabel('UseOnlyDefaultGroupHolderView'), $useOnlydefaultGroupviewSource, $this->UseOnlyDefaultGroupHolderView);
        $productsPerPageHintField           = new LiteralField('ProductsPerPageHint', _t('SilvercartProductGroupPage.PRODUCTSPERPAGEHINT'));
        $fieldGroup                         = new SilvercartFieldGroup('FieldGroup', '', $fields);
        $fieldGroup->push(          $useContentField);
        $fieldGroup->breakAndPush(  $doNotShowProductsField);
        $fieldGroup->breakAndPush(  $productsPerPageField);
        $fieldGroup->push(          $defaultGroupViewField);
        $fieldGroup->push(          $useOnlyDefaultGroupViewField);
        $fieldGroup->breakAndPush(  $productGroupsPerPageField);
        $fieldGroup->push(          $defaultGroupHolderViewField);
        $fieldGroup->push(          $useOnlyDefaultGroupHolderViewField);
        $fieldGroup->breakAndPush(  $productsPerPageHintField);
        $fields->addFieldToTab('Root.Content.Main', $fieldGroup, 'IdentifierCode');

        $mirroredProductIdList  = '';
        $mirroredProductIDs     = $this->getMirroredProductIDs();

        foreach ($mirroredProductIDs as $mirroredProductID) {
            $mirroredProductIdList .= sprintf(
                "'%s',",
                $mirroredProductID
            );
        }

        if (!empty($mirroredProductIdList)) {
            $mirroredProductIdList = substr($mirroredProductIdList, 0, -1);

            $filter = sprintf(
                "`SilvercartProductGroupID` = %d OR
                 `SilvercartProduct`.`ID` IN (%s)",
                $this->ID,
                $mirroredProductIdList
            );
        } else {
            $filter = sprintf(
                "`SilvercartProductGroupID` = %d",
                $this->ID
            );
        }

        if ($this->drawCMSFields()) {
            $productsTableField = new HasManyComplexTableField(
                $this,
                'SilvercartProducts',
                'SilvercartProduct',
                array(
                    'Title' => _t('SilvercartProduct.COLUMN_TITLE'),
                    'Weight' => _t('SilvercartProduct.WEIGHT', 'weight')
                ),
                'getCMSFields_forPopup',
                $filter
            );
            $tabPARAM = "Root.Content."._t('SilvercartProduct.TITLE', 'product');
            $fields->addFieldToTab($tabPARAM, $productsTableField);

            $tabPARAM3 = "Root.Content." . _t('SilvercartProductGroupPage.GROUP_PICTURE', 'group picture');
            $fields->addFieldToTab($tabPARAM3, new FileIFrameField('GroupPicture', _t('SilvercartProductGroupPage.GROUP_PICTURE', 'group picture')));
        }
        
        // Google taxonomy breadcrumb field
        $cachekey       = SilvercartGoogleMerchantTaxonomy::$cacheKey;
        $cache          = SS_Cache::factory($cachekey);
        $breadcrumbList = $cache->load($cachekey);

        if ($breadcrumbList) {
            $breadcrumbList = unserialize($breadcrumbList);
        } else {
            $breadcrumbList         = array();
            $googleMerchantTaxonomy = DataObject::get(
                'SilvercartGoogleMerchantTaxonomy'
            );
            
            if ($googleMerchantTaxonomy) {
                $breadcrumbList = DataObject::get(
                    'SilvercartGoogleMerchantTaxonomy'
                )->map('ID', 'BreadCrumb');
            }
            
            $cache->save(serialize($breadcrumbList));
        }
        $fields->addFieldToTab('Root.Content.Metadata', new DropdownField(
            'SilvercartGoogleMerchantTaxonomyID',
            _t('SilvercartGoogleMerchantTaxonomy.SINGULARNAME'),
            $breadcrumbList
        ));

        $this->extend('extendCMSFields', $fields);
        return $fields;
    }
    
    /**
     * Checks whether the given group view is allowed to render for this group
     *
     * @param string $groupView GroupView code
     * 
     * @return boolean 
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function isGroupViewAllowed($groupView) {
        $groupViewAllowed = true;
        if ($this->getUseOnlyDefaultGroupViewInherited() &&
            $groupView != $this->getDefaultGroupViewInherited()) {
            $groupViewAllowed = false;
        }
        return $groupViewAllowed;
    }

    /**
     * Returns the inherited DefaultGroupView
     *
     * @param SilvercartProductGroupPage $context Context
     * 
     * @return string
     */
    public function getDefaultGroupViewInherited($context = null) {
        if (is_null($context)) {
            $context = $this;
        }
        $defaultGroupView = $context->DefaultGroupView;
        if (empty($defaultGroupView) ||
            SilvercartGroupViewHandler::getGroupView($defaultGroupView) === false) {
            if ($context->Parent() instanceof SilvercartProductGroupPage) {
                $defaultGroupView = $this->getDefaultGroupViewInherited($context->Parent());
            } else {
                $defaultGroupView = SilvercartGroupViewHandler::getDefaultGroupView();
            }
        }
        return $defaultGroupView;
    }
    
    /**
     * Returns the inherited UseOnlyDefaultGroupView
     *
     * @param SilvercartProductGroupPage $context Context
     * 
     * @return string
     */
    public function getUseOnlyDefaultGroupViewInherited($context = null) {
        if (is_null($context)) {
            $context = $this;
        }
        $useOnlyDefaultGroupView = $context->UseOnlyDefaultGroupView;
        if ($useOnlyDefaultGroupView == 'inherit') {
            if ($context->Parent() instanceof SilvercartProductGroupPage) {
                $useOnlyDefaultGroupView = $this->getUseOnlyDefaultGroupViewInherited($context->Parent());
            } else {
                $useOnlyDefaultGroupView = false;
            }
        } elseif ($useOnlyDefaultGroupView == 'yes') {
            $useOnlyDefaultGroupView = true;
        } else {
            $useOnlyDefaultGroupView = false;
        }
        return $useOnlyDefaultGroupView;
    }
    
    /**
     * Checks whether the given group view is allowed to render for this group
     *
     * @param string $groupHolderView GroupHolderView code
     * 
     * @return boolean 
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function isGroupHolderViewAllowed($groupHolderView) {
        $groupHolderViewAllowed = true;
        if ($this->getUseOnlyDefaultGroupHolderViewInherited() &&
            $groupHolderView != $this->getDefaultGroupHolderViewInherited()) {
            $groupHolderViewAllowed = false;
        }
        return $groupHolderViewAllowed;
    }

    /**
     * Returns the inherited DefaultGroupHolderView
     *
     * @param SilvercartProductGroupPage $context Context
     * 
     * @return string
     */
    public function getDefaultGroupHolderViewInherited($context = null) {
        if (is_null($context)) {
            $context = $this;
        }
        $defaultGroupHolderView = $context->DefaultGroupHolderView;
        if (empty($defaultGroupHolderView) ||
            SilvercartGroupViewHandler::getGroupHolderView($defaultGroupHolderView) === false) {
            if ($context->Parent() instanceof SilvercartProductGroupPage) {
                $defaultGroupHolderView = $this->getDefaultGroupHolderViewInherited($context->Parent());
            } else {
                $defaultGroupHolderView = SilvercartGroupViewHandler::getDefaultGroupHolderView();
            }
        }
        return $defaultGroupHolderView;
    }
    
    /**
     * Returns the inherited UseOnlyDefaultGroupHolderView
     *
     * @param SilvercartProductGroupPage $context Context
     * 
     * @return string
     */
    public function getUseOnlyDefaultGroupHolderViewInherited($context = null) {
        if (is_null($context)) {
            $context = $this;
        }
        $useOnlyDefaultGroupHolderView = $context->UseOnlyDefaultGroupHolderView;
        if ($useOnlyDefaultGroupHolderView == 'inherit') {
            if ($context->Parent() instanceof SilvercartProductGroupPage) {
                $useOnlyDefaultGroupHolderView = $this->getUseOnlyDefaultGroupHolderViewInherited($context->Parent());
            } else {
                $useOnlyDefaultGroupHolderView = false;
            }
        } elseif ($useOnlyDefaultGroupHolderView == 'yes') {
            $useOnlyDefaultGroupHolderView = true;
        } else {
            $useOnlyDefaultGroupHolderView = false;
        }
        return $useOnlyDefaultGroupHolderView;
    }

    /**
     * Returns all SilvercartProductIDs that have this group set as mirror
     * group.
     *
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 24.03.2011
     */
    public function getMirroredProductIDs() {
        $mirroredProductIDs         = array();
        $translations               = $this->getTranslations();
        $translationProductGroupIDs = array(
            $this->ID,
        );

        if ($translations &&
            $translations->Count() > 0) {
            foreach ($translations as $translation) {
                $translationProductGroupIDs[] = $translation->ID;
            }
        }
        $translationProductGroupIDList  = implode(',', $translationProductGroupIDs);

        $sqlQuery = new SQLQuery();
        $sqlQuery->select = array(
            'SP_SPGMP.SilvercartProductID'
        );
        $sqlQuery->from = array(
            'SilvercartProduct_SilvercartProductGroupMirrorPages SP_SPGMP'
        );
        $sqlQuery->where = array(
            sprintf(
                "SP_SPGMP.SilvercartProductGroupPageID IN (%s)",
                $translationProductGroupIDList
            )
        );
        $result = $sqlQuery->execute();

        foreach ($result as $row) {
            $mirroredProductIDs[] = $row['SilvercartProductID'];
        }
        
        return $mirroredProductIDs;
    }

    /**
     * Indicates wether the CMS Fields should be drawn.
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 07.03.2011
     */
    public function drawCMSFields() {
        $drawCMSFields   = true;
        $updateCMSFields = $this->extend('updateDrawCMSFields', $drawCMSFields);

        if (!empty($updateCMSFields)) {
            $drawCMSFields = $updateCMSFields[0];
        }

        return $drawCMSFields;
    }

    /**
     * Checks if SilvercartProductGroup has children or products.
     *
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 01.02.2011
     */
    public function hasProductsOrChildren() {
        if ($this->ActiveSilvercartProducts()->Count > 0
         || count($this->Children()) > 0) {
            
            return true;
        }
        return false;
    }

    /**
     * Returns true, when the products count is equal $count
     *
     * @param int $count expected count of products
     *
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.02.2011
     */
    public function hasProductCount($count) {
        if ($this->ActiveSilvercartProducts()->Count == $count) {
            return true;
        }
        return false;
    }

    /**
     * Returns a flat array containing the ID of all child pages of the given page.
     *
     * @param int $pageId The root page ID
     *
     * @return array
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.12.2011
     */
    public static function getFlatChildPageIDsForPage($pageId) {
        $pageIDs = array($pageId);
        $pageObj = DataObject::get_by_id('SiteTree', $pageId);
        
        if ($pageObj) {
            foreach ($pageObj->Children() as $pageChild) {
                $pageIDs = array_merge($pageIDs, self::getFlatChildPageIDsForPage($pageChild->ID));
            }
        }
        
        return $pageIDs;
    }
    
    /**
     * Returns the active products for this page.
     *
     * @return DataObject
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @copyright 2012 pixeltricks GmbH
     * @since 26.04.2012
     */
    public function ActiveSilvercartProducts() {
        if (is_null($this->activeSilvercartProducts)) {
            $requiredAttributes = SilvercartProduct::getRequiredAttributes();
            $activeProducts     = array();
            $productGroupIDs    = self::getFlatChildPageIDsForPage($this->ID);
            $priceTypeFilter    = '';
            $translations       = $this->getTranslations();
            
            if ($translations &&
                $translations->Count() > 0) {
                foreach ($translations as $translation) {
                    $productGroupIDs = array_merge(
                            $productGroupIDs,
                            self::getFlatChildPageIDsForPage($translation->ID)
                    );
                }
            }
            
            if (!empty($requiredAttributes)) {
                foreach ($requiredAttributes as $requiredAttribute) {
                    if ($requiredAttribute == "Price") {
                        if (SilvercartConfig::Pricetype() == 'net') {
                            $priceTypeFilter = 'PriceNetAmount > 0';
                        } else {
                            $priceTypeFilter = 'PriceGrossAmount > 0';
                        }
                    }
                }
            }

            if (!empty($priceTypeFilter)) {
                $priceTypeFilter = ' AND '.$priceTypeFilter;
            }
            
            $records = DB::query(
                sprintf(
                    "SELECT
                        ID
                     FROM
                        SilvercartProduct
                     WHERE
                        isActive = 1
                        AND (SilvercartProductGroupID IN (%s)
                             OR ID IN (
                                SELECT
                                    SilvercartProductID
                                FROM
                                    SilvercartProduct_SilvercartProductGroupMirrorPages
                                WHERE
                                    SilvercartProductGroupPageID IN (%s)))
                        %s",
                    implode(',', $productGroupIDs),
                    implode(',', $productGroupIDs),
                    $priceTypeFilter
                )
            );
            
            foreach ($records as $record) {
                $activeProducts[] = $record['ID'];
            }
            
            $this->activeSilvercartProducts = $activeProducts;
        }
        
        $result = new DataObject();
        $result->ID = count($this->activeSilvercartProducts);
        $result->Count = count($this->activeSilvercartProducts);
        
        return $result;
    }

    /**
     * Returns all Manufacturers of the groups products.
     *
     * @return DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.03.2011
     */
    public function getManufacturers() {
        if (is_null($this->manufacturers)) {
            $registeredManufacturers = array();
            $manufacturers = array();

            foreach ($this->SilvercartProducts() as $product) {
                if ($product->SilvercartManufacturer()) {
                    if (in_array($product->SilvercartManufacturer()->Title, $registeredManufacturers) == false) {
                        $registeredManufacturers[] = $product->SilvercartManufacturer()->Title;
                        $manufacturers[] = $product->SilvercartManufacturer();
                    }
                }
            }
            $this->manufacturers = new DataList($manufacturers);
        }
        return $this->manufacturers;
    }

    /**
     * Returns whether the actual view is filtered by this manufacturer or not.
     *
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.03.2011
     */
    public function isActive() {
        return Controller::curr()->Link() == $this->Link();
    }
    
    /**
     * Returns a sorted list of children of this node.
     *
     * @param string $sortField The field used for sorting
     * @param string $sortDir   The sort direction ('ASC' or 'DESC')
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 31.05.2011
     * 
     * @return ArrayList child pages
     */
    public function OrderedChildren($sortField = 'Title', $sortDir = 'ASC') {
        $children = $this->Children();
        $children->sort($sortField, $sortDir);
        
        return $children;
    }
    
    /**
     * All products of this group forced (independant of DoNotShowProducts setting)
     * 
     * @param int    $numberOfProducts The number of products to return
     * @param string $sort             An SQL sort statement
     * @param bool   $disableLimit     Disables the product limitation
     * 
     * @return DataList|false all products of this group
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function getProductsForced($numberOfProducts = false, $sort = false, $disableLimit = false) {
        return $this->getProducts($numberOfProducts, $sort, $disableLimit, true);
    }
    
    /**
     * All products of this group
     * 
     * @param int    $numberOfProducts The number of products to return
     * @param string $sort             An SQL sort statement
     * @param bool   $disableLimit     Disables the product limitation
     * @param bool   $force            Forces to get the products
     * 
     * @return DataList|false all products of this group
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function getProducts($numberOfProducts = false, $sort = false, $disableLimit = false, $force = false) {
        if (Controller::curr() instanceof SilvercartProductGroupPage_Controller &&
            Controller::curr()->data()->ID === $this->ID) {
            
            $controller = Controller::curr();
        } else {
            $controller = new SilvercartProductGroupPage_Controller($this);
        }
        
        return $controller->getProducts($numberOfProducts, $sort, $disableLimit, $force);
    }
    
    /**
     * Returns the meta description. If not set, it will be generated by it's
     * related products.
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.06.2012
     */
    public function getMetaDescription() {
        $metaDescription = $this->getField('MetaDescription');
        if (!$this->getCMSFieldsIsCalled) {
            if (empty($metaDescription)) {
                $products = $this->getProducts();
                $metaDescription = SilvercartSeoTools::extractMetaDescriptionOutOfArray(
                        array_merge(
                            array(
                                utf8_decode($this->Title)
                            ),
                            $products->map()
                        )
                );
            }
            $this->extend('updateMetaDescription', $metaDescription);
        }
        return $metaDescription;
    }

    /**
     * Set LastEdited field to now for the SilvercartProductGroupHolder.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 03.07.2012
     */
    public function onBeforeDelete() {
        $productGroupHolderPage = $this->getSilvercartProductGroupHolderPage();

        if ($productGroupHolderPage) {
            $now = new DateTime();
            $productGroupHolderPage->LastEdited = $now->format('Y-m-d H:i:s');
            $productGroupHolderPage->write();
        }

        parent::onBeforeDelete();
    }

    /**
     * Returns the first SilvercartProductGroupHolder page.
     *
     * @param SiteTree $context An optional SiteTree object
     *
     * @return SilvercartProductGroupHolder
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 03.07.2012
     */
    public function getSilvercartProductGroupHolderPage($context = null) {
        if (is_null($context)) {
            $context = $this;
        }

        if ( $context->ParentID > 0 &&
            !$context->Parent() instanceof SilvercartProductGroupHolder) {

            $context = $this->getSilvercartProductGroupHolderPage($context->Parent());
        }

        return $context;
    }
}

/**
 * Controller Class.
 * This controller handles the actions for product group views and product detail
 * views.
 *
 * @package Silvercart
 * @subpackage Pages
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @since 18.10.2010
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2010 pixeltricks GmbH
 */
class SilvercartProductGroupPage_Controller extends Page_Controller {

    /**
     * Contains a list of all registered filter plugins.
     *
     * @var array
     */
    public static $registeredFilterPlugins = array();
    
    /**
     * Contains a DataList of products for this page or null. Used for
     * caching.
     *
     * @var mixed null|ArrayList
     */
    protected $groupProducts = array();

    /**
     * Contains the SilvercartProduct object that is used for the detail view
     * or null. Used for caching.
     *
     * @var mixed null|SilvercartProduct
     */
    protected $detailViewProduct = null;

    /**
     * Contains filters for the SQL query that retrieves the products for this
     * page.
     *
     * @var array
     */
    protected $listFilters = array();
    
    /**
     * Used for offset calculation of the SQL query that retrieves the
     * products for this page.
     *
     * @var int
     */
    protected $SQL_start = 0;
    
    /**
     * Contains the output of all WidgetSets of the parent page
     *
     * @var array
     */
    protected $widgetOutput = array();

    /**
     * Makes widgets of parent pages load when subpages don't have any attributed.
     *
     * @var boolean
     */
    public $forceLoadOfWidgets = true;
    
    /**
     * Contains the viewable children of this page for caching purposes.
     *
     * @var mixed null|ArrayList
     */
    protected $viewableChildren = null;
    
    /**
     * Product detail view parameters
     *
     * @var array
     */
    protected $productDetailViewParams = array();
    
    /**
     * Indicates wether a filter plugin can be registered for the current view.
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 29.08.2011
     */
    public function canRegisterFilterPlugin() {
        if ($this->isProductDetailView()) {
            return false;
        }
        
        return true;
    }
    
    /**
     * Returns the cache key for the product group page list view.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 15.10.2011
     */
    public function CacheKeySilvercartProductGroupPageControls() {
        return implode(
            '_',
            array(
                $this->ID,
                $this->SQL_start,
                $this->getProductsPerPageSetting()
            )
        );
    }
    
    /**
     * Registers an object as a filter plugin. Before getting the result set
     * the method 'filter' is called on the plugin. It has to return an array
     * with filters to deploy on the query.
     * 
     * @param string $plugin Name of the filter plugin
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 23.08.2011
     */
    public static function registerFilterPlugin($plugin) {
        $reflectionClass = new ReflectionClass($plugin);
        
        if ($reflectionClass->hasMethod('filter')) {
            self::$registeredFilterPlugins[] = new $plugin();
        }
    }
    
    /**
     * execute these statements on object call
     *
     * @param bool $skip When set to true, the init routine will be skipped
     * 
     * @return void
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.05.2012
     */
    public function init($skip = false) {
        parent::init();
        if (!$skip) {
            if (isset($_GET['start'])) {
                $this->SQL_start = (int)$_GET['start'];
            }

            // there must be two way to initialize this controller:
            if ($this->isProductDetailView()) {
                $this->registerWidgetAreas();
                // a product detail view is requested
                if (!$this->getDetailViewProduct()->isActive) {
                    Director::redirect($this->PageByIdentifierCodeLink());
                }
                $this->registerCustomHtmlForm(
                    'SilvercartProductAddCartFormDetail',
                    new SilvercartProductAddCartFormDetail(
                        $this,
                        array(
                            'productID'          => $this->getDetailViewProduct()->ID,
                            '_REDIRECT_BACK_URL' => $this->BackLink()
                        )
                    )
                );
            } else {
                // a product group view is requested
                $this->registerWidgetAreas();
                $products = $this->getProducts();
                Session::set("SilvercartProductGroupPageID", $this->ID);
                Session::save();
                // Initialise formobjects
                $productIdx = 0;
                if ($products) {
                    $productAddCartForm = $this->getCartFormName();
                    foreach ($products as $product) {
                        $backlink = $this->Link()."?start=".$this->SQL_start;
                        $productAddCartForm = new $productAddCartForm($this, array('productID' => $product->ID, 'backLink' => $backlink));
                        $this->registerCustomHtmlForm('ProductAddCartForm'.$productIdx, $productAddCartForm);
                        $product->productAddCartForm = $this->InsertCustomHtmlForm(
                            'ProductAddCartForm'.$productIdx,
                            array(
                                $product
                            )
                        );
                        $product->productAddCartFormObj = $productAddCartForm;
                        $productIdx++;
                    }
                }

                // Register selector forms, e.g. the "products per page" selector
                $selectorForm = new SilvercartProductGroupPageSelectorsForm($this);
                $selectorForm->setSecurityTokenDisabled();

                $this->registerCustomHtmlForm(
                    'SilvercartProductGroupPageSelectors',
                    $selectorForm
                );
            }
        }
    }
    
    /**
     * Registers the WidgetAreas and stores their output.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 28.08.2011
     */
    protected function registerWidgetAreas() {
        $parentPage = $this->getParent();

        if ($parentPage) {
            $parentPageController = ModelAsController::controller_for($parentPage);
            $parentPageController->init();
            
            if ($this->WidgetSetSidebar()->Count() == 0) {
                $identifier           = 'Sidebar';
                $this->saveWidgetOutput($identifier, $parentPageController->InsertWidgetArea($identifier));
            }
            
            if ($this->WidgetSetContent()->Count() == 0) {
                $identifier           = 'Content';
                $this->saveWidgetOutput($identifier, $parentPageController->InsertWidgetArea($identifier));
            }
        }
    }

    /**
     * Uses the children of SilvercartMyAccountHolder to render a subnavigation
     * with the SilvercartSubNavigation.ss template.
     * 
     * @param string $identifierCode param only added because it exists on parent::getSubNavigation
     *                               to avoid strict notice
     *
     * @return string
     */
    public function getSubNavigation($identifierCode = 'SilvercartProductGroupHolder') {
        $cachekey = 'SilvercartSubNavigation'.$this->ID;
        $cache    = SS_Cache::factory($cachekey);
        $result   = $cache->load($cachekey);

        if ($result) {
            $output = unserialize($result);
        } else {
            $menuElements = $this->getTopProductGroup($this)->Children();
            
            $extendedOutput = $this->extend('getSubNavigation', $menuElements);
        
            if (empty ($extendedOutput)) {
                $elements = array(
                    'SubElements' => $menuElements,
                );
                $output = $this->customise($elements)->renderWith(
                    array(
                        'SilvercartSubNavigation',
                    )
                );
            } else {
                $output = $extendedOutput[0];
            }
            
            $cache->save(serialize($output));
        }
        
        return $output;
    }

    /**
     * returns the top product group (first product group under SilvercartProductGroupHolder)
     *
     * @param SilvercartProductGroupPage $productGroup product group
     *
     * @return SilvercartProductGroupPage
     */
    public function getTopProductGroup($productGroup = false) {
        if (!$productGroup) {
            $productGroup = $this;
        }
        if ($productGroup->Parent()->ClassName == 'SilvercartProductGroupHolder' ||
            $productGroup->ParentID == 0) {
            return $productGroup;
        }
        return $this->getTopProductGroup($productGroup->Parent());
    }

    /**
     * Returns the pages original breadcrumbs
     *
     * @param int    $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param bool   $unlinked       true, if the breadcrumbs should be displayed without links
     * @param string $stopAtPageType name of pagetype to stop at
     * @param bool   $showHidden     true, if hidden pages should be displayed in breadcrumbs
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.07.2012
     */
    public function OriginalBreadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        return parent::Breadcrumbs($maxDepth, $unlinked, $stopAtPageType, $showHidden);
    }

    /**
     * manipulates the defaul logic of building the pages breadcrumbs if a
     * product detail view is requested.
     *
     * @param int    $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param bool   $unlinked       true, if the breadcrumbs should be displayed without links
     * @param string $stopAtPageType name of pagetype to stop at
     * @param bool   $showHidden     true, if hidden pages should be displayed in breadcrumbs
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.02.2011
     */
    public function Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        if ($this->isProductDetailView()) {
            $page    = $this;
            $parts   = array();
            $parts[] = $this->getDetailViewProduct()->Title;
            
            while (
                $page
                && (!$maxDepth ||
                     sizeof($parts) < $maxDepth)
                && (!$stopAtPageType ||
                     $page->ClassName != $stopAtPageType)
            ) {
                if ($showHidden ||
                    $page->ShowInMenus ||
                    ($page->ID == $this->ID)) {
                    
                    if ($page->ID == $this->ID) {
                        $link = $page->OriginalLink();
                    } else {
                        $link = $page->Link();
                    }
                    $parts[] = ("<a href=\"" . $link . "\">" . Convert::raw2xml($page->Title) . "</a>");
                }
                $page = $page->Parent;
            }
            return implode(Page::$breadcrumbs_delimiter, array_reverse($parts));
        }
        return parent::Breadcrumbs($maxDepth, $unlinked, $stopAtPageType, $showHidden);
    }
    
    /**
     * Returns the offset of the current page for pagination.
     * 
     * @return int
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.06.2011
     */
    public function CurrentOffset() {
        if (!isset($_GET['start']) ||
            !is_numeric($_GET['start']) ||
            (int)$_GET['start'] < 1) {


            if (isset($_GET['offset'])) {
                $productsPerPage = $this->getProductsPerPageSetting();
                
                // --------------------------------------------------------
                // Use offset for getting the current item rage
                // --------------------------------------------------------
                $offset = (int) $_GET['offset'];

                if ($offset > 0) {
                    $offset -= 1;
                }

                // Prevent too high values
                if ($offset > 999999) {
                    $offset = 0;
                }

                $SQL_start = $offset * $productsPerPage;
            } else {
                // --------------------------------------------------------
                // Use item number for getting the current item range
                // --------------------------------------------------------
                $SQL_start = 0;
            }
        } else {
            $SQL_start = (int) $_GET['start'];
        }
        
        return $SQL_start;
    }
    
    /**
     * All products of this group forced (independant of DoNotShowProducts setting)
     * 
     * @param int    $numberOfProducts The number of products to return
     * @param string $sort             An SQL sort statement
     * @param bool   $disableLimit     Disables the product limitation
     * 
     * @return DataList all products of this group or FALSE
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function getProductsForced($numberOfProducts = false, $sort = false, $disableLimit = false) {
        return $this->getProducts($numberOfProducts, $sort, $disableLimit, true);
    }

    /**
     * All products of this group
     * 
     * @param int    $numberOfProducts The number of products to return
     * @param string $sort             An SQL sort statement
     * @param bool   $disableLimit     Disables the product limitation
     * @param bool   $force            Forces to get the products
     * 
     * @return DataList|false all products of this group
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function getProducts($numberOfProducts = false, $sort = false, $disableLimit = false, $force = false) {
        $hashKey = md5($numberOfProducts . '_' . $sort . '_' . $disableLimit . Translatable::get_current_locale());
        if ($this->data()->DoNotShowProducts &&
            !$force) {
            $this->groupProducts[$hashKey] = new ArrayList();
        } elseif (!array_key_exists($hashKey, $this->groupProducts)) {
            $SQL_start       = $this->getSqlOffset($numberOfProducts);
            $productsPerPage = $this->getProductsPerPageSetting();
            $pluginProducts  = SilvercartPlugin::call($this, 'overwriteGetProducts', array($numberOfProducts, $productsPerPage, $SQL_start, $sort), true, new ArrayList());

            if (!empty($pluginProducts)) {
                $this->groupProducts[$hashKey] = $pluginProducts;
            } else {
                $this->listFilters = array();
                $filter            = '';
                
                // ----------------------------------------------------------------
                // Get products that have this group set as mirror group
                // ----------------------------------------------------------------

                if ($numberOfProducts !== false) {
                    $productsPerPage = (int) $numberOfProducts;
                }
                
                $translations               = $this->getTranslations();
                $translationProductGroupIDs = array(
                    $this->ID,
                );

                if ($translations &&
                    $translations->Count() > 0) {
                    foreach ($translations as $translation) {
                        $translationProductGroupIDs[] = $translation->ID;
                    }
                }
                $translationProductGroupIDList  = implode(',', $translationProductGroupIDs);

                $mirroredProductIdList  = '';
                $mirroredProductIDs     = $this->getMirroredProductIDs();

                foreach ($mirroredProductIDs as $mirroredProductID) {
                    $mirroredProductIdList .= sprintf(
                        "'%s',",
                        $mirroredProductID
                    );
                }

                if (!empty($mirroredProductIdList)) {
                    $mirroredProductIdList = substr($mirroredProductIdList, 0, -1);
                }

                // ----------------------------------------------------------------
                // Get products that have this group set as main group
                // ----------------------------------------------------------------
                if ($this->isFilteredByManufacturer()) {
                    $manufacturer = SilvercartManufacturer::getByUrlSegment($this->urlParams['ID']);
                    if ($manufacturer) {
                        $this->addListFilter('SilvercartManufacturerID', $manufacturer->ID);
                    }
                }

                if (empty($mirroredProductIdList)) {
                    $this->listFilters['original'] = sprintf(
                        "`SilvercartProductGroupID` IN (%s)",
                        $translationProductGroupIDList
                    );
                } else {
                    $this->listFilters['original'] = sprintf(
                        "(`SilvercartProductGroupID` IN (%s) OR
                        `SilvercartProduct`.`ID` IN (%s))",
                        $translationProductGroupIDList,
                        $mirroredProductIdList
                    );
                }
                
                if (count(self::$registeredFilterPlugins) > 0) {
                    foreach (self::$registeredFilterPlugins as $registeredPlugin) {
                        $pluginFilters = $registeredPlugin->filter();
                        
                        if (is_array($pluginFilters)) {
                            $this->listFilters = array_merge(
                                $this->listFilters,
                                $pluginFilters
                            );
                        }
                    }
                }

                foreach ($this->listFilters as $listFilterIdentifier => $listFilter) {
                    $filter .= ' ' . $listFilter;
                }

               
                if (!$sort) {
                    $sort = SilvercartProduct::defaultSort();
                    if (empty($sort)) {
                        $sort = 'CASE WHEN SPGMSO.SortOrder THEN CONCAT(SPGMSO.SortOrder, SilvercartProduct.SortOrder) ELSE SilvercartProduct.SortOrder END ASC';
                    }
                    $this->extend('updateGetProductsSort', $sort);
                }

                $join = sprintf(
                    "LEFT JOIN SilvercartProductGroupMirrorSortOrder SPGMSO ON SPGMSO.SilvercartProductGroupPageID = %d AND SPGMSO.SilvercartProductID = SilvercartProduct.ID",
                    $this->ID
                );
                
                if ($disableLimit) {
                    $limit = null;
                } else {
                    $limit = sprintf("%d,%d", $SQL_start, $productsPerPage);
                }
                
                $groupProducts = SilvercartProduct::get($filter, $sort, $join, $limit);
                $this->extend('onAfterGetProducts', $groupProducts);
                $this->groupProducts[$hashKey] = $groupProducts;
            }

            // Inject additional methods into the ArrayList
            if ($this->groupProducts[$hashKey]) {
                $this->groupProducts[$hashKey]->HasMorePagesThan = $this->HasMorePagesThan;
            }
        }
        
        return $this->groupProducts[$hashKey];
    }
    
    /**
     * Returns the products (all or by the given hash key)
     *
     * @param string $hashKey Hash key to get products for
     * 
     * @return array 
     */
    public function getGroupProducts($hashKey = null) {
        if (is_null($hashKey)) {
            $groupProducts = $this->groupProducts;
        } elseif (array_key_exists($hashKey, $this->groupProducts)) {
            $groupProducts = $this->groupProducts[$hashKey];
        } else {
            $groupProducts = array();
        }
        return $groupProducts;
    }
    
    /**
     * Sets the products (all or by the given hash key)
     *
     * @param array  $groupProducts Products to set
     * @param string $hashKey       Hash key to set products for
     * 
     * @return void 
     */
    public function setGroupProducts($groupProducts, $hashKey = null) {
        if (is_null($hashKey)) {
            $this->groupProducts = $groupProducts;
        } else {
            $this->groupProducts[$hashKey] = $groupProducts;
        }
    }

    /**
     * All products of this group
     * 
     * @param int $numberOfProducts The number of products to return
     * 
     * @return DataList all products of this group or FALSE
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getRandomProducts($numberOfProducts) {
        $listFilters = array();
        $filter      = '';

        // ----------------------------------------------------------------
        // Get products that have this group set as mirror group
        // ----------------------------------------------------------------
        
        $mirroredProductIdList  = '';
        $mirroredProductIDs     = $this->getMirroredProductIDs();

        foreach ($mirroredProductIDs as $mirroredProductID) {
            $mirroredProductIdList .= sprintf(
                "'%s',",
                $mirroredProductID
            );
        }

        if (!empty($mirroredProductIdList)) {
            $mirroredProductIdList = substr($mirroredProductIdList, 0, -1);
        }

        // ----------------------------------------------------------------
        // Get products that have this group set as main group
        // ----------------------------------------------------------------
        if ($this->isFilteredByManufacturer()) {
            $manufacturer = SilvercartManufacturer::getByUrlSegment($this->urlParams['ID']);
            if ($manufacturer) {
                $this->addListFilter('SilvercartManufacturerID', $manufacturer->ID);
            }
        }

        if (empty($mirroredProductIdList)) {
            $listFilters['original'] = sprintf(
                "`SilvercartProductGroupID` = '%s'",
                $this->ID
            );
        } else {
            $listFilters['original'] = sprintf(
                "(`SilvercartProductGroupID` = '%s' OR
                  `SilvercartProduct`.`ID` IN (%s))",
                $this->ID,
                $mirroredProductIdList
            );
        }

        foreach ($listFilters as $listFilterIdentifier => $listFilter) {
            $filter .= ' ' . $listFilter;
        }

        $sort = 'RAND()';
        $join = sprintf(
            "LEFT JOIN SilvercartProductGroupMirrorSortOrder SPGMSO ON SPGMSO.SilvercartProductGroupPageID = %d AND SPGMSO.SilvercartProductID = SilvercartProduct.ID",
            $this->ID
        );

        $products = SilvercartProduct::get($filter, $sort, $join, $numberOfProducts);
        
        return $products;
    }
    
    /**
     * Returns the number of products per page according to where it is set.
     * Highest priority has the customer's configuration setting if available.
     * Next comes the shop owners setting for this page; if that's not
     * configured we use the global setting from SilvercartConfig.
     *
     * @return int
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 23.08.2011
     */
    public function getProductsPerPageSetting() {
        $productsPerPage = 0;
        $member          = Member::currentUser();
        
        if ($member &&
            $member->getSilvercartCustomerConfig() &&
            $member->getSilvercartCustomerConfig()->productsPerPage !== null &&
            array_key_exists($member->getSilvercartCustomerConfig()->productsPerPage, SilvercartConfig::$productsPerPageOptions)) {

            $productsPerPage = $member->getSilvercartCustomerConfig()->productsPerPage;
        } else if ($this->productsPerPage) {
            $productsPerPage = $this->productsPerPage;
        } else {
            $productsPerPage = SilvercartConfig::ProductsPerPage();
        }

        if ($productsPerPage == 0) {
            $productsPerPage = SilvercartConfig::getProductsPerPageUnlimitedNumber();
        }
        
        return $productsPerPage;
    }
    
    /**
     * Return the start value for the limit part of the sql query that
     * retrieves the product list for the current product group page.
     * 
     * @param int|bool $numberOfProducts The number of products to return
     *
     * @return int
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 12.06.2011
     */
    public function getSqlOffset($numberOfProducts = false) {
        $productsPerPage = $this->getProductsPerPageSetting();

        if ($numberOfProducts !== false) {
            $productsPerPage = (int) $numberOfProducts;
        }
        
        if ($productsPerPage === SilvercartConfig::getProductsPerPageUnlimitedNumber()) {
            $SQL_start = 0;
        } else {
            if (!isset($_GET['start']) ||
                !is_numeric($_GET['start']) ||
                (int)$_GET['start'] < 1) {

                if (isset($_GET['offset'])) {
                    // --------------------------------------------------------
                    // Use offset for getting the current item rage
                    // --------------------------------------------------------
                    $offset = (int) $_GET['offset'];

                    if ($offset > 0) {
                        $offset -= 1;
                    }

                    // Prevent too high values
                    if ($offset > 999999) {
                        $offset = 0;
                    }

                    $SQL_start = $offset * $productsPerPage;
                } else {
                    // --------------------------------------------------------
                    // Use item number for getting the current item range
                    // --------------------------------------------------------
                    $SQL_start = 0;
                }
            } else {
                $SQL_start = (int) $_GET['start'];
            }
        }
        
        return $SQL_start;
    }
    
    /**
     * All viewable product groups of this group.
     *
     * @param int $numberOfProductGroups Number of product groups to display
     * 
     * @return DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.07.2011
     */
    public function getViewableChildren($numberOfProductGroups = false) {
        if ($this->viewableChildren === null) {
            $viewableChildren = array();
            
            foreach ($this->Children() as $child) {
                if ($child->hasProductsOrChildren()) {
                    $viewableChildren[] = $child;
                }
            }
            
            if ($numberOfProductGroups == false) {
                if ($this->productGroupsPerPage) {
                    $pageLength = $this->productGroupsPerPage;
                } else {
                    $pageLength = SilvercartConfig::ProductGroupsPerPage();
                }
            } else {
                $pageLength = $numberOfProductGroups;
            }

            $pageStart = $this->getSqlOffsetForProductGroups($numberOfProductGroups);

            $viewableChildrenSet = new DataList($viewableChildren);
            $viewableChildrenPage = $viewableChildrenSet->getRange($pageStart, $pageLength);
            $viewableChildrenPage->setPaginationGetVar('groupStart');
            $viewableChildrenPage->setPageLimits($pageStart, $pageLength, $viewableChildrenSet->Count());
        
            $this->viewableChildren = $viewableChildrenPage;
        }
        
        return $this->viewableChildren;
    }
    
    /**
     * Indicates wether there are more viewable product groups than the given
     * number.
     *
     * @param int $nrOfViewableChildren The number to check against
     * 
     * @return boolean
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 09.11.2011
     */
    public function HasMoreViewableChildrenThan($nrOfViewableChildren) {
        if ($this->getViewableChildren()->TotalItems() > $nrOfViewableChildren) {
            return true;
        }
        
        return false;
    }
    
    /**
     * Return the start value for the limit part of the sql query that
     * retrieves the product group list for the current product group page.
     * 
     * @param int|bool $numberOfProductGroups The number of product groups to return
     *
     * @return int
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.07.2011
     */
    public function getSqlOffsetForProductGroups($numberOfProductGroups = false) {
        if ($this->productGroupsPerPage) {
            $productGroupsPerPage = $this->productGroupsPerPage;
        } else {
            $productGroupsPerPage = SilvercartConfig::ProductsPerPage();
        }

        if ($numberOfProductGroups !== false) {
            $productGroupsPerPage = (int) $numberOfProductGroups;
        }
            
        if (!isset($_GET['groupStart']) ||
            !is_numeric($_GET['groupStart']) ||
            (int)$_GET['groupStart'] < 1) {

            if (isset($_GET['groupOffset'])) {
                // --------------------------------------------------------
                // Use offset for getting the current item rage
                // --------------------------------------------------------
                $offset = (int) $_GET['groupOffset'];

                if ($offset > 0) {
                    $offset -= 1;
                }

                // Prevent too high values
                if ($offset > 999999) {
                    $offset = 0;
                }

                $SQL_start = $offset * $productGroupsPerPage;
            } else {
                // --------------------------------------------------------
                // Use item number for getting the current item range
                // --------------------------------------------------------
                $SQL_start = 0;
            }
        } else {
            $SQL_start = (int) $_GET['groupStart'];
        }
        
        return $SQL_start;
    }

    /**
     * Indicates wether the resultset of the product query returns more items
     * than the number given (defaults to 10).
     *
     * @param int $maxResults The number of results to check
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 20.04.2011
     */
    public function HasMorePagesThan($maxResults = 10) {
        $products       = $this->getProducts();
        $items          = 0;
        $hasMoreResults = false;

        if ($products) {
            $items = $products->Pages()->TotalItems();
        }

        if ($items > $maxResults) {
            $hasMoreResults = true;
        }

        return $hasMoreResults;
    }
    
    /**
     * Indicates wether the resultset of the product query returns more
     * products than the number given (defaults to 10).
     * 
     * @param int $maxResults The maximum count of results
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 23.08.2011
     */
    public function HasMoreProductsThan($maxResults = 10) {
        $products = $this->getProducts();
        if ($products &&
            $products->TotalItems() > $maxResults) {
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Indicates wether the resultset of the product query returns less
     * products than the number given (defaults to 10).
     * 
     * @param int $maxResults The maximum count of results
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 23.08.2011
     */
    public function HasLessProductsThan($maxResults = 10) {
        $products = $this->getProducts();
        
        if ($products &&
            $products->TotalItems() < $maxResults) {
            return true;
        }
        
        return false;
    }

    /**
     * Returns $Content of the page. If it's empty and
     * the option is set to use the content of a parent page we try to find
     * the first parent page with content and deliver that.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 18.08.2011
     */
    public function getPageContent() {
        if (!empty($this->Content) ||
            !$this->useContentFromParent) {
            return $this->Content;
        }
        
        $page       = $this;
        $content    = '';
        
        while ($page->ParentID > 0) {
            if (!empty($page->Content)) {
                $content = $page->Content;
                break;
            }
            
            $page = DataObject::get_by_id('SiteTree', $page->ParentID);
        }
        
        return $content;
    }
    
    /**
     * Getter for an products image.
     *
     * @return Image defined via a has_one relation in SilvercartProduct
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getProductImage() {
        return SilvercartProduct::image();
    }

    /**
     * handles the requested action.
     * If a product detail view is requested, the detail view template will be
     * rendered an displayed.
     *
     * @param SS_HTTPRequest $request request data
     *
     * @return mixed
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.02.2011
     */
    public function handleAction($request) {
        if ($this->isProductDetailView()) {
            
            $this->urlParams['Action'] = (int) $this->urlParams['Action'];

            if (!empty($this->urlParams['OtherID'])) {
                $secondaryAction = $this->urlParams['OtherID'];
                if ($this->hasMethod($secondaryAction) &&
                    $this->hasAction($secondaryAction)) {
                    $result = $this->{$secondaryAction}($request);
                    if (is_array($result)) {
                        return $this->getViewer($this->action)->process($this->customise($result));
                    } else {
                        return $result;
                    }
                }
            }

            $view = $this->ProductDetailView(
                $this->urlParams['ID']
            );
            
            if ($view !== false) {
                return $view;
            }
        } elseif ($this->isFilteredByManufacturer()) {
            $url = str_replace($this->urlParams['Action'] . '/' . $this->urlParams['ID'], '', $_REQUEST['url']);
            $this->urlParams['Action'] = '';
            $this->urlParams['ID'] = '';
            $customRequest = new SS_HTTPRequest('GET', $url, array(), array(), null);
            return parent::handleAction($customRequest);
            exit();
        }
        return parent::handleAction($request);
    }

    /**
     * Return an SSViewer object to process the data
     * Manipulates the SSViewer in case of a product detail view.
     * 
     * @param string $action Action
     * 
     * @return SSViewer The viewer identified being the default handler for this Controller/Action combination
     */
    public function getViewer($action) {
        $viewer = parent::getViewer($action);
        if ($this->isProductDetailView()) {
            $this->ProductDetailRequirements();
            $templates = $viewer->templates();
            $viewer    = new SSViewer(
                    array(
                        'SilvercartProductPage',
                        basename($templates['main'], '.ss')
                    )
            );
        }
        return $viewer;
    }
    
    /**
     * Merge some arbitrary data in with this object. This method returns a {@link ViewableData_Customised} instance
     * with references to both this and the new custom data.
     *
     * Note that any fields you specify will take precedence over the fields on this object.
     * 
     * Adds custom product detail data when a product detail view is requested.
     * 
     * @param array $data Customised data
     * 
     * @return ViewableData_Customised
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.07.2012
     */
    public function customise($data) {
        if ($this->isProductDetailView()) {
            $data = array_merge(
                    $data,
                    $this->ProductDetailViewParams()
            );
        }
        $customisedData = parent::customise($data);
        return $customisedData;
    }

    /**
     * renders a product detail view template (if requested)
     *
     * @return string the redered template
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.07.2012
     */
    protected function ProductDetailView() {
        if ($this->isProductDetailView()) {
            $this->ProductDetailRequirements();
            return $this->customise(array())->renderWith(array('SilvercartProductPage','Page'));
        }
        return false;
    }

    /**
     * renders a product detail view template (if requested)
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.07.2012
     */
    protected function ProductDetailViewParams() {
        if ($this->isProductDetailView() &&
            empty($this->productDetailViewParams)) {
            $product                        = $this->getDetailViewProduct();
            $product->productAddCartForm    = $this->InsertCustomHtmlForm('SilvercartProductAddCartFormDetail');
            $this->productDetailViewParams  = array(
                'getProduct'    => $product,
                'MetaTitle'     => $this->DetailViewProductMetaTitle(),
                'MetaTags'      => $this->DetailViewProductMetaTags(false),
            );
        }
        return $this->productDetailViewParams;
    }

    /**
     * renders a product detail view template (if requested)
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 27.07.2012
     */
    protected function ProductDetailRequirements() {
        Requirements::customScript("
            $(document).ready(function() {
                $('a.silvercart-product-detail-image').fancybox();
            });
        ", 'SilvercartProductDetailRequirements');
    }

    /**
     * checks whether the requested view is an product detail view or a product
     * group view.
     *
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.02.2011
     */
    public function isProductDetailView() {
        
        if (empty($this->urlParams['Action'])) {
            return false;
        }
        if ($this->hasMethod($this->urlParams['Action'])) {
            return false;
        }
        if ($this->getDetailViewProduct() instanceof SilvercartProduct) {
            return true;
        }
        return false;
    }

    /**
     * returns the chosen product when requesting a product detail view.
     *
     * @return SilvercartProduct
     */
    public function getDetailViewProduct() {
        if (is_numeric($this->urlParams['Action']) == false) {
            return null;
        }
        if (is_null($this->detailViewProduct)) {
            $this->detailViewProduct = DataObject::get_by_id('SilvercartProduct', Convert::raw2sql($this->urlParams['Action']));
        }
        return $this->detailViewProduct;
    }
    
    /**
     * Returns the SQL filter statement for the current query.
     * 
     * @param string $excludeFilter The name of the filter to exclude
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 28.08.2011
     */
    public function getListFilters($excludeFilter = false) {
        $filter = '';
        
        foreach ($this->listFilters as $listFilterIdenfitier => $listFilter) {
            if ($listFilterIdenfitier != $excludeFilter) {
                $filter .= ' ' . $listFilter;
            }
        }
        
        return $filter;
    }

    /**
     * Because of a url rule defined for this page type in the _config.php, the function MetaTags does not work anymore.
     * This function overloads it and parses the meta data attributes of SilvercartProduct
     *
     * @param boolean $includeTitle should the title tag be parsed?
     *
     * @return string with all meta tags
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.07.2012
     */
    protected function DetailViewProductMetaTags($includeTitle = false) {
        $canonicalTag = '';
        if ($this->isProductDetailView()) {
            $product = $this->getDetailViewProduct();
            $this->MetaKeywords     = $product->MetaKeywords;
            $this->MetaDescription  = $product->MetaDescription;
            if ($product->IsMirroredView()) {
                $canonicalTag = sprintf(
                        '<link rel="canonical" href="%s"/>' . "\n",
                        $product->CanonicalLink()
                );
            }
        }
        $tags = parent::MetaTags($includeTitle);
        $tags .= $canonicalTag;
        return $tags;
    }

    /**
     * for SEO reasons this pages attribute MetaTitle gets overwritten with the products MetaTitle
     * Remember: search engines evaluate 64 characters of the MetaTitle only
     *
     * @return string|false the products MetaTitle
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 13.11.10
     */
    protected function DetailViewProductMetaTitle() {
        $product = $this->getDetailViewProduct();
        if ($product && $product->MetaTitle) {
            if ($product->SilvercartManufacturer()->ID > 0) {
                return $product->MetaTitle ."/". $product->SilvercartManufacturer()->Title;
            }
            return $product->MetaTitle;
        } else {
            return false;
        }
    }

    /**
     * Checks whether the product list should be filtered by manufacturer.
     *
     * @return bool
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.03.2011
     */
    public function isFilteredByManufacturer() {
        if ($this->urlParams['Action'] == _t('SilvercartProductGroupPage.MANUFACTURER_LINK','manufacturer') && !empty ($this->urlParams['ID'])) {
            return true;
        }
        return false;
    }

    /**
     * Adds a filter to filter the groups product list.
     *
     * @param string $property   The property to filter
     * @param string $value      The value of the property
     * @param string $comparison The comparison operator (default: '=')
     * @param string $operator   The logical operator (default: 'AND')
     *
     * @return void
     *
     * @example $productGroup->addListFilter('SilvercartManufacturerID','5');
     *          Will add the following filter: "AND `SilvercartManufacturerID` = '5'"
     * @example $productGroup->addListFilter('SilvercartManufacturerID','(5,6,7)','IN','OR');
     *          Will add the following filter: "OR `SilvercartManufacturerID` IN (5,6,7)"
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.03.2011
     */
    public function addListFilter($property, $value, $comparison = '=', $operator = 'AND') {
        if ($comparison == 'IN') {
            $this->listFilters[] = $operator . " `" . $property . "` " . $comparison . " (" . $value . ")";
        } else {
            $this->listFilters[] = $operator . " `" . $property . "` " . $comparison . " '" . $value . "'";
        }
    }
    
    /**
     * Returns whether the current view is the first page of the product list or not
     *
     * @return boolean 
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 12.06.2012
     */
    public function isFirstPage() {
        $isFirstPage = true;
        if ($this->getSqlOffset() > 0) {
            $isFirstPage = false;
        }
        return $isFirstPage;
    }
    
    /**
     * Returns injected products
     *
     * @return ArrayList 
     */
    public function getInjectedProducts() {
        $injectedProducts = new ArrayList();
        if ($this->WidgetSetContent()->Count() > 0) {
            foreach ($this->WidgetSetContent() as $widgetSet) {
                if ($widgetSet->WidgetArea()->Widgets()->Count() > 0) {
                    foreach ($widgetSet->WidgetArea()->Widgets() as $widget) {
                        $controllerClass = $widget->class . '_Controller';
                        if (method_exists($controllerClass, 'getProducts')) {
                            $controller = new $controllerClass($widget);
                            $products   = $controller->getProducts();
                            if ($products instanceof SS_List) {
                                $injectedProducts->merge($products);
                            }
                        }
                    }
                }
            }
        }
        return $injectedProducts;
    }

}
