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

use App\CartInterface;
use App\Handler\CartDisplayHandler;
use App\Model\Product;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * {@inheritdoc}
 *
 * @package ShoppingCart
 * @author lechatquidanse
 */
class Cart implements CartInterface
{
    /**
     * [$cartDisplayHandler description]
     * @var [type]
     */
    protected $cartDisplayHandler;

    /**
     * Price
     *
     * Sum of products price in Cart
     * 
     * @var float $price
     */
    protected $price = 0.00;

    /**
     * Products
     *
     * Array Collection of Products
     *
     * @var Doctrine\Common\Collections\ArrayCollection $products
     */
    public $products;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->cartDisplayHandler = new CartDisplayHandler();
    }

    /**
     * __toString
     * 
     * @return string cart summary
     */
    public function __toString()
    {
        $string = '';

        foreach ($this->products as $product) {
            $string .= $this->cartDisplayHandler->displayProduct($product);
        }

        $string .= $this->cartDisplayHandler->displayTotal($this->price);

        return $string;
    }

    /**
     * Update Cart
     *
     * Update Cart properties according to Product.
     * 1 - Calulate total price of Product
     * 2 - Add it to price Cart
     * 3 - Update cart display handler properties
     * 
     * @param  Product $product
     * @return void
     */
    private function updateCart(Product $product)
    {
        $product->setTotalPriceFromAmount();
        $this->price += $product->getTotalPrice();
        $this->cartDisplayHandler->updateConfigForProduct($product, $this->price);
    }

    /**
     * Clear
     *
     * Clear Cart
     * 
     * @return void
     */
    public function clear()
    {
        $this->products->clear();
        $this->price = 0.00;
        $this->cartDisplayHandler->clear();
    }

    /**
     * {@inheritdoc}
     */
    public function getTotalSum()
    {
        return $this->price;
    }

    /**
     * {@inheritdoc}
     */
    public function addItem(Product $product, $amount)
    {
        $productKey = $product->getId();

        if ($productCart = $this->products->get($productKey)) {
            $this->price = $this->price - $productCart->getTotalPrice();
            $productCart->incrementAmountByValue($amount);
            
            $this->updateCart($productCart);
        } else {
            $product->setAmount($amount);
            $this->products->set($productKey, $product);

            $this->updateCart($product);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getPriceOf(Product $product)
    {
        return $product->getPriceFromAmount();
    }
}
