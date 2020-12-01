<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample;

use OtherCode\ComplexHeart\Domain\IsEntity;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue as ProductId;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

final class OrderLine
{
    use IsEntity;

    private ProductId $id;

    private ProductName $name;

    public function __construct(ProductId $id, ProductName $name)
    {
        $this->initialize(['id' => $id, 'name' => $name,]);
    }
}
