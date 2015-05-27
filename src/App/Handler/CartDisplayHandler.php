<?php

/**
 * This file is part of the ShoppingCart package.
 *
 * (c) lechatquidanse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Handler;

use App\Model\Product;

/**
 * Cart Display Handler
 * 
 * @package ShoppingCart
 */
class CartDisplayHandler
{
    const DISPLAY_TOTAL = 'Total:';
    const DISPLAY_MONEY = '£';
    const DISPLAY_FORMAT = '%0.2f';

    /**
     * Config Amount Length
     * 
     * @var integer $configAmountLength
     */
    private $configAmountLength;

    /**
     * Config Name Length
     * 
     * @var integer $configNameLength
     */
    private $configNameLength;

    /**
     * Config Name Length
     * 
     * @var integer $configNameLength
     */
    private $configPriceLength;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Update Config For Product
     *
     * Update config according to Product properties
     * 
     * @param  Product $product
     * @param  float  $cartPrice
     * @return void
     */
    public function updateConfigForProduct(Product $product, $cartPrice)
    {
        $productAmountLength = strlen($product->getAmount());
        $productNameLength = strlen($product->getName());
        $cartPrice = strlen(self::DISPLAY_MONEY . $cartPrice);

        if ($productAmountLength > $this->configAmountLength) {
            $this->configAmountLength = $productAmountLength;
        }

        if ($productNameLength > $this->configNameLength) {
            $this->configNameLength = $productNameLength;
        }

        if ($cartPrice > $this->configPriceLength) {
            $this->configPriceLength = $cartPrice;
        }
    }

    /**
     * To Display
     * 
     * @param  integer $amount
     * @param  float $price
     * @param  string $name
     * @return sring
     */
    public function toDisplay($amount, $price, $name = '')
    {
        $price = self::DISPLAY_MONEY . sprintf(self::DISPLAY_FORMAT, $price);

        return sprintf("%-{$this->configAmountLength}s   %-{$this->configNameLength}s %{$this->configPriceLength}s\n", $amount, $name, $price);
    }

    /**
     * To Display Row
     * 
     * @return sring
     */
    public function toDisplayRow()
    {
        $length = strlen($this->toDisplay('', '', '')) - 1;
        
        return str_repeat('=', $length) . "\n";
    }

    /**
     * Display Product
     * 
     * @param  Product $product
     * @return string
     */
    public function displayProduct(Product $product)
    {
        return $this->toDisplay($product->getAmount(), $product->getTotalPrice(), $product->getName());
    }

    /**
     * Display Total
     * 
     * @param  float $total
     * @return string
     */
    public function displayTotal($total)
    {
        return $this->toDisplayRow() . $this->toDisplay(self::DISPLAY_TOTAL, $total);
    }

    /**
     * Clear
     * 
     * @return void
     */
    public function clear()
    {
        $this->init();
    }

    /**
     * init
     * 
     * @return void
     */
    protected function init()
    {
        $this->configAmountLength = strlen(self::DISPLAY_TOTAL);
        $this->configNameLength = 0;
        $this->configPriceLength = 0;
    }
}
