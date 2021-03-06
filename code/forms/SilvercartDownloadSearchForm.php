<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Forms
 */

/**
 * Form to search throug the downloads of a SilvercartDownloadHolders 
 * SilvercartDownloadPages.
 *
 * @package Silvercart
 * @subpackage Forms
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 14.12.2015
 * @copyright 2015 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartDownloadSearchForm extends CustomHtmlForm {
    
    /**
     * Don't enable Security token for this type of form because we'll run
     * into caching problems when using it.
     * 
     * @var boolean
     */
    protected $securityTokenEnabled = false;

    /**
     * Set to true to exclude this form from caching.
     *
     * @var bool
     */
    protected $excludeFromCache = true;

    /**
     * Set texts for preferences with i18n methods.
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.09.2013
     */
    public function preferences() {
        $this->preferences['submitButtonTitle']         = _t('SilvercartDownloadSearchForm.submitButtonTitle');
        $this->preferences['doJsValidationScrolling']   = false;

        parent::preferences();
    }
    
    /**
     * Returns the forms fields.
     * 
     * @param bool $withUpdate Call the method with decorator updates or not?
     *
     * @return array
     */
    public function getFormFields($withUpdate = true) {
        parent::getFormFields(false);
        if (!array_key_exists('SearchQuery', $this->formFields)) {
            $this->formFields['SearchQuery'] = array(
                'type'              => 'SilvercartTextField',
                'title'             => '',
                'value'             => '',
                'maxLength'         => '30',
                'checkRequirements' => array(
                    'isFilledIn'    => true,
                ),
            );
            if ($withUpdate) {
                $this->extend('updateFormFields', $this->formFields);
            }
        }
        return $this->formFields;
    }

    /**
     * executed if there are no valdation errors on submit.
     *
     * @param SS_HTTPRequest $data     contains the frameworks form data
     * @param Form           $form     not used
     * @param array          $formData contains the modules form data
     *
     * @return array to be rendered in the controller
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.06.2014
     */
    protected function submitSuccess($data, $form, $formData) {
        $children    = $this->Controller()->AllChildren();
        $childrenIDs = $children->map('ID', 'ID');
        $searchQuery = $formData['SearchQuery'];
        $searchTerms = explode(' ', $searchQuery);
        
        
        $searchFilter = sprintf(
                '"SilvercartFileLanguage"."Title" LIKE \'%%%s%%\' OR "SilvercartFileLanguage"."Description" LIKE \'%%%s%%\'',
                $searchQuery,
                $searchQuery
        );
        if (count($searchTerms) > 1) {
            foreach ($searchTerms as $searchTerm) {
                $searchFilter .= sprintf(
                    ' OR "SilvercartFileLanguage"."Title" LIKE \'%%%s%%\' OR "SilvercartFileLanguage"."Description" LIKE \'%%%s%%\'',
                    $searchTerm,
                    $searchTerm
                );
            }
        }
        
        if ($childrenIDs->count() > 0) {
            $filter = sprintf(
                    '(%s) AND "SilvercartFile"."SilvercartDownloadPageID" IN (%s)',
                    $searchFilter,
                    implode(',', $childrenIDs)
            );
        } else {
            $filter = $searchFilter;
        }
        
        $downloads = SilvercartFile::get()->where($filter);
        
        Session::clear('SilvercartDownloadSearchForm.current_results');
        Session::save();
        if ($downloads) {
            Session::set('SilvercartDownloadSearchForm.current_results', $downloads->map('ID','ID'));
        }
        Session::set('SilvercartDownloadSearchForm.current_query', $searchQuery);
        Session::save();
        
        $this->Controller()->redirect($this->Controller()->Link('results'));
    }
    
    /**
     * Returns the current results out of session store.
     * 
     * @return DataList
     */
    public static function get_current_results() {
        $currentResultMap = Session::get('SilvercartDownloadSearchForm.current_results');
        $downloads        = false;
        /* @var $currentResultMap SS_Map */
        if (!is_null($currentResultMap) &&
            $currentResultMap->count() > 0) {
            $downloads = SilvercartFile::get()->where('"SilvercartFile"."ID" IN (' . implode(',', $currentResultMap->toArray()) . ')');
        }
        return $downloads;
    }
    
    /**
     * Returns the current search query out of session store.
     * 
     * @return string
     */
    public static function get_current_query() {
        $currentQuery = Session::get('SilvercartDownloadSearchForm.current_query');
        return $currentQuery;
    }
}
