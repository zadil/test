<?php

namespace PersonneBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use PersonneBundle\Entity\Personne;
use PersonneBundle\Entity\Memo;
use Symfony\Component\HttpFoundation\Request;
use PersonneBundle\Form\MemoType;
use PersonneBundle\Form\RechercheType;


class MemoController extends Controller
{
   
     /**
     * @Route("/memo/{id}" , name="insererMemo")
     */
    public function MemoAction(Personne $personne , Request $request)
    {
        
        $memo = new Memo();
        $form = $this->get('form.factory')->create(MemoType::class , $memo);
        $form->handleRequest($request);
        if($form->isValid()){
            $memo->setDateCreation(new \datetime());
            $memo->setPersonne($personne);
            $em= $this->getDoctrine()->getManager();
            $em->persist($memo);
            $em->flush();
            return $this->redirectToRoute('showPersonne', array('id' => $personne->getId(),
            // ...
        ));

        }
       
        return $this->render('PersonneBundle:Memo:inserer_memo.html.twig', array('form' => $form->createView(), 'personne' => $personne,
            // ...
        ));
    }



    /**
     * @Route("/editer/Memo/{id}" , name="editerMemo" )
     */
    public function editerMemoAction(Memo $memo , Request $request)
    {
        $form = $this->get('form.factory')->create(MemoType::class , $memo);
        $form->handleRequest($request);
        if($form->isValid()){
            $em= $this->getDoctrine()->getManager();
            $em->persist($memo);
            $em->flush();
            return $this->redirectToRoute('listeMemos', array(
            // ...
        ));

        }

        $personne = $memo->getPersonne();
        return $this->render('PersonneBundle:Memo:inserer_memo.html.twig', array('form' => $form->createView(), 'personne' => $personne,
            // ...
        ));
    }

    /**
     * @Route("/SupprimerMemo/{id}" , name="supprimerMemo")
     */
    public function SupprimerMemoAction(Memo $memo)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($memo);
        $em->flush();

        return $this->redirectToRoute('listeMemos', array(
            // ...
        ));
    }

    /**
     * @Route("/memos/lister/{page}" , name="listeMemos", defaults={"page" : "0"})
     */
    public function RechercheAction(Request $request, $page)
    {
        $recherche = array('recherche' => '',);
      $form = $this->get('form.factory')->create(RechercheType::class, $recherche);
      $form->handleRequest($request);
        if($form->isValid()){
            $recherche = $form->getData();
            $listeMemo=$this->getDoctrine()->getManager()->getRepository('PersonneBundle:Memo')->findByContenu(array('recherche' => $recherche['recherche'], ));
            return $this->render('PersonneBundle:Memo:liste_memo.html.twig', array('listeMemos' => $listeMemo 
            , 'form' => $form->createView(),
            // ...
        ));

            }
        $paginationMemo = $this->getDoctrine()->getManager()->getRepository('PersonneBundle:Memo')->paginationMemos($page*5);
        $listeMemo = $this->getDoctrine()->getManager()->getRepository('PersonneBundle:Memo')->findAll();
        return $this->render('PersonneBundle:Memo:liste_memo.html.twig', array('form' => $form->createView(),"listeMemos" => $listeMemo, 'paginationMemos' => $paginationMemo,
            // ...
        ));  
    }

}
