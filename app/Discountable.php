<?php

namespace App;

/**
 * Interface Discountable
 * @package App
 */
interface Discountable
{

    /**
     * @param Cart $cart
     * @return float
     */
    public function calculateDiscount(Cart $cart): float;
}
