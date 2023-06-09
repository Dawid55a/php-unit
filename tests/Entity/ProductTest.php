<?php

declare(strict_types=1);

namespace Recruitment\Tests\Entity;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Recruitment\Entity\Exception\InvalidUnitPriceException;
use Recruitment\Entity\Product;

class ProductTest extends TestCase
{
    public function testItThrowsExceptionForInvalidUnitPrice(): void
    {
        $this->expectException(InvalidUnitPriceException::class);
        $product = new Product();
        $product->setUnitPrice(0);
    }

    public function testItThrowsExceptionForInvalidMinimumQuantity(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $product = new Product();
        $product->setMinimumQuantity(0);
    }
}
