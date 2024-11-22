<?php

namespace App\Controller;

use App\Repository\SpatioportRepository;
use App\Repository\BestiaryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContrebandeAnimaliereController extends AbstractController
{
    #[Route('/contrebande/animaliere', name: 'app_contrebande_animaliere')]
    public function index(SpatioportRepository $spatioportRepository): Response
    {
        // Récupère tous les spatioports depuis la base de données
        $spatioports = $spatioportRepository->findAll();

        return $this->render('contrebande_animaliere/index.html.twig', [
            'spatioports' => $spatioports,
        ]);
    }

    #[Route('/contrebande/spatioport/{id}', name: 'spatioport_show')]
    public function show(int $id, SpatioportRepository $spatioportRepository): Response
    {
        // Récupère le spatioport par son ID
        $spatioport = $spatioportRepository->find($id);
    
        // Vérifie si le spatioport existe
        if (!$spatioport) {
            throw $this->createNotFoundException('Le spatioport demandé n\'existe pas.');
        }
    
        // Transmet le spatioport au template
        return $this->render('contrebande_animaliere/spatioport.html.twig', [
            'spatioport' => $spatioport,
        ]);
    }
    
    #[Route('/contrebande/animal/{id}', name: 'animal_show')]
    public function showAnimal(int $id, BestiaryRepository $bestiaryRepository): Response
    {
        // Récupère l'animal par son ID
        $animal = $bestiaryRepository->find($id);
    
        // Vérifie si l'animal existe
        if (!$animal) {
            throw $this->createNotFoundException('L\'animal demandé n\'existe pas.');
        }
    
        // Transmet l'animal au template
        return $this->render('contrebande_animaliere/animal.html.twig', [
            'animal' => $animal,
        ]);
    }    
    
}
?>