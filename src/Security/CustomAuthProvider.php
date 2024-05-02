<?php
namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CustomAuthProvider implements AuthenticationProviderInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function authenticate(TokenInterface $token)
    {
        $user = $this->userRepository->findOneBy(['emailUser' => $token->getCredentials()['email']]);

        if (!$user) {
            throw new CustomUserMessageAuthenticationException('Invalid email or password');
        }

        if (!$user->getPassword() === $token->getCredentials()['password']) {
            throw new CustomUserMessageAuthenticationException('Invalid email or password');
        }

        $authenticatedToken = new AuthenticatedToken($user, $user->getRoles());

        return $authenticatedToken;
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof AuthenticatedToken;
    }
}