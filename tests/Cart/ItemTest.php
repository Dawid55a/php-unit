<?php

declare(strict_types=1);

namespace Recruitment\Tests\Cart;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Recruitment\Cart\Exception\QuantityTooLowException;
use Recruitment\Cart\Item;
use Recruitment\Entity\Product;

class ItemTest extends TestCase
{
    public function testItAcceptsConstructorArgumentsAndReturnsData(): void
    {
        $product = (new Product())->setUnitPrice(10000);

        $item = new Item($product, 10);

        $this->assertEquals($product, $item->getProduct());
        $this->assertEquals(10, $item->getQuantity());
        $this->assertEquals(100000, $item->getTotalPrice());
    }

    public function testConstructorThrowsExceptionWhenQuantityIsTooLow(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $product = (new Product())->setMinimumQuantity(10);

        new Item($product, 9);
    }

    public function testItThrowsExceptionWhenSettingTooLowQuantity(): void
    {
        $this->expectException(QuantityTooLowException::class);

        $product = (new Product())->setMinimumQuantity(10);

        $item = new Item($product, 10);
        $item->setQuantity(9);
    }
}
