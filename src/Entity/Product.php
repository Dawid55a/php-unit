<?php

namespace Recruitment\Entity;

use InvalidArgumentException;
use Recruitment\Entity\Exception\InvalidUnitPriceException;

class Product
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var string
     */
    private string $name;

    /**
     * @var int
     */
    private int $unitPrice;

    /**
     * @var int
     */
    private int $minimumQuantity;

    public function __construct()
    {
        $this->unitPrice = 0;
        $this->minimumQuantity = 1;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Product
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnitPrice(): int
    {
        return $this->unitPrice;
    }

    /**
     * @param int $unitPrice
     * @return Product
     * @throws InvalidUnitPriceException
     */
    public function setUnitPrice(int $unitPrice): self
    {
        if ($unitPrice <= 0) {
            throw new InvalidUnitPriceException("Unit price can not be 0!");
        }

        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getMinimumQuantity(): int
    {
        return $this->minimumQuantity;
    }

    public function setMinimumQuantity(int $minimumQuantity): self
    {
        if ($minimumQuantity <= 0) {
            throw new InvalidArgumentException("Minimum quantity can not be 0!");
        }

        $this->minimumQuantity = $minimumQuantity;
        return $this;
    }
}