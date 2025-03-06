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
        $users = $userRepository->findAll();
        $data = $serializer->serialize($users, 'json', ['groups' => 'user:read']);
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
        try {
            $user = $serializer->deserialize($request->getContent(), User::class, 'json');
        } catch (\Exception $e) {
            return new JsonResponse(['error' => 'Données invalides'], Response::HTTP_BAD_REQUEST);
        }
        
        if (!$user->getEmail() || !$user->getPassword()) {
            return new JsonResponse(['error' => 'Email et mot de passe requis'], Response::HTTP_BAD_REQUEST);
        }
        $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));
        $existingUser = $entityManager->getRepository(User::class)->findOneBy(['email' => $user->getEmail()]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Cet email est déjà utilisé'], Response::HTTP_CONFLICT);
        }
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse(['message' => 'User créé'], Response::HTTP_CREATED);

    }
}
