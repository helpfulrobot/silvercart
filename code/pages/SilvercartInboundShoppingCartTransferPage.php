<?php
/**
 * Copyright 2011 pixeltricks GmbH
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
 * Handles the transfer of shopping cart items from an external referer to
 * a current users shopping cart.
 *
 * @package Silvercart
 * @subpacke Pages
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 01.08.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2011 pixeltricks GmbH
 */
class SilvercartInboundShoppingCartTransferPage extends Page {}

/**
 * Handles the transfer of shopping cart items from an external referer to
 * a current users shopping cart.
 *
 * @package Silvercart
 * @subpacke Pages
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 01.08.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2011 pixeltricks GmbH
 */
class SilvercartInboundShoppingCartTransferPage_Controller extends Page_Controller {
    
    /**
     * Contains all error messages.
     *
     * @var array
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected $errorMessages = array();
    
    /**
     * We implement our own action handling here since we use the action
     * as identifier string to look up the corresponding 
     * SilvercartInboundShoppingCartTransfer object.
     *
     * @return string
     *
     * @param SS_HTTPRequest $request The request parameters
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    public function handleAction(SS_HTTPRequest $request) {
        $this->action           = str_replace("-","_",$request->param('Action'));
		$this->requestParams    = $request->requestVars();
        
        $inboundShoppingCartTransfer = DataObject::get_one(
            'SilvercartInboundShoppingCartTransfer',
            sprintf(
                "refererIdentifier = '%s'",
                Convert::raw2sql($this->action)
            )
        );
        
        if ($inboundShoppingCartTransfer) {
            if ($inboundShoppingCartTransfer->useSharedSecret &&
                !$this->checkSharedSecretFor($inboundShoppingCartTransfer, $request)) {
                
                return $this->sharedSecretInvalid();
            } else {
                switch ($inboundShoppingCartTransfer->transferMethod) {
                    case 'keyValue':
                        return $this->handleKeyValueShoppingCartTransferWith($inboundShoppingCartTransfer, $request);
                        break;
                    case 'combinedString':
                    default:
                        return $this->handleCombinedStringShoppingCartTransferWith($inboundShoppingCartTransfer, $request);
                }
            }
            
        } else {
            return $this->refererNotFound();
        }
    }
    
    /**
     * Returns the error messages.
     *
     * @return string
     *
     * @param 
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    public function ErrorMessages() {
        return new DataObjectSet($this->errorMessages);
    }
    
    /**
     * Handles the transfer of the sent product data to a valid shopping cart
     * via key-value pairs.
     *
     * @return string
     *
     * @param SilvercartInboundShoppingCartTransfer $inboundShoppingCartTransfer The transfer object that handles this referer
     * @param SS_HTTPRequest                        $request                     The request parameters
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function handleKeyValueShoppingCartTransferWith(SilvercartInboundShoppingCartTransfer $inboundShoppingCartTransfer, SS_HTTPRequest $request) {
        $error          = false;
        $requestVars    = $request->requestVars();
        $identifierIdx  = 0;
        
        if (!array_key_exists($inboundShoppingCartTransfer->keyValueProductIdentifier, $requestVars)) {
            return $this->keyValueProductIdentifierNotFound();
        }
        if (!array_key_exists($inboundShoppingCartTransfer->keyValueQuantityIdentifier, $requestVars)) {
            return $this->keyValueQuantityIdentifierNotFound();
        }
        
        $identifierCount = count($requestVars[$inboundShoppingCartTransfer->keyValueProductIdentifier]);
        
        for ($identifierIdx = 0; $identifierIdx < $identifierCount; $identifierIdx++) {
            if (array_key_exists($identifierIdx, $requestVars[$inboundShoppingCartTransfer->keyValueQuantityIdentifier])) {
                $productQuantity = $requestVars[$inboundShoppingCartTransfer->keyValueQuantityIdentifier][$identifierIdx];
            } else {
                $productQuantity = 1;
            }
            
            $product = DataObject::get_one(
                'SilvercartProduct',
                sprintf(
                    $inboundShoppingCartTransfer->productMatchingField." = '%s'",
                    Convert::raw2sql($requestVars[$inboundShoppingCartTransfer->keyValueProductIdentifier][$identifierIdx])
                )
            );
            
            if ($product) {
                $this->addProduct($product, $productQuantity);
            }
        }
        
        if (!$error) {
            Director::redirect(SilvercartPage_controller::PageByIdentifierCodeLink('SilvercartCartPage'));
        }
    }
    
    /**
     * Handles the transfer of the sent product data to a valid shopping cart
     * via one string with separators.
     *
     * @return string
     *
     * @param SilvercartInboundShoppingCartTransfer $inboundShoppingCartTransfer The transfer object that handles this referer
     * @param SS_HTTPRequest                        $request                     The request parameters
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function handleCombinedStringShoppingCartTransferWith(SilvercartInboundShoppingCartTransfer $inboundShoppingCartTransfer, SS_HTTPRequest $request) {
        $error       = false;
        $requestVars = $request->requestVars();
        
        if (!array_key_exists($inboundShoppingCartTransfer->combinedStringKey, $requestVars)) {
            return $this->combinedStringKeyNotFound();
        }
        $combinedString = Convert::raw2sql($requestVars[$inboundShoppingCartTransfer->combinedStringKey]);
        $entities       = explode($inboundShoppingCartTransfer->combinedStringEntitySeparator, $combinedString);
        
        foreach ($entities as $entity) {
            list($productIdentifier, $productQuantity) = explode($inboundShoppingCartTransfer->combinedStringQuantitySeparator, $entity);
            
            $product = DataObject::get_one(
                'SilvercartProduct',
                sprintf(
                    $inboundShoppingCartTransfer->productMatchingField." = '%s'",
                    $productIdentifier
                )
            );
            
            if ($product) {
                $this->addProduct($product, $productQuantity);
            }
        }
        
        if (!$error) {
            Director::redirect(SilvercartPage_controller::PageByIdentifierCodeLink('SilvercartCartPage'));
        }
    }

    /**
     * Add a product to the shopping cart.
     *
     * @return boolean
     *
     * @param SilvercartProduct $product         The product object to add to the shopping cart
     * @param int               $productQuantity The quantity of the product to add
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function addProduct(SilvercartProduct $product, $productQuantity) {
        $productAdded = false;
        
        if ($product->isActive &&
            $product->SilvercartProductGroupID > 0 &&
            $product->isBuyableDueToStockManagementSettings()) {

            $productData = array(
                'productID'         => $product->ID,
                'productQuantity'   => $productQuantity
            );
            $productAdded = SilvercartShoppingCart::addProduct($productData);
        }
        
        return $productAdded;
    }
    
    /**
     * Check if a shared secret was sent and is valid for this transfer type.
     *
     * @return boolean
     *
     * @param SilvercartInboundShoppingCartTransfer $inboundShoppingCartTransfer The transfer object that handles this referer
     * @param SS_HTTPRequest                        $request                     The request parameters
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function checkSharedSecretFor(SilvercartInboundShoppingCartTransfer $inboundShoppingCartTransfer, SS_HTTPRequest $request) {
        $isValid        = false;
        $requestVars    = $request->requestVars();
        
        if (array_key_exists($inboundShoppingCartTransfer->sharedSecretIdentifier, $requestVars) &&
            sha1($inboundShoppingCartTransfer->sharedSecret) === urldecode($requestVars[$inboundShoppingCartTransfer->sharedSecretIdentifier])) {
            
            $isValid = true;
        }
        
        return $isValid;
    }
    
    /**
     * Displays an error output since the referer could not be found.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function refererNotFound() {
        $this->errorMessages[] = array(
            'Error' => _t('SilvercartInboundShoppingCartTransferPage.ERROR_REFERER_NOT_FOUND')
        );
        
        return $this;
    }
    
    /**
     * Displays an error output since the key-value product identifier  is
     * missing.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function keyValueProductIdentifierNotFound() {
        $this->errorMessages[] = array(
            'Error' => _t('SilvercartInboundShoppingCartTransferPage.ERROR_KEY_VALUE_PRODUCT_IDENTIFIER_NOT_FOUND')
        );
        
        return $this;
    }
    
    /**
     * Displays an error output since the key-value quantity identifier  is
     * missing.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function keyValueQuantityIdentifierNotFound() {
        $this->errorMessages[] = array(
            'Error' => _t('SilvercartInboundShoppingCartTransferPage.ERROR_KEY_VALUE_QUANTITY_IDENTIFIER_NOT_FOUND')
        );
        
        return $this;
    }
    
    /**
     * Displays an error output since the combined string key is missing.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function combinedStringKeyNotFound() {
        $this->errorMessages[] = array(
            'Error' => _t('SilvercartInboundShoppingCartTransferPage.ERROR_COMBINED_STRING_KEY_NOT_FOUND')
        );
        
        return $this;
    }
    
    /**
     * Displays an error output since the sent shared secret is invalid.
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 01.08.2011
     */
    protected function sharedSecretInvalid() {
        $this->errorMessages[] = array(
            'Error' => _t('SilvercartInboundShoppingCartTransferPage.ERROR_SHARED_SECRET_INVALID')
        );
        
        return $this;
    }
}