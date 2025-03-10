<?php

namespace App\Domain;

use App\Entity\Product;
use App\Entity\User;
use App\Entity\UserCart;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class CartDomain {
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    public function addProductToCart(User $user, Product $product)
    {
        $existingCartItem = $this->entityManager->getRepository(UserCart::class)->findOneBy([
            'user' => $user,
            'product' => $product
        ]);

        if ($existingCartItem) {
            $existingCartItem->setQuantity($existingCartItem->getQuantity() + 1);
        } else {
            $cartItem = new UserCart();
            $cartItem->setProduct($product);
            $cartItem->setUser($user);
            $cartItem->setQuantity(1);
            $this->entityManager->persist($cartItem);
        }
    }
}