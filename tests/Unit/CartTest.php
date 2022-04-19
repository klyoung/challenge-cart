<?php

namespace Tests\Unit;

use App\Cart;
use App\Item;
use App\PercentageSale;
use PHPUnit\Framework\TestCase;

class CartTest extends TestCase
{
    /**
     * @var Cart
     */
    protected Cart $cart;

    /**
     * @var Item
     */
    protected Item $mattress;

    /**
     * @var Item
     */
    protected Item $pillow;

    /**
     * @var Item
     */
    protected Item $foundation;

    /**
     * Setup.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->cart = new Cart();
        $this->pillow = new Item('2x Dream Pillows', 50);
        $this->mattress = new Item('Helix Moonlight Luxe', 2049.00);
        $this->foundation = new Item('Queen Foundation', 299, 3);

        // add initial items to cart
        $this->cart->addItem($this->pillow);
        $this->cart->addItem($this->mattress);
        $this->cart->addItem($this->foundation);
    }

    public function test_that_it_can_add_an_item_to_the_cart()
    {
        $this->assertNotEmpty($this->cart->getItems());
        $this->assertArrayHasKey($this->mattress->getId(), $this->cart->getItems());
    }

    public function test_that_it_can_remove_an_item_from_the_cart()
    {
        $this->cart->removeItem($this->mattress);

        $this->assertArrayNotHasKey($this->mattress->getId(), $this->cart->getItems());
    }

    public function test_that_it_can_increase_the_quantity_of_an_item_in_the_cart()
    {
        // increase quantity using default
        $this->cart->increaseItemQuantity($this->pillow);

        $expectedQuantity = 2;

        $this->assertEquals($expectedQuantity, $this->pillow->getQuantity());

        // increase quantity explicitly
        $this->cart->increaseItemQuantity($this->pillow, 4);

        $expectedQuantity = 6;

        $this->assertEquals($expectedQuantity, $this->pillow->getQuantity());
    }

    public function test_that_it_can_decrease_the_quantity_of_an_item_in_the_cart()
    {
        // decrease quantity using default
        $this->cart->decreaseItemQuantity($this->foundation);

        $expectedQuantity = 2;

        $this->assertEquals($expectedQuantity, $this->foundation->getQuantity());

        // decrease quantity explicitly
        $this->cart->decreaseItemQuantity($this->foundation, 2);

        $expectedQuantity = 0;

        $this->assertEquals($expectedQuantity, $this->foundation->getQuantity());

        // assert item was removed from cart once quantity equaled zero
        $this->assertArrayNotHasKey($this->foundation->getId(), $this->cart->getItems());
    }

    public function test_that_it_can_add_a_discount_to_the_cart()
    {
        $percentageSalesDiscount = new PercentageSale(25, 1);

        $this->cart->addDiscount($percentageSalesDiscount);

        $this->assertNotEquals( 0.0, $this->cart->getDiscountAmount());
    }

    public function test_that_it_can_remove_a_discount_to_the_cart()
    {
        $percentageSalesDiscount = new PercentageSale(25, 1);

        $this->cart->addDiscount($percentageSalesDiscount);

        $this->cart->removeDiscount();

        $this->assertEquals( 0.0, $this->cart->getDiscountAmount());
    }

    public function test_that_it_can_get_the_subtotal_of_the_cart_without_a_discount()
    {
        $this->assertEquals(2996, $this->cart->getSubTotal());
    }

    public function test_that_it_can_get_the_subtotal_of_the_cart_with_a_discount()
    {
        $percentageSalesDiscount = new PercentageSale(25, 1);

        $this->cart->addDiscount($percentageSalesDiscount);

        $this->assertEquals(2996, $this->cart->getSubTotal());
    }

    public function test_that_it_can_get_the_total_of_the_cart_without_a_discount()
    {
        $this->assertEquals(2996, $this->cart->getTotal());
    }

    public function test_that_it_can_get_the_total_of_the_cart_with_a_discount()
    {
        $percentageSalesDiscount = new PercentageSale(25, 1);

        $this->cart->addDiscount($percentageSalesDiscount);

        $this->assertEquals(2247, $this->cart->getTotal());
    }
}
