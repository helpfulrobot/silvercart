<?php

/**
 * shows and processes a registration form;
 * configuration of registration mails;
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 20.10.2010
 * @license LGPL
 */
class SilvercartRegistrationPage extends Page {

    public static $singular_name = "";
    public static $db = array(
        'ActivationMailSubject' => 'Varchar(255)',
        'ActivationMailMessage' => 'HTMLText'
    );
    public static $defaults = array(
    );

    /**
     * Constructor
     *
     * @param array|null $record      This will be null for a new database record.  Alternatively, you can pass an array of
     *                                field values.  Normally this contructor is only used by the internal systems that get objects from the database.
     * @param boolean    $isSingleton This this to true if this is a singleton() object, a stub for calling methods.  Singletons
     *                                don't have their defaults set.
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 2.2.2011
     */
    public function __construct($record = null, $isSingleton = false) {
        self::$defaults = array(
            'ActivationMailSubject' => _t('SilvercartRegistrationPage.YOUR_REGISTRATION', 'your registration'),
            'ActivationMailMessage' => _t('SilvercartRegistrationPage.CUSTOMER_SALUTATION', 'Dear customer\,')
        );
        parent::__construct($record, $isSingleton);
    }

    /**
     * Return all fields of the backend
     *
     * @return FieldSet Fields of the CMS
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $activationMailSubjectField = new TextField('ActivationMailSubject', _t('SilvercartRegistrationPage.ACTIVATION_MAIL_SUBJECT', 'activation mail subject'));
        $activationMailTextField = new HtmlEditorField('ActivationMailMessage', _t('SilvercartRegistrationPage.ACTIVATION_MAIL_TEXT', 'activation mail text'), 20);
        $tabParam = "Root.Content." . _t('SilvercartRegistrationPage.ACTIVATION_MAIL', 'activation mail');
        $fields->addFieldToTab($tabParam, $activationMailSubjectField);
        $fields->addFieldToTab($tabParam, $activationMailTextField);

        return $fields;
    }

    /**
     * Default entries for a fresh installation
     * Child pages are also created
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     * @return void
     */
    public function requireDefaultRecords() {
        parent::requireDefaultRecords();
        $page = '';

        $records = DataObject::get_one('SilvercartRegistrationPage');
        if (!$records) {
            $page = new SilvercartRegistrationPage();
            $page->Title = _t('SilvercartRegistrationPage.TITLE', 'registration page');
            $page->URLSegment = _t('SilvercartRegistrationPage.URL_SEGMENT', 'registration');
            $page->Status = "Published";
            $page->ShowInMenus = false;
            $page->ShowInSearch = true;
            $page->write();
            $page->publish("Stage", "Live");
        }
        $confirmationPage = DataObject::get_one('SilvercartRegisterConfirmationPage');
        if (!$confirmationPage) {
            $confirmationPage = new SilvercartRegisterConfirmationPage();
            $confirmationPage->Title = _t('SilvercartRegisterConfirmationPage.TITLE', 'register confirmation page');
            $confirmationPage->URLSegment = _t('SilvercartRegisterConfirmationPage.URL_SEGMENT', 'register-confirmation');
            $confirmationPage->Content = _t('SilvercartRegisterConfirmationPage.CONTENT');
            $confirmationPage->ConfirmationFailureMessage = _t('SilvercartRegisterConfirmationPage.CONFIRMATIONFAILUREMESSAGE');
            $confirmationPage->ConfirmationSuccessMessage = _t('SilvercartRegisterConfirmationPage.CONFIRMATIONSUCCESSMESSAGE');
            $confirmationPage->AlreadyConfirmedMessage = _t('SilvercartRegisterConfirmationPage.ALREADYCONFIRMEDMESSAGE');
            $confirmationPage->Status = "Published";
            if ($page instanceof SilvercartRegistrationPage) {
                $confirmationPage->ParentID = $page->ID;
            }
            $confirmationPage->ShowInMenus = false;
            $confirmationPage->ShowInSearch = false;
            $confirmationPage->write();
            $confirmationPage->publish("Stage", "Live");
        }

        $whereClause = sprintf("`URLSegment` = '%s'", _t('SilvercartPage.WELCOME_PAGE_URL_SEGMENT', 'welcome'));
        $welcomePage = DataObject::get_one('Page', $whereClause);
        if (!$welcomePage) {
            $welcomePage = new Page();
            $welcomePage->Title = _t('SilvercartPage.WELCOME_PAGE_TITLE', 'welcome');
            $welcomePage->URLSegment = _t('SilvercartPage.WELCOME_PAGE_URL_SEGMENT');
            $welcomePage->Content = _t('SilvercartRegisterWelcomePage.CONTENT');
            $welcomePage->Status = "Published";
            if ($page instanceof SilvercartRegistrationPage) {
                $welcomePage->ParentID = $page->ID;
            }
            $welcomePage->ShowInMenus = false;
            $welcomePage->ShowInSearch = false;
            $welcomePage->write();
            $welcomePage->publish("Stage", "Live");
        }
        $shopEmailRegistrationOptIn = DataObject::get_one(
                        'SilvercartShopEmail',
                        "Identifier = 'RegistrationOptIn'"
        );
        if (!$shopEmailRegistrationOptIn) {
            $shopEmailRegistrationOptIn = new SilvercartShopEmail();
            $shopEmailRegistrationOptIn->setField('Identifier', 'RegistrationOptIn');
            $shopEmailRegistrationOptIn->setField('Subject', _t('SilvercartRegistrationPage.PLEASE_COFIRM', 'please confirm Your registration'));
            $shopEmailRegistrationOptIn->setField('EmailText', _t('SilvercartRegistrationPage.CONFIRMATION_TEXT', '<h1>Complete registration</h1><p>Please confirm Your activation or copy the link to Your Browser.</p><p><a href="$ConfirmationLink">Confirm registration</a></p><p>In case You did not register please ignore this mail.</p><p>Your shop team</p>'));
            $shopEmailRegistrationOptIn->write();
        }
        $shopEmailRegistrationConfirmation = DataObject::get_one(
                        'SilvercartShopEmail',
                        "Identifier = 'RegistrationConfirmation'"
        );
        if (!$shopEmailRegistrationConfirmation) {
            $shopEmailRegistrationConfirmation = new SilvercartShopEmail();
            $shopEmailRegistrationConfirmation->setField('Identifier', 'RegistrationConfirmation');
            $shopEmailRegistrationConfirmation->setField('Subject', _t('SilvercartRegistrationPage.THANKS', 'Many thanks for Your registration'));
            $shopEmailRegistrationConfirmation->setField('EmailText', _t('SilvercartRegistrationPage.SUCCESS_TEXT', '<h1>Registration completed successfully!</h1><p>Many thanks for Your registration.</p><p>Have a nice time on our website!</p><p>Your webshop team</p>'));
            $shopEmailRegistrationConfirmation->write();
        }
    }

}

/**
 * Controller of this page type
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @license LGPL
 * @since 19.10.2010
 * @copyright 2010 pixeltricks GmbH
 */
class SilvercartRegistrationPage_Controller extends Page_Controller {

    /**
     * initialisation of the form object
     * logged in members get logged out
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de> Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 20.10.2010
     * @return void
     */
    public function init() {
        $member = Member::currentUser();
        if ($member) {
            $member->logOut();
        }
        $this->registerCustomHtmlForm('SilvercartRegisterRegularCustomerForm', new SilvercartRegisterRegularCustomerForm($this));
        parent::init();
    }

}