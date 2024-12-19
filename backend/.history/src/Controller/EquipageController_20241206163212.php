<?php 

namespace App\Controller;

use App\Entity\Equipage;
use App\Repository\EquipageRepository;
use App\Repository\PirateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EquipageController extends AbstractController {

    #[Route('/api/equipage', methods:['GET'])]
    public function AllEquipage( EquipageRepository $equipageRepository) {

        $equipages = $equipageRepository -> findAll();
        $data = [];

        foreach($equipages as $equipage) {
            $data[] = [
                'id' => $equipage -> getId(),
                'name' => $equipage -> getTitle(),
            ];
        }
        return $this->json($data);
    }
    #[Route('/api/equipage/create', methods:['POST'])]
    public function CreateEquipage (Request $request, EntityManagerInterface $em): JsonResponse {

        $data = json_decode($request -> getContent(), true);

        if(!isset($data['title'])) {
            return new JsonResponse( ['message' => 'Donnée invalid']);
        }

        $pirate = new Equipage(); 
        $pirate -> setTitle($data['title'] );
        $em -> persist($pirate);
        $em -> flush();

        return new JsonResponse(['message' => 'Equipage created successfully'], 201);
    }
    
    #[Route('/api/equipage/{id}', methods:['DELETE'])]
    public function DeleteEquipage(EquipageRepository $equipageRepository, EntityManagerInterface $em, int $id) {
        
        $equipage = $equipageRepository -> find($id);
        $em -> remove($equipage);
        $em -> flush();

        return new JsonResponse(['message' => 'Equipage supprimé avec succès']);
    }
}


