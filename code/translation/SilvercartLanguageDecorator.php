<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Translation
 */

/**
 * Adds methods that are common to all language classes eg SilvercartProductLanguage
 * Updates CMS fields and brings the common attribute Locale
 *
 * @package Silvercart
 * @subpackage Translation
 * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
 * @since 04.05.2012
 * @copyright 2013 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartLanguageDecorator extends DataExtension {
    
    /**
     * Extends the database fields
     *
     * @var array
     */
    public static $db = array(
        'Locale' => 'SilvercartDBLocale',
    );
    
    /**
     * Extends the db indexes
     *
     * @var array
     */
    public static $indexes = array(
        'Locale' => '("Locale")',
    );
    
    /**
     * Field lable for Locale should always be multilingual
     *
     * @param array &$labels Lables to update
     *
     * @return void 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.05.2012
     */
    public function updateFieldLabels(&$labels) {
        parent::updateFieldLabels($labels);
        $labels['Locale'] = _t('SilvercartProductLanguage.LOCALE');
    }
    
    /**
     * must return true for the LanguageDropdown field to work properly
     *
     * @return void 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.05.2012
     */
    public function canTranslate() {
        return true;
    }
    
    /**
     * The summary fields should at least show the locale
     * 
     * @param array &$fields Fields to update
     *
     * @return void 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 04.05.2012
     */
    public function updateSummaryFields(&$fields) {
        $fields = array_merge(
                array(
                    'NativeNameForLocale' => _t('SilvercartConfig.TRANSLATION')
                ),
                $fields
        );
    }
    
    /**
     * adjust CMS fields for display in the popup window
     *
     * @param FieldList $fields the FieldList from getCMSFields()
     *
     * @return void 
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 06.01.2012
     */
    public function updateCMSFields(FieldList $fields) {
        $fields = SilvercartLanguageHelper::prepareCMSFields($this->owner->class);
        $localeDropdown = SilvercartLanguageHelper::prepareLanguageDropdownField($this->owner);
        $fields->push($localeDropdown);
    }
    
    /**
     * return the locale as native name
     *
     * @return string native name for the locale 
     */
    public function getNativeNameForLocale() {
        return $this->owner->dbObject('Locale')->getNativeName();
    }
    
    /**
     * Returns the language class relation field name
     *
     * @return string 
     */
    public function getRelationClassName() {
        $relationClassName = substr($this->owner->ClassName, 0, -8);
        return $relationClassName;
    }
    
    /**
     * Returns the language class relation field name
     *
     * @return string 
     */
    public function getRelationFieldName() {
        $relationFieldName = $this->getRelationClassName() . 'ID';
        return $relationFieldName;
    }
    
    /**
     * Returns all translations for this DataObject as an array.
     * Example:
     * <code>
     * array(
     *      'de_DE' => 'de_DE',
     *      'en_US' => 'en_US',
     *      'en_GB' => 'en_GB'
     * );
     * </code>
     * 
     * @return array
     */
    public function getTranslatedLocales() {
        $langs        = array();
        $translations = $this->getTranslations();
        if ($translations) {
            foreach ($translations as $translation) {
                $langs[$translation->Locale] = $translation->Locale;
            }
        }
        return $langs;
    }
    
    /**
     * Returns all translations for this DataObject as DataList
     *
     * @return DataList 
     */
    public function getTranslations() {
        $relationFieldName  = $this->getRelationFieldName();
        $translations       = DataObject::get(
                $this->owner->ClassName,
                sprintf(
                        "\"%s\" = '%s'",
                        $relationFieldName,
                        $this->owner->{$relationFieldName}
                )
        );
        return $translations;
    }
}

