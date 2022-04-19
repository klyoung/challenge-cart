<?php

namespace App;

/**
 * Class Item
 * @package App
 */
class Item
{
    /**
     * @var int
     */
    protected int $id;

    /**
     * @var float
     */
    protected float $price;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var int
     */
    protected int $quantity;

    /**
     * Item constructor.
     * @param string $name
     * @param float $price
     * @param int $quantity
     */
    public function __construct(string $name, float $price, int $quantity = 1)
    {
        $this->id = rand();
        $this->name = $name;
        $this->price = $price;
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param $quantity
     */
    public function setQuantity($quantity): void
    {
        $this->quantity = $quantity;
    }
}
