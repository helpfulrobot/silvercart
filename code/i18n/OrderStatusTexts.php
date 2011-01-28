<?php

/**
 *
 * @author Roland Lehmann
 * @copyright Pixeltricks GmbH
 */
class OrderStatusTexts extends DataObject {

    static $singular_name = "";
    static $plural_name = "";
    public static $db = array(
        'Title' => 'VarChar',
        'Description' => 'Text'
    );
    /**
     * Enable translatable
     * @var <type> array
     * @author Roland Lehmann
     */
    static $extensions = array(
        "Translatable"
    );
    public static $has_one = array(
    );
    public static $has_many = array(
    );
    public static $many_many = array(
    );
    public static $belongs_many_many = array(
    );

    //public static $searchable_fields = array();
    //public static $summary_fields = array();

    function requireDefaultRecords() {
        parent::requireDefaultRecords();
        $className = $this->ClassName;
        $objectAmount = 0;
        if (!DataObject::get($className)) {
            for ($i = 1; $i <= $objectAmount; $i++) {
                $obj = new $className();
                $obj->Title = $className . $i;
                $obj->write();
            }
        }
    }

}