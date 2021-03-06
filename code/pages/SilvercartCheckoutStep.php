<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Pages_Checkout
 */

/**
 * Checkout step page.
 *
 * @package Silvercart
 * @subpackage Pages_Checkout
 * @author Sascha Koehler <skoehler@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 18.09.2013
 * @copyright 2013 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartCheckoutStep extends CustomHtmlFormStepPage {
    
    /**
     * DB attributes
     *
     * @var array
     */
    public static $db = array(
        'ContentStep1'  => 'HTMLText',
        'ContentStep2'  => 'HTMLText',
        'ContentStep3'  => 'HTMLText',
        'ContentStep4'  => 'HTMLText',
        'ContentStep5'  => 'HTMLText',
        'ContentStep6'  => 'HTMLText',
    );

    /**
     * icon for site tree
     *
     * @var string
     */
    public static $icon = "silvercart/img/page_icons/checkout_page";
    
    /**
     * Field labels
     * 
     * @param bool $includerelations Include relations?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 18.09.2013
     */
    public function fieldLabels($includerelations = true) {
        $labels = array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'ContentStep1'  => _t('SilvercartCheckoutStep.ContentStep1'),
                    'ContentStep2'  => _t('SilvercartCheckoutStep.ContentStep2'),
                    'ContentStep3'  => _t('SilvercartCheckoutStep.ContentStep3'),
                    'ContentStep4'  => _t('SilvercartCheckoutStep.ContentStep4'),
                    'ContentStep5'  => _t('SilvercartCheckoutStep.ContentStep5'),
                    'ContentStep6'  => _t('SilvercartCheckoutStep.ContentStep6'),
                    'StepContent'   => _t('SilvercartCheckoutStep.StepContent'),
                )
        );
        
        $this->extend('updateFieldLabels', $labels);
        
        return $labels;
    }

    /**
     * Deletes the step session data.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.04.2013
     */
    public static function deleteSessionStepData() {
        $sessionStepData = Session::get('CustomHtmlFormStep');
        if (!is_null($sessionStepData) &&
            is_array($sessionStepData)) {

            foreach ($sessionStepData as $sessionIdx => $sessionContent) {
                unset($_SESSION['CustomHtmlFormStep'][$sessionIdx]);
            }
        }
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
     * CMS fields
     * 
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        
        $fields->findOrMakeTab('Root.StepContent', $this->fieldLabel('StepContent'));
        $fields->addFieldToTab('Root.StepContent', new HtmlEditorField('ContentStep1', $this->fieldLabel('ContentStep1'), 15));
        $fields->addFieldToTab('Root.StepContent', new HtmlEditorField('ContentStep2', $this->fieldLabel('ContentStep2'), 15));
        $fields->addFieldToTab('Root.StepContent', new HtmlEditorField('ContentStep3', $this->fieldLabel('ContentStep3'), 15));
        $fields->addFieldToTab('Root.StepContent', new HtmlEditorField('ContentStep4', $this->fieldLabel('ContentStep4'), 15));
        $fields->addFieldToTab('Root.StepContent', new HtmlEditorField('ContentStep5', $this->fieldLabel('ContentStep5'), 15));
        $fields->addFieldToTab('Root.StepContent', new HtmlEditorField('ContentStep6', $this->fieldLabel('ContentStep6'), 15));
        
        return $fields;
    }
}

/**
 * checkout step controller.
 * Checkout step page controller.
 *
 * @package Silvercart
 * @subpackage Pages Checkout
 * @author Sascha Koehler <skoehler@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 08.04.2013
 * @copyright 2013 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartCheckoutStep_Controller extends CustomHtmlFormStepPage_Controller {
    
    /**
     * Allowed actions.
     *
     * @var array
     */
    private static $allowed_actions = array(
        'editAddress',
    );

    /**
     * Preferences
     *
     * @var array
     */
    protected $preferences = array(
        'templateDir' => ''
    );
    /**
     * The payment method object.
     *
     * @var PaymentMethod
     */
    protected $paymentMethodObj = false;
    
    /**
     * cache key for the current step
     *
     * @var string
     */
    protected $cacheKey = null;

    /**
     * Initializes the step form. Includes forms and requirements.
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Sascha Koehler <skoehler@pixeltricks.de>
     * @since 15.11.2014
     */
    public function init() {
        $this->preferences['templateDir'] = PIXELTRICKS_CHECKOUT_BASE_PATH_REL . 'templates/Layout/';
        if (SilvercartConfig::EnableSSL()) {
            Director::forceSSL();
        }
        parent::init();
        
        // Inject payment and shippingmethods to shoppingcart, if available
        $member = SilvercartCustomer::currentUser();

        if ($member) {
            $stepData       = $this->getCombinedStepData();
            $shoppingCart   = $member->getCart();
            
            // If minimum order value is set and shoppingcart value is below we
            // have to redirect the customer to the shoppingcart page and set
            // an appropriate error message.
            if ( $this->getCurrentStep() < 5 &&
                 SilvercartConfig::UseMinimumOrderValue() &&
                 SilvercartConfig::MinimumOrderValue() &&
                 SilvercartConfig::MinimumOrderValue()->getAmount() > $shoppingCart->getAmountTotalWithoutFees()->getAmount()) {
                
                $silvercartSessionErrors    = Session::get('Silvercart.errors');
                $silvercartSessionErrors[]  = sprintf(
                    _t('SilvercartShoppingCart.ERROR_MINIMUMORDERVALUE_NOT_REACHED'),
                    SilvercartConfig::MinimumOrderValue()->Nice()
                );
                Session::set('Silvercart.errors', $silvercartSessionErrors);
                Session::save();
                
                $this->redirect(SilvercartPage_Controller::PageByIdentifierCode('SilvercartCartPage')->Link());
            }

            if (isset($stepData['ShippingMethod'])) {
                $shoppingCart->setShippingMethodID($stepData['ShippingMethod']);
            }
            if (isset($stepData['PaymentMethod'])) {
                $shoppingCart->setPaymentMethodID($stepData['PaymentMethod']);
            }
            
            $requestParams = $this->getRequest()->allParams();
            if ($requestParams['Action'] == 'editAddress') {
                $addressID          = (int) $requestParams['ID'];
                $membersAddresses   = SilvercartCustomer::currentUser()->SilvercartAddresses();
                $membersAddress     = $membersAddresses->find('ID', $addressID);
                if ($membersAddress instanceof SilvercartAddress && $membersAddress->exists()) {
                    Session::set("redirect", $this->Link());
                    $preferences = array();
                    $preferences['submitAction'] = 'editAddress/' . $addressID . '/customHtmlFormSubmit';
                    $this->registerCustomHtmlForm('SilvercartEditAddressForm', new SilvercartEditAddressForm($this, array('addressID' => $addressID), $preferences));
                }
            }
        }
    }

    /**
     * Returns a cache key for the current step
     * 
     * @return string
     */
    public function getCacheKey() {
        if (is_null($this->cacheKey)) {
            $member     = SilvercartCustomer::currentUser();
            $stepData   = $this->getStepData($this->getCurrentStep());
            $cacheKey   = '';

            if ($member) {
                $cart = $member->getCart();
                $cacheKey .= $member->ID;
                $cacheKey .= sha1($cart->LastEdited) . md5($cart->LastEdited);
            }
            $cacheKey   .= $this->getCurrentStep();
            if (is_array($stepData)) {
                $stepDataString  = '';
                foreach ($stepData as $parameterName => $parameterValue) {
                    $stepDataString .= $parameterName . ':' . $parameterValue . ';';
                }
                $cacheKey .= sha1($stepDataString);
            } else {
                $cacheKey .= (int) $stepData;
            }

            $this->cacheKey = $cacheKey;
        }
        return $this->cacheKey;
    }

    /**
     * Returns whether an error occured.
     *
     * @return bool
     */
    public function getErrorOccured() {
        if ($this->paymentMethodObj) {
            return $this->paymentMethodObj->getErrorOccured();
        }

        return false;
    }

    /**
     * Returns occured errors.
     *
     * @return DataList
     */
    public function getErrorList() {
        if ($this->paymentMethodObj) {
            return $this->paymentMethodObj->getErrorList();
        }

        return false;
    }

    /**
     * Deletes the cart.
     *
     * @param bool $includeShoppingCart set wether the shoppingcart should be
     *                                  deleted
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Sascha Koehler <skoehler@pixeltricks.de>
     * @since 15.11.2014
     */
    public function deleteSessionData($includeShoppingCart = true) {
        parent::deleteSessionData();

        $member = SilvercartCustomer::currentUser();

        if ($includeShoppingCart && $member) {
            if ($member->SilvercartShoppingCartID != 0) {
                $shoppingCart = $member->getCart();
                $shoppingCart->delete();
            }
        }

        if (isset($_SESSION['paypal_module_payer_id'])) {
            unset($_SESSION['paypal_module_payer_id']);
        }
        if (isset($_SESSION['paypal_module_token'])) {
            unset($_SESSION['paypal_module_token']);
        }
    }

    /**
     * Adds a prefix to a plain address data array.
     *
     * @param string $prefix Prefix
     * @param array  $data   Plain address data
     *
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.07.2011
     */
    public function joinAddressDataTo($prefix, $data) {
        $addressData = array();
        $checkoutDataFields = array(
            $prefix.'_TaxIdNumber'      => 'TaxIdNumber',
            $prefix.'_Company'          => 'Company',
            $prefix.'_Salutation'       => 'Salutation',
            $prefix.'_FirstName'        => 'FirstName',
            $prefix.'_Surname'          => 'Surname',
            $prefix.'_Addition'         => 'Addition',
            $prefix.'_Street'           => 'Street',
            $prefix.'_StreetNumber'     => 'StreetNumber',
            $prefix.'_Postcode'         => 'Postcode',
            $prefix.'_City'             => 'City',
            $prefix.'_Phone'            => 'Phone',
            $prefix.'_PhoneAreaCode'    => 'PhoneAreaCode',
            $prefix.'_Fax'              => 'Fax',
            $prefix.'_Country'          => 'CountryID',
            $prefix.'_Country'          => 'SilvercartCountryID',
            $prefix.'_PostNumber'       => 'PostNumber',
            $prefix.'_Packstation'      => 'Packstation',
            $prefix.'_IsPackstation'    => 'IsPackstation',
        );
        
        if (is_array($data)) {
            foreach ($checkoutDataFields as $checkoutFieldName => $dataFieldName) {
                if (isset($data[$dataFieldName])) {
                    $addressData[$checkoutFieldName] = $data[$dataFieldName];
                }
            }
        }

        return $addressData;
    }

    /**
     * Adds a prefix to a plain address data array.
     *
     * @param string $prefix       Prefix
     * @param array  $checkoutData Checkout address data
     *
     * @return array
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 24.01.2014
     */
    public function extractAddressDataFrom($prefix, $checkoutData) {
        $addressData = array();
        $checkoutDataFields = array(
            $prefix.'_TaxIdNumber'      => 'TaxIdNumber',
            $prefix.'_Company'          => 'Company',
            $prefix.'_Salutation'       => 'Salutation',
            $prefix.'_FirstName'        => 'FirstName',
            $prefix.'_Surname'          => 'Surname',
            $prefix.'_Addition'         => 'Addition',
            $prefix.'_Street'           => 'Street',
            $prefix.'_StreetNumber'     => 'StreetNumber',
            $prefix.'_Postcode'         => 'Postcode',
            $prefix.'_City'             => 'City',
            $prefix.'_Phone'            => 'Phone',
            $prefix.'_PhoneAreaCode'    => 'PhoneAreaCode',
            $prefix.'_Fax'              => 'Fax',
            $prefix.'_Country'          => 'CountryID',
            $prefix.'_Country'          => 'SilvercartCountryID',
            $prefix.'_PostNumber'       => 'PostNumber',
            $prefix.'_Packstation'      => 'Packstation',
            $prefix.'_IsPackstation'    => 'IsPackstation',
        );
        
        if (is_array($checkoutData)) {
            foreach ($checkoutDataFields as $checkoutFieldName => $dataFieldName) {
                if (isset($checkoutData[$checkoutFieldName])) {
                    $addressData[$dataFieldName] = $checkoutData[$checkoutFieldName];
                }
            }
        }

        return $addressData;
    }

    /**
     * Indicates wether ui elements for removing items and altering their
     * quantity should be shown in the shopping cart templates.
     *
     * During the checkout process the user may not be able to alter the
     * shopping cart.
     *
     * @return boolean false
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 07.02.2011
     */
    public function getEditableShoppingCart() {
        return false;
    }
    
    /**
     * Action to delete an address. Checks, whether the given address is related
     * to the logged in customer and deletes it.
     *
     * @param SS_HTTPRequest $request The given request
     * @param string         $context specifies the context from the action to adjust redirect behaviour
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.07.2011
     */
    public function deleteAddress(SS_HTTPRequest $request, $context = 'SilvercartCheckoutStep') {
        $silvercartAddressHolder = new SilvercartAddressHolder_Controller();
        $silvercartAddressHolder->deleteAddress($request, $context);
    }
    
    /**
     * Renders a form to edit addresses and handles it's sumbit event.
     *
     * @param SS_HTTPRequest $request the given request
     * 
     * @return type 
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.11.2014
     */
    public function editAddress(SS_HTTPRequest $request) {
        $rendered = '';
        $params = $request->allParams();
        if (array_key_exists('ID', $params)
         && !empty ($params['ID'])) {
            if (strtolower($params['OtherID']) == 'customhtmlformsubmit') {
                $this->CustomHtmlFormSubmit($request);
                $form = $this->getRegisteredCustomHtmlForm('SilvercartEditAddressForm');
                if ($form->submitSuccess) {
                    $form->addMessage(_t('SilvercartAddressHolder.ADDED_ADDRESS_SUCCESS', 'Your address was successfully saved.'));
                } else {
                    $form->addMessage(_t('SilvercartAddressHolder.ADDED_ADDRESS_FAILURE', 'Your address could not be saved.'));
                    $rendered = $this->renderWith(array('SilvercartCheckoutFormStep2RegularEditAddress','Page'));
                }
            } else {
                $addressID          = (int) $params['ID'];
                $membersAddresses   = SilvercartCustomer::currentUser()->SilvercartAddresses();
                $membersAddress     = $membersAddresses->find('ID', $addressID);
                if ($membersAddress instanceof SilvercartAddress && $membersAddress->exists()) {
                    // Address contains to logged in user - render edit form
                    $rendered = $this->renderWith(array('SilvercartCheckoutFormStep2RegularEditAddress','Page'));
                } else {
                    // possible break in attempt!
                    $rendered = $this->renderWith(array('SilvercartCheckoutStep','Page'));
                }
            }
        }
        if ($rendered == '' && is_null($this->redirectedTo())) {
            $this->redirectBack();
        }
        return $rendered;
    }
    
    /**
     * Checks whether the current step is the payment step
     *
     * @return bool
     * 
     * @author Sascha Köhler <skoehler@pixeltricks.de>
     * @since 19.7.2011
     */
    public function currentStepIsPaymentStep() {
        return $this->stepMapping[$this->getCurrentStep()]['class'] == 'SilvercartCheckoutFormStep4';
    }
    
    /**
     * Returns the invoice address set in checkout
     *
     * @return SilvercartAddress 
     */
    public function getInvoiceAddress() {
        return $this->getAddress('Invoice');
    }
    
    /**
     * Returns the shipping address set in checkout
     *
     * @return SilvercartAddress 
     */
    public function getShippingAddress() {
        return $this->getAddress('Shipping');
    }
    
    /**
     * Returns the shipping or invoice address set in checkout
     *
     * @param string $prefix The prefix to use
     *
     * @return SilvercartAddress 
     */
    public function getAddress($prefix) {
        $address    = false;
        $stepData   = $this->getCombinedStepData();
        if ($stepData != false) {
            $addressData = SilvercartTools::extractAddressDataFrom($prefix, $stepData);
            if (!empty($addressData) &&
                array_key_exists('CountryID', $addressData)) {
                $address = new SilvercartAddress($addressData);
                $address->SilvercartCountryID = $addressData['CountryID'];
            }
        }
        return $address;
    }
    
    /**
     * Returns the address step number.
     * 
     * @return int
     */
    public function getAddressStepNumber() {
        $stepNumber = 2;
        if (SilvercartCustomer::currentUser()->isRegisteredCustomer()) {
            $stepNumber = 1;
        }
        return $stepNumber;
    }
    
    /**
     * Returns the shippment step number.
     * 
     * @return int
     */
    public function getShipmentStepNumber() {
        $stepNumber = 3;
        if (SilvercartCustomer::currentUser()->isRegisteredCustomer()) {
            $stepNumber = 2;
        }
        return $stepNumber;
    }
    
    /**
     * Returns the payment step number.
     * 
     * @return int
     */
    public function getPaymentStepNumber() {
        $stepNumber = 4;
        if (SilvercartCustomer::currentUser()->isRegisteredCustomer()) {
            $stepNumber = 3;
        }
        return $stepNumber;
    }
    
    /**
     * Returns the payment step number.
     * 
     * @return int
     */
    public function getLastStepNumber() {
        $stepNumber = 5;
        if (SilvercartCustomer::currentUser()->isRegisteredCustomer()) {
            $stepNumber = 4;
        }
        return $stepNumber;
    }
    
    /**
     * Returns the address step number.
     * 
     * @return int
     */
    public function getAddressStepLink() {
        return $this->Link('GotoStep/' . $this->getAddressStepNumber());
    }
    
    /**
     * Returns the shippment step number.
     * 
     * @return int
     */
    public function getShipmentStepLink() {
        return $this->Link('GotoStep/' . $this->getShipmentStepNumber());
    }
    
    /**
     * Returns the payment step number.
     * 
     * @return int
     */
    public function getPaymentStepLink() {
        return $this->Link('GotoStep/' . $this->getPaymentStepNumber());
    }
    
    /**
     * Returns the payment step number.
     * 
     * @return int
     */
    public function getLastStepLink() {
        return $this->Link('GotoStep/' . $this->getLastStepNumber());
    }
    
    /**
     * Returns whether to skip payment step or not.
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.02.2016
     */
    public function SkipPaymentStep() {
        $paymentStep = new SilvercartCheckoutFormStep4($this);
        return $paymentStep->SkipPaymentStep();
    }
    
    /**
     * Returns whether to skip shipping step or not.
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.02.2016
     */
    public function SkipShippingStep() {
        $shippingStep = new SilvercartCheckoutFormStep3($this);
        return $shippingStep->SkipShippingStep();
    }
    
}
