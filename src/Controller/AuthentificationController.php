<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Employe;
use App\Form\LoginType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\EmployeRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AuthentificationController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function authentification(Request $request, SessionInterface $session, EmployeRepository $er)
    {
        $employe = new Employe();

        $form = $this->createForm(LoginType::class, $employe);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tous_les_employes = $this->getDoctrine()->getRepository(Employe::class)->findAll();

            // var_dump($tous_les_employes);

            $estTrouve = false;
            foreach ($tous_les_employes as  $user) {
                if ($user->getMdp() == $employe->getMdp() && $user->getLogin() == $employe->getLogin()) {
                    $estTrouve = true;
                }
                // + dd($user); //// comme var_dump
                // dd : dump and die
                // die arrete tout
                // var_dump() and die();
            }


            if (!!$estTrouve) {
                // $product = $repository->findOneBy([
                //     'name' => 'Keyboard',
                //     'price' => 1999,
                // ]); //// findOneBy

                // $user_connecte = $er->findByLogin($employe->getLogin());
                $user_connecte = $this->getDoctrine()->getRepository(Employe::class)->findByLogin($employe->getLogin());

                // + recupere la session avec request ou SessionInterface
                // $session = $request->getSession();

                $session->set('estAuthentifie', true);
                $session->set('user_id', $user_connecte->getId());
                echo $session->get('estAuthentifie');

                // return $this->redirectToRoute('home', array('id' => $user_connecte->getId()));
                return $this->redirectToRoute('index');
            }
        }

        return $this->render('log_in/index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/logout" , name="logout")
     */
    public function logout(Request $request)
    {
        $session = $request->getSession();

        $session->set('estAuthentifie', false);
        $session->set('user_id', null);

        return $this->redirectToRoute('login');
    }
}
