<?php

namespace App\Controller;

use App\Entity\Employe;
use App\Entity\Formation;
use App\Entity\Inscription;
use App\Entity\Produit;
use App\Form\FormationType;
use App\Form\InscriptionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class FormationController extends AbstractController
{
    /**
     * @Route("/formFormation/{id_employe}", name="aff_formFormation")
     */
    public function createFormation(Request $request, SessionInterface $session, $id_employe)
    {
        $session_user_id = $session->get('user_id');

        if ($id_employe == $session_user_id) {
            $formation = new Formation();
            $date = new \DateTime();
            $formation->setDateDebut($date);

            $form = $this->createForm(FormationType::class, $formation);

            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {
                // return $this->redirectToRoute('aff_employees')
                $em = $this->getDoctrine()->getManager();
                $em->persist($formation);
                $em->flush();
                return $this->redirectToRoute('index');
            }
            return $this->render('home/createForm.html.twig', array(
                'form' => $form->createView(),
                "action" => "Créer une formation"
            ));
        } else {
            return $this->redirectToRoute('index');
        }
    }

    /**
     * @Route("/formulaire/{employe_id}/{produit_id}", name="aff_formFormationProduit")
     */
    public function createFormationByProduct(Request $request, SessionInterface $session, $employe_id, $produit_id)
    {
        $session_user_id = $session->get('user_id');

        if ($employe_id == $session_user_id) {

            $employe = $this->getDoctrine()->getRepository(Employe::class)->find($employe_id);
            $produit = $this->getDoctrine()->getRepository(Produit::class)->find($produit_id);

            $date = new \DateTime();

            $formation = new Formation();
            $formation->setProduit($produit);
            $formation->setDateDebut($date);

            $form = $this->createForm(FormationType::class, $formation);

            $form->handleRequest($request);


            if ($form->isSubmitted() && $form->isValid()) {
                // return $this->redirectToRoute('aff_employees')
                $em = $this->getDoctrine()->getManager();
                $em->persist($formation);
                $em->flush();
                return $this->redirectToRoute('index');
            }

            return $this->render('home/createForm.html.twig', array('form' => $form->createView(), "action" => "Créer une formation"));
        } else {
            return $this->redirectToRoute('index');
        }
    }



    /**
     * @Route("/modifier/{id}" , name="modifier_formation")
     */
    public function modifierFormation(Request $request, $id)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // return $this->redirectToRoute('aff_employees')
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('index');
        }

        return $this->render('home/createForm.html.twig', array('form' => $form->createView(), "action" => "Modifier la formation"));
    }
    /**
     * @Route("/supprimer/{id}" , name="supprimer_formation")
     */
    public function supprimerFormation(Request $request, $id)
    {
        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($formation);
        $em->flush();
        return $this->redirectToRoute('index');
    }


    /**
     * @Route("/inscription/{id_formation}/{id_employe}" ,name="inscription")
     */
    public function inscrireFormation(SessionInterface $session, $id_formation, $id_employe)
    {
        $employe = $this->getDoctrine()->getRepository(Employe::class)->find($id_employe);
        // $employe = $session->get('user');

        // $estVisiteur = $employe->getStatut() == 0;

        $formation = $this->getDoctrine()->getRepository(Formation::class)->find($id_formation);

        $unInscription = new Inscription();
        $unInscription->setEmploye($employe);
        $unInscription->setFormation($formation);
        $unInscription->setStatut('E');

        $em = $this->getDoctrine()->getManager();
        $em->persist($unInscription);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
