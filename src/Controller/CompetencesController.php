<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Form\CompetencesType;
use App\Repository\CompetencesRepository;
use App\Repository\MercenherosRepository;
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

    #[Route('/new', name: 'competences_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, MercenherosRepository $mercenherosRepository): Response
    {
        $competence = new Competences();
        $form = $this->createForm(CompetencesType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($competence);
            $entityManager->flush();

            $this->addFlash('success', 'Compétence ajoutée avec succès !');
            return $this->redirectToRoute('competences_index');
        }

        return $this->render('competences/new.html.twig', [
            'competence' => $competence,
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

    #[Route('/{id}/edit', name: 'competences_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Competences $competence, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CompetencesType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Compétence modifiée avec succès !');
            return $this->redirectToRoute('competences_index');
        }

        return $this->render('competences/edit.html.twig', [
            'competence' => $competence,
            'form' => $form->createView(),
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
