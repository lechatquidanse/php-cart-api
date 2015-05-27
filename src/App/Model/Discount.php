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

/**
 * Discount
 *
 * @package ShoppingCart
 * @author lechatquidanse
 */
class Discount
{
    /**
     * Min Amount
     *
     * Min Amount for using Discount
     *
     * @var integer $minAmount
     */
    protected $minAmount = 0;

    /**
     * Max Amount
     *
     * Max Amount for using Discount.
     * If is false then maxAmount is +infini
     *
     * @var integer|false $maxAmount
     */
    protected $maxAmount = 0;

    /**
     * Reduction
     *
     * Pourcentage reduction to apply
     *
     * @var float $reduction
     */
    protected $reduction = 0.00;

    /**
     * Nb Used
     *
     * Number of time this discounts is used for a product
     *
     * @var integer $nbUsed
     */
    protected $nbUsed = 0;

    /**
     * _construct
     *
     * @param integer $minAmount
     * @param integer $maxAmount
     * @param float $reduction
     */
    public function __construct($minAmount, $maxAmount, $reduction)
    {
        $this->minAmount = $minAmount;
        $this->maxAmount = $maxAmount;
        $this->reduction = $reduction;
    }

    /**
     * Get Price Discount
     *
     * Return price with reduction application
     *
     * @param float $price
     * @return float
     */
    public function getPriceDiscount($price)
    {
        return $price - ($price * $this->reduction);
    }

    /**
     * Get Total Price Discount
     *
     * Return price with number of reduction application
     *
     * @param float $price
     * @return float
     */
    public function getTotalPriceDiscount($price)
    {
        return $this->nbUsed * $this->getPriceDiscount($price);
    }

    /**
     * Is In Range Amount
     *
     * Return true if number is between minAmount and maxAmount.
     * If maxAmount is false, it means that it is +infini
     *
     * @param integer $number
     * @return boolean
     */
    public function isInRangeAmount($number)
    {
        if ($this->minAmount < $number) {
            if (!$this->maxAmount) {
                return true;
            } else if ($number <= $this->maxAmount) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get Range Amount
     *
     * Return amount between minAmount and maxAmount
     * @return type
     */
    public function getRangeAmount()
    {
        return is_int($this->getMaxAmount()) ? $this->getMaxAmount() - $this->getMinAmount() : false;
    }

    /**
     * Get Min Amount
     *
     * @return integer
     */
    public function getMinAmount()
    {
        return $this->minAmount;
    }

    /**
     * Set Min Amount
     *
     * @param integer $minAmount
     * @return Discount
     */
    public function setMinAmount($minAmount)
    {
        $this->minAmount = $minAmount;

        return $this;
    }

    /**
     * Get Max Amount
     *
     * @return integer
     */
    public function getMaxAmount()
    {
        return $this->maxAmount;
    }

    /**
     * Set Max Amount
     *
     * @param integer $maxAmount
     * @return Discount
     */
    public function setMaxAmount($maxAmount)
    {
        $this->maxAmount = $maxAmount;

        return $this;
    }

    /**
     * Get Reduction
     *
     * @return float
     */
    public function getReduction()
    {
        return $this->reduction;
    }

    /**
     * Set Reduction
     *
     * @param float $reduction
     * @return Discount
     */
    public function setReduction($reduction)
    {
        $this->reduction = $reduction;

        return $this;
    }

    /**
     * Get Nb Used
     *
     * @return integer
     */
    public function getNbUsed()
    {
        return $this->nbUsed;
    }

    /**
     * Set Nb Used
     *
     * @param intger $nbUsed
     * @return Discount
     */
    public function setNbUsed($nbUsed)
    {
        $this->nbUsed = $nbUsed;

        return $this;
    }
}
