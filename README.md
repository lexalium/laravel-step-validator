# Step Validator for Laravel & Lumen

The package is built for validating step data on the `BeforeHandleStep` event.

## Requirements

**PHP:** ^8.0

**Laravel:** ^8.0

## Installation

Via Composer

```
composer require lexal/laravel-step-validator
```

### Additional changes for Lumen framework

Add the following snippet to the `bootstrap/app.php` file under the providers
section as follows:

```php
$app->register(Lexal\LaravelStepValidator\ServiceProvider\ServiceProvider::class);
```

## Usage

Implement `ValidatableStepInterface` for the step and the listener will
validate step data before handling the step. The validator will pass
`RulesDefinition` entity data directly to the Laravel validator factory
method.

```php
use Lexal\LaravelStepValidator\Entity\RulesDefinition;
use Lexal\LaravelStepValidator\Steps\ValidatableStepInterface;
use Lexal\SteppedForm\Steps\RenderStepInterface;

class CustomerStep implements RenderStepInterface, ValidatableStepInterface
{
    public function getRulesDefinition(mixed $entity): RulesDefinition
    {
        return new RulesDefinition(
            /* rules */,
            /* messages (default - empty array) */,
            /* custom attributes (default - empty array) */,
        );
    }
}
```

---

## License

Laravel & Lumen Step Validator is licensed under the MIT License. See
[LICENSE](LICENSE) for the full license text.
