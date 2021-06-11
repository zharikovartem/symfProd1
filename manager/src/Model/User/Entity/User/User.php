<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="user_users", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"phone"}),
 *     @ORM\UniqueConstraint(columns={"reset_token_token"})
 * })
 */
class User
{
    public const STATUS_WAIT = 'wait';
    public const STATUS_ACTIVE = 'active';
    public const STATUS_BLOCKED = 'blocked';

    /**
     * @ORM\Column(type="user_user_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var \DateTimeImmutable
     */
    private $date;
    /**
     * @var Phone
     */
    private $phone;
    /**
     * @var string
     */
    private $passwordHash;
    /**
     * @var string
     * @ORM\Column(type="string", length=16)
     */
    private $status;
        /**
     * @var string|null
     * @ORM\Column(type="string", name="confirm_token", nullable=true)
     */
    private $confirmToken;

    public function __construct(
        Id $id, 
        \DateTimeImmutable $date, 
        Phone $phone, 
        string $hash
    )
    {
        $this->id = $id;
        $this->date = $date;
        $this->phone = $phone;
        $this->passwordHash = $hash;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }

    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function confirmSignUp(): void
    {
        if (!$this->isWait()) {
            throw new \DomainException('User is already confirmed.');
        }

        $this->status = self::STATUS_ACTIVE;
        $this->confirmToken = null;
    }

    public function isWait(): bool
    {
         return $this->status === self::STATUS_WAIT;
    }

    public function isActive(): bool
    {
         return $this->status === self::STATUS_ACTIVE;
    }

    public function getConfirmToken(): ?string
    {
        return $this->confirmToken;
    }

    public static function signUpByPhone(Id $id, \DateTimeImmutable $date, Phone $phone, string $hash, string $token): self
    {
        $user = new self($id, $date, $phone, $hash);
        $user->phone = $phone;
        $user->passwordHash = $hash;
        $user->confirmToken = $token;
        $user->status = self::STATUS_WAIT;
        return $user;
    }

}