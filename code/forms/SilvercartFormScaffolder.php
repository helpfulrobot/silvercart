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
 * Extension for every DataObject
 *
 * @package Silvercart
 * @subpackage Forms
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 13.02.2013
 * @license see license file in modules root directory
 */
class SilvercartFormScaffolder extends FormScaffolder {

    /**
     * Gets the form fields as defined through the metadata
     * on {@link $obj} and the custom parameters passed to FormScaffolder.
     * Depending on those parameters, the fields can be used in ajax-context,
     * contain {@link TabSet}s etc.
     * 
     * Uses SilvercartGridFieldConfig_RelationEditor and 
     * SilvercartGridFieldConfig_ExclusiveRelationEditor instead of
     * GridFieldConfig_RelationEditor.
     * 
     * @return FieldList
     */
    public function getFieldList() {
        $fields = new FieldList();
        $excludeFromScaffolding = array();
        if ($this->obj->hasMethod('excludeFromScaffolding')) {
            $excludeFromScaffolding = $this->obj->excludeFromScaffolding();
        }

        // tabbed or untabbed
        if ($this->tabbed) {
            $fields->push(new TabSet("Root", $mainTab = new Tab("Main")));
            $mainTab->setTitle(_t('SiteTree.TABMAIN', "Main"));
        }

        // add database fields
        foreach ($this->obj->db() as $fieldName => $fieldType) {
            if (in_array($fieldName, $excludeFromScaffolding) || ($this->restrictFields && !in_array($fieldName, $this->restrictFields))) {
                continue;
            }

            // @todo Pass localized title
            if ($this->fieldClasses && isset($this->fieldClasses[$fieldName])) {
                $fieldClass = $this->fieldClasses[$fieldName];
                $fieldObject = new $fieldClass($fieldName);
            } else {
                $fieldObject = $this->obj->dbObject($fieldName)->scaffoldFormField(null, $this->getParamsArray());
            }
            $fieldObject->setTitle($this->obj->fieldLabel($fieldName));
            if ($this->tabbed) {
                $fields->addFieldToTab("Root.Main", $fieldObject);
            } else {
                $fields->push($fieldObject);
            }
        }

        // add has_one relation fields
        if ($this->obj->has_one()) {
            foreach ($this->obj->has_one() as $relationship => $component) {
                if (in_array($relationship, $excludeFromScaffolding) || ($this->restrictFields && !in_array($relationship, $this->restrictFields))) {
                    continue;
                }
                $fieldName = "{$relationship}ID";
                if ($this->fieldClasses && isset($this->fieldClasses[$fieldName])) {
                    $fieldClass = $this->fieldClasses[$fieldName];
                    $hasOneField = new $fieldClass($fieldName);
                } else {
                    $hasOneField = $this->obj->dbObject($fieldName)->scaffoldFormField(null, $this->getParamsArray());
                }
                $hasOneField->setTitle($this->obj->fieldLabel($relationship));
                if ($this->tabbed) {
                    $fields->addFieldToTab("Root.Main", $hasOneField);
                } else {
                    $fields->push($hasOneField);
                }
            }
        }

        // only add relational fields if an ID is present
        if ($this->obj->ID) {
            // add has_many relation fields
            if ($this->obj->has_many() && ($this->includeRelations === true || isset($this->includeRelations['has_many']))) {
                foreach ($this->obj->has_many() as $relationship => $component) {
                    if (in_array($relationship, $excludeFromScaffolding)) {
                        continue;
                    }
                    if ($this->tabbed) {
                        $relationTab = $fields->findOrMakeTab(
                                "Root.$relationship", $this->obj->fieldLabel($relationship)
                        );
                    }
                    $fieldClass = (isset($this->fieldClasses[$relationship])) ? $this->fieldClasses[$relationship] : 'GridField';
                    if (singleton($component) instanceof SilvercartModelAdmin_ReadonlyInterface) {
                        $config = SilvercartGridFieldConfig_Readonly::create();
                    } elseif (singleton($component) instanceof SilvercartModelAdmin_ExclusiveRelationInterface ||
                              $this->obj->has_extension($this->obj->$relationship()->dataClass(), 'SilvercartLanguageDecorator')) {
                        $config = SilvercartGridFieldConfig_ExclusiveRelationEditor::create();
                    } else {
                        $config = SilvercartGridFieldConfig_RelationEditor::create();
                    }
                    $grid = Object::create(
                            $fieldClass,
                            $relationship,
                            $this->obj->fieldLabel($relationship),
                            $this->obj->$relationship(),
                            $config
                    );
                    if ($this->tabbed) {
                        $fields->addFieldToTab("Root.$relationship", $grid);
                    } else {
                        $fields->push($grid);
                    }
                }
            }

            if ($this->obj->many_many() && ($this->includeRelations === true || isset($this->includeRelations['many_many']))) {
                foreach ($this->obj->many_many() as $relationship => $component) {
                    if (in_array($relationship, $excludeFromScaffolding)) {
                        continue;
                    }
                    if ($this->tabbed) {
                        $relationTab = $fields->findOrMakeTab(
                                "Root.$relationship", $this->obj->fieldLabel($relationship)
                        );
                    }

                    $fieldClass = (isset($this->fieldClasses[$relationship])) ? $this->fieldClasses[$relationship] : 'GridField';
                    $grid = Object::create($fieldClass, $relationship, $this->obj->fieldLabel($relationship), $this->obj->$relationship(), SilvercartGridFieldConfig_RelationEditor::create()
                    );
                    if ($this->tabbed) {
                        $fields->addFieldToTab("Root.$relationship", $grid);
                    } else {
                        $fields->push($grid);
                    }
                }
            }
        }

        return $fields;
    }
    
    /**
	 * Return an array suitable for passing on to {@link DBField->scaffoldFormField()}
	 * without tying this call to a FormScaffolder interface.
     * Adds a reference to the context object.
	 * 
	 * @return array
	 */
    protected function getParamsArray() {
        return array_merge(
                parent::getParamsArray(),
                array(
                    'object' => $this->obj
                )
        );
    }

}