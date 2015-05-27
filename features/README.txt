--------------------------
The shopping cart scenario
--------------------------

You must build a simple shopping cart API, in which you can add products + how many of them you want.
Based on how many of the products you add to the cart, the calculated price may fall into multiple discount tiers.

Please allows for 2 products. Lemons and tomatoes, pricing tiers are given in the examples below.

Lemons
ÑÑÑÑÑ-

Pricing tiers:

0-10 = £0.50
10+ = £0.45

Customer adds 25 lemons to their cart.

The price would be calculated as:

(10 * £0.50) + (15 * £0.45) = £11.75


Tomatoes
ÑÑÑÑÑÑÑÑ

0-20 = £0.20
21-100 = £0.18
100+ = £0.14

Customer adds 101 tomatoes to their cart.

The price would be calculated as:

(20 * £0.20) + (80 * £0.18) + (1 * £0.14) = £18.54


The goal of this test is to write a script using the interface for the shopping cart we provide. Please print output to the terminal as follows: 

8	Lemon	£4.00
25	Tomato	£4.90
-----------------
Total:		£8.90

Spacing is dynamically generated depending on product name, so say 'Lemon' would be changed into 'Green Grape',
the spacing for previous and next rows would be adjusted so that the pricing is still in line across all rows.

PLEASE NOTE:

Here are some further examples of what your code should return for given inputs. 

If you run your code and do not get the results below something is wrong.

$cart->addItem($lemon, 10); // Amount of lemons in cart is now 10
echo $cart->getPriceOf($lemon); // 0.50

$cart->addItem($lemon, 5); // Amount of lemons in cart is now 15
echo $cart->getPriceOf($lemon); // 0.45

echo $cart->getTotalSum(); // Final output 7.25