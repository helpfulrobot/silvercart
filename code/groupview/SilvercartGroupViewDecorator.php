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
 * Decorator for PageTypes which have grouped views. Provides a group view
 * specific functionality to its decorated owner.
 *
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @copyright 2010 pixeltricks GmbH
 * @since 14.02.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartGroupViewDecorator extends DataObjectDecorator {

    /**
     * add switchGroupView to allowed_actions
     *
     * @var array
     */
    public static $allowed_actions = array(
        'switchGroupView',
        'switchGroupHolderView',
    );

    /**
     * returns all group views
     *
     * @return DataObjectSet
     */
    public function getGroupViews() {
        $groupViewArray = array();
        foreach (SilvercartGroupViewHandler::getGroupViews() as $code => $groupView) {
            $groupViewArray[] = new $groupView();
        }
        return new DataObjectSet($groupViewArray);
    }

    /**
     * returns all group views
     *
     * @return DataObjectSet
     */
    public function getGroupHolderViews() {
        $groupViewArray = array();
        foreach (SilvercartGroupViewHandler::getGroupHolderViews() as $code => $groupView) {
            $groupViewArray[] = new $groupView();
        }
        return new DataObjectSet($groupViewArray);
    }

    /**
     * checkes, whether more than $count group views are existant.
     *
     * @param int $count count
     *
     * @return bool
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.02.2011
     */
    public function hasMoreGroupViewsThan($count) {
        return count(SilvercartGroupViewHandler::getGroupViews()) > $count;
    }

    /**
     * checkes, whether more than $count group views are existant.
     *
     * @param int $count count
     *
     * @return bool
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.02.2011
     */
    public function hasMoreGroupHolderViewsThan($count) {
        return count(SilvercartGroupViewHandler::getGroupHolderViews()) > $count;
    }

    /**
     * switches the group view to the via URL parameter 'ID' given type (if
     * existant)
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.02.2011
     * @see self::$productGroupViews
     */
    public function switchGroupView() {
        if (array_key_exists('ID', $this->owner->urlParams)) {
            SilvercartGroupViewHandler::setGroupView($this->owner->urlParams['ID']);
        }
        Director::redirect('/' . $this->owner->URLSegment);
    }

    /**
     * switches the group view to the via URL parameter 'ID' given type (if
     * existant)
     *
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.02.2011
     * @see self::$productGroupHolderViews
     */
    public function switchGroupHolderView() {
        if (array_key_exists('ID', $this->owner->urlParams)) {
            SilvercartGroupViewHandler::setGroupHolderView($this->owner->urlParams['ID']);
        }
        Director::redirect('/' . $this->owner->URLSegment);
    }

    /**
     * returns the code of the active group view
     *
     * @return string
     */
    public function getActiveGroupView() {
        return SilvercartGroupViewHandler::getActiveGroupView();
    }

    /**
     * this is used to render the ProductGroupHolder template in dependence on
     * the active group view.
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.02.2011
     */
    public function RenderProductGroupHolderGroupView() {
        $items = array();
        foreach ($this->owner->Children() as $child) {
            if ($child->hasProductsOrChildren()) {
                $items[] = $child;
            }
        }
        $elements = array(
            'Elements' => new DataObjectSet($items),
        );
        $output = $this->owner->customise($elements)->renderWith(
            array(
                $this->getProductGroupHolderTemplateName(),
            )
        );
        return $output;
    }

    /**
     * this is used to render the ProductGroupPage template in dependence on
     * the active group view.
     *
     * @return string
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 15.02.2011
     */
    public function RenderProductGroupPageGroupView() {
        $elements = array(
            'Elements' => $this->owner->getProducts(),
        );
        $output = $this->owner->customise($elements)->renderWith(
            array(
                $this->getProductGroupPageTemplateName(),
            )
        );
        return $output;
    }

    /**
     * returns the required ProductGroupHolder template name required by the
     * decorators owner in dependence on the active group view.
     *
     * @return string
     */
    protected function getProductGroupHolderTemplateName() {
        return 'SilvercartProductGroupHolder' . SilvercartGroupViewHandler::getActiveGroupHolderViewAsUpperCamelCase();
    }

    /**
     * returns the required ProductGroupPage template name required by the
     * decorators owner in dependence on the active group view.
     *
     * @return string
     */
    protected function getProductGroupPageTemplateName() {
        return 'SilvercartProductGroupPage' . SilvercartGroupViewHandler::getActiveGroupViewAsUpperCamelCase();
    }

    /**
     * returns the required CartFormName required by the decorators owner in
     * dependence on the active group view.
     *
     * @return string
     */
    public function getCartFormName() {
        return 'SilvercartProductAddCartForm' . SilvercartGroupViewHandler::getActiveGroupViewAsUpperCamelCase();
    }
}