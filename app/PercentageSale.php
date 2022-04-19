<?php

namespace App;

/**
 * Class PercentageSale
 * @package App
 */
class PercentageSale implements Discountable
{
    /**
     * @var int
     */
    protected int $discountPercent;

    /**
     * @var int
     */
    protected int $itemCount;

    /**
     * PercentageSale constructor.
     * @param $discountPercent
     * @param $itemCount
     */
    public function __construct($discountPercent, $itemCount)
    {
        $this->itemCount = $itemCount;
        $this->discountPercent = $discountPercent;
    }

    /**
     * @param Cart $cart
     * @return float
     */
    public function calculateDiscount(Cart $cart): float
    {
        if ($cart->getItems()->count() > $this->itemCount) {
            return round($cart->getSubTotal() * ($this->discountPercent / 100), 2);
        }

        return 0.00;
    }
}
