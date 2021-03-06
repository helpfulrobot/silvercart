<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Pages
 */

/**
 * holder for customers private area
 * 
 * @package Silvercart
 * @subpackage Pages
 * @author Roland Lehmann <rlehmann@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 29.04.2013
 * @copyright 2013 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartMyAccountHolder extends Page {
    
    /**
     * Icon to display in CMS site tree
     *
     * @var string
     */
    public static $icon = "silvercart/img/page_icons/my_account_holder";
    
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
     * manipulates the Breadcrumbs
     *
     * @param int  $maxDepth       maximum levels
     * @param bool $unlinked       link breadcrumbs elements
     * @param bool $stopAtPageType name of PageType to stop at
     * @param bool $showHidden     show pages that will not show in menus
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 22.02.2011
     */
    public function  Breadcrumbs($maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        return parent::Breadcrumbs($maxDepth, $unlinked, 'SilvercartFrontPage', true);
    }

}

/**
 * correlating controller
 *
 * @package Silvercart
 * @subpackage Pages
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @license see license file in modules root directory
 * @copyright 2013 pixeltricks GmbH
 * @since 23.10.2010
 */
class SilvercartMyAccountHolder_Controller extends Page_Controller {

    /**
     * ID of the breadcrumb element
     *
     * @var int
     */
    protected $breadcrumbElementID;

    /**
     * statements to be called on object initialisation
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 18.11.2010
     * @return void
     */
    public function init() {
        if (SilvercartConfig::EnableSSL()) {
            Director::forceSSL();
        }
        
        Session::clear("redirect"); //if customer has been to the checkout yet this is set to direct him back to the checkout after address editing

        parent::init();

        $this->registerCustomHtmlForm('SilvercartLoginForm', new SilvercartLoginForm($this));
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
        $elements = array(
            'SubElementsTitle'  => $this->PageByIdentifierCode('SilvercartMyAccountHolder')->MenuTitle,
            'SubElements'       => $this->PageByIdentifierCode('SilvercartMyAccountHolder')->Children(),
        );
        $this->extend('updateSubNavigation', $elements);
        $output = $this->customise($elements)->renderWith(
            array(
                'SilvercartSubNavigation',
            )
        );
        return $output;
    }

    /**
     * template method for breadcrumbs
     * show breadcrumbs for pages which show a DataObject determined via URL parameter ID
     * see _config.php
     *
     * @return string html for breadcrumbs
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 3.11.2010
     */
    public function getBreadcrumbs() {
        $page = $this->PageByIdentifierCode($this->IdentifierCode);

        return $this->ContextBreadcrumbs($page, 20, false, 'SilvercartFrontPage', true);
    }

    /**
     * pages with own url rewriting need their breadcrumbs created in a different way
     *
     * @param Controller $context        the current controller
     * @param int        $maxDepth       maximum levels
     * @param bool       $unlinked       link breadcrumbs elements
     * @param bool       $stopAtPageType name of PageType to stop at
     * @param bool       $showHidden     show pages that will not show in menus
     *
     * @return string html for breadcrumbs
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Sascha Koehler <skoehler@pixeltricks.de>
     * @since 04.03.2014
     */
    public function ContextBreadcrumbs($context, $maxDepth = 20, $unlinked = false, $stopAtPageType = false, $showHidden = false) {
        $page = $context;
        $parts = array();

        $contextObject = DataObject::get($context->getSection())->byID($this->getBreadcrumbElementID());
        
        if ($contextObject) {
            $parts[] = $contextObject->Title;
        }

        $i = 0;
        while (
            $page
            && (!$maxDepth || sizeof($parts) < $maxDepth)
            && (!$stopAtPageType || $page->ClassName != $stopAtPageType)
        ) {
            if ($showHidden || $page->ShowInMenus || ($page->ID == $this->ID)) {
                if ($page->URLSegment == 'home') {
                    $hasHome = true;
                }
                if (($page->ID == $this->ID) || $unlinked) {
                    $parts[] = Convert::raw2xml($page->Title);
                } else {
                    $parts[] = ("<a href=\"" . $page->Link() . "\">" . Convert::raw2xml($page->Title) . "</a>");
                }
            }
            $page = $page->Parent;
        }

        return implode(" &raquo; ", array_reverse($parts));
    }

    /**
     * returns the BreadcrumbElementID
     *
     * @return int
     */
    public function getBreadcrumbElementID() {
        return $this->breadcrumbElementID;
    }

    /**
     * sets the BreadcrumbElementID
     *
     * @param int $breadcrumbElementID BreadcrumbElementID
     *
     * @return void
     */
    public function setBreadcrumbElementID($breadcrumbElementID) {
        $this->breadcrumbElementID = $breadcrumbElementID;
    }

    /**
     * returns the link to the order detail page (without orderID)
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 22.02.2011
     */
    public function OrderDetailLink() {
        return $this->PageByIdentifierCode('SilvercartOrderDetailPage')->Link() . 'detail/';
    }
}
