<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Widgets
 */

/**
 * form definition
 *
 * @package Silvercart
 * @subpackage Widgets
 * @author Sascha Koehler <skoehler@pixeltricks.de>,
 *         Sebastian Diel <sdiel@pixeltricks.de>
 * @since 26.06.2013
 * @copyright pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SilvercartSearchWidgetForm extends CustomHtmlForm {
    
    /**
     * Don't enable Security token for this type of form because we'll run
     * into caching problems when using it.
     * 
     * @var boolean
     */
    protected $securityTokenEnabled = false;

    /**
     * Form field definition
     *
     * @var array
     */
    protected $formFields = array(
        'quickSearchQuery' => array(
            'type'              => 'SilvercartTextField',
            'title'             => '',
            'value'             => '',
            'checkRequirements' => array(
                'isFilledIn' => true
            )
        )
    );
    
    /**
     * Custom form action to use for this form
     *
     * @var string
     */
    protected $customHtmlFormAction = 'doSearch';
    
    /**
     * Creates a form object with a free configurable markup.
     * Adds the current locale to the custom params.
     *
     * @param ContentController $controller  the calling controller instance
     * @param array             $params      optional parameters
     * @param array             $preferences optional preferences
     * @param bool              $barebone    defines if a form should only be instanciated or be used too
     *
     * @return CustomHtmlForm
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.06.2013
     */
    public function __construct($controller, $params = null, $preferences = null, $barebone = false) {
        if (is_null($params)) {
            $params = array();
        }
        $params['locale'] = Translatable::get_current_locale();
        parent::__construct($controller, $params, $preferences, $barebone);
    }

    /**
     * Save search query in session and Redirect to the search results page.
     *
     * @param SS_HTTPRequest $data     contains the frameworks form data
     * @param Form           $form     not used
     * @param array          $formData contains the modules form data
     *
     * @return array to be rendered in the controller
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.06.2013
     */
    protected function submitSuccess($data, $form, $formData) {
        $handler = new SilvercartActionHandler();
        $handler->doSearch($this->controller->getRequest());
    }

    /**
     * Set texts for preferences with i18n methods.
     *
     * @return void
     * 
     * @author Sascha Koehler <skoehler@pixeltricks.de>,
     *         Sebastian Diel <sdiel@pixeltricks.de>
     * @since 26.06.2013
     */
    public function preferences() {
        $this->preferences['submitButtonTitle']         = _t('SilvercartSearchWidgetForm.SUBMITBUTTONTITLE');
        $this->preferences['doJsValidationScrolling']   = false;
        
        $this->formFields['quickSearchQuery']['title'] = _t('SilvercartSearchWidgetForm.SEARCHLABEL');

        parent::preferences();
    }
}
