<?php

/**
 * All article properties that need a translation end up here.
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 02.02.2011
 * @license none
 */
class ArticleTexts extends DataObject {

    static $singular_name = "article translation text";
    static $plural_name = "article translation texts";
    public static $db = array(
        'Title' => 'VarChar',
        'LongDescription' => 'Text',
        'ShortDescription' => 'VarChar',
        'MetaDescription' => 'VarChar',
        'MetaTitle' => 'VarChar',
        'MetaKeywords' => 'VarChar'
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
        'owner' => 'Article'
    );
    public static $has_many = array(
    );
    public static $many_many = array(
    );
    public static $belongs_many_many = array(
    );

}
