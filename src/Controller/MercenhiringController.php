<?php
namespace App\Controller;

use App\Entity\Team;
use App\Entity\Missions;
use App\Form\TeamType;
use App\Form\MissionsType;
use App\Form\ValidTeamType;
use App\Repository\MissionsRepository;
use App\Repository\TeamRepository;
use App\Repository\MercenherosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MercenhiringController extends AbstractController
{
    #[Route('/teams', name: 'team_list')]
    public function listTeams(TeamRepository $teamRepository): Response
    {
        $teams = $teamRepository->findAll();

        return $this->render('mercenhiring/teams.html.twig', [
            'teams' => $teams,
        ]);
    }

    #[Route('/team/new', name: 'team_new')]
    public function newTeam(Request $request, EntityManagerInterface $entityManager): Response
    {
        $team = new Team();
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validation des membres
            if ($team->getMembers()->count() < 2 || $team->getMembers()->count() > 5) {
                $this->addFlash('error', 'Une équipe doit avoir entre 2 et 5 membres.');
                return $this->redirectToRoute('team_new');
            }

            // Validation du leader
            if ($team->getLeader()->getMunitions() <= 80) {
                $this->addFlash('error', 'Le leader doit avoir plus de 80 munitions.');
                return $this->redirectToRoute('team_new');
            }

            $entityManager->persist($team);
            $entityManager->flush();

            $this->addFlash('success', 'Équipe créée avec succès !');
            return $this->redirectToRoute('team_list');
        }

        return $this->render('mercenhiring/team_new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/team/{id}/edit', name: 'team_edit')]
    public function editTeam(Team $team, Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TeamType::class, $team);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Validation des membres
            if ($team->getMembers()->count() < 2 || $team->getMembers()->count() > 5) {
                $this->addFlash('error', 'Une équipe doit avoir entre 2 et 5 membres.');
                return $this->redirectToRoute('team_edit', ['id' => $team->getId()]);
            }

            // Validation du leader
            if ($team->getLeader()->getMunitions() <= 80) {
                $this->addFlash('error', 'Le leader doit avoir plus de 80 munitions.');
                return $this->redirectToRoute('team_edit', ['id' => $team->getId()]);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Équipe mise à jour avec succès !');
            return $this->redirectToRoute('team_list');
        }

        return $this->render('mercenhiring/team_edit.html.twig', [
            'form' => $form->createView(),
            'team' => $team,
        ]);
    }

    #[Route('/missions', name: 'mission_list')]
    public function listMissions(MissionsRepository $missionsRepository): Response
    {
        $missions = $missionsRepository->findAll();

        return $this->render('mercenhiring/missions.html.twig', [
            'missions' => $missions,
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


    public function newMission(Request $request, EntityManagerInterface $em): Response
    {
        $mission = new Missions();
        $form = $this->createForm(MissionsType::class, $mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($mission);
            $em->flush();

            return $this->redirectToRoute('mission_list');
        }

        return $this->render('mercenhiring/missions.html.twig', [
            'form' => $form->createView(),
        ]);
    }

        #[Route('/missions/{id}/assign-team', name: 'mission_assign_team', methods: ['GET', 'POST'])]
        public function assignTeam(int $id, EntityManagerInterface $em, Request $request): Response
        {

        $mission = $em->getRepository(Missions::class)->find($id);

        if (!$mission) {
            throw $this->createNotFoundException("Mission non trouvée.");
        }

        // Récupérer les équipes valides
        $requiredCompetences = $mission->getRequiredCompetences();
        $teams = $em->getRepository(Team::class)->findAll();

        $validTeams = [];
        foreach ($teams as $team) {
            foreach ($team->getMembers() as $member) {
                if ($member->getCompetences()->exists(fn($key, $competence) => $requiredCompetences->contains($competence))) {
                    $validTeams[] = $team;
                    break;
                }
            }
        }

        // Utilisation de ValidTeamType
        $form = $this->createForm(ValidTeamType::class, null, [
            'data_class' => null, // Pas besoin de lier directement à l'entité Team
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedTeam = $form->get('team')->getData(); // Récupère l'équipe sélectionnée
            $mission->setAssignedTeam($selectedTeam); // Assigne l'équipe à la mission
            $em->flush();

            $this->addFlash('success', 'Équipe assignée avec succès.');
            return $this->redirectToRoute('mission_list');
        }

        return $this->render('mercenhiring/assign_team.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }

    public function validateTeamCompetences(Team $team, Missions $mission): bool
    {
        foreach ($mission->getRequiredCompetences() as $competence) {
            $found = false;
            foreach ($team->getMembers() as $member) {
                if ($member->getCompetences()->contains($competence)) {
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                return false;
            }
        }
        return true;
    }
    
}

?>

