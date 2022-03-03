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

---

## License

Laravel & Lumen Step Validator is licensed under the MIT License. See
[LICENSE](LICENSE) for the full license text.
