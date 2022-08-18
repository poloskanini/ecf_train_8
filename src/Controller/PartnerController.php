<?php

namespace App\Controller;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use App\Repository\StructureRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/partner')]
class PartnerController extends AbstractController
{
    #[Route('/', name: 'app_partner_index', methods: ['GET'])]
    public function index(StructureRepository $structureRepository): Response
    {
        // return $this->render('partner/index.html.twig', [
        //     'controller_name' => 'PartnerController',
        // ]);

        $structures = $structureRepository->findAll();
        dd($structures);

        return $this->render('partner/index.html.twig', [
            'structures' => $structures,
        ]);
    }

    #[Route('/show/{id}', name: 'app_partner_show', methods: ['GET'])]
    public function show(Partner $partner)
    {
        // $structures = $partner->getStructures();
        // foreach ($structures as $structure) {
        //     dd($structure);
        // }

        // return $this->render('partner/_show.html.twig', [
        //     'partner' => $partner,
        //     'structures' => $structures
        // ]);

        $structures = $partner->getStructures();

        return $this->render('partner/_show.html.twig', [
            'partner' => $partner,
            'structures' => $structures
        ]);
    }
}
