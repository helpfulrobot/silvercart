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
 * Define how an url can be built to redirect to a product detail page without
 * The URL has the attribute and the value as parameters:
 * www.mysite.com/deeplink/attribute/value
 * These definitions are always handled on the SilvercartDeeplinkPage.
 *
 * @package Silvercart
 * @subpackage Base
 * @author Roland Lehmann <rlehmann@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 29.05.2013
 * @copyright 2013 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartDeeplink extends DataObject {
    
    /**
     * attributes
     * 
     * @var array additional attributes 
     */
    public static $db = array(
        'productAttribute'  => 'VarChar(50)',
        'isActive'          => 'Boolean(0)',
        'Prefix'            => 'Varchar(32)',
        'Suffix'            => 'Varchar(32)',
    );

    /**
     * Casted attributes
     *
     * @var array
     */
    public static $casting = array(
        'DeeplinkUrl'      => 'VarChar',
        'ActivationStatus' => 'VarChar'
    );
    
    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     *
     * @return array
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.05.2013
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'Prefix'            => _t('SilvercartDeeplink.Prefix'),
                    'Suffix'            => _t('SilvercartDeeplink.Suffix'),
                    'isActive'          => _t('SilvercartPage.ISACTIVE'),
                    'productAttribute'  => _t('SilvercartProductGroupPage.ATTRIBUTES'),
                    'deeplinkAttribute' => _t('SilvercartDeeplinkAttribute.SINGULARNAME'),
                    'countryActive'     => _t('SilvercartCountry.ACTIVE'),
                    'emptyString'       => _t('SilvercartEditAddressForm.EMPTYSTRING_PLEASECHOOSE')
                )
        );

        $this->extend('updateFieldLabels', $fieldLabels);
        return $fieldLabels;
    }
    
    /**
     * getter for the avtivation status
     * 
     * @return boolean answer 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 30.7.2011
     */
    public function isActive() {
        return $this->isActive;
    }
    
    /**
     * Returns the text label for the deeplinks activion status.
     *
     * @return string answer as text
     */
    public function getActivationStatus() {
        if ($this->isActive()) {
            return _t('Silvercart.YES');
        }
        return _t('Silvercart.NO');
    }
    
    /**
     * Return the absolute URL of the deeplink page plus the attribute for the
     * filter;
     * 
     * @return string The absolute link to this deeplink setting or an empty string
     */
    public function getDeeplinkUrl() {
        $url = "";
        $deeplinkPage = SilvercartTools::PageByIdentifierCode("SilvercartDeeplinkPage");
        if ($deeplinkPage && $this->productAttribute != "" && $this->isActive()) {
            $url = $deeplinkPage->AbsoluteLink() . $this->productAttribute . "/";
        }
        return $url;
    }
    
    /**
     * Returns an array of field/relation names (db, has_one, has_many, 
     * many_many, belongs_many_many) to exclude from form scaffolding in
     * backend.
     * This is a performance friendly way to exclude fields.
     * 
     * @return array
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 10.02.2013
     */
    public function excludeFromScaffolding() {
        $excludeFromScaffolding = array(
            'productAttribute'
        );
        $this->extend('updateExcludeFromScaffolding', $excludeFromScaffolding);
        return $excludeFromScaffolding;
    }
    
    /**
     * Returns the GUI fields for the storeadmin.
     * 
     * @return FieldSet a set of fields
     */
    public function getCMSFields() {
        $productFields  = array();
        $fields         = SilvercartDataObject::getCMSFields($this);
        
        $dbFields = DataObject::database_fields('SilvercartProduct');
        foreach ($dbFields as $fieldName => $fieldType) {
            $productFields[$fieldName] = $fieldName;
        }
        
        $productAttributeDropdown = new DropdownField('productAttribute', $this->fieldLabel('deeplinkAttribute'), $productFields, null, null, $this->fieldLabel('emptyString'));
        
        $fields->addFieldToTab('Root.Main', $productAttributeDropdown);
        $fields->addFieldToTab('Root.Main', new ReadonlyField('deeplink', $this->singular_name(), $this->getDeeplinkUrl()));
        return $fields;
    }
    
    /**
     * Summaryfields for display in tables.
     *
     * @return array
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 30.7.2011
     */
    public function summaryFields() {
        $summaryFields = array(
            'productAttribute' => $this->fieldLabel('deeplinkAttribute'),
            'ActivationStatus' => $this->fieldLabel('countryActive'),
            'DeeplinkUrl'      => 'Deeplink'
        );
        return $summaryFields;
    }
}

