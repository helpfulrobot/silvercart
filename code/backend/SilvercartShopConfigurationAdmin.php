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
 * @subpackage Backend
 */

/**
 * The Silvercart configuration backend.
 *
 * @package Silvercart
 * @subpackage Backend
 * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2011 pixeltricks GmbH
 * @since 31.01.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartShopConfigurationAdmin extends ModelAdmin {

    /**
     * Managed models
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $managed_models = array(
        'SilvercartCountry',
        'SilvercartZone',
        'SilvercartPaymentMethod',
        'SilvercartShippingMethod',
        'SilvercartCarrier',
        'SilvercartTax',
        'SilvercartOrderStatus',
        'SilvercartShopEmail',
        'SilvercartAvailabilityStatus',
        'SilvercartNumberRange',
        'SilvercartConfig',
        'SilvercartAmountUnit'
    );
    /**
     * The URL segment
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $url_segment = 'silvercart-configuration';
    /**
     * The menu title
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $menu_title = 'Silvercart Konfiguration';
    /**
     * The collection controller class to use for the shop configuration.
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $collection_controller_class = 'SilvercartShopConfigurationAdmin_CollectionController';

    public static $menu_priority = -1;

    /**
     * constructor
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 02.02.2011
     */
    public function __construct() {
        self::$menu_title = _t('SilvercartShopConfigurationAdmin.SILVERCART_CONFIG', 'SilverCart Konfiguration');
        parent::__construct();
    }

}

/**
 * Modifies the model admin search panel.
 *
 * @package Silvercart
 * @subpackage Backend
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @copyright 2011 pixeltricks GmbH
 * @since 31.01.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartShopConfigurationAdmin_CollectionController extends ModelAdmin_CollectionController {

    /**
     * Return a modified search form.
     *
     * @return Form
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public function SearchForm() {
        $form = parent::SearchForm();

        switch ($this->getModelClass()) {
            case 'SilvercartConfig':
                $form->setFields(new FieldSet());
                $form->Actions()->fieldByName('action_search')->Title = _t('SilvercartConfig.SHOW_CONFIG');
                $form->Actions()->removeByName('action_clearsearch');
                break;
            default:
        }
        return $form;
    }

    /**
     * Disable the creation of SilvercartUpdate DataObjects.
     *
     * @return bool
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 29.03.2011
     */
    public function alternatePermissionCheck() {
        switch ($this->getModelClass()) {
            case 'SilvercartConfig':
                $this->showImportForm = false;
                return false;
                break;
            default:
                return true;
        }
    }

}
