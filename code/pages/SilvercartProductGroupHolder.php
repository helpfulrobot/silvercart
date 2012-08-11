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
 * to display a group of products
 *
 * @package Silvercart
 * @subpackage Pages
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @since 23.10.2010
 */
class SilvercartProductGroupHolder extends Page {
    
    /**
     * Attributes.
     *
     * @var array
     */
    public static $db = array(
        'productGroupsPerPage'          => 'Int',
        'DefaultGroupHolderView'        => 'VarChar(255)',
        'UseOnlyDefaultGroupHolderView' => 'Enum("no,yes,inherit","inherit")',
    );

    /**
     * Allowed children in site tree
     *
     * @var array
     */
    public static $allowed_children = array(
        'SilvercartProductGroupPage',
        'RedirectorPage'
    );
    
    /**
     * Icon to use in SiteTree
     *
     * @var string
     */
    public static $icon = "silvercart/images/page_icons/product_group_holder";
    
    /**
     * Singular name for this object
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function singular_name() {
        return SilvercartTools::singular_name_for($this);
    }
    
    /**
     * Plural name for this object
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
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
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
            parent::fieldLabels($includerelations),
            array(
                'productGroupsPerPage'          => _t('SilvercartProductGroupPage.PRODUCTGROUPSPERPAGE'),
                'DefaultGroupHolderView'        => _t('SilvercartProductGroupPage.DEFAULTGROUPHOLDERVIEW'),
                'UseOnlyDefaultGroupHolderView' => _t('SilvercartProductGroupPage.USEONLYDEFAULTGROUPHOLDERVIEW'),
                'DefaultGroupView'              => _t('SilvercartProductGroupPage.DEFAULTGROUPVIEW_DEFAULT'),
                'Yes'                           => _t('Silvercart.YES'),
                'No'                            => _t('Silvercart.NO'),
            )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }
    
    /**
     * Return all fields of the backend.
     *
     * @return FieldSet Fields of the CMS
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        $useOnlydefaultGroupviewSource  = array(
            'inherit'   => $this->fieldLabel('DefaultGroupView'),
            'yes'       => $this->fieldLabel('Yes'),
            'no'        => $this->fieldLabel('No'),
        );
        
        $productGroupsPerPageField          = new TextField('productGroupsPerPage',         $this->fieldLabel('productGroupsPerPage'));
        $defaultGroupHolderViewField        = SilvercartGroupViewHandler::getGroupViewDropdownField('DefaultGroupHolderView', $this->fieldLabel('DefaultGroupHolderView'), $this->DefaultGroupHolderView, $this->fieldLabel('DefaultGroupView'));
        $useOnlyDefaultGroupHolderViewField = new DropdownField('UseOnlyDefaultGroupHolderView',  $this->fieldLabel('UseOnlyDefaultGroupHolderView'), $useOnlydefaultGroupviewSource, $this->UseOnlyDefaultGroupHolderView);
        $fieldGroup                         = new SilvercartFieldGroup('FieldGroup', '', $fields);
        $fieldGroup->push($productGroupsPerPageField);
        $fieldGroup->push($defaultGroupHolderViewField);
        $fieldGroup->push($useOnlyDefaultGroupHolderViewField);
        $fields->addFieldToTab('Root.Content.Main', $fieldGroup, 'IdentifierCode');

        $this->extend('extendCMSFields', $fields);
        return $fields;
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
        if (count($this->Children()) > 0) {
            return true;
        }
        return false;
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
}

/**
 * correlating controller
 *
 * @package Silvercart
 * @subpackage Pages
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @since 23.10.2010
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2010 pixeltricks GmbH
 */
class SilvercartProductGroupHolder_Controller extends Page_Controller {

    protected $groupProducts;
    
    /**
     * Contains the viewable children of this page for caching purposes.
     *
     * @var mixed null|ArrayList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 09.11.2011
     */
    protected $viewableChildren = null;

    /**
     * statements to be called on oject instantiation
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sascha Koehler <skoehler@pixeltricks.de>
     * @since 23.10.2010
     * @return void
     */
    public function init() {


        // Get Products for this group
        if (!isset($_GET['start']) ||
                !is_numeric($_GET['start']) ||
                (int) $_GET['start'] < 1) {
            $_GET['start'] = 0;
        }

        $SQL_start = (int) $_GET['start'];
        
        parent::init();
    }

    /**
     * to be called on a template
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @return DataList set of randomly choosen product objects
     * @since 23.10.2010
     */
    public function randomProducts() {
        //return $this->groupProducts;
    }

    /**
     * Builds an associative array of ProductGroups to use in GroupedDropDownFields.
     *
     * @param SiteTree $parent      Expects a SilvercartProductGroupHolder or a SilvercartProductGroupPage
     * @param boolean  $allChildren Indicate wether all children or only the visible ones should be included
     * @param boolean  $withParent  Indicate wether the parent should be included
     *
     * @return array
     */
    public static function getRecursiveProductGroupsForGroupedDropdownAsArray($parent = null, $allChildren = false, $withParent = false) {
        $productGroups = array();
        
        if (is_null($parent)) {
            $productGroups['']  = '';
            $parent             = self::PageByIdentifierCode('SilvercartProductGroupHolder');
        }
        
        if ($parent) {
            if ($withParent) {
                $productGroups[$parent->ID] = $parent->Title;
            }
            if ($allChildren) {
                $children = $parent->AllChildren();
            } else {
                $children = $parent->Children();
            }
            foreach ($children as $child) {
                $productGroups[$child->ID] = $child->Title;
                $subs                      = self::getRecursiveProductGroupsForGroupedDropdownAsArray($child);
                
                if (!empty ($subs)) {
                    $productGroups[_t('SilvercartProductGroupHolder.SUBGROUPS_OF','Subgroups of ') . $child->Title] = $subs;
                }
            }
        }
        
        return $productGroups;
    }
    
    /**
     * Aggregates an array with ID => Title of all product groups that have children.
     * The product group holder is included.
     * This is needed for the product group widget
     * 
     * @param Page $parent needed for recursion
     *
     * @return array associative array, might be multi dimensional
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 17.07.2012
     */
    public static function getAllProductGroupsWithChildrenAsArray($parent = null) {
        $productGroups = array();
        
        if (is_null($parent)) {
            $productGroups['']  = '';
            $parent = self::PageByIdentifierCode('SilvercartProductGroupHolder');
            $productGroups[$parent->ID] = $parent->Title;
        }
        $children = $parent->Children();
        if ($children) {
            foreach ($children as $child) {
                $grandChildren = $child->Children();
                if ($grandChildren->count() > 0) {
                    $productGroups[$child->ID] = $child->Title;
                    $grandChildrenArray = self::getAllProductGroupsWithChildrenAsArray($child);
                    if (!empty ($grandChildrenArray)) {
                    $productGroups[_t('SilvercartProductGroupHolder.SUBGROUPS_OF','Subgroups of ') . $child->Title] = $grandChildrenArray;
                    }
                }
            }
        }
        return $productGroups;
    }

    /**
     * All viewable product groups of this group.
     *
     * @param int $numberOfProductGroups Number of product groups to display
     * 
     * @return ArrayList
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

            $viewableChildrenSet = new ArrayList($viewableChildren);
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
}
