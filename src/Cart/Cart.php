<?php

namespace Recruitment\Cart;

use Recruitment\Entity\Order;
use Recruitment\Entity\Product;



class Cart
{

    private array $items;


    public function __construct()
    {
        $this->items = [];
    }
    public function addProduct(Product $product, int $int = 1) : self
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product) {
                $item->setQuantity($item->getQuantity() + $int);
                return $this;
            }
        }
        $this->items[] = new Item($product, $int);
        return $this;
    }

    public function removeProduct(Product $product): void
    {
        foreach ($this->items as $key => $item) {
            if ($item->getProduct() === $product) {
                unset($this->items[$key]);
                // reindex array after unset to avoid gaps in keys
                $this->items = array_values($this->items);
            }
        }
    }

    public function getTotalPrice(): int
    {
        $priceSum = 0;
        foreach ($this->items as $item) {
            $priceSum += $item->getTotalPrice();
        }
        return $priceSum;
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getItem(int $int): Item
    {
        if (!isset($this->items[$int])) {
            throw new \OutOfBoundsException();
        }
        return $this->items[$int];
    }

    public function setQuantity(Product $product, int $int): self
    {
        foreach ($this->items as $item) {
            if ($item->getProduct() === $product) {
                $item->setQuantity($int);
            return $this;
            }
        }
        $this->items[] = new Item($product, $int);
        return $this;

    }

    public function checkout(int $oder_id): Order
    {
        $order = new Order($oder_id, $this->items);
        $this->items = array();
        return $order;
    }
}