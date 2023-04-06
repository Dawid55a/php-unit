<?php

namespace Recruitment\Cart;

use InvalidArgumentException;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Entity\Product;

class Item
{
    private Product $product;
    private int $quantity;
    public function __construct(Product $product, int $quantity)
    {
        $this->product = $product;
        if ($quantity < $product->getMinimumQuantity()) {
            throw new InvalidArgumentException();
        }
        $this->quantity = $quantity;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @throws QuantityTooLowException
     */
    public function setQuantity(int $quantity): void
    {
        if ($quantity < $this->product->getMinimumQuantity()) {
            throw new QuantityTooLowException("Quantity too low");
        }
        $this->quantity = $quantity;
    }
    public function getTotalPrice(): int
    {
        return $this->product->getUnitPrice() * $this->quantity;
    }
}