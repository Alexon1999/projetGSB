<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/rechercheProduits/{produit}" , name="recherche_produits", methods={"GET"})
     * @param $produit
     * @param Request $request
     */
    public function rechercheProduits($produit, ProduitRepository $pr)
    {
        // $lesProduits =  $this->getDoctrine()->getRepository(Produit::class)->findProduitsByNom($produit);
        $lesProduits =  $pr->findProduitsByNom($produit);
        // dd($produit);
        // dd($lesProduits);

        // $lesProduits = $this->getDoctrine()->getRepository(Produit::class)->findOneBy(["libelle" => $produit]);

        return $this->json($lesProduits, 200);
    }
}
