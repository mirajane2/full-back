<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController {


    private $jwtTokenManager;

    public function __construct(JWTTokenManagerInterface $jwtTokenManager)
    {
        $this->jwtTokenManager = $jwtTokenManager;
    }

    #[Route('/api/login', methods:['POST'])]
    public function login(Request $request, UserRepository $userRepository):Response {

        $data = json_decode($request -> getContent(), true);
        $username = $data['username'] ?? null;
        $password = $data['password'] ?? null;

        if(!$username | !$password) {
            return $this-> json(['error' => 'email et password requis ']);
        }

        $user = $userRepository->findOneBy(['email' => $username]);

        if (!$user) {
            return $this->json(['error' => 'Identifiants invalides']);
        }
    
        if (!password_verify($password, $user->getPassword())) {
            return $this->json(['error' => 'Identifiants invalides']);
        }
        try {
            $token = $this -> jwtTokenManager ->create($user);
        }
        catch(\Exception) {
            return $this->json(['error' => 'Erreur lors de la création du token']);
        }

        return $this -> json([
            'message' => 'connexion reussie',
            'token' => $token
        ]);
    }
}