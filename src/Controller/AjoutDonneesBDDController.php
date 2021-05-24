<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Formation;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class AjoutDonneesBDDController extends AbstractController
{
    /**
     * @Route("/employees", name="aff_employees")
     */
    public function listeEmployes()
    {
        $lesEmployees = $this->getDoctrine()->getRepository(Employe::class)->findAll();


        return $this->render('home/lesEmployees.html.twig', [
            'controller_name' => 'HomeController',
            'lesEmployees' => $lesEmployees
        ]);
    }

    /**
     * @Route("/ajoutProduits", name="ajout_produit")
     */
    public function ajoutProduit(SerializerInterface $serializer)
    {

        $leProduit = new Produit();
        $leProduit->setLibelle("PARACETAMOL");

        // $em = $this->getDoctrine()->getManager();
        // $em->persist($leProduit);
        // $em->flush();

        // return new Response('Saved new product : '.$leProduit->getId(). " ". $leProduit->getLibelle());
        // return $this->json($leProduit);

        $jsonContent = $serializer->serialize($leProduit, 'json');
        return new Response($jsonContent , 200);

    }

    /**
     * @Route("/ajoutEmploye", name="ajout_employe")
     */
    public function ajoutEmploye()
    {

        $employe = new Employe();
        $employe->setLogin("jane@gmail.com");
        $employe->setMdp("azert123");
        $employe->setNom("jane");
        $employe->setPrenom("danny");
        $employe->setStatut(0);

        $em = $this->getDoctrine()->getManager();
        $em->persist($employe);
        $em->flush();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/ajoutFormation", name="ajout_formation")
     */
    public function ajoutFormation()
    {
        $date = new \DateTime();
        $nbrHeures = 10;
        $departement = "ile de france";

        $leFormation = new Formation();
        $leFormation->setDateDebut($date);
        $leFormation->setNbreHeures($nbrHeures);
        $leFormation->setNbreHeures($departement);

        $leProduit = new Produit();
        $leProduit->setLibelle("doliprane");
        $leFormation->setProduit($leProduit);

        $em = $this->getDoctrine()->getManager();
        $em->persist($leFormation);
        $em->flush();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/ajoutInscription", name="ajout_inscription")
     */
    public function ajoutInscription()
    {
        $date = new \DateTime();
        $nbrHeures = 10;
        $departement = "ile de france";

        $leFormation = new Formation();
        $leFormation->setDateDebut($date);
        $leFormation->setNbreHeures($nbrHeures);
        $leFormation->setNbreHeures($departement);

        $leProduit = new Produit();
        $leProduit->setLibelle("doliprane");
        $leFormation->setProduit($leProduit);

        $em = $this->getDoctrine()->getManager();
        $em->persist($leFormation);
        $em->flush();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
