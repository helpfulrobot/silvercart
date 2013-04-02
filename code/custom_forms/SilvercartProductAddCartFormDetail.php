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
 * @subpackage Forms
 */

/**
 * dummy form definition for ProductAddCartForm. It is used to register with
 * ProductPage (only) to provide a seperate template for all different product
 * views (detail, list, tile).
 *
 * @package Silvercart
 * @subpackage Forms
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2010 pixeltricks GmbH
 * @since 14.02.2011
 * @license see license file in modules root directory
 */
class SilvercartProductAddCartFormDetail extends SilvercartProductAddCartForm {

    /**
     * Insert additional fields for this form from registered plugins.
     *
     * @return string
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 16.11.2011
     */
    public function AddCartFormDetailAdditionalFields() {
        return SilvercartPlugin::call($this, 'AddCartFormDetailAdditionalFields', array($this));
    }
}