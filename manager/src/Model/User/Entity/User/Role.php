<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class Role
{
    public const USER = 'ROLE_USER';
    public const ADMIN = 'ROLE_ADMIN';
    public const MODERATOR = 'ROLE_MODERATOR';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::USER,
            self::MODERATOR,
            self::ADMIN,
        ]);

        $this->name = $name;
    }

    public static function user(): self
    {
        return new self(self::USER);
    }

    public static function admin(): self
    {
        return new self(self::ADMIN);
    }

    public static function moderator(): self
    {
        return new self(self::MODERATOR);
    }

    public function isUser(): bool
    {
        return $this->name === self::USER;
    }

    public function isAdmin(): bool
    {
        return $this->name === self::ADMIN;
    }

    public function isModerator(): bool
    {
        return $this->name === self::MODERATOR;
    }

    public function isEqual(self $role): bool
    {
        return $this->getName() === $role->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
