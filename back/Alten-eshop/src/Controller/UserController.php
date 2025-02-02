<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

#[Route('/', name: 'api_user_')]
final class UserController extends AbstractController
{
    #[Route('/api/users', name: 'list', methods: ['GET'])]
    public function list(UserRepository $userRepository, SerializerInterface $serializer): JsonResponse
    {
        $products = $userRepository->findAll();
        $data = $serializer->serialize($products, 'json', ['groups' => 'user:read']);
        return new JsonResponse($data, Response::HTTP_OK, [], true);
    }

    #[Route('/account', name: 'create', methods: ['POST'])]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        UserPasswordHasherInterface $passwordHasher
    ): Response
    {
        $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse(['message' => 'User créé'], Response::HTTP_CREATED);

    }
}