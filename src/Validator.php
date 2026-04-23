<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator;

use Illuminate\Contracts\Validation\Factory as ValidationFactory;
use Lexal\LaravelStepValidator\Exception\ValidatorException;

final readonly class Validator implements ValidatorInterface
{
    public function __construct(private ValidationFactory $validatorFactory)
    {
    }

    public function validate(array $data, RulesDefinition $definition): void
    {
        $validator = $this->validatorFactory->make(
            $data,
            $definition->rules,
            $definition->messages,
            $definition->customAttributes,
        );

        if ($validator->fails()) {
            /** @phpstan-ignore-next-line */
            throw new ValidatorException($validator->errors()->messages());
        }
    }
}
