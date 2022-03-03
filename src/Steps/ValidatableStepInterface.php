<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Steps;

use Lexal\LaravelStepValidator\Entity\RulesDefinition;

interface ValidatableStepInterface
{
    /**
     * Returns Laravel validation rules that the validator will use to validate data.
     */
    public function getRulesDefinition(mixed $entity): RulesDefinition;
}
