<?php

/**
 * This file is part of the ShoppingCartTest package.
 *
 * (c) lechatquidanse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Tests\Model;

use App\Model\Discount;
use App\Model\Product;

/**
 * ProductTest
 *
 * @package ShoppingCartTest
 * @author lechatquidanse
 */
class ProductTest extends \PHPUnit_Framework_TestCase
{
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
     * testIncrementAmountByValueSuccess
     *
     * Tests that incrementAmountByValue add goud value to amount Product
     */
    public function testIncrementAmountByValueSuccess()
    {
        $product = $this->createProduct();

        $valueToAdd = 2;
        $product->incrementAmountByValue($valueToAdd);

        $this->assertEquals(2, $product->getAmount());
    }

    /**
     * testGetPriceFromAmountWithoutDiscountsSuccess
     *
     * Tests that getPriceFromAmount return a default price for Product.
     * When Product has no Discount and However Amount 
     */
    public function testGetPriceFromAmountWithoutDiscountsSuccess()
    {
        $product = $this->createProduct();
        $product->setAmount(50);

        $this->assertEquals($product->getPrice(), $product->getPriceFromAmount());
    }

    /**
     * testGetPriceFromAmountWithDiscountsUseSuccess
     *
     * Tests that getPriceFromAmount return a discounted price for Product.
     * When Product has Discount used because Product amount is in Discount range.
     * In this case, we will set amount of product to match discount2 range.
     * Then check that product price with reduction of discount2 === price from amount calculated by Product 
     */
    public function testGetPriceFromAmountWithDiscountsUseSuccess()
    {
        $product = $this->createProduct('Lemon', 0.50);

        $discount1 = $this->createDiscounts(0, 10, 0.00);
        $product->addDiscount($discount1);

        $discount2 = $this->createDiscounts(11, false, 0.10);
        $product->addDiscount($discount2);

        $product->setAmount(40);
        $price = $product->getPrice();

        $this->assertEquals($discount2->getPriceDiscount($price), $product->getPriceFromAmount());
    }

    /**
     * testGetTotalPriceFromAmountSuccess
     *
     * Test that total Price of product is calculated by amounts and with amount reduction from discounts.
     * 
     * Example: Test that for a product descibes as:
     * 0-10 = £0.50
     * 10+ = £0.45
     * amount = 25
     * The price would be calculated as: (10 * £0.50) + (15 * £0.45) = £11.75
     */
    public function testGetTotalPriceFromAmountSuccess()
    {
        $lemon = $this->createProduct('Lemon', 0.50);

        $discount1 = $this->createDiscounts(0, 10, 0.00);
        $lemon->addDiscount($discount1);

        $discount2 = $this->createDiscounts(10, false, 0.10);
        $lemon->addDiscount($discount2);

        $lemon->incrementAmountByValue(10);
        $this->assertEquals(5.00, $lemon->getTotalPriceFromAmount());

        $lemon->incrementAmountByValue(15);
        $this->assertEquals(11.75, $lemon->getTotalPriceFromAmount());
    }
}
