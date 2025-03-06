<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\UserCart;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Response;

#[Route('/api/products', name: 'api_product_')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'list', methods: ['GET'])]
    public function list(ProductRepository $productRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $productRepository->findAll();
        $data = $serializer->serialize($products, 'json', ['groups' => 'product:read']);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/{id}', name: 'show', methods: ['GET'])]
    public function show(Product $product, SerializerInterface $serializer): JsonResponse
    {
        $data = $serializer->serialize($product, 'json', ['groups' => 'product:read']);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/', name: 'create', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        try{
            $product = $serializer->deserialize($request->getContent(), Product::class, 'json');
        } catch(\Exception $e) {
            return new JsonResponse(['error' => 'Données invalides'], Response::HTTP_BAD_REQUEST);            
        }
        $entityManager->persist($product);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Produit créé'], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'update', methods: ['PATCH'])] //
    #[IsGranted('ROLE_ADMIN')]
    public function update(Request $request, Product $product, EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        try{
            $serializer->deserialize($request->getContent(), Product::class, 'json', ['product' => $product]);
        } catch(\Exception $e) {
            return new JsonResponse(['error' => 'Données invalides'], Response::HTTP_BAD_REQUEST);            
        }
        $entityManager->flush();

        return new JsonResponse(['message' => 'Produit mis à jour'], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'delete', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$product) {
            return $this->json(['error' => 'Produit non trouvé'], Response::HTTP_NOT_FOUND);
        }
        $entityManager->remove($product);
        $entityManager->flush();
        return new JsonResponse(['message' => 'Produit supprimé'], Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}/addToCart', name: 'add_to_cart', methods: ['POST'])]
    public function addToCart(#[CurrentUser] ?UserInterface $user, Product $product, EntityManagerInterface $entityManager): JsonResponse
    {
        if (!$user) {
            return new JsonResponse(['error' => 'Utilisateur non authentifié'], Response::HTTP_UNAUTHORIZED);
        }
        $existingCartItem = $entityManager->getRepository(UserCart::class)->findOneBy([
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
            $entityManager->persist($cartItem);
        }

        $entityManager->flush();

        return new JsonResponse(['message' => 'Produit ajouté au panier'], Response::HTTP_OK);
    }
}
