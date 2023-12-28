<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator;

final class RulesDefinition
{
    public function __construct(
        /**
         * @var array<string, mixed>
         */
        public readonly array $rules,
        /**
         * @var array<string, string>
         */
        public readonly array $messages = [],
        /**
         * @var array<string, string>
         */
        public readonly array $customAttributes = [],
    ) {
    }
}
