<?php
/*
 * Copyright 2010, 2011 pixeltricks GmbH
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
 */

/**
 * Description of SilvercartProductCategoryPage
 * Gathers Products of the same theme
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @since 23.10.2010
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2010 pixeltricks GmbH
 */
class SilvercartProductCategoryPage extends Page {

    static $singular_name = "";
    static $plural_name = "";
    public static $can_be_root = false;
    public static $allowed_children = array(
        'none'
    );
    public static $has_one = array(
        'CategoryPicture' => 'Image'
    );
    public static $many_many = array(
        'SilvercartProducts' => 'SilvercartProduct'
    );

    /**
     * customizes the CMS
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 23.10.2010
     * @return FieldSet the CMS fields
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        $tabParam = "Root.Content." . _t('SilvercartProductCategoryPage.CATEGORY_PICTURE', 'category picture');
        $fields->addFieldToTab($tabParam, new FileIFrameField('CategoryPicture', _t('SilvercartProductCategoryPage.CATEGORY_PICTURE', 'category picture')));
        $productsTableField = new ManyManyComplexTableField(
                        $this,
                        'products',
                        'SilvercartProduct',
                        array(
                            'Title' => _t('SilvercartProductCategoryPage.COLUMN_TITLE', 'title')
                        ),
                        'getCMSFields_forPopup'
        );
        $tabParam2 = "Root.Content." . _t('SilvercartProductCategoryPage.PRODUCTS', 'products');
        $fields->addFieldToTab($tabParam2, $productsTableField);
        return $fields;
    }

}

/**
 * corelating controller
 *
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 * @copyright 2010 pixeltricks GmbH
 * @since 23.10.2010
 */
class SilvercartProductCategoryPage_Controller extends Page_Controller {

    protected $categoryProducts;

    /**
     * statements to be called on instanciation
     *
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 23.10.2010
     * @return void
     */
    public function init() {

        // Get Products for this category
        if (!isset($_GET['start']) ||
                !is_numeric($_GET['start']) ||
                (int) $_GET['start'] < 1) {
            $SQL_start = 0;
        } else {
            $SQL_start = (int) $_GET['start'];
        }

        $join = "LEFT JOIN SilvercartProductCategoryPage_SilvercartProducts ON SilvercartProductCategoryPage_SilvercartProducts.SilvercartProductID = SilvercartProduct.ID";

        $this->categoryProducts = SilvercartProduct::get(sprintf("`SilvercartProductCategoryPageID` = '%s'", $this->ID, null, $join, sprintf("%s,15", $SQL_start)));

        // Initialise formobjects
        $templateProductList = new DataObjectSet();
        $productIdx = 0;
        if ($this->categoryProducts) {
            foreach ($this->categoryProducts as $product) {
                $this->registerCustomHtmlForm('SilvercartProductPreviewForm' . $productIdx, new SilvercartProductPreviewForm($this, array('productID' => $product->ID)));
                $productIdx++;
            }
        }

        parent::init();

        $productIdx = 0;
        if ($this->categoryProducts) {
            foreach ($this->categoryProducts as $product) {

                $product->setField('Link', $product->Link());
                $product->productPreviewForm = $this->InsertCustomHtmlForm(
                                'SilvercartProductPreviewForm' . $productIdx,
                                array(
                                    $product
                                )
                );

                $productIdx++;
            }
        }
    }

    /**
     * returns all products of this category
     * we use this way instead of a control over the relation because we need pagination
     *
     * @return DataObjectSet set of product objects
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 23.10.2010
     * @copyright 2010 pixeltricks GmbH
     */
    public function CategoriesProducts() {
        return $this->categoryProducts;
    }

}