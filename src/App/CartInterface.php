<?php

/**
 * This file is part of the ShoppingCart package.
 *
 * (c) lechatquidanse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App;

use App\Model\Product;

/**
* Interface CartInterface
*
* @package ShoppingCart
* @author lechatquidanse
*/
interface CartInterface
{
    /**
    * Display a summary of the shopping cart
    * @return string
    */
    public function getTotalSum();

    /**
    * Add an item to the shopping cart
    *
    * @param Product $product Instance of the Product we're adding
    * @param int $amount The amount of $product
    *
    * @return void
    */
    public function addItem(Product $product, $amount);

    /**
    * Get the price of the product depending on how many are already in the shopping cart
    *
    * @param Product $product Product The product to determine price for
    * @return float The price of $product
    */
    public function getPriceOf(Product $product);
}
