<?php

declare(strict_types=1);

namespace Recruitment\Tests\Cart;

use OutOfBoundsException;
use PHPUnit\Framework\TestCase;
use Recruitment\Cart\Cart;
use Recruitment\Entity\Order;
use Recruitment\Entity\Product;

class CartTest extends TestCase
{
    public function testItAddsOneProduct(): void
    {
        $product = $this->buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertEquals($product, $cart->getItem(0)->getProduct());
    }

    public function testItRemovesExistingProduct(): void
    {
        $product1 = $this->buildTestProduct(1, 15000);
        $product2 = $this->buildTestProduct(2, 10000);

        $cart = new Cart();
        $cart->addProduct($product1, 1)
            ->addProduct($product2, 1);
        $cart->removeProduct($product1);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(10000, $cart->getTotalPrice());
        $this->assertEquals($product2, $cart->getItem(0)->getProduct());
    }

    public function testItIncreasesQuantityWhenAddingAnExistingProduct(): void
    {
        $product = $this->buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1)
            ->addProduct($product, 2);

        $this->assertCount(1, $cart->getItems());
        $this->assertEquals(45000, $cart->getTotalPrice());
    }

    public function testItUpdatesQuantityOfAnExistingItem(): void
    {
        $product = $this->buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1)
            ->setQuantity($product, 2);

        $this->assertEquals(30000, $cart->getTotalPrice());
        $this->assertEquals(2, $cart->getItem(0)->getQuantity());
    }

    public function testItAddsANewItemWhileSettingQuantityForNonExistentItem(): void
    {
        $product = $this->buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->setQuantity($product, 1);

        $this->assertEquals(15000, $cart->getTotalPrice());
        $this->assertCount(1, $cart->getItems());
    }

    /**
     * @dataProvider getNonExistentItemIndexes
     */
    public function testItThrowsExceptionWhileGettingNonExistentItem(int $index): void
    {
        $this->expectException(OutOfBoundsException::class);

        $product = $this->buildTestProduct(1, 15000);

        $cart = new Cart();
        $cart->addProduct($product, 1);
        $cart->getItem($index);
    }

    public function testRemovingNonExistentItemDoesNotRaiseException(): void
    {
        $cart = new Cart();
        $cart->addProduct($this->buildTestProduct(1, 15000));
        $cart->removeProduct(new Product());

        $this->assertCount(1, $cart->getItems());
    }

    public function testItClearsCartAfterCheckout(): void
    {
        $cart = new Cart();
        $cart->addProduct($this->buildTestProduct(1, 15000));
        $cart->addProduct($this->buildTestProduct(2, 10000), 2);

        $order = $cart->checkout(7);

        $this->assertCount(0, $cart->getItems());
        $this->assertEquals(0, $cart->getTotalPrice());
        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(['id' => 7, 'items' => [
            ['id' => 1, 'quantity' => 1, 'total_price' => 15000],
            ['id' => 2, 'quantity' => 2, 'total_price' => 20000],
        ], 'total_price' => 35000], $order->getDataForView());
    }

    public function getNonExistentItemIndexes(): array
    {
        return [
            [PHP_INT_MIN],
            [-1],
            [1],
            [PHP_INT_MAX],
        ];
    }

    private function buildTestProduct(int $id, int $price): Product
    {
        return (new Product())->setId($id)->setUnitPrice($price);
    }
}
