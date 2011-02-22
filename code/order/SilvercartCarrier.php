<?php
/*
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
 */

/**
 * abstract for a shipping carrier
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 06.11.2010
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartCarrier extends DataObject {

    /**
     * Singular name
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $singular_name = "carrier";

    /**
     * Plural name
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $plural_name = "carriers";

    /**
     * Attributes.
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $db = array(
        'Title'             => 'VarChar(25)',
        'FullTitle'         => 'VarChar(60)'
    );

    /**
     * Has-many relationship.
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $has_many = array(
        'SilvercartShippingMethods'   => 'SilvercartShippingMethod',
        'SilvercartZones'             => 'SilvercartZone'
    );

    /**
     * Summaryfields for display in tables.
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $summary_fields = array(
        'Title'                     => 'Name',
        'AttributedZones'           => 'Zugeordnete Zonen',
        'AttributedShippingMethods' => 'Zugeordnete Versandarten'
    );

    /**
     * Column labels for display in tables.
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $field_labels = array(
        'Title'                     => 'Name',
        'FullTitle'                 => 'voller Name',
        'AttributedZones'           => 'Zugeordnete Zonen',
        'AttributedShippingMethods' => 'Zugeordnete Versandarten'
    );

    /**
     * Virtual database fields.
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $casting = array(
        'AttributedZones'           => 'Varchar(255)',
        'AttributedShippingMethods' => 'Varchar(255)'
    );

    /**
     * List of searchable fields for the model admin
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public static $searchable_fields = array(
        'Title',
        'SilvercartZones.ID' => array(
            'title' => 'Zugeordnete Zonen'
        ),
        'SilvercartShippingMethods.ID' => array(
            'title' => 'Zugeordnete Versandarten'
        )
    );

    /**
     * Constructor. We localize the static variables here.
     *
     * @param array|null $record      This will be null for a new database record.
     *                                  Alternatively, you can pass an array of
     *                                  field values.  Normally this contructor is only used by the internal systems that get objects from the database.
     * @param boolean    $isSingleton This this to true if this is a singleton() object, a stub for calling methods.  Singletons
     *                                  don't have their defaults set.
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 02.02.2011
     */
    public function  __construct($record = null, $isSingleton = false) {
        self::$summary_fields = array(
            'Title'                     => _t('SilvercartProductCategoryPage.COLUMN_TITLE'),
            'AttributedZones'           => _t('SilvercartCountry.ATTRIBUTED_ZONES'),
            'AttributedShippingMethods' => _t('SilvercartCarrier.ATTRIBUTED_SHIPPINGMETHODS', 'attributed shipping methods')
        );
        self::$field_labels = array(
            'Title'                     => _t('SilvercartProductCategoryPage.COLUMN_TITLE'),
            'FullTitle'                 => _t('SilvercartCarrier.FULL_NAME', 'full name'),
            'AttributedZones'           => _t('SilvercartCountry.ATTRIBUTED_ZONES'),
            'AttributedShippingMethods' => _t('SilvercartCarrier.ATTRIBUTED_SHIPPINGMETHODS'),
            'SilvercartShippingMethods' => _t('SilvercartShippingMethod.PLURALNAME', 'zones'),
            'SilvercartZones'           => _t('SilvercartZone.PLURALNAME', 'zones')
        );
        self::$searchable_fields = array(
            'Title',
            'SilvercartZones.ID' => array(
                'title' => _t('SilvercartCountry.ATTRIBUTED_ZONES')
            ),
            'SilvercartShippingMethods.ID' => array(
                'title' => _t('SilvercartCarrier.ATTRIBUTED_SHIPPINGMETHODS')
            )
        );
        self::$singular_name = _t('SilvercartCarrier.SINGULARNAME', 'carrier');
        self::$plural_name = _t('SilvercartCarrier.PLURALNAME', 'carriers');
        parent::__construct($record, $isSingleton);
    }

    /**
     * Returns the attributed zones as string (limited to 150 chars).
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public function AttributedZones() {
        $attributedZonesStr = '';
        $attributedZones    = array();
        $maxLength          = 150;

        foreach ($this->SilvercartZones() as $zone) {
            $attributedZones[] = $zone->Title;
        }

        if (!empty($attributedZones)) {
            $attributedZonesStr = implode(', ', $attributedZones);

            if (strlen($attributedZonesStr) > $maxLength) {
                $attributedZonesStr = substr($attributedZonesStr, 0, $maxLength).'...';
            }
        }

        return $attributedZonesStr;
    }

    /**
     * Returns the attributed shipping methods as string (limited to 150 chars).
     *
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 31.01.2011
     */
    public function AttributedShippingMethods() {
        $attributedShippingMethodsStr = '';
        $attributedShippingMethods    = array();
        $maxLength          = 150;

        foreach ($this->SilvercartShippingMethods() as $shippingMethod) {
            $attributedShippingMethods[] = $shippingMethod->Title;
        }

        if (!empty($attributedShippingMethods)) {
            $attributedShippingMethodsStr = implode(', ', $attributedShippingMethods);

            if (strlen($attributedShippingMethodsStr) > $maxLength) {
                $attributedShippingMethodsStr = substr($attributedShippingMethodsStr, 0, $maxLength).'...';
            }
        }

        return $attributedShippingMethodsStr;
    }
}