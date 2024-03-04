<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;


class ProfileController extends AbstractController
{
    private UserRepository $userRepository;
    private UserPasswordHasherInterface $passwordHasher;
    private $jwtManager;

    public function __construct(
        UserRepository $userRepository,
        UserPasswordHasherInterface $passwordHasher,
        JWTTokenManagerInterface $jwtManager
    ) {
        $this->userRepository = $userRepository;
        $this->passwordHasher = $passwordHasher;
        $this->jwtManager = $jwtManager;
    }

    #[Route(
        "/api/users/{id}",
        name: "patch_user",
        defaults: [
            "_api_resource_class" => User::class,
            "_api_item_operation_name" => "get_current_user"
        ],
        methods: ["PATCH"]
    )]
    public function updateUser(UserInterface $user, Request $request,  UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        if (!$user instanceof User) {
            return new JsonResponse(['message' => 'User not found'], 404);
        }

        $requestContent = json_decode($request->getContent(), true);


        if (isset($requestContent['email'])) {
            $user->setEmail($requestContent['email']);
        }
        

        if (isset($requestContent['password'])) {

            $previousPassword = $requestContent['previousPassword'];
            $password = $requestContent['password'];
            $confirmPassword = $requestContent['confirmPassword'];


            if ($password !== $confirmPassword) {
                return new JsonResponse(['message' => 'Passwords do not match'], 400);
            }
            if (!$passwordHasher->isPasswordValid($user, $previousPassword)) {
                return new JsonResponse(['message' => 'L\'ancien mot de passe saisi est incorrect'], 400);
            }
            $user->setPassword($this->passwordHasher->hashPassword($user, $password));
        }
        $token = $this->jwtManager->create($user);
        $this->userRepository->updateUser($user);

        $userData = [
            'email' => $user->getEmail(),
            'token' => $token
        ];

        return new JsonResponse($userData);
    }
}