<?php

declare(strict_types=1);

namespace OtherCode\ComplexHeart\Application\DTO;

use Spatie\DataTransferObject\DataTransferObject;

/**
 * Class DTO
 *
 * An abstract class that acts as an interface between the Spatie/DataTransferObject,
 * so, in case the library changes, it will be necessary to change only this file to
 * provide the same functionality as before.
 *
 * @author Unay Santisteban <usantisteban@othercode.es>
 * @package OtherCode\ComplexHeart\Application\DTO
 */
abstract class DTO extends DataTransferObject
{

}