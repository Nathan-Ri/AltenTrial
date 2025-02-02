<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\AccessTokenRepository;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: AccessTokenRepository::class)]
class AccessToken
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(unique: true)]
    private string $value; // Le token lui-même

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "accessTokens")]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\Column(type: "datetime_immutable")]
    private \DateTimeImmutable $expiresAt;

    public function __construct(User $user, string $token, \DateTimeImmutable $expiresAt)
    {
        $this->user = $user;
        $this->value = $token;
        $this->expiresAt = $expiresAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getUserId(): string
    {
        return $this->user->getUserIdentifier();
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function isValid(): bool
    {
        return $this->expiresAt > new \DateTimeImmutable();
    }
}
