<?php

/**
 * This file is part of the AppShoppingCart package.
 *
 * (c) lechatquidanse
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

require_once __DIR__ . '/../vendor/autoload.php';

use App\Cart;
use App\Handler\ProductHandler;

echo <<<TEXT

------------------------------ TEST 1 -------------------------------------\n
Load products from {/src/App/Resources/data/products.json'}
---------------------------------------------------------------------------\n
TEXT;

$productHandler = new ProductHandler();
$productHandler->load(__DIR__ . '/../src/App/Resources/data/products.json', 'json');

$lemon = $productHandler->get('lemon');
$tomatoe = $productHandler->get('tomatoe');

$cart = new Cart();

$cart->addItem($lemon, 25);
echo <<<TEXT
------------------------------ TEST 2 -------------------------------------\n
If Customer has 25 lemons in his cart, so total Sum in Cart:
{$cart->getTotalSum()}
---------------------------------------------------------------------------\n
TEXT;

$cart->clear();
$cart->addItem($tomatoe, 101);
echo <<<TEXT
------------------------------ TEST 3 -------------------------------------\n
If Customer has 101 tomatoes in his cart, so total Sum in Cart:
{$cart->getTotalSum()}
---------------------------------------------------------------------------\n
TEXT;

$cart->clear();
$cart->addItem($lemon, 8);
$cart->addItem($tomatoe, 25);
echo <<<TEXT
------------------------------ TEST 4 -------------------------------------\n
If Customer has 8 lemons and 25 tomatoes in his cart, so total Sum in Cart:
{$cart->getTotalSum()}

And Display cart:

{$cart}
---------------------------------------------------------------------------\n
TEXT;
