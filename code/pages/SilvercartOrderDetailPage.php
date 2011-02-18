<?php

/**
 * show details of a customers orders
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 20.10.2010
 * @license BSD
 */
class SilvercartOrderDetailPage extends Page {

    public static $singular_name = "";
    public static $can_be_root = false;

    /**
     * configure the class name of the DataObjects to be shown on this page
     *
     * @return string class name of the DataObject to be shown on this page
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 3.11.2010
     */
    public function getSection() {
        return 'SilvercartOrder';
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
class SilvercartOrderDetailPage_Controller extends Page_Controller {

    /**
     * returns a single order of a logged in member identified by url param id
     *
     * @return DataObject Order object
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 27.10.10
     */
    public function CustomersOrder() {
        $id         = Convert::raw2sql($this->urlParams['ID']);
        $memberID   = Member::currentUserID();
        $order      = false;
        
        if ($memberID && $id) {
            $order = DataObject::get_one(
                'SilvercartOrder',
                sprintf(
                    "`ID`= '%s' AND `MemberID` = '%s'",
                    $id,
                    $memberID
                )
            );

            return $order;
        }
    }
}