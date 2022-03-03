<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Validator;

use Lexal\LaravelStepValidator\Entity\RulesDefinition;
use Lexal\LaravelStepValidator\Validator\Exception\ValidatorException;

interface ValidatorInterface
{
    /**
     * Validates step data.
     *
     * @param array<int|string, mixed> $data
     *
     * @throws ValidatorException
     */
    public function validate(array $data, RulesDefinition $definition): void;
}
