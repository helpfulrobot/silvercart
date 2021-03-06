<?php
/**
 * Copyright 2014 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Forms
 */

/**
 * The form for subscribing to or unsubscribing from the newsletter.
 *
 * @package Silvercart
 * @subpackage Forms
 * @copyright 2013 pixeltricks GmbH
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @since 22.03.2011
 * @license see license file in modules root directory
 */
class SilvercartNewsletterForm extends CustomHtmlForm {

    /**
     * Form field definitions.
     *
     * @var array
     */
    protected $formFields = array(
        'Salutation' => array(
            'type'  => 'DropdownField',
            'title' => 'Salutation',
            'value' => array(
                ''      => 'Bitte wählen',
                'Frau'  => 'Frau',
                'Herr'  => 'Herr'
            ),
            'checkRequirements' => array(
                'isFilledIn' => true
            )
        ),
        'FirstName' => array(
            'type'  => 'TextField',
            'title' => 'Firstname',
            'checkRequirements' => array(
                'isFilledIn'    => true,
                'hasMinLength'  => 3
            )
        ),
        'Surname' => array(
            'type'  => 'TextField',
            'title' => 'Surname',
            'checkRequirements' => array(
                'isFilledIn'    => true,
                'hasMinLength'  => 3
            )
        ),
        'Email' => array(
            'type'  => 'TextField',
            'title' => 'Email Address',
            'value' => '',
            'checkRequirements' => array(
                'isFilledIn'        => true,
                'isEmailAddress'    => true
            )
        ),
        'NewsletterAction' => array(
            'type'          => 'OptionsetField',
            'title'         => 'What do you want to do?',
            'selectedValue' => '',
            'value' => array(
                '1' => 'I want to subscribe to the newsletter',
                '2' => 'I want to unsubscribe from the newsletter'
            ),
            'checkRequirements' => array(
                'isFilledIn'        => true
            )
        )
    );
    /**
     * Form settings.
     *
     * @var array
     */
    protected $preferences = array(
        'submitButtonTitle'         => 'Abschicken',
        'doJsValidationScrolling'   => false
    );

    /**
     * Here we insert the translations of the field labels.
     * 
     * Registered users don't have to insert their data, they only get the
     * option to subscribe to or unsubscribe from the newsletter.
     *
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>,
     *         Sascha Koehler <skoehler@pixeltricks.de>
     * @since 23.04.2014
     */
    protected function fillInFieldValues() {
        parent::fillInFieldValues();
        $member = SilvercartCustomer::currentRegisteredCustomer();

        $this->clearSessionMessages();

        // Set translations
        $this->formFields['Salutation']['value'] = array(
            ''      => _t('SilvercartEditAddressForm.EMPTYSTRING_PLEASECHOOSE'),
            "Frau"  => _t('SilvercartAddress.MISSES'),
            "Herr"  => _t('SilvercartAddress.MISTER')
        );
        $this->formFields['Salutation']['title']            = _t('SilvercartAddress.SALUTATION');
        $this->formFields['FirstName']['title']             = _t('SilvercartAddress.FIRSTNAME', 'firstname');
        $this->formFields['Surname']['title']               = _t('SilvercartAddress.SURNAME');
        $this->formFields['Email']['title']                 = _t('SilvercartAddress.EMAIL', 'email address');
        $this->formFields['NewsletterAction']['title']      = _t('SilvercartNewsletterForm.ACTIONFIELD_TITLE');
        $this->formFields['NewsletterAction']['value']['1'] = _t('SilvercartNewsletterForm.ACTIONFIELD_SUBSCRIBE');
        $this->formFields['NewsletterAction']['value']['2'] = _t('SilvercartNewsletterForm.ACTIONFIELD_UNSUBSCRIBE');
        $this->preferences['submitButtonTitle']             = _t('SilvercartPage.SUBMIT');

        // Fill in field values for registered customers and set them to readonly.
        if ($member) {
            $this->formFields['Salutation']['checkRequirements']    = array();
            $this->formFields['Salutation']['type']                 = 'ReadonlyField';
            $this->formFields['Salutation']['value']                = $member->Salutation;
            $this->formFields['FirstName']['checkRequirements']     = array();
            $this->formFields['FirstName']['type']                  = 'ReadonlyField';
            $this->formFields['FirstName']['value']                 = $member->FirstName;
            $this->formFields['Surname']['checkRequirements']       = array();
            $this->formFields['Surname']['type']                    = 'ReadonlyField';
            $this->formFields['Surname']['value']                   = $member->Surname;
            $this->formFields['Email']['checkRequirements']         = array();
            $this->formFields['Email']['type']                      = 'ReadonlyField';
            $this->formFields['Email']['value']                     = $member->Email;

            // Remove action field according to newsletter status of the customer
            if ($member->SubscribedToNewsletter) {
                $this->formFields['NewsletterAction']['value'] = array(
                    '2' => _t('SilvercartNewsletterForm.ACTIONFIELD_UNSUBSCRIBE')
                );
                $this->formFields['NewsletterAction']['title'] = _t('SilvercartNewsletter.SUBSCRIBED').' - '.$this->formFields['NewsletterAction']['title'];
            } else {
                $this->formFields['NewsletterAction']['value'] = array(
                    '1' => _t('SilvercartNewsletterForm.ACTIONFIELD_SUBSCRIBE')
                );
                $this->formFields['NewsletterAction']['title'] = _t('SilvercartNewsletter.UNSUBSCRIBED').' - '.$this->formFields['NewsletterAction']['title'];
            }
        }
    }

    /**
     * We save the data of the user here.
     *
     * @param SS_HTTPRequest $data     contains the frameworks form data
     * @param Form           $form     not used
     * @param array          $formData contains the modules form data
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 22.03.2011
     */
    protected function submitSuccess($data, $form, $formData) {
        $member = SilvercartCustomer::currentRegisteredCustomer();

        if ($member) {
            $formData['Salutation'] = $member->Salutation;
            $formData['FirstName']  = $member->FirstName;
            $formData['Surname']    = $member->Surname;
            $formData['Email']      = $member->Email;
            // ----------------------------------------------------------------
            // For registered and logged in customers all we have to do is set
            // the respective field in the customer object.
            // ----------------------------------------------------------------
            switch ($formData['NewsletterAction']) {
                case '1':
                    SilvercartNewsletter::subscribeRegisteredCustomer($member);
                    $this->setSessionMessage(
                        sprintf(
                            _t('SilvercartNewsletterStatus.SUBSCRIBED_SUCCESSFULLY'),
                            $formData['Email']
                        )
                    );
                    break;
                case '2':
                default:
                    SilvercartNewsletter::unSubscribeRegisteredCustomer($member);
                    $this->setSessionMessage(
                        sprintf(
                            _t('SilvercartNewsletterStatus.UNSUBSCRIBED_SUCCESSFULLY'),
                            $formData['Email']
                        )
                    );
            }
        } else {
            
            // ----------------------------------------------------------------
            // For unregistered customers we have to add / remove them from
            // the datastore for unregistered newsletter recipients.
            //
            // If the given email address belongs to a registered customer we
            // should not do anything but ask the user to log in first.
            // ----------------------------------------------------------------
            if (SilvercartNewsletter::isEmailAllocatedByRegularCustomer($formData['Email'])) {
                $this->setSessionMessage(
                    sprintf(
                        _t('SilvercartNewsletterStatus.REGULAR_CUSTOMER_WITH_SAME_EMAIL_EXISTS'),
                        $formData['Email'],
                        '/Security/Login/?BackURL='.$this->controller->PageByIdentifierCode('SilvercartNewsletterPage')->Link()
                    )
                );
            } else {
                if ($formData['NewsletterAction'] == '1') {
                    // --------------------------------------------------------
                    // Subscribe to newsletter.
                    // If the user is already subscribed we display a
                    // message accordingly.
                    // --------------------------------------------------------
                    if (SilvercartNewsletter::isEmailAllocatedByAnonymousRecipient($formData['Email'])) {
                        $this->setSessionMessage(
                            sprintf(
                                _t('SilvercartNewsletterStatus.ALREADY_SUBSCRIBED'),
                                $formData['Email']
                            )
                        );
                    } else {
                        SilvercartNewsletter::subscribeAnonymousCustomer($formData['Salutation'], $formData['FirstName'], $formData['Surname'], $formData['Email']);
                        $this->setSessionMessage(
                            sprintf(
                                _t('SilvercartNewsletterStatus.SUBSCRIBED_SUCCESSFULLY_FOR_OPT_IN'),
                                $formData['Email']
                            )
                        );
                    }
                } else {
                    // --------------------------------------------------------
                    // Unsubscribe from newsletter.
                    // If no email address exists we display a message
                    // accordingly.
                    // --------------------------------------------------------
                    if (SilvercartNewsletter::isEmailAllocatedByAnonymousRecipient($formData['Email'])) {
                        SilvercartNewsletter::unSubscribeAnonymousCustomer($formData['Email']);
                        $this->setSessionMessage(
                            sprintf(
                                _t('SilvercartNewsletterStatus.UNSUBSCRIBED_SUCCESSFULLY'),
                                $formData['Email']
                            )
                        );
                    } else {
                        $this->setSessionMessage(
                            sprintf(
                                _t('SilvercartNewsletterStatus.NO_EMAIL_FOUND'),
                                $formData['Email']
                            )
                        );
                    }
                }
            }
        }

        $redirectLink = '/';
        $responsePage = SilvercartPage_Controller::PageByIdentifierCode("SilvercartNewsletterResponsePage");

        if ($responsePage) {
            $redirectLink = $responsePage->RelativeLink();
        }

       $this->controller->redirect($redirectLink);
    }

    /**
     * Set a session message that can be recalled on the status page.
     *
     * @param string $message The message to store
     *
     * @return void
     */
    public function setSessionMessage($message) {
        $status = Session::get('SilvercartNewsletterStatus');

        // Initialise session data structure
        if (!$status ||
            !is_array($status)) {
            
            $status = array(
                'messages' => array()
            );
        } else {
            if (!isset($status['messages']) ||
                !is_array($status['messages'])) {

                $status['messages'] = array();
            }
        }

        // Add message and save to session
        $status['messages'][] = array(
            'message' => $message
        );
        
        Session::set('SilvercartNewsletterStatus', $status);
    }

    /**
     * Clear all session messages that could be recalled on the status page.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 22.03.2011
     */
    public function clearSessionMessages() {
        Session::clear('SilvercartNewsletterStatus');
    }
}