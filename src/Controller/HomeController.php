<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Formation;
use App\Entity\Inscription;
use App\Entity\Produit;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

function verifierConnexion($id1, $id2)
{
    if ($id1 == $id2) {
        return true;
    }
    return false;
}

class HomeController extends AbstractController
{
    /**
     * @Route("/" , name="index")
     */
    public function redirection(Request $request, SessionInterface $session)
    {
        // $session = $request->getSession();

        // session->get() ->//? retourne null s'il trouve pas
        $estAuthentifie = $session->get('estAuthentifie');
        $user_id = $session->get('user_id');

        // if ($session->get('estAuthentifie')) {
        if ($estAuthentifie && $user_id) {
            // + envois du json , array php = js object
            // return $this->json(["estAuthentifie" => $session->get('estAuthentifie'), "user_id" => $session->get('user_id')], 200);

            return $this->redirectToRoute('user', array('id' => $user_id));
        }

        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/user/{id}", name="user")
     */
    public function index($id, SessionInterface $session)
    {
        $user_id = $session->get('user_id');
        if (!verifierConnexion($user_id, $id)) {

            $session->set('estAuthentifie', false);
            $session->set('user_id', null);
            return $this->redirectToRoute('login');
        }

        $employe = $this->getDoctrine()->getRepository(Employe::class)->find($id);


        $lesFormations = $this->getDoctrine()->getRepository(Formation::class)->findAll();

        $lesInscriptions = $this->getDoctrine()->getRepository(Inscription::class)->findAll();

        $lesProduits = $this->getDoctrine()->getRepository(Produit::class)->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'lesProduits' => $lesProduits,
            'lesFormations' => $lesFormations,
            'lesInscriptions' => $lesInscriptions,
            'id_employe' => $employe->getId(),
            'nom_employe' => $employe->getNom(),
            'estAuServiceFormation' => $employe->getStatut() == 1,
        ]);

        // switch ($employe->getStatut()) {
        //     case 0:
        //         return $this->render('home/visiteur.html.twig', [
        //             'controller_name' => 'HomeController',
        //             'lesProduits' => $produits,
        //             'id_employe' => $employe->getId(),
        //             'nom_employe' => $employe->getNom(),
        //         ]);
        //     case 1:
        //         return $this->render('home/index.html.twig', [
        //             'controller_name' => 'HomeController',
        //             'lesProduits' => $produits,
        //             'id_employe' => $employe->getId(),
        //             'nom_employe' => $employe->getNom(),
        //         ]);
        // }
    }
}
