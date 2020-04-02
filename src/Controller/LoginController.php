<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class LoginController extends AbstractController
{
    /**
     {
        "email": "lalala",
        "password": "mdp"
     }
     */

    /**
     * @Route("/api/login", name="login", methods={"POST"})
     * @param Request $request
     * @param SerializerInterface $serializer
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function index(Request $request, SerializerInterface $serializer, EntityManagerInterface $em, UserPasswordEncoderInterface $passwordEncoder, UserRepository $userRepository)
    {
        $jsonRecu = $request->getContent();

        try {
            $u = $serializer->deserialize($jsonRecu, User::class, 'json');
            $user = $userRepository->findOneBy(['email' => $u->getEmail()]);

            $match = password_verify($u->getPassword(), $user->getPassword());

            if ($match) {
                return $this->json([
                    'email' => $user->getEmail(),
                    'login' => $user->getLogin()
                ], 200, [], []);
            } else {
                return $this->json([
                    'error' => 'Unauthorized'
                ], 401, [], []);
            }
        } catch (NotEncodableValueException $e) {
            return $this->json([
                'status' => 400,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * @Route("/api/users", name="get_users", methods={"GET"})
     * @param UserRepository $userRepository
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getUsers(UserRepository $userRepository)
    {
        return $this->json($userRepository->findAll(), 200, [], []);
    }
}
