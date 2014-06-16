<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Order
 */

/**
 * Handles the configuration for the prefilled shopping carts mechanism.
 *
 * @package Silvercart
 * @subpackage Order
 * @author Sascha Koehler <skoehler@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 16.07.2013
 * @license see license file in modules root directory
 * @copyright 2013 pixeltricks GmbH
 */
class SilvercartInboundShoppingCartTransfer extends DataObject {
    
    /**
     * Attributes
     *
     * @var array
     */
    public static $db = array(
        'Title'                             => 'VarChar(255)',
        'refererIdentifier'                 => 'VarChar(50)',
        'useSharedSecret'                   => 'Boolean(1)',
        'sharedSecret'                      => 'VarChar(255)',
        'sharedSecretIdentifier'            => 'VarChar(50)',
        'transferMethod'                    => "Enum('keyValue,combinedString','combinedString')",
        'combinedStringKey'                 => 'VarChar(50)',
        'combinedStringEntitySeparator'     => 'VarChar(20)',
        'combinedStringQuantitySeparator'   => 'VarChar(20',
        'keyValueProductIdentifier'         => 'VarChar(50)',
        'keyValueQuantityIdentifier'        => 'VarChar(50)',
        'productMatchingField'              => 'VarChar(255)',
        'productMatchingFieldPrefix'        => 'Varchar(32)',
        'productMatchingFieldSuffix'        => 'Varchar(32)',
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
     * Summaryfields for display in tables.
     *
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    public function summaryFields() {
        $summaryFields = array(
            'Title'                 => $this->fieldLabel('Title'),
            'refererIdentifier'     => $this->fieldLabel('refererIdentifier'),
            'useSharedSecret'       => $this->fieldLabel('useSharedSecret'),
            'transferMethod'        => $this->fieldLabel('transferMethod'),
            'productMatchingField'  => $this->fieldLabel('productMatchingField')
        );
        $this->extend('updateSummaryFields', $summaryFields);

        return $summaryFields;
    }
    
    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     * 
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 16.07.2013
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
            parent::fieldLabels($includerelations),
            array(
                'Title'                             => _t('SilvercartInboundShoppingCartTransfer.TITLE'),
                'refererIdentifier'                 => _t('SilvercartInboundShoppingCartTransfer.REFERER_IDENTIFIER'),
                'useSharedSecret'                   => _t('SilvercartInboundShoppingCartTransfer.SHARED_SECRET_ACTIVATION'),
                'sharedSecret'                      => _t('SilvercartInboundShoppingCartTransfer.SHARED_SECRET'),
                'sharedSecretIdentifier'            => _t('SilvercartInboundShoppingCartTransfer.SHARED_SECRET_IDENTIFIER'),
                'transferMethod'                    => _t('SilvercartInboundShoppingCartTransfer.TRANSFER_METHOD'),
                'combinedStringKey'                 => _t('SilvercartInboundShoppingCartTransfer.COMBINED_STRING_KEY'),
                'combinedStringEntitySeparator'     => _t('SilvercartInboundShoppingCartTransfer.COMBINED_STRING_ENTITY_SEPARATOR'),
                'combinedStringQuantitySeparator'   => _t('SilvercartInboundShoppingCartTransfer.COMBINED_STRING_QUANTITY_SEPARATOR'),
                'keyValueProductIdentifier'         => _t('SilvercartInboundShoppingCartTransfer.KEY_VALUE_PRODUCT_IDENTIFIER'),
                'keyValueQuantityIdentifier'        => _t('SilvercartInboundShoppingCartTransfer.KEY_VALUE_QUANTITY_IDENTIFIER'),
                'productMatchingField'              => _t('SilvercartInboundShoppingCartTransfer.PRODUCT_MATCHING_FIELD'),
                'productMatchingFieldPrefix'        => _t('SilvercartInboundShoppingCartTransfer.productMatchingFieldPrefix'),
                'productMatchingFieldSuffix'        => _t('SilvercartInboundShoppingCartTransfer.productMatchingFieldSuffix'),
            )
        );
        $this->extend('updateFieldLabels', $fieldLabels);
        
        return $fieldLabels;
    }
}