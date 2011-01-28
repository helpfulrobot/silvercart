<?php

/**
 * shows and processes a registration form;
 * configuration of registration mails;
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 20.10.2010
 * @license BSD
 */
class RegistrationPage extends Page {

    public static $singular_name    = "Registrierungsseite";
    public static $plural_name      = "Registrierungsseiten";

    public static $db = array(
        'ActivationMailSubject' => 'Varchar(255)',
        'ActivationMailMessage' => 'HTMLText'
    );

    public static $defaults = array(
        'ActivationMailSubject' => 'Ihre Registrierung',
        'ActivationMailMessage' => 'Sehr geehrter Kunde\,'
    );

    /**
     * Return all fields of the backend
     *
     * @return FieldSet Fields of the CMS
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 20.10.2010
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();

        $activationMailSubjectField = new TextField('ActivationMailSubject', 'Aktivierungsmail: Betreff');
        $activationMailTextField    = new HtmlEditorField('ActivationMailMessage', 'Aktivierungsmail: Nachricht', 20);

        $fields->addFieldToTab('Root.Content.ActivationMail', $activationMailSubjectField);
        $fields->addFieldToTab('Root.Content.ActivationMail', $activationMailTextField);

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

        $records = DataObject::get_one($this->ClassName);
        if (!$records) {
            $page               = new RegistrationPage();
            $page->Title        = "Registrierung";
            $page->URLSegment   = "registrierung";
            $page->Status       = "Published";
            $page->ShowInMenus  = false;
            $page->ShowInSearch = true;
            $page->write();
            $page->publish("Stage", "Live");
        }
        $confirmationPage = DataObject::get_one('RegisterConfirmationPage', "\"URLSegment\" = 'bestaetigung'");
        if (!$confirmationPage) {
            $confirmationPage               = new RegisterConfirmationPage();
            $confirmationPage->Title        = "Bestätigunsseite";
            $confirmationPage->URLSegment   = "bestaetigung";
            $confirmationPage->Status       = "Published";
            if ($page instanceof RegistrationPage) {
                $confirmationPage->ParentID = $page->ID;
            }
            $confirmationPage->ShowInMenus  = false;
            $confirmationPage->ShowInSearch = false;
            $confirmationPage->write();
            $confirmationPage->publish("Stage", "Live");
        }

        $welcomePage = DataObject::get_one('Page', "\"URLSegment\" = 'begruessung'");
        if (!$welcomePage) {
            $welcomePage                = new Page();
            $welcomePage->Title         = "Begrüßung";
            $welcomePage->URLSegment    = "begruessung";
            $welcomePage->Status        = "Published";
            if ($page instanceof RegistrationPage) {
                $welcomePage->ParentID = $page->ID;
            }
            $welcomePage->ShowInMenus   = false;
            $welcomePage->ShowInSearch  = false;
            $welcomePage->write();
            $welcomePage->publish("Stage", "Live");
        }
        $shopEmailRegistrationOptIn = DataObject::get_one(
            'ShopEmail',
            "Identifier = 'RegistrationOptIn'"
        );
        if (!$shopEmailRegistrationOptIn) {
            $shopEmailRegistrationOptIn = new ShopEmail();
            $shopEmailRegistrationOptIn->setField('Identifier', 'RegistrationOptIn');
            $shopEmailRegistrationOptIn->setField('Subject',    'Bestätigen Sie bitte Ihre Registrierung');
            $shopEmailRegistrationOptIn->setField('EmailText',  '<h1>Registrierung abschließen</h1>

<p>Bitte bestätigen sie ihren Aktivierungs-Link, oder Kopieren sie den untenstehenden Link und fügen ihn in Ihren Browser ein.</p>

<p>
    <a href="$ConfirmationLink">Registrierung bestätigen</a>
</p>

<p>Falls die Registrierung unbeabsichtigt vorgenommen wurde, ignorieren sie diese E-Mail.</p>

<p>Ihr Team</p>');
            $shopEmailRegistrationOptIn->write();
        }
        $shopEmailRegistrationConfirmation = DataObject::get_one(
            'ShopEmail',
            "Identifier = 'RegistrationConfirmation'"
        );
        if (!$shopEmailRegistrationConfirmation) {
            $shopEmailRegistrationConfirmation = new ShopEmail();
            $shopEmailRegistrationConfirmation->setField('Identifier', 'RegistrationConfirmation');
            $shopEmailRegistrationConfirmation->setField('Subject',    'Danke für Ihre Registrierung');
            $shopEmailRegistrationConfirmation->setField('EmailText',  '<h1>Registrierung erfolgreich abgeschlossen!</h1>

<p>Vielen Dank für Ihre Registrierung und das entgegengebrachte Vertrauen.</p>

<p>Wir wünschen Ihnen eine schöne Zeit auf unserer Webseite!</p>

<p>Ihr Team</p>');
            $shopEmailRegistrationConfirmation->write();
        }
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
class RegistrationPage_Controller extends Page_Controller {

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
        $this->registerCustomHtmlForm('RegisterRegularCustomerForm', new RegisterRegularCustomerForm($this));
        parent::init();
    }
}