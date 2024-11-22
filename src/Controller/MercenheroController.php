<?php

namespace App\Controller;

use App\Entity\Mercenheros;
use App\Form\MercenheroType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MercenheroController extends AbstractController
{

    #[Route('/liste_mercenheros', name: 'mercenhero_list')]
    public function list(EntityManagerInterface $entityManager): Response
    {
        $mercenheros = $entityManager->getRepository(Mercenheros::class)->findAll();

        return $this->render('mercenhero/list.html.twig', [
            'mercenheros' => $mercenheros,
        ]);
    }

    #[Route('/mercenheros/create', name: 'mercenhero_create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $mercenhero = new Mercenheros();
        $form = $this->createForm(MercenheroType::class, $mercenhero);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($mercenhero);
            $entityManager->flush();

            $this->addFlash('success', 'Mercenhero created successfully!');

            return $this->redirectToRoute('mercenhero_list');
        }

        return $this->render('mercenhero/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mercenheros/edit/{id}', name: 'mercenhero_edit')]
    public function edit(Request $request, Mercenheros $mercenhero, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MercenheroType::class, $mercenhero);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Mercenhero updated successfully!');

            return $this->redirectToRoute('mercenhero_list');
        }

        return $this->render('mercenhero/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/mercenheros/delete/{id}', name: 'mercenhero_delete')]
    public function delete(Mercenheros $mercenhero, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($mercenhero);
        $entityManager->flush();

        $this->addFlash('success', 'Mercenhero deleted successfully!');

        return $this->redirectToRoute('mercenhero_list');
    }
}
?>