<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Order
 */

/**
 * Order logs are used to log date and time of changing an order. By SilverCarts
 * default, order logs are created when an order status changes from one to
 * another.
 *
 * @package Silvercart
 * @subpackage Order
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 17.10.2012
 * @license see license file in modules root directory
 */
class SilvercartOrderLog extends DataObject implements SilvercartModelAdmin_ReadonlyInterface {
    
    /**
     * DB attributes
     *
     * @var array
     */
    public static $db = array(
        'Context'   => 'VarChar(64)',
        'Action'    => 'Enum("Created,Changed,MarkedAsSeen","Changed")',
        'SourceID'  => 'Int',
        'TargetID'  => 'Int',
    );
    
    /**
     * has one relations
     *
     * @var array
     */
    public static $has_one = array(
        'SilvercartOrder' => 'SilvercartOrder',
    );
    
    /**
     * Casted attributes
     *
     * @var array
     */
    public static $casting = array(
        'ContextNice'       => 'Text',
        'ContextMessage'    => 'Text',
        'SourceTitle'       => 'Text',
        'TargetTitle'       => 'Text',
    );
    
    /**
     * Default sort field and direction
     *
     * @var string
     */
    public static $default_sort = 'Created DESC';
    
    /**
     * Adds an log with the action Changed
     * 
     * @param SilvercartOrder $order    Order to add log for
     * @param string          $context  Context object
     * @param int             $sourceID ID of the source
     * @param int             $targetID ID of the target
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public static function addChangedLog($order, $context, $sourceID, $targetID) {
        $orderLog = new SilvercartOrderLog();
        $orderLog->Context              = $context;
        $orderLog->SourceID             = $sourceID;
        $orderLog->TargetID             = $targetID;
        $orderLog->SilvercartOrderID    = $order->ID;
        $orderLog->setChangedAction();
        $orderLog->write();
    }
    
    /**
     * Adds an log with the action MarkedAsSeen
     * 
     * @param SilvercartOrder $order   Order to add log for
     * @param string          $context Context object
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public static function addMarkedAsSeenLog($order, $context) {
        $orderLog = new SilvercartOrderLog();
        $orderLog->Context              = $context;
        $orderLog->SilvercartOrderID    = $order->ID;
        $orderLog->setMarkedAsSeenAction();
        $orderLog->write();
    }
    
    /**
     * Adds an log with the action MarkedAsNotSeen
     * 
     * @param SilvercartOrder $order   Order to add log for
     * @param string          $context Context object
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 14.03.2012
     */
    public static function addMarkedAsNotSeenLog($order, $context) {
        $orderLog = new SilvercartOrderLog();
        $orderLog->Context              = $context;
        $orderLog->SilvercartOrderID    = $order->ID;
        $orderLog->setMarkedAsNotSeenAction();
        $orderLog->write();
    }
    
    /**
     * Adds an log with the action Created
     * 
     * @param SilvercartOrder $order   Order to add log for
     * @param string          $context Context object
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public static function addCreatedLog($order, $context) {
        $orderLog = new SilvercartOrderLog();
        $orderLog->Context              = $context;
        $orderLog->SilvercartOrderID    = $order->ID;
        $orderLog->setCreatedAction();
        $orderLog->write();
    }

    /**
     * Sets the action to Changed.
     * 
     * @return void
     */
    public function setChangedAction() {
        $this->Action = 'Changed';
    }
    
    /**
     * Sets the action to Created.
     * 
     * @return void
     */
    public function setCreatedAction() {
        $this->Action = 'Created';
    }
    
    /**
     * Sets the action to MarkedAsSeen.
     * 
     * @return void
     */
    public function setMarkedAsSeenAction() {
        $this->Action = 'MarkedAsSeen';
    }
    
    /**
     * Sets the action to MarkedAsSeen.
     * 
     * @return void
     */
    public function setMarkedAsNotSeenAction() {
        $this->Action = 'MarkedAsNotSeen';
    }

    /**
     * Returns the Context of the log in a human readable state
     * 
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public function getContextNice() {
        return _t($this->Context . '.SINGULARNAME', $this->Context);
    }
    
    /**
     * Builds and returns the message in the logs context
     * 
     * @return string
     */
    public function getContextMessage() {
        $message = '';
        switch ($this->Action) {
            case 'Created':
                $message = sprintf(
                        _t('SilvercartOrderLog.MESSAGE_CREATED'),
                        $this->ContextNice
                );
                break;
            case 'MarkedAsSeen':
                $message = _t('SilvercartOrderLog.MESSAGE_MARKEDASSEEN');
                break;
            case 'MarkedAsNotSeen':
                $message = _t('SilvercartOrderLog.MESSAGE_MARKEDASNOTSEEN');
                break;
            case 'Changed':
            default:
                $message = sprintf(
                        _t('SilvercartOrderLog.MESSAGE_CHANGED'),
                        $this->SourceTitle,
                        $this->TargetTitle
                );
                break;
        }
        return $message;
    }

    /**
     * Creates and returns the source title
     * 
     * @return string
     */
    public function getSourceTitle() {
        $sourceTitle    = '#' . $this->SourceID;
        $sourceObject   = DataObject::get_by_id($this->Context, $this->SourceID);
        if ($sourceObject) {
            $sourceTitle = $sourceObject->Title;
        }
        return $sourceTitle;
    }

    /**
     * Creates and returns the target title
     * 
     * @return string
     */
    public function getTargetTitle() {
        $targetTitle    = '#' . $this->TargetID;
        $targetObject   = DataObject::get_by_id($this->Context, $this->TargetID);
        if ($targetObject) {
            $targetTitle = $targetObject->Title;
        }
        return $targetTitle;
    }

    /**
     * Field labgels
     * 
     * @param bool $includerelations Include relations or not?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public function fieldLabels($includerelations = true) {
        $fieldLabels = array_merge(
                parent::fieldLabels($includerelations),
                array(
                    'Context'   => _t('SilvercartOrderLog.CONTEXT'),
                    'Created'   => _t('SilvercartOrderLog.CREATED'),
                    'Message'   => _t('SilvercartOrderLog.MESSAGE'),
                )
        );
        
        $this->extend('updateFieldLabels', $fieldLabels);
        
        return $fieldLabels;
    }

    /**
     * Summary fields
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 17.10.2012
     */
    public function summaryFields() {
        $summaryFields = array(
            'Created'           => $this->fieldLabel('Created'),
            'ContextNice'       => $this->fieldLabel('Context'),
            'ContextMessage'    => $this->fieldLabel('Message'),
        );
        
        $this->extend('updateSummaryFields', $summaryFields);
        
        return $summaryFields;
    }
}