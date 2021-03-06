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
 * Class for processing transaction costs etc.
 *
 * @package Silvercart
 * @subpackage Base
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 09.11.2010
 * @license see license file in modules root directory
 */
class SilvercartHandlingCost extends DataObject {

    /**
     * Attributes.
     *
     * @var array
     */
    public static $db = array(
        'amount' => 'Money'
    );

    /**
     * Casting.
     *
     * @var array
     */
    public static $casting = array(
        'handlingcosts' => 'Text'
    );

    /**
     * Has-one relationships.
     *
     * @var array
     */
    public static $has_one = array(
        'SilvercartTax'           => 'SilvercartTax',
        'SilvercartPaymentMethod' => 'SilvercartPaymentMethod',
        'SilvercartZone'          => 'SilvercartZone',
    );

    /**
     * Sets the field labels.
     *
     * @param bool $includerelations set to true to include the DataObjects relations
     * 
     * @return array
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.10.2012
     */
    public function fieldLabels($includerelations = true) {
        return array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'amount'         => _t('SilvercartHandlingCost.AMOUNT', 'amount'),
                    'SilvercartTax'  => _t('SilvercartTax.SINGULARNAME'),
                    'SilvercartZone' => _t('SilvercartZone.SINGULARNAME'),
                )
        );
    }

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
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.10.2012
     */
    public function summaryFields() {
        $summaryFields = array(
            'handlingcosts'         => $this->fieldLabel('amount'),
            'SilvercartTax.Rate'    => $this->fieldLabel('SilvercartTax'),
            'SilvercartZone.Title'  => $this->fieldLabel('SilvercartZone'),
        );
        $this->extend('updateSummaryFields', $summaryFields);

        return $summaryFields;
    }
    
    /**
     * customizes the backends fields, mainly for ModelAdmin
     * 
     * @param array $params configuration parameters
     *
     * @return FieldList the fields for the backend
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.10.2012
     */
    public function getCMSFields($params = null) {
        $fields = parent::getCMSFields(
                array_merge(
                        array(
                            'fieldClasses' => array(
                                'amount' => 'SilvercartMoneyField',
                            ),
                        ),
                        (array)$params
                )
        );
        SilvercartTax::presetDropdownWithDefault($fields->dataFieldByName('SilvercartTaxID'), $this);
        
        $fieldGroup = new SilvercartFieldGroup('handlingCostGroup', '', $fields);
        $fieldGroup->push(          $fields->dataFieldByName('amount'));
        $fieldGroup->pushAndBreak(  $fields->dataFieldByName('SilvercartTaxID'));
        $fields->addFieldToTab('Root.Main', $fieldGroup);
        
        return $fields;
    }

    /**
     * Returns the prices amount
     *
     * @return float
     */
    public function getPriceAmount() {
        $price = (float) $this->amount->getAmount();

        if (SilvercartConfig::PriceType() == 'net') {
            $price = $price - $this->getTaxAmount();
        }

        return $price;
    }

    /**
     * Returns the tax rate for this fee.
     * 
     * @return int
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 16.11.2013
     */
    public function getTaxRate() {
        $taxRate = SilvercartShoppingCart::get_most_valuable_tax_rate();
        if ($taxRate === false) {
            $taxRate = $this->SilvercartTax()->getTaxRate();
        }
        return $taxRate;
    }

    /**
     * returns the tax amount included in $this
     *
     * @return float
     */
    public function getTaxAmount() {
        $taxRate = $this->amount->getAmount() - ($this->amount->getAmount() / (100 + $this->getTaxRate()) * 100);

        return $taxRate;
    }

    /**
     * Returns the Price formatted by locale.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 31.01.2011
     */
    public function PriceFormatted() {
        $priceObj = new Money();
        $priceObj->setAmount($this->getPriceAmount());
        $priceObj->setCurrency($this->price->getCurrency());

        return $priceObj->Nice();
    }

    /**
     * Returns the handling costs for display in tables.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 29.03.2012
     */
    public function handlingcosts() {
        return $this->amount->Nice();
    }
}
