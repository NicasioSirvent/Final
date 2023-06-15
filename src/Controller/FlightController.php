<?php

namespace App\Controller;

use App\Entity\Flight;
use App\Entity\Captain;
use App\Repository\CaptainRepository;
use App\Repository\FlightRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/flight', name: 'api_')]
class FlightController extends AbstractController
{
    public function __construct(private FlightRepository $flightRepo) { }

    #[Route('/', name: 'app_flight_show_all',  methods:['get'])]
    public function showAll(): JsonResponse {
    $flights  = $this->flightRepo->findAll();

        $data = [];
   
        foreach ($flights as $flight) {
           $data[] = [
            'id' => $flight->getId(),
            'number' => $flight->getNumber(),
            'from_airport' => $flight->getFromAirport(),
            'to_airport' => $flight->getToAirport(),
            'captain' => $flight->getCaptain()->getName(),
            'stewards' => $flight->getStewards(),
            'passengers' => $flight->getPassengers(),
           ];
        }
        return $this->json([$data], 200);
    }

    #[Route('/{id}', name: 'api_flight_show', methods:['get'])]
    public function show(int $id): Response
    {
        $flight = $this->flightRepo->find($id);


        $data =  [
        'number' => $flight->getNumber(),
        'from_airport' => $flight->getFromAirport(),
        'to_airport' => $flight->getToAirport(),
        'captain' => $flight->getCaptain()->getName(),
        'stewards' => $flight->getStewards(),
        'passengers' => $flight->getPassengers(),
       ];


        return $this->json([$data], 200);
    }




    #[Route('/new', name: 'api_flight_create', methods:['post'])]
    public function create(Request $request,ManagerRegistry $doctrine ): Response
    {
        $requestData = $request->request->all();

        $flight = new Flight();
        $flight->setNumber(intval($requestData['number']));
        $flight->setFromAirport($requestData['from_airport']);
        $flight->setToAirport($requestData['to_airport']);
        $flight->setCaptain($doctrine->getRepository(Captain::class)->find(intval($requestData['captain'])));
        $this->flightRepo->save($flight, true);

        $data =  [
            'id' => $flight->getId(),
            'number' => $flight->getNumber(),
        ];


        return $this->json([$data], 201);
}

    #[Route('/{id}/edit', name: 'api_flight_edit', methods:['post'])]
    public function edit(int $id, Request $request,ManagerRegistry $doctrine): Response
    {
        $requestData = $request->request->all();
        $myFlight = $this->flightRepo->find($id);
        $myFlight->setNumber(intval($requestData['number']));
        $myFlight->setFromAirport($requestData['from_airport']);
        $myFlight->setToAirport($requestData['to_airport']);
        $myFlight->setCaptain($doctrine->getRepository(Captain::class)->find(intval($requestData['captain'])));


        $this->flightRepo->save($myFlight, true);


        $data =  [
            'id' => $myFlight->getId(),
        ];


        return $this->json([$data], 201);


    }


    #[Route('/{id}', name: 'api_flight_delete', methods:['delete'])]
    public function delete(int $id): Response
    {
        $myFlight = $this->flightRepo->find($id);


        if (!$myFlight) {
            return $this->json('No flight found for id ' . $id, 404);
        }


        $this->flightRepo->remove($myFlight, true);
        
        return $this->json([
            'message' => "Deleted flight with id ". $id,
        ], 200);
    }
    
}

