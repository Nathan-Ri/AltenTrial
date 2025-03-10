<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read'])]
    #[Assert\Length(min:5)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $image = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['product:read'])]
    private ?string $category = null;

    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $quantity = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read'])]
    private ?string $internalReference = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['product:read'])]
    private ?int $shellId = null;

    #[ORM\Column(length: 255)]
    #[Groups(['product:read'])]
    private ?string $inventoryStatus = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['product:read'])]
    private ?int $rating = null;

    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $createdAt = null;

    #[ORM\Column]
    #[Groups(['product:read'])]
    private ?int $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Products')]
    #[Groups(['product:read'])]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: UserCart::class)]
    private Collection $userCarts;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->userCarts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;

        return $this;
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getInternalReference(): ?string
    {
        return $this->internalReference;
    }

    public function setInternalReference(string $internalReference): static
    {
        $this->internalReference = $internalReference;

        return $this;
    }

    public function getShellId(): ?int
    {
        return $this->shellId;
    }

    public function setShellId(?int $shellId): static
    {
        $this->shellId = $shellId;

        return $this;
    }

    public function getInventoryStatus(): ?string
    {
        return $this->inventoryStatus;
    }

    public function setInventoryStatus(string $inventoryStatus): static
    {
        $this->inventoryStatus = $inventoryStatus;

        return $this;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getCreatedAt(): ?int
    {
        return $this->createdAt;
    }

    public function setCreatedAt(int $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?int
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(int $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->addProduct($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            $user->removeProduct($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCart>
     */
    public function getUserCarts(): Collection
    {
        return $this->userCarts;
    }

    public function addUserCart(UserCart $userCart): static
    {
        if (!$this->userCarts->contains($userCart)) {
            $this->userCarts->add($userCart);
            $userCart->setProduct($this);
        }

        return $this;
    }

    public function removeUserCart(UserCart $userCart): static
    {
        if ($this->userCarts->removeElement($userCart)) {
            // set the owning side to null (unless already changed)
            if ($userCart->getProduct() === $this) {
                $userCart->setProduct(null);
            }
        }

        return $this;
    }
}
