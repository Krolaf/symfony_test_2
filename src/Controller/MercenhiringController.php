<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MissionsRepository;
use App\Repository\TeamRepository;
use App\Repository\MercenherosRepository;

class MercenhiringController extends AbstractController
{
    #[Route('/missions', name: 'mission_list')]
    public function listMissions(MissionsRepository $missionsRepository): Response
    {
        $missions = $missionsRepository->findAll();

        return $this->render('mercenhiring/missions.html.twig', [
            'missions' => $missions,
        ]);
    }

    #[Route('/teams', name: 'team_list')]
    public function listTeams(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('mercenhiring/teams.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/mercenheros', name: 'mercenhero_list')]
    public function listMercenheros(MercenherosRepository $mercenherosRepository): Response
    {
        $mercenheros = $mercenherosRepository->findAll();

        return $this->render('mercenhiring/mercenheros.html.twig', [
            'mercenheros' => $mercenheros,
        ]);
    }

    #[Route('/mercenhiring', name: 'mercenhiring')]
    public function index(MissionsRepository $missionsRepository): Response
    {
        $ongoingMissions = $missionsRepository->findBy(['status' => 'IN_PROGRESS']);

        return $this->render('mercenhiring/index.html.twig', [
            'ongoingMissions' => $ongoingMissions,
        ]);
    }
}
?>