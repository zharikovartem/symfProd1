<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class Phone
{
    private $value;

    public function __construct(string $value)
    {
        Assert::notEmpty($value);
        // if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        // if (!filter_var($value, FILTER_VALIDATE_PHONE)) {
        //     throw new \InvalidArgumentException('Incorrect Phone.');
        // }
        $this->value = mb_strtolower($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue();
    }
}