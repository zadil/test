<?php

namespace FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FormationBundle\Entity\Formation;
use FormationBundle\Form\SessionType;
use FormationBundle\Form\FormationType;
use FormationBundle\Entity\Session;
use Symfony\Component\HttpFoundation\Request;
use PersonneBundle\Entity\Personne;

class SessionController extends Controller
{
    /**
     * @Route("/session/lister/{id}" , name ="listerSession")
     */
    public function listerAction(Formation $formation, Request $request)
    {
        
        $listeSession = $this->getDoctrine()->getManager()->getRepository('FormationBundle:Session')->findAll();
        $personne = new Personne();
        $session = $request->getSession();
        if( $session->get('id') != null)
        {
        $personne = $this->getDoctrine()->getManager()->getRepository('PersonneBundle:Personne')->find($session->get('id'));
        }
        return $this->render('FormationBundle:Session:lister.html.twig', array("listeSession" => $listeSession, 'formation' => $formation, 'personne' => $personne,
            // ...
        ));
    }

    /**
     * @Route("/session/supprimer/{id}" , name="supprimerSession")
     */
    public function supprimerAction(Session $session)
    {
        
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($session);
        $em->flush();
        return $this->redirectToRoute('listerSession', array(
            // ...
        ));
    }

    /**
     * @Route("/session/inserer/{id}" , name="insererSession")
     */
    public function afficherAction(Formation $formation , Request $request)
    {
        $session = new Session();
        $form = $this->get('form.factory')->create(SessionType::class, $session);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $session->setFormation($formation);
            $em->persist($session);
            $em->flush();
            return $this->redirectToRoute('listerSession', array('id' => $formation->getId(),
            // ...
        ));

        }

        return $this->render('FormationBundle:Session:editer.html.twig', array('form' => $form->createView(),
            // ...
        ));;
    }

    /**
     * @Route("/editer/{id}" , name="editerSession")
     */
    public function editerAction(Session $session, Request $request)
    {
        $form = $this->get('form.factory')->create(SessionType::class, $session);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $session->setFormation($formation);
            $em->persist($session);
            $em->flush();
            return $this->redirectToRoute('listerSession', array(
            // ...
        ));

        }

        return $this->render('FormationBundle:Session:editer.html.twig', array('form' => $form->createView(), 'session' => $session,
            // ...
        ));;
    }
   
     /**
     * @Route("/candidater/{personneId}/{sessionId}" , name="candidaterSession")
     */
    public function candidaterAction( $personneId,  $sessionId)
    {
        
        $session = $this->getDoctrine()->getManager()->getRepository('FormationBundle:Session')->find($sessionId);
        $personne = $this->getDoctrine()->getManager()->getRepository('PersonneBundle:Personne')->find($personneId);
        $session->addPersonne($personne);
        $personne->addSession($session);
        $em=$this->getDoctrine()->getManager();
        $em->persist($session);
        $em->persist($personne);
        $em->flush();
            return $this->redirectToRoute('listerSession', array('id'=>$session->getFormation()->getId(), 
            // ...
        ));

        
    }
}
