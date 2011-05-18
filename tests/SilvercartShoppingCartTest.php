<?php
/**
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
 *
 * @package Silvercart
 * @subpackage Tests
 */

/**
 * tests for SilvercartShoppingCart
 *
 * @package Silvercart
 * @subpackage Tests
 * @author Roland Lehmann <rlehmann@pixeltricks.de>
 * @copyright Pixeltricks GmbH
 * @since 25.04.2011
 * @license http://www.gnu.org/licenses/lgpl.html GNU Lesser General Public License
 */
class SilvercartShoppingCartTest extends SapphireTest {

    public static $fixture_file = 'silvercart/tests/SilvercartShoppingCartTest.yml';
    
    /**
     * Do all positions of the cart get deleted?
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 25.4.2011
     * @return void
     */
    public function testDelete() {
        //do all 4 positions get loaded?
        $cart = $this->objFromFixture("SilvercartShoppingCart", "ShoppingCart");
        $this->assertEquals(4, $cart->SilvercartShoppingCartPositions()->Count());
        
        //do all 4 positions get deleted?
        $cart->delete();
        $this->assertEquals(0, $cart->SilvercartShoppingCartPositions()->Count());
    }
    
    /**
     * tests addProduct function with admins and anonymous users
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 28.4.2011
     * @return void
     */
    public function testAddProduct() {
        //add product to admins cart
        $product = $this->objFromFixture("SilvercartProduct", "product");
        $formData = array();
        $formData['productID'] = $product->ID;
        $formData['productQuantity'] = 10;
        $this->assertTrue(SilvercartShoppingCart::addProduct($formData));
        
        //add product to anonymous cart
        $member = Member::currentUser();
        if ($member) {
            $member->logOut();
        }
        $this->assertTrue(SilvercartShoppingCart::addProduct($formData), "adding a product to an anonymous users cart failed!");
        
        //log admin in again or session gets messed up and the test will not work on reload
        $member->logIn();
    }
    
    /**
     * test for getQuantity function
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 28.4.2011
     * @return void
     */
    public function testGetQuantity() {
        $cart = $this->objFromFixture("SilvercartShoppingCart", "ShoppingCart");
        $this->assertEquals(12, $cart->getQuantity());
    }
    
    /**
     * test for isFilled function
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 28.4.2011
     * @return void
     */
    public function testIsFilled() {
        $cart = $this->objFromFixture("SilvercartShoppingCart", "ShoppingCart");
        $this->assertTrue($cart->isFilled());
    }
    
    /**
     * test for getAmountTotal()
     * This cart has no shipping costs or payment costs
     * 
     * @author Roland Lehmann <rlehmann@pixeltricks.de>
     * @since 4.5.2011
     * @return void
     */
    public function testGetAmountTotal() {
       $cart = $this->objFromFixture("SilvercartShoppingCart", "ShoppingCart");
       $this->assertEquals(2131.74, $cart->getAmountTotal()->getAmount(), "The total amount of a cart without payment and shipping costs is NOT correct.");
       
       //cart with shipping costs
       $cartWithShippingCosts = $this->objFromFixture("SilvercartShoppingCart", "ShoppingCartWithShippingCosts");
    }
    
    

}

