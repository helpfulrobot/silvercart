<?php
/**
 * Copyright 2013 pixeltricks GmbH
 *
 * This file is part of SilverCart.
 *
 * @package Silvercart
 * @subpackage Search
 */

/**
 * Provides the ability to search between two dates.
 *
 * @package Silvercart
 * @subpackage Search
 * @author Sascha Koehler <skoehler@pixeltricks.de>
 * @copyright 2013 pixeltricks GmbH
 * @since 11.03.2012
 * @license see license file in modules root directory
 */
class DateRangeSearchContext extends SearchContext {

  /**
   * Replace the default form fields for the 'Created' search
   * field with a single text field which we can use to apply
   * jquery date range widget to.
   *
   * @return FieldList
   *
   * @author Sascha Koehler <skoehler@pixeltricks.de>
   * @since 11.03.2012
   */
    public function getSearchFields() {
        $fields = ($this->fields) ? $this->fields : singleton($this->modelClass)->scaffoldSearchFields();

        if ($fields) {
            $dates = array ();

            foreach ($fields as $field) {
                $type = singleton($this->modelClass)->obj($field->getName())->class;
                if ($type == "Date" || $type == "SS_Datetime") {
                    $dates[] = $field;
                }
            }

            foreach ($dates as $d) {
                $fields->removeByName($d->Name());
                $fields->push(new TextField($d->Name(), $d->Title()));
            }
        }

        return $fields;
    }

    /**
     * Alter the existing SQL query object by adding some filters for the search
     * so that the query finds objects between two dates min and max
     *
     * @param array $searchParams  The search parameters
     * @param mixed $sort          The SQL sort statement
     * @param mixed $limit         The SQL limit statement
     * @param mixed $existingQuery The existing query
     *
     * @return SQLQuery Query with filters applied for search
     *
     * @author Sascha Koehler <skoehler@pixeltricks.de>
     * @since 11.03.2012
     */
    public function getQuery($searchParams, $sort = false, $limit = false, $existingQuery = null) {
        $query            = parent::getQuery($searchParams, $sort, $limit, $existingQuery);
        $searchParamArray = (is_object($searchParams)) ? $searchParams->getVars() : $searchParams;

        foreach ($searchParamArray as $fieldName => $value) {
            if ($fieldName == 'Created') {
                $filter = $this->getFilter($fieldName);

                if ($filter && get_class($filter) == "DateRangeSearchFilter") {
                    $min_val = null;
                    $max_val = null;

                    $filter->setModel($this->modelClass);

                    if (strpos($value, '-') === false) {
                        $min_val = $value;
                    } else {
                        preg_match('/([^\s]*)(\s-\s(.*))?/i', $value, $matches);

                        $min_val = (isset($matches[1])) ? $matches[1] : null;

                        if (isset($matches[3])) {
                            $max_val = $matches[3];
                        }
                    }

                    if ($min_val && $max_val) {
                        $filter->setMin($min_val);
                        $filter->setMax($max_val);
                        $filter->apply($query);
                    } else if ($min_val) {
                        $filter->setMin($min_val);
                        $filter->apply($query);
                    } else if ($max_val) {
                        $filter->setMax($max_val);
                        $filter->apply($query);
                    }
                }
            }
        }
        return $query;
    }
}

