<?php
/**
 * Copyright 2014 pixeltricks GmbH
 *
 * This file is part of SilverCart.
*
* @package Silvercart
* @subpackage ModelAdmins
*/

/**
* ModelAdmin for SilvercartImage.
* 
* @package Silvercart
* @subpackage ModelAdmins
 * @author Sebastian Diel <sdiel@pixeltricks.de>,
 *         Sascha Koehler <skoehler@pixeltricks.de>
 * @copyright 2014 pixeltricks GmbH
 * @since 03.03.2014
* @license see license file in modules root directory
*/
class SilvercartImageAdmin extends SilvercartModelAdmin {

    /**
    * The code of the menu under which this admin should be shown.
    * 
    * @var string
    */
    public static $menuCode = 'files';

    /**
    * The section of the menu under which this admin should be grouped.
    * 
    * @var string
    */
    public static $menuSortIndex = 20;

    /**
    * The URL segment
    *
    * @var string
    */
    public static $url_segment = 'silvercart-silvercart-image';

    /**
    * The menu title
    *
    * @var string
    */
    public static $menu_title = 'Silvercart Images';

    /**
    * Managed models
    *
    * @var array
    */
    public static $managed_models = array(
        'SilvercartImage',
        'SilvercartImageSliderImage',
    );

}