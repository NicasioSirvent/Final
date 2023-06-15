<?php

namespace App\Controller;

use App\Entity\Passenger;
use App\Entity\Flight;
use App\Repository\PassengerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/passenger', name: 'api_')]
class PassengerController extends AbstractController
{
    public function __construct(private PassengerRepository $passengerRepo) { }

    #[Route('/', name: 'app_passenger_show_all',  methods:['get'])]
    public function showAll(): JsonResponse {
    $passengers  = $this->passengerRepo->findAll();

        $data = [];
   
        foreach ($passengers as $passenger) {
           $data[] = [
            'id' => $passenger->getId(),
            'seat' => $passenger->getSeat(),
            'name' => $passenger->getName(),
            'dni' => $passenger->getDni(),
           ];
        }
        return $this->json([$data], 200);
    }

    #[Route('/{id}', name: 'api_passenger_show', methods:['get'])]
    public function show(int $id): Response
    {
        $myPassenger = $this->passengerRepo->find($id);


        $data =  [
            'id' => $myPassenger->getId(),
            'name' => $myPassenger->getName(),
            'dni' => $myPassenger->getDni(),
            'seat' => $myPassenger->getSeat(),
        ];


        return $this->json([$data], 200);
    }




    #[Route('/new', name: 'api_passenger_create', methods:['post'])]
    public function create(Request $request): Response
    {
        $myPassenger = new Passenger();
        $myPassenger->setName($request->request->get('name'));
        $myPassenger->setDni($request->request->get('dni'));
        $myPassenger->setSeat($request->request->get('seat'));


        $this->passengerRepo->save($myPassenger, true);


        $data =  [
            'id' => $myPassenger->getId(),
            'name' => $myPassenger->getName(),
            'dni' => $myPassenger->getDni(),
            'seat' => $myPassenger->getSeat(),
        ];


        return $this->json([$data], 201);
    }

    #[Route('/{id}/edit', name: 'api_passenger_edit', methods:['post'])]
    public function edit(int $id, Request $request): Response
    {
        $myPassenger = $this->passengerRepo->find($id);


        $myPassenger->setName($request->request->get('name'));
        $myPassenger->setDni($request->request->get('dni'));
        $myPassenger->setSeat($request->request->get('seat'));


        $this->passengerRepo->save($myPassenger, true);


        $data =  [
            'id' => $myPassenger->getId(),
            'name' => $myPassenger->getName(),
            'seat' => $myPassenger->getSeat(),
        ];


        return $this->json([$data], 201);


    }



    #[Route('/{id}', name: 'api_passenger_delete', methods:['delete'])]
    public function delete(int $id): Response
    {
        $myPassenger = $this->passengerRepo->find($id);


        if (!$myPassenger) {
            return $this->json('No passenger found for id ' . $id, 404);
        }


        $this->passengerRepo->remove($myPassenger, true);
        
        return $this->json([
            'message' => "Deleted passenger with id ". $id,
        ], 200);
    }


    #[Route('/addFlight', name: 'api_passenger_add_flight', methods:['post'])]
    public function addToFlight(Request $request, ManagerRegistry $doctrine): Response
    {
        $myPassenger = $this->passengerRepo->find($request->request->get('passenger_id'));
        $myFlight = $doctrine->getRepository(Flight::class)->find($request->request->get('flight_id'));
        $myPassenger->addFlight($myFlight);


        $this->passengerRepo->save($myPassenger, true);


        $data =  [
            'id' => $myPassenger->getId(),
            ];


        return $this->json([$data], 201);
    }

}


