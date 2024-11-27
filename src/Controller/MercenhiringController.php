<?php
namespace App\Controller;

use App\Entity\Team;
use App\Entity\Missions;
use App\Form\TeamType;
use App\Form\MissionsType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
    public function index(MissionsRepository $missionsRepository, EntityManagerInterface $em): Response
    {
        // Mettre à jour les statuts avant de récupérer les données
        $this->updateMissionStatuses($em);
    
        $ongoingMissions = $missionsRepository->findBy(['status' => ['IN_PROGRESS']]);
        $completedMissions = $missionsRepository->findBy(['status' => 'COMPLETED']);
    
        return $this->render('mercenhiring/index.html.twig', [
            'ongoingMissions' => $ongoingMissions,
            'completedMissions' => $completedMissions,
        ]);
    }
    

    private function updateMissionStatuses(EntityManagerInterface $em): void
    {
        $missions = $em->getRepository(Missions::class)->findBy(['status' => 'IN_PROGRESS']);

        $now = new \DateTimeImmutable();
        foreach ($missions as $mission) {
            if ($mission->getEndAt() && $mission->getEndAt() <= $now) {
                $mission->setStatus('COMPLETED');
            }
        }

        $em->flush(); // Appliquer les changements à la base de données
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
            if ($this->validateTeamCompetences($team, $mission)) {
                $validTeams[] = $team;
            }
        }
    
        // Création du formulaire avec les équipes valides
        $form = $this->createFormBuilder()
            ->add('team', EntityType::class, [
                'class' => Team::class,
                'choices' => $validTeams, // Seules les équipes valides
                'choice_label' => 'name',
                'placeholder' => 'Choisissez une équipe',
                'label' => 'Équipe disponible',
            ])
            ->getForm();
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $selectedTeam = $form->get('team')->getData(); // Récupère l'équipe sélectionnée
            $mission->addAssignedTeam($selectedTeam); // Assigne l'équipe à la mission
            $em->flush();
    
            $this->addFlash('success', 'Équipe assignée avec succès.');
            return $this->redirectToRoute('mission_list');
        }
    
        return $this->render('mercenhiring/assign_team.html.twig', [
            'mission' => $mission,
            'form' => $form->createView(),
        ]);
    }
    
    
    #[Route('/missions/{missionId}/remove-team/{teamId}', name: 'remove_team_from_mission', methods: ['POST'])]
    public function removeTeamFromMission(int $missionId, int $teamId, EntityManagerInterface $entityManager): Response
    {
        $mission = $entityManager->getRepository(Missions::class)->find($missionId);
        $team = $entityManager->getRepository(Team::class)->find($teamId);
    
        if (!$mission || !$team) {
            $this->addFlash('error', 'Mission ou équipe introuvable.');
            return $this->redirectToRoute('mission_list');
        }
    
        $mission->removeAssignedTeam($team);
        $entityManager->flush();
    
        $this->addFlash('success', 'Équipe retirée avec succès de la mission.');
        return $this->redirectToRoute('mission_list');
    }

    #[Route('/missions/{id}/start', name: 'mission_start', methods: ['GET'])]
public function startMission(int $id, EntityManagerInterface $em): Response
{
    $mission = $em->getRepository(Missions::class)->find($id);

    if (!$mission) {
        $this->addFlash('error', 'Mission non trouvée.');
        return $this->redirectToRoute('mission_list');
    }

    if ($mission->getAssignedTeams()->isEmpty()) {
        $this->addFlash('error', 'Aucune équipe assignée à cette mission.');
        return $this->redirectToRoute('mission_list');
    }

    if ($mission->getStatus() === 'IN_PROGRESS') {
        $this->addFlash('error', 'La mission est déjà en cours.');
        return $this->redirectToRoute('mission_list');
    }

    if ($mission->getCompletionTime() === null) {
        $this->addFlash('error', 'Temps d\'accomplissement non défini pour cette mission.');
        return $this->redirectToRoute('mission_list');
    }

    // Définir la date de début et de fin uniquement lors du démarrage
    $now = new \DateTimeImmutable();
    $mission->setStartAt($now);
    $mission->setEndAt($now->modify('+' . $mission->getCompletionTime() . ' minutes'));

    // Mettre à jour le statut de la mission
    $mission->setStatus('IN_PROGRESS');

    $em->flush();

    $this->addFlash('success', 'La mission a commencé avec succès !');
    return $this->redirectToRoute('mission_list');
}

    
    
    public function validateTeamCompetences(Team $team, Missions $mission): bool
    {
        $requiredCompetences = $mission->getRequiredCompetences();
    
        // Vérifie les compétences du leader
        $leader = $team->getLeader();
        foreach ($requiredCompetences as $competence) {
            if (!$leader->getCompetences()->contains($competence)) {
                return false; // Si le leader n'a pas une compétence requise
            }
        }
    
        // Vérifie les compétences des membres
        foreach ($requiredCompetences as $competence) {
            $found = false;
            foreach ($team->getMembers() as $member) {
                if ($member->getCompetences()->contains($competence)) {
                    $found = true; // Au moins un membre a la compétence
                    break;
                }
            }
            if (!$found) {
                return false; // Si aucun membre n'a une compétence requise
            }
        }
    
        return true;
    }
    
}

?>

