<?php

declare(strict_types=1);

namespace Lexal\LaravelStepValidator;

final readonly class RulesDefinition
{
    public function __construct(
        /**
         * @var array<string, mixed>
         */
        public array $rules,
        /**
         * @var array<string, string>
         */
        public array $messages = [],
        /**
         * @var array<string, string>
         */
        public array $customAttributes = [],
    ) {
    }
}
