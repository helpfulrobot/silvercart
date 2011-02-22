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
 * backend interface to CRUD the defined classes
 * 
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 23.10.2010
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartProductAdmin extends ModelAdmin {

    /**
     * Managed models
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 02.02.2011
     */
    public static $managed_models = array(
        'SilvercartProduct',
        'SilvercartManufacturer',
        'SilvercartProductImageGallery'
    );

    /**
     * The URL segment
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 02.02.2011
     */
    public static $url_segment = 'products';

    /**
     * The menu title
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 02.02.2011
     */
    public static $menu_title = 'Produkte';

    /**
     * constructor
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 02.02.2011
     */
    public function  __construct() {
        self::$menu_title = _t('SilvercartProduct.SINGULARNAME');

        parent::__construct();
    }
}