<?php

/**
 * This file is part of the ShoppingCartTest package.
 *
 * (c) lechatquidanse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests;

use App\Cart;
use App\Model\Discount;
use App\Model\Product;

/**
 * CartTest
 *
 * @package ShoppingCartTest
 * @author lechatquidanse
 */
class CartTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Create Cart
     * 
     * @return App\Cart
     */
    protected function createCart()
    {
        return new Cart();
    }

    /**
     * Create Discount
     * 
     * @param  integer $minAmount
     * @param  integer $maxAmount
     * @param  float   $reduction
     * @return App\Model\Discount
     */
    protected function createDiscounts($minAmount = 0, $maxAmount = 10, $reduction = 0.00)
    {
        return new Discount($minAmount, $maxAmount, $reduction);
    }

    /**
     * Create Product
     * 
     * @param  string $name
     * @param  float  $price
     * @return App\Model\Product
     */
    protected function createProduct($name = 'Lemon', $price = 0.50)
    {
        $key = strtolower($name);

        return new Product($key, $name, $price);
    }

    /**
     * testGetPriceOfSuccess
     * 
     * Test that Get the price of the product depends on how many are already in the shopping cart
     * 
     * Example: Test that for a product descibes as:
     * 0-10 = £0.50
     * 10+ = £0.45
     *
     * $cart->addItem($lemon, 10); // Amount of lemons in cart is now 10
     * $cart->getPriceOf($lemon); // should return 0.50
     * 
     * $cart->addItem($lemon, 5); // Amount of lemons in cart is now 15
     * $cart->getPriceOf($lemon); // should return 0.45
     */
    public function testGetPriceOfSuccess()
    {
        $cart = $this->createCart();

        $lemon = $this->createProduct('Lemon', 0.50);
        $discount1 = $this->createDiscounts(0, 10, 0.00);
        $lemon->addDiscount($discount1);
        $discount2 = $this->createDiscounts(10, false, 0.10);
        $lemon->addDiscount($discount2);

        $cart->addItem($lemon, 10);
        $this->assertEquals(0.50, $cart->getPriceOf($lemon));

        $cart->addItem($lemon, 5);
        $this->assertEquals(0.45, $cart->getPriceOf($lemon));
    }

    /**
     * testGetTotalSum
     *
     * Test that total sum of cart is calculed according to amount and discounts of Product
     */
    public function testGetTotalSum()
    {
        $cart = $this->createCart();

        $lemon = $this->createProduct('Lemon', 0.50);
        $discount1 = $this->createDiscounts(0, 10, 0.00);
        $lemon->addDiscount($discount1);
        $discount2 = $this->createDiscounts(10, false, 0.10);
        $lemon->addDiscount($discount2);

        $cart->addItem($lemon, 10);
        $cart->addItem($lemon, 5);

        $this->assertEquals(7.25, $cart->getTotalSum());
    }
}
