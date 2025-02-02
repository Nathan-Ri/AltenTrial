<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\MaxDepth;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $roles = null;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 25, nullable: true)] // je fais nullable pour faciliter l'usage en front
    #[Groups(['user:read'])]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Product::class, inversedBy: 'users')]
    #[Groups(['user:read'])]
    #[MaxDepth(1)]
    private Collection $Products;

    #[ORM\Column(length: 255)]
    #[Groups(['user:read'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: AccessToken::class, mappedBy: "user", cascade: ["remove"])]
    private Collection $accessTokens;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserCart::class)]
    private Collection $userCarts;

    #[ORM\OneToMany(mappedBy: "user", targetEntity: UserCart::class, cascade: ["persist", "remove"])]
    private Collection $cartItems;


    public function __construct()
    {
        $this->Products = new ArrayCollection();
        $this->accessTokens = new ArrayCollection();
        $this->cartItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->Products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->Products->contains($product)) {
            $this->Products->add($product);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        $this->Products->removeElement($product);

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';
        //permet de simplifier le role admin pour l'exercice
        if($this->getEmail() === 'admin@admin.com'){
            $roles[] = 'ROLE_ADMIN';
        }

        return array_unique($roles);
    }

    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
    }

    public function getUserIdentifier(): string
    {
        // TODO: Implement getUserIdentifier() method.
        return (string) $this->email;
    }

    public function getAccessTokens(): Collection
    {
        return $this->accessTokens;
    }

    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }
}
