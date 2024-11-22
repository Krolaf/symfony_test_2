<?php
    namespace App\Controller;

    use App\Repository\ProduitRepository;
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\Routing\Annotation\Route;
    
    class CatalogueController extends AbstractController
    {
        #[Route('/catalogue', name: 'catalogue')]
        public function catalogue(ProduitRepository $produitRepository): Response
        {
            $produits = $produitRepository->findAll(); // Récupère tous les produits depuis la BDD
    
            return $this->render('catalogue/index.html.twig', [
                'produits' => $produits,
            ]);
        }
    }
    
?>