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

/**
 * DiscountTest
 *
 * @package ShoppingCartTest
 * @author lechatquidanse
 */
class DiscountTest extends \PHPUnit_Framework_TestCase
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
     * testGetPriceDiscountSuccess
     * 
     * Test that a pourcentage reduction is well apply to a price
     */
    public function testGetPriceDiscountSuccess()
    {
        $discount = $this->createDiscounts(0, 10, 0.10);
        $price = 0.50;

        $this->assertEquals(0.45, $discount->getPriceDiscount($price));
    }

    /**
     * testGetTotalPriceDiscount
     * 
     * Test that a pourcentage reduction is well apply to a price according to how many times this reduction has to be apply
     */
    public function testGetTotalPriceDiscount()
    {
        $discount = $this->createDiscounts(0, 10, 0.10);
        $discount->setNbUsed(10);
        $price = 0.50;

        $this->assertEquals(4.50, $discount->getTotalPriceDiscount($price));
    }
}
