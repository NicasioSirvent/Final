<?php

namespace App\Controller;

use App\Entity\Steward;
use App\Repository\StewardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/steward', name: 'api_')]
class StewardController extends AbstractController
{
    public function __construct(private StewardRepository $stewardRepo) { }

    #[Route('/', name: 'app_steward_show_all',  methods:['get'])]
    public function showAll(): JsonResponse {
    $stewards  = $this->stewardRepo->findAll();

        $data = [];
   
        foreach ($stewards as $steward) {
           $data[] = [
            'id' => $steward->getId(),
            'air_crew_id' => $steward->getAirCrewId(),
            'name' => $steward->getName(),
            'dni' => $steward->getDni(),
           ];
        }
        return $this->json([$data], 200);
    }

    #[Route('/{id}', name: 'api_steward_show', methods:['get'])]
    public function show(int $id): Response
    {
        $mySteward = $this->stewardRepo->find($id);


        $data =  [
            'id' => $mySteward->getId(),
            'name' => $mySteward->getName(),
            'dni' => $mySteward->getDni(),
            'air_crew_id' => $mySteward->getAirCrewId(),
        ];


        return $this->json([$data], 200);
    }




    #[Route('/new', name: 'api_steward_create', methods:['post'])]
    public function create(Request $request): Response
    {
        $mySteward = new Steward();
        $mySteward->setName($request->request->get('name'));
        $mySteward->setDni($request->request->get('dni'));
        $mySteward->setAirCrewId($request->request->get('air_crew_id'));


        $this->stewardRepo->save($mySteward, true);


        $data =  [
            'id' => $mySteward->getId(),
            'name' => $mySteward->getName(),
            'dni' => $mySteward->getDni(),
            'air_crew_id' => $mySteward->getAirCrewId(),
        ];


        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_steward_edit', methods:['post'])]
    public function edit(int $id, Request $request): Response
    {
        $mySteward = $this->stewardRepo->find($id);


        $mySteward->setName($request->request->get('name'));
        $mySteward->setDni($request->request->get('dni'));
        $mySteward->setAirCrewId($request->request->get('air_crew_id'));


        $this->stewardRepo->save($mySteward, true);


        $data =  [
            'id' => $mySteward->getId(),
            'name' => $mySteward->getName(),
            'air_crew_id' => $mySteward->getAirCrewId(),
        ];


        return $this->json([$data], 201);


    }



    #[Route('/{id}', name: 'api_steward_delete', methods:['delete'])]
    public function delete(int $id): Response
    {
        $mySteward = $this->stewardRepo->find($id);


        if (!$mySteward) {
            return $this->json('No steward found for id ' . $id, 404);
        }


        $this->stewardRepo->remove($mySteward, true);
        
        return $this->json([
            'message' => "Deleted steward with id ". $id,
        ], 200);
    }

}


