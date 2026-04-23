<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator\Steps;

use Lexal\LaravelStepValidator\RulesDefinition;

/**
 * @template TEntity of object
 */
interface ValidatableStepInterface
{
    /**
     * Returns Laravel validation rules that the validator will use to validate data.
     *
     * @param TEntity $entity
     */
    public function getRulesDefinition(object $entity): RulesDefinition;
}
