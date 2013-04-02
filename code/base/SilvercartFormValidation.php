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
 * @subpackage Base
 */

/**
 * Provides callbacks for a form validation
 *
 * @package Silvercart
 * @subpackage Base
 * @author Patrick Schneider <pschneider@pixeltricks.de>
 * @since 09.11.2012
 * @copyright 2012 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartFormValidation extends Object {
    /**
     * used as Form callback: Does the entered Email already exist?
     *
     * @param string $value           The email address to be checked
     * @param int    $allowedMemberID ID of a member to ignore this check for
     *
     * @return array to be rendered in the template
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Patrick Schneider <pschneider@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 05.02.2013
     */
    public static function doesEmailExistAlready($value, $allowedMemberID = null) { 
        $emailExistsAlready = false;

        $member = DataObject::get_one(
            'Member',
            "Email = '" . $value . "'"
        );

        if ($member instanceof Member &&
            $member->ID != $allowedMemberID) {
            $emailExistsAlready = true;
        }

        return array(
            'success' => !$emailExistsAlready,
            'errorMessage' => _t('SilvercartPage.EMAIL_ALREADY_REGISTERED', 'This Email address is already registered')
        );
    }
}