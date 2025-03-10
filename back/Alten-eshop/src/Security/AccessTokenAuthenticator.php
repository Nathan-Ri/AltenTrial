<?php


namespace App\Security;

use phpDocumentor\Reflection\Types\This;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authenticator\Token\PostAuthenticationToken;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AccessTokenAuthenticator extends AbstractAuthenticator
{
    public function __construct(private AccessTokenHandler $accessTokenHandler)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->headers->has('Authorization');
    }

    public function authenticate(Request $request): Passport
    {
        $token = str_replace('Bearer ', '', $request->headers->get('Authorization', ''));

        if (!$token) {
            throw new AuthenticationException('No API token provided.');
        }

        $userBadge = $this->accessTokenHandler->getUserBadgeFrom($token);

        return new SelfValidatingPassport($userBadge);
    }

    public function createAuthenticatedToken(Passport $passport, string $firewallName): PostAuthenticationToken
    {
        return new PostAuthenticationToken(
            $passport->getUser(),
            $firewallName,
            $passport->getUser()->getRoles()
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        // TODO: Implement onAuthenticationFailure() method.
        return new Response('Unauthenticated', Response::HTTP_UNAUTHORIZED);
    }
}
