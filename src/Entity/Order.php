<?php

namespace Recruitment\Entity;

use Recruitment\Cart\Cart;

class Order
{
    private int $id;
    private array $items;

    public function __construct(int $id, array $items)
    {
        $this->id = $id;
        $this->items = $items;
    }

    public function getDataForView(): array
    {
        $itemsData = [];
        $id = 1;
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $itemsData[] = [
                'id' => $id++,
                'quantity' => $item->getQuantity(),
                'total_price' => $item->getTotalPrice(),
            ];
            $totalPrice += $item->getTotalPrice();
        }

        return [
            'id' => $this->id,
            'items' => $itemsData,
            'total_price' => $totalPrice,
        ];
    }
}