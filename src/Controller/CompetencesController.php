<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetencesType;

use App\Repository\CompetencesRepository;
use App\Repository\MercenherosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/competences')]
class CompetencesController extends AbstractController
{
    #[Route('/', name: 'competences_index', methods: ['GET'])]
    public function index(CompetencesRepository $competencesRepository): Response
    {
        return $this->render('competences/index.html.twig', [
            'competences' => $competencesRepository->findAll(),
        ]);
    }

    #[Route('/competences/new', name: 'competences_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $competence = new Competences();
        $form = $this->createForm(CompetencesType::class, $competence);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Synchroniser les relations inverses
            foreach ($competence->getMercenheros() as $mercenhero) {
                $mercenhero->addCompetence($competence);
            }
    
            $entityManager->persist($competence);
            $entityManager->flush();
    
            $this->addFlash('success', 'Compétence créée avec succès !');
    
            return $this->redirectToRoute('competences_index');
        }
    
        return $this->render('competences/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'competences_show', methods: ['GET'])]
    public function show(Competences $competence): Response
    {
        return $this->render('competences/show.html.twig', [
            'competence' => $competence,
        ]);
    }

    #[Route('/competences/{id}/edit', name: 'competences_edit', methods: ['GET', 'POST'])]
public function edit(Request $request, Competences $competence, EntityManagerInterface $entityManager): Response
{
    $form = $this->createForm(CompetencesType::class, $competence);
    $form->handleRequest($request);

    // Étape 1 : Dump des héros associés avant la soumission
    dump('Avant soumission', $competence->getMercenheros()->toArray());

    if ($form->isSubmitted() && $form->isValid()) {
        // Étape 2 : Dump des héros après la soumission
        dump('Après soumission', $competence->getMercenheros()->toArray());

        // Récupérer les héros associés avant la soumission
        $existingMercenheros = new ArrayCollection($competence->getMercenheros()->toArray());

        // Synchroniser les relations inverses
        foreach ($existingMercenheros as $mercenhero) {
            if (!$competence->getMercenheros()->contains($mercenhero)) {
                // Si le héros a été désélectionné, on enlève l'association
                $mercenhero->removeCompetence($competence);
                $competence->removeMercenhero($mercenhero);
            }
        }

        // Ajouter les relations sélectionnées
        foreach ($competence->getMercenheros() as $mercenhero) {
            $mercenhero->addCompetence($competence);
        }

        $entityManager->persist($competence);
        $entityManager->flush();

        $this->addFlash('success', 'Compétence modifiée avec succès !');

        return $this->redirectToRoute('competences_index');
    }

    return $this->render('competences/edit.html.twig', [
        'form' => $form->createView(),
        'competence' => $competence,
    ]);
}


    #[Route('/{id}', name: 'competences_delete', methods: ['POST'])]
    public function delete(Request $request, Competences $competence, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $competence->getId(), $request->request->get('_token'))) {
            $entityManager->remove($competence);
            $entityManager->flush();
            $this->addFlash('success', 'Compétence supprimée avec succès !');
        }

        return $this->redirectToRoute('competences_index');
    }

        #[Route('/filter', name: 'competences_filter', methods: ['GET'])]
    public function filter(Request $request, CompetencesRepository $competencesRepository): Response
    {
        $level = $request->query->get('level');
        $heroId = $request->query->get('hero_id');

        $competences = $competencesRepository->findByFilters($level, $heroId);

        return $this->render('competences/index.html.twig', [
            'competences' => $competences,
        ]);
    }

}
