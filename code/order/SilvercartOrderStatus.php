<?php

/**
 * abstract for an order status
 *
 * @package fashionbids
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @copyright 2010 pixeltricks GmbH
 * @since 22.11.2010
 * @license none
 */
class SilvercartOrderStatus extends DataObject {

    /**
     * Singular-Beschreibung zur Darstellung im Backend.
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    static $singular_name = "order status";

    /**
     * Plural-Beschreibung zur Darstellung im Backend.
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    static $plural_name = "order status";

    /**
     * attributes
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $db = array(
        'Title' => 'VarChar',
        'Code' => 'VarChar'
    );
    /**
     * n:m relations
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $has_many = array(
        'SilvercartOrders' => 'SilvercartOrder'
    );

    // -----------------------------------------------------------------------
    // methods
    // -----------------------------------------------------------------------

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
    public function __construct($record = null, $isSingleton = false) {
        self::$singular_name = _t('SilvercartOrderStatus.SINGULARNAME', 'order status');
        self::$plural_name = _t('SilvercartOrderStatus.PLURALNAME', 'order status');
        parent::__construct($record, $isSingleton);
    }

    /**
     * Get any user defined searchable fields labels that
     * exist. Allows overriding of default field names in the form
     * interface actually presented to the user.
     *
     * The reason for keeping this separate from searchable_fields,
     * which would be a logical place for this functionality, is to
     * avoid bloating and complicating the configuration array. Currently
     * much of this system is based on sensible defaults, and this property
     * would generally only be set in the case of more complex relationships
     * between data object being required in the search interface.
     *
     * Generates labels based on name of the field itself, if no static property
     * {@link self::field_labels} exists.
     *
     * @param boolean $includerelations a boolean value to indicate if the labels returned include relation fields
     *
     * @return array|string Array of all element labels if no argument given, otherwise the label of the field
     *
     * @uses $field_labels
     * @uses FormField::name_to_label()
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 16.02.2011
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = parent::fieldLabels($includerelations);
        $fieldLabels['Title']               = _t('SilvercartPage.TITLE', 'title');
        $fieldLabels['Code']                = _t('SilvercartOrderStatus.CODE', 'code');
        $fieldLabels['SilvercartOrders']    = _t('SilvercartOrder.PLURALNAME', 'orders');
        return $fieldLabels;
    }

    /**
     * remove attribute Code from the CMS fields
     *
     * @return FieldSet all CMS fields related
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Code'); //Code values are used for some getters and must not be changed via backend
        return $fields;
    }

    /**
     * create default entries
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public function requireDefaultRecords() {
        parent::requireDefaultRecords();

        $className = $this->ClassName;

        if (!DataObject::get($className)) {

            $defaultStatusEntries = array(
                'pending' => _t('SilvercartOrderStatus.WAITING_FOR_PAYMENT', 'waiting for payment', null, 'Auf Zahlungseingang wird gewartet'),
                'payed' => _t('SilvercartOrderStatus.PAYED', 'payed')
            );

            foreach ($defaultStatusEntries as $code => $title) {
                $obj = new $className();
                $obj->Title = $title;
                $obj->Code = $code;
                $obj->write();
            }
        }
    }

    /**
     * returns array with StatusCode => StatusText
     *
     * @return DataObjectSet
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 23.11.2010
     */
    public static function getStatusList() {
        $statusList = DataObject::get(
                        'SilvercartOrderStatus'
        );

        return $statusList;
    }

}
