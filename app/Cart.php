<?php

namespace App;

use Illuminate\Support\Collection;

/**
 * Class Cart
 * @package App
 */
class Cart
{
    /**
     * @var Collection
     */
    protected Collection $items;

    /**
     * @var float
     */
    protected float $discountAmount = 0.0;

    /**
     * Cart constructor.
     */
    public function __construct()
    {
        $this->items = collect();
    }

    /**
     * Add Item to Cart.
     *
     * @param Item $item
     * @return Item
     */
    public function addItem(Item $item): Item
    {
        $this->items = $this->items->push($item)->keyBy(function (Item $item) {
            return $item->getId();
        });

        return $item;
    }

    /**
     * Remove Item from Cart.
     *
     * @param Item $item
     * @return Item
     */
    public function removeItem(Item $item): Item
    {
        $this->items->forget($item->getId());

        return $item;
    }

    /**
     * Increase quantity of given Item.
     *
     * @param Item $item
     * @param int $quantity
     */
    public function increaseItemQuantity(Item $item, int $quantity = 1)
    {
        $item = $this->items->get($item->getId());

        $newQuantity = $item->getQuantity() + $quantity;

        $item->setQuantity($newQuantity);

        $this->items->put($item->getId(), $item);
    }

    /**
     * Decrease quantity of given Item.
     *
     * @param Item $item
     * @param int $quantity
     */
    public function decreaseItemQuantity(Item $item, int $quantity = 1)
    {
        $item = $this->items->get($item->getId());

        $newQuantity = $item->getQuantity() - $quantity;

        $item->setQuantity($newQuantity);

        if ($newQuantity <= 0) {
            $this->removeItem($item);
        } else {
            $this->items->put($item->getId(), $item);
        }
    }

    /**
     * Calculate discount amount for given discount type.
     *
     * @param Discountable $discountable
     */
    public function addDiscount(Discountable $discountable)
    {
        $this->discountAmount = $discountable->calculateDiscount($this);
    }

    /**
     * Zero out discount amount.
     */
    public function removeDiscount()
    {
        $this->discountAmount = 0.00;
    }

    /**
     * @return float
     */
    public function getDiscountAmount(): float
    {
        return $this->discountAmount;
    }

    /**
     * Calculate subtotal of items in cart.
     *
     * @return float
     */
    public function getSubTotal(): float
    {
        return $this->getItems()->reduce(function ($sumPrice, Item $item) {
            return $sumPrice + ($item->getPrice() * $item->getQuantity());
        });
    }

    /**
     * Calculate total of items in cart.
     *
     * @return float
     */
    public function getTotal(): float
    {
        return $this->getSubTotal() - $this->discountAmount;
    }

    /**
     * @return Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }
}
