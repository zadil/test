<?php

namespace FormationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use FormationBundle\Entity\Formation;
use FormationBundle\Form\FormationType;
use Symfony\Component\HttpFoundation\Request;
use FormationBundle\Entity\Session;

class FormationController extends Controller
{
    /**
     * @Route("/formation/lister" , name="listerFormation")
     */
    public function listerAction()
    {
      $listeFormation = $this->getDoctrine()->getManager()->getRepository('FormationBundle:Formation')->compterNombreSession();
        return $this->render('FormationBundle:Formation:lister.html.twig', array('listeFormation'=> $listeFormation,
        ));
    }

    /**
     * @Route("/formation/supprimer/{id}" ,name="supprimerFormation")
     */
    public function supprimerAction(Formation $formation)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($formation);
        $em->flush();

        return $this->reditrectToRoute('listerFormation', array(
            // ...
        ));
    }

    /**
     * @Route("/formation/inserer" , name="insererFormation")
     */
    public function afficherAction(Request $request)
    {
       $formation = new Formation();
        $form = $this->get('form.factory')->create(FormationType::class, $formation);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('listerFormation', array(
            // ...
        ));

        }

        return $this->render('FormationBundle:Formation:editer.html.twig', array('form' => $form->createView(),
            // ...
        ));
    }

    /**
     * @Route("/formation/editer{id}" , name="editerFormation" )
     */
    public function editerAction(Request $request, Formation $formation)
    {
        $form = $this->get('form.factory')->create(FormationType::class, $formation);
        $form->handleRequest($request);
        if($form->isValid()){
            $em=$this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('listerFormation', array(
            // ...
        ));

        }

        return $this->render('FormationBundle:Formation:editer.html.twig', array('form' => $form->createView(),
            // ...
        ));
    }

}
