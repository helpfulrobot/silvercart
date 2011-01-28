<?php

/**
 * Child of AddressHolder, CRUD a single address
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @license BSD
 * @since 18.10.2010
 * @copyright 2010 pixeltricks GmbH
 */
class AddressPage extends Page {

    public static $singular_name = "Adressdetails";
    public static $can_be_root = false;

    /**
     * configure the class name of the DataObjects to be shown on this page
     * this is needed to show correct breadcrumbs
     *
     * @return string class name of the DataObject to be shown on this page
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 3.11.2010
     */
    public function getSection() {
        return 'Address';
    }
}

/**
 * Controller of this page type
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @license BSD
 * @since 19.10.2010
 * @copyright 2010 pixeltricks GmbH
 */
class AddressPage_Controller extends Page_Controller {

    /**
     * statements to be called on instanciation
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 25.10.2010
     * @return void
     */
    public function init() {
        if ($this->urlParams['ID']) {
            Session::set('addressID', $this->urlParams['ID']); //ID is saved to the session because otherwise it will be lost on form submit
        }
        $this->registerCustomHtmlForm('EditAddressForm', new EditAddressForm($this));
        parent::init();
    }
}