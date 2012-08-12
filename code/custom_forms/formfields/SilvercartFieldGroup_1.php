<?php
/**
 * Copyright 2012 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * SilverCart is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * SilverCart is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with SilverCart.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package Silvercart
 * @subpackage FormFields
 */

/**
 * A formfield to group CMS fields
 *
 * @package Silvercart
 * @subpackage FormFields
 * @copyright pixeltricks GmbH
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 06.06.2012
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License 
 */
class SilvercartFieldGroup extends CompositeField {
    
    /**
     * Fields to manipulate
     *
     * @var FieldSet
     */
    protected $fields = null;

    /**
     * Constructor
     *
     * @param string   $name     Name
     * @param string   $title    Title
     * @param FieldSet $fields   CMS fields
     * @param mixed    $children Children
     * 
     * @return void
     */
    public function __construct($name, $title = '', $fields = null, $children = array()) {
        parent::__construct($children);
        $this->setName($name);
        $this->setTitle($title);
        $this->setFields($fields);
    }

    /**
     * Returns the field markup
     * 
     * @return string
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function FieldHolder() {
        $title              = $this->Title();
        $name               = $this->Name();
        $fieldHolder        = '<div class="silvercart-field-group silvercart-fieldgroup"><div class="middleColumn"><div class="fieldgroup">%s</div></div>  </div>';
        $singleFieldHolder  = '<div class="fieldgroupField %s">%s</div>';
        $fieldMarkup        = array();
        
        if (!empty($title)) {
            $titleField     = new HeaderField($name . 'Title', $title);
            $fieldMarkup[]  = $titleField->Field();
        }
        
        $addClass = '';
        foreach ($this->getChildren() as $child) {
            if ($child->BreakBefore) {
                $addClass = 'silvercart-clearfix';
            }
            $fieldMarkup[]  = sprintf(
                    $singleFieldHolder,
                    $addClass,
                    $child->SmallFieldHolder()
            );
            if ($child->BreakAfter) {
                $addClass = 'silvercart-clearfix';
            } else {
                $addClass = '';
            }
        }
        
        $fieldHolder = sprintf(
                $fieldHolder,
                implode('', $fieldMarkup)
        );
        
        return $fieldHolder;
    }
    
    /**
     * Pushes the given field to the group
     *
     * @param FormField $field       Field to push
     * @param bool      $breakBefore Insert a line break before the field?
     * @param bool      $breakAfter  Insert a line break after the field?
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function push(FormField $field, $breakBefore = false, $breakAfter = false) {
        $field->BreakAfter  = $breakAfter;
        $field->BreakBefore = $breakBefore;
        parent::push($field);
        $fields = $this->getFields();
        if (!is_null($fields)) {
            $fields->removeByName($field->Name());
        }
    }
    
    /**
     * Pushes the given field and breaks the line after
     *
     * @param FormField $field Field to push
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function pushAndBreak(FormField $field) {
        $this->push($field, false, true);
    }
    
    /**
     * Pushes the given field and breaks the line before
     *
     * @param FormField $field Field to push
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.06.2012
     */
    public function breakAndPush(FormField $field) {
        $this->push($field, true);
    }
    
    /**
     * Returns the fields
     *
     * @return FieldSet 
     */
    public function getFields() {
        return $this->fields;
    }

    /**
     * Sets the fields
     *
     * @param FieldSet $fields Fields to set
     * 
     * @return void
     */
    public function setFields($fields) {
        $this->fields = $fields;
    }
    
}