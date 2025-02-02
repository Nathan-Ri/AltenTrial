<?php

namespace App\Controller;

use App\Entity\AccessToken;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiLoginController extends AbstractController
{

    #[Route('/authenticate/login', name: 'app_api_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?UserInterface $user, EntityManagerInterface $entityManager): JsonResponse
    {
        if (null === $user) {
            return $this->json(['message' => 'missing credentials :)'], Response::HTTP_UNAUTHORIZED);
        }

        // Génération du token
        $tokenValue = bin2hex(random_bytes(20));
        $expiresAt = new \DateTimeImmutable('+1 hour');

        // Création du token en base de données
        $token = new AccessToken($user, $tokenValue, $expiresAt);
        $entityManager->persist($token);
        $entityManager->flush();

        return $this->json([
            'email' => $user->getUserIdentifier(),
            'token' => $tokenValue,
            'expires_at' => $expiresAt->format('Y-m-d H:i:s'),
        ]);
    }

}
