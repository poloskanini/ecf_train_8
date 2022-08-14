<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/', name: 'app_user_index' ,methods: ['GET'])]
    public function index(UserRepository $userRepository, PartnerRepository $partnerRepository, StructureRepository $structureRepository): Response
    {
        
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
            'partners' => $partnerRepository->findAll(),
            'structures' => $structureRepository->findAll(),
        ]);
    }
}
