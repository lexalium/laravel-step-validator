# Step Validator for Laravel & Lumen

[![PHPUnit, PHPCS, PHPStan Tests](https://github.com/lexalium/laravel-step-validator/actions/workflows/tests.yml/badge.svg)](https://github.com/lexalium/laravel-step-validator/actions/workflows/tests.yml)

The package is built for validating step data on the `BeforeHandleStep` event of [Stepped Form](https://github.com/lexalium/stepped-form).

## Requirements

**PHP:** >=8.1

**Laravel:** ^9.0 || ^10.0

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

Implement `ValidatableStepInterface` for the step and the listener will validate step data before handling the step.
The validator will pass `RulesDefinition` data directly to the Laravel validator factory method.

```php
use Lexal\LaravelStepValidator\RulesDefinition;
use Lexal\LaravelStepValidator\Steps\ValidatableStepInterface;
use Lexal\SteppedForm\Steps\RenderStepInterface;

final class CustomerStep implements RenderStepInterface, ValidatableStepInterface
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

Laravel & Lumen Step Validator is licensed under the MIT License. See [LICENSE](LICENSE) for the full license text.
