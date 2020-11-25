<?php

namespace App\Controller;

use App\Entity\Inscription;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscriptionValide/{id}" , name="inscription_valide")
     */
    public function validerInscription($id)
    {
        $inscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id);

        $inscription->setStatut("V");

        $em = $this->getDoctrine()->getManager();
        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('index');
    }
    /**
     * @Route("/inscriptionRefuse/{id}" , name="inscription_refuse")
     */
    public function refuserInscription($id)
    {
        $inscription = $this->getDoctrine()->getRepository(Inscription::class)->find($id);

        $inscription->setStatut("R");

        $em = $this->getDoctrine()->getManager();
        $em->persist($inscription);
        $em->flush();

        return $this->redirectToRoute('index');
    }
}
