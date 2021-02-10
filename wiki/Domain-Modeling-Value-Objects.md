
```php
use OtherCode\ComplexHeart\Domain\Contracts\ValueObject;
use OtherCode\ComplexHeart\Domain\Traits\IsValueObject;

/**
 * Class Color
 * @method string value()
 */
final class Color implements ValueObject 
{
    use IsValueObject;
    
    private string $value;
 
    public function __construct(string $value) 
    {
        $this->initialize(['value' => $value]);
    }
    
    protected function invariantValueMustBeHexadecimal(): bool 
    {
        return preg_match('/^#(?:[0-9a-fA-F]{3}){1,2}$/', $this->value) === 1;
    }
    
    public function __toString(): string 
    {
        return $this->value();
    }
}

$red = new Color('#ff0000');
$red->equals(new Color('#00ff00')); // false
$red->value(); // #ff0000
$magenta = new Color('ff00ff'); // Exception InvariantViolation: Value must be hexadecimal.
```