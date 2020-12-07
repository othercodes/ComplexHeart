<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Tests\Sample;

use OtherCode\ComplexHeart\Domain\Contracts\Entity;
use OtherCode\ComplexHeart\Domain\Traits\IsEntity;
use OtherCode\ComplexHeart\Domain\ValueObjects\UUIDValue as ProductId;
use OtherCode\ComplexHeart\Tests\Sample\ValueObjects\ProductName;

/**
 * Class OrderLine
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Tests\Sample
 */
final class OrderLine implements Entity
{
    use IsEntity;

    private ProductId $id;

    private ProductName $name;

    public function __construct(ProductId $id, ProductName $name)
    {
        $this->initialize(['id' => $id, 'name' => $name,]);
    }
}
