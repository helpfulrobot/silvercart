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
 * @package SilverCart
 * @subpackage translation
 */

/**
 * 
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 23.01.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartTextWidgetLanguage extends DataObject {
    
    /**
     * Attributes.
     *
     * @var array
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 22.01.2012
     */
    public static $db = array(
        'FreeText' => 'HTMLText'
    );
    
    /**
     * 1:1 or 1:n relationships.
     *
     * @var array
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 22.01.2012
     */
    public static $has_one = array(
        'SilvercartTextWidget' => 'SilvercartTextWidget'
    );
    /**
     * Returns the translated singular name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string The objects singular name 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 22.01.2012
     */
    public function singular_name() {
        if (_t('SilvercartTextWidgetLanguage.SINGULARNAME')) {
            return _t('SilvercartTextWidgetLanguage.SINGULARNAME');
        } else {
            return parent::singular_name();
        } 
    }


    /**
     * Returns the translated plural name of the object. If no translation exists
     * the class name will be returned.
     * 
     * @return string the objects plural name
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 22.01.2012
     */
    public function plural_name() {
        if (_t('SilvercartTextWidgetLanguage.PLURALNAME')) {
            return _t('SilvercartTextWidgetLanguage.PLURALNAME');
        } else {
            return parent::plural_name();
        }

    }
}

