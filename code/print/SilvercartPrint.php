<?php
/**
 * Copyright 2012 pixeltricks GmbH
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
 * @subpackage Print
 */

/**
 * Provides some helping methods for the print environment.
 *
 * @package Silvercart
 * @subpackage Print
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2012 pixeltricks GmbH
 * @since 19.04.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartPrint {
    
    /**
     * Returns the print URL for the given DataObject
     * (silvercart-print/$DataObjectName/$DataObjectID)
     *
     * @param DataObject $dataObject DataObject to get print URL for
     * 
     * @return string 
     */
    public static function getPrintURL($dataObject) {
        $printURL = '';
        if ($dataObject instanceof DataObject) {
            $printURL = sprintf(
                    'silvercart-print/%s/%s',
                    $dataObject->ClassName,
                    $dataObject->ID
            );
        }
        return $printURL;
    }
    
    /**
     * Clears the already set requirements and loads the default print requirements
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.04.2012 
     */
    public static function loadDefaultRequirements() {
        Requirements::clear();
        Requirements::themedCSS('SilvercartPrintDefault');
        Requirements::javascript('silvercart/script/SilvercartPrintDefault.js');
    }
    
    /**
     * Returns the given DataObjects default print template
     * 
     * @param DataObject $dataObject DataObject to get print output for
     *
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.04.2012
     */
    public static function getPrintOutput($dataObject) {
        $printResult = '';
        if ($dataObject->CanView()) {
            self::loadDefaultRequirements();
            Requirements::themedCSS('SilvercartPrint' . $dataObject->ClassName);
            $printResult = $dataObject->renderWith('SilvercartPrint' . $dataObject->ClassName);
        }
        return $printResult;
    }
    
}

/**
 * Default controller to get the print output for supported DataObjects.
 * The controller is called by using the URL rewrite rule
 * silvercart-print/$DataObjectName/$DataObjectID
 * and requires the methods printDataObject() and CanView() on the given
 * DataObject.
 *
 * @package Silvercart
 * @subpackage Print
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2012 pixeltricks GmbH
 * @since 19.04.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartPrint_Controller extends SilvercartPage_Controller {

    /**
     * Executes the print controllers logic
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 19.04.2012
     */
    public function init() {
        parent::init();
        $request        = $this->getRequest();
        $params         = $request->allParams();
        $dataObjectName = $params['DataObjectName'];
        $dataObjectID   = $params['DataObjectID'];
        $dataObject     = DataObject::get_by_id($dataObjectName, $dataObjectID);
        if ($dataObject &&
            $dataObject->canView()) {
            if ($dataObject->hasMethod('printDataObject')) {
                print $dataObject->printDataObject();
            } else {
                print SilvercartPrint::getPrintOutput($dataObject);
            }
            exit();
        } else {
            Director::redirect(Director::baseURL());
        }
    }
    
}