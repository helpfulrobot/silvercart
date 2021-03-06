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
 * abstract for an order
 *
 * @package Silvercart
 * @subpackage Order
 * @author Sascha Koehler <skoehler@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 21.07.2013
 * @copyright 2013 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartOrder extends DataObject implements PermissionProvider {

    /**
     * attributes
     *
     * @var array
     */
    public static $db = array(
        'AmountTotal'                       => 'SilvercartMoney', // value of all products
        'PriceType'                         => 'VarChar(24)',
        'HandlingCostPayment'               => 'SilvercartMoney',
        'HandlingCostShipment'              => 'SilvercartMoney',
        'TaxRatePayment'                    => 'Int',
        'TaxRateShipment'                   => 'Int',
        'TaxAmountPayment'                  => 'Float',
        'TaxAmountShipment'                 => 'Float',
        'Note'                              => 'Text',
        'WeightTotal'                       => 'Int', //unit is gramm
        'CustomersEmail'                    => 'VarChar(60)',
        'OrderNumber'                       => 'VarChar(128)',
        'HasAcceptedTermsAndConditions'     => 'Boolean(0)',
        'HasAcceptedRevocationInstruction'  => 'Boolean(0)',
        'IsSeen'                            => 'Boolean(0)',
        'TrackingCode'                      => 'VarChar(64)',
        'TrackingLink'                      => 'Text',
        /**
         * @deprecated
         */
        'AmountGrossTotal'                  => 'SilvercartMoney', // value of all products + transaction fee
    );

    /**
     * 1:1 relations
     *
     * @var array
     */
    public static $has_one = array(
        'SilvercartShippingAddress' => 'SilvercartOrderShippingAddress',
        'SilvercartInvoiceAddress'  => 'SilvercartOrderInvoiceAddress',
        'SilvercartPaymentMethod'   => 'SilvercartPaymentMethod',
        'SilvercartShippingMethod'  => 'SilvercartShippingMethod',
        'SilvercartOrderStatus'     => 'SilvercartOrderStatus',
        'Member'                    => 'Member',
        'SilvercartShippingFee'     => 'SilvercartShippingFee'
    );

    /**
     * 1:n relations
     *
     * @var array
     */
    public static $has_many = array(
        'SilvercartOrderPositions'  => 'SilvercartOrderPosition',
        'SilvercartOrderLogs'       => 'SilvercartOrderLog',
    );

    /**
     * Casting.
     *
     * @var array
     */
    public static $casting = array(
        'Created'                       => 'Date',
        'CreatedNice'                   => 'VarChar',
        'ShippingAddressSummary'        => 'Text',
        'ShippingAddressSummaryHtml'    => 'HtmlText',
        'ShippingAddressTable'          => 'HtmlText',
        'InvoiceAddressSummary'         => 'Text',
        'InvoiceAddressSummaryHtml'     => 'HtmlText',
        'InvoiceAddressTable'           => 'HtmlText',
        'AmountTotalNice'               => 'VarChar',
        'PriceTypeText'                 => 'VarChar(24)',
    );
    
        /**
     * Default sort direction in tables.
     *
     * @var string
     */
    public static $default_sort = "Created DESC";

    /**
     * register extensions
     *
     * @var array
     */
    public static $extensions = array(
        "Versioned('Live')",
    );

    /**
     * Grant API access on this item.
     *
     * @var bool
     *
     * @since 2013-03-13
     */
    public static $api_access = true;

    /**
     * Prevents multiple handling of order status change.
     *
     * @var bool
     */
    protected $didHandleOrderStatusChange = false;
    
    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string The objects singular name 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
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
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
     */
    public function plural_name() {
        return SilvercartTools::plural_name_for($this); 
    }

    /**
     * Set permissions.
     *
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
     */
    public function providePermissions() {
        return array(
            'SILVERCART_ORDER_VIEW'   => _t('SilvercartOrder.SILVERCART_ORDER_VIEW'),
            'SILVERCART_ORDER_EDIT'   => _t('SilvercartOrder.SILVERCART_ORDER_EDIT'),
            'SILVERCART_ORDER_DELETE' => _t('SilvercartOrder.SILVERCART_ORDER_DELETE')
        );
    }

    /**
     * Indicates wether the current user can view this object.
     * 
     * @param Member $member declated to be compatible with parent
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.01.2013
     */
    public function CanView($member = null) {
        $canView = false;

        if ((Member::currentUserID() == $this->MemberID &&
             !is_null($this->MemberID)) ||
            Permission::check('SILVERCART_ORDER_VIEW')) {
            $canView = true;
        }
        return $canView;
    }
    
    /**
     * Order should not be created via backend
     * 
     * @param Member $member Member to check permission for
     *
     * @return false 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 10.02.2012
     */
    public function canCreate($member = null) {
        return false;
    }

    /**
     * Indicates wether the current user can edit this object.
     * 
     * @param Member $member declated to be compatible with parent
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
     */
    public function CanEdit($member = null) {
        return Permission::check('SILVERCART_ORDER_EDIT');
    }

    /**
     * Indicates wether the current user can delete this object.
     * 
     * @param Member $member declated to be compatible with parent
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
     */
    public function CanDelete($member = null) {
        return Permission::check('SILVERCART_ORDER_DELETE');
    }

    /**
     * Summaryfields for display in tables.
     *
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 03.04.2013
     */
    public function summaryFields() {
        $summaryFields = array(
            'CreatedNice'                       => $this->fieldLabel('Created'),
            'OrderNumber'                       => $this->fieldLabel('OrderNumberShort'),
            'Member.CustomerNumber'             => $this->Member()->fieldLabel('CustomerNumberShort'),
            'ShippingAddressSummaryHtml'        => $this->fieldLabel('SilvercartShippingAddress'),
            'InvoiceAddressSummaryHtml'         => $this->fieldLabel('SilvercartInvoiceAddress'),
            'AmountTotalNice'                   => $this->fieldLabel('AmountTotal'),
            'SilvercartPaymentMethod.Title'     => $this->fieldLabel('SilvercartPaymentMethod'),
            'SilvercartOrderStatus.Title'       => $this->fieldLabel('SilvercartOrderStatus'),
            'SilvercartShippingMethod.Title'    => $this->fieldLabel('SilvercartShippingMethod'),
        );
        $this->extend('updateSummaryFields', $summaryFields);

        return $summaryFields;
    }
    
    /**
     * Returns a list of fields which are allowed to display HTML inside a
     * GridFields data column.
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.03.2013
     */
    public function allowHtmlDataFor() {
        return array(
            'ShippingAddressSummaryHtml',
            'InvoiceAddressSummaryHtml',
        );
    }

    /**
     * Field labels for display in tables.
     *
     * @param boolean $includerelations A boolean value to indicate if the labels returned include relation fields
     * 
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
            parent::fieldLabels($includerelations),
            array(
                'ID'                                    => _t('SilvercartOrder.ORDER_ID'),
                'Created'                               => _t('SilvercartPage.ORDER_DATE'),
                'OrderNumber'                           => _t('SilvercartOrder.ORDERNUMBER', 'ordernumber'),
                'OrderNumberShort'                      => _t('SilvercartOrder.OrderNumberShort'),
                'SilvercartShippingFee'                 => _t('SilvercartOrder.SHIPPINGRATE', 'shipping costs'),
                'Note'                                  => _t('SilvercartOrder.NOTE'),
                'YourNote'                              => _t('SilvercartOrder.YOUR_REMARK'),
                'Member'                                => _t('SilvercartOrder.CUSTOMER', 'customer'),
                'Customer'                              => _t('SilvercartOrder.CUSTOMER'),
                'CustomerData'                          => _t('SilvercartOrder.CUSTOMERDATA'),
                'MemberCustomerNumber'                  => _t('SilvercartCustomer.CUSTOMERNUMBER'),
                'MemberEmail'                           => _t('Member.EMAIL'),
                'Email'                                 => _t('SilvercartAddress.EMAIL'),
                'SilvercartShippingAddress'             => _t('SilvercartShippingAddress.SINGULARNAME'),
                'SilvercartShippingAddressFirstName'    => _t('SilvercartAddress.FIRSTNAME'),
                'SilvercartShippingAddressSurname'      => _t('SilvercartAddress.SURNAME'),
                'SilvercartShippingAddressCountry'      => _t('SilvercartCountry.SINGULARNAME'),
                'SilvercartInvoiceAddress'              => _t('SilvercartInvoiceAddress.SINGULARNAME'),
                'SilvercartOrderStatus'                 => _t('SilvercartOrder.STATUS', 'order status'),
                'AmountTotal'                           => _t('SilvercartOrder.AMOUNTTOTAL'),
                'PriceType'                             => _t('SilvercartOrder.PRICETYPE'),
                'AmountGrossTotal'                      => _t('SilvercartOrder.AMOUNTGROSSTOTAL'),
                'HandlingCost'                          => _t('SilvercartOrder.HandlingCost'),
                'HandlingCostPayment'                   => _t('SilvercartOrder.HANDLINGCOSTPAYMENT'),
                'HandlingCostShipment'                  => _t('SilvercartOrder.HANDLINGCOSTSHIPMENT'),
                'TaxRatePayment'                        => _t('SilvercartOrder.TAXRATEPAYMENT'),
                'TaxRateShipment'                       => _t('SilvercartOrder.TAXRATESHIPMENT'),
                'TaxAmountPayment'                      => _t('SilvercartOrder.TAXAMOUNTPAYMENT'),
                'TaxAmountShipment'                     => _t('SilvercartOrder.TAXAMOUNTSHIPMENT'),
                'WeightTotal'                           => _t('SilvercartOrder.WEIGHTTOTAL'),
                'CustomersEmail'                        => _t('SilvercartOrder.CUSTOMERSEMAIL'),
                'SilvercartPaymentMethod'               => _t('SilvercartPaymentMethod.SINGULARNAME'),
                'SilvercartShippingMethod'              => _t('SilvercartShippingMethod.SINGULARNAME'),
                'HasAcceptedTermsAndConditions'         => _t('SilvercartOrder.HASACCEPTEDTERMSANDCONDITIONS'),
                'HasAcceptedRevocationInstruction'      => _t('SilvercartOrder.HASACCEPTEDREVOCATIONINSTRUCTION'),
                'SilvercartOrderPositions'              => _t('SilvercartOrderPosition.PLURALNAME'),
                'SilvercartOrderPositionsProductNumber' => _t('SilvercartProduct.PRODUCTNUMBER'),
                'OrderPositionData'                     => _t('SilvercartOrder.ORDERPOSITIONDATA'),
                'OrderPositionQuantity'                 => _t('SilvercartOrder.ORDERPOSITIONQUANTITY'),
                'OrderPositionIsLimit'                  => _t('SilvercartOrder.ORDERPOSITIONISLIMIT'),
                'SearchResultsLimit'                    => _t('SilvercartOrder.SEARCHRESULTSLIMIT'),
                'BasicData'                             => _t('SilvercartOrder.BASICDATA'),
                'MiscData'                              => _t('SilvercartOrder.MISCDATA'),
                'ShippingAddressTab'                    => _t('SilvercartAddressHolder.SHIPPINGADDRESS_TAB'),
                'InvoiceAddressTab'                     => _t('SilvercartAddressHolder.INVOICEADDRESS_TAB'),
                'PrintPreview'                          => _t('SilvercartOrder.PRINT_PREVIEW'),
                'EmptyString'                           => _t('SilvercartEditAddressForm.EMPTYSTRING_PLEASECHOOSE'),
                'ChangeOrderStatus'                     => _t('SilvercartOrder.BATCH_CHANGEORDERSTATUS'),
                'IsSeen'                                => _t('SilvercartOrder.IS_SEEN'),
                'SilvercartOrderLogs'                   => _t('SilvercartOrderLog.PLURALNAME'),
                'ValueOfGoods'                          => _t('SilvercartPage.VALUE_OF_GOODS'),
                'TrackingCode'                          => _t('SilvercartOrder.TrackingCode'),
                'TrackingLink'                          => _t('SilvercartOrder.TrackingLink'),
            )
        );
        $this->extend('updateFieldLabels', $fieldLabels);
        
        return $fieldLabels;
    }

    /**
     * Searchable fields
     *
     * @return array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2012
     */
    public function searchableFields() {
        $address = singleton('SilvercartAddress');
        $searchableFields = array(
            'Created' => array(
                'title'     => $this->fieldLabel('Created'),
                'filter'    => 'DateRangeSearchFilter',
                'field'     => 'TextField',
            ),
            'OrderNumber' => array(
                'title'     => $this->fieldLabel('OrderNumber'),
                'filter'    => 'PartialMatchFilter'
            ),
            'IsSeen' => array(
                'title'     => $this->fieldLabel('IsSeen'),
                'filter'    => 'ExactMatchFilter'
            ),
            'SilvercartOrderStatus.ID' => array(
                'title'     => $this->fieldLabel('SilvercartOrderStatus'),
                'filter'    => 'SilvercartExactMatchBooleanMultiFilter'
            ),
            'SilvercartPaymentMethod.ID' => array(
                'title'     => $this->fieldLabel('SilvercartPaymentMethod'),
                'filter'    => 'ExactMatchFilter'
            ),
            'SilvercartShippingMethod.ID' => array(
                'title'     => $this->fieldLabel('SilvercartShippingMethod'),
                'filter'    => 'ExactMatchFilter'
            ),
            'Member.CustomerNumber' => array(
                'title'     => $this->fieldLabel('MemberCustomerNumber'),
                'filter'    => 'PartialMatchFilter'
            ),
            'Member.Email' => array(
                'title'     => $this->fieldLabel('MemberEmail'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.FirstName' => array(
                'title'     => $this->fieldLabel('SilvercartShippingAddressFirstName'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.Surname' => array(
                'title'     => $this->fieldLabel('SilvercartShippingAddressSurname'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.Street' => array(
                'title'     => $address->fieldLabel('Street'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.StreetNumber' => array(
                'title'     => $address->fieldLabel('StreetNumber'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.Postcode' => array(
                'title'     => $address->fieldLabel('Postcode'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.City' => array(
                'title'     => $address->fieldLabel('City'),
                'filter'    => 'PartialMatchFilter'
            ),
            'SilvercartShippingAddress.SilvercartCountry.ID' => array(
                'title'     => $this->fieldLabel('SilvercartShippingAddressCountry'),
                'filter'    => 'ExactMatchFilter'
            ),
            'SilvercartOrderPositions.ProductNumber' => array(
                'title'     => $this->fieldLabel('SilvercartOrderPositionsProductNumber'),
                'filter'    => 'PartialMatchFilter'
            ),
        );
        $this->extend('updateSearchableFields', $searchableFields);

        return $searchableFields;
    }
    
    /**
     * Returns the Title.
     * 
     * @return string
     */
    public function getTitle() {
        $title = $this->fieldLabel('OrderNumber') . ': ' . $this->OrderNumber . ' | ' . $this->fieldLabel('Created') . ': ' . date(_t('Silvercart.DATEFORMAT'), strtotime($this->Created)) . ' | ' . $this->fieldLabel('AmountTotal') . ': ' . $this->AmountTotal->Nice();
        $this->extend('updateTitle', $title);
        return $title;
    }

    /**
     * Set the default search context for this field
     * 
     * @return DateRangeSearchContext
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 27.02.2012
     */
    public function getDefaultSearchContext() {
        return new DateRangeSearchContext(
            $this->class,
            $this->scaffoldSearchFields(),
            $this->defaultSearchFilters()
        );
    }
    
    /**
     * Returns the orders tracking code.
     * Tracking code is extendable by decorator.
     * 
     * @return string
     */
    public function getTrackingCode() {
        $trackingCode = $this->getField('TrackingCode');
        $this->extend('updateTrackingCode', $trackingCode);
        return $trackingCode;
    }
    
    /**
     * Returns the orders tracking link.
     * Tracking link is extendable by decorator.
     * 
     * @return string
     */
    public function getTrackingLink() {
        $trackingLink = $this->getField('TrackingLink');
        $this->extend('updateTrackingLink', $trackingLink);
        return $trackingLink;
    }

    /**
     * returns the orders creation date formated: dd.mm.yyyy hh:mm
     *
     * @return string
     */
    public function getCreatedNice() {
        return date('d.m.Y H:i', strtotime($this->Created)) . ' Uhr';
    }

    /**
     * return the orders shipping address as complete string.
     * 
     * @param bool $disableUpdate Disable update by decorator?
     *
     * @return string
     */
    public function getShippingAddressSummary($disableUpdate = false) {
        $shippingAddressSummary = '';
        if (!empty($this->SilvercartShippingAddress()->Company)) {
            $shippingAddressSummary .= $this->SilvercartShippingAddress()->Company . PHP_EOL;
        }
        $shippingAddressSummary .= $this->SilvercartShippingAddress()->FullName . PHP_EOL;
        if ($this->SilvercartShippingAddress()->IsPackstation) {
            $shippingAddressSummary .= $this->SilvercartShippingAddress()->PostNumber . PHP_EOL;
            $shippingAddressSummary .= $this->SilvercartShippingAddress()->Packstation . PHP_EOL;
        } else {
            $shippingAddressSummary .= $this->SilvercartShippingAddress()->Addition == '' ? '' : $this->SilvercartShippingAddress()->Addition . PHP_EOL;
            $shippingAddressSummary .= $this->SilvercartShippingAddress()->Street . ' ' . $this->SilvercartShippingAddress()->StreetNumber . PHP_EOL;
        }
        $shippingAddressSummary .= strtoupper($this->SilvercartShippingAddress()->SilvercartCountry()->ISO2) . '-' . $this->SilvercartShippingAddress()->Postcode . ' ' . $this->SilvercartShippingAddress()->City . PHP_EOL;
        if (!empty($this->SilvercartShippingAddress()->TaxIdNumber)) {
            $shippingAddressSummary .= $this->SilvercartShippingAddress()->TaxIdNumber . PHP_EOL;
        }
        if (!$disableUpdate) {
            $this->extend('updateShippingAddressSummary', $shippingAddressSummary);
        }
        return $shippingAddressSummary;
    }

    /**
     * return the orders shipping address as complete HTML string.
     *
     * @return string
     */
    public function getShippingAddressSummaryHtml() {
        $html = new HTMLText();
        $html->setValue(str_replace(PHP_EOL, '<br/>', $this->ShippingAddressSummary));
        return $html;
    }

    /**
     * Returns the shipping address rendered with a HTML table
     * 
     * @return type
     */
    public function getShippingAddressTable() {
        return $this->SilvercartShippingAddress()->renderWith('SilvercartMailAddressData');
    }
    
    /**
     * Returns whether the invoice address equals the shipping address.
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.02.2014
     */
    public function InvoiceAddressEqualsShippingAddress() {
        $isEqual = $this->SilvercartInvoiceAddress()->isEqual($this->SilvercartShippingAddress());
        return $isEqual;
    }

    /**
     * return the orders invoice address as complete string.
     * 
     * @param bool $disableUpdate Disable update by decorator?
     *
     * @return string
     */
    public function getInvoiceAddressSummary($disableUpdate = false) {
        $invoiceAddressSummary = '';
        if (!empty($this->SilvercartInvoiceAddress()->Company)) {
            $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->Company . PHP_EOL;
        }
        $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->FullName . PHP_EOL;
        if ($this->SilvercartInvoiceAddress()->IsPackstation) {
            $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->PostNumber . PHP_EOL;
            $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->Packstation . PHP_EOL;
        } else {
            $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->Addition == '' ? '' : $this->SilvercartInvoiceAddress()->Addition . PHP_EOL;
            $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->Street . ' ' . $this->SilvercartInvoiceAddress()->StreetNumber . PHP_EOL;
        }
        $invoiceAddressSummary .= strtoupper($this->SilvercartInvoiceAddress()->SilvercartCountry()->ISO2) . '-' . $this->SilvercartInvoiceAddress()->Postcode . ' ' . $this->SilvercartInvoiceAddress()->City . PHP_EOL;
        if (!empty($this->SilvercartInvoiceAddress()->TaxIdNumber)) {
            $invoiceAddressSummary .= $this->SilvercartInvoiceAddress()->TaxIdNumber . PHP_EOL;
        }
        if (!$disableUpdate) {
            $this->extend('updateInvoiceAddressSummary', $invoiceAddressSummary);
        }
        return $invoiceAddressSummary;
    }

    /**
     * return the orders invoice address as complete HTML string.
     *
     * @return string
     */
    public function getInvoiceAddressSummaryHtml() {
        $html = new HTMLText();
        $html->setValue(str_replace(PHP_EOL, '<br/>', $this->InvoiceAddressSummary));
        return $html;
    }
    
    /**
     * Returns the invoice address rendered with a HTML table
     * 
     * @return type
     */
    public function getInvoiceAddressTable() {
        return $this->SilvercartInvoiceAddress()->renderWith('SilvercartMailAddressData');
    }

    /**
     * Returns a limited number of order positions.
     * 
     * @param int $numberOfPositions The number of positions to get.
     *
     * @return DataList
     */
    public function getLimitedSilvercartOrderPositions($numberOfPositions = 2) {
        return $this->SilvercartOrderPositions()->limit($numberOfPositions);
    }

    /**
     * Returns a limited number of order positions.
     * 
     * @param int $numberOfPositions The number of positions to check for.
     *
     * @return ArrayList
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 26.01.2012
     */
    public function hasMoreSilvercartOrderPositionsThan($numberOfPositions = 2) {
        $hasMorePositions = false;

        if ($this->SilvercartOrderPositions()->count() > $numberOfPositions) {
            $hasMorePositions = true;
        }

        return $hasMorePositions;
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
     * @since 05.03.2013
     */
    public function excludeFromScaffolding() {
        $excludeFromScaffolding = array(
            'Version',
            'IsSeen',
            'SilvercartShippingAddress',
            'SilvercartInvoiceAddress',
            'SilvercartShippingFee',
            'Member'
        );
        $this->extend('updateExcludeFromScaffolding', $excludeFromScaffolding);
        return $excludeFromScaffolding;
    }

    /**
     * customize backend fields
     *
     * @return FieldList the form fields for the backend
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@πixeltricks.de>
     * @since 28.01.2013
     */
    public function getCMSFields() {
        $this->markAsSeen();
        $fields = SilvercartDataObject::getCMSFields($this);
        
        //add the shipping/invloice address fields as own tab
        $address = singleton('SilvercartAddress');
        $fields->findOrMakeTab('Root.ShippingAddressTab', $this->fieldLabel('ShippingAddressTab'));
        $fields->findOrMakeTab('Root.InvoiceAddressTab',  $this->fieldLabel('InvoiceAddressTab'));
        
        $fields->addFieldToTab('Root.ShippingAddressTab', new LiteralField('sa__Preview',           '<p>' . Convert::raw2xml($this->getShippingAddressSummary(true)) . '</p>'));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__TaxIdNumber',          $address->fieldLabel('TaxIdNumber'),        $this->SilvercartShippingAddress()->TaxIdNumber));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Company',              $address->fieldLabel('Company'),            $this->SilvercartShippingAddress()->Company));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__FirstName',            $address->fieldLabel('FirstName'),          $this->SilvercartShippingAddress()->FirstName));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Surname',              $address->fieldLabel('Surname'),            $this->SilvercartShippingAddress()->Surname));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Addition',             $address->fieldLabel('Addition'),           $this->SilvercartShippingAddress()->Addition));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Street',               $address->fieldLabel('Street'),             $this->SilvercartShippingAddress()->Street));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__StreetNumber',         $address->fieldLabel('StreetNumber'),       $this->SilvercartShippingAddress()->StreetNumber));
        $fields->addFieldToTab('Root.ShippingAddressTab', new CheckboxField('sa__IsPackstation',    $address->fieldLabel('IsPackstation'),      $this->SilvercartShippingAddress()->IsPackstation));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__PostNumber',           $address->fieldLabel('PostNumber'),         $this->SilvercartShippingAddress()->PostNumber));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Packstation',          $address->fieldLabel('PackstationPlain'),   $this->SilvercartShippingAddress()->Packstation));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Postcode',             $address->fieldLabel('Postcode'),           $this->SilvercartShippingAddress()->Postcode));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__City',                 $address->fieldLabel('City'),               $this->SilvercartShippingAddress()->City));
        $fields->addFieldToTab('Root.ShippingAddressTab', new DropdownField('sa__Country',          $address->fieldLabel('Country'),            SilvercartCountry::get_active()->map()->toArray(), $this->SilvercartShippingAddress()->SilvercartCountry()->ID));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__PhoneAreaCode',        $address->fieldLabel('PhoneAreaCode'),      $this->SilvercartShippingAddress()->PhoneAreaCode));
        $fields->addFieldToTab('Root.ShippingAddressTab', new TextField('sa__Phone',                $address->fieldLabel('Phone'),              $this->SilvercartShippingAddress()->Phone));
            
        $fields->addFieldToTab('Root.InvoiceAddressTab', new LiteralField('ia__Preview',            '<p>' . Convert::raw2xml($this->getInvoiceAddressSummary(true)) . '</p>'));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__TaxIdNumber',           $address->fieldLabel('TaxIdNumber'),        $this->SilvercartInvoiceAddress()->TaxIdNumber));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Company',               $address->fieldLabel('Company'),            $this->SilvercartInvoiceAddress()->Company));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__FirstName',             $address->fieldLabel('FirstName'),          $this->SilvercartInvoiceAddress()->FirstName));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Surname',               $address->fieldLabel('Surname'),            $this->SilvercartInvoiceAddress()->Surname));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Addition',              $address->fieldLabel('Addition'),           $this->SilvercartInvoiceAddress()->Addition));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Street',                $address->fieldLabel('Street'),             $this->SilvercartInvoiceAddress()->Street));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__StreetNumber',          $address->fieldLabel('StreetNumber'),       $this->SilvercartInvoiceAddress()->StreetNumber));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new CheckboxField('ia__IsPackstation',     $address->fieldLabel('IsPackstation'),      $this->SilvercartInvoiceAddress()->IsPackstation));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__PostNumber',            $address->fieldLabel('PostNumber'),         $this->SilvercartInvoiceAddress()->PostNumber));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Packstation',           $address->fieldLabel('PackstationPlain'),   $this->SilvercartInvoiceAddress()->Packstation));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Postcode',              $address->fieldLabel('Postcode'),           $this->SilvercartInvoiceAddress()->Postcode));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__City',                  $address->fieldLabel('City'),               $this->SilvercartInvoiceAddress()->City));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new DropdownField('ia__Country',           $address->fieldLabel('Country'),            SilvercartCountry::get_active()->map()->toArray(), $this->SilvercartInvoiceAddress()->SilvercartCountry()->ID));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__PhoneAreaCode',         $address->fieldLabel('PhoneAreaCode'),      $this->SilvercartInvoiceAddress()->PhoneAreaCode));
        $fields->addFieldToTab('Root.InvoiceAddressTab', new TextField('ia__Phone',                 $address->fieldLabel('Phone'),              $this->SilvercartInvoiceAddress()->Phone));
        
        //add print preview
        $fields->findOrMakeTab('Root.PrintPreviewTab',    $this->fieldLabel('PrintPreview'));
        $printPreviewField = new LiteralField(
                'PrintPreviewField',
                sprintf(
                    '<iframe width="100%%" height="100%%" border="0" src="%s" class="print-preview"></iframe>',
                    SilvercartPrint::getPrintInlineURL($this)
                )
        );
        $fields->addFieldToTab('Root.PrintPreviewTab', $printPreviewField);
        
        return $fields;
    }
    
    /**
     * Returns the quick access fields to display in GridField
     * 
     * @return FieldList
     */
    public function getQuickAccessFields() {
        $quickAccessFields = new FieldList();
        
        $threeColField = '<div class="multi-col-field"><strong>%s</strong><span>%s</span><span>%s</span></div>';
        $twoColField   = '<div class="multi-col-field"><strong>%s</strong><span></span><span>%s</span></div>';
        
        $orderNumberField   = new TextField('OrderNumber__' . $this->ID,            $this->fieldLabel('OrderNumber'),           $this->OrderNumber);
        $orderStatusField   = new TextField('SilvercartOrderStatus__' . $this->ID,  $this->fieldLabel('SilvercartOrderStatus'), $this->SilvercartOrderStatus()->Title);
        $orderPositionTable = new SilvercartTableField(
                'SilvercartOrderPositions__' . $this->ID,
                $this->fieldLabel('SilvercartOrderPositions'),
                $this->SilvercartOrderPositions()
        );
        $shippingField      = new LiteralField('SilvercartShippingMethod__' . $this->ID,    sprintf($threeColField, $this->fieldLabel('SilvercartShippingMethod'), $this->SilvercartShippingMethod()->TitleWithCarrier, $this->HandlingCostShipmentNice));
        $paymentField       = new LiteralField('SilvercartPaymentMethod__' . $this->ID,     sprintf($threeColField, $this->fieldLabel('SilvercartPaymentMethod'),  $this->SilvercartPaymentMethod()->Title, $this->HandlingCostPaymentNice));
        $amountTotalField   = new LiteralField('AmountTotal__' . $this->ID,                 sprintf($twoColField,   $this->fieldLabel('AmountTotal'), $this->AmountTotalNice));
        
        $orderNumberField->setReadonly(true);
        $orderStatusField->setReadonly(true);
        
        $mainGroup = new SilvercartFieldGroup('MainGroup');
        $mainGroup->push($orderNumberField);
        $mainGroup->push($orderStatusField);
        
        $quickAccessFields->push($mainGroup);
        $quickAccessFields->push($orderPositionTable);
        $quickAccessFields->push($shippingField);
        $quickAccessFields->push($paymentField);
        $quickAccessFields->push($amountTotalField);
        
        $this->extend('updateQuickAccessFields', $quickAccessFields);
        
        return $quickAccessFields;
    }
    
    /**
     * create a invoice address for an order from customers data
     *
     * @param array $registrationData checkout forms submit data; only needed for anonymous customers
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     *         Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 15.11.2014
     */
    public function createInvoiceAddress($registrationData = array()) {
        $member              = SilvercartCustomer::currentUser();
        $orderInvoiceAddress = new SilvercartOrderInvoiceAddress();
        
        if (empty($registrationData)) {
            $addressData = $member->SilvercartInvoiceAddress()->toMap();
            unset($addressData['ID']);
            unset($addressData['ClassName']);
            unset($addressData['RecordClassName']);
            $orderInvoiceAddress->castedUpdate($addressData);
        } else {
            $orderInvoiceAddress->castedUpdate($registrationData);
            $orderInvoiceAddress->SilvercartCountryID = $registrationData['CountryID'];
        }
        $orderInvoiceAddress->write();
        $this->SilvercartInvoiceAddressID = $orderInvoiceAddress->ID;
        
        $this->write();
    }

    /**
     * create a shipping address for an order from customers data
     * writes $this to the database
     *
     * @param array $registrationData checkout forms submit data; only needed for anonymous customers
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     *         Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 15.11.2014
     */
    public function createShippingAddress($registrationData = array()) {
        $member               = SilvercartCustomer::currentUser();
        $orderShippingAddress = new SilvercartOrderShippingAddress();
       
        if (empty($registrationData)) {
            $addressData = $member->SilvercartShippingAddress()->toMap();
            unset($addressData['ID']);
            unset($addressData['ClassName']);
            unset($addressData['RecordClassName']);
            $orderShippingAddress->castedUpdate($addressData);
        } else {
            $orderShippingAddress->castedUpdate($registrationData);
            $orderShippingAddress->SilvercartCountryID = $registrationData['CountryID'];
        }

        $orderShippingAddress->write(); //write here to have an object ID
        $this->SilvercartShippingAddressID = $orderShippingAddress->ID;
       
        $this->write();
    }

    /**
     * creates an order from the cart
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Sascha Koehler <skoehler@pixeltricks.de>
     * @since 15.11.2014
     */
    public function createFromShoppingCart() {
        $member = SilvercartCustomer::currentUser();
        if ($member instanceof Member) {
            $silvercartShoppingCart = $member->getCart();
            $silvercartShoppingCart->setPaymentMethodID($this->SilvercartPaymentMethodID);
            $silvercartShoppingCart->setShippingMethodID($this->SilvercartShippingMethodID);
            $this->MemberID         = $member->ID;

            if (SilvercartPlugin::call($this, 'overwriteCreateFromShoppingCart', array($silvercartShoppingCart))) {
                return true;
            }
            
            $this->extend('onBeforeCreateFromShoppingCart', $silvercartShoppingCart);

            $paymentObj = DataObject::get_by_id(
                'SilvercartPaymentMethod',
                $this->SilvercartPaymentMethodID
            );

            // VAT tax for shipping and payment fees
            $shippingMethod = DataObject::get_by_id('SilvercartShippingMethod', $this->SilvercartShippingMethodID);
            if ($shippingMethod) {
                $shippingFee  = $shippingMethod->getShippingFee();

                if ($shippingFee) {
                    if ($shippingFee->SilvercartTax()) {
                        $this->TaxRateShipment   = $shippingFee->getTaxRate();
                        $this->TaxAmountShipment = $shippingFee->getTaxAmount();
                    }
                }
            }

            $paymentMethod = DataObject::get_by_id('SilvercartPaymentMethod', $this->SilvercartPaymentMethodID);
            if ($paymentMethod) {
                $paymentFee = $paymentMethod->getHandlingCost();

                if ($paymentFee) {
                    if ($paymentFee->SilvercartTax()) {
                        $this->TaxRatePayment   = $paymentFee->SilvercartTax()->getTaxRate();
                        $this->TaxAmountPayment = $paymentFee->getTaxAmount();
                    }
                    $this->HandlingCostPayment->setAmount($paymentFee->amount->getAmount());
                    $this->HandlingCostPayment->setCurrency($paymentFee->amount->getCurrency());
                }
            }

            // amount of all positions + handling fee of the payment method + shipping fee
            $totalAmount = $member->getCart()->getAmountTotal()->getAmount();

            $this->AmountTotal->setAmount(
                $totalAmount
            );
            $this->AmountTotal->setCurrency(SilvercartConfig::DefaultCurrency());

            $this->PriceType = $member->getPriceType();

            // adjust orders standard status
            $orderStatus = SilvercartOrderStatus::get()->filter('Code', $paymentObj->getDefaultOrderStatus())->first();
            if ($orderStatus) {
                $this->SilvercartOrderStatusID = $orderStatus->ID;
            }

            // write order to have an id
            $this->write();
            
            $this->extend('onAfterCreateFromShoppingCart', $silvercartShoppingCart);

            SilvercartPlugin::call($this, 'createFromShoppingCart', array($this, $silvercartShoppingCart));
        }
    }

    /**
     * convert cart positions in order positions
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Sascha Koehler <skoehler@pixeltricks.de>
     * @since 15.11.2014
     */
    public function convertShoppingCartPositionsToOrderPositions() {
        if ($this->extend('updateConvertShoppingCartPositionsToOrderPositions')) {
            return true;
        }
        
        $member = SilvercartCustomer::currentUser();
        if ($member instanceof Member) {
            $silvercartShoppingCart = $member->getCart();
            $silvercartShoppingCart->setPaymentMethodID($this->SilvercartPaymentMethodID);
            $silvercartShoppingCart->setShippingMethodID($this->SilvercartShippingMethodID);
            $shoppingCartPositions = SilvercartShoppingCartPosition::get()->filter('SilvercartShoppingCartID', $member->SilvercartShoppingCartID);

            if ($shoppingCartPositions->exists()) {
                foreach ($shoppingCartPositions as $shoppingCartPosition) {
                    $product = $shoppingCartPosition->SilvercartProduct();

                    if ($product) {
                        $orderPosition = new SilvercartOrderPosition();
                        $orderPosition->objectCreated = true;
                        $orderPosition->Price->setAmount($shoppingCartPosition->getPrice(true)->getAmount());
                        $orderPosition->Price->setCurrency($shoppingCartPosition->getPrice(true)->getCurrency());
                        $orderPosition->PriceTotal->setAmount($shoppingCartPosition->getPrice()->getAmount());
                        $orderPosition->PriceTotal->setCurrency($shoppingCartPosition->getPrice()->getCurrency());
                        $orderPosition->Tax                     = $shoppingCartPosition->getTaxAmount(true);
                        $orderPosition->TaxTotal                = $shoppingCartPosition->getTaxAmount();
                        $orderPosition->TaxRate                 = $product->getTaxRate();
                        $orderPosition->ProductDescription      = $product->LongDescription;
                        $orderPosition->Quantity                = $shoppingCartPosition->Quantity;
                        $orderPosition->numberOfDecimalPlaces   = $product->SilvercartQuantityUnit()->numberOfDecimalPlaces;
                        $orderPosition->ProductNumber           = $shoppingCartPosition->getProductNumberShop();
                        $orderPosition->Title                   = $product->Title;
                        $orderPosition->SilvercartOrderID       = $this->ID;
                        $orderPosition->IsNonTaxable            = $member->doesNotHaveToPayTaxes();
                        $orderPosition->SilvercartProductID     = $product->ID;
                        $orderPosition->log                     = false;
                        $this->extend('onBeforeConvertSingleShoppingCartPositionToOrderPosition', $shoppingCartPosition, $orderPosition);
                        $orderPosition->write();

                        // Call hook method on product if available
                        if ($product->hasMethod('ShoppingCartConvert')) {
                            $product->ShoppingCartConvert($this, $orderPosition);
                        }
                        // decrement stock quantity of the product
                        if (SilvercartConfig::EnableStockManagement()) {
                            $product->decrementStockQuantity($shoppingCartPosition->Quantity);
                        }

                        $this->extend('onAfterConvertSingleShoppingCartPositionToOrderPosition', $shoppingCartPosition, $orderPosition);
                        $result = SilvercartPlugin::call($this, 'convertShoppingCartPositionToOrderPosition', array($shoppingCartPosition, $orderPosition), true, array());

                        if (!empty($result)) {
                            $orderPosition = $result[0];
                        }

                        $orderPosition->write();
                        unset($orderPosition);
                    }
                }

                // Get taxable positions from registered modules
                $registeredModules = $member->getCart()->callMethodOnRegisteredModules(
                    'ShoppingCartPositions',
                    array(
                        $member->getCart(),
                        $member,
                        true
                    )
                );

                foreach ($registeredModules as $moduleName => $moduleOutput) {
                    foreach ($moduleOutput as $modulePosition) {
                        $orderPosition = new SilvercartOrderPosition();
                        if ($this->IsPriceTypeGross()) {
                            if ($modulePosition->Price instanceof Money) {
                                $price = $modulePosition->Price->getAmount();
                            } else {
                                $price = $modulePosition->Price;
                            }
                            $orderPosition->Price->setAmount($price);
                        } else {
                            if ($modulePosition->Price instanceof Money) {
                                $price = $modulePosition->PriceNet->getAmount();
                            } else {
                                $price = $modulePosition->PriceNet;
                            }
                            $orderPosition->Price->setAmount($price);
                        }
                        $orderPosition->Price->setCurrency($modulePosition->Currency);
                        if ($this->IsPriceTypeGross()) {
                            $orderPosition->PriceTotal->setAmount($modulePosition->PriceTotal);
                        } else {
                            $orderPosition->PriceTotal->setAmount($modulePosition->PriceNetTotal);
                        }
                        $orderPosition->PriceTotal->setCurrency($modulePosition->Currency);
                        $orderPosition->Tax                 = 0;
                        $orderPosition->TaxTotal            = $modulePosition->TaxAmount;
                        $orderPosition->TaxRate             = $modulePosition->TaxRate;
                        $orderPosition->ProductDescription  = $modulePosition->LongDescription;
                        $orderPosition->Quantity            = $modulePosition->Quantity;
                        $orderPosition->Title               = $modulePosition->Name;
                        if ($modulePosition->isChargeOrDiscount) {
                            $orderPosition->isChargeOrDiscount                  = true;
                            $orderPosition->chargeOrDiscountModificationImpact  = $modulePosition->chargeOrDiscountModificationImpact;
                        }
                        $orderPosition->SilvercartOrderID   = $this->ID;
                        $orderPosition->write();
                        unset($orderPosition);
                    }
                }

                // Get charges and discounts for product values
                if ($silvercartShoppingCart->HasChargesAndDiscountsForProducts()) {
                    $chargesAndDiscountsForProducts = $silvercartShoppingCart->ChargesAndDiscountsForProducts();

                    foreach ($chargesAndDiscountsForProducts as $chargeAndDiscountForProduct) {
                        $orderPosition = new SilvercartOrderPosition();
                        $orderPosition->Price->setAmount($chargeAndDiscountForProduct->Price->getAmount());
                        $orderPosition->Price->setCurrency($chargeAndDiscountForProduct->Price->getCurrency());
                        $orderPosition->PriceTotal->setAmount($chargeAndDiscountForProduct->Price->getAmount());
                        $orderPosition->PriceTotal->setCurrency($chargeAndDiscountForProduct->Price->getCurrency());
                        $orderPosition->isChargeOrDiscount = true;
                        $orderPosition->chargeOrDiscountModificationImpact = $chargeAndDiscountForProduct->sumModificationImpact;
                        $orderPosition->Tax                 = $chargeAndDiscountForProduct->SilvercartTax->Title;

                        if ($this->IsPriceTypeGross()) {
                            $orderPosition->TaxTotal = $chargeAndDiscountForProduct->Price->getAmount() - ($chargeAndDiscountForProduct->Price->getAmount() / (100 + $chargeAndDiscountForProduct->SilvercartTax->Rate) * 100);
                        } else {
                            $orderPosition->TaxTotal = ($chargeAndDiscountForProduct->Price->getAmount() / 100 * (100 + $chargeAndDiscountForProduct->SilvercartTax->Rate)) - $chargeAndDiscountForProduct->Price->getAmount();
                        }

                        $orderPosition->TaxRate             = $chargeAndDiscountForProduct->SilvercartTax->Rate;
                        $orderPosition->ProductDescription  = $chargeAndDiscountForProduct->Name;
                        $orderPosition->Quantity            = 1;
                        $orderPosition->ProductNumber       = $chargeAndDiscountForProduct->sumModificationProductNumber;
                        $orderPosition->Title               = $chargeAndDiscountForProduct->Name;
                        $orderPosition->SilvercartOrderID   = $this->ID;
                        $orderPosition->write();
                        unset($orderPosition);
                    }
                }

                // Get nontaxable positions from registered modules
                $registeredModulesNonTaxablePositions = $member->getCart()->callMethodOnRegisteredModules(
                    'ShoppingCartPositions',
                    array(
                        $member->getCart(),
                        $member,
                        false
                    )
                );

                foreach ($registeredModulesNonTaxablePositions as $moduleName => $moduleOutput) {
                    foreach ($moduleOutput as $modulePosition) {
                        $orderPosition = new SilvercartOrderPosition();
                        if ($this->IsPriceTypeGross()) {
                            $orderPosition->Price->setAmount($modulePosition->Price);
                        } else {
                            $orderPosition->Price->setAmount($modulePosition->PriceNet);
                        }
                        $orderPosition->Price->setCurrency($modulePosition->Currency);
                        if ($this->IsPriceTypeGross()) {
                            $orderPosition->PriceTotal->setAmount($modulePosition->PriceTotal);
                        } else {
                            $orderPosition->PriceTotal->setAmount($modulePosition->PriceNetTotal);
                        }
                        $orderPosition->PriceTotal->setCurrency($modulePosition->Currency);
                        $orderPosition->Tax                 = 0;
                        $orderPosition->TaxTotal            = $modulePosition->TaxAmount;
                        $orderPosition->TaxRate             = $modulePosition->TaxRate;
                        $orderPosition->ProductDescription  = $modulePosition->LongDescription;
                        $orderPosition->Quantity            = $modulePosition->Quantity;
                        $orderPosition->Title               = $modulePosition->Name;
                        $orderPosition->SilvercartOrderID   = $this->ID;
                        $orderPosition->write();
                        unset($orderPosition);
                    }
                }

                // Get charges and discounts for shopping cart total
                if ($silvercartShoppingCart->HasChargesAndDiscountsForTotal()) {
                    $chargesAndDiscountsForTotal = $silvercartShoppingCart->ChargesAndDiscountsForTotal();

                    foreach ($chargesAndDiscountsForTotal as $chargeAndDiscountForTotal) {
                        $orderPosition = new SilvercartOrderPosition();
                        $orderPosition->Price->setAmount($chargeAndDiscountForTotal->Price->getAmount());
                        $orderPosition->Price->setCurrency($chargeAndDiscountForTotal->Price->getCurrency());
                        $orderPosition->PriceTotal->setAmount($chargeAndDiscountForTotal->Price->getAmount());
                        $orderPosition->PriceTotal->setCurrency($chargeAndDiscountForTotal->Price->getCurrency());
                        $orderPosition->isChargeOrDiscount = true;
                        $orderPosition->chargeOrDiscountModificationImpact = $chargeAndDiscountForTotal->sumModificationImpact;
                        $orderPosition->Tax                 = $chargeAndDiscountForTotal->SilvercartTax->Title;
                        if ($this->IsPriceTypeGross()) {
                            $orderPosition->TaxTotal = $chargeAndDiscountForTotal->Price->getAmount() - ($chargeAndDiscountForTotal->Price->getAmount() / (100 + $chargeAndDiscountForTotal->SilvercartTax->Rate) * 100);
                        } else {
                            $orderPosition->TaxTotal = ($chargeAndDiscountForTotal->Price->getAmount() / 100 * (100 + $chargeAndDiscountForTotal->SilvercartTax->Rate)) - $chargeAndDiscountForTotal->Price->getAmount();
                        }
                        $orderPosition->TaxRate             = $chargeAndDiscountForTotal->SilvercartTax->Rate;
                        $orderPosition->ProductDescription  = $chargeAndDiscountForTotal->Name;
                        $orderPosition->Quantity            = 1;
                        $orderPosition->ProductNumber       = $chargeAndDiscountForTotal->sumModificationProductNumber;
                        $orderPosition->Title               = $chargeAndDiscountForTotal->Name;
                        $orderPosition->SilvercartOrderID   = $this->ID;
                        $orderPosition->write();
                        unset($orderPosition);
                    }
                }

                // Convert positions of registered modules
                $member->getCart()->callMethodOnRegisteredModules(
                    'ShoppingCartConvert',
                    array(
                        SilvercartCustomer::currentUser()->getCart(),
                        SilvercartCustomer::currentUser(),
                        $this
                    )
                );
                
                $this->extend('onAfterConvertShoppingCartPositionsToOrderPositions', $silvercartShoppingCart);

                // Delete the shoppingcart positions
                foreach ($shoppingCartPositions as $shoppingCartPosition) {
                    $shoppingCartPosition->delete();
                }
            
                $this->write();
            }
            SilvercartPlugin::call($this, 'convertShoppingCartPositionsToOrderPositions', array($this), true);
        }
    }

    /**
     * save order to db
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 22.11.2010
     */
    public function save() {
        $this->write();
    }

    /**
     * set payment method for $this
     *
     * @param int $paymentMethodID id of payment method
     *
     * @return void
     */
    public function setPaymentMethod($paymentMethodID) {
        $paymentMethodObj = DataObject::get_by_id(
                        'SilvercartPaymentMethod',
                        $paymentMethodID
        );

        if ($paymentMethodObj) {
            $this->SilvercartPaymentMethodID = $paymentMethodObj->ID;
            $this->HandlingCostPayment->setAmount($paymentMethodObj->getHandlingCost()->amount->getAmount());
            $this->HandlingCostPayment->setCurrency(SilvercartConfig::DefaultCurrency());
        }
    }

    /**
     * set status of $this
     *
     * @param SilvercartOrderStatus $orderStatus the order status object
     *
     * @return bool
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 22.11.2010
     */
    public function setOrderStatus($orderStatus) {
        $orderStatusSet = false;

        if ($orderStatus && $orderStatus->exists()) {
            $this->SilvercartOrderStatusID = $orderStatus->ID;
            $this->write();
            $orderStatusSet = true;
        }

        return $orderStatusSet;
    }

    /**
     * set status of $this
     *
     * @param int $orderStatusID the order status ID
     *
     * @return bool
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.04.2011
     */
    public function setOrderStatusByID($orderStatusID) {
        $orderStatusSet = false;

        if (SilvercartOrderStatus::get()->filter('ID', $orderStatusID)->exists()) {
            $this->SilvercartOrderStatusID = $orderStatusID;
            $this->write();
            $orderStatusSet = true;
        }

        return $orderStatusSet;
    }

    /**
     * Save the note from the form if there is one
     *
     * @param string $note the customers notice
     *
     * @return void
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 16.12.10
     */
    public function setNote($note) {
        $this->setField('Note', $note);
    }

    /**
     * getter
     *
     * @return string
     *
     */
    public function getFormattedNote() {
        $note = $this->Note;
        $note = str_replace(
            '\r\n',
            '<br />',
            $note
        );

        return $note;
    }

    /**
     * save the carts weight
     *
     * @return void
     */
    public function setWeight() {
        $member = SilvercartCustomer::currentUser();
        if ($member instanceof Member &&
            $member->getCart()->getWeightTotal()) {
            $this->WeightTotal = $member->getCart()->getWeightTotal();
        }
    }

    /**
     * set the total price for this order
     *
     * @return void
     */
    public function setAmountTotal() {
        $member = SilvercartCustomer::currentUser();

        if ($member && $member->getCart()) {
            $this->AmountTotal = $member->getCart()->getAmountTotal();
        }
    }

    /**
     * set the email for this order
     *
     * @param string $email the email address of the customer
     *
     * @return void
     */
    public function setCustomerEmail($email = null) {
        $member = SilvercartCustomer::currentUser();
        if ($member instanceof Member &&
            $member->Email) {
            $email = $member->Email;
        }
        $this->CustomersEmail = $email;
    }
    
    /**
     * Set the status of the revocation instructions checkbox field.
     *
     * @param boolean $status The status of the field
     * 
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 12.10.2011
     */
    public function setHasAcceptedRevocationInstruction($status) {
        if ($status == 1) {
            $status = true;
        }
        
        $this->setField('HasAcceptedRevocationInstruction', $status);
    }
    
    /**
     * Set the status of the terms and conditions checkbox field.
     *
     * @param boolean $status The status of the field
     * 
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 12.10.2011
     */
    public function setHasAcceptedTermsAndConditions($status) {
        if ($status == 1) {
            $status = true;
        }
        
        $this->setField('HasAcceptedTermsAndConditions', $status);
    }

    /**
     * The shipping method is a relation + an attribte of the order
     *
     * @param int $shippingMethodID the ID of the shipping method
     *
     * @return void
     */
    public function setShippingMethod($shippingMethodID) {
        $selectedShippingMethod = DataObject::get_by_id(
            'SilvercartShippingMethod',
            $shippingMethodID
        );

        if ($selectedShippingMethod instanceof SilvercartShippingMethod &&
            $selectedShippingMethod->getShippingFee() instanceof SilvercartShippingFee) {
            $this->SilvercartShippingMethodID    = $selectedShippingMethod->ID;
            $this->SilvercartShippingFeeID       = $selectedShippingMethod->getShippingFee()->ID;
            $this->HandlingCostShipment->setAmount($selectedShippingMethod->getShippingFee()->getPriceAmount());
            $this->HandlingCostShipment->setCurrency(SilvercartConfig::DefaultCurrency());
        }
    }

    /**
     * returns tax included in $this
     *
     * @return float
     */
    public function getTax() {
        $tax = 0.0;

        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            $tax += $orderPosition->TaxTotal;
        }

        $taxObj = new Money('Tax');
        $taxObj->setAmount($tax);
        $taxObj->setCurrency(SilvercartConfig::DefaultCurrency());

        return $taxObj;
    }

    /**
     * returns bills currency
     * 
     * @return string
     */
    public function getCurrency() {
        return $this->AmountTotal->getCurrency();
    }
    
    /**
     * Returns the Order Positions as a string.
     * 
     * @param bool $asHtmlString    Set to true to use HTML inside the string.
     * @param bool $withAmountTotal Set to true add the orders total amount.
     * 
     * @return string
     */
    public function getPositionsAsString($asHtmlString = false, $withAmountTotal = false) {
        if ($asHtmlString) {
            $seperator = '<br/>';
        } else {
            $seperator = PHP_EOL;
        }
        $positionsStrings = array();
        foreach ($this->SilvercartOrderPositions() as $position) {
            $positionsString = $position->getTypeSafeQuantity() . 'x #' . $position->ProductNumber . ' "' . $position->Title . '" ' . $position->getPriceTotalNice();
            $positionsStrings[] = $positionsString;
        }
        $positionsAsString = implode($seperator . '------------------------' . $seperator, $positionsStrings);
        if ($withAmountTotal) {
            $shipmentAndPayment = new Money();
            $shipmentAndPayment->setAmount($this->HandlingCostPayment->getAmount() + $this->HandlingCostShipment->getAmount());
            $shipmentAndPayment->setCurrency($this->HandlingCostPayment->getCurrency());
            
            $positionsAsString .= $seperator . '------------------------' . $seperator;
            $positionsAsString .= $this->fieldLabel('HandlingCost') . ': ' . $shipmentAndPayment->Nice() . $seperator;
            $positionsAsString .= '________________________' . $seperator . $seperator;
            $positionsAsString .= $this->fieldLabel('AmountTotal') . ': ' . $this->AmountTotal->Nice();
        }
        return $positionsAsString;
    }
    
    /**
     * Returns the gross amount of all order positions.
     * 
     * @return Money
     */
    public function getPositionsPriceGross() {
        $positionsPriceGross = $this->AmountTotal->getAmount() - ($this->HandlingCostShipment->getAmount() + $this->HandlingCostPayment->getAmount());

        $positionsPriceGrossObj = new Money();
        $positionsPriceGrossObj->setAmount($positionsPriceGross);
        $positionsPriceGrossObj->setCurrency(SilvercartConfig::DefaultCurrency());
        
        return $positionsPriceGrossObj;
    }

    /**
     * Returns the net amount of all order positions.
     *
     * @return Money
     */
    public function getPositionsPriceNet() {
        $priceNet = $this->getPositionsPriceGross()->getAmount() - $this->getTax(true,true,true)->getAmount();

        $priceNetObj = new Money();
        $priceNetObj->setAmount($priceNet);
        $priceNetObj->setCurrency(SilvercartConfig::DefaultCurrency());
        
        return $priceNetObj;
    }

    /**
     * Returns the net amount of all order positions.
     *
     * @return Money
     * 
     * @deprecated
     */
    public function getPriceNet() {
        return $this->getPositionsPriceNet();
    }

    /**
     * Returns the gross amount of the order.
     *
     * @return Money
     */
    public function getPriceGross() {
        return $this->AmountTotal;
    }
    
    /**
     * Returns all order positions without a tax value.
     * 
     * @return ArrayList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 16.12.2011
     */
    public function SilvercartOrderPositionsWithoutTax() {
        $orderPositions = new ArrayList();
        
        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if (!$orderPosition->isChargeOrDiscount &&
                 $orderPosition->TaxRate == 0) {
                
                $orderPositions->push($orderPosition);
            }
        }
        
        return $orderPositions;
    }

    /**
     * Returns all SilvercartOrderPositions that are included in the total
     * price.
     *
     * @return mixed ArrayList
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.03.2013
     */
    public function SilvercartOrderIncludedInTotalPositions() {
        $positions = new ArrayList();

        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if ($orderPosition->isIncludedInTotal) {
                $positions->push($orderPosition);
            }
        }

        return $positions;
    }

    /**
     * Returns all regular order positions.
     *
     * @return ArrayList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>,
     *         Ramon Kupper <rkupper@pixeltricks.de>
     * @since 16.11.2013
     */
    public function SilvercartOrderListPositions() {
        $orderPositions = new ArrayList();
        
        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if (!$orderPosition->isChargeOrDiscount) {
                
                $orderPositions->push($orderPosition);
            }
        }
        
        return $orderPositions;
    }
    
    /**
     * Returns all order positions that contain charges and discounts for the 
     * shopping cart value.
     *
     * @return ArrayList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 16.12.2011
     */
    public function SilvercartOrderChargePositionsTotal() {
        $chargePositions = new ArrayList();
        
        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if ($orderPosition->isChargeOrDiscount &&
                $orderPosition->chargeOrDiscountModificationImpact == 'totalValue') {
                
                $chargePositions->push($orderPosition);
            }
        }
        
        return $chargePositions;
    }
    
    /**
     * Returns all order positions that contain charges and discounts for
     * product values.
     *
     * @return ArrayList
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 16.12.2011
     */
    public function SilvercartOrderChargePositionsProduct() {
        $chargePositions = new ArrayList();
        
        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if ($orderPosition->isChargeOrDiscount &&
                $orderPosition->chargeOrDiscountModificationImpact == 'productValue') {
                
                $chargePositions->push($orderPosition);
            }
        }
        
        return $chargePositions;
    }

    /**
     * returns the orders taxable amount without fees as string incl. currency.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     *
     * @return string
     */
    public function getTaxableAmountWithoutFeesNice($includeChargesForProducts = false, $includeChargesForTotal = false) {
        $taxableAmountWithoutFees = $this->getTaxableAmountWithoutFees($includeChargesForProducts, $includeChargesForTotal);
        return str_replace('.', ',', number_format($taxableAmountWithoutFees->Amount->getAmount(), 2)) . ' ' . $this->AmountTotal->getCurrency();
    }

    /**
     * Returns the order value of all positions with a tax rate > 0 without any
     * fees and charges.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return Money
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.09.2012
     */
    public function getTaxableAmountWithoutFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        $taxableAmountWithoutFees = null;
        if ($this->IsPriceTypeGross()) {
            $taxableAmountWithoutFees = $this->getTaxableAmountGrossWithoutFees($includeChargesForProducts, $includeChargesForTotal);
        } else {
            $taxableAmountWithoutFees = $this->getTaxableAmountNetWithoutFees($includeChargesForProducts, $includeChargesForTotal);
        }
        return $taxableAmountWithoutFees;
    }
    
    /**
     * Returns the order value of all positions with a tax rate > 0 without any
     * fees and charges.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return Money
     */
    public function getTaxableAmountGrossWithoutFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        $priceGross = new Money();
        $priceGross->setAmount(0);
        $priceGross->setCurrency(SilvercartConfig::DefaultCurrency());
        
        if ($includeChargesForTotal == 'false') {
            $includeChargesForTotal = false;
        }
        if ($includeChargesForProducts == 'false') {
            $includeChargesForProducts = false;
        }
        
        foreach ($this->SilvercartOrderPositions() as $position) {
            if ((
                    !$includeChargesForProducts &&
                     $position->isChargeOrDiscount &&
                     $position->chargeOrDiscountModificationImpact == 'productValue'
                ) || (
                    !$includeChargesForTotal &&
                     $position->isChargeOrDiscount &&
                     $position->chargeOrDiscountModificationImpact == 'totalValue'
                )
               ) {
                continue;
            }
            
            if ($position->TaxRate > 0 ||
                $position->IsNonTaxable) {
                $priceGross->setAmount(
                    $priceGross->getAmount() + $position->PriceTotal->getAmount()
                );
            }
        }
        
        return new DataObject(
            array(
                'Amount' => $priceGross
            )
        );
    }

    /**
     * Returns the order value of all positions with a tax rate > 0 without any
     * fees and charges.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return Money
     */
    public function getTaxableAmountNetWithoutFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        $priceNet = new Money();
        $priceNet->setAmount(0);
        $priceNet->setCurrency(SilvercartConfig::DefaultCurrency());
        
        if ($includeChargesForTotal == 'false') {
            $includeChargesForTotal = false;
        }
        if ($includeChargesForProducts == 'false') {
            $includeChargesForProducts = false;
        }
        
        foreach ($this->SilvercartOrderPositions() as $position) {
            if ((
                    !$includeChargesForProducts &&
                     $position->isChargeOrDiscount &&
                     $position->chargeOrDiscountModificationImpact == 'productValue'
                ) || (
                    !$includeChargesForTotal &&
                     $position->isChargeOrDiscount &&
                     $position->chargeOrDiscountModificationImpact == 'totalValue'
                )
               ) {
                continue;
            }
            
            if ($position->TaxRate > 0 ||
                $position->IsNonTaxable) {
                $priceNet->setAmount(
                    $priceNet->getAmount() + $position->PriceTotal->getAmount()
                );
            }
        }
        
        return new DataObject(
            array(
                'Amount' => $priceNet
            )
        );
    }

    /**
     * returns the orders taxable amount with fees as string incl. currency.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     *
     * @return string
     */
    public function getTaxableAmountWithFeesNice($includeChargesForProducts = false, $includeChargesForTotal = false) {
        $taxableAmountWithFees = $this->getTaxableAmountWithFees($includeChargesForProducts, $includeChargesForTotal);
        return str_replace('.', ',', number_format($taxableAmountWithFees->Amount->getAmount(), 2)) . ' ' . $this->AmountTotal->getCurrency();
    }

    /**
     * Returns the order value of all positions with a tax rate > 0 without any
     * charges.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return Money
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.09.2012
     */
    public function getTaxableAmountWithFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        $taxableAmountWithFees = 0;
        if ($this->IsPriceTypeGross()) {
            $taxableAmountWithFees = $this->getTaxableAmountGrossWithFees($includeChargesForProducts, $includeChargesForTotal);
        } else {
            $taxableAmountWithFees = $this->getTaxableAmountNetWithFees($includeChargesForProducts, $includeChargesForTotal);
        }
        return $taxableAmountWithFees;
    }

    /**
     * Returns the order value of all positions with a tax rate > 0 without any
     * charges.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return Money
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.09.2012
     */
    public function getTaxableAmountGrossWithFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        if ($includeChargesForTotal == 'false') {
            $includeChargesForTotal = false;
        }
        if ($includeChargesForProducts == 'false') {
            $includeChargesForProducts = false;
        }
        
        $priceGross = $this->getTaxableAmountGrossWithoutFees($includeChargesForProducts, $includeChargesForTotal)->Amount;
        
        $priceGross->setAmount(
            $priceGross->getAmount() +
            $this->HandlingCostPayment->getAmount()
        );

        $priceGross->setAmount(
            $priceGross->getAmount() +
            $this->HandlingCostShipment->getAmount()
        );
        
        return new DataObject(
            array(
                'Amount' => $priceGross
            )
        );
    }
    
    /**
     * Returns the order value of all positions with a tax rate > 0 without any
     * charges.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return Money
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 21.09.2012
     */
    public function getTaxableAmountNetWithFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        if ($includeChargesForTotal == 'false') {
            $includeChargesForTotal = false;
        }
        if ($includeChargesForProducts == 'false') {
            $includeChargesForProducts = false;
        }
        
        $priceGross = $this->getTaxableAmountNetWithoutFees($includeChargesForProducts, $includeChargesForTotal)->Amount;
        
        $priceGross->setAmount(
            $priceGross->getAmount() +
            $this->HandlingCostPayment->getAmount()
        );

        $priceGross->setAmount(
            $priceGross->getAmount() +
            $this->HandlingCostShipment->getAmount()
        );
        
        return new DataObject(
            array(
                'Amount' => $priceGross
            )
        );
    }

    /**
     * Returns the sum of tax amounts grouped by tax rates for the products
     * of the order.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return ArrayList
     */
    public function getTaxRatesWithoutFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        if ($includeChargesForTotal === 'false') {
            $includeChargesForTotal = false;
        }
        if ($includeChargesForProducts === 'false') {
            $includeChargesForProducts = false;
        }
        
        $taxes = new ArrayList();
        
        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if ((
                    !$includeChargesForProducts &&
                     $orderPosition->isChargeOrDiscount &&
                     $orderPosition->chargeOrDiscountModificationImpact == 'productValue'
                ) || (
                    !$includeChargesForTotal &&
                     $orderPosition->isChargeOrDiscount &&
                     $orderPosition->chargeOrDiscountModificationImpact == 'totalValue'
                )
               ) {
                continue;
            }
            
            $taxRate = $orderPosition->TaxRate;
            if ($taxRate == '') {
                $taxRate = 0;
            }
            if ($taxRate >= 0 &&
                !$taxes->find('Rate', $taxRate)) {
                
                $taxes->push(
                    new DataObject(
                        array(
                            'Rate'      => $taxRate,
                            'AmountRaw' => 0.0,
                        )
                    )
                );
            }
            $taxSection = $taxes->find('Rate', $taxRate);
            $taxSection->AmountRaw += $orderPosition->TaxTotal;
        }

        foreach ($taxes as $tax) {
            $taxObj = new Money;
            $taxObj->setAmount($tax->AmountRaw);
            $taxObj->setCurrency(SilvercartConfig::DefaultCurrency());

            $tax->Amount = $taxObj;
        }
        
        return $taxes;
    }

    /**
     * Returns the total amount of all taxes.
     *
     * @param boolean $excludeCharges Indicates wether to exlude charges and discounts
     *
     * @return Money a price amount
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.09.2012
     */
    public function getTaxTotal($excludeCharges = false) {
        $taxRates = $this->getTaxRatesWithFees(true, false);

        if (!$excludeCharges &&
             $this->HasChargePositionsForTotal()) {

            foreach ($this->SilvercartOrderChargePositionsTotal() as $charge) {
                $taxRate = $taxRates->find('Rate', $charge->TaxRate);

                if ($taxRate) {
                    $taxRateAmount   = $taxRate->Amount->getAmount();
                    $chargeTaxAmount = $charge->TaxTotal;
                    $taxRate->Amount->setAmount($taxRateAmount + $chargeTaxAmount);

                    if (round($taxRate->Amount->getAmount(), 2) === -0.00) {
                        $taxRate->Amount->setAmount(0);
                    }
                }
            }
        }

        $this->extend('updateTaxTotal', $taxRates);

        return $taxRates;
    }
    
    /**
     * Returns the tax total amount
     * 
     * @param bool $excludeCharges Exclude charges?
     * 
     * @return float
     */
    public function getTaxTotalAmount($excludeCharges = false) {
        $amount   = 0;
        $taxRates = $this->getTaxTotal($excludeCharges);
        foreach ($taxRates as $taxRate) {
            $amount += $taxRate->Amount->getAmount();
        }
        return round($amount, 2);
    }
    
    /**
     * Returns the sum of tax amounts grouped by tax rates for the products
     * of the order.
     *
     * @param boolean $includeChargesForProducts Indicates wether to include charges and
     *                                           discounts for products
     * @param boolean $includeChargesForTotal    Indicates wether to include charges and
     *                                           discounts for the shopping cart total
     * 
     * @return ArrayList
     */
    public function getTaxRatesWithFees($includeChargesForProducts = false, $includeChargesForTotal = false) {
        if ($includeChargesForTotal === 'false') {
            $includeChargesForTotal = false;
        }
        if ($includeChargesForProducts === 'false') {
            $includeChargesForProducts = false;
        }
        
        $taxes = $this->getTaxRatesWithoutFees($includeChargesForProducts, $includeChargesForTotal);
        
        // Shipping cost tax
        $taxRate = $this->TaxRateShipment;
        if ($taxRate == '') {
            $taxRate = 0;
        }
        if ($taxRate >= 0 &&
            !$taxes->find('Rate', $taxRate)) {

            $taxes->push(
                new DataObject(
                    array(
                        'Rate'      => $taxRate,
                        'AmountRaw' => 0.0,
                    )
                )
            );
        }
        $taxSection = $taxes->find('Rate', $taxRate);
        $taxSection->AmountRaw += $this->TaxAmountShipment;

        // Payment cost tax
        $taxRate = $this->TaxRatePayment;
        if ($taxRate == '') {
            $taxRate = 0;
        }
        if ($taxRate >= 0 &&
            !$taxes->find('Rate', $taxRate)) {

            $taxes->push(
                new DataObject(
                    array(
                        'Rate'      => $taxRate,
                        'AmountRaw' => 0.0,
                    )
                )
            );
        }
        $taxSection = $taxes->find('Rate', $taxRate);
        $taxSection->AmountRaw += $this->TaxAmountPayment;

        foreach ($taxes as $tax) {
            $taxObj = new Money;
            $taxObj->setAmount($tax->AmountRaw);
            $taxObj->setCurrency(SilvercartConfig::DefaultCurrency());

            $tax->Amount = $taxObj;
        }
        
        return $taxes;
    }

    /**
     * returns quantity of all products of the order
     *
     * @param int $productId if set only product quantity of this product is returned
     *
     * @return int
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 29.11.10
     */
    public function getQuantity($productId = null) {
        $positions = $this->SilvercartOrderPositions();
        $quantity = 0;

        foreach ($positions as $position) {
            if ($productId === null ||
                    $position->SilvercartProduct()->ID === $productId) {

                $quantity += $position->Quantity;
            }
        }

        return $quantity;
    }
    
    /**
     * Returns plugin output.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 28.09.2011
     */
    public function OrderDetailInformation() {
        return SilvercartPlugin::call($this, 'OrderDetailInformation', array($this));
    }

    /**
     * Returns the order positions, shipping method, payment method etc. as
     * HTML table.
     * 
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 25.01.2012
     */
    public function OrderDetailTable() {
        $viewableData = new ViewableData();
        $template     = '';

        if ($this->IsPriceTypeGross()) {
            $template = $viewableData->customise($this)->renderWith('SilvercartOrderDetailsGross');
        } else {
            $template = $viewableData->customise($this)->renderWith('SilvercartOrderDetailsNet');
        }

        return $template;
    }
    
    /**
     * Indicates wether there are positions that are charges or discounts for
     * the product value.
     *
     * @return boolean
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 19.12.2011
     */
    public function HasChargePositionsForProduct() {
        $hasChargePositionsForProduct = false;

        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if ($orderPosition->isChargeOrDiscount &&
                $orderPosition->chargeOrDiscountModificationImpact == 'productValue') {

                $hasChargePositionsForProduct = true;
            }
        }
        
        return $hasChargePositionsForProduct;
    }
    
    /**
     * Indicates wether there are positions that are charges or discounts for
     * the product value.
     *
     * @return boolean
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 19.12.2011
     */
    public function HasChargePositionsForTotal() {
        $hasChargePositionsForTotal = false;

        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            if ($orderPosition->isChargeOrDiscount &&
                $orderPosition->chargeOrDiscountModificationImpact == 'totalValue') {

                $hasChargePositionsForTotal = true;
            }
        }
        
        return $hasChargePositionsForTotal;
    }

    /**
     * Indicates wether there are positions that are included in the total
     * price.
     *
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 2013-02-20
     */
    public function HasIncludedInTotalPositions() {
        if ($this->SilvercartOrderIncludedInTotalPositions()) {
            return true;
        } else {
            return false;
        }
    }
    
    /**
     * Returns the i18n text for the price type
     *
     * @return string
     */
    public function getPriceTypeText() {
        return _t('SilvercartPriceType.' . strtoupper($this->PriceType), $this->PriceType);
    }

    /**
     * Indicates wether this order is gross calculated or not.
     * 
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.06.2012
     */
    public function IsPriceTypeGross() {
        $isPriceTypeGross = false;

        if ($this->PriceType == 'gross') {
            $isPriceTypeGross = true;
        }

        $isPriceTypeGross = SilvercartPlugin::call(
            $this,
            'IsPriceTypeGross',
            array(
                $isPriceTypeGross
            )
        );

        return $isPriceTypeGross;
    }

    /**
     * Indicates wether this order is net calculated or not.
     * 
     * @return boolean
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.06.2012
     */
    public function IsPriceTypeNet() {
        $isPriceTypeNet = false;

        if ($this->PriceType == 'net') {
            $isPriceTypeNet = true;
        }

        $isPriceTypeNet = SilvercartPlugin::call(
            $this,
            'IsPriceTypeNet',
            array(
                $isPriceTypeNet
            )
        );

        return $isPriceTypeNet;
    }

    /**
     * writes a log entry
     * 
     * @param string $context context for log entry
     * @param string $text    text for log entry
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.11.2010
     */
    public function Log($context, $text) {
        $path = Director::baseFolder() . '/silvercart/log/' . $this->ClassName . '.log';
        $text = sprintf(
            "%s - Method: '%s' - %s\n",
            date('Y-m-d H:i:s'),
            $context,
            $text
        );
        file_put_contents($path, $text, FILE_APPEND);
    }

    /**
     * send a confirmation mail with order details to the customer $member
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.08.2011
     * @return void
     */
    public function sendConfirmationMail() {
        $params = array(
            'MailOrderConfirmation' => array(
                'Template'      => 'MailOrderConfirmation',
                'Recipient'     => $this->CustomersEmail,
                'Variables'     => array(
                    'FirstName'         => $this->SilvercartInvoiceAddress()->FirstName,
                    'Surname'           => $this->SilvercartInvoiceAddress()->Surname,
                    'Salutation'        => $this->SilvercartInvoiceAddress()->getSalutationText(),
                    'SilvercartOrder'   => $this
                ),
                'Attachments'   => null,
            ),
            'MailOrderNotification' => array(
                'Template'      => 'MailOrderNotification',
                'Recipient'     => SilvercartConfig::DefaultMailOrderNotificationRecipient(),
                'Variables'     => array(
                    'FirstName'         => $this->SilvercartInvoiceAddress()->FirstName,
                    'Surname'           => $this->SilvercartInvoiceAddress()->Surname,
                    'Salutation'        => $this->SilvercartInvoiceAddress()->getSalutationText(),
                    'SilvercartOrder'   => $this
                ),
                'Attachments'   => null,
            ),
        );
                
        $result = $this->extend('updateConfirmationMail', $params);
        
        SilvercartShopEmail::send(
            $params['MailOrderConfirmation']['Template'],
            $params['MailOrderConfirmation']['Recipient'],
            $params['MailOrderConfirmation']['Variables'],
            $params['MailOrderConfirmation']['Attachments']
        );
        SilvercartShopEmail::send(
            $params['MailOrderNotification']['Template'],
            $params['MailOrderNotification']['Recipient'],
            $params['MailOrderNotification']['Variables'],
            $params['MailOrderNotification']['Attachments']
        );
        $this->extend('onAfterConfirmationMail');
    }

    /**
     * Set a new/reserved ordernumber before writing and send attributed
     * ShopEmails.
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.01.2014
     */
    protected function onBeforeWrite() {
        parent::onBeforeWrite();
        
        if (empty ($this->OrderNumber)) {
            $this->OrderNumber = SilvercartNumberRange::useReservedNumberByIdentifier('OrderNumber');
        }
        if (!$this->didHandleOrderStatusChange &&
            $this->ID > 0 && $this->isChanged('SilvercartOrderStatusID')) {
            $this->didHandleOrderStatusChange = true;
            $this->extend('onBeforeOrderStatusChange');
            if (method_exists($this->SilvercartPaymentMethod(), 'handleOrderStatusChange')) {
                $this->SilvercartPaymentMethod()->handleOrderStatusChange($this);
            }
            $newOrderStatus = DataObject::get_by_id('SilvercartOrderStatus', $this->SilvercartOrderStatusID);
            
            if ($newOrderStatus) {
                if ($this->AmountTotalAmount > 0) {
                    $this->AmountTotal->setAmount($this->AmountTotalAmount);
                    $this->AmountTotal->setCurrency($this->AmountTotalCurrency);
                }
                
                $newOrderStatus->sendMailFor($this);
            }
            SilvercartOrderLog::addChangedLog($this, 'SilvercartOrderStatus', $this->original['SilvercartOrderStatusID'], $this->SilvercartOrderStatusID);
        }
        if (array_key_exists('sa__FirstName', $_POST) &&
            $this->SilvercartShippingAddress()->ID > 0) {
            foreach ($_POST as $paramName => $paramValue) {
                if (strpos($paramName, 'sa__') === 0) {
                    $addressParamName = str_replace('sa__', '', $paramName);
                    $this->SilvercartShippingAddress()->{$addressParamName} = $paramValue;
                }
            }
            $this->SilvercartShippingAddress()->write();
        }
        if (array_key_exists('ia__FirstName', $_POST) &&
            $this->SilvercartInvoiceAddress()->ID > 0) {
            foreach ($_POST as $paramName => $paramValue) {
                if (strpos($paramName, 'ia__') === 0) {
                    $addressParamName = str_replace('ia__', '', $paramName);
                    $this->SilvercartInvoiceAddress()->{$addressParamName} = $paramValue;
                }
            }
            $this->SilvercartInvoiceAddress()->write();
        }
        $this->extend('updateOnBeforeWrite');
    }

    /**
     * hook triggered after write
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 23.01.2014
     */
    protected function onAfterWrite() {
        parent::onAfterWrite();

        $this->extend('updateOnAfterWrite');
        $this->didHandleOrderStatusChange = false;
    }

    /**
     * Recalculates the order totals for the attributed positions.
     * 
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 21.03.2012
     */
    public function recalculate() {
        $totalAmount = 0.0;

        foreach ($this->SilvercartOrderPositions() as $orderPosition) {
            $totalAmount += $orderPosition->PriceTotal->getAmount();
        }

        $this->AmountTotal->setAmount(
            $totalAmount
        );

        $this->write();
    }

    /**
     * Returns the shipping method of this order and injects the shipping address
     *
     * @return SilvercartShippingMethod
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.04.2012
     */
    public function SilvercartShippingMethod() {
        $silvercartShippingMethod = null;
        if ($this->getComponent('SilvercartShippingMethod')) {
            $silvercartShippingMethod = $this->getComponent('SilvercartShippingMethod');
            $silvercartShippingMethod->setShippingAddress($this->SilvercartShippingAddress());
        }
        return $silvercartShippingMethod;
    }

    /**
     * returns the orders total amount as string incl. currency.
     *
     * @return string
     * 
     * @deprecated Use property AmountTotal instead
     */
    public function getAmountTotalNice() {
        return $this->AmountTotal->Nice();
    }

    /**
     * returns the orders total amount as string incl. currency.
     *
     * @return string
     */
    public function getHandlingCostShipmentNice() {
        return str_replace('.', ',', number_format($this->HandlingCostShipmentAmount, 2)) . ' ' . $this->HandlingCostShipmentCurrency;
    }

    /**
     * returns the orders total amount as string incl. currency.
     *
     * @return string
     */
    public function getHandlingCostPaymentNice() {
        return str_replace('.', ',', number_format($this->HandlingCostPaymentAmount, 2)) . ' ' . $this->HandlingCostPaymentCurrency;
    }

    /**
     * returns carts net value including all editional costs
     *
     * @return Money amount
     * 
     * @deprecated Use property AmountTotal instead
     */
    public function getAmountNet() {
        user_error('SilvercartOrder::getAmountNet() is marked as deprecated! Use property AmountTotal instead.', E_USER_ERROR);
        $amountNet = $this->AmountGrossTotal->getAmount() - $this->Tax->getAmount();
        $amountNetObj = new Money();
        $amountNetObj->setAmount($amountNet);
        $amountNetObj->setCurrency(SilvercartConfig::DefaultCurrency());

        return $amountNetObj;
    }

    /**
     * returns carts gross value including all editional costs
     *
     * @return Money
     * 
     * @deprecated Use property AmountTotal instead
     */
    public function getAmountGross() {
        user_error('SilvercartOrder::getAmountGross() is marked as deprecated! Use property AmountTotal instead.', E_USER_ERROR);
        return $this->AmountGrossTotal;
    }

    /**
     * returns the orders total amount as string incl. currency.
     *
     * @return string
     * 
     * @deprecated Use property AmountTotal instead
     */
    public function getAmountGrossTotalNice() {
        user_error('SilvercartOrder::getAmountGrossTotalNice() is marked as deprecated! Use property AmountTotal instead.', E_USER_ERROR);
        return $this->getAmountTotalNice();
    }
    
    /**
     * Marks the order as seen
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public function markAsSeen() {
        if (!$this->IsSeen) {
            $this->IsSeen = true;
            $this->write();
            SilvercartOrderLog::addMarkedAsSeenLog($this, 'SilvercartOrder');
        }
    }
    
    /**
     * Marks the order as not seen
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.03.2013
     */
    public function markAsNotSeen() {
        if ($this->IsSeen) {
            $this->IsSeen = false;
            $this->write();
            SilvercartOrderLog::addMarkedAsNotSeenLog($this, 'SilvercartOrder');
        }
    }
    
}
