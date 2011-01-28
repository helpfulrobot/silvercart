<?php
/**
 * Bestellung
 *
 * @package fashionbids
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @copyright 2010 pixeltricks GmbH
 * @since 22.11.2010
 * @license none
 */
class Order extends DataObject {

    /**
     * Singular-Beschreibung zur Darstellung im Backend.
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $singular_name = "Bestellung";
    /**
     * Plural-Beschreibung zur Darstellung im Backend.
     *
     * @var string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $plural_name = "Bestellungen";
    /**
     * Attribute
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $db = array(
        'PriceTotal'                    => 'Money', // Wert aller Artikel
        'AmountTotal'                   => 'Money', // Wert aller Artikel + Transaktionskosten
        'HandlingCostPayment'           => 'Money',
        'HandlingCostShipment'          => 'Money',
        'Tax'                           => 'Float',
        'Note'                          => 'Text',
        'isConfirmed'                   => 'Boolean',
        'WeightTotal'                   => 'Int', //unit is gramm
        'CarrierAndShippingMethodTitle' => 'VarChar(100)',
        'PaymentMethodTitle'            => 'VarChar(100)',
        'CustomersEmail'                => 'VarChar(60)'
    );

    public static $summary_fields = array(
        'Created'               => 'Datum',
        'customer.FirstName'    => 'Vorname Kunde',
        'customer.Surname'      => 'Nachname Kunde'
    );

    public static $casting = array(
        'Created' => 'Date'
    );

    public static $field_labels = array(
        'ShippingRate'      => 'Versandkosten',
        'Note'              => 'Kundenbemerkungen',
        'isConfirmed'       => 'bestätigt?',
        'customer'          => 'Kunde',
        'shippingAddress'   => 'Versandadresse',
        'invoiceAddress'    => 'Rechnungsadresse',
        'status'            => 'Bestellstatus'
    );
    
    public static $default_sort = "Created DESC";

    /**
     * Makes the column in a backend table sortable
     *
     * @var array
     */
    public static $searchable_fields = array(
        'Created',
        'customer.FirstName'

    );

    /**
     * 1:n Beziehungen
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $has_one = array(
        'shippingAddress'   => 'OrderShippingAddress',
        'invoiceAddress'    => 'OrderInvoiceAddress',
        'payment'           => 'PaymentMethod',
        'shippingMethod'    => 'ShippingMethod',
        'status'            => 'OrderStatus',
        'customer'          => 'Member',
        'shippingFee'       => 'ShippingFee'
    );

    /**
     * 1:n Beziehungen
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public static $has_many = array(
        'orderPositions' => 'OrderPosition'
    );

    public static $many_many = array(
        'articles' => 'Article'
    );
    
    /**
     * Extensions fuer dieses DataObject registrieren.
     *
     * @var array
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 24.11.2010
     */
    static $extensions = array(
        "Versioned('Live')",
    );


    /**
     * customize backend fields
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 1.11.2010
     * @return FieldSet the form fields for the backend
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $fields->removeByName('Versandadresse');
        $fields->removeByName('Rechnungsadresse');
        $shippingAddressTable = new HasOneComplexTableField($this, 'shippingAddress', 'OrderShippingAddress', array('Postcode' => 'PLZ'), 'getCMSFields_forPopup');
        $fields->addFieldToTab('Root.Versandadresse', $shippingAddressTable);
        return $fields;
    }

    /**
     * create a invoice address for an order from customers data
     *
     * @param array $registrationData checkout forms submit data; only needed for anonymous customers
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 16.11.2010
     * @return void
     */
    public function createInvoiceAddress($registrationData = "") {
        $member = Member::currentUser();
        $orderInvoiceAddress = new OrderInvoiceAddress();
        if ($member->ClassName != "AnonymousCustomer") {//for registered users

            /*
             * a member might not have an invoice address Surname/FirstName
             */
            if ($member->invoiceAddress()->Surname) {
                $orderInvoiceAddress->Surname = $member->invoiceAddress()->Surname;
            } else {
                $orderInvoiceAddress->Surname = $member->Surname;
            }
            if ($member->invoiceAddress()->FirstName) {
                $orderInvoiceAddress->FirstName = $member->invoiceAddress()->FirstName;
            } else {
                $orderInvoiceAddress->FirstName = $member->FirstName;
            }
            $orderInvoiceAddress->Street = $member->invoiceAddress()->Street;
            $orderInvoiceAddress->StreetNumber = $member->invoiceAddress()->StreetNumber;
            $orderInvoiceAddress->Postcode = $member->invoiceAddress()->Postcode;
            $orderInvoiceAddress->City = $member->invoiceAddress()->City;
            $orderInvoiceAddress->PhoneAreaCode = $member->invoiceAddress()->PhoneAreaCode;
            $orderInvoiceAddress->Phone = $member->invoiceAddress()->Phone;
            $orderInvoiceAddress->countryID = $member->invoiceAddress()->countryID;
            $orderInvoiceAddress->write();
            $this->invoiceAddressID = $orderInvoiceAddress->ID;
        } else { //for anonymous customers
            $orderInvoiceAddress->castedUpdate($registrationData);
            $orderInvoiceAddress->countryID = $registrationData['Country'];
            $orderInvoiceAddress->write();
            $this->invoiceAddressID = $orderInvoiceAddress->ID;
        }
        $this->write();
    }

    /**
     * create a shipping address for an order from customers data
     * writes $this to the database
     *
     * @param array $registrationData checkout forms submit data; only needed for anonymous customers
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 16.11.2010
     * @return void
     */
    public function createShippingAddress($registrationData = "") {
        $member = Member::currentUser();
        $orderShippingAddress = new OrderShippingAddress();
        if ($member->ClassName != "AnonymousCustomer") {// for registered customers

            /*
             * get Surname and FirstName from the address, if not available from the member
             */
            if ($member->shippingAddress()->Surname) {
                $orderShippingAddress->Surname = $member->shippingAddress()->Surname;
            } else {
                $orderShippingAddress->Surname = $member->Surname;
            }
            if ($member->shippingAddress()->FirstName) {
                $orderShippingAddress->FirstName = $member->shippingAddress()->FirstName;
            } else {
                $orderShippingAddress->FirstName = $member->FirstName;
            }
            $orderShippingAddress->Street = $member->shippingAddress()->Street;
            $orderShippingAddress->StreetNumber = $member->shippingAddress()->StreetNumber;
            $orderShippingAddress->Postcode = $member->shippingAddress()->Postcode;
            $orderShippingAddress->City = $member->shippingAddress()->City;
            $orderShippingAddress->PhoneAreaCode = $member->shippingAddress()->PhoneAreaCode;
            $orderShippingAddress->Phone = $member->shippingAddress()->Phone;
            $orderShippingAddress->countryID = $member->shippingAddress()->countryID;
            $orderShippingAddress->write(); //write here to have an object ID
            $this->shippingAddressID = $orderShippingAddress->ID;
        } else { //for anonymous customers
            $orderShippingAddress->castedUpdate($registrationData);
            $orderShippingAddress->countryID = $registrationData['Country'];
            $orderShippingAddress->write(); //write here to have an object ID
            $this->shippingAddressID = $orderShippingAddress->ID;
        }
        $this->write();
    }

    /**
     * Erzeugt eine Bestellung aus dem Warenkorbobjekt.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public function createFromShoppingCart() {
        $member = Member::currentUser();
        $this->customerID = $member->ID;

        // Mehrwertsteuersaetze aller Positionen
        $this->Tax = $member->shoppingCart()->getTax()->getAmount();

        // Bestellwert aller Positionen
        $this->PriceTotal->setAmount($member->shoppingCart()->getPrice()->getAmount());
        $this->PriceTotal->setCurrency('EUR');

        // Bestellwert aller Positionen plus Bearbeitungsgebuehren der Zahlungsart plus Versandkosten
        $totalAmount = 
            $this->getPaymentHandlingCosts()->getAmount() +
            $this->getShippingCosts()->getAmount() +
            $member->shoppingCart()->getPrice()->getAmount();
        
        $this->AmountTotal->setAmount(
            $totalAmount
        );
        $this->AmountTotal->setCurrency('EUR');

        // Standardstatus der Bestellung einstellen
        $paymentObj = DataObject::get_by_id(
            'PaymentMethod',
            $this->paymentID
        );
        $orderStatus = DataObject::get_one(
            'OrderStatus',
            sprintf(
                "\"Code\" = '%s'",
                $paymentObj->getDefaultOrderStatus()
            )
        );
        if ($orderStatus) {
            $this->statusID = $orderStatus->ID;
        }
        
        // Bestellung erzeugen, damit ist auch die ID vorhanden
        $this->write();

        // Warenkorbpositionen umwandeln in Bestellpositionen
        $this->convertShoppingCartPositionsToOrderPositions();
    }

    /**
     * Konvertiert die Positionen aus dem ShoppingCart zu OrderPositions.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    protected function convertShoppingCartPositionsToOrderPositions() {
        $member = Member::currentUser();
        $filter = sprintf("\"shoppingCartID\" = '%s'", $member->shoppingCartID);
        $shoppingCartPositions = DataObject::get('ShoppingCartPosition', $filter);

        if ($shoppingCartPositions) {
            foreach ($shoppingCartPositions as $shoppingCartPosition) {
                $article = $shoppingCartPosition->article();
                if ($article) {
                    $orderPosition = new OrderPosition();
                    $orderPosition->Price->setAmount($article->Price->getAmount());
                    $orderPosition->Price->setCurrency($article->Price->getCurrency());
                    $orderPosition->PriceTotal->setAmount($article->Price->getAmount() * $shoppingCartPosition->Quantity);
                    $orderPosition->PriceTotal->setCurrency($article->Price->getCurrency());
                    $orderPosition->Tax = $article->getTaxAmount();
                    $orderPosition->TaxTotal = $article->getTaxAmount() * $shoppingCartPosition->Quantity;
                    $orderPosition->TaxRate = $article->tax()->Rate;
                    $orderPosition->ArticleDescription = $article->LongDescription;
                    $orderPosition->Quantity = $shoppingCartPosition->Quantity;
                    $orderPosition->Title = $article->Title;
                    $orderPosition->orderID = $this->ID;
                    $orderPosition->articleID = $article->ID;
                    $orderPosition->write();
                }
            }
            foreach ($shoppingCartPositions as $shoppingCartPosition) {
                $shoppingCartPosition->delete();
            }
        }
    }

    /**
     * Speichert die Bestellung in der Datenbank.
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public function save() {
        $this->write();
    }

    /**
     * Setzt die Zahlungsmethode fuer diese Bestellung.
     *
     * @param int $paymentMethodID Die ID der Zahlungsmethode
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 05.01.2011
     */
    public function setPaymentMethod($paymentMethodID) {
        $paymentMethodObj = DataObject::get_by_id(
                        'PaymentMethod',
                        $paymentMethodID
        );

        if ($paymentMethodObj) {
            $this->paymentID = $paymentMethodObj->ID;
            $this->PaymentMethodTitle = $paymentMethodObj->Name;
            $this->HandlingCostPayment->setAmount($paymentMethodObj->getHandlingCost()->getAmount());
            $this->HandlingCostPayment->setCurrency('EUR');
        }
    }

    /**
     * Setzt den Status der Bestellung.
     *
     * @param OrderStatus $orderStatus Das OrderStatus Objekt
     *
     * @return bool
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 22.11.2010
     */
    public function setOrderStatus($orderStatus) {
        $orderStatusSet = false;

        if ($orderStatus && $orderStatus->exists()) {
                $this->statusID = $orderStatus->ID;
                $this->write();
                $orderStatusSet = true;
        }

        return $orderStatusSet;
    }

    /**
     * Save the note from the form if there is one
     *
     * @param string $note the customers notice
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 16.12.10
     * @return void
     */
    public function setNote($note) {
        $this->Note = $note;
    }

    /**
     * save the cart´s weight
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 16.12.10
     * @return void
     */
    public function setWeight() {
        $member = Member::currentUser();
        if ($member->shoppingCart()->getWeightTotal()) {
            $this->WeightTotal = $member->shoppingCart()->getWeightTotal();
        }
    }

    /**
     * set the total price for this order
     *
     * @return void
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 16.12.10
     */
    public function setPriceTotal() {
        $member = Member::currentUser();
        
        if ($member && $member->shoppingCart()) {
            $this->PriceTotal = $member->shoppingCart()->getPrice();
            $this->customerID = $member->ID;
            $this->write();
        }
    }

    /**
     * set the email for this order
     *
     * @param string $email the email address of the customer
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 16.12.10
     * @return void
     */
    public function setCustomerEmail($email = null) {
        $member = Member::currentUser();
        if ($member->Email) { //for registered customers
            $email = $member->Email;
        } else { // for anonymous customers
            $email = $email;
        }
        $this->CustomersEmail = $email;
    }

    /**
     * The shipping method is a relation + an attribte of the order
     * 
     * @param int $shippingMethodID the ID of the shipping method
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 16.12.10
     * @copyright 2010 pixeltricks GmbH
     * @return void
     */
    public function setShippingMethod($shippingMethodID) {
        $selectedShippingMethod = DataObject::get_by_id(
            'ShippingMethod',
            $shippingMethodID
        );
        
        if ($selectedShippingMethod) {
            $this->shippingMethodID              = $selectedShippingMethod->ID;
            $this->CarrierAndShippingMethodTitle = $selectedShippingMethod->carrier()->Title . "-" . $selectedShippingMethod->Title;
            $this->shippingFeeID                 = $selectedShippingMethod->getShippingFee()->ID;
            $this->HandlingCostShipment->setCurrency('EUR');
            $this->HandlingCostShipment->setAmount($selectedShippingMethod->getShippingFee()->Price->getAmount());
        }
    }

    /**
     * Liefert den im Warenkorb enthaltenen Steuerbetrag.
     *
     * @return float
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 24.11.2010
     */
    public function getTax() {
        $tax = 0.0;

        foreach ($this->orderPositions() as $orderPosition) {
            $tax += $orderPosition->TaxTotal;
        }
        
        $taxObj = new Money('Tax');
        $taxObj->setAmount($tax);
        
        return $taxObj;
    }

    /**
     * Liefert den Netto-Wert des Warenkorbs inkl. aller Nebenkosten
     * (Versand, Bearbeitungsgebuehren, etc.).
     *
     * @return float
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 24.11.2010
     */
    public function getAmountNet() {
        $amountNet = $this->AmountTotal->getAmount() - $this->Tax->getAmount();
        $amountNetObj = new Money();
        $amountNetObj->setAmount($amountNet);

        return $amountNetObj;
    }

    /**
     * Liefert den Brutto-Wert des Warenkorbs inkl. aller Nebenkosten
     * (Versand, Bearbeitungsgebuehren, etc.).
     *
     * @return Money
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 05.01.2011
     */
    public function getAmountGross() {
        return $this->AmountTotal;
    }
    
    /**
     * Liefert die Waehrung der Rechnung.
     * 
     * @return string
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2011 pixeltricks GmbH
     * @since 06.01.2011
     */
    public function getCurrency() {
        return $this->AmountTotal->getCurrency();
    }

    /**
     * Liefert den Netto-Warenwert des Warenkorbs ohne Nebenkosten
     * (Versand, Bearbeitungsgebuehren, etc.).
     *
     * @return Money
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 24.11.2010
     */
    public function getPriceNet() {
        $priceNet = $this->PriceTotal->getAmount() - $this->Tax->getAmount();
        $priceNetObj = new Money();
        $priceNetObj->setAmount($priceNet);

        return $priceNetObj;
    }

    /**
     * Liefert den Brutto-Warenwert des Warenkorbs ohne Nebenkosten
     * (Versand, Bearbeitungsgebuehren, etc.).
     *
     * @return Money
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 24.11.2010
     */
    public function getPriceGross() {
        return $this->PriceTotal;
    }

    /**
     * Liefert die Versandkosten fuer die gewaehlte Versandart
     * zurueck.
     *
     * @return float
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 25.11.2010
     */
    public function getShippingCosts() {
        return $this->HandlingCostShipment;
    }

    /**
     * Liefert die Bearbeitungsgebuehren fuer die gewaehlte Zahlungsart
     * zurueck.
     *
     * @return float
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 25.11.2010
     */
    public function getHandlingCosts() {
        return $this->HandlingCostPayment;
    }
    

    /**
     * Gibt die Menge aller Artikel der Bestellung zurueck.
     *
     * @param int $articleId Wenn angegeben, wird nur die Menge der Artikel
     * 						 geliefert, deren ID der $articleId entspricht
     *
     * @return int
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 29.11.10
     */
    public function getQuantity($articleId = null) {
        $positions = $this->orderPositions();
        $quantity = 0;

        foreach ($positions as $position) {
            if ($articleId === null ||
                    $position->article()->ID === $articleId) {

                $quantity += $position->Quantity;
            }
        }

        return $quantity;
    }

    /**
     * Liefert die Bearbeitungsgebuehren fuer die eingestellte Zahlungsart.
     *
     * @return float
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 23.11.2010
     */
    public function getPaymentHandlingCosts() {
        $handlingCosts = 0.0;
        $paymentObj = DataObject::get_by_id(
            'PaymentMethod',
            $this->paymentID
        );

        // Bearbeitungsgebuehren von der Zahlungsart holen
        if ($paymentObj) {
            $handlingCosts += $paymentObj->getHandlingCost()->getAmount();
        }
        $handlingCostsObj = new Money('paymentHandlingCosts');
        $handlingCostsObj->setAmount($handlingCosts);

        return $handlingCostsObj;
    }

    /**
     * Schreibt einen Logeintrag.
     * 
     * @param string $context Der Kontext fuer den Logeintrag
     * @param string $text    Der Text fuer den Logeintrag
     *
     * @return void
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @copyright 2010 pixeltricks GmbH
     * @since 17.11.2010
     */
    public function Log($context, $text) {
        if ($this->mode == 'Live') {
            $path = PIX_LOGFILE;
        } else {
            $path = PIX_LOGFILE;
        }

        if ($fp = fopen($path, 'a+')) {
            $text = sprintf(
                            "%s | Module: \"%s\" | Method: \"%s\"\n%s\n--------------------------------------------------------------------------------\n",
                            date('d.m.Y H:i:s'),
                            $this->ClassName,
                            $context,
                            $text
            );

            fwrite($fp, $text);
            fclose($fp);
        }
    }

    /**
     * send a confirmation mail with order details to the customer $member
     *
     * @param string $recipientEmail to get anonymous customers email only
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 16.11.2010
     * @return void
     */
    public function sendConfirmationMail($recipientEmail = "") {
        $member = Member::currentUser();
        if ($member) {
            if ($member->Email) { //for registered customers
                $memberEmail = $member->Email;
            } else { // for anonymous customers
                $memberEmail = $recipientEmail;
            }
            $email = new Email(
                            'info@pourlatable.de',
                            $memberEmail,
                            'Ihre Bestellung bei pourlatable.de',
                            '');
            $email->setTemplate('MailOrderConfirmation');
            $email->populateTemplate(
                    array(
                        'FirstName' => $member->FirstName,
                        'Surname' => $member->Surname,
                        'Salutation' => $member->Salutation,
                        'Order' => $this
                    )
            );
            $email->send();
        }
    }

    /**
     * hook triggered after write
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 9.11.10
     * @return void
     */
    protected function onAfterWrite() {
        parent::onAfterWrite();
        if ($this->AmountTotal->hasAmount() === false) {
            $price = $this->PriceTotal->getAmount() + $this->HandlingCostShipment->getAmount();
            $this->AmountTotal->setAmount($price);
            $this->AmountTotal->setCurrency('EUR');
            $this->write();
        }
    }
}