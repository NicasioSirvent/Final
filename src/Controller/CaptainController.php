<?php

namespace App\Controller;

use App\Entity\Captain;
use App\Repository\CaptainRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/captain', name: 'api_')]
class CaptainController extends AbstractController
{
    public function __construct(private CaptainRepository $captainRepo) { }

    #[Route('/', name: 'app_captain_show_all',  methods:['get'])]
    public function showAll(): JsonResponse {
    $captains  = $this->captainRepo->findAll();

        $data = [];
   
        foreach ($captains as $captain) {
           $data[] = [
            'id' => $captain->getId(),
            'license_id' => $captain->getCaptainLicenseId(),
            'name' => $captain->getName(),
            'dni' => $captain->getDni(),
           ];
        }
        return $this->json([$data], 200);
    }

    #[Route('/{id}', name: 'api_captain_show', methods:['get'])]
    public function show(int $id): Response
    {
        $myCaptain = $this->captainRepo->find($id);


        $data =  [
            'id' => $myCaptain->getId(),
            'name' => $myCaptain->getName(),
            'dni' => $myCaptain->getDni(),
            'captain_license_id' => $myCaptain->getCaptainLicenseId(),
        ];


        return $this->json([$data], 200);
    }




    #[Route('/new', name: 'api_captain_create', methods:['post'])]
    public function create(Request $request): Response
    {
        $myCaptain = new Captain();
        $myCaptain->setName($request->request->get('name'));
        $myCaptain->setDni($request->request->get('dni'));
        $myCaptain->setCaptainLicenseId($request->request->get('captain_license_id'));


        $this->captainRepo->save($myCaptain, true);


        $data =  [
            'id' => $myCaptain->getId(),
            'name' => $myCaptain->getName(),
            'dni' => $myCaptain->getDni(),
            'captain_license_id' => $myCaptain->getCaptainLicenseId(),
        ];


        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_captain_edit', methods:['post'])]
    public function edit(int $id, Request $request): Response
    {
        $myCaptain = $this->captainRepo->find($id);


        $myCaptain->setName($request->request->get('name'));
        $myCaptain->setDni($request->request->get('dni'));
        $myCaptain->setCaptainLicenseId($request->request->get('captain_license_id'));


        $this->captainRepo->save($myCaptain, true);


        $data =  [
            'id' => $myCaptain->getId(),
            'name' => $myCaptain->getName(),
            'captain_license_id' => $myCaptain->getCaptainLicenseId(),
        ];


        return $this->json([$data], 201);


    }



    #[Route('/{id}', name: 'api_captain_delete', methods:['delete'])]
    public function delete(int $id): Response
    {
        $myCaptain = $this->captainRepo->find($id);


        if (!$myCaptain) {
            return $this->json('No captain found for id' . $id, 404);
        }


        $this->captainRepo->remove($myCaptain, true);
        
        return $this->json([
            'message' => "Deleted captain with id ". $id,
        ], 200);
    }

}


