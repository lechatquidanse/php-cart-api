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

use App\Loader\JsonFileLoader;
use App\Model\Product;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Product Handler
 *
 * Handler that load available products from differents resources.
 *
 * @package ShoppingCart
 * @author lechatquidanse
 */
class ProductHandler
{
    /**
     * Loaders
     *
     * @var array $loaders
     */
    protected $loaders = array();

    /**
     * Products
     *
     * Array Collection of Products
     *
     * @var Doctrine\Common\Collections\ArrayCollection $products
     */
    public $products;

    /**
     * _construct
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->loaders['json'] = new JsonFileLoader();
    }

    /**
     * Load
     *
     * Load and set Product in ProductCollection from resource and format
     *
     * @param string $resource
     * @param string $format
     * @throws \Exception if one missing parameters for new Product instance
     * @return void
     */
    public function load($resource, $format)
    {
        $productsArray = $this->loaders[$format]->loadResource($resource);

        foreach ($productsArray as $productArray) {
            $id = $productArray['id'];
            $name = $productArray['name'];
            $price = $productArray['price'];
            $discounts = $productArray['discounts'];

            $product = new Product($id, $name, $price, $discounts);
            $this->products->set($id, $product);
        }
    }

    /**
     * Get
     *
     * Gets the Product at the specified index.
     *
     * @param integer $key The index of the Product to retrieve.
     * @return App\Model\Product
     */
    public function get($id)
    {
        return $this->products->get($id);
    }
}
