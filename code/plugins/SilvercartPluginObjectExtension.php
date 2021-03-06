<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Plugins
 */

/**
 * Methods for objects that want to provide plugin support.
 *
 * @package Silvercart
 * @subpackage Plugins
 * @author Sascha Koehler <skoehler@pixeltricks.de>, Ramon Kupper <rkupperpixeltricks.de>
 * @since 01.01.2014
 * @license see license file in modules root directory
 * @copyright 2014 pixeltricks GmbH
 */
class SilvercartPluginObjectExtension extends DataExtension {
    
    /**
     * Passes through calls to SilvercartPlugins.
     *
     * @param string $method The name of the method to call
     *
     * @return mixed
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 22.09.2011
     */
    public function SilvercartPlugin($method) {
        return SilvercartPlugin::call($this->owner, $method);
    }
    
    // ------------------------------------------------------------------------
    // CustomHtmlForm related methods
    // ------------------------------------------------------------------------
    
    /**
     * This method will be called after CustomHtmlForm's default submitFailure.
     * You can manipulate the relevant data here.
     * 
     * @param SS_HTTPRequest &$data submit data
     * @param Form           &$form form object
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function onAfterSubmitFailure(&$data, &$form) {
    }
    
    /**
     * This method will be called after CustomHtmlForm's default submitSuccess.
     * You can manipulate the relevant data here.
     * 
     * @param SS_HTTPRequest &$data     submit data
     * @param Form           &$form     form object
     * @param array          &$formData secured form data
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function onAfterSubmitSuccess(&$data, &$form, &$formData) {
    }
    
    /**
     * This method will be called before CustomHtmlForm's default submitFailure.
     * You can manipulate the relevant data here.
     * 
     * @param SS_HTTPRequest &$data submit data
     * @param Form           &$form form object
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function onBeforeSubmitFailure(&$data, &$form) {
    }
    
    /**
     * This method will be called before CustomHtmlForm's default submitSuccess.
     * You can manipulate the relevant data here.
     * 
     * @param SS_HTTPRequest &$data     submit data
     * @param Form           &$form     form object
     * @param array          &$formData secured form data
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function onBeforeSubmitSuccess(&$data, &$form, &$formData) {
    }
    
    /**
     * This method will replace CustomHtmlForm's default submitFailure. It's
     * important that this method returns sth. to ensure that the default 
     * submitFailure won't be called. The return value should be a rendered 
     * template or sth. similar.
     * You can also trigger a direct or redirect and return what ever you want
     * (perhaps boolean true?).
     * 
     * @param SS_HTTPRequest &$data submit data
     * @param Form           &$form form object
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function overwriteSubmitFailure(&$data, &$form) {
    }
    
    /**
     * This method will replace CustomHtmlForm's default submitSuccess. It's
     * important that this method returns sth. to ensure that the default 
     * submitSuccess won't be called. The return value should be a rendered 
     * template or sth. similar.
     * You can also trigger a direct or redirect and return what ever you want
     * (perhaps boolean true?).
     * 
     * @param SS_HTTPRequest &$data     submit data
     * @param Form           &$form     form object
     * @param array          &$formData secured form data
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function overwriteSubmitSuccess(&$data, &$form, &$formData) {
    }
    
    /**
     * This method is called before CustomHtmlForm requires the form fields. You 
     * can manipulate the default form fields here.
     * 
     * @param array &$formFields Form fields to manipulate
     * 
     * @return bool
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.11.2011
     */
    public function updateFormFields(&$formFields) {
        $formFields = SilvercartPlugin::call($this->owner, 'updateFormFields', $formFields, true, array());
        
        if ($formFields &&
            is_array($formFields) &&
            count($formFields) > 0) {
            
            $formFields = $formFields[0];
        }
    }
    
    /**
     * This method is called before CustomHtmlForm set the preferences. You 
     * can manipulate the default preferences here.
     * 
     * @param array &$preferences Preferences to manipulate
     * 
     * @return bool
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>, Sebastian Diel <sdiel@pixeltricks.de>
     * @since 23.03.2012
     */
    public function updatePreferences(&$preferences) {
        $extendedPreferences = SilvercartPlugin::call($this->owner, 'updatePreferences', $preferences, true, array());
        
        if ($extendedPreferences &&
            is_array($extendedPreferences) &&
            count($extendedPreferences) > 0) {
            $preferences = $preferences[0];
        }
    }
}
