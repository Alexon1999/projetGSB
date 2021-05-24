<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Produit;
use App\Repository\EmployeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/test" , name="test_api") , methods={"POST"}
     */
    public function test_api(Request $request, SerializerInterface $serializer,  EntityManagerInterface $em)
    {
        $jsonrecu = $request->getContent();
        
        $data = json_decode($jsonrecu); # json_decode return  object
        // json_encode -> return Json string
        dd( gettype($data) , $data , $data->name, $data->categeories , gettype($data->categeories));
    }
    
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

    /**
     * @Route("/api/createNewEmploye" , name="create_employe") , methods={"POST"}
     */
    public function createNewEmploye(Request $request, SerializerInterface $serializer,  EntityManagerInterface $em)
    {
        $jsonrecu = $request->getContent();
        // $employe = $serializer->deserialize($jsonrecu, Employe::class, 'json');

        // $em->persist($employe);
        // $em->flush();

        // return $this->json($employe, 200);
        $data = json_decode($jsonrecu); # json_decode return 
        dd( gettype($data) , $data , $data->name, $data->categeories , gettype($data->categeories));
    }

}
