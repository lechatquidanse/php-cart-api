<?php

/**
 * This file is part of the ShoppingCart package.
 *
 * (c) lechatquidanse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Model;

use App\Model\Discount;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product
 *
 * @package ShoppingCart
 * @author lechatquidanse
 */
class Product
{
    /**
     * Id
     *
     * Id to identify a product
     *
     * @var integer|string $id
     */
    public $id;

    /**
     * Name
     *
     * Name displayed
     *
     * @var string $name
     */
    public $name;

    /**
     * Price
     *
     * Product price
     *
     * @var float $price
     */
    public $price;

    /**
     * Total Price
     *
     * Product total price
     *
     * @var float $price
     */
    public $totalPrice = 0.00;

    /**
     * Amount
     *
     * Amount of product
     *
     * @var integer $amount
     */
    public $amount;

    /**
     * Discounts
     *
     * ArrayColletion of discounts
     *
     * @var Doctrine\Common\Collections\ArrayCollection $discounts
     */
    public $discounts;

    /**
     * _constructor
     *
     * @param integer|string $id
     * @param string $name
     * @param float $price
     * @param array $discounts
     */
    public function __construct($id, $name, $price, array $discounts = array())
    {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;

        $this->discounts = new ArrayCollection();
        $this->fillDiscountsFromArrayData($discounts);
    }
    
    /**
     * Get Total Price From Amount
     *
     * Return the total price of product according to amount and discounts.
     * It follows these steps:
     * 1 - if no discounts for this product, return amount * price
     * 2 - else, for each discounts:
     * 2a - if amount of product <= to amount of discount,  this discount is used amount times, return totalPrice
     * 2b - else add discount amount to totalprice, substract the amount of product and repeat 2
     *
     * @return float
     */
    public function getTotalPriceFromAmount()
    {
        $totalPrice = 0;
        $amount = $this->amount;

        foreach ($this->discounts as $discount) {
            $discountRangeAmount = $discount->getRangeAmount();

            if ($discountRangeAmount > 0) {
                $tmpAmount = $amount;
                $amount = $amount - $discountRangeAmount;

                if ($amount <= 0) {
                    $discount->setNbUsed($tmpAmount);
                    $totalPrice += $discount->getTotalPriceDiscount($this->price);

                    return $totalPrice;
                } else {
                    $discount->setNbUsed($discountRangeAmount);
                    $totalPrice += $discount->getTotalPriceDiscount($this->price);
                }
            } else {
                $discount->setNbUsed($amount);
                $totalPrice += $discount->getTotalPriceDiscount($this->price);

                return $totalPrice;
            }
        }

        return $this->amount * $this->price;
    }

    /**
     * Set Total Price From Amount
     *
     * @return void
     */
    public function setTotalPriceFromAmount()
    {
        $this->totalPrice = $this->getTotalPriceFromAmount();
    }

    /**
     * Get Price From Amount
     *
     * If no Discounts return default price, else apply reduction according to amount and discounts
     * 
     * @return integer
     */
    public function getPriceFromAmount()
    {
        foreach ($this->discounts as $discount) {
            if ($discount->isInRangeAmount($this->amount)) {
                return $discount->getPriceDiscount($this->price);
            }
        }

        return $this->price;
    }

    /**
     * Increment Amount By Value
     *
     * Increment the amount with value
     *
     * @param integer $value
     * @return void
     */
    public function incrementAmountByValue($value)
    {
        $this->amount += $value;
    }

    /**
     * Fill Discounts From Array Data
     *
     * Fill discounts array collection with Discount object thanks to array data
     *
     * @param array $discounts
     * @return void
     */
    public function fillDiscountsFromArrayData(array $discounts)
    {
        foreach ($discounts as $key => $discount) {
            $minAmount = isset($discount['minAmount']) ? $discount['minAmount'] : 0;
            $maxAmount = isset($discount['maxAmount']) ? $discount['maxAmount'] : 0;
            $reduction = isset($discount['reduction']) ? $discount['reduction'] : 0;

            $discount = new Discount($minAmount, $maxAmount, $reduction);
            $this->discounts->add($discount);
        }
    }

    /**
     * Get Id
     *
     * @return integer|string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
    
    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set Price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }
    
    /**
     * Get total price
     *
     * @return float
     */
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }

    /**
     * Set Total Price
     *
     * @param float $price
     * @return Product
     */
    public function setTotalPrice($totalPrice)
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    /**
     * Get Name
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set Amount
     *
     * @param integer $amount
     * @return Product
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }
    
    /**
     * Get Discounts
     *
     * @return ArrayCollection
     */
    public function getDiscounts()
    {
        return $this->discounts;
    }

    /**
     * Set Discounts
     *
     * @param ArrayCollection $discounts
     * @return Product
     */
    public function setDiscounts(ArrayCollection $discounts)
    {
        $this->discounts = $discounts;
        
        return $this;
    }

    /**
     * Add Discount
     *
     * @param Discount $discount
     * @return boolean
     */
    public function addDiscount(Discount $discount)
    {
        return $this->discounts->add($discount);
    }
}
