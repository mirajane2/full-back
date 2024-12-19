<?php 

namespace App\Controller;


use App\Repository\PirateRepository;
use App\Entity\Pirate;
use App\Repository\EquipageRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class PirateController extends AbstractController {

    #[Route('/api/equipage/{id}', methods:['GET'])]
    public function index (EquipageRepository $equipageRepository, int $id) {

        $equipage = $equipageRepository -> find($id);

        $pirates = $equipage -> getPirate();
        $data = [];

        foreach($pirates as $pirate) {
            $data[] = [
                'id' => $pirate -> getId(),
                'name' => $pirate -> getName(),
                'description' => $pirate -> getDescription(),
                'image' => $pirate -> getImg(),
                'prime' => $pirate -> getPrime()
            ];
        }
        return $this->json($data);
    }

    #[Route('/api/pirate', methods:['POST'])]
    public function create (Request $request, EntityManagerInterface $em, EquipageRepository $equipageRepository): JsonResponse {

        $data = json_decode($request -> getContent(), true);
 
        if(!isset($data['name'], $data['prime'], $data['equipageId'])) {
            return new JsonResponse( ['message' => 'Donnée invalid']);
        }

        $association = $equipageRepository -> find($data['equipageId']);

        $pirate = new Pirate(); 
        $pirate -> setName($data['name'] );
        $pirate -> setDescription($data['description']);
        $pirate -> setImg($data['img']);
        $pirate -> setPrime($data['prime']);
        $pirate -> setAssociation($association);
        $em -> persist($pirate);
        $em -> flush();

        return new JsonResponse(['message' => 'Affiche created successfully'], 201);
    }

    #[Route('/api/equipahge/${crewId}/pirate/{id}', methods:['PUT'])]
    public function update(Request $request, EntityManagerInterface $em, int $id, PirateRepository $repository): JsonResponse {

        $data = json_decode($request -> getContent(), true);

        $pirate = $repository -> find($id);

        $pirate -> setName($data['name'] );
        $pirate -> setDescription($data['description']);
        $pirate -> setImg($data['img']);
        $pirate -> setPrime($data['prime']);
        $em -> persist($pirate);
        $em -> flush();


        return new JsonResponse(['message' => 'Affiche modifié avec succès']);
    }

    #[Route('/api/pirate/{id}', methods:['DELETE'])]
    public function delete(EntityManagerInterface $em, PirateRepository $repository, int $id): JsonResponse {


        $pirate = $repository -> find($id);
        $em -> remove($pirate);
        $em -> flush();

        return new JsonResponse(['message' => 'Affiche supprimé avec succès']);
    }

    #[Route('/api/equipage/{crewId}/pirate/{id}', methods:['GET'])]
    public function pirate (PirateRepository $pirateR, int $id,  ) {
        $pirate = $pirateR -> find($id);
        if (!$pirate) {
            return $this->json(['message' => 'Pirate non trouvé']);
        }  
        
        $data = [
            'id' => $pirate->getId(),
            'name' => $pirate->getName(),
            'description' => $pirate->getDescription(),
            'image' => $pirate->getImg(),
            'prime' => $pirate->getPrime(),
        ];
    
        return $this->json($data);
    
    }


}